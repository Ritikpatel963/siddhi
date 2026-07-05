# myExam Pre LMS

## URLs

- Public website: `/`
- Student login: `/auth/student`
- Admin login: `/auth/adminpanel`
- Admin panel: `/adminpanel`

## Upgrade an existing database

Start MySQL, then run:

```bash
php database/migrate.php
```

For a fresh database, import `database/myexam_pre.sql` instead.

## LMS workflow

1. Create a course.
2. Add subjects to that course.
3. Upload notes/resources for each subject.
4. Create a quiz, add questions, and publish it.
5. Build the course's day-wise study plan and attach resources/quizzes.
6. Create a student and assign one or more courses.
7. The student signs in, follows the plan, downloads notes, and attempts quizzes.
8. Attempts appear under **Quiz Results** and on the admin dashboard.
