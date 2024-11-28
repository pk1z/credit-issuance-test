curl -X POST http://127.0.0.1:8000/api/clients \
-H "Content-Type: application/json" \
-d '{
    "firstName": "John",
    "lastName": "Doe",
    "age": 30,
    "creditScore": 700,
    "email": "john.doe@example.com",
    "phone": "+1234567890",
    "address": {
        "street": "123 Main St",
        "city": "Los Angeles",
        "state": "CA",
        "zip": "90001"
    }
}'
