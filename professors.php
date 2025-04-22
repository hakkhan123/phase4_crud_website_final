<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept = $_POST['department'];

    $stmt = $conn->prepare("INSERT INTO Professors (Professor_ID, Name, Email, Department)
                            VALUES (?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE Name=VALUES(Name), Email=VALUES(Email), Department=VALUES(Department)");
    $stmt->bind_param("isss", $id, $name, $email, $dept);
    $stmt->execute();
    $stmt->close();
    header("Location: professors.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $check = $conn->prepare("SELECT * FROM Courses WHERE Professor_ID = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Cannot delete professor. They are assigned to a course.'); window.location.href='professors.php';</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM Professors WHERE Professor_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: professors.php");
        exit();
    }
}

$result = $conn->query("SELECT * FROM Professors");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Professors</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h2>Add New Professor</h2>
<form method="POST" action="professors.php">
    <label>Professor ID:</label><input type="number" name="id" required><br>
    <label>Name:</label><input type="text" name="name" required><br>
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Department:</label><input type="text" name="department" required><br>
    <button type="submit">Add Professor</button>
</form>

<h2>All Professors</h2>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Department</th><th>Actions</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['Professor_ID'] ?></td>
    <td><?= $row['Name'] ?></td>
    <td><?= $row['Email'] ?></td>
    <td><?= $row['Department'] ?></td>
    <td>
        <a href="?delete=<?= $row['Professor_ID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>