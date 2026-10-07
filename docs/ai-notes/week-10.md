# AI Prompt Log — Week 10: QA & Adversarial Testing

## Session Overview
- **Goal:** Build test matrix, execute manual & adversarial QA pass, expand automated tests, triage P0/P1/P2 bugs for Aircon Scheduling System.

## Prompt History
1. **User Prompt:** Generated initial test matrix structure laying out domain features against happy, boundary, invalid, empty, and permission scenarios.
2. **AI Action:** Output formatted markdown table for `/docs/test-matrix.md` with domain-specific features (date selection, technician auto-dispatch, unit counts).
3. **User Prompt:** Added automated test code for critical paths (past dates, race conditions, unauthorized updates).
4. **AI Action:** Provided TypeScript/Jest test suite covering HTTP 400, 403, and 409 status codes.

## AI Review Notes
- Verified double-booking prevention requires database transaction locks (`SELECT ... FOR UPDATE` or unique composite indexes) rather than application-level checks.