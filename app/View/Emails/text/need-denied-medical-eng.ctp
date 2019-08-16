Hi <?=$user['User']['realname']?>!

This is a message informing you that your medical need has been denied.

<?php if($message != ''): ?>
You also revieced a message:
<?=$message?>
<?php endif; ?>

Contact <?=$wannabe->event->reference?>sec-medic@gathering.org if you have and questions. 

