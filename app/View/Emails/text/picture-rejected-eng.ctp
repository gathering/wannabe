Hi <?=$user['User']['realname']?>!

This is a message notifying you that your profile picture has been rejected.

<?php if($denied != '') { ?>
The reason for rejection was:
<?=$denied?>
<?php } ?>

<?php if($custom != '') { ?>
You also recieved a message from the administrator rejecting your picture: <?=$custom?>
<?php } ?>


Please submit a new picture that complies with our rules: http://<?=$_SERVER['SERVER_NAME']?>/<?=$wannabe->event->reference?>/Profile/Picture

