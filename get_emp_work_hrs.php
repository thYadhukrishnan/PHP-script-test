<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "design_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$month = 8;  
$year = 2024; 

$sql = "
    SELECT 
        emp.EmployeeID, 
        emp.Name, 
        SUM(TIMESTAMPDIFF(SECOND, CONCAT(AttendanceDate, ' ', InTime), CONCAT(AttendanceDate, ' ', OutTime)) / 3600) AS TotalHoursWorked
    FROM 
        AttendanceLog atlg
    JOIN 
        Employee emp ON atlg.EmployeeID = emp.EmployeeID
    WHERE 
        MONTH(AttendanceDate) = ? AND YEAR(AttendanceDate) = ?
        AND Status = 'Present' 
    GROUP BY 
        emp.EmployeeID, emp.Name
    ORDER BY 
        emp.EmployeeID;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $month, $year);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    foreach($result as $res){
        echo "Employee ID: " . $res["EmployeeID"] . " - Name: " . $res["Name"] . " - Total Hours Worked: " . number_format($res["TotalHoursWorked"], 2) . " hours<br>";
    }
} else {
    echo "No records found.";
}

$stmt->close();
$conn->close();
?>
