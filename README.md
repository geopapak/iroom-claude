# iRoom - Room Scheduling System

A PHP-based room scheduling and management system for universities.

## Features

- Course and room management
- Schedule creation and management
- User authentication (CAS/SSO support)
- Equipment tracking
- Exam scheduling
- Department and university management

## Quick Start

### Prerequisites

- PHP 7.0 or higher
- MySQL 5.7+ or MariaDB 10.2+
- Apache/Nginx or PHP built-in server

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url> iroom-claude
   cd iroom-claude
   ```

2. **Configure database connection**
   ```bash
   # Update connectDB.php with your database credentials
   # Default settings are for localhost development
   ```

3. **Create database and tables**
   ```bash
   # Update createDB.php with your MySQL credentials
   php createDB.php
   ```

4. **Start the development server**
   ```bash
   # Using quick-start script
   ./quick-start.sh

   # Or manually with PHP built-in server
   php -S localhost:8000
   ```

5. **Access the application**
   - Open browser: `http://localhost:8000`
   - Default admin login:
     - Email: admin@admin.gr
     - Password: admin

## Detailed Setup

For detailed installation and configuration instructions, see [SETUP_GUIDE.md](SETUP_GUIDE.md)

## Project Structure

```
iroom-claude/
├── CAS/                    # CAS authentication library
├── Course/                 # Course management
├── Departament_University/ # Department management
├── Equipment_rooms/        # Equipment and room management
├── Schedule/               # Schedule management
├── Semester/               # Semester management
├── Users/                  # User management
├── connectDB.php           # Database connection
├── createDB.php            # Database initialization
├── index.php               # Main entry point
└── SETUP_GUIDE.md         # Detailed setup instructions
```

## Default Credentials

After running `createDB.php`, use these credentials to login:

- **Email:** admin@admin.gr
- **Password:** admin

**⚠️ Change these credentials immediately in production!**

## Technology Stack

- **Backend:** PHP
- **Database:** MySQL/MariaDB
- **Frontend:** HTML, CSS, JavaScript
- **Authentication:** CAS/SSO (optional for local development)

## Development

- PHP files are in the root and subdirectories
- CSS files in `/css`
- JavaScript files in `/js`
- No build process required - changes reflect immediately

## Support

For detailed setup instructions, troubleshooting, and configuration options, see [SETUP_GUIDE.md](SETUP_GUIDE.md)

## License

[Add your license information here]