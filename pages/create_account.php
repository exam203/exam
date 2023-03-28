<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <script src="jquery.min.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
</head>
<?php
// get error message from create_action.php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-dismissible alert-danger">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Uh Oh!</strong> ' . $_GET["error"].'
  </div>';
}
?>
<body>
<center>
    
    <span class="badge bg-light" id="cr-box">
    <h1 style="font-family: sans-serif;">Create Account</h1>
    Enter Information
    <form action="../action/create_action.php" method="post" style="padding-bottom: 10px;">
        <div class="form-group">
            <label class="col-form-label mt-4" for="inputDefault">Username</label>
            <input type="text" class="form-control" placeholder="Username" name="username" id="inputDefault" required>
        </div><br>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" required>
        </div><br>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password_con" placeholder="Confirm Password" required>
        </div><br>
        <div class="form-group">
            <label class="col-form-label mt-4" for="inputDefault">location</label>
            <input type="text" class="form-control" placeholder="Enter Name of Nearest City" name="location" id="inputDefault">
        </div><br>
        <div class="form-group">
            <label class="col-form-label mt-4" for="inputDefault">Alergens</label>
            <input type="text" class="form-control" placeholder="Use Commas to Separate Example - 'pollen, cats, dogs, perfume'" name="alergens" id="inputDefault">
        </div><br>
        <div class="form-group">
            <label class="col-form-label mt-4" for="inputDefault">Step Goal</label>
            <input type="text" class="form-control" placeholder="Enter Your Step Goal" name="goal" id="inputDefault">
        </div><br>
        <button type="submit"  style="width: 100%; height: 50px; margin-top: 20px;"class="btn btn-primary">Submit</button>
        
    </form>
    <p style="font-family: sans-serif;">Returning User? <a href="Login.php" style="font-family: sans-serif;">Login</a></p>
    </span>
   
</center> 
</body>
</html>