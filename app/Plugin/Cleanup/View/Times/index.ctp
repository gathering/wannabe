<?php if ($my_position): ?>

<div class="row">
    <div class="span16">
        <h3><?=__('My cleanup time')?></h3>
        <p class="moment format"><?=$my_position['Cleanup']['unixtime']?></p>
    </div>
</div>
<div class="row">
    <div class="span16">
        <hr />
        <h3><?=__("Other times for my fellow crew memebers")?></h3>
        <?php foreach ($related_positions as $position): ?>
        <div class="row">
            <div class="span16">
                <p>
                    (<?=$position['Crew']['name']?>)
                    <?=$position['User']['realname']?> – 
                    <span class="moment format"><?=$position['Cleanup']['unixtime']?></span>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="span16">
        <p><?=__('You do not have a set cleanup time.')?></p>
    </div>
</div>

<?php endif; ?>
