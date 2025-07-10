## Installation
 1. Clone the repository from: ``` git clone https://github.com/Mohibul-Hasan-Rana/laravel-todo.git```

 2. Navigate to the project directory: ```cd laravel-todo```

 3. Install dependencies: ```composer update```

 4. Set up environment variables: ```cp .env.example .env```

 5. Generate an application key: ```php artisan key:generate```

 6. Update database information in env file. 

 7. Run migration file: ```php artisan migrate```

 8. Run those command ```composer dumpautoload``` and ```php artisan config:cache```

 ## Usage 

 1. Run this command: ```php artisan serve``` 

 2. Paste this URL in browser: http://127.0.0.1:8000/ 

 3. Run ```php artisan queue:work```  in terminal.

 4. Run ```php artisan schedule:run```  in another terminal.

 5. Create a task with due date after 12 minute. System will send email and insert in email_logs table between due time 0-10 minute.