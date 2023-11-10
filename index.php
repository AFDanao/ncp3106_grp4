<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <script>
        function validateLogin() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            // Check if the entered username and password match the default values
            if (username === "admin" && password === "admin") {
                alert("Login successful!");
            } else {
                alert("Invalid username or password. Please try again.");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter your username" name="username" id="username" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter your password" name="psw" id="password" required>

        <input type="checkbox" name="remember"> <span class="small-text">Remember Me</span>

        <button type="button" onclick="validateLogin()">Login</button>

        <a href="#" class="forgot-password">Forgot Password?</a>
    </div>
</body>
</html>
