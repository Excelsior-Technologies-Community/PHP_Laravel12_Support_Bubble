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