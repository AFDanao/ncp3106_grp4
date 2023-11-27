<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username and password from the form
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Define the default username and password
    $defaultUsername = "admin";
    $defaultPassword = "admin";

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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 300px;
            padding: 16px;
            background-color: white;
            box-sizing: border-box;
            text-align: left;
            border-radius: 10px; 
        }

        label {
            display: block;
            margin-bottom: 3px;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        input[type=checkbox] {
            margin-bottom: 11px;
        }

        button {
            background-color: black;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }

        button:hover {
            opacity: 0.8;
        }

        .forgot-password {
            color: #333;
            text-decoration: none;
            font-size: small;
            display: block;
            margin-top: 5px;
            text-align: right;
        }

        .small-text {
            font-size: small;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label small-text" for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <span><?php echo $error ?></span>
        </form>
    </div>
</body>
</html>
