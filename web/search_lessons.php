<?php
function search($mysqli,$id,$reg_time,$message,$token){
//берем флаг
    $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
    $row = $result->fetch_assoc();
    $flag = $row['search_flag'];//флаг
    $lang = $row['locale'];//язык юзера

    if ($flag == "all") {
        $result = $mysqli->query("SELECT * FROM `lesson` WHERE lang = '".$lang."' ");
        $array = $result->fetch_all();
    } else {
        switch ($flag) {
            case "A1" :
                $flag = "A1 - Beginner";
                break;
            case "A2" :
                $flag = "A2 - Elementary";
                break;
            case "B1" :
                $flag = "B1 - Pre-Intermediate";
                break;
            case "B2" :
                $flag = "B2 - Intermediate";
                break;
            case "C1" :
                $flag = "C1 - Upper-Intermediate";
                break;
            case "C2" :
                $flag = "C2 - Advanced";
                break;
        }

        $result = $mysqli->query("SELECT * FROM `lesson` WHERE account = '".$flag."' and lang = '".$lang."' ");
        $array = $result->fetch_all();
    }

    $number = 0;
    for($i = 0; $i < count($array); $i++) {
        $search_on_title = stripos($array[$i][3],$message);
        $search_on_description = stripos($array[$i][4],$message);

        if ($search_on_title === false && $search_on_description === false) {
        } else {
            $lessons_id[$number] = $i;
            $number = $number + 1;
        }
    }
    if (count($lessons_id) > 0) {
        for ($i = 0; $i < count($lessons_id); $i++) {

            $lesson_start = array(
                "type" => "postback",
                'title' => "Start lesson",
                'payload' => "lesson_start_".$array[$lessons_id[$i]][1]);
            $keyboard = [$lesson_start];
            $elements[$i] = json_encode(array(
                    'image_url' => "https://rdl-dashboard.herokuapp.com/files/lessons/".$array[$lessons_id[$i]][2],
                    'title' => $array[$lessons_id[$i]][3],
                    'subtitle' => $array[$lessons_id[$i]][4],
                    'buttons' => $keyboard)
            );
            $payload = array('template_type' => "generic",
                'elements' => $elements);
            $attachment =array('type'=>"template",
                'payload' => $payload);
            $data = array('recipient' => array('id' => "$id"),
                'message' => array('attachment' => $attachment));
        }
    } else {
        $text = "Lessons are not found.";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
    }
    send($data, $token, $id, $mysqli, $reg_time);
}
?>