<?php
// Test script to check database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "universidade_corporativa";

// Test MySQLi connection
echo "Testing MySQLi connection...\n";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "MySQLi connection failed: " . $conn->connect_error . "\n";
} else {
    echo "MySQLi connection successful!\n";

    // Test a simple query
    $sql = "SELECT COUNT(*) as total FROM cursos";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Total courses: " . $row['total'] . "\n";
    } else {
        echo "Query failed: " . $conn->error . "\n";
    }
    $conn->close();
}

// Test PDO connection
echo "\nTesting PDO connection...\n";
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "PDO connection successful!\n";

    // Test a simple query
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM cursos");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total courses: " . $row['total'] . "\n";
} catch (PDOException $e) {
    echo "PDO connection failed: " . $e->getMessage() . "\n";
}
?>
