Create a REST API with these features:

1. Student Management

-   Model: Student (name, student_id, class, section, photo)
-   CRUD endpoints with validation
-   Use Laravel Resource for API responses

2. Attendance Module

-   Model: Attendance (student_id, date, status, note, recorded_by)
-   Bulk attendance recording endpoint
-   Query optimization for attendance reports
-   Generate monthly attendance report (eager loading required)

3. Advanced Features

-   Implement a Service Layer for attendance business logic
-   Add a custom Artisan command: attendance:generate-report {month} {class}
-   Use Laravel Events/Listeners for attendance notifications
-   Implement Redis caching for attendance statistics

Part 2: Vue.js Frontend (30%)

Create a simple SPA:

1. Student List Page

-   Display students with search/filter by class
-   Pagination (use Laravel pagination)

2. Attendance Recording Interface

-   Select class/section, load students
-   Mark attendance (Present/Absent/Late) with bulk action
-   Show real-time attendance percentage

3. Dashboard

-   Display today’s attendance summary
-   Monthly attendance chart (use Chart.js or similar)

Part 3: AI Development Documentation (10%)

Create a AI_WORKFLOW.md file documenting:

1. Which parts you used AI assistance for (Claude Code/Cursor/ChatGPT)
2. 3 specific prompts you used and how they helped
3. How AI improved your development speed
4. What you manually coded vs AI-generated

Technical Requirements

-   Laravel 10+, Vue 3 (Composition API preferred)
-   Database: MySQL/PostgreSQL with proper migrations
-   Authentication: Laravel Sanctum (simple token-based)
-   Follow SOLID principles
-   Write at least 3 unit tests for critical features
-   Docker setup (optional but impressive)
-   Clean Git history with meaningful commits
