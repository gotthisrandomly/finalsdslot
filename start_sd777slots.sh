#!/bin/bash

# Navigate to the project directory
cd /home/engine/app/project/php_project

# Start the PHP built-in web server
php -S 0.0.0.0:8080 -t public &

# Wait for the server to start
sleep 2

# Open the admin portal in the default browser
termux-open-url http://localhost:8080/admin

echo "Server started. Admin portal opened in browser."
echo "Users can connect to the casino at http://[your-ip-address]:8080"