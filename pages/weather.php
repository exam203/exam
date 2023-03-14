<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/weather.css">
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
        zoom: 12,
        center: {lat: 0, lng: 0}
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
              document.getElementById('output').innerHTML = document.getElementById('output').innerHTML = "<h2 style='font-size: 48px;'>" + city +  "</h2>" + "<img src='" + icon + "' style='padding: 0; margin:0;' alt='Weather Icon'>" +
  "<p>Temperature: " + tempC + " &deg;C / " + tempF + " &deg;F</p>" +
  "<p>Condition: " + condition + "</p>" +
  "<p>Air Quality Index: " + aqi + "</p>";

              // Add marker to map
                var weatherInfo = "Temperature: " + tempC + " &deg;C / " + tempF + " &deg;F<br>Condition: " + condition + "<br>Air Quality Index: " + aqi;
                var infoWindow = new google.maps.InfoWindow({
                content: document.getElementById('output')
                });
                var marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                visible: false, // Hide marker
                closeBoxURL: "",
                closeBoxMargin: "0px",
                enableEventPropagation: true,
                closeButton: false
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
  
    <form style="padding: 5px;">
        <div class="form-group" style="padding: 5px;">
            <label class="col-form-label mt-4" for="inputDefault" style="color: white;">Location</label>
            <input type="text" class="form-control" placeholder="Enter Location" name="location" id="location" style="border-radius: 5px !important;" required>
            <button type="submit" id="submit" style="width: 100%; height: 50px; font-size: 15px; margin-top: 10px !important; border-radius: 5px !important;"class="btn btn-dark">GO!</button>
        </div>
        

    </form>
    <div id="map"></div>
    <div id="output"></div>

</body>
</html>