# UI Components Breakdown

## Shared Components
1. **Navbar:** Main navigation (Home, Schedule, Customers).
2. **StatusBadge:** Visual indicator for job status (e.g., Pending, In Progress, Completed, Cancelled).
3. **JobCard / ListRow:** (Most Reused) Displays summary of an appointment (Date, Customer, Service Type, Status).
4. **BookingForm:** Reusable form for creating and editing service appointments.
5. **Button:** Standardized action buttons (Primary, Secondary, Danger).

## Screens and Composition
*   **Index/List View (Dashboard):** Navbar, Empty/Loading/Error States, List of JobCards.
*   **Detail View:** Navbar, Job Details (Customer info, AC unit details, Notes), StatusBadge, Edit/Delete Buttons.
*   **Create Form View:** Navbar, BookingForm, Submit Button.
*   **Edit Form View:** Navbar, BookingForm (pre-filled), Save/Cancel Buttons.
