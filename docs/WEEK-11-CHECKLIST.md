# Week 11: Fix, Clean Up & Ship — End-of-Lab Checklist

**Team:** Christian Andrei Gonzaga, Lawrence Curan, Ian Piluden, Nikko Paul Lora, Victor Antonio Dy  
**Week:** 11 (Oct 8, 2026)  
**Time:** ~90 min in-class  
**Deadline:** [Lab end date]

---

## Task 1: Squash P0/P1 Bugs ✓

### Completion Criteria
- [ ] P0 bugs identified and prioritized
- [ ] P1 bugs identified and prioritized
- [ ] Each bug has a dedicated feature branch (`fix/P0-*` or `fix/P1-*`)
- [ ] Each bug has a failing test that captures the issue
- [ ] Bug is fixed and test now passes
- [ ] PR is reviewed by at least one team member
- [ ] `npm test` passes on all bug-fix branches
- [ ] All bug-fix PRs are merged to `main`

### P0 Bugs Fixed
| Bug ID | Description | Branch | PR # | Status |
|--------|-------------|--------|------|--------|
| [#] | [e.g., "Data loss on appointment delete"] | `fix/P0-...` | [#] | ✓ Merged |
| [#] | [Add more rows as needed] | | | |

### P1 Bugs Fixed
| Bug ID | Description | Branch | PR # | Status |
|--------|-------------|--------|------|--------|
| [#] | [e.g., "Validation error not shown"] | `fix/P1-...` | [#] | ✓ Merged |
| [#] | [Add more rows as needed] | | | |

---

## Task 2: Pay Down Debt ✓

### Completion Criteria
- [ ] 1–2 meaningful debt items identified
- [ ] Debt item is NOT a new feature
- [ ] Debt item is NOT a "while I'm here" rewrite
- [ ] Refactor is completed with tests passing
- [ ] Code review completed
- [ ] Changes merged to `main`

### Debt Items Tackled
| Item | Type | Description | Files Changed | PR # | Status |
|------|------|-------------|----------------|------|--------|
| 1 | [e.g., "Duplication"] | [Describe refactor] | [e.g., `routes/booking.js`, `models/Booking.js`] | [#] | ✓ Merged |
| 2 | [Type] | [Describe] | [Files] | [#] | ✓ Merged |

### Test Results
- [ ] `npm test` passes after refactor
- [ ] No regression in existing features
- [ ] Code coverage maintained or improved

---

## Task 3: Set Up Environments & Config ✓

### Completion Criteria
- [ ] `.env.example` file created with all required keys
- [ ] `.env.example` has no actual secret values (template only)
- [ ] `.gitignore` includes `.env` and `.env.local`
- [ ] All hardcoded config moved to environment variables
- [ ] `APP_DEBUG` or equivalent is **off** in production
- [ ] `README.md` updated with setup instructions
- [ ] No secrets are committed to the repo (audit passed)

### Environment Variables
| Variable | Purpose | Local Default | Production | Status |
|----------|---------|----------------|------------|--------|
| `NODE_ENV` | Environment mode | `development` | `production` | ✓ |
| `PORT` | Server port | `3000` | `8080` | ✓ |
| `APP_DEBUG` | Debug mode | `true` | `false` | ✓ |
| `DB_HOST` | Database host | `localhost` | `[prod host]` | ✓ |
| `DB_USER` | Database user | `root` | `[prod user]` | ✓ |
| `DB_PASSWORD` | Database password | `[empty]` | `[prod pass]` | ✓ |
| `DB_NAME` | Database name | `aircon_schedule` | `aircon_schedule_prod` | ✓ |
| `SESSION_SECRET` | Session encryption | `dev-secret` | `[strong secret]` | ✓ |
| `JWT_SECRET` | JWT signing | `dev-jwt` | `[strong secret]` | ✓ |
| `API_URL` | Backend base URL | `http://localhost:3000` | `https://[domain]` | ✓ |
| `FRONTEND_URL` | Frontend base URL | `http://localhost:3000` | `https://[domain]` | ✓ |

### Files Status
- [ ] `.env.example` created
- [ ] `.gitignore` verified (contains `.env`, `.env.local`)
- [ ] No `.env` file committed (verify with `git log --all --full-history -- .env`)
- [ ] README.md setup section added

### Secrets Audit
- [ ] No API keys in source code
- [ ] No database credentials hardcoded
- [ ] No JWT/session secrets in code
- [ ] Third-party API keys externalized

---

## Task 4: Deploy to a Live Host ✓

### Completion Criteria
- [ ] Hosting platform chosen and account created
- [ ] GitHub repository connected to hosting platform
- [ ] All production environment variables set on host
- [ ] Code deployed successfully (build logs reviewed, no errors)
- [ ] Database migrations run and production schema created
- [ ] Health check: app is accessible at live URL
- [ ] Live URL recorded in `/docs/deployment.md`

### Deployment Summary
- **Platform:** [e.g., Render, Railway, Heroku, Vercel]
- **Account:** [e.g., team email / GitHub login]
- **Live URL:** `https://[your-domain]`
- **Auto-Deploy:** ✓ Enabled on `main` branch push
- **Build Status:** ✓ Latest build successful
- **Database:** ✓ Migrations completed

### Deployment Checklist
- [ ] Platform account set up
- [ ] GitHub OAuth/deploy key configured
- [ ] All env vars set in platform settings
- [ ] `NODE_ENV=production` confirmed
- [ ] `APP_DEBUG=false` confirmed
- [ ] Database credentials point to production DB
- [ ] First deploy successful (0 errors in build log)
- [ ] Database migrations ran: `npm run migrate` (or equivalent)
- [ ] Health endpoint responds with 200 OK
- [ ] Static assets load correctly
- [ ] Live URL is publicly accessible (no login wall)

---

## Task 5: Smoke-Test the Live App ✓

### Completion Criteria
- [ ] Test at live URL (not `localhost`)
- [ ] Happy path (CRUD) fully functional
- [ ] Failure path (invalid input → 422) displays correctly
- [ ] No console errors in browser
- [ ] All smoke tests passed

### Happy Path Test Results
| Operation | Expected | Actual | Status |
|-----------|----------|--------|--------|
| **Create** (e.g., book appointment) | Record saved & appears in list | [Your result] | ✓ PASS / ✗ FAIL |
| **Read** (view record details) | All fields display correctly | [Your result] | ✓ PASS / ✗ FAIL |
| **Update** (edit a field) | Change persists & list updates | [Your result] | ✓ PASS / ✗ FAIL |
| **Delete** (remove a record) | Record removed with confirmation | [Your result] | ✓ PASS / ✗ FAIL |

**Happy Path Status:** ✓ PASS / ✗ FAIL

### Failure Path Test Results
| Scenario | Expected | Actual | Status |
|----------|----------|--------|--------|
| **Missing Required Field** | 422 error; field highlighted; message shown | [Your result] | ✓ PASS / ✗ FAIL |
| **Invalid Format** (e.g., bad email, non-numeric phone) | 422 error; error reason shown | [Your result] | ✓ PASS / ✗ FAIL |
| **XSS Attempt** (`<script>alert(1)</script>`) | Input escaped; no script execution | [Your result] | ✓ PASS / ✗ FAIL |

**Failure Path Status:** ✓ PASS / ✗ FAIL

### Browser Console Check
- [ ] No errors in DevTools Console
- [ ] No warnings (unless pre-existing)
- [ ] Network requests all return 200-level status codes

### Issues Found & Fixed
| Issue | Severity | Fix Applied | Status |
|-------|----------|-------------|--------|
| [If any] | [P0/P1/P2] | [How fixed] | ✓ Fixed / ⏳ Pending |

---

## Additional Deliverables ✓

### Documentation
- [ ] `/docs/week-11-lab.md` — Lab guide (this file!)
- [ ] `/docs/deployment.md` — Live URL, deployment notes, sign-off
- [ ] `/docs/ai-notes/week-11.md` — All AI prompts logged & decisions documented
- [ ] `.env.example` — Environment variables template
- [ ] `.gitignore` — Excludes `.env` and sensitive files
- [ ] `README.md` — Updated with deployment & setup instructions

### Code Quality
- [ ] `npm test` passes on main branch
- [ ] No console errors or warnings in production
- [ ] Code follows project style guide (linting passes)

### Team Artifacts
- [ ] Team roster documented (README.md)
- [ ] Roles & responsibilities clear
- [ ] AI usage logged & justified
- [ ] No AI-generated code committed without review

---

## Sign-Off

### Completion Summary
| Task | Status | Assignee | Date |
|------|--------|----------|------|
| Task 1: Bug Fixes | ✓ Complete / ⏳ In Progress / ✗ Blocked | [Name] | [Date] |
| Task 2: Debt Paydown | ✓ Complete / ⏳ In Progress / ✗ Blocked | [Name] | [Date] |
| Task 3: Config & Env | ✓ Complete / ⏳ In Progress / ✗ Blocked | [Name] | [Date] |
| Task 4: Deployment | ✓ Complete / ⏳ In Progress / ✗ Blocked | [Name] | [Date] |
| Task 5: Smoke Tests | ✓ Complete / ⏳ In Progress / ✗ Blocked | [Name] | [Date] |

### Team Sign-Off
- **Repo Lead** (Christian Andrei Gonzaga): [Signature / Date]
- **Scribe** (Lawrence Curan): [Signature / Date]
- **Builder 1** (Ian Piluden): [Signature / Date]
- **Builder 2** (Victor Antonio Dy): [Signature / Date]
- **Board Lead** (Nikko Paul Lora): [Signature / Date]

### Live URL (Final)
```
https://[your-live-url]
```

### Notes for Week 12 Prep
- [Add any blockers, follow-ups, or dependencies for Week 12 presentation]

---

## Week 12: Ready for Retrospective & Presentation?

- [ ] Live app is stable and public
- [ ] All team members understand their own code
- [ ] Demo script prepared (5-minute walkthrough)
- [ ] Presentation slides drafted
- [ ] Each member ready for oral defense of their code

**Status:** Ready / Needs Work / Blocked  
**Expected Ready Date:** [Date]

---

**End of Week 11 Checklist**

✅ **All tasks complete → Ship it! 🚀**

