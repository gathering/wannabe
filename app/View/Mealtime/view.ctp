<div class="row">
	<div class="span16">
		<ul class="tabs" data-tabs="tabs">
            <li class="active"><a href="#day"><?=__("Day")?> (<?=count($day)?>)</a></li>
            <li><a href="#night"><?=__("Night")?> (<?=count($night)?>)</a></li>
            <li><a href="#notset"><?=__("Not set")?> (<?=count($notset)?>)</a></li>
		</ul>
		<div id="mealtime-tab-content" class="tab-content">
			<div class="active" id="day">
                <p><?=__("Total")?>: <?=count($day)?></p>
                <table>
                    <thead>
                        <tr>
                            <th><?=__("User")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($day as $member) { ?>
                            <tr>
                                <td><?=$this->Wb->userLink($member)?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
			</div>
			<div id="night">
                <p><?=__("Total")?>: <?=count($night)?></p>
                <table>
                    <thead>
                        <tr>
                            <th><?=__("User")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($night as $member) { ?>
                            <tr>
                                <td><?=$this->Wb->userLink($member)?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
			</div>
			<div id="notset">
                <p><?=__("Total")?>: <?=count($notset)?></p>
                <table>
                    <thead>
                        <tr>
                            <th><?=__("User")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($notset as $member) { ?>
                            <tr>
                                <td><?=$this->Wb->userLink($member)?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>
