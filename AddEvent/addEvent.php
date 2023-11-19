<?php
// Include config file
require_once "../config.php";

/* 
    EVENT CREATION 
    - Event ID - auto generated 
    - Event Name
    - Event desription
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
// Once another form is submitted it initializes empty values again
$name = $des = $type = $date = $start_time = $end_time = $venue = $fee = $officer = "";
$name_err = $des_err = $type_err = $date_err = $start_time_err = $end_time_err = $venue_err = $fee_err = $officer_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name (working)
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } else {
        $name = $input_name;
    }

    /*  $_POST["var"] - used to get data from variable with specified name using POST form method 
        trim() - removes unnecessary spaces from beginning and  end of string */
      // empty() - determines if variable is empty
      /* filter_var() - outputs false if it does not pass validation that's why we use logical NOT (!) for the condition to be true and execute its respective code
      */

    // Validate des (working)
    $input_des = trim($_POST["des"]);
    if (empty($input_des)) {
        $des_err = "Please enter a desription.";
    } else {
        $des = $input_des;
    }

    // Validate type (working)
    $input_type = trim($_POST["type"]);
    if (empty($input_type)){
      $type_err = "Please select a type.";
    } else{
      $type = $input_type;
    }

    // Validate date (working)
    $input_date = trim($_POST["date"]);
    if (empty($input_date)){
      $date_err = "Please enter the date.";
    } else {
      $date = $input_date;
    }

    // Validate start time (working)
    $input_start_time = trim($_POST["start_time"]);
    if (empty($input_start_time)){
      $start_time_err = "Please enter the start time.";
    } else{
      $start_time = $input_start_time;
    }

    // Validate start time (working)
    $input_end_time = trim($_POST["end_time"]);
    if (empty($input_end_time)){
      $end_time_err = "Please enter the end time.";
    } else{
      $end_time = $input_end_time;
    }

    // Validate venue
    $input_venue = trim($_POST["venue"]);
    if (empty($input_venue)) {
        $venue_err = "Please enter a venue.";
    } else {
        $venue = $input_venue;
    }

    // Validate fee (working)
    $input_fee = trim($_POST["fee"]);
    if (empty($input_fee)) {
        $fee_err = "Please enter the fee amount.";
    } elseif (!ctype_digit($input_fee)) {
      /*  ctype_digit() - is used to check if input are numeric; outputs false if it doesn't pass validation. For that reason, logical NOT (!) is used for the condition to be true */
        $fee_err = "Please enter a positive integer value.";
    } else {
        $fee = $input_fee;
    }

    // Validate officer (working)
    $input_officer = trim($_POST["officer"]);
    if (empty($input_officer)){
      $officer_err = "Please enter an officer name.";
    }elseif (!filter_var($input_officer, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
      $officer_err = "Please enter a valid name.";
    } else{
      $officer = $input_officer;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($des_err) && empty($type_err) && empty($date_err) && empty($start_time_err) && empty($end_time_err) && empty($venue_err) && empty($fee_err) && empty($officer_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO events (name, des, type, date, start_time, end_time, venue, fee, officer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssis", $param_name, $param_des, $param_type, $param_date, $param_start_time, $param_end_time, $param_venue, $param_fee, $param_officer);

            // Set parameters
            $param_name = $name;
            $param_des = $des;
            $param_type = $type;
            $param_date = $date;
            $param_start_time = $start_time;
            $param_end_time = $end_time;
            $param_venue = $venue;
            $param_fee = $fee;
            $param_officer = $officer;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: ../index.php");
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
            <h2 class="mt-5">Create Event</h2>
            <p>
            Please ensure that all data fields for the event are completed before submitting them for recording in the database.
            </p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <!-- Event Name -->
              <div class="form-group">
                <label>Event Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" >
                <!--  adds "is-invalid" class to the input if there is error (outlines the field red)  -->
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
              </div>

              <!-- Event desription -->
              <div class="form-group">
                <label>Event desription</label>
                <textarea
                  name="des"
                  class="form-control <?php echo (!empty($des_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $des; ?>"
                >
                </textarea>
                <span class="invalid-feedback"
                  ><?php echo $des_err; ?></span
                >
              </div>

              <!-- Event Type -->
              <label>Event Type</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Options</label>
                </div>
                <select class="custom-select form-control <?php echo (!empty($type_err)) ? 'is-invalid' : ''; ?>" id="inputGroupSelect01" name="type">
                  <option selected value="">Choose...</option>
                  <option value="Curricular">Curricular</option>
                  <option value="Extracurricular">Extracurricular</option>
                  <option value="Outreach">Outreach</option>
                  <option value="Others">Others</option>
                </select>
                <span class="invalid-feedback"><?php echo $type_err; ?></span>
              </div>

              <!-- Date of Event -->
              <div class="form-group">
                <label>Date of Event</label>
                <input class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" type="date" name="date" id="date" value="<?php echo $date; ?>"/>
                <span class="invalid-feedback"><?php echo $date_err; ?></span>
              </div>

              <!-- Start Time -->
              <div class="form-group">
                <label>Start Time</label>
                <input class="form-control <?php echo (!empty($start_time_err)) ? 'is-invalid' : ''; ?>"
                  type="time"
                  id="start_time"
                  name="start_time"
                  min="09:00"
                  max="18:00"
                  value="<?php echo $start_time; ?>"
                />
                <span class="invalid-feedback"><?php echo $start_time_err ?></span>
              </div>

              <!-- End Time -->
              <div class="form-group">
                <label>End Time</label>
                <input class="form-control <?php echo (!empty($end_time_err)) ? 'is-invalid' : ''; ?>"
                  type="time"
                  id="end_time"
                  name="end_time"
                  min="09:00"
                  max="18:00"
                  value="<?php echo $end_time; ?>"
                />
                <span class="invalid-feedback"><?php echo $end_time_err ?></span>
              </div>

              <!-- Venue -->
              <div class="form-group">
                <label>Venue</label>
                <input
                  type="text"
                  name="venue"
                  class="form-control <?php echo (!empty($venue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" >
                <span class="invalid-feedback"><?php echo $venue_err; ?></span>
              </div>

              <!-- Registration Fee -->
              <div class="form-group">
                <label>Registration Fee</label>
                <input
                  type="number"
                  name="fee"
                  class="form-control <?php echo (!empty($fee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fee; ?>"
                />
                <span class="invalid-feedback"><?php echo $fee_err; ?></span>
              </div>

              <!-- Officer-In-Charge -->
              <div class="form-group">
                <label>Officer-In-Charge</label>
                <input
                  type="text"
                  name="officer"
                  class="form-control <?php echo (!empty($officer_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $officer; ?>"
                />
                <span class="invalid-feedback"><?php echo $officer_err; ?></span>
              </div>

            <!-- Submit Button -->
              <input type="submit" class="btn btn-primary" value="Submit" />
              <a href="../select.php" class="btn btn-secondary ml-2">Cancel</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
