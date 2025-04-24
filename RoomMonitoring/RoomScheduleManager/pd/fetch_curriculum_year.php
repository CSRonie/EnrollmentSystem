<?php
// curriculum_years.php
session_start();
if (file_exists('../../../includes/db_connection.php')) {
    require_once '../../../includes/db_connection.php';
} else {
    die('Database connection file not found!');
}

// Check if program code is provided
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['course_code'])) {
    $courseCode = $_GET['course_code'];

    // Fetch the course ID based on course code
    $courseQuery = "SELECT id FROM courses WHERE course_code = ?";
    $courseStmt = $conn->prepare($courseQuery);
    $courseStmt->bind_param("s", $courseCode);
    $courseStmt->execute();
    $courseResult = $courseStmt->get_result();

    if ($courseResult->num_rows > 0) {
        $course = $courseResult->fetch_assoc();
        $courseId = $course['id'];

        // Fetch curriculum years for the course
        $curriculumQuery = "SELECT curriculum_year_start, curriculum_year_end FROM curriculum_years WHERE course_id = ?";
        $curriculumStmt = $conn->prepare($curriculumQuery);
        $curriculumStmt->bind_param("i", $courseId);
        $curriculumStmt->execute();
        $curriculumResult = $curriculumStmt->get_result();

        $curriculumYears = [];
        while ($row = $curriculumResult->fetch_assoc()) {
            $curriculumYears[] = [
                'start' => $row['curriculum_year_start'],
                'end' => $row['curriculum_year_end']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($curriculumYears);
    } else {
        echo json_encode([]);
    }
    exit();
}
