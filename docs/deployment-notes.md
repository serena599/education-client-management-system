# Deployment Notes

These notes document how the legacy PHP/MySQL application runs locally and what would be needed for production hosting.

## Local XAMPP Setup

- Apache serves the project from `htdocs`.
- MySQL stores the `student_management` database.
- The application reads database settings from `config/db.php`.
- File permissions matter because Apache may run as a different system user.

## Local Database

The local database connection used during development:

```text
Host: 127.0.0.1:3307
Database: student_management
User: root
```

The database can be imported from the SQL files in `sql/`.

## Production Hosting Considerations

For production, the application should be deployed with:

- HTTPS enabled with a valid SSL certificate.
- DNS pointed to the hosting server.
- Database credentials stored outside public version control.
- Upload directories configured with safe permissions.
- Regular MySQL backups.
- PHP error display disabled for users and logged server-side.

## AWS Option

A simple AWS deployment path could use:

- EC2 for Apache/PHP hosting.
- RDS or a managed MySQL-compatible database.
- S3 for uploaded images and generated files.
- Route 53 for DNS.
- ACM or a reverse proxy setup for SSL certificates.

This project is still a local portfolio build, but these notes show the production concerns I would address before real client deployment.
