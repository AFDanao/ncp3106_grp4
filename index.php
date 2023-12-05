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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background-image: linear-gradient(#ffffff, #ff9900);
            margin: 0;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 400px; /* Adjust the width as needed */
            padding: 16px;
            background-color: white;
            border-radius: 10px; 
        }

        label {
            margin-bottom: 3px;
        }

        input[type=text],
        input[type=password] {
            margin-bottom: 10px;
        }

        button {
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            opacity: 0.8;
        }

        .password-eye {
            position: absolute;
            right: 1px;
            top: 55%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .img-container {
            width: 1000px; /* Adjust the width as needed */
            max-width: 100%;
            margin-right: auto; /* Adjust the margin as needed */
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-container">
                    <img src="engineering.png" alt="Engineering Image" class="img-fluid">
                </div>
            </div>

            <div class="col-md-6">
                <div class="container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Enter your password" name="password" id="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text password-eye" onclick="togglePasswordVisibility()">
                                        <i id="eye-icon" class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label small-text" for="remember">Remember Me</label>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-dark btn-block">Login</button>
                        </div>
                        
                        <span><?php echo $error ?></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
