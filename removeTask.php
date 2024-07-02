<?php
require 'connect.php';
$sql="DELETE FROM usertasks WHERE id=:id";

$id=$_POST['id'];
$statement=$pdo->prepare($sql);
$statement->bindParam(":id",$id, PDO::PARAM_INT);
$statement->execute();
$pdo=null;

header("location:myTasks.php");
?>