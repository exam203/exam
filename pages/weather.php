<head>
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
<body onload="initMap()">
  <div id="map" style="height: 400px; width: 100%;"></div>
  <form>
    <label for="location">Enter location:</label>
    <input type="text" id="location" name="location" required>
    <button type="submit" id="submit">Submit</button>

</form>
<div id="output"></div>
</body>
</html>