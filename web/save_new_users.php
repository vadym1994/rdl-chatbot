<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 24.11.2016
 * Time: 17:16
 */

$result = $mysqli->query("SELECT * FROM users WHERE `id_fb` = '".$id."' ");
$row = $result->fetch_assoc();
$name = $row['first_name'];
$reg_time = date("D M j Y - G:i:s");
$last_time = time();
//$last_time = date("Y-m-d H:i:s");

if(!(count($row) > 0) ){
    $user_info = "https://graph.facebook.com/v2.6/".$id."?access_token=".$token;
    $user_info = file_get_contents($user_info);
    $user_info = json_decode($user_info);
    //получение информации про юзера
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $profile_pic = $user_info->profile_pic;
    $locale = explode("_", $user_info->locale);
    $gender = $user_info->gender;
    $timezone = $user_info->timezone;
    //инсерт информации про юзера в бд
    $sql  = "INSERT INTO `users` SET ";
    $sql  .= " `id_fb` = '".$id."' ,";
    $sql  .= " `first_name` = '".$first_name."' ,";
    $sql  .= " `last_name` = '".$last_name."' ,";
    $sql  .= " `full_name` = '".$first_name." ".$last_name."' ,";
    $sql  .= " `profile_pic` = '".$profile_pic."' ,";
    $sql  .= " `gender` = '".$gender."' ,";
    $sql  .= " `locale` = '".$locale[1]."' ,";
    $sql  .= " `timezone` = '".$timezone."' ,";
    $sql  .= " `reg_time` = '".$reg_time."' ,";
    $sql  .= " `setup` = false ,";
    $sql  .= " `status` = true ";
    $result = $mysqli->query($sql);

    //инсерт информации про время сообщения
    $sql  = "INSERT INTO `last_time` SET ";
    $sql  .= " `id_fb` = '".$id."' ,";
    $sql  .= " `time` = '".$last_time."' ";
    $result = $mysqli->query($sql);
}else{
}
?>