<?php

require_once "../config.php";

$name = $des = $type = $date = $start_time = $end_time = $venue = $fee = $officer = $v = $search = "";
$name_err = $des_err = $type_err = $date_err = $start_time_err = $end_time_err = $venue_err = $fee_err = $officer_err = "";

if (isset($_POST["v"]) && !empty($_POST["v"])) {
  $v = $_POST["v"];

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
  if (empty($input_type)) {
    $type_err = "Please select a type.";
  } else {
    $type = $input_type;
  }

  $input_date = trim($_POST["date"]);
  if (empty($input_date)) {
    $date_err = "Please enter the date.";
  } else {
    $date = $input_date;
  }

  $input_start_time = trim($_POST["start_time"]);
  if (empty($input_start_time)) {
    $start_time_err = "Please enter the start time.";
  } else {
    $start_time = $input_start_time;
  }

  $input_end_time = trim($_POST["end_time"]);
  if (empty($input_end_time)) {
    $end_time_err = "Please enter the end time.";
  } else {
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
  if (empty($input_officer)) {
    $officer_err = "Please enter an officer name.";
  } elseif (!filter_var($input_officer, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
    $officer_err = "Please enter a valid name.";
  } else {
    $officer = $input_officer;
  }

  // Check input errors before inserting in database
  if (empty($name_err) && empty($des_err) && empty($type_err) && empty($date_err) && empty($start_time_err) && empty($end_time_err) && empty($venue_err) && empty($fee_err) && empty($officer_err)) {
    // Prepare an insert statement
    $sql = "UPDATE events SET name=?, des=?, type=?, date=?, start_time=?, end_time=?, venue=?, fee=?, officer=? WHERE v=?";

    if ($stmt = $mysqli->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("sssssssiss", $param_name, $param_des, $param_type, $param_date, $param_start_time, $param_end_time, $param_venue, $param_fee, $param_officer, $param_v);

      // Set parameters
      $param_name = strtoupper($name);
      $param_des = $des;
      $param_type = strtoupper($type);
      $param_date = $date;
      $param_start_time = $start_time;
      $param_end_time = $end_time;
      $param_venue = strtoupper($venue);
      $param_fee = $fee;
      $param_officer = strtoupper($officer);
      $param_v = $v;

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
  if (isset($_GET["v"]) && !empty(trim($_GET["v"]))) {
    $v = trim($_GET["v"]);

    $sql = "SELECT * FROM events WHERE v = ?";
    if ($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("s", $param_v);

      $param_v = $v;

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <title>Manage Event</title>
  <style>
    body {
      background-color: #FAF9F6;
      height:
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
      overflow-y: auto;
    }
  </style>
  <script>
    $(document).ready(function () {
      $('[data-toggle="tooltip"]').tooltip();
      $('#events_table').DataTable({
        dom: "Bfrtip",
        buttons: [
          'copy', 'csv', 'excel', 'print'
        ]
      });
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
              <ul class="nav nav-tabs nav-fill">
                <li class="nav-item nav-dark">
                  <a href="#events" class="nav-link active" data-bs-toggle="tab">Events</a>
                </li>
                <li class="nav-item">
                  <a href="#participants" class="nav-link" data-bs-toggle="tab">Participants</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="events">
                  <br>
                  <form action="" method="post">
                    <div class="row">
                      <div class="col-md-10"><input type="text" id="search" class="form-control" name="search"></div>
                      <div class="col-md-2"><input type="submit" class="btn btn-dark" value="Submit" /></div>
                    </div>
                  </form>
                  <br>
                  <?php
                  require_once "../config.php";
                  $sql = "SELECT * FROM events WHERE id LIKE '%$search%' OR name LIKE '%$search%' OR des LIKE '%$search%' OR officer LIKE '%$search%' ORDER BY events . id ASC";
                  if ($result = $mysqli->query($sql)) {
                    if ($result->num_rows > 0) {
                      echo "<table class='table table-bordered table-stiped'>";
                      echo "<thead>";
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
                        echo '<a href="manageEvent.php?v=' . $row['v'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                        echo '<a href="deleteEvent.php?v=' . $row['v'] . '" class="mr-3" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                        echo '<a href="downloadEvent.php?v=' . $row['v'] . '" class="mr-3" title="Download Record" data-toggle="tooltip"><span class="fa fa-download"></span></a>';
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
                <div class="tab-pane fade" id="participants">
                  <br>
                  <form action="report.php" method="post">
                    <center>
                      <button type="button" name="register" class="btn btn-light w-100 shadow-sm" value="Home"
                        onclick="document.location.href='../AddStudent/addParticipant.php?v=<?php echo $v ?>'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                          style="widt:1.2rem; height:1rem;">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Register
                      </button>
                    </center>
                    <br>
                  </form>

                  <?php
                  require_once "../config.php";

                  $sql = "SELECT * FROM participants WHERE event_name='$name' ORDER BY time_in";
                  if ($result = $mysqli->query($sql)) {
                    if ($result->num_rows > 0) {
                      echo "<table class='table table-bordered'>";
                      echo "<thead>";
                      echo "<tr>";
                      echo "<th>Last Name</th>";
                      echo "<th>First Name</th>";
                      echo "<th>Middle Initial</th>";
                      echo "<th>Student Number</th>";
                      echo "<th>Time In</th>";
                      echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['middle_initial'] . "</td>";
                        echo "<td>" . $row['student_number'] . "</td>";
                        echo "<td>" . $row['time_in'] . "</td>";
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
        </div>
      </div>
      <div class="col-md-6">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="mt-5 mb-3 clearfix">
                <h2 class="pull-left">Edit Event</h2>
              </div>
              <p>Please ensure that all data fields for the event are completed before submitting them for recording in
                the database.</p>
              <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                <div class="form-group">
                  <label>Event Name</label>
                  <input type="text" name="name"
                    class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $name; ?>">
                  <!--  adds "is-invalid" class to the input if there is error (outlines the field red)  -->
                  <span class="invalid-feedback">
                    <?php echo $name_err; ?>
                  </span>
                </div>

                <!-- Event desription -->
                <div class="form-group">
                  <label>Event Description</label>
                  <textarea name="des" class="form-control <?php echo (!empty($des_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $des; ?>"><?php echo $des; ?></textarea>
                  <span class="invalid-feedback">
                    <?php echo $des_err; ?>
                  </span>
                </div>

                <!-- Event Type -->
                <label>Event Type <span class="text-muted">(Currently Selected:
                    <?php echo $type; ?>)
                  </span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                  </div>
                  <select class="custom-select form-control <?php echo (!empty($type_err)) ? 'is-invalid' : ''; ?>"
                    id="inputGroupSelect01" name="type">
                    <option selected value="<?php echo $type; ?>">Choose...</option>
                    <option value="Curricular">Curricular</option>
                    <option value="Extracurricular">Extracurricular</option>
                    <option value="Outreach">Outreach</option>
                    <option value="Others">Others</option>
                  </select>
                  <span class="invalid-feedback">
                    <?php echo $type_err; ?>
                  </span>
                </div>

                <!-- Date of Event -->
                <div class="form-group">
                  <label>Date of Event</label>
                  <input class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" type="date"
                    name="date" id="date" value="<?php echo $date; ?>" />
                  <span class="invalid-feedback">
                    <?php echo $date_err; ?>
                  </span>
                </div>

                <!-- Start Time -->
                <div class="form-group">
                  <label>Start Time</label>
                  <input class="form-control <?php echo (!empty($start_time_err)) ? 'is-invalid' : ''; ?>" type="time"
                    id="start_time" name="start_time" min="09:00" max="18:00" value="<?php echo $start_time; ?>" />
                  <span class="invalid-feedback">
                    <?php echo $start_time_err ?>
                  </span>
                </div>

                <!-- End Time -->
                <div class="form-group">
                  <label>End Time</label>
                  <input class="form-control <?php echo (!empty($end_time_err)) ? 'is-invalid' : ''; ?>" type="time"
                    id="end_time" name="end_time" min="09:00" max="18:00" value="<?php echo $end_time; ?>" />
                  <span class="invalid-feedback">
                    <?php echo $end_time_err ?>
                  </span>
                </div>

                <!-- Venue -->
                <div class="form-group">
                  <label>Venue</label>
                  <input type="text" name="venue"
                    class="form-control <?php echo (!empty($venue_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $name; ?>">
                  <span class="invalid-feedback">
                    <?php echo $venue_err; ?>
                  </span>
                </div>

                <!-- Registration Fee -->
                <div class="form-group">
                  <label>Registration Fee</label>
                  <input type="number" name="fee"
                    class="form-control <?php echo (!empty($fee_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $fee; ?>" />
                  <span class="invalid-feedback">
                    <?php echo $fee_err; ?>
                  </span>
                </div>

                <!-- Officer-In-Charge -->
                <div class="form-group">
                  <label>Officer-In-Charge</label>
                  <input type="text" name="officer"
                    class="form-control <?php echo (!empty($officer_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $officer; ?>" />
                  <span class="invalid-feedback">
                    <?php echo $officer_err; ?>
                  </span>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6 my-1"><input type="submit" class="btn btn-dark btn-block" value="Submit" />
                    </div>
                    <div class="col-md-6 my-1"><a href="../select.php" class="btn btn-secondary btn-block">Cancel</a>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="v" value=<?php echo $v; ?>>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>