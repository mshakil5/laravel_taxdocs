<!DOCTYPE html>
<html>
<head>
    <title>Your Account Has Been Created</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Your account has been created successfully.</p>
    <p>Accountant Firm Name: {{ $firm->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Phone: {{ $user->phone }}</p>
    <p>Password: 123456</p>
    <p>You can log in and change your password from <a href="https://www.taxdocs.co.uk/login">this link</a>.</p>
</body>
</html>
