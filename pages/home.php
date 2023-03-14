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

// User's location (you can replace this with your own location)
$location2 = "London";

// API endpoint and parameters
$url = "http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/pollenforecast/UK?res=3hourly&key=31819b16-1164-4f3b-9b16-2e9f0cb292ea";

// Make a request to the API
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Accept: application/json"
    ]
]);
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    echo "Error: " . curl_error($curl);
    exit();
}

// Parse the API response
$data2 = json_decode($response, true);

if ($data2 != null){
  $locations = $data2["Locations"]["Location"];
  $pollenLevel = null;

  foreach ($locations as $loc) {
      if (strtolower($loc["name"]) === strtolower($location2)) {
          $pollenLevel = $loc["Period"][0]["Rep"][0]["$"];
          break;
      }
  }

}
else {
  $pollenLevel = null;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../style/home.css">
  <link rel="stylesheet" href="../style/bootstrap.min.css">
  <script src="../pages/jquery.min.js" type="text/javascript"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<?php include '../models/nav-model.php'; ?>
<body>

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
    <span class="badge bg-danger" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px; line-height: normal !important;">
    <?php
    echo "<p class='alerts' style='font-size: 3.5vw;'>";
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
    //check if pollen in allergen list
    if (str_contains(strtolower($allergens), "pollen") or str_contains(strtolower($allergens), "hay fever") or str_contains(strtolower($allergens), "asthma")){
      // Inform the user about the pollen level
      if ($pollenLevel !== null && isset($pollenLevel[0]) && $pollenLevel[0] >= 7) {
        echo "High pollen levels! <br>";
      } else {
        echo "Pollen levels normal <br>";
      }

      
    }
    if ($alerts != TRUE){
        echo "No alerts <br>";
      }

    


    ?>
  
  
  
  </span>
  </div>
  <div class="wid2" style="padding: 5px">
    <span class="badge bg-info" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px;">
    <div class="weatherconth">
      <div>
        <?php
        if ($data) {
          
          
          echo '<h1 style="font-size: 3.5vw;">Current weather in ' . $city . '</h1>';
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
      <div>
      <a href="../pages/advice.php?advice=weather" class="btn btn-warning" style="float: left; font-size: 1.5vw;">Advice</a>

      </div>
    </div>
    <div class="weathercontp" style="padding-top: 0; font-size: 3vw;">
    <?php
        if ($data) {
          echo '<h1 style="font-size: 6vw;">' . $city . '<img src="' . $icon_url . '"style="width: 10vw; height: 10vw;" alt="' . $condition . '"> </h1> ';
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
<div class="weathercontp">
<a href="../pages/advice.php?advice=weather" class="btn btn-warning" style="margin: 25px; float: left; font-size: 4vw;">Advice</a>';
</div>
</body>
</html>