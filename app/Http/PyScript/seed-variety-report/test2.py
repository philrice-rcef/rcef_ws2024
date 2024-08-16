import os, sys
import polars as pl
from urllib.parse import quote
import time

uri ="mysql://root:%s@192.168.10.44:3306/" % quote('Zeijan@13')

start_time = time.time()

lib_dropoff_point_df = pl.read_database_uri(query=f"select distinct left(prv_dropoff_id,4) as prv_dropoff_id from ws2024_rcep_delivery_inspection.lib_dropoff_point;", uri=uri)

#print("Distinct prefixes from prv_dropoff_id:")
#print(lib_dropoff_point_df)

# Extract distinct prefixes
available_tables = (
    lib_dropoff_point_df
    .with_columns([
        pl.col("prv_dropoff_id").alias("prefix")
    ])
    .select("prefix")
    .unique()
    .to_series()
    .to_list()
)

#print("Available Tables Based on Prefixes:", available_tables)

dataframes = {}

# Loop through each prefix and fetch the corresponding table
for prefix in available_tables:
    table_name = f"ws2024_prv_{prefix}.new_released"
    query = f"SELECT bags_claimed, seed_variety, province, municipality, claimed_area, content_rsbsa, seed_variety, municipality, category FROM {table_name} where category='INBRED';"
    
    try:
        df = pl.read_database_uri(query=query, uri=uri)
        dataframes[table_name] = df
        # print(f"Data from {table_name}:")
        # print(df)
        # print()  # Newline for better readability
    except Exception as e:
        print(f"Failed to fetch data from {table_name}: {e}")

def process_tables_concurrently(table_names, uri):
    dataframes = {}
    with concurrent.futures.ThreadPoolExecutor(max_workers=8) as executor:
        futures = {executor.submit(process_table, table_name, uri): table_name for table_name in table_names}
        
        for future in concurrent.futures.as_completed(futures):
            table_name = futures[future]
            try:
                df = future.result()
                if df is not None:
                    dataframes[table_name] = df
            except Exception as exc:
                print(f'Processing table {table_name} generated an exception: {exc}')
    return dataframes

# Optionally, combine all fetched DataFrames into a single DataFrame
if dataframes:
    combined_df = pl.concat(list(dataframes.values()))
    #print("Combined DataFrame:")
    #print(combined_df)
else:
    print("No matching tables found.")

end_time = time.time()
elapsed_time = end_time - start_time

print(f"Benchmark Time: {elapsed_time:.2f} seconds")