<?php

file_put_contents("fb.txt",file_get_contents("php://input"));
$fb = file_get_contents("fb.txt");
$fb = json_decode($fb);
$id = $fb->entry[0]->messaging[0]->sender->id;
$reid = $fb->entry[0]->messaging[0]->recipient->id;
$message = $fb->entry[0]->messaging[0]->message->text;
$payload = $fb->entry[0]->messaging[0]->postback->payload;
$payload_quick = $fb->entry[0]->messaging[0]->message->quick_reply->payload;

$token = "EAAPCcsph9SEBACkbwa3THaRHSHyInMiA8JCci34UnmzPi0hkwyZBYTIovAoOHTjRuDFZBZCMizMTk4ZC4rV9vrVcrt4tddovUeVWLk261aH9EiqM4JrfFec4ExxCphnzkEqFKU6lxblF4qiXasleMPUgSHbiD9v45qiN1D5UtwZDZD";
$fp = json_decode(file_get_contents('user.json'), true);

//connection to db
require('connect_db.php');
//saving users
require('save_new_users.php');
//saving user message
require('save_user_message.php');
//require buttons
require('buttons.php');

//проверяем есть ли слово Search в запросе
$Search = strpos($payload, "Search");
$latest_lessons = strpos($payload, "Latest Lessons");

