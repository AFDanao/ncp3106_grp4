<?php

require_once "../config.php";

$last_name = $first_name = $middle_initial = $student_number = $program = "";
$last_name_err = $first_name_err = $middle_initial_err = $program_err = "";

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

  $input_middle_initial = trim($_POST["middle_initial"]);
  if (!filter_var($input_middle_initial, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $middle_initial_err = "Please enter a valid character.";
  } else {
    $middle_initial = $input_middle_initial;
  }

  $input_program = trim($_POST["program"]);
  if (empty($input_program)) {
    $program_err = "Please select a program.";
  } else {
    $program = $input_program;
  }
  #TODO: FINISH THE EMAIL AUTHENTICATION 
  $input_email = trim($_POST["email"]);
  if (empty($input_email)) {
    $email_err = "Please enter an email.";
  } elseif (!) {

  } else {
    $email = $input_email;
  }

  if (empty($last_name_err) && empty($first_name_err) && empty($middle_initial_err) && empty($student_number_err) && empty($program_err) && empty($email_err)) {
    $sql = "INSERT INTO students (last_name, first_name, middle_initial, student_number, program, email) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("ssccss", $param_last_name, $param_first_name, $param_middle_initial, $param_student_number, $param_program, $param_email);

      $param_last_name = $last_name;
      $param_first_name = $first_name;
      $param_middle_initial = $middle_initial;
      $param_student_number = $student_number;
      $param_program = $program;
      $param_email = $email;

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
            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                  <span class="invalid-feedback"><?php echo $first_name_err ?></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>MI</label>
                  <input type="text" name="middle_initial" class="form-control <?php echo (!empty($middle_initial_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middle_initial; ?>">
                  <span class="invalid-feedback"><?php echo $middle_initial_err ?></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Student Number</label>
              <input type="number" name="student_number" class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $student_number; ?>">
              <span class="invalid-feedback"><?php echo $student_number_err ?></span>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Program</label>
                  <select class="form-select form-control <?php echo (!empty($program_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $program; ?>" required>
                    <option value="1">Civil Engineering</option>
                    <option value="2">Computer Engineering</option>
                    <option value="3">Electrical Engineering</option>
                    <option value="4">Mechanical Engineering</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $program_err ?></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                <label>Curr. Yr</label>
                  <select class="form-select form-control <?php echo (!empty($current_year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $current_year; ?>" required>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $current_year_err ?></span>
                </div>
              </div>
            </div>
            <div class="form-gorup">
              <label>UE E-mail Address</label>
              <input type="email" name="email" class="form-control <?php echo(!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
              <span class="invalid-feedback"><?php echo $email_err ?></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>