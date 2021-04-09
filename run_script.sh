#!/bin/bash

#to run the application
echo "Starting server"
php artisan serve --host=0.0.0.0 --port=8000 &
echo "Migration Started" 
sudo php artisan migrate &
echo "Queue Started"
sudo php artisan queue:work --daemon --timeout=3000 &