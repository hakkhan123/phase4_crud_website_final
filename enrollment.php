<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='assets/style.css'>
<script src='assets/validate.js'></script><title>Manage Enrollments</title></head>
<body>
    <h2>Add Enrollment</h2>
    <form onsubmit="return validateForm()" method="post">
        Enrollment ID: <input type="number" name="enrollment_id"><br><br>
        Student ID: <input type="number" name="student_id"><br><br>
        Course ID: <input type="number" name="course_id"><br><br>
        Grade: <input type="text" name="grade"><br><br>
        <input type="submit" name="submit" value="Add Enrollment">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $id = $_POST['enrollment_id'];
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $grade = $_POST['grade'];

        $sql = "INSERT INTO enrollment (Enrollment_ID, Student_ID, Course_ID, Grade)
                VALUES ('$id', '$student_id', '$course_id', '$grade')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Enrollment added successfully.</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
    ?>

    
    <?php
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->query("DELETE FROM enrollment WHERE Enrollment_ID = '$id'");
    }
    ?>
    <h2>All Enrollments</h2>
    
    <table border="1">
        <tr><th>ID</th><th>Student ID</th><th>Course ID</th><th>Grade</th></tr><th>Action</th>
        <?php
        $result = $conn->query("SELECT * FROM enrollment");
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['Enrollment_ID']}</td><td>{$row['Student_ID']}</td><td>{$row['Course_ID']}</td><td>{$row['Grade']}</td><td><a href='?delete={$row['Enrollment_ID']}'>Delete</a></td></tr>";
        }
        ?>
    </table>
</body>
</html>