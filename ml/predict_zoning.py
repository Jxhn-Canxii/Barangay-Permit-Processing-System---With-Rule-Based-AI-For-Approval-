import sys
import json
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler

# Dummy dataset (replace with actual training data)
data = [
    {"right_over_land": 1, "zoning_district": 1, "proposed_use": 1, "existing_structures": 1, "setback_compliance": 1, "lot_area": 2, "status_id": 2},
    {"right_over_land": 2, "zoning_district": 2, "proposed_use": 3, "existing_structures": 0, "setback_compliance": 0, "lot_area": 1, "status_id": 3},
    {"right_over_land": 3, "zoning_district": 3, "proposed_use": 5, "existing_structures": 1, "setback_compliance": 1, "lot_area": 3, "status_id": 2},
    {"right_over_land": 1, "zoning_district": 2, "proposed_use": 2, "existing_structures": 1, "setback_compliance": 1, "lot_area": 2, "status_id": 2},
    {"right_over_land": 2, "zoning_district": 1, "proposed_use": 4, "existing_structures": 0, "setback_compliance": 0, "lot_area": 1, "status_id": 3},
]

# Convert data to Pandas DataFrame
df = pd.DataFrame(data)

# Split dataset into features and labels
X = df.drop(columns=["status_id"])
y = df["status_id"]

# Train-test split (80% training, 20% testing)
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Standardize data
scaler = StandardScaler()
X_train = scaler.fit_transform(X_train)
X_test = scaler.transform(X_test)

# Train RandomForestClassifier
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Read input data from Laravel
try:
    input_json = sys.argv[1]
    input_data = json.loads(input_json)

    # Convert input to DataFrame
    input_df = pd.DataFrame([input_data])

    # Standardize input
    input_df = scaler.transform(input_df)

    # Predict status_id (2 = Approved, 3 = Rejected)
    prediction = int(model.predict(input_df)[0])

    # Return result to Laravel
    print(json.dumps({"status_id": prediction}))

except Exception as e:
    print(json.dumps({"error": str(e)}))
