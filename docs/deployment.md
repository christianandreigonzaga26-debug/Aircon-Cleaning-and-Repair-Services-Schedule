# Deployment Notes

**Live Application URL:** [Insert Live URL Here]
**Deployment Date:** 2026-10-08
**Hosting Provider:** [e.g., Render, Heroku, DigitalOcean]

## Environment Configuration
- [x] `APP_DEBUG` set to `false`
- [x] Database credentials securely stored in host environment variables
- [x] Production application key generated and set

## Deployment Steps
1. Provisioned host and attached the database.
2. Set environment variables in the host's dashboard.
3. Deployed main branch.
4. Executed database migrations to build the scheduling schema.

## Smoke Test Results
- [ ] **Happy Path:** Successfully booked a new aircon cleaning appointment, viewed it on the schedule, updated the service address, and cancelled the booking.
- [ ] **Failure Path:** Attempted to book an appointment in the past (or without providing a required phone number); verified the app returned a `422 Unprocessable Entity` validation error instead of a hard crash.
