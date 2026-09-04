# My Project

| Field | Rules |
|---|---|
| name | required, string |

POST /appointments
PUT /appointments/:id

POST /appointments

{
  "customer_id": 1,
  "service_id": 2,
  "technician_id": 3,
  "appointment_date": "2026-08-20",
  "quantity": 2,
  "status": "pending"
}

# Aircon Cleaning and Repair Services Schedule

## Validation Matrix

This document defines the validation rules for all CREATE and UPDATE
routes of the Aircon Cleaning and Repair Services Schedule API.

---

## POST /appointments

Creates a new aircon cleaning or repair appointment.

| Field | Presence | Type | Length/Range | Format | Allowed Values | Referential |
|---|---|---|---|---|---|---|
| customer_id | required | number | 1+ | integer | — | customer must exist |
| service_id | required | number | 1+ | integer | — | service must exist |
| technician_id | required | number | 1+ | integer | — | technician must exist |
| appointment_date | required | string | 10 chars | YYYY-MM-DD | — | — |
| quantity | required | number | 1–999 | integer | — | — |
| status | required | string | 1–20 chars | lowercase text | pending, confirmed, completed, cancelled | — |

"customer_id": 5
"service_id": 2
"technician_id": 3
"appointment_date": "2026-08-20"
"quantity": 2
"status": "banana"


PUT /appointments/:id
PUT /appointments/15

---

## PUT /appointments/:id

Updates an existing aircon cleaning or repair appointment.

| Field | Presence | Type | Length/Range | Format | Allowed Values | Referential |
|---|---|---|---|---|---|---|
| customer_id | optional | number | 1+ | integer | — | customer must exist |
| service_id | optional | number | 1+ | integer | — | service must exist |
| technician_id | optional | number | 1+ | integer | — | technician must exist |
| appointment_date | optional | string | 10 chars | YYYY-MM-DD | — | — |
| quantity | optional | number | 1–999 | integer | — | — |
| status | optional | string | 1–20 chars | lowercase text | pending, confirmed, completed, cancelled | — |

{
  "appointment_date": "2026-08-25"
}

{
  "quantity": -50
}

# Aircon Cleaning and Repair Services Schedule

## Validation Matrix

This document contains the validation rules for the CREATE and UPDATE
routes of the Aircon Cleaning and Repair Services Schedule API.

The validation rules use the following categories:

- Presence
- Type
- Length/Range
- Format
- Allowed Values
- Referential

---

# 1. POST /appointments

Creates a new appointment for an aircon cleaning or repair service.

| Field | Presence | Type | Length/Range | Format | Allowed Values | Referential |
|---|---|---|---|---|---|---|
| customer_id | required | number | 1+ | integer | — | customer must exist |
| service_id | required | number | 1+ | integer | — | service must exist |
| technician_id | required | number | 1+ | integer | — | technician must exist |
| appointment_date | required | string | 10 chars | YYYY-MM-DD | — | — |
| quantity | required | number | 1–999 | integer | — | — |
| status | required | string | 1–20 chars | lowercase text | pending, confirmed, completed, cancelled | — |

### Validation Explanation

#### customer_id
- Presence: required
- Type: number
- Range: 1 or greater
- Format: integer
- Referential: customer must exist in the customers table

#### service_id
- Presence: required
- Type: number
- Range: 1 or greater
- Format: integer
- Referential: service must exist in the services table

#### technician_id
- Presence: required
- Type: number
- Range: 1 or greater
- Format: integer
- Referential: technician must exist in the technicians table

#### appointment_date
- Presence: required
- Type: string
- Length: 10 characters
- Format: YYYY-MM-DD

#### quantity
- Presence: required
- Type: number
- Range: 1–999
- Format: integer

#### status
- Presence: required
- Type: string
- Length: 1–20 characters
- Format: lowercase text
- Allowed values:
  - pending
  - confirmed
  - completed
  - cancelled

---

# 2. PUT /appointments/:id

Updates an existing appointment.

| Field | Presence | Type | Length/Range | Format | Allowed Values | Referential |
|---|---|---|---|---|---|---|
| customer_id | optional | number | 1+ | integer | — | customer must exist |
| service_id | optional | number | 1+ | integer | — | service must exist |
| technician_id | optional | number | 1+ | integer | — | technician must exist |
| appointment_date | optional | string | 10 chars | YYYY-MM-DD | — | — |
| quantity | optional | number | 1–999 | integer | — | — |
| status | optional | string | 1–20 chars | lowercase text | pending, confirmed, completed, cancelled | — |

### Update Rules

An update request may include one or more fields.

Fields that are not included do not need to be changed.

However, any field that is included must follow the same type,
range, format, allowed-value, and referential rules as the CREATE route.

---

# 3. Summary

Every CREATE and UPDATE route has a complete field-by-field
validation rule list.

The API validates:

1. Presence - checks whether required fields are provided.
2. Type - checks whether the data has the correct type.
3. Length/Range - checks the allowed size or numerical range.
4. Format - checks whether the value follows the correct pattern.
5. Allowed Values - checks whether the value is one of the accepted choices.
6. Referential - checks whether related IDs exist in the database.