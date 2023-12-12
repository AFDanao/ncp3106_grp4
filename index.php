<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    $defaultUsername = "admin";
    $defaultPassword = "admin";

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
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #engineering-image {
            background: url('scpes.png') center center no-repeat;
            background-size: cover;
            width: 100vw;
            height: 100vh;
            position: fixed;
            z-index: -1;
        }

        .container {
            width: 350px;
            height: auto;
            padding: 16px;
            background-color: #FAF9F6;
            border-radius: 10px;
            z-index: 1;
        }

        label {
            margin-bottom: 3px;
        }

        input[type=text],
        input[type=password] {
            margin-bottom: 20px;
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
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .logo-container {
            text-align: left;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            height: auto;
        }
    </style>
</head>

<body>
    <div id="engineering-image"></div>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="logo-container  d-flex justify-content-center">
                <img src="ue_logo.png" alt="Logo" class="logo">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" placeholder="Enter your password" name="password"
                        id="password" required>
                    <div class="input-group-append">
                        <span class="input-group-text password-eye" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label small-text" for="remember">Remember Me</label>
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-dark btn-block">Login</button>
            </div>

            <span>
                <?php echo $error ?>
            </span>
        </form>
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