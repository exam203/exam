<?php
session_start();

if (!isset($_SESSION['username'])){
    header("Location: ../pages/login.php");
}
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$hc_mode = $_SESSION['hc_mode'];
$allergens = $_SESSION['alergens'];
//connect to database
$servername = "localhost";
$server_username = "root";
$password = "";
$dbname = "health_app";
$conn = new mysqli($servername, $server_username, $password, $dbname);
$hc_img = "";

//get users location
$sql = "SELECT * FROM user_login WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $location = $row["location"];
        $_SESSION["location"] = $location;
        $allergens = $row["alergens"];
        $step_goal = $row["step_goal"];
        $hc_mode = $row["hc_mode"];
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
$location2 = $location;

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
  <?php if($hc_mode == 1){ echo '<link rel="stylesheet" href="../style/hc_mode.css">'; $hc_img = "_hc";} ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        
        <?php
        echo "<h1 style='font-size:20px'>". '<a class="pf_wid"  href="settings.php"><img src="'. "../images/settings".$hc_img.".png" . '" width="40px"></a>' .ucfirst($username) . '<a class="pf_wid" href="pf_settings.php"><img src="'. "../images/profile_settings".$hc_img.".png" . '" width="40px"></a>' . "</h1><br>";

        ?>
        <p class="pf_data">Location: <?php echo $location; ?><br>Heart Rate (BPM): [GET FROM SMART DEVICE]<br> Distance (KM): [GET FROM SMART DEVICE]<br> Allergens: <?=$allergens?>   </p>
        
  </span>
  </div>

  <div class="wid1" style="padding: 5px">
    <span class="badge bg-danger" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px; line-height: normal !important;">
    <?php
    echo "<p class='alerts' style='font-size: 4vw;'>";
    if ($wind_kph >= 93){
      echo "Check High winds<br>";
      $alerts = TRUE;
    }    
    if ($temp_c >= 30){
      echo "High temperature Check<br>";
      $alerts = TRUE;
    }
    if ($temp_c <= 0){
      echo "Low temperature Check<br>";
      $alerts = TRUE;
    }
    if ($temp_c <= -2){
      echo "Check Snow and Ice<br>";
      $alerts = TRUE;
    }
    if ($humidity >= 80){
      echo "Check High Humidity<br>";
      $alerts = TRUE;
    }
    if ($humidity <= 20){
      echo "Check Low humidity<br>";
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
        echo 'No alerts <br> <div class="btn-group" role="group" aria-label="Basic example">
        <a href="../pages/advice.php" class="btn btn-danger" style="border-color: white; float: left;  margin-top:10%; font-size: 120%; padding: 10%">Advice</a>
        </div>';
        
      }
    else{
      echo '</p><p style="font-size: 200%;">Read More: <br>
      <div class="btn-group" role="group" aria-label="Basic example">
      <a href="../pages/advice.php" class="btn btn-danger" style="border-color: white; float: left;  margin-top:10%; font-size: 120%; padding: 10%">Advice</a>
      </div>
      ';
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
          
          
          echo '<h1 style="font-size: 3.5vw;">' . ucfirst($city) . '</h1>';
          echo '<p>Temperature: ' . $temp_c . '°C / ' . $temp_f . '°F | Humidity: ' . $humidity . '%</p>';
          echo '<p>Wind: ' . $wind_kph . ' km/h ' . $wind_dir . ' | Condition: ' . $condition . '</p>';
          echo '';
          echo '<img src="' . $icon_url . '"style="width: 25%"  alt="' . $condition . '">';
      } else {
          echo 'Error retrieving weather data';
      }
      ?>
      </div>
      <div>
      

      </div>
    </div>
    <div class="weathercontp" style="padding-top: 0; font-size: 3vw;">
    <?php
        if ($data) {
          echo '<h1 style="font-size: 6vw;">' . ucfirst($city) . '<img src="' . $icon_url . '"style="width: 10vw; height: 10vw;" alt="' . $condition . '"> </h1> ';
          echo '<p>Temp: ' . $temp_c . '°C / ' . $temp_f . '°F</p>';
          echo '<p>Humidity: ' . $humidity . '%</p>';
          echo '<p>Wind: ' . $wind_kph . ' km/h ' . $wind_dir . '</p>';
          echo '<p style="padding-top: 0; font-size: 3.5vw; font-weight: bold;">' . $condition . '</p>';
      } else {
          echo 'Error retrieving weather data';
      }
      ?>
      
  </div>
  </span>
  </div>
  <div class="wid3" style="padding: 5px">
    <span class="badge bg-secondary" id="shadow" style=" width: 100%; height: 100%; border-radius: 30px; line-height: normal !important;">
  
    <?php

        //connect to database
        $servername = "localhost";
        $server_username = "root";
        $password = "";
        $dbname = "health_app";
        $conn = new mysqli($servername, $server_username, $password, $dbname);
        $total_steps = 0;
        $today_steps = 0;

        //check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        //get step count data from database
        $sql = "SELECT * FROM step_counts WHERE username = '$username'";
        $result = $conn->query($sql);
        $line = 0;
        echo "<h6 style='line-height: normal !important;'> Step Count Data:</h6><p style='line-height: normal !important;'>";
        while ($row = $result->fetch_assoc()) {
          $line++;
          if ($line < 6) {
              echo $row['step_count'] . " on " . $row['date'] . "<br>";
          } else if ($line == 6) {
              echo "... <br>";
          }
          
            $total_steps += $row['step_count'];
            if ($row['date'] == date("Y-m-d")){
              $today_steps += $row['step_count'];
            }
        }
        echo "<h3>Steps Today:<br> " . $today_steps . "</h3>";
        //add a circle to show how many steps they have done today
        echo "<div class='progress' style='height: 20px; width: 100%;'>
        <div class='progress-bar' role='progressbar' style='width: " . ($today_steps / $step_goal) * 100 . "%; background-color: #46eb34;' aria-valuenow='" . ($today_steps / 10000) * 100 . "' aria-valuemin='0' aria-valuemax='100'></div>
      </div>";


      echo "<h4>Goal: " . $step_goal . "</h4> <br>";
    ?>
  
  
  </span>
  </div>
</div>
<div class="weathercontp">

</div>





</body>
</body>
</html>