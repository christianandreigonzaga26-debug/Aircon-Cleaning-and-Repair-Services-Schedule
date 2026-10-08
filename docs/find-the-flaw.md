# Find the Flaw Log

## Week 9 review findings

This file records the bugs we found while reviewing AI-generated code for the booking feature. The goal was to catch problems that would look reasonable at a glance but fail in real use.

---

## 1) Stubbed booking routes are not real validation

### Snippet reviewed
- `routes/appointments.js`

### What is wrong
The route handlers return canned success messages for every request and never validate request data.

Example problems:
- `POST /appointments` accepts empty objects
- invalid dates are never rejected
- missing required fields are never checked
- the route does not return error payloads in a consistent shape

### Why this is a bug
The app is supposed to enforce booking rules, but the code is effectively a placeholder. This means the system will accept bad data and silently treat invalid bookings as successful.

### Correct fix
- validate required fields before processing
- return `400` or `422` on invalid input
- use a consistent response format such as `{ success, message, errors }`
- persist only valid bookings

### Review comment
Blocking: "This route never validates any input and always returns success. It violates the booking acceptance criteria and must be fixed before merge."

---

## 2) Past dates were allowed for bookings

### Snippet reviewed
- the initial `ScheduleController` validation rules

### What is wrong
The original validation used:

```php
'schedule_date' => ['required', 'date']
```

This accepts dates in the past, even though the feature says the system should prevent bookings in the past.

### Why this is a bug
A user can schedule an appointment for yesterday or earlier, which breaks the booking rule and creates invalid records.

### Correct fix
Use a future-date rule such as:

```php
'schedule_date' => ['required', 'date', 'after_or_equal:today']
```

and return a clear message when the user picks an invalid date.

### Review comment
Blocking: "Past dates are currently accepted. This breaks the core business rule and should be rejected before the PR is merged."

---

## 3) Phone and customer validation were too weak

### Snippet reviewed
- the initial `ScheduleController` store validation

### What is wrong
The rules accepted almost any string for `customer_name` and `phone`, and there was no clear validation message for invalid contact data.

### Why this is a bug
Bad data enters the system, and the UI cannot show precise user-friendly errors. This can also make downstream reporting unreliable.

### Correct fix
- require a minimum length for customer names
- validate format for phone numbers
- return explicit validation messages

### Review comment
Blocking: "The validation is too permissive. A booking with a blank or malformed phone number should be rejected with a clear message."

---

## 4) Runtime mismatch: the project was not actually runnable in the current environment

### Snippet reviewed
- `server.js`
- project startup assumptions

### What is wrong
The project was attempting to run as a Node/Express app, but the environment does not have Node installed. The app also does not include a proper Node project setup for execution.

### Why this is a bug
The code may look complete in a source editor, but it cannot start or run end-to-end in this workspace. A feature that cannot be executed is not a completed feature.

### Correct fix
- install/configure the correct runtime for the chosen stack
- or choose a working local runtime such as the PHP built-in server for this project
- verify with an actual startup command and HTTP response before claiming it works

### Review comment
Blocking: "The app never actually started here. We need a working runtime and a real smoke test before merge."

---

## 5) Error handling was inconsistent between frontend and backend

### Snippet reviewed
- the booking UI in `feature/resources/views/schedules/index.blade.php`

### What is wrong
The frontend handles `422` validation responses, but the backend was not consistently returning the same JSON error structure. A malformed or empty response would produce unclear behavior.

### Why this is a bug
A validation failure should give users clear errors without crashing or showing a generic message. Inconsistent error payloads make debugging harder and create hidden UX issues.

### Correct fix
Standardize every API error response to:

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "customer_name": ["Customer name is required."]
  }
}
```

### Review comment
Nit: "The error handling is close, but standardizing the response shape would make validation and debugging much easier."

---

## 6) The AI-generated work looked polished but was incomplete

### Snippet reviewed
- several AI-assisted booking snippets

### What is wrong
The generated code looked clean and had all the right field names, but important business rules were missing or only partially implemented.

### Why this is a bug
A polished-looking implementation can still fail real acceptance tests if validation, edge cases, and runtime checks are skipped.

### Correct fix
Review every AI-generated patch against:
- correctness
- error paths
- validation rules
- security
- tests
- runtime execution

### Review comment
Nit: "The naming and structure are readable, but the implementation still needs a real validation and execution check before it is safe to merge."

---

## Good feedback examples from this review

### Blocking review
"This endpoint accepts arbitrary payloads and always reports success. It violates the booking validation requirements and should be rejected until validation and error handling are added."

### Nit review
"The success flow is clean and easy to follow. A small improvement would be to standardize the error payload format across all booking endpoints."

### Positive note
"The code is readable and the field names are clear, which makes the review easier. The next step is to add the missing validation and real execution checks."

---

## Merge rule reminder

No PR should be merged without:
- passing tests
- a substantive review
- a clear bug check against edge cases
- a real run or smoke test proving the app works

This lab’s main lesson is that AI-generated code must be treated as a draft, not as proof that the feature is complete.
