<?php if(!$kin): ?>
    <p><?=__("No information for %s", $user['User']['realname'])?>
<?php else: ?>
    <p>
        <?=__("Name")?>: <?=$kin['Kin']['name']?><br>
        <?=__("Phone number")?>: <?=$kin['Kin']['number']?>
    </p>
<? endif; ?>
