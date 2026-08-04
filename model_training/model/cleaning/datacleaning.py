import pandas as pd
import numpy as np

# Load the dataset
file_path = 'dataset_taiwan_moths.csv'
df = pd.read_csv(file_path)

# 1. Convert 'date' to datetime format for time-series handling
df['date'] = pd.to_datetime(df['date'])

# 2. Fix Invalid Data: Replace negative AQI values (-1) with NaN
df.loc[df['aqi'] < 0, 'aqi'] = np.nan

# 3. Handle Missing Values in Pollutants
# We interpolate missing values for each site specifically.
# This fills gaps in $SO_2$, $PM_{2.5}$, $O_3$, etc., based on time trends.
numeric_cols = ['aqi', 'so2', 'co', 'o3', 'pm10', 'pm2.5', 'no2', 'nox', 'no']
df[numeric_cols] = df.groupby('sitename')[numeric_cols].transform(
    lambda x: x.interpolate(method='linear').ffill().bfill()
)

# 4. Handle Categorical Missing Values
# Drop rows where 'status' is still missing (if any remain)
df.dropna(subset=['status'], inplace=True)

# Save the cleaned dataset
df.to_csv('cleaned_dataset_taiwan_2months.csv', index=False)

print("Cleaning complete. No missing values remain:")
print(df.isnull().sum())
