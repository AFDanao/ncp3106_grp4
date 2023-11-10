<?php
// Include config file
require_once "config.php";

/* 
    EVENT CREATION 
    - Event ID - auto generated 
    - Event Name
    - Event Description
    - Event Type (Curricular, Extracurricular, Outreach, Others)
    - Date
    - Start Time
    - End Time
    - Registreation Fee
    - Venue
    - Officer-In-Charge
    - Other needed fields
*/ 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)) {
        $salary_err = "Please enter the salary amount.";
    } elseif (!ctype_digit($input_salary)) {
        $salary_err = "Please enter a positive integer value.";
    } else {
        $salary = $input_salary;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($address_err) && empty($salary_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_name, $param_address, $param_salary);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create Record</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
            <h2 class="mt-5">Create Record</h2>
            <p>
              Please fill this form and submit to add employee record to the
              database.
            </p>
            <!--<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">-->
            <form>
              " method="post">
              <div class="form-group">
                <label>Event Name</label>
                <input
                  type="text"
                  name="name"
                  class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                  value="Enter Event Name"
                  required
                />
                <!-- add inside input later:
                  value="<?php echo $name; ?>" 
                -->
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
              </div>
              <div class="form-group">
                <label>Event Description</label>
                <textarea
                  name="address"
                  class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"
                  required
                >
                </textarea>
                <!--add inside text area later:
                  <?php echo $address; ?>
                -->
                <span class="invalid-feedback"
                  ><?php echo $address_err; ?></span
                >
              </div>
              <label>Event Type</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01"
                    >Options</label
                  >
                </div>
                <select class="custom-select" id="inputGroupSelect01">
                  <option selected>Choose...</option>
                  <option value="1">Curricular</option>
                  <option value="2">Extracurricular</option>
                  <option value="3">Outreach</option>
                  <option value="4">Others</option>
                </select>
              </div>
              <div class="form-group">
                <label>Date of Event</label>
                <input type="date" name="date" id="date" required />
              </div>
              <div class="form-group">
                <label>Start Time</label>
                <input
                  type="time"
                  id="appt"
                  name="appt"
                  min="09:00"
                  max="18:00"
                  required
                />
              </div>
              <div class="form-group">
                <label>End Time</label>
                <input
                  type="time"
                  id="appt"
                  name="appt"
                  min="09:00"
                  max="18:00"
                  required
                />
              </div>
              <div class="form-group">
                <label>Venue</label>
                <input
                  type="text"
                  name="name"
                  class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                  value="Enter Event Name"
                />
                <!-- add inside input later:
                  value="<?php echo $name; ?>" 
                -->
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
              </div>
              <div class="form-group">
                <label>Registration Fee</label>
                <input
                  type="text"
                  name="salary"
                  class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>"
                /><!-- add in input later
                  value="<?php echo $salary; ?>"-->
                <span class="invalid-feedback"><?php echo $salary_err; ?></span>
              </div>
              <div class="form-group">
                <label>Officer-In-Charge</label>
                <input
                  type="text"
                  name="name"
                  class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                  value="Enter Event Name"
                />
                <!-- add inside input later:
                  value="<?php echo $name; ?>" 
                -->
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
              </div>
              <!--<div class="form-group">
                <label>Salary</label>
                <input
                  type="text"
                  name="salary"
                  class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>"
                  value="<?php echo $salary; ?>"
                />
                <span class="invalid-feedback"><?php echo $salary_err; ?></span>
              </div>-->
              <input type="submit" class="btn btn-primary" value="Submit" />
              <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
