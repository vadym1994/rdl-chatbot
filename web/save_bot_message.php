<?php
$result_mes1 = $data['message']['text'];
$result_mes2 = $data['message']['attachment'];
if ($result_mes1 != '') {
    $text = $result_mes1;
} elseif ($result_mes2 != '') {
    $attachment_type = $data['message']['attachment']['type'];
    if ($attachment_type == "audio" || $attachment_type == "file" || $attachment_type == "image" ||
        $attachment_type == "video" ) {
        $attachment_url = $data['message']['attachment']['payload']['url'];
        $text = $attachment_type . " : " . $attachment_url;
    } elseif ($attachment_type == "template") {
        $template_type = $data['message']['attachment']['payload']['template_type'];
        if ($template_type == "generic" || $template_type == "list" || $template_type == "receipt") {
            $template = $data['message']['attachment']['payload']['elements'][0];
            $template = explode("title\":\"",$template);
            $template[1] = explode("\"", $template[1]);
            $text = $template_type . " : " . $template[1][0];
        } elseif ($template_type == "button") {
            $template_text = $data['message']['attachment']['payload']['text'];
            $text = $template_type . " : " . $template_text;
        }
    }
}
?>