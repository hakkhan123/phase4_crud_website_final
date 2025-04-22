### 📄 `README.md`

```markdown
# Phase 4 - Student Management CRUD Website

This project is the final phase of a full-stack database project using PHP, MySQL, and HTML/CSS. It allows users to manage Students, Professors, Courses, and Enrollments through a CRUD interface.

---

## 📁 Folder Structure

```
phase4_crud_website_final/
├── index.php
├── db.php
├── students.php
├── professors.php
├── courses.php
├── enrollment.php
├── assets/
│   ├── style.css
│   └── validate.js
├── create.sql
├── load.sql
```

---

## 🧠 Requirements

- PHP (>= 8.0) — run via built-in PHP server
- MySQL — used to store and retrieve data
- VS Code or any IDE
- Homebrew (if using macOS)

---

## 🔧 How to Run the Project

### 1. Install PHP and MySQL (if not already installed)

```bash
brew install php
brew install mysql
```

---

### 2. Start MySQL server

```bash
brew services start mysql
```

---

### 3. Create and Load the Database

```bash
mysql -u root
```

Inside MySQL prompt:

```sql
CREATE DATABASE student_db;
EXIT;
```

Back in terminal:

```bash
mysql -u root student_db < create.sql
mysql -u root student_db < load.sql
```

---

### 4. Launch the Web Server

```bash
php -S localhost:8000
```

Then open in your browser:

```
http://localhost:8000
```

---

## 📝 Features

- Add, Update, Delete Students
- Add, Update, Delete Professors
- Add, Update, Delete Courses (linked to professors)
- Enroll Students in Courses
- See All Enrollments with Grades

---

## ⚠️ Notes

- Make sure MySQL server is running before starting the site
- You must load data into the database using `create.sql` and `load.sql`
- All actions are validated via front-end JavaScript
