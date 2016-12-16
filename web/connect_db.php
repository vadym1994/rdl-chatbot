<?php
$dbHost = 'ehc1u4pmphj917qf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';// чаще всего это так, но иногда требуется прописать ip адрес базы данных
$dbName = 'l6beyt7vz29lu019';// название вашей базы
$dbUser = 'ow1b2dd09o84kcod';// пользователь базы данных
$dbPass = 'righrl209f0to2id';// пароль пользователя
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
$mysqli->set_charset("utf8");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
printf("Host information: %s\n", $mysqli->host_info);

$result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
$row = $result->fetch_assoc();
$position = $row['position'];
?>