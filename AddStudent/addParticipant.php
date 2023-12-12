<?php
session_start();
date_default_timezone_set("Hongkong");
$time = date("H:i:s");
?>

<?php
require_once "../config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($_POST['student_number'] != "") {
    $sql = "SELECT * FROM students WHERE student_number='$_POST[student_number]'";
    if ($result = $mysqli->query($sql)) {
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $last_name = $row['last_name'];
          $first_name = $row['first_name'];
          $middle_initial = $row['middle_initial'];
          $student_number = $row['student_number'];
        }
        $result->free();

        if (isset($_GET['v']) && !empty(trim($_GET['v']))) {
          $v = trim($_GET['v']);

          $sql = "SELECT name FROM events WHERE v = ?";
          if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_v);

            $param_v = $v;

            if ($stmt->execute()) {
              $result = $stmt->get_result();

              if ($result->num_rows == 1) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $name = $row['name'];
              }
              $result->free();
            }
          }

          $sql = "INSERT INTO participants (last_name, first_name, middle_initial, student_number, time_in, event_name) VALUES ('$last_name', '$first_name', '$middle_initial', '$student_number', '$time', '$name');";
          if ($stmt = $mysqli->prepare($sql)) {
            if ($stmt->execute()) {
              // header("location: addParticipant.php?v=$v");
              // exit();
            } else {
              echo "Oops! Something went wrong. Please try again later.";
            }
          }
          // $stmt->close();
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Add Participants</title>
  <style>
    body {
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
    }

    #engineering-image {
      background: url('../scpes.png') center center no-repeat;
      background-size: cover;
      width: 100vw;
      height: 100vh;
      position: fixed;
      z-index: -1;
    }

    .wrapper {
      width: 80vw;
      margin: 0 auto;

    }

    ::-webkit-scrollbar {
      width: 0;
    }

    .col-md-6 {
      width: 100vw;
      margin: 0 auto;
    }

    ::-webkit-scrollbar {
      width: 0;
    }


    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
    }

    .col-md-12 {
      height: 90vh;
      overflow-y: auto;
    }

    .card {
      border: none;
      border-radius: 20px;

    }
  </style>
  <script>
    window.onload = function () {
      document.getElementById("student_number").focus();
    }
  </script>
</head>

<body>
  <div id="engineering-image"></div>
  <div class="wrapper">

    <div class="container-fluid d-flex justify-content-center">

      <div class="card mb-3">
        <div class="row no-gutters">
          <div class="col-md-5">
            <h4 class="card-header text-center">Register For Event</h4>
            <img class="card-img-top" src="../gcash_danao.jpg" alt="Card image cap"
              style="border-bottom-left-radius: 10px;">
          </div>
          <div class="col-md-7 d-flex align-items-center">
            <!-- FORM -->
            <!-- LEFT COLUMN -->
            <div class="card-body">
              <!-- FORM FOR STUDENT REGISTRATION -->
              <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"])); ?>" method="post">
                <div class="mb-3" style="font-size: 22px;">
                  <label for="" class="form-label">Student Number</label>
                  <input autofocus style="font-size: 28px;" type="text" name="student_number"
                    class="form-control <?php echo (!isset($last_name)) ? 'is-invalid' : ''; ?>" required
                    onkeyup="submittheform()" value="<?php if (isset($_POST['student_number']))
                      echo $_POST['student_number']; ?>">
                </div>
                <div class="d-flex justify-content-between mb-3 small">
                  <div style="font-size: 24px; color: black;">
                    <div class="cc">
                      <div class="dd">
                        <b>
                          <?php if (isset($last_name)) {
                            echo $last_name . ",";
                          } ?>
                          <?php if (isset($first_name)) {
                            echo $first_name;
                          } ?>
                          <?php if (isset($middle_initial)) {
                            echo $middle_initial . ".";
                          } ?>
                        </b>
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" name="register" class="btn btn-dark w-100 shadow-sm" value="Register">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    style="width:1.2rem; height:1.2rem">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                  </svg>
                  Register
                </button>
                <div>
                  <input class="btn btn-light w-100 shadow-sm mt-2" id="report" value="View All Attendees" type="button"
                    onclick="document.location.href='../ManageEvent/manageEvent.php?v=<?php echo trim($_GET['v']) ?>'">
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