<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <form action="proses_register.php" method="POST">
        <h2>Register</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</body>

</html>