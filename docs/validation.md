# Aircon Cleaning and Repair Services - Validation Matrix & Test Log

This document defines the validation rules, expected errors, and break-it test logs for all CREATE (POST) and UPDATE (PUT) routes across the system's primary records.

## Validation Matrix

| Route | Field | Rule Applied | Error Returned | Break-It Test Log |
| :--- | :--- | :--- | :--- | :--- |
| `POST /customers` | `name` | Required, must be a string | 400: "Name is required" | Sent empty string -> Rejected (400) |
| `POST /customers` | `phone` | Required, valid phone format | 400: "Invalid phone format" | Sent alphabetical characters -> Rejected (400) |
| `PUT /customers/:id` | `address` | Optional, must be a string | 400: "Address must be text" | Sent an integer -> Rejected (400) |
| `POST /appointments` | `customer_id` | Required, must exist in DB | 400: "Invalid customer ID" | Sent non-existent ID (999) -> Rejected (400) |
| `POST /appointments` | `appointment_date`| Required, YYYY-MM-DD, future date | 400: "Date must be in the future" | Sent past date -> Rejected (400) |
| `PUT /appointments/:id` | `status` | Must be: pending, confirmed, completed, cancelled | 400: "Invalid status" | Sent "banana" -> Rejected (400) |
| `POST /technicians` | `name` | Required, must be a string | 400: "Technician name required" | Sent empty payload -> Rejected (400) |
| `PUT /technicians/:id` | `status` | Must be: Available, Off-Duty | 400: "Invalid technician status"| Sent "Busy" -> Rejected (400) |
| `POST /services` | `price` | Required, positive number | 400: "Price must be > 0" | Sent -500 -> Rejected (400) |
| `PUT /services/:id` | `name` | Optional, must be a string | 400: "Invalid name format" | Sent null -> Rejected (400) |
| `POST /service-records` | `appointment_id`| Required, must exist in DB | 400: "Invalid appointment ID" | Sent missing ID -> Rejected (400) |
| `PUT /service-records/:id`| `final_cost` | Optional, positive number | 400: "Cost cannot be negative" | Sent -50 -> Rejected (400) |

---
*Note: As code implementation continues, the Break-It Test Log will be updated to reflect actual terminal output and automated test suite results.*
