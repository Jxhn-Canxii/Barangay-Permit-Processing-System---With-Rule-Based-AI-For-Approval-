AI-Driven Zoning Permit Processing User Manual

Overview
This project provides an AI-driven zoning permit processing system built for Local Government Units (LGUs) to streamline zoning permit management. The project is composed of two main parts:
1. Laravel Back-End: Manages the application logic and API.
2. Vue.js Front-End: Provides the user interface and interacts with the back-end.

The following guide will help you set up the application from scratch, including both the back-end and front-end components.

Table of Contents
1. System Requirements
2. Back-End Setup (Laravel)
    - Clone the Repository
    - Install Dependencies
    - Configure Environment Settings
    - Set Up the Database
    - Run Migrations
    - Create Storage Link
    - Run Laravel Application
3. Front-End Setup (Vue.js)
    - Install Node.js Dependencies
    - Compile Front-End Assets
    - Run Vue.js Development Server
4. Running Both Back-End and Front-End Simultaneously
5. Troubleshooting
6. License

1. System Requirements

Before setting up the project, make sure you have the following installed:

- PHP (7.4 or higher)
- Composer (for PHP dependencies)
- Node.js (for JavaScript dependencies)
- MySQL (for database storage)
- Git (for cloning the repository)

On Ubuntu:

Run the following commands to install necessary dependencies:

# Update package list
sudo apt update

# Install PHP, Composer, MySQL, Git, and Node.js
sudo apt install php php-cli php-mbstring php-xml php-curl php-zip php-mysql mysql-server git
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
sudo apt install -y nodejs

2. Back-End Setup (Laravel)

Clone the Repository

First, clone the project repository from GitHub:

git clone https://github.com/your-repo/ai-driven-zoning-permit-processing.git
cd ai-driven-zoning-permit-processing

Install Dependencies

Use Composer to install all necessary PHP dependencies:

composer install

Configure Environment Settings

Copy the .env.example file to .env:

cp .env.example .env

Edit the .env file to configure your database settings. For example:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lgu_zoning
DB_USERNAME=root
DB_PASSWORD=yourpassword

Set Up the Database

Make sure you have a MySQL database created (you can name it lgu_zoning or any name you prefer).

Log into MySQL and create the database:

mysql -u root -p
CREATE DATABASE lgu_zoning;
exit;

Run Migrations

Run the database migrations to create the required tables:

php artisan migrate

Create Storage Link

To allow the app to serve public files (e.g., images), create a symbolic link:

php artisan storage:link

Run Laravel Application

Start the Laravel development server:

php artisan serve

The application should now be running at http://127.0.0.1:8000.

3. Front-End Setup (Vue.js)

Install Node.js Dependencies

Go to the front-end directory and install the necessary dependencies:

cd path-to-frontend-directory
npm install

Compile Front-End Assets

Compile the assets (JavaScript and CSS) for development:

npm run dev

For a production build, use:

npm run prod

Run Vue.js Development Server

Start the Vue.js development server:

npm run serve

The front-end should now be available at http://localhost:8080.

4. Running Both Back-End and Front-End Simultaneously

Now that both back-end and front-end are set up:

1. Back-End (Laravel):
   - Run php artisan serve to start the Laravel server at http://127.0.0.1:8000.

2. Front-End (Vue.js):
   - Run npm run serve to start the Vue.js development server at http://localhost:8080.

Make sure both servers are running at the same time.

5. Troubleshooting

Can't Access File?
If you're unable to access uploaded files, make sure to run the following command to create the storage link:

php artisan storage:link

Permissions Issues

If you run into permission errors for storage or cache directories, run:

sudo chmod -R 775 storage bootstrap/cache

Database Issues

If you encounter issues with database migrations, try running:

php artisan migrate:refresh

This will reset and re-run the migrations.

6. License

This project is open-source and available under the MIT License. For more details, check the LICENSE file.


7. Installation of Php Machine Learningcomposer require php-ai/php-ml

composer require php-ai/php-ml


8. run training data command for zoning approval decision maker - AI

php artisan model:train

Conclusion

You should now have the AI-Driven Zoning Permit Processing system up and running on your local machine, both the Laravel back-end and the Vue.js front-end. If you encounter any issues, refer to the troubleshooting section or seek support from the community.
