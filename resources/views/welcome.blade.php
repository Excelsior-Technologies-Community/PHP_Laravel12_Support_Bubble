<!DOCTYPE html>
<html>

<head>

    <title>Advanced Support Bubble</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{

            height:100vh;

            background:
            linear-gradient(
                135deg,
                #0f172a,
                #1e293b,
                #111827
            );

            display:flex;

            justify-content:center;

            align-items:center;

            color:white;

            overflow:hidden;
        }

        .container{

            text-align:center;

            max-width:750px;

            padding:20px;
        }

        .container h1{

            font-size:60px;

            margin-bottom:20px;

            line-height:1.2;

            background:linear-gradient(90deg,#60a5fa,#a78bfa);

            -webkit-background-clip:text;

            -webkit-text-fill-color:transparent;
        }

        .container p{

            color:#cbd5e1;

            font-size:18px;

            line-height:1.8;

            margin-bottom:30px;
        }

        .btn{

            display:inline-block;

            padding:15px 30px;

            border-radius:12px;

            text-decoration:none;

            background:linear-gradient(135deg,#2563eb,#7c3aed);

            color:white;

            font-weight:600;

            transition:0.3s;
        }

        .btn:hover{

            transform:translateY(-3px);
        }

    </style>

</head>

<body>

    <div class="container">

        <h1>
            🚀 Advanced Laravel Support Bubble
        </h1>

        <p>

            A modern customer support system with floating support chat,
            AJAX messaging, admin dashboard, status management,
            and premium responsive UI built using Laravel 12.

        </p>

        <a href="/admin/support-messages"
           class="btn">

           Open Admin Dashboard

        </a>

    </div>

    <x-support-bubble />

</body>

</html>