<?php
session_start();
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

echo $username;

//check if username and password match
$sql = "SELECT * FROM user_login WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
        if (password_verify($password, $row["password"])) {
            echo 'Password is valid!';
            $_SESSION['username'] = $username;
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["location"] = $row["location"];
            $_SESSION["alergens"] = $row["alergens"];
            $_SESSION["step_goal"] = $row["step_goal"];
            $_SESSION["hc_mode"] = $row["hc_mode"];
            header("Location: ../pages/home.php");
        } else {
            echo 'Invalid password.';
            header("Location: ../pages/login.php?error=Invalid username or password");
        }
    }
} else {
    echo "0 results";
    header("Location: ../pages/login.php?error=Invalid username or password");
}