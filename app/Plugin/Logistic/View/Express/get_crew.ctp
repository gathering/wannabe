<?php

if (count($crew) > 0) {
    //var_dump($crew);
    echo json_encode(array('name' => $crew['Crew']['name'], 'id' => $crew['Crew']['id']));
} else {
    echo json_encode(null);
}