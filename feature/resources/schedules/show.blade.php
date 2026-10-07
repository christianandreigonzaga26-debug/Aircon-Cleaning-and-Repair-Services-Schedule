<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Details</title>
</head>

<body>

    <h1>Booking Details</h1>

    <p>
        <strong>Customer Name:</strong>
        {{ $schedule->customer_name }}
    </p>

    <p>
        <strong>Phone:</strong>
        {{ $schedule->phone }}
    </p>

    <p>
        <strong>Service:</strong>
        {{ $schedule->service_type }}
    </p>

    <p>
        <strong>Schedule Date:</strong>
        {{ $schedule->schedule_date }}
    </p>

    <p>
        <strong>Notes:</strong>
        {{ $schedule->notes }}
    </p>

    <a href="/schedules">
        Back to Booking List
    </a>

</body>

</html>