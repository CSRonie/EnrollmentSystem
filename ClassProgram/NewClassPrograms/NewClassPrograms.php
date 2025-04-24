<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Faculty', 'Registrar']);

if (file_exists('../../includes/db_connection.php')) {
    require_once '../../includes/db_connection.php';
} else {
    die('Database connection file not found!');
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header("Location: http://localhost/capst/index.php");
    exit();
}

// Fetch education
$queryEducations = "SELECT id, level_name FROM education_levels";
$resultEducation = $conn->query($queryEducations);

// Fetch courses
$queryCourses = "SELECT course_code, course_name FROM courses";
$resultCourse = $conn->query($queryCourses);

// Fetch majors
$queryMajors = "SELECT id, education_level_id, major_name FROM majors";
$resultMajor = $conn->query($queryMajors);

// Fetch curriculum_years
$queryCurriculumYears = "SELECT id, course_id, curriculum_year_start, curriculum_year_end FROM curriculum_years";
$resultCurriculumYear = $conn->query($queryCurriculumYears);

// Fetch subjects
$querySubjects = "SELECT subject_code, subject_name FROM subjects";
$resultSubject = $conn->query($querySubjects);

// Fetch rooms
$queryRoomTypes = "SELECT DISTINCT room_type FROM rooms WHERE status IS NULL OR status != 'Unavailable'";
$resultRoomType = $conn->query($queryRoomTypes);

