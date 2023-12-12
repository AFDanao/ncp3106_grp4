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
  <title>
    <?php echo $name; ?>
  </title>
  <style>
    body {
      background-color: #f4f4f4;
      height: 100vh;
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

    .col-md-12 {
      height: 90vh;
      overflow-y: auto;
    }
  </style>
  <script>
    $(document).ready(function () {
      $('#event_participants_table').DataTable({
        dom: "Bfrtip",
        buttons: [
          'copy', 'csv', 'excel', 'print'
        ]
      });
    });
  </script>
</head>

<body>
  <div class="container-fluid">
    <div class="row h-50">
      <div class="col-md-12">
        <div class="mt-5 mb-3 clearfix">
          <a href="manageStudent.php" class="btn btn-secondary">Back</a>
          <h2 class="justify-content-center d-flex">DOWNLOAD STUDENT RECORDS</h2>
        </div>
        <?php
        require_once "../config.php";
        $sql = "SELECT * FROM students";
        if ($result = $mysqli->query($sql)) {
          if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-stiped' id='event_participants_table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Middle Initial</th>";
            echo "<th>Student Number</th>";
            echo "<th>Program</th>";
            echo "<th>Current Year</th>";
            echo "<th>Email</th>";
            echo "<th>Contact Number</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['last_name'] . "</td>";
              echo "<td>" . $row['first_name'] . "</td>";
              echo "<td>" . $row['middle_initial'] . "</td>";
              echo "<td>" . $row['student_number'] . "</td>";
              echo "<td>" . $row['program'] . "</td>";
              echo "<td>" . $row['current_year'] . "</td>";
              echo "<td>" . $row['email'] . "</td>";
              echo "<td>" . $row['contact_number'] . "</td>";
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
        ?>
      </div>
    </div>
  </div>
</body>

</html>