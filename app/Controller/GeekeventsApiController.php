<?php

class GeekeventsApiController extends AppController {

    public function getUserInfo($id) {

        $url = 'https://geekevents.org/users/check_card/';
        $data = array('event_id' => '113', 'card_id' => $id);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $this->autoRender = false;
        //return "{ \"status\": 1, \"user_url\": \"http://google.com\", \"valid_ticket\": 1 }";
        return $result;
    }
}
