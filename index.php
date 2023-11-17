<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username and password from the form
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Define the default username and password
    $defaultUsername = "admin";
    $defaultPassword = "admin";

    $error = "";

    // Check if the entered username and password match the default values
    if ($enteredUsername === $defaultUsername && $enteredPassword === $defaultPassword) {
        header('Location: select.php');
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="login.css"> -->
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter your username" name="username" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter your password" name="password" required>

            <input type="checkbox" name="remember"> <span class="small-text">Remember Me</span>

            <button type="submit">Login</button>
            <span><?php echo $error ?></span>
        </form>
    </div>
</body>
</html>
