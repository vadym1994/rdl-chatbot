<?php
$button11 = array(
    'type' => "postback",
    'title' => "Watch Intro",
    'payload' => "Watch Intro"
);

$button12 = array(
    'type' => "postback",
    'title' => "Get Setup",
    'payload' => "Get Setup"
);

$button13 = array(
    "type" => "web_url",
    "url" => "https://google.com",
    "title" => "Help Center",
    "webview_height_ratio" => "compact"
);

$keyboard1 = [$button11, $button12, $button13];

$button21 = array(
    'type' => "postback",
    'title' => "Next Lesson",
    'payload' => "Next Lesson"
);

$button22 = array(
    'type' => "postback",
    'title' => "Browse Lessons",
    'payload' => "Browse Lessons"
);

$button23 = array(
    'type' => "postback",
    'title' => "Search",
    'payload' => "Search"
);

$keyboard2 = [$button21,$button22,$button23];

$button31 = array(
    "type" => "web_url",
    "url" => "https://google.com",
    "title" => "Free Shows",
    "webview_height_ratio" => "compact"
);

$button32 = array(
    'type' => "postback",
    'title' => "Leave Feedback",
    'payload' => "Leave Feedback"
);

$button33 = array(
    'type' => "postback",
    'title' => "Share Us",
    'payload' => "Share Us"
);

$keyboard3 = [$button31,$button32,$button33];

$button_share = array(
    "type" => "element_share"
);

$keyboard_share = [$button_share];



$a1 = array(
    "content_type" => "text",
    "title" => "A1",
    "payload" => "A1"
);

$a2 = array(
    "content_type" => "text",
    "title" => "A2",
    "payload" => "A2"
);

$b1 = array(
    "content_type" => "text",
    "title" => "B1",
    "payload" => "B1"
);

$b2 = array(
    "content_type" => "text",
    "title" => "B2",
    "payload" => "B2"
);

$c1 = array(
    "content_type" => "text",
    "title" => "C1",
    "payload" => "C1"
);

$c2 = array(
    "content_type" => "text",
    "title" => "C2",
    "payload" => "C2"
);

$keyboard_level = [$a1,$a2,$b1,$b2,$c1,$c2];

$yes = array(
    "content_type" => "text",
    "title" => "Yes",
    "payload" => "Yes"
);

$no = array(
    "content_type" => "text",
    "title" => "No",
    "payload" => "No"
);

$keyboard_yes_no = [$yes,$no];

for ($i = 1; $i < 11; $i++) {
    $t[$i] = array(
        "content_type" => "text",
        "title" => "$i",
        "payload" => "$i"
    );
}

$keyboard_feedback = [$t[1],$t[2],$t[3],$t[4],$t[5],$t[6],$t[7],$t[8],$t[9],$t[10]];

$button_see_next = array(
    "type" => "postback",
    'title' => "See next",
    'payload' => "See next"
);

$keyboard_account_center = [$button_see_next];



$button_A1_1 = array(
    "type" => "postback",
    'title' => "Latest Lessons",
    'payload' => "Latest Lessons A1"
);

$button_A1_2 = array(
    "type" => "postback",
    'title' => "Search",
    'payload' => "Search A1"
);

$button_A1_3 = array(
    "type" => "postback",
    'title' => "Random",
    'payload' => "Random A1"
);

$keyboard_A1 = [$button_A1_1, $button_A1_2, $button_A1_3];

$button_A2_1 = array(
    "type" => "postback",
    'title' => "Latest Lessons",
    'payload' => "Latest Lessons A2"
);

$button_A2_2 = array(
    "type" => "postback",
    'title' => "Search",
    'payload' => "Search A2"
);

$button_A2_3 = array(
    "type" => "postback",
    'title' => "Random",
    'payload' => "Random A2"
);

$keyboard_A2 = [$button_A2_1, $button_A2_2, $button_A2_3];

$button_B1_1 = array(
    "type" => "postback",
    'title' => "Latest Lessons",
    'payload' => "Latest Lessons B1"
);

$button_B1_2 = array(
    "type" => "postback",
    'title' => "Search",
    'payload' => "Search B1"
);

$button_B1_3 = array(
    "type" => "postback",
    'title' => "Random",
    'payload' => "Random B1"
);

$keyboard_B1 = [$button_B1_1, $button_B1_2, $button_B1_3];

$button_B2_1 = array(
    "type" => "postback",
    'title' => "Latest Lessons",
    'payload' => "Latest Lessons B2"
);

$button_B2_2 = array(
    "type" => "postback",
    'title' => "Search",
    'payload' => "Search B2"
);

$button_B2_3 = array(
    "type" => "postback",
    'title' => "Random",
    'payload' => "Random B2"
);

$keyboard_B2 = [$button_B2_1, $button_B2_2, $button_B2_3];

$button_C1_1 = array(
    "type" => "postback",
    'title' => "Latest Lessons",
    'payload' => "Latest Lessons C1"
);

$button_C1_2 = array(
    "type" => "postback",
    'title' => "Search",
    'payload' => "Search C1"
);

$button_C1_3 = array(
    "type" => "postback",
    'title' => "Random",
    'payload' => "Random C1"
);

$keyboard_C1 = [$button_C1_1, $button_C1_2, $button_C1_3];

$button_C2_1 = array(
    "type" => "postback",
    'title' => "Latest Lessons",
    'payload' => "Latest Lessons C2"
);

$button_C2_2 = array(
    "type" => "postback",
    'title' => "Search",
    'payload' => "Search C2"
);

$button_C2_3 = array(
    "type" => "postback",
    'title' => "Random",
    'payload' => "Random C2"
);

$keyboard_C2 = [$button_C2_1, $button_C2_2, $button_C2_3];
?>