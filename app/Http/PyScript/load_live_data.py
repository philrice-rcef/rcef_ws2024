import os
import sys
import polars as pl
from urllib.parse import quote

uri ="mysql://root:%s@192.168.10.44:3306/" % quote('Zeijan@13')

# Set the province
province = "AKLAN"

# Read tables from the database
lib_dropoff_point = pl.read_database_uri(query=f"SELECT DISTINCT prv as t1_prv, coop_accreditation as t1_coop_accreditation , CONCAT(province,'_',municipality) AS ldp_prov_muni_data, CONCAT(region,'_',province,'_',municipality) AS ldp_con_data, province as t1_province FROM ws2024_rcep_delivery_inspection.lib_dropoff_point WHERE province='{province}'", uri=uri)
tbl_delivery = pl.read_database_uri(query=f"SELECT coopAccreditation as t2_coopAccreditation, CONCAT(region,'_',province,'_',municipality) AS del_con_data, CONCAT(batchTicketNumber,'_',region,'_',province,'_',municipality) AS del_con_data_batches, isBuffer as t2_isBuffer, municipality as t2_municipality, totalBagCount as t2_totalBagCount FROM ws2024_rcep_delivery_inspection.tbl_delivery WHERE province='{province}'", uri=uri)
tbl_actual_delivery = pl.read_database_uri(query=f"SELECT batchTicketNumber as t3_batchTicketNumber, municipality as t3_municipality, CONCAT(region,'_',province,'_',municipality) AS act_del_con_data, isBuffer as t3_isBuffer,isRejected as t3_isRejected, transferCategory as t3_transferCategory, remarks as t3_remarks, totalBagCount as t3_totalBagCount FROM ws2024_rcep_delivery_inspection.tbl_actual_delivery WHERE province='{province}'", uri=uri)
tbl_paymaya_claim = pl.read_database_uri(query=f"SELECT CONCAT(region,'_',province,'_',municipality) AS paymaya_claim_con_data, municipality as t4_municipality, paymaya_code as t4_paymaya_code FROM ws2024_rcep_paymaya.tbl_claim WHERE province='{province}'", uri=uri)
new_released = pl.read_database_uri(query=f"SELECT CONCAT(province,'_',municipality) AS new_released_con_data, rcef_id as t5_rcef_id, municipality as t5_municipality, bags_claimed as t5_bags_claimed, claimed_area as t5_claimed_area, category as t5_category, prv_dropoff_id as t5_prv_dropoff_id, new_released_id as t5_new_released_id FROM ws2024_prv_0604.new_released WHERE category='INBRED' and prv_dropoff_id like '0604%'", uri=uri)
tbl_beneficiaries = pl.read_database_uri(query=f"SELECT DISTINCT paymaya_code as t6_paymaya_code, sex as t6_sex, area as t6_area, municipality as t6_municipality, CONCAT(region,'_',province,'_',municipality) AS tbl_beneficiaries_con_data FROM ws2024_rcep_paymaya.tbl_beneficiaries WHERE province='{province}'", uri=uri)
farmer_information_final = pl.read_database_uri(query=f"SELECT T0.municipality as t7_municipality, COUNT(CASE WHEN UPPER(SUBSTR(T0.sex, 1, 1)) = 'M' THEN 1 END) AS total_male,COUNT(CASE WHEN UPPER(SUBSTR(T0.sex, 1, 1)) = 'F' THEN 1 END) AS total_female,SUM(T0.final_area) AS total_final_area FROM ws2024_prv_0604.farmer_information_final T0 JOIN (SELECT DISTINCT rcef_id FROM ws2024_prv_0604.new_released WHERE category = 'inbred' AND prv_dropoff_id LIKE '0604%') T1 ON T0.rcef_id = T1.rcef_id GROUP BY T0.municipality", uri=uri)
municipal_yield = pl.read_database_uri(query=f"select municipality as t8_municipality, municipality_yield as t8_municipality_yield from ws2024_rcep_reports_view.final_outpul where province = '{province}'", uri=uri)

# Perform the joins
join_1 = lib_dropoff_point.join(tbl_actual_delivery, left_on='ldp_con_data', right_on='act_del_con_data', how='left')
join_2 = lib_dropoff_point.join(tbl_delivery, left_on='ldp_con_data', right_on='del_con_data', how='left')
join_3 = lib_dropoff_point.join(tbl_paymaya_claim, left_on='ldp_con_data', right_on='paymaya_claim_con_data', how='left')

