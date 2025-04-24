<?php
// curriculum_years.php
require_once '../../../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['program_code'])) {
    $programCode = $_GET['program_code'];

    $query = "SELECT DISTINCT curriculum_year FROM curriculum WHERE program_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $programCode);
    $stmt->execute();
    $result = $stmt->get_result();

    $years = [];
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['curriculum_year'];
    }

    header('Content-Type: application/json');
    echo json_encode($years);
    exit();
}