// Fetch rooms
$queryRoomNos = "SELECT id, room_number FROM rooms WHERE status IS NULL OR status != 'Unavailable'";
$resultRoomNo = $conn->query($queryRoomNos);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Class Programs</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Load Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Load Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <nav id="navbar-placeholder">
        <p>Loading navbar...</p>
    </nav>

    <div class="main-content" id="mainContent">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Enrollment</a></li>
                <li><a href="#">Class Program</a></li>
                <li class="active">New Class Programs/Sections Page</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>NEW CLASS PROGRAMS/SECTIONS</h1>
        </section>

        <!-- Form container -->
        <div class="form-container">
            <div class="checkbox-container flex items-center">
                <input type="checkbox" id="international" class="mr-2">
                <label for="international">Check for International/Additional subject offerings/schedules (offerings for all courses)</label>
            </div>
            <form action="#">
                <!-- Two-column layout for form fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left column inputs -->
                    <div>
                        <div class="form-group">
                            <label for="courseprog">Course Program (Optional to Select)</label>
                            <select id="courseprog">
                                <option value="" disabled selected>Select a Program</option>
                                <?php while ($row = $resultEducation->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['level_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="major">Major</label>
                            <select id="major">
                                <option value="" disabled selected>Select</option>
                                <?php while ($row = $resultMajor->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['major_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="year">Year *</label>
                            <select id="year" required>
                                <option value="" disabled selected>Select</option>
                                <option value="A">1st</option>
                                <option value="B">2nd</option>
                                <option value="C">3rd</option>
                                <option value="D">4th</option>
                                <option value="E">5th</option>
                                <option value="F">6th</option>
                                <option value="G">7th</option>
                                <option value="H">8th</option>
                            </select>
                        </div>

                        <hr>

                        <div class="flex">
                            <div class="label label-input" style="flex-grow: 1;">
                                <label for="classprogramsy1">Class Program for SY *</label>
                                <input type="text" id="classprogramsy1" placeholder="Start Year" required>
                            </div>
                            <div class="label label-input" style="flex-grow: 0.2;">
                                <span>-</span>
                                <input type="text" id="classprogramsy2" placeholder="End Year" required>
                            </div>

                        </div>

                        <div class="flex">
                            <div class="label label-input" style="flex-grow: 1;">
                                <label for="classprogramsy1">Subject *</label>

                                <input list="options" id="subject" name="combinedInput" placeholder="Type or select">
                                <datalist id="options">
                                    <?php while ($row = $resultSubject->fetch_assoc()): ?>
                                        <option value="<?php echo $row['subject_code'];
                                                        echo " - ";
                                                        echo $row['subject_name'] ?>">

                                        </option>
                                    <?php endwhile; ?>
                                </datalist>
                            </div>
                        </div>

                        <!-- Align Subject -->

                        <div class="form-group">
                            <label for="subjectttle">Subject Title:</label>
                        </div>
                        <div class="form-group">
                            <label for="subjectofferingtype">Subject Offering Type</label>
                            <select id="subjectofferingtype" required>
                                <option value="" disabled selected>Select</option>
                                <option value="a">Regular Subject</option>
                                <option value="b">Irregular Subject</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subjectcreated">Subject created by College:</label>
                            <span>College of</span>
                        </div>

                        <div class="form-group">
                            <label for="schedulecreated">Schedule Created by Department</label>
                            <span>All Departments</span>
                        </div>
                        <div class="form-group">
                            <label for="schedulewk">Schedule (M-T-W-TH-F-SAT-SUN) *</label>
                            <input type="text" id="schedulewk" placeholder="Enter by Mon, Tues etc." required>
                        </div>
                        <div class="form-group">
                            <label for="roomno">Room No (Optional)</label>
                            <select id="roomno">
                                <option value="" disabled selected>Select</option>
                                <?php while ($row = $resultRoomNo->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['room_number']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Right column inputs -->
                    <div>
                        <div class="form-group">
                            <label for="offeringcourses">Offerings for Course *</label>
                            <select id="offeringcourses" required>
                                <option value="" disabled selected>Select Course Offering</option>
                                <?php while ($row = $resultCourse->fetch_assoc()): ?>
                                    <option value="<?php echo $row['course_code']; ?>">
                                        <?php echo $row['course_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="curryear">Curriculum Year *</label>
                            <select id="curryear">
                                <option value="" disabled selected>Select</option>
                                <?php while ($row = $resultCurriculumYear->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['curriculum_year_start'];
                                        echo " - ";
                                        echo $row['curriculum_year_end']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="term">Term *</label>
                            <select id="term" required>
                                <option value="" disabled selected>Select</option>
                                <option value="A">1st</option>
                                <option value="B">2nd</option>
                                <option value="C">3rd</option>
                                <option value="D">Summer</option>
                            </select>
                        </div>

                        <hr>

                        <div class="label label-input" style="flex-grow: 0.4;">
                            <label for="semester">Semester *</label>
                            <select id="semester" required>
                                <option value="" disabled selected>Select</option>
                                <option value="1">1st Semester</option>
                                <option value="2">2nd Semester</option>
                            </select>
                        </div>


                        <!-- Align Section directly below Term, right-aligned -->
                        <div class="form-group">
                            <label for="subcomponent">Subject Component *</label>
                            <select id="subcomponent" required>
                                <option value="" disabled selected>Select</option>
                                <?php while ($row = $resultRoomType->fetch_assoc()): ?>
                                    <option value="<?php echo $row['room_type']; ?>">
                                        <?php echo $row['room_type']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="checkbox-container flex items-center">
                            <input type="checkbox" id="requestedsub" class="mr-2">
                            <label for="requestedsub">Is Requested Subject?</label>
                        </div>
                        <div class="form-group">
                            <label for="section">Section *</label>
                            <select id="section" required>
                                <option value="" disabled selected>Select Section</option>
                                <option value="A">1BSIT-1</option>
                                <option value="B">1BSIT-2</option>
                                <option value="C">1BSIT-3</option>
                                <option value="D">1BSIT-4</option>
                            </select>
                            <div class="flex-container" style="flex-grow: 0.2; display: flex; flex-direction: row; gap: 10px">
                                <a href="#" onclick="openPopup()" class="bi bi-pencil-square" style="margin-top: 7px;">
                                    -Click to edit sections
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subjectcategory">Subject Category:</label>
                            <span>CCS Computer Laboratory</span>
                        </div>
                        <div class="form-group" style="display: flex; gap: 10px; align-items: center;">
                            <div>
                                <label for="time_input1" style="margin-top: 23px;">Time from *</label>
                                <input type="time" id="time_input1" name="time_input1" required>
                            </div>
                            <div>
                                <label for="time_input2" style="margin-top: 23px;">Time to *</label>
                                <input type="time" id="time_input2" name="time_input-2" required>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <div class="form-actions">
                <button class="bi bi-file-earmark-plus" id="add-btn" type="submit" style="margin-top: 7px; background-color: #174069;"> Add</button>
            </div>
        </div>

        <script>
            // Load navbar dynamically
            (function loadNavbar() {
                fetch('../../Components/Navbar.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Navbar.html does not exist or is inaccessible');
                        }
                        return response.text();
                    })
                    .then(html => {
                        document.getElementById('navbar-placeholder').innerHTML = html;

                        // Dynamically load app.js if not already loaded
                        if (!document.querySelector('script[src="../../Components/app.js"]')) {
                            const script = document.createElement('script');
                            script.src = '../../Components/app.js';
                            script.defer = true;
                            document.body.appendChild(script);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading navbar:', error);
                        document.getElementById('navbar-placeholder').innerHTML =
                            '<p style="color: red; text-align: center;">Navbar could not be loaded.</p>';
                    });
            })();

            // Function to handle checkbox state and redirect accordingly
            document.getElementById('international').addEventListener('change', function() {
                if (this.checked) {
                    // Redirect to International New Class Programs page when checked
                    window.location.href = "InternationalNewClassPrograms.php";
                } else {
                    // Redirect back to New Class Programs page when unchecked
                    window.location.href = "NewClassPrograms.php";
                }
            });

            // Allow manual updates by the user
            classProgramSY1.addEventListener('input', function() {
                const startYear = parseInt(classProgramSY1.value);
                if (!isNaN(startYear)) {
                    classProgramSY2.value = startYear + 1; // Automatically adjust the end year
                } else {
                    classProgramSY2.value = ''; // Clear if the input is invalid
                }
            });

            // Function to update end year based on curriculum year selection
            function updateEndYear() {
                const currYearSelect = document.getElementById('curryear');
                const endYearInput = document.getElementById('curryear-end');
                const startYear = parseInt(currYearSelect.value);
                if (startYear) {
                    endYearInput.value = startYear + 1; // Set end year as start year + 1
                } else {
                    endYearInput.value = ""; // Clear if no selection
                }
            }

            function openPopup() {
                // URL of the page you want to open
                const url = 'SectionEditor.php'; // Replace with your popup page URL
                const options = 'width=1200,height=800,resizable=yes,scrollbars=yes'; // Customize the dimensions
                window.open(url, 'PopupWindow', options);
            }
        </script>

</body>

</html>

<!-- CSS styling -->
<style scoped>
    /* Breadcrumb styles */
    .breadcrumb-nav {
        margin: 0;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .breadcrumb {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        padding: 0;
    }

    .breadcrumb li {
        margin-right: 10px;
    }

    .breadcrumb li a {
        color: #174069;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb li a:hover {
        color: #20568B;
    }

    .breadcrumb li.active {
        color: orange;
        pointer-events: none;
    }

    .breadcrumb li::after {
        content: ">";
        margin-left: 10px;
        color: #174069;
    }

    .breadcrumb li:last-child::after {
        content: "";
    }

    /* Section Header */
    .section-header {
        background-color: #174069;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .section-header h1 {
        color: white;
        margin: 0;
    }

    /* Form styles */
    .form-container {
        width: 80%;
        margin: 40px auto;
        background-color: #f4f8fc;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group half {
        width: 50%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .label input,
    .label select {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        /* Ensure inputs take up full width inside their containers */
    }

    .flex {
        display: flex;
        gap: 5px;
        /* Maintain close proximity between elements */
        flex-wrap: nowrap;
        /* Prevent wrapping */
        width: 100%;
        /* Ensure the flex container is responsive */
    }


    .ml-1 {
        margin-left: 0;
        /* Remove any additional left margin */
        flex-grow: 1;
        /* Allow input fields to grow as needed */
    }

    .flex-grow {
        flex-grow: 1;
    }

    .empty-row {
        height: 75px;
        /* Adjust the height as needed */
    }



    input[readonly] {
        background-color: #aaa7a7;
        /* Light gray background for readonly input */
    }

    /* Checkboxes */
    .checkbox-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
    }

    .checkbox-container input {
        margin-right: 5px;
    }

    /* Button styles */
    .form-actions button {
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .showsub {
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #174069;
        /* Blue background */
        color: white;
        /* White text */
        width: 150px;
        /* Adjust button width */
        height: 45px;
        /* Adjust button height */
    }

    .showsub:hover {
        background-color: #0056b3;
        /* Darker blue on hover */
    }

    .flex-container {
        display: flex;
        align-items: left;
        justify-content: flex-start;
        margin-top: 10px;
    }

    /* Make the time inputs stack vertically */
    .form-group#time-group {
        display: flex;
        flex-direction: column;
        /* Stack items vertically */
        gap: 10px;
        /* Space between Time From and Time To */
    }

    .form-group#time-group div {
        display: flex;
        flex-direction: column;
        /* Ensure each label and input is stacked vertically */
    }

    .form-group#time-group label {
        margin-bottom: 5px;
    }

    .form-group#time-group input {
        width: 100%;
    }
</style>