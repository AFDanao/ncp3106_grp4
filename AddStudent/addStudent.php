<?php

require_once "../config.php";

$last_name = $first_name = $middle_initial = $student_number = $program = $current_year = $email = $contact_number = "";
$last_name_err = $first_name_err = $middle_initial_err = $student_number_err = $program_err = $current_year_err = $email_err = $contact_number_err = "";

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
  if (!filter_var($input_middle_initial, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-z A-Z\s]+$/"))) && !empty($input_middle_initial)) {
    $middle_initial_err = "Please enter a valid character.";
  } else {
    $middle_initial = $input_middle_initial;
  }

  $input_student_number = trim($_POST["student_number"]);
  if (empty($input_student_number)) {
    $student_number_err = "Please enter a student number.";
  } elseif ((strlen((string)$input_student_number) < 11) || (strlen((string)$input_student_number) > 11)) {
    $student_number_err = "Please input an 11 digit number.";
  } else {
    $student_number = $input_student_number;
  }

  $input_program = trim($_POST["program"]);
  if (empty($input_program)) {
    $program_err = "Please select a program.";
  } else {
    $program = $input_program;
  }

  $input_current_year = trim($_POST["current_year"]);
  if (empty($input_current_year)) {
    $current_year_err = "Please select a program.";
  } else {
    $current_year = $input_current_year;
  }

  $input_email = trim($_POST["email"]);
  if (empty($input_email)) {
    $email_err = "Please enter an email.";
  } elseif (!strpos($input_email, '@ue.edu.ph', -10)) {
    $email_err = "Please enter a valid UE Email.";
  } else {
    $email = $input_email;
  }

  $input_contact_number = trim($_POST["contact_number"]);
  if (empty($input_contact_number)) {
    $contact_number_err = "Please enter your contact number.";
  } else {
    $contact_number = $input_contact_number;
  }

  if (empty($last_name_err) && empty($first_name_err) && empty($middle_initial_err) && empty($student_number_err) && empty($program_err) && empty($email_err) && empty($contact_number_err)) {
    $sql = "INSERT INTO students (last_name, first_name, middle_initial, student_number, program, current_year, email, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("sssisssi", $param_last_name, $param_first_name, $param_middle_initial, $param_student_number, $param_program, $param_current_year, $param_email, $param_contact_number);

      $param_last_name = $last_name;
      $param_first_name = $first_name;
      $param_middle_initial = $middle_initial;
      $param_student_number = $student_number;
      $param_program = $program;
      $param_current_year = $current_year;
      $param_email = $email;
      $param_contact_number = $contact_number;

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
  <title>Add Students</title>
  <style>
    body {
      background-color: #f4f4f4;
      /* overflow: hidden; */
    }

    .wrapper {
      width: 600px;
      margin: 0 auto;
    }

    .ast {
      color: rgba(255, 0, 0, 100);
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
              <label>Last Name<span class="ast">*</span></label>
              <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $last_name; ?>">
              <span class="invalid-feedback"><?php echo $last_name_err ?></span>
            </div>
            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                  <label>First Name<span class="ast">*</span></label>
                  <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $first_name; ?>">
                  <span class="invalid-feedback"><?php echo $first_name_err ?></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>MI</label>
                  <input type="text" name="middle_initial" class="form-control <?php echo (!empty($middle_initial_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $middle_initial; ?>">
                  <span class="invalid-feedback"><?php echo $middle_initial_err ?></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Student Number<span class="ast">*</span></label>
              <input type="number" name="student_number" class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $student_number; ?>" maxlength="11">
              <span class="invalid-feedback"><?php echo $student_number_err ?></span>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Program<span class="ast">*</span></label>
                  <select name="program" class="form-select form-control <?php echo (!empty($program_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $program; ?>" required>
                    <option value="Civil">Civil Engineering</option>
                    <option value="Computer">Computer Engineering</option>
                    <option value="Electrical">Electrical Engineering</option>
                    <option value="Mechanical">Mechanical Engineering</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $program_err ?></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Curr. Yr<span class="ast">*</span></label>
                  <select name="current_year" class="form-select form-control <?php echo (!empty($current_year_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $current_year; ?>" required>
                    <option value="1st">1st Year</option>
                    <option value="2nd">2nd Year</option>
                    <option value="3rd">3rd Year</option>
                    <option value="4th">4th Year</option>
                  </select>
                  <span class="invalid-feedback"><?php echo $current_year_err ?></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>UE E-mail Address<span class="ast">*</span></label>
              <input type="email" name="email" class="form-control <?php echo(!empty($email_err)) ? 'is-invalid' : ''; ?> bg-light" value="<?php echo $email; ?>">
              <span class="invalid-feedback"><?php echo $email_err ?></span>
            </div>
            <div class="form-group">
              <label>Contact Number<span class="ast">*</span></label>
              <div class="row">
                <div class="col-md-1">
                  <span>+63</span>
                </div>
                <div class="col-md-11">
                  <input type="number" name="contact_number" class="form-control <?php echo(!empty($contact_number_err)) ? 'is-invalid' : '' ?> bg-light" value="<?php echo $contact_number; ?>">
                  <span class="invalid-feedback"><?php echo $contact_number_err ?></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6"><input type="submit" value="Submit" class="btn btn-primary btn-block"></div>
                <div class="col-md-6"><a href="../select.php" class="btn btn-secondary btn-block">Cancel</a></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>