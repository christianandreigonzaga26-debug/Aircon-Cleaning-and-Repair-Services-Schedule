<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Not Found</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f2;
            margin: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .not-found {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
        }

        .not-found h1 {
            margin-bottom: 10px;
        }

        .not-found p {
            color: #647166;
            margin-bottom: 25px;
        }

        .back-button {
            display: inline-block;
            padding: 12px 20px;
            background: #173b2e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-button:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <div class="not-found">

        <h1>Booking not found</h1>

        <p>
            This booking may have been deleted or does not exist.
        </p>

        <a href="/schedules" class="back-button">
            Back to Booking List
        </a>

    </div>

</body>

</html>