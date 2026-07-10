# Security Improvements

This project started as a legacy PHP/MySQL education management system. The first security pass focuses on authentication, database access, and safer API output while keeping the existing architecture stable.

## Authentication

### Previous approach

- `login_action.php` loaded every user from the database.
- Passwords were compared using a raw SHA-256 hash.
- The login query was not scoped to a single username.

### Improved approach

- Login now queries one user by username with a prepared statement.
- Password checks use `password_verify()` for modern hashes.
- Existing SHA-256 passwords are still accepted temporarily.
- When a legacy SHA-256 password is used successfully, the password is upgraded with `password_hash()`.

This gives the project a practical migration path instead of forcing all users to reset passwords immediately.

## SQL Injection Risk Reduction

The legacy codebase builds many SQL statements with string concatenation. As a first safe step, the login query and new API detail queries use prepared statements.

Future work should move shared database operations into a reusable prepared statement helper.

## API Output

The new JSON endpoints intentionally expose only selected fields. For example, the student API does not return family phone numbers or address details.

This keeps the API useful for frontend integration while reducing unnecessary data exposure.

## Remaining Security Work

- Add CSRF protection to form submissions.
- Harden file upload validation for student and user photos.
- Replace more dynamic SQL strings with prepared statements.
- Add role checks to API endpoints before exposing them beyond local development.
- Move environment-specific database settings out of committed PHP files.
