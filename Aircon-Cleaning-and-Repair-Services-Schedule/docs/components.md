# UI Components Breakdown

## Shared Components
1. **Global Navigation Bar:** Reusable top header with varying links based on role:
   * Customer: Logo, Aircon Services, Home, Profile, Logout.
   * Technician: Logo, TECH PORTAL, My Jobs, Log Out.
   * Admin: Logo, ADMIN DASHBOARD, Appointments, Techs, Customers.
2. **Data Table:** Reused on the Admin Dashboard for both "Today's Appointments" and "Technician Roster"[cite: 4]. 
3. **Form Group:** Standardized wrapper for labels and inputs:
   * Dropdown selectors (e.g., Select Service)[cite: 2].
   * Radio button groups (e.g., Time Slot: Morning / Afternoon)[cite: 2].
   * Text inputs (e.g., Auto-filled Service Address)[cite: 2].
   * Textareas (e.g., Work Notes)[cite: 3].
4. **Action Buttons:** Standardized buttons including primary actions like "[ CONFIRM BOOKING ]"[cite: 2] and "[ MARK AS COMPLETE ]"[cite: 3], as well as inline table actions like "[x]" (delete) and "[ Edit ]"[cite: 4].

## Screens and Composition
*   **Booking Screen:** Navbar (Customer), Booking Form (Service Dropdown, Calendar Grid, Time Slot Radios, Address Input), Confirm Booking Button[cite: 2].
*   **Technician Job View:** Navbar (Tech), Job Details Text (Customer name, address, requested service), Update Service Record Form (Work Notes, Final Cost PHP), Mark As Complete Button[cite: 3].
*   **Admin Dashboard:** Navbar (Admin), Appointments Section (Data Table of ID, Customer, Service, Tech Assigned, Status), Technician Roster Section (Add Tech Button, Data Table of Name, Specialty, Status)[cite: 4].
