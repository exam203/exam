<?php
session_start();
$location = $_SESSION["location"];
$hc_mode = $_SESSION["hc_mode"];

function getCityCode($cityName) {
  // Replace YOUR_API_KEY with your actual API key from OpenWeatherMap
  $apiKey = 'dcf3e5487dbe12a0bad6c3ffcdac8500';
  
  // Create the API URL with the city name and API key
  $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($cityName) . ',UK&appid=' . $apiKey;

  // Make an API request to get the city data
  $data = file_get_contents($url);

  // Parse the JSON response
  $json = json_decode($data, true);

  // Check if the API returned an error
  if ($json['cod'] !== 200) {
    return null;
  }

  // Return the city code from the API response
  return $json['id'];
}

// Example usage
$citycode = getCityCode($location);

if ($citycode) {
  #echo "The city code for $location is $citycode";
} else {
  echo "Error: Could not find city code for $location";
  $citycode = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/weather.css">
  <?php if($hc_mode == 1){ echo '<link rel="stylesheet" href="../style/hc_mode.css">'; } ?>
  <link rel="stylesheet" href="../style/bootstrap.min.css">
  <script src="../pages/jquery.min.js" type="text/javascript"></script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather Map</title>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzw43t-84BEsCeymov_vPsks3Z8GEBsmg"></script>
  <script>
    function initMap() {
      // Initialize map
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11.5,
        center: {lat: 0, lng: 0},
        disableDefaultUI: true
      });

      // Get location input and send API request
      var locationInput = document.getElementById('location');
      var submitButton = document.getElementById('submit');
      submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        var location = locationInput.value;
        var apiKey = "23884342970a4f1b8aa101013230903"; // Replace with your weatherapi.com API key
        var url = "https://api.weatherapi.com/v1/current.json?key=" + apiKey + "&q=" + location + "&aqi=yes";
        

        // Use cURL to retrieve data from API
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.onload = function() {
          if (xhr.status === 200) {
            var weatherData = JSON.parse(xhr.responseText);
            if (weatherData === null || weatherData.error) {
              alert("Error retrieving data from API: " + weatherData.error.message);
            } else {
              // Extract relevant data from API response
              var city = weatherData.location.name;
              var region = weatherData.location.region;
              var country = weatherData.location.country;
              var tempC = weatherData.current.temp_c;
              var tempF = weatherData.current.temp_f;
              var condition = weatherData.current.condition.text;
              var icon = weatherData.current.condition.icon;
              var aqi = weatherData.current.air_quality['gb-defra-index'];
              var lat = weatherData.location.lat;
              var lng = weatherData.location.lon;

              // Display weather and air quality data on webpage
              document.getElementById('output').innerHTML = document.getElementById('output').innerHTML = "<h2 style='font-size: 5vw;'>" + city + "<img src='" + icon + "' style='padding: 0; margin:0; width: 5vw;'  alt='Weather Icon'>" + "</h2>" +
  "<p>" + tempC + " &deg;C / " + tempF + " &deg;F</p>" +
  "<p>" + condition + "</p>" +
  "<p>Air Quality: " + aqi + "</p>";

              // Add marker to map
                var weatherInfo = "Temperature: " + tempC + " &deg;C / " + tempF + " &deg;F<br>Condition: " + condition + "<br>Air Quality Index: " + aqi;
                var infoWindow = new google.maps.InfoWindow({
                content: document.getElementById('output'),
                maxHeight: 500
                });
                var marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                visible: false // Hide marker
                });
                map.setCenter(marker.getPosition());
                infoWindow.open(map, marker);
                

               
            }
          } else {
            alert("Error retrieving data from API: " + xhr.statusText);
          }
        };
        xhr.onerror = function() {
          alert("Error retrieving data from API.");
        };
        xhr.send();
      });
    }
  </script>
</head>
<?php include '../models/nav-model.php'; ?>
<body onload="initMap()">
<div id="location-form">
    <form style="padding: 5px;">
    <center>
        <div class="form-group" style="padding: 5px;">
        
            <label class="col-form-label mt-4" for="inputDefault" style="color: white;">Location</label>
            <input type="text" class="form-control" placeholder="Enter Location" name="location" id="location" style=" width: 90% !important; border-radius: 5px !important;" required>
            <button type="submit" id="submit" style="width: 90%; height: 50px; font-size: 15px; margin-top: 10px !important; border-radius: 5px !important;"class="btn btn-dark">GO!</button>
        </center>
        </div>
    </form>
</div>


    <div id="map"></div>
    <div id="output"></div>
    <div id="forecast">
    
    <div class="forecast-p">
    
      <?php include '../models/forecast-model-mobile.php'; ?>
    </div>
    <div class="forecast-h">
    <center>
      <?php include '../models/forecast-model.php'; ?>
      </center>
    </div>
    
    </div>

</body>
</html>