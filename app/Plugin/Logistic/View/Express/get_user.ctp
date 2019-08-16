<?php

if (count($user) > 0) {
    $crew = [];
    foreach ($user['Crew'] as $key => $item){
        $crew[$key]['id'] = $item['id'];
        $crew[$key]['name'] = $item['name'];
    }
    echo json_encode(array('name' => $user['User']['realname'], 'id' => $user['User']['id'], 'crew'=>$crew));
} else {
    echo json_encode(null);
}