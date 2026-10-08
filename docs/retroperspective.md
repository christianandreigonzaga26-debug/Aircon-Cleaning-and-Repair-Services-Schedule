# Project Retrospective: Aircon Services Schedule App

**Date:** 2026-10-08
**Participants:** [List team members]

## What Went Well
*   **Process:** [e.g., Pull request reviews caught bugs before they hit main.]
*   **Technical:** [e.g., Using environment variables kept our credentials secure; the test suite made refactoring booking logic safe.]
*   **Teamwork:** [e.g., Clear division of tasks between frontend scheduling UI and backend API.]

## What Didn't Go As Planned
*   **Process:** [e.g., We underestimated the time required to configure the live deployment environment.]
*   **Technical:** [e.g., Handling timezone differences for appointments caused data-saving bugs initially.]
*   **Teamwork:** [e.g., We had some merge conflicts early on when multiple people touched the same controller.]

## Lessons Learned & What We'd Change
*   **Concrete Lesson 1:** Write the failing test *before* fixing the bug. It saves time manually reproducing it.
*   **Concrete Lesson 2:** Move business logic (like checking for overlapping technician schedules) out of the controller and into a dedicated service class earlier in the project.
*   **Concrete Lesson 3:** Deploy a "Hello World" to the live host in Week 1 rather than waiting until the end to figure out infrastructure.
