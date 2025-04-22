<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $credits = $_POST['credits'];
    $dept = $_POST['department'];
    $prof_id = $_POST['professor_id'];

    // Check if Professor exists
    $check = $conn->prepare("SELECT * FROM Professors WHERE Professor_ID = ?");
    $check->bind_param("i", $prof_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Professor ID does not exist. Please add the professor first.'); window.location.href='courses.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO Courses (Course_ID, Course_Name, Credits, Department, Professor_ID)
                            VALUES (?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE Course_Name=VALUES(Course_Name), Credits=VALUES(Credits), Department=VALUES(Department), Professor_ID=VALUES(Professor_ID)");
    $stmt->bind_param("isisi", $id, $name, $credits, $dept, $prof_id);
    $stmt->execute();
    $stmt->close();

    header("Location: courses.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Check if course is referenced in Enrollment
    $check = $conn->prepare("SELECT * FROM Enrollment WHERE Course_ID = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Cannot delete course. It is referenced in enrollment.'); window.location.href='courses.php';</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM Courses WHERE Course_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: courses.php");
        exit();
    }
}

$result = $conn->query("SELECT * FROM Courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h2>Add New Course</h2>
<form method="POST" action="courses.php">
    <label>Course ID:</label><input type="number" name="id" required><br>
    <label>Name:</label><input type="text" name="name" required><br>
    <label>Credits:</label><input type="number" name="credits" required><br>
    <label>Department:</label><input type="text" name="department" required><br>
    <label>Professor ID:</label><input type="number" name="professor_id" required><br>
    <button type="submit">Add Course</button>
</form>

<h2>All Courses</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Credits</th><th>Department</th><th>Professor ID</th><th>Actions</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['Course_ID'] ?></td>
    <td><?= $row['Course_Name'] ?></td>
    <td><?= $row['Credits'] ?></td>
    <td><?= $row['Department'] ?></td>
    <td><?= $row['Professor_ID'] ?></td>
    <td>
        <a href="?delete=<?= $row['Course_ID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
