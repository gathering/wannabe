<?='<?xml version="1.0" encoding="UTF-8"?>'?>
<wannabe>
<?php if(isset($_GET['encode']) && $_GET['encode'] == 'true') {
    echo str_replace('&', '&amp;', $content_for_layout); 
} else {
    echo $content_for_layout;
} ?>
</wannabe>
