<?php

if (count($children) > 0) {
    echo json_encode(array(
        'children' => $children));
} else {
    echo json_encode(null);
}

?>
