<?php

if (count($item) > 0) {
    foreach ($storages as $key => $value) {
        $storages[$key] = h($value);
    }
    echo json_encode(array(
        'type' => $type,
        'item' => h($item['LogisticItem']['name']),
        'comment' => h($item['LogisticItem']['comment']),
        'storage_amounts' => $storage_amounts,
        'storages' => $storages));
} else {
    echo json_encode(null);
}

?>
