<div class="row">
  <div class="col-md-4">
    <!-- Sidebar -->
    <div class="row">
      <div class="col-md-12">
        <h4><a href="<?=$this->Wb->eventUrl('/Profile/View')?>"><?=$this->Wb->userDisplayName($wannabe->user)?></a></h4>
      </div>
    </div>
    <div class="row">
        <?php if ( $wannabe->user['User']['image'] != '' ) { ?>
          <div class="col-xs-4">
            <ul class="media-grid">
              <li>
                <a href="<?=$this->Wb->eventUrl('/Profile/Picture')?>"><img class="thumbnail" src="<?=$this->Wb->profilePictureUrl($wannabe->user, 100)?>" alt="" /></a>
              </li>
            </ul>
          </div>
        <?php } ?>
        <?php
        if($crewmember) {
        ?>
					<div class="col-xs-8">
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
    <div class="span6 home-profile">
      <h4><?=__("Actions")?></h4>
      <p><a href="<?=$this->Wb->eventUrl('/Profile/View')?>" class="btn btn-default"><?=__("Full profile")?></a> <a href="<?=$this->Wb->eventUrl('/Profile/Edit')?>" class="btn btn-default"><?=__("Edit profile")?></a> <a href="<?=$this->Wb->eventUrl('/Profile/Picture')?>" class="btn btn-default"><?=__("Upload picture")?></a></p>
    </div>

    <?php if((!empty($settings) && $settings['EnrollSetting']['enrollactive']) && $accessToEnroll && $activeApplicationsList) { ?>
      <div class="row">
  			<div class="col-md-12 home-profile">
                        <ul>
                            <?php foreach($activeApplicationsList as $key => $crew){ ?>
  				<li><a href="<?=$this->Wb->eventUrl('/Enroll/filter?crew_id='.$wannabe->user['Crew'][$key]['id'])?>"><?=$crew>1 ? __("%s active applications for %s", $crew, $wannabe->user['Crew'][$key]['name']) : __("%s active application for %s", $crew, $wannabe->user['Crew'][$key]['name'])?></a></li>
                            <? } ?>
                        </ul>
        </div>
      </div>
    <?php } ?>

    <?php
    if($crewmember && sizeof($availableIrcChannels) > 0) { ?>
      <div class="row">
  			<div class="col-md-12 home-profile">
          <h4><?=__("Access to IRC")?></h4>
          <ul>
            <?foreach($availableIrcChannels as $arr => $chan) { ?>
              <li><strong><?=$chan[0]['channelname']?></strong>: <?=$chan[0]['channelkey']?></li>
            <? } ?>
          </ul>
        </div>
      </div>
    <? } ?>


    <?php
    if($crewmember && sizeof($smsbudget) > 0) { ?>
      <div class="row">
        <div class="col-md-12 home-profile">
            <h4><?=__("SMS Budget")?></h4>
            <ul class="unstyled profile">
                <li>Used: <?= $smsbudget['SmsBudget']['sms_sent'] ?></li>
                <li>Limit: <?= $smsbudget['SmsBudget']['sms_limit'] ?></li>
            </ul>
        </div>
      </div>
    <? } ?>

    <?php if($crewmember && sizeof($birthdays) > 0) { ?>
      <div class="row">
        <div class="col-md-12 home-profile">
          <h4><?=__("Todays birthdays")?></h4>
          <ul>
              <?php foreach($birthdays as $birthday) { ?>
                  <li>
                      <?=$this->Wb->userLink($birthday)?> (<?=$this->Wb->calculateAge($birthday['User']['birth'])?> <?=__("Years")?>)
                  </li>
              <?php } ?>
          </ul>
        </div>
      </div>
    <? } ?>

    <?php if($crewmember && sizeof($activeUsers) > 0) { ?>
      <div class="row">
        <div class="col-md-12 home-profile">
            <h4><?=__("Last active")?></h4>
            <ul>
                <?php foreach($activeUsers as $user): ?>
                <li><?=$this->Wb->userLink($user)?> (<?=$this->Wb->lastActive($user)?>)</li>
                <?php endforeach; ?>
            </ul>
        </div>
      </div>
    <?php } ?>



  </div>
  <div class="col-md-8">
    <!-- Main content -->
    <div class="row">
      <?php
      if(!$crewmember && $wannabe->event->can_apply_for_crew) {
      ?>
    			<div class="col-md-12">
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
    			<div class="col-md-12">
    				<?=$this->element('wikipage', array('page' => "Front"))?>
    			</div>
      <?php
      } else if (!$cfadMembership) {
      ?>
          <div class="col-md-12">
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
          <div class="col-md-12">
            <h2><?=__("CFAD")?> </h2>
            <h5><?=__("Member of:")?></h5>
            <li> <?= $cfadMembership[0]['crews']['name'] ?></li>
          </div>
              <?php

          } else {
      ?>
  			<div class="col-md-12">
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
