<?php

require_once "../config.php";

$last_name = $first_name = $middle_initial = $student_number = $program = $current_year = $email = $contact_number = $search = "";
$last_name_err = $first_name_err = $middle_initial_err = $student_number_err = $program_err = $current_year_err = $email_err = $contact_number_err = "";

if (isset($_POST["student_number"]) && !empty($_POST["student_number"])) {
  $st = $_POST["student_number"];

  $input_last_name = strtoupper(trim($_POST["last_name"]));
  if (empty($input_last_name)) {
    $last_name_err = "Please enter your last name.";
  } elseif (!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $last_name_err = "Please enter a valid name.";
  } else {
    $last_name = $input_last_name;
  }

  $input_first_name = strtoupper(trim($_POST["first_name"]));
  if (empty($input_first_name)) {
    $first_name_err = "Please enter your last first name.";
  } elseif (!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $first_name_err = "Please enter a valid name.";
  } else {
    $first_name = $input_first_name;
  }

  $input_middle_initial = strtoupper(trim($_POST["middle_initial"]));
  if (!filter_var($input_middle_initial, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-z A-Z\s]+$/"))) && !empty($input_middle_initial)) {
    $middle_initial_err = "Please enter a valid character.";
  } else {
    $middle_initial = $input_middle_initial;
  }

  $input_student_number = trim($_POST["student_number"]);
  if (empty($input_student_number)) {
    $student_number_err = "Please enter a student number.";
  } elseif ((strlen((string) $input_student_number) < 11) || (strlen((string) $input_student_number) > 11)) {
    $student_number_err = "Please input an 11 digit number.";
  } else {
    $student_number = $input_student_number;
  }

  $input_program = strtoupper(trim($_POST["program"]));
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

  $input_email = strtoupper(trim($_POST["email"]));
  if (empty($input_email)) {
    $email_err = "Please enter an email.";
  } elseif (!strpos($input_email, '@UE.EDU.PH', -10)) {
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

  // Check input errors before inserting in database
  if (empty($last_name_err) && empty($first_name_err) && empty($middle_initial_err) && empty($student_number_err) && empty($program_err) && empty($current_year_err) && empty($email_err)) {
    // Prepare an insert statement
    $sql = "UPDATE students SET last_name=?, first_name=?, middle_initial=?, student_number=?, program=?, current_year=?, email=?, contact_number=? WHERE student_number=?";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sssisssii", $param_last_name, $param_first_name, $param_middle_initial, $param_student_number, $param_program, $param_current_year, $param_email, $param_contact_number, $param_st);

      // Set parameters
      $param_last_name = strtoupper($last_name);
      $param_first_name = strtoupper($first_name);
      $param_middle_initial = strtoupper($middle_initial);
      $param_student_number = $student_number;
      $param_program = strtoupper($program);
      $param_current_year = $current_year;
      $param_email = strtoupper($email);
      $param_contact_number = $contact_number;
      $param_st = $st;

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Records created successfully. Redirect to landing page
        echo '<script>alert("Student Info Updated")</script>';
        header("location: manageStudent.php");
        // exit();
      } else {
        // header("location: ../select.php");
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    $stmt->close();
  }

  // // Close connection
  // $mysqli->close();
} else {
  if (isset($_GET["st"]) && !empty(trim($_GET["st"]))) {
    $student_number = trim($_GET["st"]);

    $sql = "SELECT * FROM students WHERE student_number = ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_student_number);

      $param_student_number = $student_number;

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $last_name = $row["last_name"];
          $first_name = $row["first_name"];
          $middle_initial = $row["middle_initial"];
          $program = $row["program"];
          $current_year = $row["current_year"];
          $email = $row["email"];
          $contact_number = $row["contact_number"];
        } else {
          echo "ERROR";
          exit();
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    $stmt->close();

    // $mysqli->close();
  }
}

if (isset($_POST['search'])) {
  $search = "";
  $search = trim($_POST['search']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Manage Students</title>
  <style>
    body {
      background-color: #FAF9F6;
    }

    .wrapper {
      width: 80vw;
      margin: 0 auto;
    }

    .col-md-6 {
      width: 450px;
      margin: 0 auto;
    }

    ::-webkit-scrollbar {
      width: 0;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
      max-height: 200px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
    }

    .fa {
      color: #343a40;
    }

    .nav-link .active {
      color: #343a40;
    }

    .nav-link {
      color: #6c757d;
    }

    .col-md-12 {
      height: 100vh;
      overflow-y: auto
    }
  </style>
  <script>
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltop();
    });
  </script>
</head>

<body>
  <div class="wrapper">
    <div class="row">
      <div class="col-md-6 asd">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="mt-5 mb-3 clearfix">
                <h2 class="pull-left">Student Details</h2>
              </div>
              <form action="" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" id="search" class="form-control" name="search"></div>
                  <div class="col-md-2"><input type="submit" class="btn btn-dark" value="Submit" /></div>
                </div>
              </form>
              <br>
              <?php
              require_once "../config.php";

              $sql = "SELECT * FROM students WHERE last_name like '%$search%' OR first_name LIKE '%$search%'OR current_year LIKE '%$search%' OR student_number LIKE '%$search%' ORDER BY last_name ASC";
              if ($result = $mysqli->query($sql)) {
                if ($result->num_rows > 0) {
                  echo "<table class='table table-bordered table-stiped'>";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Last Name</th>";
                  echo "<th>First Name</th>";
                  echo "<th>Year Level</th>";
                  echo "<th>Student Number</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['current_year'] . "</td>";
                    echo "<td>" . $row['student_number'] . "</td>";
                    echo "<td>";
                    echo '<a href="manageStudent.php?st=' . $row['student_number'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                    echo '<a href="deleteStudent.php?v=' . $row['student_number'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                    echo "</td>";
                    echo "</tr>";
                  }
                  echo "</tbody>";
                  echo "</table>";
                  $result->free();
                } else {
                  echo '<div class="alert alert-danger"><em>No records found.</em></div>';
                }
              } else {
                echo "Oops! Something went wrong. Please try again later.";
              }

              // $mysqli->close();
              ?>
              <a href="downloadStudents.php" class="btn btn-block btn-dark">Download Records</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 asd">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mt-5">Add Student</h2>
              <p>Please fill this form and submit to add students to the database</p>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" name="last_name"
                    class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?> bg-light"
                    value="<?php echo $last_name; ?>">
                  <span class="invalid-feedback">
                    <?php echo $last_name_err ?>
                  </span>
                </div>
                <div class="row">
                  <div class="col-md-9">
                    <div class="form-group">
                      <label>First Name</label>
                      <input type="text" name="first_name"
                        class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?> bg-light"
                        value="<?php echo $first_name; ?>">
                      <span class="invalid-feedback">
                        <?php echo $first_name_err ?>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>MI</label>
                      <input type="text" name="middle_initial"
                        class="form-control <?php echo (!empty($middle_initial_err)) ? 'is-invalid' : ''; ?> bg-light"
                        value="<?php echo $middle_initial; ?>">
                      <span class="invalid-feedback">
                        <?php echo $middle_initial_err ?>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Student Number</label>
                  <input type="number" name="student_number"
                    class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?> bg-light"
                    value="<?php echo $student_number; ?>" maxlength="11">
                  <span class="invalid-feedback">
                    <?php echo $student_number_err ?>
                  </span>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Program</label>
                      <select name="program"
                        class="form-select form-control <?php echo (!empty($program_err)) ? 'is-invalid' : ''; ?> bg-light"
                        value="<?php echo $program; ?>" required>
                        <option value="Computer">Computer Engineering</option>
                        <option value="Civil">Civil Engineering</option>
                        <option value="Electrical">Electrical Engineering</option>
                        <option value="Mechanical">Mechanical Engineering</option>
                      </select>
                      <span class="invalid-feedback">
                        <?php echo $program_err ?>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Curr. Yr</label>
                      <select name="current_year"
                        class="form-select form-control <?php echo (!empty($current_year_err)) ? 'is-invalid' : ''; ?> bg-light"
                        value="<?php echo $current_year; ?>" required>
                        <option value="1st">1st Year</option>
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                      </select>
                      <span class="invalid-feedback">
                        <?php echo $current_year_err ?>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>UE E-mail Address</label>
                  <input type="email" name="email"
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?> bg-light"
                    value="<?php echo $email; ?>">
                  <span class="invalid-feedback">
                    <?php echo $email_err ?>
                  </span>
                </div>
                <div class="form-group">
                  <label>Contact Number</label>
                  <div class="row">
                    <div class="col-md-1">
                      <span>+63</span>
                    </div>
                    <div class="col-md-11">
                      <input type="number" name="contact_number"
                        class="form-control <?php echo (!empty($contact_number_err)) ? 'is-invalid' : '' ?> bg-light"
                        value="<?php echo $contact_number; ?>">
                      <span class="invalid-feedback">
                        <?php echo $contact_number_err ?>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6 my-1"><input type="submit" value="Submit" class="btn btn-dark btn-block"></div>
                    <div class="col-md-6 my-1"><a href="../select.php" class="btn btn-secondary btn-block">Cancel</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>