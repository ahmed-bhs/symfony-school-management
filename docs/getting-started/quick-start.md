---
layout: default
title: Quick Start
parent: Getting Started
nav_order: 2
---

# Quick Start

Get up and running with the School Management System in 5 minutes.

---

## Prerequisites

Make sure you've completed the [Installation](installation.md) first.

---

## Step 1: Access the Admin Panel

Open your browser and navigate to:

```
http://localhost:8080/admin
```

You should see the EasyAdmin dashboard with navigation menu on the left.

---

## Step 2: Explore the Dashboard

The dashboard shows:

- **Total Students** - Number of enrolled students
- **Total Classes** - Active classes
- **Total Professors** - Teaching staff
- **Recent Activity** - Latest updates
- **Performance Charts** - Student statistics

---

## Step 3: Manage Students

### View All Students

1. Click **Students** in the sidebar
2. You'll see a list of all students with:
   - Name
   - Birth date
   - Class assignment
   - Actions (view, edit, delete)

### Add a New Student

1. Click **Create Student** button
2. Fill in the form:
   - **Name** (required)
   - **First Name** (required)
   - **Birth Date** (required)
   - **Address**
   - **Father's Name**
   - **Father's Phone**
   - **Mother's Name**
   - **Mother's Phone**
   - **Class** (select from dropdown)
3. Click **Save**

### Edit a Student

1. Click the **Edit** icon next to a student
2. Modify the information
3. Click **Save**

---

## Step 4: Manage Classes

### View All Classes

1. Click **Classes** in the sidebar
2. See list of classes with:
   - Class name
   - Year
   - Number of students
   - Number of sessions

### Create a Class

1. Click **Create Class**
2. Enter:
   - **Name** (e.g., "6th Grade A")
   - **Year** (e.g., "2025-2026")
3. Click **Save**

### Assign Students to Class

1. Edit a student
2. Select the class from the **Class** dropdown
3. Save

---

## Step 5: Manage Professors

### Add a Professor

1. Click **Professors** in the sidebar
2. Click **Create Professor**
3. Fill in:
   - **Name**
   - **First Name**
   - **Phone**
   - **Skills** (subjects they teach)
   - **Competencies** (additional qualifications)
4. Save

---

## Step 6: Create Sessions (Schedule)

### Add a Session

1. Click **Sessions** in the sidebar
2. Click **Create Session**
3. Fill in:
   - **Day** (Monday-Friday)
   - **Start Time** (e.g., 08:00)
   - **End Time** (e.g., 09:00)
   - **Class** (select class)
   - **Professor** (select professor)
   - **Subject** (e.g., "Mathematics")
4. Save

This creates a weekly recurring session.

---

## Step 7: Create Evaluations

### Add an Evaluation

1. Click **Evaluations** in the sidebar
2. Click **Create Evaluation**
3. Enter:
   - **Title** (e.g., "Math Test - Chapter 1")
   - **Type** (e.g., "Test", "Quiz", "Exam")
   - **Coefficient** (weight in final grade, e.g., 2)
   - **Date**
   - **Session** (select the session)
4. Save

---

## Step 8: Record Grades

### Add Grades for an Evaluation

1. Click **Grades** in the sidebar
2. Click **Create Grade**
3. Select:
   - **Evaluation** (the test/exam)
   - **Student**
   - **Value** (the grade, e.g., 15.5 out of 20)
4. Save

Repeat for each student in the class.

{: .note }
You can use the mass grade entry feature for faster input. See [User Guide](../user-guide/grades.md) for details.

---

## Step 9: Track Absences

### Record an Absence

1. Click **Absences** in the sidebar
2. Click **Create Absence**
3. Fill in:
   - **Student**
   - **Session** (which class they missed)
   - **Justified** (checkbox if absence is excused)
   - **Reason** (optional explanation)
4. Save

---

## Step 10: Switch Languages

The system supports 3 languages:

- French (Français)
- English
- Arabic (العربية)

### Change Language

1. Click the **language selector** in the top-right corner
2. Select your preferred language
3. The entire interface updates instantly

---

## Common Workflows

### Complete Student Enrollment Workflow

1. **Create Class** → Classes → Create
2. **Add Professor** → Professors → Create
3. **Create Sessions** → Sessions → Create (for each time slot)
4. **Enroll Students** → Students → Create (assign to class)

### Grading Workflow

1. **Create Evaluation** → Evaluations → Create (the test/exam)
2. **Record Grades** → Grades → Create (for each student)
3. **View Statistics** → Dashboard (see performance charts)

### Weekly Schedule Setup

1. **Create All Sessions** for the week (Mon-Fri)
2. **Assign Professors** to each session
3. **Assign Classes** to each session
4. **View Schedule** → Sessions list (filter by day)

---

## Keyboard Shortcuts

When entering grades:

- `Enter` - Save and move to next student
- `↑` - Navigate up
- `↓` - Navigate down
- `Tab` - Next field

---

## Tips for Beginners

### Start with Demo Data

If you haven't loaded fixtures yet:

```bash
docker-compose exec php php bin/console doctrine:fixtures:load
```

This creates sample data you can explore.

### Use Filters

- Click **Filters** button to search and filter lists
- Filter by class, date, professor, etc.

### Bulk Actions

- Select multiple items using checkboxes
- Use **Batch Actions** dropdown for bulk operations

### Export Data

- Use the **Export** button to download data as CSV or Excel

---

## Common Tasks Reference

| Task | Location | Action |
|------|----------|--------|
| Add Student | Students → Create | Fill form and save |
| Assign to Class | Edit Student | Select class dropdown |
| Create Schedule | Sessions → Create | Set day, time, professor |
| Record Grade | Grades → Create | Select evaluation and student |
| Mark Absence | Absences → Create | Select student and session |
| View Statistics | Dashboard | Charts and numbers |

---

## Next Steps

Now that you know the basics:

1. [User Guide](../user-guide/index.md) - Learn all features in detail
2. [Database Structure](../database/index.md) - Understand the data model
3. [Architecture Guide](../architecture/index.md) - Learn about the codebase

---

## Need Help?

- Check the [User Guide](../user-guide/index.md)
- See [Troubleshooting](troubleshooting.md)
- Visit [GitHub Issues](https://github.com/ahmed-bhs/symfony-school-management/issues)

---

**You're ready to start using the system!** 🎉
