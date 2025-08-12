# MDT Insights Installation Guide

This project is a PHP-based web portal for managing user registrations and accessing reports. Follow the steps below to set up the application locally or on a server.

## Prerequisites
- PHP 7.4 or newer with the `mysqli` extension
- MySQL or MariaDB database server
- A web server such as Nginx or Apache

## Installation Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/your-org/mdtinsights.git
   cd mdtinsights
   ```

2. **Configure the database connection**
   - Create a database (e.g., `powerbi`).
   - Create the required tables, including `users` and `users_login_logs` with columns referenced in the PHP files.
   - Update `db.php` with the correct database host, username, password, and database name.

3. **Deploy the application**
   - Place the repository in your web server's document root (e.g., `/var/www/html`).
   - Ensure the web server has permission to read the files.
   - If using Nginx with PHP-FPM, configure the server block to serve the `.php` files.

4. **Run the application**
   - Start or reload your web server.
   - Visit `http://<your-server>/login.php` to access the login page.
   - New users can register via `register.php`.

5. **Optional: Adjust tracking integrations**
   - Files like `login.php` and `register.php` include Microsoft Clarity analytics snippets. Replace the tracking ID if needed.

## Support
For issues or contributions, open an issue or submit a pull request.
