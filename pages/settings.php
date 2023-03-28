<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: ../pages/login.php");
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];


//connect to database
$servername = "localhost";
$server_username = "root";
$password = "";
$dbname = "health_app";
$conn = new mysqli($servername, $server_username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get data from database
$sql = "SELECT * FROM user_login WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $step_goal = $row["step_goal"];
        $hc_mode = $row["hc_mode"];
    }
} else {
    echo "0 results";
}


//check if form has been submitted
if (isset($_POST["submit"])){
    //get form data
    $new_step_goal = $_POST['step_goal'];

    //check if steps is changed
    if ($new_step_goal != $step_goal){
        $sql = "UPDATE user_login SET step_goal = '$new_step_goal' WHERE username = '$username'";
        $result = $conn->query($sql);
        $_SESSION['step_goal'] = $step_goal;
        header("Location: ../pages/settings.php");
    }

    //check if hc_mode dropdown is yes or no
    if ($_POST['hc_mode'] == "yes"){
        $sql = "UPDATE user_login SET hc_mode = '1' WHERE username = '$username'";
        $result = $conn->query($sql);
        $_SESSION['hc_mode'] = 1;
        header("Location: ../pages/settings.php");
    }
    else if ($_POST['hc_mode'] == "no"){
        $sql = "UPDATE user_login SET hc_mode = '0' WHERE username = '$username'";
        $result = $conn->query($sql);
        $_SESSION['hc_mode'] = 0;
        header("Location: ../pages/settings.php");
    }


}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/settings.css">
    <?php if($hc_mode == 1){ echo '<link rel="stylesheet" href="../style/hc_mode.css">'; } ?>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <title>Settings</title>
</head>
<body>
    <?php include '../models/nav-model.php';?>



<form class="settings" action="settings.php" method="post" style="margin-left: auto; margin-right: auto;">

<?php
if (isset($_GET['error'])){
    echo '<div class="alert alert-danger" role="alert">
    '.$_GET['error'].'
  </div>';
}
    
?>

    <div class="form-group">
    <label class="form-label mt-4">Settings</label>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInput" name="step_goal" value="<?=$step_goal?>">
        <label for="floatingInput">Step Goal</label>
    </div>

    
        <label for="exampleSelect1" class="form-label mt-4">High Contrast Mode</label>
        <select class="form-select" name="hc_mode" id="exampleSelect1">
            <?php
            if ($hc_mode == "1"){
                echo '<option>yes</option>
                <option>no</option>';
            }
            else if ($hc_mode == "0"){
                echo '<option>no</option>
                <option>yes</option>';
            }
            ?>
            
        </select>
        
    </div>
    <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
</form>
</div>
</body>
</html>
<?php

