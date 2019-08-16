Hei <?=$user['User']['realname']?>!

Dette er en melding om at ditt profilbilde ikke ble godkjent.

<?php if($denied != '') { ?>
Avslaget er begrunnet med: <?=$denied?>
<?php } ?>
<?php if($custom != '') { ?>
Du har mottatt en beskjed fra administratoren som avslo ditt bilde: <?=$custom?>
<?php } ?>


Vennligst last opp et nytt bilde som er i overenstemmelse med våre regler: http://<?=$_SERVER['SERVER_NAME']?>/<?=$wannabe->event->reference?>/Profile/Picture
