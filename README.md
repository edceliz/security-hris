# security-outsourcing-hris

Security outsource employees database - Main function is to monitor and track employee details.

## Installation
1. Clone repository
2. Run `composer install` on project folder.
3. Create `.env` file from `.env.example` and fill up with your environment configuration.
4. Run `php artisan migrate -seed`.
5. Run `php artisan serve` to start the application.

### Virtual Host Setup
If you are running the project using XAMPP or WAMP, you need to setup the application by pointing the root directory to `/public` folder of the project.