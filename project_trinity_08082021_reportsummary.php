<?php
session_start();
$role = isset($_COOKIE['derbyrole']) ? $_COOKIE['derbyrole'] : false;
if (!$role) {
  header("location:index.html");
}
if ($role == "User") {
  header("location:index.html");
}

error_reporting(error_reporting() & ~E_NOTICE);

?>

<!DOCTYPE html>
<html>

<head>
  <title>BAT Outbound</title>
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" type="text/css" href="../../table/dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="../../css/style.css">
  <script src='../../js/jquery.js'></script>
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src='../../table/jquery-1.12.4.js'></script>
  <script src='../../table/jquery.dataTables.min.js'></script>



</head>

<body>
  <nav class="navbar navbar-default crmnav">
    <div class="container-fluid">
      <div class="navbar-header">
        <img src="../../img/logo.png" class="logo">
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="project_trinity_08082021 .php">Home</a></li>

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Administration
            <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../../campaignchoose.php">Change Campaign</a></li>
            <li><a href="../../pwdchangeform.php">Change Password</a></li>
          </ul>
        </li>


        <li class="dropdown" id="evaluate">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Report
            <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="project_trinity_08082021_evaluate.php">Call Evaluate</a></li>
            <li><a href="project_trinity_08082021_report.php">Report</a></li>
            <li><a href="project_trinity_08082021_reportsummary.php">Summary</a></li>
          </ul>
        </li>
      </ul>
      <h4 class="header">Project Kartos Campaign</h4>
      <h4 align="right" class="logout"><a href="../../logout.php"> <?php echo $_COOKIE['derbyusername']; ?> </a></h4>
    </div>

  </nav>


  <div class="container">
    <form role="form" action="project_trinity_08082021_exportsummary.php" method="post">

      <div class="form-group col-md-2">
        <input class="form-control" placeholder="Start Date" type="text" id='datetimepicker1' name="datetimepicker1" required>
      </div>
      <div class="form-group col-md-2">
        <select class="form-control" id="treport" required name="treport">
          <option value="">Report Type</option>
          <option value="Dashboard">Dashboard</option>
          <option value="BRreport">BR wise Report</option>
          <!--               <option value="Dhouse">Distribution House wise Report</option>
              <option value="Duplicate">BR wise Duplicate</option>
              <option value="Invalid">BR wise Invalid</option> -->
          <option value="RawInvalid">Raw Invalid Number</option>
          <option value="RawDuplicate">Raw Duplicate Number</option>
          <option value="RawFake">Raw Fake Number</option>

        </select>
      </div>
      <!-- Change this to a button or input when using this as a form -->
      <button type="submit" class="btn btn-primary col-md-1">Submit</button>

    </form>
  </div>





  <script src="../../js/moment.min.js"></script>
  <script src="../../js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $('#datetimepicker1').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
        //format:'h:m:s a'
      });
      autoclose: true
    });
  </script>

</body>

</html>