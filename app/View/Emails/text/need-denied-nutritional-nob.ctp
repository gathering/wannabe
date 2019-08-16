Hei <?=$user['User']['realname']?>!

Dette er en melding om at ditt oppgitte ernæringsbehov har blitt avslått.

Du hadde fyllt inn følgende:
<?=$need[0]['Needs']['nutritionalneeds']?>


<?php if($message != ''): ?>
Du har også fått en beskjed:
<?=$message?>
<?php endif; ?>

Ta kontakt med <?=$wannabe->event->reference?>nutritional-needs@gathering.org dersom du har spørsmål rundt dette.
