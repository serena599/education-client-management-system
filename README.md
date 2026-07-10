# Education Client Management System

<p align="center">
  <img width="2730" height="1510" alt="dashboard" src="https://github.com/user-attachments/assets/874e0ecd-28a3-48e6-96f6-e06bc0687ca5" />

</p>

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-legacy%20app-777BB4?style=flat-square&logo=php&logoColor=white">
  <img alt="MySQL" src="https://img.shields.io/badge/MySQL-database-4479A1?style=flat-square&logo=mysql&logoColor=white">
  <img alt="XAMPP" src="https://img.shields.io/badge/XAMPP-local%20server-FB7A24?style=flat-square&logo=xampp&logoColor=white">
  <img alt="Status" src="https://img.shields.io/badge/status-portfolio%20build-17806D?style=flat-square">
</p>

Education Client Management System is a PHP and MySQL web application for small education providers that need one place to manage learners, programs, batches, payments, ID cards, receipts, reports, notices, and user activity.

The project is built as a practical admin system rather than a landing page. Most screens are designed around everyday office tasks: finding a student, checking payment status, printing a receipt, reviewing activity, or updating institute settings.

## What it does

- Student profile management with photos, IDs, barcodes, and printable student cards.
- Program and batch management with batch day/time details.
- Student admission into programs and batch-based learner lists.
- Payment tracking for monthly fees and other payment types.
- Paid/due status summaries with printable receipts and payment reports.
- Institute profile settings, logo upload, contact details, and branding.
- User profile, role, status, login activity, and activity comparison logs.
- Notice, SMS statistics, quick learner access, live chat, and SQL utility screens.


## Tech stack

- PHP
- MySQL / MariaDB
- XAMPP for local Apache and MySQL
- HTML, CSS, JavaScript
- jQuery and Bootstrap-style UI components

The quickest way to run the project locally is through XAMPP.

1. Put the project folder inside XAMPP `htdocs`.

   Example:

   ```text
   /Applications/XAMPP/xamppfiles/htdocs/education-client-management-system
   ```

2. Start XAMPP services.

   ```text
   Apache
   MySQL
   ```

3. Create a local database in phpMyAdmin.

   Recommended database name:

   ```text
   student_management
   ```

4. Import the SQL file.

   ```text
   sql/install_sql.sql
   
5. Open the app in the browser and install.

   ```text
   http://localhost/Student-Management-System/install_system.php
   ```
   
6. Open the app in the browser.

   ```text
   http://localhost/education-client-management-system/login.php
   ```
   
## Demo login

```text
Username: admin
Password: admin
```

## Installation screen

The project includes a browser-based database setup screen:

<img width="2556" height="1516" alt="install-database" src="https://github.com/user-attachments/assets/1e86fbc5-b2f6-4cd1-9512-418d1402233a" />


For local development, manually creating `config/db.php` is usually easier and more reliable, especially when XAMPP file permissions block the installer from writing config files.

## Screen Shoot

### Learner profile
<img width="2626" height="1434" alt="learner-profile" src="https://github.com/user-attachments/assets/ec85b077-b5dc-4a1e-8ef4-71d1f8079e77" />

### Program workspace
<img width="2730" height="1510" alt="dashboard" src="https://github.com/user-attachments/assets/a1d58020-aea5-4e7b-8a91-b092115cd3c4" />

### Payment tracking
<img width="2608" height="1500" alt="payment-overview" src="https://github.com/user-attachments/assets/d3cda78d-3baa-4a45-b0ff-f88c3d65401e" />

### Receipt printing
<img width="2478" height="1438" alt="payment-receipt" src="https://github.com/user-attachments/assets/1fc48022-ef08-4672-a1e9-4c3a6409cabf" />

### SQL editor
<img width="2532" height="1462" alt="sql-editor" src="https://github.com/user-attachments/assets/ce9af07e-c2f3-443b-8e71-19d6d9320ebc" />
