import pandas as pd
import numpy as np


df = pd.read_csv('model\datacleaning\cleaned_ph.csv')

# 1. convert date to datetime format
df['Date'] = pd.to_datetime(df['Date'])

# 2. replace negative AQI -1 values with NaN
df.loc[df['AQI'] < 0, 'AQI'] = np.nan

# 3. Handle Missing Values in Pollutants
numeric_cols = ['AQI', 'so2', 'co', 'o3', 'pm10', 'pm2.5', 'no2', 'nox', 'no']
df[numeric_cols] = df.groupby('sitename')[numeric_cols].transform(
    lambda x: x.interpolate(method='linear').ffill().bfill()
)


def change_status(aqi):
    if aqi <= 25:
        return 'good'

    elif aqi <= 35:
        return 'fair'

    elif aqi <= 45:
        return 'unhealthy for sensitive group'

    elif aqi <= 55:
        return 'very unhealthy'

    elif aqi <= 90:
        return 'acutely unhealthy'
    else:
        return 'emergency'


df['status'] = df['AQI'].apply(change_status)

# sasve the cleaned dataset
df.to_csv('cleaned_ph_updated.csv', index=False)
