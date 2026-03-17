# PHP_Laravel12_Support_Bubble


## Project Description

PHP_Laravel12_Support_Bubble is a simple Laravel 12 application that integrates a floating support chat bubble using a package.

The application allows users to click on a support bubble, fill out a contact form, and send messages directly to the admin via email.

The UI is customized using pure CSS (without Tailwind), making it beginner-friendly and easy to understand.


## Features

- Floating support bubble (bottom-right)

- Contact form inside popup

- AJAX-based form submission (no page reload)

- Sends message to admin email

- Fully customized UI using CSS (no Tailwind)

- CSRF protection for secure requests

- Package-based integration (Spatie)

- Easy to customize and extend


## How It Works

1. The support bubble appears at the bottom-right of the screen.
2. When clicked, a popup form opens.
3. The user fills in the required details.
4. On submit, data is sent using AJAX (Fetch API).
5. Laravel validates the request and sends email to admin.
6. A success message is shown without page reload.



## Use Case

This project can be used in:

- Business websites for customer support

- Portfolio websites for contact form

- Admin support systems

- Beginner Laravel practice projects


## Technologies Used

- PHP 8.2+

- Laravel 12

- MySQL (Optional for database)

- JavaScript (Fetch API) – for AJAX form submission

- HTML5 & CSS3 – for custom UI design

- Composer – for package management

- Spatie Laravel Support Bubble Package



---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Support_Bubble "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Support_Bubble

```

#### Explanation:

Creates a fresh Laravel 12 project using Composer and moves into the project directory to start development.




## STEP 2: Database Setup (Optional)

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_Support_Bubble
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_Support_Bubble

```

### Then Run:

```
php artisan migrate

```


#### Explanation:

Configures the database connection in .env and runs migrations to create default Laravel tables.





## STEP 3: Install Spatie Support Bubble Package

### Install package:

```
composer require spatie/laravel-support-bubble

```

### Publish Config

```
php artisan vendor:publish --tag="support-bubble-config"

```

### config/support-bubble.php

```
return [

    'enabled' => true,

    'mail' => [
        'to' => 'admin@gmail.com',  // Change your gmail
    ],

    'color' => '#ff5722',

];

```

#### Explanation:

Installs the support bubble package and publishes its configuration file for customization.

Defines whether the bubble is enabled, the recipient email, and the UI color.





## STEP 4: Register Support Bubble Route 

### Edit: routes/web.php:

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportBubbleController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/support-bubble', [SupportBubbleController::class, 'submit'])
    ->name('supportBubble.submit');


```

#### Explanation:

Defines routes for loading the page and handling support form submissions.




## STEP 5: Create Controller

### Run:

```
php artisan make:controller SupportBubbleController

```

### Open: app/Http/Controllers/SupportBubbleController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportBubbleController extends Controller
{
    public function submit(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Send mail (simple)
        Mail::raw(
            "Name: {$request->name}\nEmail: {$request->email}\nSubject: {$request->subject}\nMessage: {$request->message}",
            function ($mail) {
                $mail->to('admin@gmail.com')
                     ->subject('Support Bubble Message');
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully'
        ]);
    }
}

```

#### Explanation:

Validates user input and sends the message via email using Laravel Mail.



## STEP 6: Publish Package Views

### Run:

```
php artisan vendor:publish --tag=support-bubble-views

```

### This creates:

```
resources/views/vendor/support-bubble/

```


### Open: resources/views/vendor/support-bubble/components/support-bubble.blade.php

```
<div id="support-bubble">

    <!-- Toggle Button -->
    <button id="bubble-btn">💬</button>

    <!-- Popup Form -->
    <div id="bubble-form">
        <h3>Contact Support</h3>

        <form id="supportForm">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="How can we help?" required></textarea>

            <button type="submit">Submit</button>
        </form>

        <p id="successMsg"></p>
    </div>

</div>

<style>
    #bubble-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #4f46e5;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
    }

    #bubble-form {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        background: #1f2937;
        padding: 15px;
        border-radius: 10px;
        display: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    #bubble-form h3 {
        margin-bottom: 10px;
        color: #fff;
    }

    #bubble-form input,
    #bubble-form textarea {
        width: 100%;
        margin-bottom: 10px;
        padding: 8px;
        border: none;
        border-radius: 5px;
    }

    #bubble-form button {
        width: 100%;
        padding: 10px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #successMsg {
        color: lightgreen;
        margin-top: 5px;
    }
</style>

<script>
    document.getElementById('bubble-btn').onclick = function () {
        let form = document.getElementById('bubble-form');
        form.style.display = form.style.display === 'block' ? 'none' : 'block';
    };

    document.getElementById('supportForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch('/support-bubble', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById('successMsg').innerText = "Message sent!";
                document.getElementById('supportForm').reset();
            })
            .catch(err => {
                document.getElementById('successMsg').innerText = "Error!";
            });
    });
</script>

```

#### Explanation:

Copies package views into your project so you can customize the UI without modifying vendor files.

This file contains the custom support bubble UI, including CSS styling and JavaScript for toggle and AJAX form submission.





## STEP 7: Add the Support Bubble to Layout

### resources/views/welcome.blade.php

```
<!DOCTYPE html>
<html>

<head>
    <title>Support Bubble</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            margin: 0;
            background: #111827;
            color: white;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            max-width: 600px;
        }
    </style>
</head>

<body>

    <div class="box">
        <h1>🚀 Welcome to Support Bubble</h1>
        <p>Click the bubble to contact support.</p>
    </div>

    <x-support-bubble />

</body>

</html>

```

#### Explanation:

Displays the main UI and includes the <x-support-bubble /> component to render the bubble on the page.





## STEP 8: Run the App

### Start dev server:

```
php artisan serve

```

### Open in browser:

```
http://127.0.0.1:8000

```

#### Explanation:

Starts the Laravel development server so you can test the application in the browser.

Loads the application where the support bubble appears at the bottom-right.




## Expected Output:


### Bubble Page:


<img src="screenshots/Screenshot 2026-03-17 112525.png" width="900">


### Send Message:


<img src="screenshots/Screenshot 2026-03-17 112831.png" width="900">

<img src="screenshots/Screenshot 2026-03-17 112851.png" width="900">


### Mail Received:


<img src="screenshots/Screenshot 2026-03-17 112936.png" width="900">



---

## Project Folder Structure:

```
PHP_Laravel12_Support_Bubble/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── SupportBubbleController.php    (Your custom controller)
│   │   │
│   │   └── Middleware/
│   │
│   └── Providers/
│       └── AppServiceProvider.php            (Route override added)
│
├── bootstrap/
│
├── config/
│   └── support-bubble.php                    (Published config file)
│
├── database/
│   ├── migrations/
│   └── factories/
│
├── public/
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php                (Main UI page)
│   │   │
│   │   └── vendor/
│   │       └── support-bubble/
│   │           └── components/
│   │               └── support-bubble.blade.php    (Custom CSS bubble UI)
│   │
│   ├── css/
│   └── js/
│
├── routes/
│   └── web.php                               (Route added)
│
├── storage/
│
├── vendor/                                   (Auto-generated by Composer)
│   └── spatie/
│       └── laravel-support-bubble/
│
├── .env                                      (Database config)
├── artisan
├── composer.json
├── package.json
└── README.md                                 (Your documentation)

```
