<?php

require_once "../config.php";

$name = $des = $type = $date = $start_time = $end_time = $venue = $fee = $officer = $id = "";
$name_err = $des_err = $type_err = $date_err = $start_time_err = $end_time_err = $venue_err = $fee_err = $officer_err = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
  $id = $_POST["id"];

  $input_name = trim($_POST["name"]);
  if (empty($input_name)) {
    $name_err = "Please enter a name.";
  } else {
    $name = $input_name;
  }

  $input_des = trim($_POST["des"]);
  if (empty($input_des)) {
    $des_err = "Please enter a desription.";
  } else {
    $des = $input_des;
  }

  $input_type = trim($_POST["type"]);
  if (empty($input_type)){
    $type_err = "Please select a type.";
  } else{
    $type = $input_type;
  }

  $input_date = trim($_POST["date"]);
  if (empty($input_date)){
    $date_err = "Please enter the date.";
  } else {
    $date = $input_date;
  }

  $input_start_time = trim($_POST["start_time"]);
  if (empty($input_start_time)){
    $start_time_err = "Please enter the start time.";
  } else{
    $start_time = $input_start_time;
  }

  $input_end_time = trim($_POST["end_time"]);
  if (empty($input_end_time)){
    $end_time_err = "Please enter the end time.";
  } else{
    $end_time = $input_end_time;
  }

  $input_venue = trim($_POST["venue"]);
  if (empty($input_venue)) {
    $venue_err = "Please enter a venue.";
  } else {
    $venue = $input_venue;
  }

  $input_fee = trim($_POST["fee"]);
  if (empty($input_fee)) {
    $fee_err = "Please enter the fee amount.";
  } elseif (!ctype_digit($input_fee)) {
    $fee_err = "Please enter a positive integer value.";
  } else {
    $fee = $input_fee;
  }

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
    $sql = "UPDATE events SET name=?, des=?, type=?, date=?, start_time=?, end_time=?, venue=?, fee=?, officer=? WHERE id=?";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sssssssisi", $param_name, $param_des, $param_type, $param_date, $param_start_time, $param_end_time, $param_venue, $param_fee, $param_officer, $param_id);

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
      $param_id = $id;

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Records created successfully. Redirect to landing page
        header("location: manageEvent.php");
        exit();
      } else {
        // header("location: ../select.php");
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    $stmt->close();
  }

  // Close connection
  $mysqli->close();
} else {
  if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    $sql = "SELECT * FROM events WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("i", $param_id);

      $param_id = $id;

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows==1) {
          $row = $result->fetch_array(MYSQLI_ASSOC);

          $name = $row["name"];
          $des = $row["des"];
          $type = $row["type"];
          $date = $row["date"];
          $start_time = $row["start_time"];
          $end_time = $row["end_time"];
          $venue = $row["venue"];
          $fee = $row["fee"];
          $officer = $row["officer"];
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
  <title>Manage Event</title>
  <style>
    body {
      background-color: #f4f4f4;
    }

    .wrapper {
      width: 900px;
      margin: 0 auto;
    }

    .col-md-6 {
      width: 450px;
      margin: 0 auto;
    }

    ::-webkit-scrollbar {
      width: 0;
    }
  </style>
  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltop();
    });
  </script>
</head>
<body>
  <div class="wrapper">
    <div class="row">
      <div class="col-md-6">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="mt-5 mb-3 clearfix">
                <h2 class="pull-left">Event Details</h2>
              </div>
              <?php
                require_once "../config.php";

                $sql = "SELECT * FROM events";
                if ($result = $mysqli->query($sql)) {
                  if ($result->num_rows > 0) {
                    echo "<table class='table table-bordered table-stiped'>";
                    echo "<thread>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Name</th>";
                    echo "<th>Description</th>";
                    echo "<th>Officer</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['id'] . "</td>";
                      echo "<td>" . $row['name'] . "</td>";
                      echo "<td>" . $row['des'] . "</td>";
                      echo "<td>" . $row['officer'] . "</td>";
                      echo "<td>";
                      echo '<a href="manageEvent.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                      echo '<a href="manageEvent.php?id=' . $row['id'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="mt-5 mb-3 clearfix">
                <h2 class="pull-left">Edit Event</h2>
              </div>
              <p>Please ensure that all data fields for the event are completed before submitting them for recording in the database.</p>
              <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                <div class="form-group">
                  <label>Event Name</label>
                  <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" >
                  <!--  adds "is-invalid" class to the input if there is error (outlines the field red)  -->
                  <span class="invalid-feedback"><?php echo $name_err; ?></span>
                </div>

                <!-- Event desription -->
                <div class="form-group">
                  <label>Event Description</label>
                  <textarea
                    name="des"
                    class="form-control <?php echo (!empty($des_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $des; ?>"
                  ></textarea>
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
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6"><input type="submit" class="btn btn-primary btn-block" value="Submit" /></div>
                    <div class="col-md-6"><a href="../select.php" class="btn btn-secondary btn-block">Cancel</a></div>
                  </div>
                </div>
                <input type="hidden" name="id" value=<?php echo $id; ?>>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>