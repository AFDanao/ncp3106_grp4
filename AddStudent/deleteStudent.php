<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Delete Student</title>
  <style>
    .wrapper {
      width: 600px;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="mt-5 mb-3">Delete Student</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
              <input type="hidden" name="st" value="<?php echo trim($_GET['st']); ?>">
              <p>Are you sure you want to delete this student record?</p>
              <p>
                <input type="submit" value="Yes" class=" btn btn-danger">
                <a href="manageStudent.php" class="btn btn-secondary ml-2">No</a>
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

if (isset($_POST['st']) && !empty($_POST['st'])) {
  require_once "../config.php";

  $sql = "DELETE FROM students WHERE student_number=?";
  if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $param_st);

    $param_st = trim($_POST['st']);

    if ($stmt->execute()) {
      header('location: manageStudent.php');
    } else {
      echo "Oopps! Something went wrong. Please try again later.";
    }
  }

  $stmt->close();

  $mysqli->close();
} else {
  if (empty(trim($_GET['st']))) {
    header("location: error.php");
    exit();
  }
}

?>