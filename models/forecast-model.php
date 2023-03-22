<?php
if ($citycode != 0){
?>

<div id="openweathermap-widget-21"></div>
      <script src='//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/d3.min.js'></script>
      <script>window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];  window.myWidgetParam.push({id: 21,cityid: '<?=$citycode?>',appid: 'dcf3e5487dbe12a0bad6c3ffcdac8500',units: 'metric',containerid: 'openweathermap-widget-21',  });  (function() {var script = document.createElement('script');script.async = true;script.charset = "utf-8";script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(script, s);  })();</script>
</div>
<?php
}
else{
    echo $citycode;
    echo("<p style='color: white;'> weather data not found for location </p>");
}
?>