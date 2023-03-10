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

//get users location
$sql = "SELECT * FROM user_login WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $location = $row["location"];
        $allergens = $row["alergens"];
    }
} else {
    echo "0 results";
    echo $username;
}

//get warning for location from weather table
$sql = "SELECT * FROM weather WHERE location = '$location'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $weather_warning = $row["warning"];
        $high = $row["high"];
        $low = $row["low"];
        if ($weather_warning == ""){
            echo "No warnings for your location";
        }
    }
} else {
    echo "0 results";
}

$alerts = false;

$apiKey = '23884342970a4f1b8aa101013230903';
$city = $location;
$country = 'UK';
$url = 'https://api.weatherapi.com/v1/current.json?key=' . $apiKey . '&q=' . urlencode($city) . ',' . urlencode($country);
$jsonData = file_get_contents($url);
$data = json_decode($jsonData);

$temp_c = $data->current->temp_c;
$temp_f = $data->current->temp_f;
$humidity = $data->current->humidity;
$wind_kph = $data->current->wind_kph;
$wind_dir = $data->current->wind_dir;
$condition = $data->current->condition->text;
$icon_url = $data->current->condition->icon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../style/home.css">
  <link rel="stylesheet" href="../style/bootstrap.min.css">
  <script src="jquery.min.js" type="text/javascript"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav-menu">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="home.php">Dashboard
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/weather.php">Weather</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Profile</a>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
<body>
<div id="output" style="font-size: 48px;">fgfg</div>

<div class="container">
  <div class="prof" style="padding: 5px">
    <span class="badge bg-light" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px;">
    
  <button type="button" class="btn btn-dark">settings</button>
  <?php
    echo $username;
    
  
  
  
    ?>
  <button type="button" class="btn btn-dark">notifications</button>
  </span>
  </div>
  <div class="wid1" style="padding: 5px">
    <span class="badge bg-danger" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px;">
    <?php
    echo "<p style='font-size: 5vw;'>";
    if ($wind_kph >= 93){
      echo "High winds<br>";
      $alerts = TRUE;
    }    
    if ($temp_c >= 30){
      echo "High temperature<br>";
      $alerts = TRUE;
    }
    if ($temp_c <= 0){
      echo "Low temperature<br>";
      $alerts = TRUE;
    }
    if ($temp_c <= -2){
      echo "Snow and Ice<br>";
      $alerts = TRUE;
    }
    if ($humidity >= 80){
      echo "High humidity<br>";
      $alerts = TRUE;
    }
    if ($humidity <= 20){
      echo "Low humidity<br>";
      $alerts = TRUE;
    }
    if ($alerts != TRUE){
      echo "No alerts";
    }


    ?>
  
  
  
  </span>
  </div>
  <div class="wid2" style="padding: 5px">
    <span class="badge bg-info" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px;">
    <div class="weatherconth">
        <?php
        if ($data) {
          
          
          echo '<h1>Current weather in ' . $city . '</h1>';
          echo '<p>Temperature: ' . $temp_c . '°C / ' . $temp_f . '°F</p>';
          echo '<p>Humidity: ' . $humidity . '%</p>';
          echo '<p>Wind: ' . $wind_kph . ' km/h ' . $wind_dir . '</p>';
          echo '<p>Condition: ' . $condition . '</p>';
          echo '<img src="' . $icon_url . '" alt="' . $condition . '">';
      } else {
          echo 'Error retrieving weather data';
      }
      ?>
    </div>
    <div class="weathercontp" style="padding-top: 2px; font-size: 3.5vw;">
    <?php
        if ($data) {
          echo '<h1 style="font-size: 10vw;">' . $city . '<img src="' . $icon_url . '"style="width: 10vw; height: 10vw;" alt="' . $condition . '"> </h1> ';
          echo '<p>Temp: ' . $temp_c . '°C / ' . $temp_f . '°F</p>';
          echo '<p>Humidity: ' . $humidity . '%</p>';
          echo '<p>Wind: ' . $wind_kph . ' km/h ' . $wind_dir . '</p>';
          echo '<p>Condition: ' . $condition . '</p>';
      } else {
          echo 'Error retrieving weather data';
      }
      ?>
      
  </div>
  </span>
  </div>
  <div class="wid3" style="padding: 5px">
    <span class="badge bg-secondary" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px;">Widget 3</span>
  </div>
</div>
</body>
</html>