Hei <?=$user['User']['realname']?>!

Dette er en melding om at ditt oppgitte medisinske behov har blitt avslått.

<?php if($message != ''): ?>
Du har også fått en beskjed:
<?=$message?>
<?php endif; ?>

Ta kontakt med <?=$wannabe->event->reference?>sec-medic@gathering.org dersom du har spørsmål rundt dette.

