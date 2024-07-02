<?php
session_start();
require("connect.php");

if(isset($_POST['login'])){
    $sql = "SELECT id, username, email, password FROM userinfo WHERE username = :username";
    $statement = $pdo->prepare($sql);
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $statement->bindParam(":username", $username, PDO::PARAM_STR);
    $statement->execute();

    // Fetch user data
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $password) {
        $_SESSION['privileged'] = $user['id'];
        header("Location: HomePage.html");
        exit();
    } else {
        echo "<h2 style='color:red'>Invalid username or password</h2>";
    }
    $pdo = null;
}
?>
