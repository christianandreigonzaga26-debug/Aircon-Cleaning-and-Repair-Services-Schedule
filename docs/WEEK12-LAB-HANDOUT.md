# WEEK 12 — LAB HANDOUT
## Retrospective, Demo & Defense

**Duration:** ~90 min in-class  
**Work as:** Your team (5 members) — but the defense is individual and unassisted.  
**AI use this week:** ❌ Off for the oral defense. You explain your own code, yourself.  

**Due at end of session:** Deliverable 4 (QA, Deployment & Final Presentation, 30%)

---

## Why This Lab Matters

This is the finish line. You'll reflect honestly on the whole build, present your deployed Aircon Booking & Repair application with a live demo, and each defend your own code unassisted.

Twelve weeks ago this was an idea and an empty repo; today it's a working, tested, deployed app — and you can prove you built it.

---

## Task 1 — Final Retrospective (15 min)

As a team, run a blameless retro across the whole course.

**Questions to discuss:**
- **What went well?** (e.g., sprint planning, feature completion, testing discipline, team collaboration)
- **What didn't?** (e.g., scope creep, late deployments, integration pain, testing gaps)
- **What would you change next time?** (e.g., earlier code reviews, better documentation, clearer APIs, more frequent deployments)

**Capture concrete lessons** (not blame) in `/docs/retrospective.md`.

**Expected output:** Honest, structured reflection with 3–5 takeaways and how you'd apply them to the next project.

---

## Task 2 — Prepare the Presentation (20 min)

Build a short deck + live demo following this arc:

### **The Story Arc**
1. **Problem** — Why do aircon users need scheduling? (bookings, service management, availability conflicts)
2. **Solution** — What does your app solve? (easy booking, real-time slots, automated reminders, service tracking)
3. **Architecture** — Explain by following a request: User books service → [API call] → [backend validation] → [DB write] → [confirmation sent]
4. **Live Demo** — Walk through a real user flow on the deployed app
5. **What We Learned** — Key technical and team insights

### **Slides cover each stage**
- Problem & motivation (1 slide)
- Solution overview & key features (2 slides)
- Architecture diagram + request flow (1–2 slides)
- Tech stack (Blade templates, Node.js/Laravel, MySQL) (1 slide)
- Demo walkthrough plan (1 slide)

### **The Demo uses the deployed app (not localhost)**
- Test all critical paths: new booking, service selection, date/time picker, payment/confirmation
- Include one edge case: what happens with an invalid input? (e.g., past date, wrong email format, double-book)
- Gracefully handle the error and show recovery

### **Prepare a backup**
- Screenshots of key screens
- Short video (30 sec) of the happy path
- Plan B: if live demo fails, narrate the flow with visuals

---

## Task 3 — Rehearse (15 min)

Run the exact demo click-path **once, start to finish**. Do not skip this.

**Checklist:**
- [ ] Open the deployed app (not localhost)
- [ ] Walk through booking flow end-to-end
- [ ] Submit invalid data → show the error handling gracefully
- [ ] Submit valid booking → confirm success and DB state
- [ ] Each team member knows which section they present
- [ ] Timing: keep to ~5–7 minutes total
- [ ] Network & latency: test on actual deployed URL

---

## Task 4 — Present & Demo (time varies)

Deliver the presentation and live demo of the deployed app.

**Remember:**
- Keep to your allotted time
- Let the demo carry the story (minimal talking during clicks)
- If the live demo fails: show backup, stay calm, move on
- One person presents architecture; one person leads the demo; others field questions

---

## Task 5 — Defend Your Code, Unassisted (individual)

Each team member, **alone and without AI**, walks a reviewer through their own code.

**Be prepared to answer:**
- **"Why this approach?"** — Why did you choose this architecture, library, or pattern? What were the trade-offs?
- **"What happens on invalid input?"** — Where is validation? (frontend, backend, database?) How do you handle it?
- **"What happens if a record is missing?"** — How do you handle a 404? A null user? A deleted service?
- **"What would you improve?"** — Be honest. Technical debt? Untested edge cases? Performance bottlenecks?

**Example questions you may get:**
- "Walk me through the booking API endpoint. What does it do on each line?"
- "How does your date/time validation work?"
- "What happens if two users book the same slot simultaneously?"
- "Show me your error handling in the payment flow."
- "Where is the business logic: frontend, backend, or database?"

**Tone:** Conversational, honest, reflective. This is not a test of perfection—it's a test of understanding your own work.

---

## Deliverable 4 — Final Submission Checklist

*(See the full Definition of Done in your course materials.)*

- [ ] **Tested, bug-resistant app** deployed to a live URL
  - [ ] Critical paths tested (book service, confirm, cancel, admin panel)
  - [ ] Edge cases handled gracefully (invalid input, missing data, concurrent bookings, timezone issues)
  - [ ] Error messages are clear and actionable

- [ ] **Professional presentation + live demo**
  - [ ] Slides cover problem → solution → architecture → demo → learnings
  - [ ] Demo runs on deployed app (not localhost)
  - [ ] Backup (screenshots/video) prepared
  - [ ] Timing: 5–7 minutes

- [ ] **/docs/retrospective.md** present
  - [ ] Honest reflection on what went well, what didn't, what's next
  - [ ] 3–5 actionable takeaways

- [ ] **/docs/deployment.md** present
  - [ ] How to deploy the app (step-by-step)
  - [ ] Environment setup (database, config, secrets)
  - [ ] Known issues or limitations
  - [ ] How to roll back if needed

- [ ] **Each member completed unassisted oral defense**
  - [ ] Explained your own code
  - [ ] Answered questions about edge cases and design
  - [ ] Reflected on what you'd improve

- [ ] **Contributions visible**
  - [ ] Commit history shows distributed work over 12 weeks
  - [ ] GitHub project board or issue tracker reflects sprints
  - [ ] Pull request reviews and approvals documented
  - [ ] Each member has pushed code in multiple sprints

---

## Tips for Success

### **For the Retrospective**
- Be specific: "We started code reviews late" is better than "we could have communicated better."
- Balance: celebrate what worked (team morale matters), then focus on growth areas.

### **For the Demo**
- Test on your phone/different network to simulate user conditions.
- Have a backup network (hotspot) in case WiFi fails.
- Know the URL by heart; don't fumble searching for it.

### **For the Defense**
- Read your own code the night before; freshen your memory.
- Expect the question: "Why didn't you test this case?"—have an honest answer.
- If you don't know the answer, say so. "I'd need to check how that's handled" is better than guessing.

---

## You Made It

From isolated scripts to a collaboratively built, tested, reviewed, and deployed web application—with the judgment to use AI well.

That combination of fundamentals and judgment is what makes an engineer. Well done. 🎉

---

## Questions or Issues?

If deployment fails, your demo backup becomes your proof. If a team member is absent, the others present their code and theirs. The spirit of this week is to show what you built—and to understand it.

**Good luck, team.**
