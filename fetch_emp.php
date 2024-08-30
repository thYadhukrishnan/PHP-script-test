<?php
$servername = "localhost";
$username = "root";       
$password = "";            
$dbname = "design_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Name, HourlyRate FROM Employee";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    foreach ($result as $res){
        echo "Name: " . $res["Name"] . " - Hourly Rate: $" . $res["HourlyRate"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
