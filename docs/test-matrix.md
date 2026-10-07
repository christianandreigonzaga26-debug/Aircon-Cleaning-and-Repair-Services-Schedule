# QA Test Matrix: Aircon Service Scheduling System

**Legend:**  
- `PASS`: Operates per requirements  
- `FAIL`: Bug detected (logged in Bug Tracker)  
- `N/A`: Scenario not applicable to this feature  

| Feature | Happy Path | Boundary / Edge | Invalid Input | Empty State | Permissions / Auth |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **User Booking Creation** | PASS | PASS (Max 10 units) | FAIL (XSS payload) | PASS | PASS |
| **Date & Time Slot Picker** | PASS | PASS (24h cutoff) | FAIL (Past dates) | PASS | N/A |
| **Technician Auto-Dispatch** | PASS | FAIL (Double-book) | FAIL (Inactive tech) | PASS | PASS |
| **Manage / Reschedule Booking** | PASS | PASS (48h lock window) | FAIL | N/A | FAIL (ID tampering) |
| **Service History & Status** | PASS | N/A | N/A | PASS | PASS |
| **Admin Booking Override** | PASS | PASS | FAIL | N/A | PASS |