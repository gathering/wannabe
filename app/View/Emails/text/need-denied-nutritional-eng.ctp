Hi <?=$user['User']['realname']?>!

This is a message informing you that your nutritional need has been denied.

You filled in the following:
<?=$need[0]['Needs']['nutritionalneeds']?>


<?php if($message != ''): ?>
You also receiveded a message:
<?=$message?>
<?php endif; ?>

Contact <?=$wannabe->event->reference?>nutritional-needs@gathering.org if you have any questions. 

