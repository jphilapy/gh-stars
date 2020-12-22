# Read Me

### Architecture:
- Laravel (PHP)
- Bootstrap
  - general styles
  - popover
  - tooltip
- NPM
- Composer
- php-curl-class
- MySQL

### Installation
- download and extract the zip file: http://portfolio.altahost.com/interview-vanderbilt.zip
- In the project root directory:
  - Open the .env file
  - Find the section that begins with: DB_CONNECTION=mysql
    - Setup your credentials (db name, username, password, etc) for that section.
  - Using a terminal, cd to the root directory
  - run the command: php artisan migrate (This will create the database. You should get messages indicating that everything migrated.)
  - run the command: php artisan serve (you should now be able to view the project in a web browser)
  - To set the table to empty for a fresh start type: php artisan migrate:refresh

Alternatively, you can see the live version at http://portfolio.altahost.com/github-stars/

### How to use the App
- Visit http://portfolio.altahost.com/github-stars/ (or 127.0.0.1:8000 if using laravel's built in server)
- You will be presented with the login page. Click the login link
- Once the app is authorized, you will be redirected to the dashboard, where you can just click "Update Report"

### Sourcode location
- app/Http/Controllers/GitHubReportsController.php
- resources/views/layouts/app.blade.php (global stuff)
- resources/views/detail.blade.php (single repo listing page)
- resources/views/dashboard.blade.php (table of listings)
- resources/views/login.blade.php (just a link to authorize the app)
- routes/web.php
- .env (for configuration info)