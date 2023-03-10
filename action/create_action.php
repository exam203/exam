<?php
//connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health_app";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo "Connected successfully <br>";
}

//get data from form
$username = $_POST['username'];
$password = $_POST['password'];
$password_con = $_POST['password_con'];
$location = $_POST['location'];
$alergens = $_POST['alergens'];

echo $username . "<br>";
//check if username is taken
$sql = "SELECT * FROM user_login WHERE username = '$username'";
$result = $conn->query($sql);

if(mysqli_num_rows($result)>0){
    
    header("Location: ../pages/create_account.php?error=Username is already taken");
    
} else {
    //check if passwords match
    if ($alergens == ""){
        $alergens = "None";
    }
    if ($location == ""){
        $location = "None";
    }
    if ($password != $password_con){
        header("Location: ../pages/create_account.php?error=Passwords do not match");
    }
    else{
        //hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        echo $hashed_password . "<br>";
        //check if password matches
        if (password_verify($password, $hashed_password)) {
            echo 'Password is valid!';
        } else {
            echo 'Invalid password.';
        }

        //add data
        $sql = $conn->prepare("INSERT INTO user_login (username, password, location, alergens) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $username, $hashed_password, $location, $alergens);
        $sql->execute();

      
        echo "New record created successfully";
        header("Location: ../pages/login.php?success=Account created successfully");

        $conn->close();

    }
    
}
    
    