<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter your username" name="username" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter your password" name="password" required>

            <input type="checkbox" name="remember"> <span class="small-text">Remember Me</span>

            <button type="submit">Login</button>
        </form>

        <a href="#" class="forgot-password">Forgot Password?</a>
    </div>
</body>
</html>
