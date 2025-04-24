<?php
// rooms.php
session_start();
if (file_exists('../../../includes/db_connection.php')) {
    require_once '../../../includes/db_connection.php';
} else {
    die('Database connection file not found!');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['course_code'])) {
    $courseCode = $_GET['course_code'];

    // Fetch rooms (adjust logic if rooms are tied to courses in your schema)
    $roomsQuery = "SELECT id, room_number FROM rooms WHERE status IS NULL OR status != 'Unavailable'";
    $roomsResult = $conn->query($roomsQuery);

    $rooms = [];
    while ($row = $roomsResult->fetch_assoc()) {
        $rooms[] = [
            'id' => $row['id'],
            'number' => $row['room_number']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($rooms);
    exit();
}
