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

 Bug #1 (P0) — Concurrent Double-Booking Race Condition
Severity: P0 (Broken core / Data integrity loss)
Steps to Reproduce:
Open two browser windows on the booking page for October 20, 10:00 AM slot.
Fill out customer details on both tabs.
Click Submit simultaneously on both tabs.
Expected: One booking succeeds; the second receives a 409 Conflict error stating the slot is no longer available.
Actual: Both bookings are saved to the database under the same technician and time slot.
Bug #2 (P0) — ID Tampering Allows Unauthenticated Booking Edits
Severity: P0 (Security / Unauthorized data modification)
Steps to Reproduce:
Log in as Customer A and view a booking (/bookings/101).
Change the URL ID parameter to /bookings/102 (Customer B's booking ID).
Change the date and submit the form.
Expected: 403 Forbidden error.
Actual: Customer B's booking is updated without permission check.
Bug #3 (P1) — Stored XSS in Address & Technician Notes Field
Severity: P1 (Security vulnerability, non-critical flow)
Steps to Reproduce:
Enter <script>alert('xss')</script> in the "Special Instructions" text area during booking.
Submit booking and open the Admin Schedule View.
Expected: Text is sanitized and rendered as raw text.
Actual: Script executes in the browser when loaded by the admin.