# Perform aggregations
acceptedAndTransferred = join_1.group_by("t3_municipality").agg([
    pl.col("t3_totalBagCount").sum().alias("totalBagCount_sum"),
    pl.when(pl.col("t3_transferCategory") == 'P').then(pl.col("t3_totalBagCount")).sum().alias("totalBagCount_sum_p"),
    pl.when(pl.col("t3_transferCategory") == 'T').then(pl.col("t3_totalBagCount")).sum().alias("totalBagCount_sum_t")
])
accept = acceptedAndTransferred.with_columns(
    (pl.col("totalBagCount_sum") - pl.col("totalBagCount_sum_p") - pl.col("totalBagCount_sum_t")).alias("totalBagCount_sum_a")
)
ebinhi_distri = join_3.group_by("t4_municipality").agg([
    pl.col("t4_municipality").count().fill_nan(0).alias("ebinhi_distri")
])
ebinhi_bene = join_3.group_by("t4_municipality").agg([
    pl.col("t4_paymaya_code").unique().count().fill_nan(0).alias("ebinhi_bene")
])
regular_bene = new_released.group_by("t5_municipality").agg([
    pl.col("t5_new_released_id").unique().count().fill_nan(0).alias("regular_bene")
])
release = new_released.group_by("t5_municipality").agg([
    pl.col("t5_bags_claimed").sum().fill_nan(0).alias("bags_claimed"),
    pl.col("t5_claimed_area").sum().fill_nan(0).alias("claimed_area")
])

# Join and calculate columns
distributed = ebinhi_distri.join(release, left_on="t4_municipality", right_on="t5_municipality").fill_nan(0)
distributed = distributed.with_columns((
    pl.col("bags_claimed").fill_nan(0) + pl.col("ebinhi_distri").fill_nan(0)).alias("distributed")
)
beneficiaries = ebinhi_bene.join(regular_bene, left_on="t4_municipality", right_on="t5_municipality")
beneficiaries = beneficiaries.with_columns((
    pl.col("ebinhi_bene").fill_nan(0) + pl.col("regular_bene").fill_nan(0)).alias("beneficiaries")
)
bep_sex_count = tbl_beneficiaries.group_by("t6_municipality").agg([
    pl.col("t6_sex").filter(pl.col("t6_sex").str.starts_with("M")).count().fill_nan(0).alias("bep_male_count"),
    pl.col("t6_sex").filter(pl.col("t6_sex").str.starts_with("F")).count().fill_nan(0).alias("bep_female_count"),
    pl.col("t6_area").sum().fill_nan(0).alias("actual_area_bep")
])
# Convert to JSON
acceptedAndTransferred_json = acceptedAndTransferred.to_pandas().to_dict(orient='records')
accept_json = accept.to_pandas().to_dict(orient='records')
ebinhi_distri_json = ebinhi_distri.to_pandas().to_dict(orient='records')
release_json = release.to_pandas().to_dict(orient='records')
distributed_json = distributed.to_pandas().to_dict(orient='records')
ebinhi_bene_json = ebinhi_bene.to_pandas().to_dict(orient='records')
regular_bene_json = regular_bene.to_pandas().to_dict(orient='records')
beneficiaries_json = beneficiaries.to_pandas().to_dict(orient='records')
bep_sex_count_json = bep_sex_count.to_pandas().to_dict(orient='records')
farmer_information_final_json = farmer_information_final.to_pandas().to_dict(orient='records')
municipal_yield_json = municipal_yield.to_pandas().to_dict(orient='records')
# Merge JSON results
final_result_json = []
for item in acceptedAndTransferred_json:
    match = next((x for x in accept_json if x["t3_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in ebinhi_distri_json if x["t4_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in release_json if x["t5_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in distributed_json if x["t4_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in ebinhi_bene_json if x["t4_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in regular_bene_json if x["t5_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in beneficiaries_json if x["t4_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in bep_sex_count_json if x["t6_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in farmer_information_final_json if x["t7_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    match = next((x for x in municipal_yield_json if x["t8_municipality"] == item["t3_municipality"]), {})
    item.update(match)
    final_result_json.append(item)

# Print final JSON result
import json
selected_columns = [
    "t3_municipality",
    "totalBagCount_sum",
    "totalBagCount_sum_p",
    "totalBagCount_sum_t",
    "totalBagCount_sum_a",
    "ebinhi_distri",
    "ebinhi_bene",
    "regular_bene",
    "bags_claimed",
    "claimed_area",
    "distributed",
    "beneficiaries",
    "bep_male_count",
    "bep_female_count",
    "actual_area_bep",
    "total_male",
    "total_female",
    "total_final_area",
    "t8_municipality_yield"
]
# Ensure all selected columns are present with default values (e.g., 0) if not already present
for item in final_result_json:
    for col in selected_columns:
        if col not in item:
            item[col] = 0

# Filter the final_result_json to keep only the selected columns
filtered_result_json = [
    {key: item[key] for key in selected_columns} 
    for item in final_result_json
]

# Print the filtered JSON result
print(json.dumps(filtered_result_json, indent=4))
