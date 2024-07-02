<?php
session_start();
require("connect.php");
$sql = "INSERT INTO usertasks (titel, descreption, userId) VALUES (:titel, :descreption, :userId)";

        $userId = $_SESSION['privileged'];
        $titel = $_POST['title'];
        $descreption = $_POST['description'];

        $statement=$pdo->prepare($sql);
        $statement->bindValue(":titel", $titel, PDO::PARAM_STR);
        $statement->bindValue(":descreption", $descreption, PDO::PARAM_STR);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();
        $pdo=null;
        header("location:HomePage.html");
?>
