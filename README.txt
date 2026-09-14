BEGINNER PROJECT SETUP

Technology:
- Apache/XAMPP
- PHP
- MySQL
- HTML
- CSS
- JavaScript
- AJAX/JSON

SETUP:
1. Install XAMPP.
2. Copy this folder into C:\xampp\htdocs\
3. Start Apache and MySQL.
4. Open phpMyAdmin.
5. Import database/complaint_system.sql.
6. Visit:
   http://localhost/complaint_system_beginner/

STAFF ACCOUNT:
1. Register a normal account from register.php.
2. Open phpMyAdmin and run:
   UPDATE users SET role='staff'
   WHERE email='your_email@example.com';

IMPORTANT FILE STRUCTURE:
- config/       Database connection
- includes/     Session and common layout
- api/          AJAX endpoint
- assets/css/   Basic styling
- assets/js/    Client-side validation and AJAX
- database/     SQL file

CRITERIA COVERAGE:
- Multi-tier structure: pages, config/includes, database/API
- UI: HTML and CSS
- Feature implementation: registration, login, complaint submission, tracking
- Database: MySQL users and complaints tables
- Authentication: PHP sessions and role checking
- JS validation: validation.js
- PHP validation: validation in register.php and user_dashboard.php
- AJAX/JSON: staff status update
- Collaboration: use Git/GitHub and commit separate features
