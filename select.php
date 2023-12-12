<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Select</title>
  <style>
    body {
      background-color: #f4f4f4;
      height: 90vh;
    }

    .wrapper {
      width: 25vw;
      height: 90vh;
      margin: 0 auto;
    }

    .container-fluid {
      width: 350px;
      height: auto;
      padding: 16px;
      background-color: #FAF9F6;
      border-radius: 10px;
      z-index: 1;
    }


    #engineering-image {
      background: url('scpes.png') center center no-repeat;
      background-size: cover;
      width: 100vw;
      height: 100vh;
      position: fixed;
      z-index: -1;
    }

    .select {
      display: flex;
      flex-direction: column;
      row-gap: 5px;
    }
  </style>
</head>

<body>
  <div id="engineering-image"></div>
  <div class="wrapper d-flex justify-content-center align-items-center text-center">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-dark">Select Activity</h2>
          <p class="text-dark">Please select an activity.</p>
          <div class="select mt-4">
            <a href="AddStudent/addStudent.php" class="btn btn-dark btn-block">Add Student</a>
            <a href="AddStudent/manageStudent.php" class="btn btn-dark btn-block">Manage Students</a>
            <a href="AddEvent/addEvent.php" class="btn btn-dark btn-block">Add Event</a>
            <a href="ManageEvent/manageEvent.php" class="btn btn-dark btn-block">Manage Event</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>