# Aircon Cleaning and Repair Services - User Stories & Backlog

## 1. Customers
* **Create**: As a Customer, I want to register a new account so that I don't have to re-enter my details every time I book a service.
  * *Acceptance Criteria:* System requires name, phone, and address. Upon submission, a unique Customer ID is generated.
* **Read**: As an Admin, I want to view customer information and service history so that I can provide better customer support.
  * *Acceptance Criteria:* Admin can fetch a list of all customers or search by ID to see past bookings.
* **Update**: As a Customer, I want to edit my contact number and address so that technicians go to the correct location.
  * *Acceptance Criteria:* User can update profile fields, and the database reflects the new data on their next booking.
* **Delete**: As an Admin, I want to remove a customer record so that we can comply with data deletion requests.
  * *Acceptance Criteria:* Deleting the customer ID completely removes their profile from the database.

## 2. Appointments
* **Create**: As a Customer, I want to schedule a cleaning or repair appointment so that my aircon gets fixed on a specific date.
  * *Acceptance Criteria:* User must select a date, time, and service type. System prevents booking in the past.
* **Read**: As an Admin, I want to view the appointment schedule and status so that I know how many jobs are pending today.
  * *Acceptance Criteria:* System lists all appointments, filterable by status (Pending, Confirmed, Completed).
* **Update**: As a Customer, I want to reschedule my appointment so that I can change the date if my availability changes.
  * *Acceptance Criteria:* User can modify the date/time of an existing appointment without having to create a brand new one.
* **Delete**: As a Customer, I want to cancel my appointment so that I don't get charged for a service I no longer need.
  * *Acceptance Criteria:* Canceling changes the appointment status to "Cancelled" or removes it from the active schedule.

## 3. Technicians
* **Create**: As an Admin, I want to add a new technician so that they can be assigned to customer appointments.
  * *Acceptance Criteria:* Form captures technician name and specialty. System generates a unique Technician ID.
* **Read**: As an Admin, I want to view a technician's profile and assigned schedule so that I don't double-book them.
  * *Acceptance Criteria:* Viewing a technician ID returns their profile and a list of their upcoming appointments.
* **Update**: As a Technician, I want to update my availability details so that I don't get assigned jobs on my days off.
  * *Acceptance Criteria:* Technician can toggle their status (Available, Off-Duty) and the system saves it.
* **Delete**: As an Admin, I want to remove a technician record so that former employees can no longer be assigned to jobs.
  * *Acceptance Criteria:* Deleting the technician removes them from the active assignment roster.

## 4. Services
* **Create**: As an Admin, I want to add a new service package (e.g., Deep Cleaning) so that customers can book newly offered options.
  * *Acceptance Criteria:* Must include a service name, description, and price.
* **Read**: As a Customer, I want to view available services and pricing so that I know what to select and how much it will cost.
  * *Acceptance Criteria:* System returns a complete list of all active services and their base prices.
* **Update**: As an Admin, I want to edit a service price or description so that the website reflects our current rates.
  * *Acceptance Criteria:* Editing an existing Service ID permanently updates its price in the database.
* **Delete**: As an Admin, I want to delete a service so that customers cannot book packages we no longer offer.
  * *Acceptance Criteria:* Deleted services no longer appear in the customer booking dropdown.

## 5. Service Records
* **Create**: As a Technician, I want to record a completed service so that the shop has a log of the work done for billing.
  * *Acceptance Criteria:* Form requires the Appointment ID, final cost, and work notes.
* **Read**: As a Customer, I want to view my service history so that I know when my aircon was last cleaned or repaired.
  * *Acceptance Criteria:* Fetching records by Customer ID returns all completed jobs.
* **Update**: As an Admin, I want to update service notes or cost so that I can correct any billing errors made by the technician.
  * *Acceptance Criteria:* System allows modification of the final cost and notes on an existing record.
* **Delete**: As an Admin, I want to delete an incorrect service record so that our historical data remains accurate.
  * *Acceptance Criteria:* Record is removed and no longer appears in the customer's history.
