<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='assets/style.css'>
<script src='assets/validate.js'></script>
    <title>Manage Students</title>
</head>
<body>
    <h2>Add or Update Student</h2>
    <form onsubmit="return validateForm()" method="post">
        Student ID: <input type="number" name="student_id" required><br><br>
        Name: <input type="text" name="name"><br><br>
        Email: <input type="email" name="email"><br><br>
        Major: <input type="text" name="major"><br><br>
        Enrollment Year: <input type="number" name="enrollment_year"><br><br>
        <input type="submit" name="submit" value="Add or Update Student">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $id = $_POST['student_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $major = $_POST['major'];
        $year = $_POST['enrollment_year'];

        $check = $conn->query("SELECT * FROM students WHERE Student_ID = '$id'");
        if ($check->num_rows > 0) {
            $sql = "UPDATE students SET Name='$name', Email='$email', Major='$major', Enrollment_Year='$year' WHERE Student_ID='$id'";
        } else {
            $sql = "INSERT INTO students (Student_ID, Name, Email, Major, Enrollment_Year)
                    VALUES ('$id', '$name', '$email', '$major', '$year')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<p>Student saved successfully.</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->query("DELETE FROM students WHERE Student_ID = '$id'");
    }
    ?>

    <h2>All Students</h2>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Major</th><th>Year</th><th>Action</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM students");
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['Student_ID']}</td><td>{$row['Name']}</td><td>{$row['Email']}</td>
            <td>{$row['Major']}</td><td>{$row['Enrollment_Year']}</td>
            <td><a href='?delete={$row['Student_ID']}'>Delete</a></td></tr>";
        }
        ?>
    </table>
</body>
</html>