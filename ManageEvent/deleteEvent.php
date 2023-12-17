<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Delete Event</title>
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
          <h2 class="mt-5 mb-3">Delete Event</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
              <input type="hidden" name="v" value="<?php echo trim($_GET["v"]); ?>">
              <p>Are you sure you want to delete this event record?</p>
              <p>
                <input type="submit" value="Yes" class="btn btn-danger">
                <a href="manageEvent.php" class="btn btn-secondary ml-2">No</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<?php

if (isset($_POST["v"]) && !empty($_POST["v"])) {
  require_once "../config.php";

  $sql = "SELECT id FROM events WHERE v = ?";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $param_v);

    $param_v = trim($_POST['v']);

    if ($stmt->execute()) {
      $result = $stmt->get_result();

      if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $id = $row['id'];
      }
      $result->free();
    }
  }

  $sql = "DELETE FROM events WHERE v=?;";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $param_v);

    $param_v = trim($_POST["v"]);

    if ($stmt->execute()) {
    } else {
      echo "Oopps! Something went wrong. Please try again later.";
    }
  }

  $sql = "UPDATE events SET id = id - 1 WHERE id > ?";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $param_id);

    $param_id = $id;

    if ($stmt->execute()) {
      header("location: manageEvent.php");
      exit();
    } else {
      echo "Oopps! Something went wrong. Please try again later.";
    }
  }

  $stmt->close();

  $mysqli->close();
} else {
  if (empty(trim($_GET["v"]))) {
    header("location: error.php");
    exit();
  }
}

?>