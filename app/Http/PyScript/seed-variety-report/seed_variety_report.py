import polars as pl
import time
import concurrent.futures
from sqlalchemy import create_engine
import pandas as pd
import json
from urllib.parse import quote

# Database URI
uri = "mysql+mysqlconnector://root:%s@192.168.10.44:3306/" % quote('Zeijan@13')

# Use SQLAlchemy for connection pooling
engine = create_engine(uri, pool_size=10, max_overflow=20)

# Function to fetch data with SQLAlchemy
def fetch_data(query, engine):
    try:
        with engine.connect() as connection:
            return pd.read_sql(query, connection)
    except Exception as e:
        print(f"Query failed: {e}")
        return None

# Start the timer
start_time = time.time()

# Fetch distinct prefixes and regions
lib_dropoff_point_query = (
    "SELECT DISTINCT LEFT(prv_dropoff_id, 4) as prefix "
    "FROM ws2024_rcep_delivery_inspection.lib_dropoff_point;"
)
province_query = (
    "SELECT DISTINCT region "
    "FROM ws2024_rcep_delivery_inspection.lib_dropoff_point;"
)

lib_dropoff_point_df = fetch_data(lib_dropoff_point_query, engine)
province_df = fetch_data(province_query, engine)

# Convert pandas DataFrame to polars DataFrame
lib_dropoff_point_df = pl.from_pandas(lib_dropoff_point_df) if lib_dropoff_point_df is not None else pl.DataFrame()
province_df = pl.from_pandas(province_df) if province_df is not None else pl.DataFrame()

# Extract distinct prefixes into a list
available_tables = lib_dropoff_point_df['prefix'].to_list() if not lib_dropoff_point_df.is_empty() else []

# Function to fetch and process data from a single table
def process_table(prefix, engine):
    table_name = f"ws2024_prv_{prefix}.new_released"
    query = (
        f"SELECT bags_claimed, seed_variety, province, municipality, claimed_area, content_rsbsa "
        f"FROM {table_name} WHERE category='INBRED';"
    )
    try:
        df = fetch_data(query, engine)
        if df is not None:
            polars_df = pl.from_pandas(df)
            if "bags_claimed" not in polars_df.columns:
                print(f"Warning: 'bags_claimed' column not found in table {table_name}")
                return table_name, None
            # Ensure consistent column types
            polars_df = polars_df.with_columns([
                pl.col("bags_claimed").cast(pl.Float64, strict=False),
                pl.col("seed_variety").cast(pl.Utf8, strict=False),
                pl.col("province").cast(pl.Utf8, strict=False),
                pl.col("municipality").cast(pl.Utf8, strict=False),
                pl.col("claimed_area").cast(pl.Float64, strict=False),
                pl.col("content_rsbsa").cast(pl.Utf8, strict=False),
            ])
            return table_name, polars_df
        else:
            print(f"Failed to fetch data from {table_name}: No data returned")
            return table_name, None
    except Exception as e:
        print(f"Failed to fetch data from {table_name}: {e}")
        return table_name, None

# Use a ThreadPoolExecutor to process tables concurrently
def process_tables_concurrently(available_tables, engine):
    dataframes = {}
    with concurrent.futures.ThreadPoolExecutor(max_workers=8) as executor:
        futures = {
            executor.submit(process_table, prefix, engine): prefix for prefix in available_tables
        }
        for future in concurrent.futures.as_completed(futures):
            prefix = futures[future]
            table_name, df = future.result()
            if df is not None:
                dataframes[table_name] = df
    return dataframes

# Process all tables and combine the results
dataframes = process_tables_concurrently(available_tables, engine)

# Optionally, combine all fetched DataFrames into a single DataFrame
if dataframes:
    # Ensure all DataFrames have the same schema before concatenating
    combined_df = pl.concat([df for df in dataframes.values() if df is not None])
else:
    print("No matching tables found.")
    combined_df = pl.DataFrame()

# Debug the schema of combined_df
# print("Combined DataFrame schema:")
# print(combined_df.schema)

# Proceed only if combined_df has the necessary columns
if "bags_claimed" in combined_df.columns:
    combined_df = combined_df.with_columns([
        pl.col("bags_claimed").cast(pl.Float64),
    ])
    overall_seed_data = combined_df.group_by(["seed_variety"]).agg([
        pl.col("bags_claimed").sum().fill_nan(0).alias("total_seed_bags")
    ])
    total_seed_variety = combined_df.select(
        pl.col("seed_variety").n_unique().alias("total_seed_variety")
    )
    total_seed_data = combined_df.select(
        pl.col("bags_claimed").sum().alias("total_seed_data")
    )
else:
    overall_seed_data = pl.DataFrame()
    total_seed_variety = pl.DataFrame()
    total_seed_data = pl.DataFrame()
    #print("Error: Combined DataFrame does not have the required columns.")

# End the timer and calculate elapsed time
# end_time = time.time()
# elapsed_time = end_time - start_time

# print(f"Benchmark Time: {elapsed_time:.2f} seconds")

# Prepare result
result = {
    "regions": province_df.to_dicts() if not province_df.is_empty() else [],
    "overall_seed_data": overall_seed_data.to_dicts() if not overall_seed_data.is_empty() else [],
    "total_seed_variety": total_seed_variety.to_dicts() if not total_seed_variety.is_empty() else [],
    "total_seed_data": total_seed_data.to_dicts() if not total_seed_data.is_empty() else [],
}

# Convert the result to JSON
result_json = json.dumps(result, indent=4)

# Print or return the JSON result as needed
print(result_json)