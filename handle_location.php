<?php
$conn ="mysql:host=localhost;dbname=targets";
$dbusername = "root";
$dbpswd = "";

try{
    $pdo = new PDO($conn, $dbusername, $dbpswd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection Failed: ". $e->getMessage();
}

header('Content-Type: application/json');

// Get the raw POST data
$json_data = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($json_data);

$response = [];

if ($data && isset($data->latitude) && isset($data->longitude)) {
    $latitude = $data->latitude;
    $longitude = $data->longitude;

    $query = "INSERT INTO users(latt, lon ) VALUES (?, ?);";
    $stm = $pdo->prepare($query);
    $stm->execute([$latitude, $longitude]);
    
    // Here you can process the location data as needed
    
    $response['status'] = 'success';
    $response['message'] = "Received Lat: $latitude, Lon: $longitude";

} else {
    $response['status'] = 'error';
    $response['message'] = 'No location data received.';
}

echo json_encode($response);
?>

