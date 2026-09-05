# RESTful Routing Table

**Project:** Aircon-Cleaning-and-Repair-Services-Schedule
A scheduling and service management system for aircon cleaning, maintenance, and repair appointments.

---

## 1. Customer Routes

| Method | Path | Handler | Story it serves |
| :--- | :--- | :--- | :--- |
| GET | `/customers` | listCustomers | View customer information and service history |
| GET | `/customers/:id` | showCustomer | View one customer's information and service history |
| POST | `/customers` | createCustomer | Register a new customer |
| PUT | `/customers/:id` | updateCustomer | Edit customer details |
| DELETE | `/customers/:id` | deleteCustomer | Remove customer record |

## 2. Appointment Routes

| Method | Path | Handler | Story it serves |
| :--- | :--- | :--- | :--- |
| GET | `/appointments` | listAppointments | View appointment schedule and status |
| GET | `/appointments/:id` | showAppointment | View one appointment |
| POST | `/appointments` | createAppointment | Schedule a cleaning or repair appointment |
| PUT | `/appointments/:id` | updateAppointment | Reschedule appointment or update status |
| DELETE | `/appointments/:id` | deleteAppointment | Cancel or delete appointment |

## 3. Technician Routes

| Method | Path | Handler | Story it serves |
| :--- | :--- | :--- | :--- |
| GET | `/technicians` | listTechnicians | View technician profile and assigned schedule |
| GET | `/technicians/:id` | showTechnician | View one technician |
| POST | `/technicians` | createTechnician | Add a new technician |
| PUT | `/technicians/:id` | updateTechnician | Update technician details and availability |
| DELETE | `/technicians/:id` | deleteTechnician | Remove technician record |

## 4. Service Routes

| Method | Path | Handler | Story it serves |
| :--- | :--- | :--- | :--- |
| GET | `/services` | listServices | View available services and pricing |
| GET | `/services/:id` | showService | View one service |
| POST | `/services` | createService | Add a new service |
| PUT | `/services/:id` | updateService | Edit service details, description, or price |
| DELETE | `/services/:id` | deleteService | Delete a service |

## 5. Service Record Routes

| Method | Path | Handler | Story it serves |
| :--- | :--- | :--- | :--- |
| GET | `/service-records` | listServiceRecords | View customer service history |
| GET | `/service-records/:id` | showServiceRecord | View one service record |
| POST | `/service-records` | createServiceRecord | Record a completed cleaning or repair service |
| PUT | `/service-records/:id` | updateServiceRecord | Update service notes, cost, or completion status |
| DELETE | `/service-records/:id` | deleteServiceRecord | Delete an incorrect service record |

---

## CRUD Coverage

| Record Type | Create | Read | Update | Delete |
| :--- | :--- | :--- | :--- | :--- |
| **Customer** | POST `/customers` | GET `/customers` | PUT `/customers/:id` | DELETE `/customers/:id` |
| **Appointment** | POST `/appointments` | GET `/appointments` | PUT `/appointments/:id` | DELETE `/appointments/:id` |
| **Technician** | POST `/technicians` | GET `/technicians` | PUT `/technicians/:id` | DELETE `/technicians/:id` |
| **Service** | POST `/services` | GET `/services` | PUT `/services/:id` | DELETE `/services/:id` |
| **Service Record**| POST `/service-records`| GET `/service-records`| PUT `/service-records/:id`| DELETE `/service-records/:id`|

---

## RESTful Method Rules

* **GET** retrieves records.
* **POST** creates records.
* **PUT** updates records.
* **DELETE** removes records.
* **`:id`** identifies a specific record.
* *GET is not used for creating or deleting records.*

## Total CRUD Routes

* **Customer:** 5 routes
* **Appointment:** 5 routes
* **Technician:** 5 routes
* **Service:** 5 routes
* **Service Record:** 5 routes
* **Total: 25 routes**

---

## Request and Response Examples

*(Note: The team has agreed on one consistent response shape for all endpoints: `{ success, message, data }`)*

### GET (List All)
* **Example:** `GET /appointments`
* **Request Body:** None
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "message": "Successfully fetched all appointments",
    "data": [
      { "id": 1, "status": "Scheduled", "date": "2026-09-10" }
    ]
  }
