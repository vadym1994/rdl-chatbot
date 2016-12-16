<?php
//запись сообщения юзера в базу
if ($payload != '') {
    $sql = "INSERT INTO `chats` SET  `id_fb` = '" . $id . "', `date` = '" . $reg_time . "', `isUser` = 1 ,  
    `message` = '" . $payload . "'";
    $result = $mysqli->query($sql);

} else if ($message != '') {
    $sql = "INSERT INTO `chats` SET  `id_fb` = '" . $id . "', `date` = '" . $reg_time . "', `isUser` = 1 ,  
    `message` = '" . $message . "'";
    $result = $mysqli->query($sql);
}

//апдейт время
$sql  = "UPDATE `last_time` SET `time` = '".$last_time."' WHERE `id_fb` = '".$id."' ";
$result = $mysqli->query($sql);
?>