<script type="text/javascript" language="JavaScript">
var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
$(document).keydown(function(e) {
  kkeys.push( e.keyCode );
  if ( kkeys.toString().indexOf( konami ) >= 0 ){
    $(document).unbind('keydown',arguments.callee);
    $.getScript('https://www.cornify.com/js/cornify.js',function(){
      cornify_add();
      $(document).keydown(cornify_add);
    });
  }
});
</script>

<div class="row">
	<div class="span6">
		<div class="row">
			<div class="span6">
			<h4><a href="<?=$this->Wb->eventUrl('/Profile/View')?>"><?=$this->Wb->userDisplayName($wannabe->user)?></a></h4>
				<div class="row">
<?php if ( $wannabe->user['User']['image'] != '' ) { ?>
					<div class="span2">
						<ul class="media-grid">
							<li>
								<a href="<?=$this->Wb->eventUrl('/Profile/Picture')?>"><img class="thumbnail" src="/<?="{$wannabe->user['User']['image']}_100.png?".time();?>" alt="" /></a>
							</li>
						</ul>
					</div>
<?php } ?>
<?php
if($crewmember) {
?>
					<div class="span4">
						<h5><?=__("Member of:")?></h5>
						<ul>
<?php foreach($wannabe->user['Crew'] as $crew) { ?>
							<li>
								<?=$this->Wb->crewLink2($crew['name'])?>
							</li>
<?php } ?>
						</ul>
					</div>
<?php
}
?>
				</div>
			</div>
<?php if((!empty($settings) && $settings['EnrollSetting']['enrollactive']) && $accessToEnroll && $activeApplications) { ?>
			<div class="span6 home-profile">
				<p><a href="<?=$this->Wb->eventUrl('/Enroll/filter?crew_id='.$wannabe->user['Crew'][0]['id'])?>"><?=__("%s active applications for %s", $activeApplications, $wannabe->user['Crew'][0]['name'])?></a></p>
            </div>

<?php } ?>


<?php
if($crewmember && sizeof($availableIrcChannels) > 0) { ?>

			<div class="span6 home-profile">
                <h4><?=__("Access to IRC")?></h4>
                <ul>
            <?foreach($availableIrcChannels as $arr => $chan) { ?>
                <li><strong><?=$chan[0]['channelname']?></strong>: <?=$chan[0]['channelkey']?></li>
            <? } ?>
                </ul>
            </div>
<? } ?>

<?php
if($crewmember && sizeof($smsbudget) > 0) { ?>
            <div class="span6 home-profile">
                <h4><?=__("SMS Budget")?></h4>
                <ul class="unstyled profile">
                    <li>Used: <?= $smsbudget['SmsBudget']['sms_sent'] ?></li>
                    <li>Limit: <?= $smsbudget['SmsBudget']['sms_limit'] ?></li>
                </ul>
            </div>
<? } ?>

<?php if($crewmember && sizeof($birthdays) > 0) { ?>
            <div class="span6 home-profile">
                <h4><?=__("Todays birthdays")?></h4>
                <ul>
                    <?php foreach($birthdays as $birthday) { ?>
                        <li>
                            <?=$this->Wb->userLink($birthday)?> (<?=$this->Wb->calculateAge($birthday['User']['birth'])?> <?=__("Years")?>)
                        </li>
                    <?php } ?>
                </ul>
            </div>
<? } ?>

			<div class="span6 home-profile">
				<h4><?=__("Actions")?></h4>
				<p><a href="<?=$this->Wb->eventUrl('/Profile/View')?>" class="btn"><?=__("Full profile")?></a> <a href="<?=$this->Wb->eventUrl('/Profile/Edit')?>" class="btn"><?=__("Edit profile")?></a> <a href="<?=$this->Wb->eventUrl('/Profile/Picture')?>" class="btn"><?=__("Upload picture")?></a></p>
			</div>
