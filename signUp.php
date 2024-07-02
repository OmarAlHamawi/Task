<?php
require("connect.php");

if($_SERVER['REQUEST_METHOD']=='POST'){
$sql="INSERT INTO userinfo (username,email,password) values (:username,:email,:password)";
$statement=$pdo->prepare($sql);
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];

$statement->bindParam(":username",$username,PDO::PARAM_STR);
$statement->bindParam(":email",$email,PDO::PARAM_STR);
$statement->bindParam(":password",$password,PDO::PARAM_STR);
$statement->execute();


header("location:login.php");
}
