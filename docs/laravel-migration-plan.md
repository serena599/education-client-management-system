# Laravel Migration Plan

The current system is a legacy PHP application built from direct PHP includes, action files, and custom database classes. A full rewrite would be risky, so a Laravel migration should be incremental.

## Proposed Laravel Structure

```text
routes/web.php
routes/api.php
app/Models/Student.php
app/Models/Program.php
app/Models/Payment.php
app/Http/Controllers/StudentController.php
app/Http/Controllers/ProgramController.php
app/Http/Controllers/AuthController.php
resources/views/
database/migrations/
```

## Migration Steps

1. Document the current database tables and relationships.
2. Create Laravel migrations matching the existing schema.
3. Move authentication to Laravel's password hashing and middleware.
4. Rebuild one module first, such as students or programs.
5. Add REST API routes for selected frontend or integration use cases.
6. Gradually move views into Blade templates.

## Why Incremental Migration

The existing application has many connected modules, including students, programs, payments, attendance, SMS, reports, and user activity logs. Rewriting everything at once would create a high risk of regressions.

An incremental migration demonstrates maintainable engineering judgement: stabilise, document, improve security, then modernise module by module.
