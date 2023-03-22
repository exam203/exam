<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <script src="../pages/jquery.min.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<?php
//clear session
session_start();
session_unset();
session_destroy();

// get success message from create.php
if (isset($_GET['success'])) {
    echo '<div class="alert alert-dismissible alert-success">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Well done! </strong>'.$_GET['success']. '
  </div>';
}
if (isset($_GET['error'])) {
    echo '<div class="alert alert-dismissible alert-danger">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Oh snap! </strong>'.$_GET['error']. '
  </div>';
}


?>
<body>
    <span class="badge bg-info" style=" width: 25%; height: 50px; border-radius: 15px; margin-bottom: 20px;"><p style="font-size: 25px; font-family: sans-serif;">Please Login</p></span><br>
    <span class="badge bg-light" style=" width: 25%; height: 330px; border-radius: 15px;">
    Enter Login Information
    <form action="../action/login_action.php" method="post" style="padding-bottom: 10px;">
        <div class="form-group">
            <label class="col-form-label mt-4" for="inputDefault">Username</label>
            <input type="text" class="form-control" placeholder="Username" name="username" id="inputDefault">
        </div><br>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
        </div><br>
        <button type="submit"  style="width: 100%; height: 50px;"class="btn btn-primary">Submit</button>
        
    </form>
    <p style="font-family: sans-serif;">New here? <a href="create_account.php" style="font-family: sans-serif;">Create an Account</a></p>
    </span>
    
</body>
</html>