<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify your Email Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container bg-white rounded p-4 shadow ">
        <h4>Registration Successful</h4>
        <hr>
        <h6>Thank you for registering.</h6>
        <p>User Details: </p>
        <ul>
            <li>Email: {{ $email }}</li>
            <li>Username: {{ $username }}</li>
        </ul> 

        <p>Please <a class="text-underlined" href="http://localhost:3000/verify/{{ $hash }}">Click Here</a> to confirm your email address.</p>
        Your account will be manually activated after being reviewed by an administrator.
        You will be notified by email once your account will become active.
        <br><br>
        <p>Best regards</p>
        <p><b>Bid2Cart</b></p>
    </div>
</body>

</html>
