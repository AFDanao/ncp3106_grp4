<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username and password from the form
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Define the default username and password
    $defaultUsername = "admin";
    $defaultPassword = "admin";

    // Check if the entered username and password match the default values
    if ($enteredUsername === $defaultUsername && $enteredPassword === $defaultPassword) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password. Please try again.";
    }
}
?>
