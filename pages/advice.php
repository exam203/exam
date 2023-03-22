<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: ../pages/login.php");
}
$hc_mode = $_SESSION['hc_mode'];
echo $hc_mode;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/advice.css">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <?php if($hc_mode == 1){ echo '<link rel="stylesheet" href="../style/hc_mode.css">'; } ?>
    <script src="../pages/jquery.min.js" type="text/javascript"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require('../models/nav-model.php'); 
    //pull GET data from URL
    echo "<center>";
    echo '<a href="../pages/advice.php?advice=weather" class="btn btn-warning" style="font-size: 80%;">Weather Advice</a>';
    echo '<a href="../pages/advice.php?advice=temperature" class="btn btn-warning" style="font-size: 80%;">Dangerous Tempuratures Advice</a>';
    echo '<a href="../pages/advice.php?advice=sun" class="btn btn-warning" style="font-size: 80%;">High UV Advice</a>';
    echo '<a href="../pages/advice.php?advice=wind" class="btn btn-warning" style="font-size: 80%;">High Wind Speed Advice</a>';
    echo '<a href="../pages/advice.php?advice=pollen" class="btn btn-warning" style="font-size: 80%;">High pollen Advice</a>';
    echo '<a href="../pages/advice.php?advice=high humidity" class="btn btn-warning" style="font-size: 80%;">High humidity Advice</a>';
    echo '<a href="../pages/advice.php?advice=low humidity" class="btn btn-warning" style="font-size: 80%;">Low humidity Advice</a>';
    
    echo '<br>';
    if (isset($_GET['advice'])){
    $advice_needed = $_GET['advice'];
    }
    else{
        $advice_needed = "welcome";
    }
    echo'
    <div class="card bg-dark mb-3 pb-3 pt-3 mt-5 " style="max-width: 90%;">
  <div class="card-body">
    <h4 class="card-title" style="font-size: 150%; color: white; text-align: -webkit-left !important;">'.$advice_needed.'</h4>
    <p class="card-text" style="font-size: 90%; color: white; text-align: -webkit-left !important;">';
    if ($advice_needed == "pollen"){
        echo "High pollen levels can be particularly difficult for those who suffer from allergies. Pollen allergies can cause symptoms like sneezing, runny nose, itchy eyes, and congestion. Here are some tips on how to deal with high pollen levels:<br>

        Firstly, check the pollen count in your area and plan your outdoor activities accordingly. Pollen counts are usually higher in the early morning and early evening, so try to plan your outdoor activities for later in the day when the pollen count is lower. Wear a mask or a pollen filter when outside to help reduce your exposure to pollen. If possible, stay indoors during days when the pollen count is particularly high.<br>
        
        Secondly, keep your home pollen-free by closing windows and doors to prevent pollen from getting in. Use an air conditioner and change the filter regularly to keep the air inside your home clean. Avoid hanging laundry outside to dry, as clothes and bedding can collect pollen. Clean your floors regularly with a vacuum cleaner that has a HEPA filter, which can trap small pollen particles.<br>
        
        Lastly, take steps to reduce your overall allergy symptoms by staying hydrated and eating a healthy diet. Drinking plenty of fluids can help to thin mucus and reduce congestion. Eating a balanced diet with plenty of fruits and vegetables can help to support your immune system and reduce inflammation. Consider taking allergy medication like antihistamines or nasal sprays to manage your symptoms.<br>
        
        Overall, dealing with high pollen levels requires taking proactive measures to reduce your exposure to pollen and manage your allergy symptoms. By following these tips, you can minimize the impact of high pollen levels on your health and enjoy the outdoors without suffering from allergies.";
    }
    elseif ($advice_needed == "wind"){
        echo "Extreme wind speeds can pose a risk to both your health and safety. Here are some tips on how to deal with extreme wind conditions:<br>

        If you're outdoors, take shelter immediately and avoid walking or driving through areas with high wind speeds. Flying debris can cause serious injuries, so be aware of your surroundings and stay away from objects that could potentially become airborne. If you're driving, keep both hands on the wheel and be prepared for sudden gusts of wind that could affect your vehicle's handling.<br>
        
        If you're indoors, secure windows and doors to prevent them from being damaged or blown open by strong winds. Stay away from windows and doors and avoid standing near them, as broken glass can cause serious injuries. Make sure that any outdoor furniture or equipment is stored or secured, as they can become dangerous projectiles in high winds.<br>
        
        It's important to stay informed about the weather conditions and listen to any warnings or advisories issued by local authorities. Stay tuned to local news and weather reports and follow any instructions provided. If you're in a location prone to high winds, make sure that you have an emergency plan in place and know where to go for shelter if necessary.<br>
        
        Overall, dealing with extreme wind conditions requires taking proactive measures to stay safe and avoid potential hazards. By following these tips, you can minimize the impact of high winds on your health and safety.<br>";
    }
    elseif ($advice_needed == "temperature"){
        echo "Extreme temperatures, whether hot or cold, can have adverse effects on our health if we don't take the necessary precautions. Here are some tips on how to deal with extreme temperatures:<br>

        During hot weather conditions, it's important to stay cool and hydrated. Avoid being outdoors during the hottest part of the day and stay in shaded or air-conditioned areas. Wear loose, lightweight clothing that covers your skin and use sunscreen to prevent sunburn. Drink plenty of fluids, particularly water, to stay hydrated and cool. Limit your physical activity to cooler times of the day and take frequent breaks if you must be outdoors.<br>
        
        During cold weather conditions, it's important to keep your body warm and dry. Wear layers of clothing to trap warm air between them and prevent heat loss. Cover your head, hands, and feet, as they are the parts of your body that lose the most heat. Avoid getting wet, as wet clothing can quickly cause heat loss and hypothermia. If you must be outdoors, take frequent breaks in warm, dry areas and avoid overexertion.<br>
        
        Whether it's hot or cold weather, it's important to listen to your body and know the signs of heat exhaustion, heat stroke, hypothermia, and frostbite. Seek medical attention immediately if you experience symptoms such as dizziness, headache, nausea, rapid heartbeat, confusion, or disorientation. Remember to take care of yourself and others around you during extreme temperatures.";
    }
    elseif ($advice_needed == "sun"){
        echo "High UV levels can be dangerous for your skin and increase the risk of skin cancer. Here are some tips on how to deal with high UV levels:<br>

        Firstly, avoid prolonged exposure to the sun during peak hours when the UV rays are the strongest, typically between 10 am and 4 pm. If you need to be outside, seek shade and wear protective clothing such as long-sleeved shirts, hats, and sunglasses to shield your skin and eyes from the sun. <br>
        
        Secondly, apply sunscreen with a minimum SPF of 30 to all exposed areas of your skin, even on cloudy days. Reapply sunscreen every two hours or more frequently if you are sweating or swimming. Be sure to apply sunscreen to your lips and ears as well, as these areas can be easily overlooked but are still susceptible to UV damage. <br>
        
        Thirdly, be mindful of reflective surfaces such as water, sand, and snow, which can increase your exposure to UV rays. If you are near any of these surfaces, take extra precautions by wearing protective clothing and reapplying sunscreen frequently. <br>
        
        Lastly, regularly check your skin for any changes or signs of skin cancer. If you notice any unusual moles, growths, or discolorations, consult a dermatologist for evaluation. Early detection is key to successful treatment of skin cancer. <br>
        
        Overall, dealing with high UV levels requires taking proactive measures to protect your skin from the sun's harmful rays. By following these tips, you can minimize your risk of skin damage and ensure your skin stays healthy for years to come. <br>";
    }
    elseif ($advice_needed == "weather"){
        echo "Extreme weather conditions can have a significant impact on our health. It is important to take precautions to protect ourselves during such times. Here are some tips on how to deal with extreme weather conditions.<br>

        Firstly, during hot weather conditions, it is essential to stay hydrated. Drink plenty of water and fluids like coconut water, buttermilk, lemonade, and fruit juices. Avoid drinks that contain caffeine, alcohol, or high amounts of sugar as they can dehydrate you further. Try to stay indoors during the hottest part of the day, and wear lightweight, loose-fitting clothes that cover your skin.<br>
        
        Secondly, during cold weather conditions, it is important to keep your body warm. Dress in layers and wear warm, waterproof clothing. Make sure to cover your head, hands, and feet as they are the parts of the body that lose heat the fastest. Avoid overexerting yourself outdoors, as the cold weather can strain your heart and lungs. If you must be outdoors, take breaks indoors to warm up.<br>
        
        Lastly, during times of extreme weather conditions like hurricanes or floods, it is important to stay informed and follow evacuation orders if necessary. Keep a stock of non-perishable food, bottled water, and other essentials like medicines and batteries for your devices. Stay away from floodwaters and do not attempt to drive through standing water. Listen to updates from local authorities and follow their instructions carefully.<br>
        
        Overall, taking precautions during extreme weather conditions is crucial for maintaining good health. Staying informed and prepared can help you avoid potential risks and stay safe.";
    }
    elseif ($advice_needed == "high humidity"){
        echo "High humidity levels can make you feel uncomfortable and increase the risk of heat exhaustion and heatstroke. Here are some tips on how to deal with high humidity:<br>

        Firstly, stay hydrated by drinking plenty of water and other non-alcoholic, non-caffeinated beverages. Avoid drinks that can dehydrate you such as alcohol, coffee, and sugary drinks. <br>
        
        Secondly, wear lightweight, loose-fitting clothing made from breathable fabrics such as cotton or linen to help keep you cool. <br>
        
        Thirdly, avoid outdoor activities during the hottest and most humid times of the day, typically between noon and 4 pm. If you must be outside, take frequent breaks in shaded or air-conditioned areas to cool down and rest. <br>
        
        Fourthly, use air conditioning or fans to help circulate air and reduce humidity levels indoors. If you don't have access to air conditioning, try using a dehumidifier to reduce moisture levels and improve air circulation. <br>
        
        Lastly, be aware of the symptoms of heat exhaustion and heatstroke, which can include dizziness, headache, nausea, rapid heartbeat, and confusion. If you experience any of these symptoms, move to a cool, shaded area, drink water, and seek medical attention if necessary. <br>
        
        Overall, dealing with high humidity requires taking proactive measures to stay cool and hydrated. By following these tips, you can reduce your risk of heat-related illnesses and enjoy the summer months safely and comfortably. <br>";
    }
    elseif ($advice_needed == "low humidity"){
        echo "Low humidity can cause a variety of health problems, including dry skin, nosebleeds, and respiratory issues. Here are some tips on how to deal with low humidity:<br>

        Firstly, stay hydrated by drinking plenty of water and other non-alcoholic, non-caffeinated beverages. This will help keep your skin and mucous membranes moist. <br>
        
        Secondly, use a humidifier to add moisture to the air indoors. This can help alleviate dry skin, nosebleeds, and respiratory issues such as coughing and congestion. <br>
        
        Thirdly, avoid taking hot showers or baths, which can dry out your skin even more. Instead, take shorter, cooler showers or baths. <br>
        
        Fourthly, use a moisturizer regularly to keep your skin hydrated. Look for a moisturizer that is fragrance-free and contains ingredients such as glycerin, hyaluronic acid, or urea, which help to attract and retain moisture in the skin. <br>
        
        Lastly, be aware of the symptoms of dehydration, which can include dry mouth, thirst, and fatigue. To avoid dehydration, drink plenty of fluids throughout the day, especially if you are sweating or engaging in physical activity. <br>
        
        Overall, dealing with low humidity requires taking proactive measures to add moisture back into the air and to keep your body hydrated. By following these tips, you can reduce your risk of health problems associated with dry air and enjoy the winter months safely and comfortably. <br>";
    }
    elseif ($advice_needed == "welcome"){
        echo "Welcome to our advice page! Our goal is to provide you with helpful tips and strategies for dealing with a variety of health-related issues. Whether you're looking for advice on how to stay healthy during extreme weather conditions, tips on managing allergies or skin conditions, or guidance on maintaining a healthy lifestyle, we're here to help. <br>

        Our team of experts has carefully researched and curated the information on this page to ensure that it is reliable, up-to-date, and practical. We understand that everyone's situation is different, and we strive to provide advice that is tailored to your unique needs and circumstances. <br>
        
        We invite you to explore our advice page and take advantage of the resources and information we have to offer. From diet and nutrition tips to stress management strategies, we're here to support you on your journey towards optimal health and well-being. If you have any questions or concerns, please don't hesitate to reach out to us. We're here to help you live your best life! <br>";

    }
    echo "</center></p></div>";
    ?>
    
</body>
</html>