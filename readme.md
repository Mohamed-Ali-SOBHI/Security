# PHP Login Script with User Authentication and Password Hashing

This is a simple PHP login script that demonstrates the basic functionality of user authentication and password hashing. It allows users to log in and add new accounts to a Mysql database.

## Features

- User authentication using identifier and password
- Password hashing for security
- Temporary account lockouts after 5 failed login attempts
- Password requirements for new accounts (at least 8 characters, including at least one uppercase letter, one lowercase letter, one number, and one special character)
- Creation of users table in Mysql database if it does not exist
- Error messages for failed login attempts and invalid password requirements

## Getting Started

1. Download the PHP script and save it to your local machine.
2. Open the script in your text editor of choice and modify the Mysql connection information (host, username, password, and database name) as necessary.
3. Run the script in your local web server environment or upload it to your web server.

## Usage

1. Enter a valid identifier and password to log in to an existing account.
2. Enter a new identifier and password to add a new account.
3. Click the "Reset" button to clear the form fields.

