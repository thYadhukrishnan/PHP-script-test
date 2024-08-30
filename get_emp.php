<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "design_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['employee_id'])) {
    $employeeID = $_POST['employee_id'];

    $sql = $conn->prepare("SELECT Name FROM Employee WHERE EmployeeID = ?");
    $sql->bind_param("i", $employeeID);

    
    $sql->execute();
    $sql->bind_result($name);

    if ($sql->fetch()) {
        echo "Employee Name: " . htmlspecialchars($name);
    } else {
        echo "No employee found.";
    }

    $sql->close();
} else {
    echo "Please Provide Employee ID.";
}

$conn->close();
?>
