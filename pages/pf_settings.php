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
        $location = $row["location"];
        $alergens = $row["alergens"];
        $password_hashed = $row["password"];
        $hc_mode = $row["hc_mode"];
    }
} else {
    echo "0 results";
}


//check if form has been submitted
if (isset($_POST["submit"])){
    //get form data
    $new_username = $_POST['username'];
    $current_password = $_POST['password'];
    $new_password = $_POST['password_new'];
    $confirm_password = $_POST['password_con'];
    $new_location = $_POST['location'];
    $new_alergens = $_POST['alergens'];
    echo $new_username;
    echo $current_password;
    echo $new_password;
    echo $confirm_password;
    echo $new_location;
    echo $new_alergens;

    //check if username is taken or unchanged
    if ($new_username != $username){
        $sql = "SELECT * FROM user_login WHERE username = '$new_username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "Username already taken";
                header("Location: ../pages/pf_settings.php?error=Username already taken");
            }
        } else {
            echo "0 results";
            $sql = "UPDATE user_login SET username = '$new_username' WHERE id = '$user_id'";
            $result = $conn->query($sql);
            $_SESSION['username'] = $new_username;
            header("Location: ../pages/pf_settings.php");
        }
    }


    //check if location is changed
    if ($new_location != $location){
        $sql = "UPDATE user_login SET location = '$new_location' WHERE id = '$user_id'";
        $result = $conn->query($sql);
        $_SESSION['location'] = $new_location;
        header("Location: ../pages/pf_settings.php");
    }

    //check if alergens are changed
    if ($new_alergens != $alergens){
        $sql = "UPDATE user_login SET alergens = '$new_alergens' WHERE id = '$user_id'";
        $result = $conn->query($sql);
        header("Location: ../pages/pf_settings.php");
    }

    //check if user wants to change password
    if ($current_password != ""){
    //check if password is correct
    if (password_verify($current_password, $password_hashed)) {
        echo 'Password is valid!';
        //check if new password is valid
        if ($new_password == $confirm_password){
            //check if new password is valid
            if (strlen($new_password) > 6){
                echo "pass:".$current_password;
                $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE user_login SET password = '$password_hashed' WHERE id = '$user_id'";
                $result = $conn->query($sql);
                header("Location: ../pages/login.php");
            } else {
                echo 'Password is too short';
                header("Location: ../pages/pf_settings.php?error=Password is too short");
            }
        }
        else{
            echo 'Passwords do not match';
            header("Location: ../pages/pf_settings.php?error=Passwords do not match");
        }
    } else {
        echo 'Invalid password.';
        header("Location: ../pages/pf_settings.php?error=Invalid password");
    }
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
    <title>Profile Settings</title>
</head>
<body>
    <?php include '../models/nav-model.php';?>



<form class="settings" action="pf_settings.php" method="post" style="margin-left: auto; margin-right: auto;">

<?php
if (isset($_GET['error'])){
    echo '<div class="alert alert-danger" role="alert">
    '.$_GET['error'].'
  </div>';
}
?>

    <div class="form-group">
    <label class="form-label mt-4">User Settings</label>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInput" name="username" value="<?=$username?>">
        <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Current Password">
        <label for="floatingPassword">Current Password</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password_new" placeholder="New Password">
        <label for="floatingPassword">New Password</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password_con" placeholder="Confirm Password">
        <label for="floatingPassword">Confirm Password</label>
    </div>
    <div class="form-floating mt-3">
        <input type="text" class="form-control" id="floatingInput" name="location" value="<?=$location?>">
        <label for="floatingInput">Location</label>
    </div>
    <label class="form-label mt-3">Use Commas to Separate Example - 'pollen, cats, dogs, perfume'</label>
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" name="alergens" value="<?=$alergens?>">
        <label for="floatingInput">Allergens</label>
    </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3" name="submit">Submit</button>
</form>
</div>
</body>
</html>
<?php

