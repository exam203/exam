<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: ../pages/login.php");
}
$username = $_SESSION['username'];

//connect to database
$servername = "localhost";
$server_username = "root";
$password = "";
$dbname = "health_app";
$conn = new mysqli($servername, $server_username, $password, $dbname);
$total_steps = 0;

//get hc_mode from database
$sql = "SELECT hc_mode FROM user_login WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $hc_mode = $row["hc_mode"];
    }
} else {
    echo "0 results";
}

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get step count from form and add to database
if (isset($_POST['step_count'])) {
    $step_count = $_POST['step_count'];
    $date = date("Y-m-d");
    $sql = "INSERT INTO step_counts (step_count, username, date) VALUES ('$step_count', '$username' , '$date')";
    $result = $conn->query($sql);
    header("Location: profile.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/profile.css">
  <link rel="stylesheet" href="../style/bootstrap.min.css">
  <?php if($hc_mode == 1){ echo '<link rel="stylesheet" href="../style/hc_mode.css">'; } ?>
  <script async src="//jsfiddle.net/bootswatch/fz9q2h8u/embed/"></script>
  <script src="../pages/jquery.min.js" type="text/javascript"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather Map</title>
  </head>
<?php include '../models/nav-model.php'; ?>
<nav class="navbar navbar-light bg-primary justify-content-center" id="profile-menu" style="background-color: #d6d6d6 !important;width: 100%; z-index: 1;">
<ul class="nav justify-content-center" >
  <li class="nav-item " style="padding-left: 5vw; padding-right: 5vw; padding-left: 0px; padding-right: 60px">
    <a class="nav-link"  href="../pages/settings.php"><img src="../images/settings.png" width="25px"></a>
  </li>
  <li class="nav-item" style="padding-left: 5vw; padding-right: 5vw; padding-right: 0px; padding-left: 60px">
    <a class="nav-link" href="../pages/pf_settings.php"><img src="../images/profile_settings.png" width="25px"></a>
  </li>
</ul>
  
</nav>

<body style="padding-top: 120px;">
<center>


<div class="portrait"> 

<div class="card text-white bg-success mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header">Add Step Data:</div>
  <div class="card-body">
    <!-- HTML form for step count input -->
    <form method="post" action="profile.php">
        
        <input type="number" name="step_count" style="width: 79%; height: 50px;">
        <input type="submit" value="Add" style="width: 19%; height: 50px;">
    </form>
    </div>
</div>

<div class="card text-white bg-secondary mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header">Total Steps Earned</div>
  <div class="card-body">
    <?php
        //get step count data from database
        $sql = "SELECT * FROM step_counts WHERE username = '$username'";
        $result = $conn->query($sql);
        $line = 0;
        echo "<p > Step Count Data:<br>";
        while ($row = $result->fetch_assoc()) {
            $line++;
            if ($line < 3) {
                echo $row['step_count'] . " steps on " . $row['date'] . "<br>";
            } else if ($line == 3) {
                echo "... <br>";
            }
            
            $total_steps += $row['step_count'];
        }
        echo "<h1>Total steps: " . $total_steps . "</h1>";
    ?>
  </div>
</div>

<div class="card text-white bg-warning mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

<div class="card text-white bg-success mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

<div class="card text-white bg-primary mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

<div class="card text-white bg-secondary mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>



</div>


<div class="container horizontal">
    <div class="row">
        
<div class="card text-white bg-success mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header">Add Step Data:</div>
  <div class="card-body">
    <!-- HTML form for step count input -->
    <form method="post" action="profile.php">
        
        <input type="number" name="step_count" style="width: 79%; height: 50px;">
        <input type="submit" value="Add" style="width: 19%; height: 50px;">
    </form>
    </div>
</div>

<div class="card text-white bg-secondary mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header">Total Steps Earned</div>
  <div class="card-body">
    <?php
        //get step count data from database
        $sql = "SELECT * FROM step_counts WHERE username = '$username'";
        $result = $conn->query($sql);
        echo "<p > Step Count Data:<br>";
        $rows = 0;
        while ($row = $result->fetch_assoc()) {
            $rows++;
            if ($rows < 3) {
                echo $row['step_count'] . " steps on " . $row['date'] . "<br>";
            }
            if ($rows == 3) {
                echo "..." . "<br>";
            }
            $total_steps += $row['step_count'];
        }
        echo "<h2>Steps: " . $total_steps . "</h2>";
    ?>
  </div>
</div>

<div class="card text-white bg-warning mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

<div class="card text-white bg-success mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

<div class="card text-white bg-primary mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

<div class="card text-white bg-secondary mb-3" style="width: 20rem; height: 17rem;">
  <div class="card-header"></div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text"></p>
  </div>
</div>

</div>
</center>