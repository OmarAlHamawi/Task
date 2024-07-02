<?php
session_start();
require 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['privileged'])) {
    header("Location: login.html");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $taskId = (int)$_POST['id'];
    $titel = trim($_POST['titel']);
    $descreption = trim($_POST['descreption']);

    if (empty($titel) || empty($descreption)) {
        die('Title and description are required.');
    }

    // Update the task in the database
    $sql = "UPDATE usertasks SET titel = :titel, descreption = :descreption WHERE id = :taskId AND userId = :userId";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':titel', $titel, PDO::PARAM_STR);
    $statement->bindValue(':descreption', $descreption, PDO::PARAM_STR);
    $statement->bindValue(':taskId', $taskId, PDO::PARAM_INT);
    $statement->bindValue(':userId', $_SESSION['privileged'], PDO::PARAM_INT);
    $statement->execute();

    // Redirect to the tasks page after update
    header("Location: MyTasks.php");
    exit();
}

// Check if task ID is provided
if (!isset($_GET['id'])) {
    die('Invalid request.');
}

$taskId = (int)$_GET['id'];

// Fetch the task details from the database
$sql = "SELECT * FROM usertasks WHERE id = :taskId AND userId = :userId";
$statement = $pdo->prepare($sql);
$statement->bindValue(':taskId', $taskId, PDO::PARAM_INT);
$statement->bindValue(':userId', $_SESSION['privileged'], PDO::PARAM_INT);
$statement->execute();
$task = $statement->fetch();

if (!$task) {
    die('Task not found or access denied.');
}

$titel = htmlspecialchars($task['titel']);
$descreption = htmlspecialchars($task['descreption']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="HomePage.css">
    <title>Edit Task</title>
</head>
<body>
    <form method="post" action="">
        <h2>Edit Task</h2>
        <input type="hidden" name="id" value="<?php echo $taskId; ?>"> <!-- Hidden input for task ID -->
        <h3>Title</h3>
        <input type="text" name="titel" value="<?php echo $titel; ?>" required> <!-- Display current title -->
        <h3>Description</h3>
        <input type="text" name="descreption" value="<?php echo $descreption; ?>" required> <!-- Display current description -->
        <button type="submit">Update Task</button>
    </form>
</body>
</html>
