# University Management System 🎓

A web-based **University Management System** designed to streamline academic operations. This application allows administrators to easily manage students, departments, courses, semesters, academic sessions, and course registrations through an intuitive dashboard interface.

---

## 🚀 Key Features

* **Dashboard Overview:** Centralized dashboard displaying key metrics and navigation options.
* **Student Management:** Register, update, and maintain detailed student records.
* **Department & Course Management:** Organize academic departments and assign courses.
* **Semester & Session Control:** Create and manage academic years, terms, and sessions (e.g., 2023–2024, Spring-2026).
* **Course Registration:** Streamlined system to track and handle student registrations.

---

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP
* **Database:** MySQL

---

## 📋 Prerequisites

To run this application locally, ensure you have a local web server environment installed:
* [XAMPP](https://www.apachefriends.org/) / [WAMP](https://www.wampserver.com/en/) / [MAMP](https://www.mamp.info/)
* Web browser (Google Chrome, Mozilla Firefox, Brave, etc.)

## Authentication and employee management setup

The employee module follows the supplied schema: `employees.department_id` references
`employee_departments.id`, while academic courses and students continue to use the separate
`department` table.

1. Import `university_management (3).sql` into the `university_management` database.
2. Apply `database/employee_management_constraints.sql` once. It adds the missing users
   auto-increment/unique indexes and restrictive employee foreign keys without adding columns.
3. Confirm the credentials in `config/database.php` match the local MySQL server.
4. Create the first login interactively (the password is hashed with PHP's current default):

```bash
php scripts/create_admin.php
```

5. Open `/versity_management_DBMS/login.php` and sign in with the username or email.

If the constraint script reports duplicate or orphan data, resolve those rows first and run it
again. Department and designation deletion is blocked whenever an employee references the row.

---

## 💻 Installation & Setup Guide

### 1. Clone or Download the Repository
```bash
git clone [https://github.com/your-username/university-management-system.git](https://github.com/your-username/university-management-system.git)