<?php if($crewmember && sizeof($activeUsers) > 0) { ?>
            <div class="span6 home-profile">
                <h4><?=__("Last active")?></h4>
                <ul>
                    <?php foreach($activeUsers as $user): ?>
                    <li><?=$this->Wb->userLink($user)?> (<?=$this->Wb->lastActive($user)?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
<?php } ?>
		</div>
	</div>
	<div class="span10">
		<div class="row">
<?php
if(!$crewmember && $wannabe->event->can_apply_for_crew) {
?>
			<div class="span10">
				<h2><?=__("Apply for crew")?> <small><?=__("One of the best experiences of your life!")?></small></h2>
				<p><?=__("A fan of The Gathering? Join us and make it happen! Contribute with your time and skills and we will guarantee that you will have one of the best experiences of your life.")?></p>
				<p><?=__("Check out %s to find out which crew that fits you best.", $this->Wb->eventLink(__("descriptions"), '/Crew/Description'))?></p>
			<?php if(!empty($application)) { ?>
				<p><?=__("Thank you for submitting your application. You will recieve feedback by email.")?></p>
				<p><a class="btn success" href="<?=$this->Wb->eventUrl("/Application")?>"><?=__("Edit your application")?></a></p>
			<?php } else { ?>
				<p><a class="btn success" href="<?=$this->Wb->eventUrl("/Application")?>"><?=__("Apply for crew now")?></a></p>
			<?php } ?>
			</div>
<?php
} else if ($crewmember) {
?>
			<div class="span10">
				<?=$this->element('wikipage', array('page' => "Front"))?>


			</div>
<?php
} else if (!$cfadMembership) {
?>
        <div class="span10">
            <h2><?=__("This event is not yet open for applications.")?></h2>
            <br>
            <blockquote>
                <p>He that can have patience can have what he will</p>
                <small>Benjamin Franklin</small>
            </blockquote>
        </div>
<?php
}
?>
<?php
if(!$crewmember && isset($cfadSettings['CfadApplicationSetting']['can_apply']) && $cfadSettings['CfadApplicationSetting']['can_apply'] && $accessToCfad) {
    if(isset($cfadMembership[0])) {
        ?>
        <div class="span10">
            <h2><?=__("CFAD")?> </h2>
            <h5><?=__("Member of:")?></h5>
            <li> <?= $cfadMembership[0]['crews']['name'] ?></li>
        </div>
        <?php

    } else {
?>
			<div class="span10">
				<h2><?=__("Apply for crew for a day")?> </h2>
				<p><a class="btn success" href="<?=$this->Wb->eventUrl("/cfad/CfadApplication")?>"><?=__("Apply for crew for a day now")?></a></p>
			</div>
<?php
    }
}
?>
		</div>
	</div>
</div>
<?php if($geocode->userNeedGeocodeUpdate): ?>
<script type="text/javascript">
    function initUserGeocoder() {
        geocoder = new google.maps.Geocoder();
        var address = "<?=$geocode->userAddress?>";
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var latlng = results[0].geometry.location;
                var post = $.post("<?=$this->Wb->eventUrl('/Geocode')?>", {
                    address: "<?=$geocode->userAddress?>",
                    latitude: latlng.lat(),
                    longitude: latlng.lng(),
                    user_id: <?=$wannabe->user['User']['id']?>,
                })
                .success(function(data) {
                    data = $.parseJSON(data);
                    if(data.success == false) {
                        showAlert("Error saving geocode to cache", '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                    }
                })
                .error(function() {
                    showAlert("Error saving geocode to cache", '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                })
            } else {
                if(status == 'ZERO_RESULTS') {
                    var post = $.post("<?=$this->Wb->eventUrl('/Geocode/invalidate')?>", {
                        address: "<?=$geocode->userAddress?>"
                    })
                    .success(function(data) {
                        data = $.parseJSON(data);
                        if(data.success) {
                            showAlert(
                                '<?=__("Your address did not match any geograpical coordinates, which probably means your address is invalid. You might want to update your address!")?>',
                                '<a class="btn small" href="<?=$this->Wb->eventUrl('/Profile/Edit')?>"><?=__("Edit your profile")?></a> <a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>'
                            );
                        }
                    })
                    .error(function() {
                        showAlert("Error saving geocode to cache", '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                    })

                } else {
                    showAlert("Geocode was not successful for the following reason: " + status, '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                }
            }
        });
    }

    function loadGoogleMapsAPI() {
        var s=document.createElement("script");
        s.type="text/javascript";
        s.src="https://maps.googleapis.com/maps/api/js?key=<?=$geocode->apikey?>&sensor=false&callback=initUserGeocoder";
        document.body.appendChild(s);
    }
    window.onload = loadGoogleMapsAPI;
</script>
<? endif; ?>
