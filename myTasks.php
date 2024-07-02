<?php
session_start();
if (!isset($_SESSION['privileged'])) {
    header("location:login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MyTask.css">
    <title>My Tasks</title>
</head>
<body>
    <?php
    require 'connect.php';
    
    // Ensure table and column names are correct
    $sql = "SELECT * FROM usertasks WHERE userId = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $_SESSION['privileged']);
    $statement->execute();
    $data = $statement->fetchAll();
    
    foreach ($data as $row) {
        $taskid = $row['id'];
        $taskTitel = htmlspecialchars($row['titel']);
        $taskDescreption = htmlspecialchars($row['descreption']);
        echo "<div>";
        echo "<h3>$taskTitel</h3>";
        echo "<h5>$taskDescreption</h5>";
        echo "<a href='editTask.php?id=$taskid'>Edit</a>";
        echo "<form method='post' action='removeTask.php'>" .
             "<input type='hidden' name='id' value='$taskid'>" .
             "<button type='submit'>Delete</button>" .
             "</form>";
        echo "</div>";
    }
    ?>
</body>
</html>
<?php


?>