if ($payload == "Get Started" || $payload == "Home") {
    if ($payload == "Get Started") {
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => "Hi " . $name . "! Here are some links to get you sterted."));
        send($data, $token, $id, $mysqli, $reg_time);
    }

    $elements[0] = json_encode(array(
        'title' => 'Welcome to the Real Deal English Bot!',
        'image_url' => 'https://files.slack.com/files-pri/T0LBY3E64-F3BVDNDHD/menu1.jpg',
        'subtitle' => 'I will help you learn English at your convenience.',
        'buttons' => $keyboard1)
    );
    $elements[1] = json_encode(array(
        'image_url' => "https://files.slack.com/files-pri/T0LBY3E64-F3BBRFTC5/menu2.jpg",
        'item_url' => "http://realdealenglish.com",
        'title' => "We are busy in the studio!",
        'subtitle' => "There are new lessons every week! All lessons are based on rear life convers...",
        'buttons' => $keyboard2)
    );
    $elements[2] = json_encode(array(
        'image_url' => "https://files.slack.com/files-pri/T0LBY3E64-F3B777JBV/menu3.jpg",
        'title' => "Do tuo want to build a training bot like this for yourself?",
        'subtitle' => "Get in touch with us!",
        'buttons' => $keyboard3)
    );

    $payload = array('template_type' => "generic",
                     'elements' => $elements);
          
    $attachment =array('type'=>"template",
                       'payload' => $payload);

    $data = array('recipient' => array('id' => "$id"),
                  'message' => array('attachment' => $attachment));
    send($data,$token,$id,$mysqli,$reg_time);
    $position = $mysqli->query("UPDATE users SET `position` = ' ' WHERE id_fb = " . $id . " ");
} elseif ($payload == "Watch Intro") {
	
	$video = array('url' => 'https://web-performers.com/BotRDL/web/video/Inside.mp4');

	$attachment = array('type'=>"video",
					   'payload' => $video);

    $data = array('recipient' => array('id' => "$id"),
                  'message' => array('attachment' => $attachment));
    send($data,$token,$id,$mysqli,$reg_time);

} elseif ($payload == "Get Setup") {
    $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
    $row = $result->fetch_assoc();
    $setup = $row['setup'];
        $text = "What is your English level?\nA1 - Beginner\nA2 - Elementary\nB1 - Pre-Intermediate\nB2 - Intermediate\nC1 - Upper-Intermediate\nC2 - Advanced";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text,
                'quick_replies' => $keyboard_level));
        send($data, $token, $id, $mysqli, $reg_time);
        $position = $mysqli->query("UPDATE users SET `position` = 'setup 1' WHERE id_fb = " . $id . " ");

} elseif ($payload_quick == "A1" || $payload_quick == "A2" || $payload_quick == "B1" || $payload_quick == "B2" || $payload_quick == "C1" || $payload_quick == "C2") {
    $text = "What is your primary goal for English?";
    $data = array('recipient' => array('id' => "$id"),
        'message' => array('text' => $text));
    send($data,$token,$id,$mysqli,$reg_time);
    $mysqli->query("UPDATE users SET `target_language_level` = '".$payload_quick."', `position` = 'setup 2' WHERE id_fb = ".$id." ");

} elseif ($position == "setup 2") {
    if ($message != "") {
        $text = "What are some topics you are interested in?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
        send($data,$token,$id,$mysqli,$reg_time);
        $mysqli->query("UPDATE users SET `target_learning_goal` = '".$message."', `position` = 'setup 3' WHERE id_fb = ".$id." ");
    } else {
        $text = "What is your primary goal for English?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
        send($data,$token,$id,$mysqli,$reg_time);
    }
} elseif ($position == "setup 3") {
    if ($message != "") {
        $text = "Ready to study a lesson?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text,
                               'quick_replies'=> $keyboard_yes_no));
        send($data,$token,$id,$mysqli,$reg_time);
        $mysqli->query("UPDATE users SET `target_english_interests` = '".$message."', `position` = 'setup complete',  `setup` = true WHERE id_fb = ".$id." ");
    } else {
        $text = "What is your primary goal for English?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
        send($data,$token,$id,$mysqli,$reg_time);
        $mysqli->query("UPDATE users SET `position` = ' ' WHERE id_fb = ".$id." ");
    }
} elseif (($payload_quick == "Yes" && $position == "setup complete") || $payload == "Next Lesson" || $payload == "Random A1" || $payload == "Random A2" || $payload == "Random B1" || $payload == "Random B2" || $payload == "Random C1" || $payload == "Random C2") {
    $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = " . $id . " ");
    $row = $result->fetch_assoc();
    $setup = $row['setup'];
    if ($setup == true) {
        if ($payload == "Next Lesson" || $payload_quick == "Yes") {
            //берем флаг
            $flag = $row['search_flag'];//флаг
            $lang = $row['locale'];//язык юзера
        } else {
            $payload = explode(" ", $payload);
            $flag = $payload[1];
            $lang = $row['locale'];//язык юзера
        }
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
        $result = $mysqli->query("SELECT * FROM `lesson` WHERE account = '" . $flag . "' and lang = '" . $lang . "' ");
        $array = $result->fetch_all();
        if (count($array) < 1) {
            $data = array('recipient' => array('id' => "$id"),
                'message' => array('text' => "Lesson is not found."));
        } else {
            $rand_index = array_rand($array, 1);

            $lesson_start = array(
                "type" => "postback",
                'title' => "Start lesson",
                'payload' => "lesson_start_" . $array[$rand_index][1]);
            $keyboard = [$lesson_start];
            $elements[0] = json_encode(array(
                    'image_url' => "https://rdl-dashboard.herokuapp.com/files/lessons/" . $array[$rand_index][2],
                    'title' => $array[$rand_index][3],
                    'subtitle' => $array[$rand_index][4],
                    'buttons' => $keyboard)
            );
            $payload = array('template_type' => "generic",
                'elements' => $elements);
            $attachment = array('type' => "template",
                'payload' => $payload);
            $data = array('recipient' => array('id' => "$id"),
                'message' => array('attachment' => $attachment));
        }
    } else {
        $text = "Please complete setup first.";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
        send($data,$token,$id,$mysqli,$reg_time);

        $text = "What is your English level?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text,
                'quick_replies' => $keyboard_level));
    }
    send($data,$token,$id,$mysqli,$reg_time);

    $position = $mysqli->query("UPDATE users SET `position` = 'setup 1' WHERE id_fb = " . $id . " ");

} elseif ($position == "setup complete") {
    if ($payload_quick == "No") {
        $text = "Okey";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
        send($data,$token,$id,$mysqli,$reg_time);
    } else {
        $text = "Ready to study a lesson?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text,
                'quick_replies'=> $keyboard_yes_no));
        send($data,$token,$id,$mysqli,$reg_time);
    }
} elseif ($payload == "Browse Lessons") {
    $elements[0] = json_encode(array(
            'title' => 'A1 - Beginner',
            'buttons' => $keyboard_A1)
    );
    $elements[1] = json_encode(array(
            'title' => "A2 - Elementary",
            'buttons' => $keyboard_A2)
    );
    $elements[2] = json_encode(array(
            'title' => "B1 - Pre-Intermediate",
            'buttons' => $keyboard_B1)
    );
    $elements[3] = json_encode(array(
            'title' => "B2 - Intermediate",
            'buttons' => $keyboard_B2)
    );
    $elements[4] = json_encode(array(
            'title' => "C1 - Upper-Intermediate",
            'buttons' => $keyboard_C1)
    );
    $elements[5] = json_encode(array(
            'title' => "C2 - Advanced",
            'buttons' => $keyboard_C2)
    );

    $payload = array('template_type' => "generic",
        'elements' => $elements);

    $attachment =array('type'=>"template",
        'payload' => $payload);

    $data = array('recipient' => array('id' => "$id"),
        'message' => array('attachment' => $attachment));
    send($data,$token,$id,$mysqli,$reg_time);

    $position = $mysqli->query("UPDATE users SET `position` = ' ' WHERE id_fb = " . $id . " ");
} elseif ($Search === 0) {
    //записываем флаг для поиска
    if($payload == "Search") {
//        //если просто поиск, то флаг - это уровень юзера
//        $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
//        $row = $result->fetch_assoc();
//        $level = $row['target_language_level'];//уровень юзера
//        $mysqli->query("UPDATE users SET `search_flag` = '".$level."' WHERE id_fb = " . $id . " ");
        $mysqli->query("UPDATE users SET `search_flag` = 'all' WHERE id_fb = " . $id . " ");
    } else {
        //если поиски по определенному уровню, то этот уровень и есть флаг
        $array = explode(" ", $payload);
        $level = $array[1];
        $mysqli->query("UPDATE users SET `search_flag` = '".$level."' WHERE id_fb = " . $id . " ");
    }

    $text = "Please enter a keyword to search for.";
    $data = array('recipient' => array('id' => "$id"),
        'message' => array('text' => $text));

    send($data, $token, $id, $mysqli, $reg_time);
    $position = $mysqli->query("UPDATE users SET `position` = 'search' WHERE id_fb = " . $id . " ");

} elseif ($position == "search" && $message != "") {
    require('search_lessons.php');
    search($mysqli,$id,$reg_time,$message,$token);
    $position = $mysqli->query("UPDATE users SET `position` = ' ' WHERE id_fb = " . $id . " ");

} elseif ($latest_lessons === 0){
    //берем флаг
    $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
    $row = $result->fetch_assoc();
    $flag = $row['search_flag'];//флаг
    $lang = $row['locale'];//язык юзера

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
    //берем все уроки данной темы
    $result = $mysqli->query("SELECT * FROM `lesson` WHERE account = '".$flag."' and lang = '".$lang."' ");
    $array = $result->fetch_all();
    if(count($array) > 0) {
        //Получаем массив с айди уроковв
        for ($i = 0; $i < count($array); $i++) {
            $array[$i] = $array[$i][0];
        }
        $latest_lesson_id = max($array);//наибольший айди
        //берем урок с наибольшим айди
        $result = $mysqli->query("SELECT * FROM `lesson` WHERE id = " . $latest_lesson_id . " ");
        $array = $result->fetch_assoc();

        $lesson_start = array(
            "type" => "postback",
            'title' => "Start lesson",
            'payload' => "lesson_start_" . $array['id']);
        $keyboard = [$lesson_start];
        $elements[$i] = json_encode(array(
                'image_url' => "https://rdl-dashboard.herokuapp.com/files/lessons/" . $array['image'],
                'title' => $array['title'],
                'subtitle' => $array['descr'],
                'buttons' => $keyboard)
        );
        $payload = array('template_type' => "generic",
            'elements' => $elements);
        $attachment = array('type' => "template",
            'payload' => $payload);
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('attachment' => $attachment));
    } else {
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => "Lesson is not found."));
    }
    send($data, $token, $id, $mysqli, $reg_time);

} elseif ($payload == "Leave Feedback") {
    $text = "Would you recommend RDE to as friend. (10 - yes likely, 1 - not likely)";
    $data = array('recipient' => array('id' => "$id"),
        'message' => array('text' => $text,
            'quick_replies' => $keyboard_feedback));
    send($data, $token, $id, $mysqli, $reg_time);
    $position = $mysqli->query("UPDATE users SET `position` = 'feedback 1' WHERE id_fb = " . $id . " ");

} elseif ($position == "feedback 1") {
    if ($payload_quick != "") {
        $text = "What feedback would you have us?";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text));
        send($data, $token, $id, $mysqli, $reg_time);
        $position = $mysqli->query("UPDATE users SET `feedback_rate` = ".$payload_quick.", `position` = 'feedback 2' WHERE id_fb = " . $id . " ");
    } else {
        $text = "Would you recommend RDE to as friend. (10 - yes likely, 1 - not likely)";
        $data = array('recipient' => array('id' => "$id"),
            'message' => array('text' => $text,
                'quick_replies' => $keyboard_feedback));
        send($data, $token, $id, $mysqli, $reg_time);
    }
} elseif ($position == "feedback 2" && $message != "") {
    $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
    $row = $result->fetch_assoc();
    $name = $row['first_name'] . " " . $row['last_name'];
    $rate = $row['feedback_rate'];

    $text = $name."\nRate: ".$rate.". \nFeedback:\n".$message;
    mail("feedback@rde.com", "Feedback", $text,
        "From: rdl@bot.com \r\n"
        ."X-Mailer: PHP/" . phpversion());

    $text = "Thanks for the feedback! It is how we get better!";
    $data = array('recipient' => array('id' => "$id"),
        'message' => array('text' => $text));
    send($data, $token, $id, $mysqli, $reg_time);
    $position = $mysqli->query("UPDATE users SET `position` = ' ' WHERE id_fb = " . $id . " ");

} elseif ($payload == "Share Us") {
    $elements[0] = json_encode(array(
            'image_url' => "http://cloudfront.assets.stitcher.com/feedimageswide/480x270_55532.jpg",
            'title' => "Real Deal English",
            'subtitle' => "Get in touch with us!",
            'buttons' => $keyboard_share)
    );

    $payload = array('template_type' => "generic",
        'elements' => $elements);

    $attachment =array('type'=>"template",
        'payload' => $payload);

    $data = array('recipient' => array('id' => "$id"),
        'message' => array('attachment' => $attachment));
    send($data,$token,$id,$mysqli,$reg_time);

} elseif ($payload == "Account Center") {
    $result = $mysqli->query("SELECT * FROM `users` WHERE id_fb = ".$id." ");
    $row = $result->fetch_assoc();

    $elements[0] = json_encode(array(
            'image_url' => $row['profile_pic'],
            'title' => $row['first_name']." ".$row['last_name'],
            'subtitle' => "Time zone: ".$row['timezone'],
            'buttons' => $keyboard_account_center)
    );

    $payload = array('template_type' => "generic",
        'elements' => $elements);

    $attachment =array('type'=>"template",
        'payload' => $payload);

    $data = array('recipient' => array('id' => "$id"),
        'message' => array('attachment' => $attachment));
    send($data,$token,$id,$mysqli,$reg_time);

} elseif ($payload == "See next") {
    $data = array('recipient' => array('id' => "$id"),
        'message' => array('text' => "This function is not avaliable now."));
    send($data,$token,$id,$mysqli,$reg_time);

} else {
	$data = array('recipient' => array('id' => "$id"),
	              'message' => array('text' => "text"));
	send($data,$token,$id,$mysqli,$reg_time);
}


function send($data,$token,$id,$mysqli,$reg_time) {
    require_once('save_bot_message.php');

    $sql  = "INSERT INTO `chats` SET ";
    $sql  .= " `id_fb` = '".$id."' ,";
    $sql  .= " `date` = '".$reg_time."' ,";
    $sql  .= " `isUser` = 0 ,";
    $sql  .= " `message` = '".$text."'";
    $result = $mysqli->query($sql);

	$option = array(
          'http' => array(
             'method' => 'POST',
             'content' => json_encode($data),
             'header' => "Content-Type: application/json"
             )
 	);
 	$context = stream_context_create($option);
	file_get_contents("https://graph.facebook.com/v2.7/me/messages?access_token=$token",false, $context);
}






