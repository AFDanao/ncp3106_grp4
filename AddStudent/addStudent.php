<?php

require_once "../config.php";

$last_name = $first_name = "";
$last_name_err = $first_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $input_last_name = trim($_POST["last_name"]);
  if (empty($input_last_name)) {
    $last_name_err = "Please enter your last name.";
  } elseif (!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $last_name_err = "Please enter a valid name.";
  } else {
    $last_name = $input_last_name;
  }

  $input_first_name = trim($_POST["first_name"]);
  if (empty($input_first_name)) {
    $first_name_err = "Please enter your last first name.";
  } elseif (!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $first_name_err = "Please enter a valid name.";
  } else {
    $first_name = $input_first_name;
  }

  if (empty($last_name_err) && empty($first_name_err)) {
    $sql = "INSERT INTO students (last_name, first_name) VALUES (?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("ss", $param_last_name, $param_first_name);

      $param_last_name = $last_name;
      $param_first_name = $first_name;

      if ($stmt->execute()) {
        header("location: index.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    $stmt->close();
  }

  $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Document</title>
  <style>
    .wrapper {
      width: 600px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h2 class="mt-5">Add Student</h2>
          <p>Please fill this form and submit to add students to the database</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
              <span class="invalid-feedback"><?php echo $last_name_err ?></span>
            </div>
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
              <span class="invalid-feedback"><?php echo $first_name_err ?></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>