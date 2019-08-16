<?php
App::uses('WbSanitize', 'Lib');
$qrdata = array();
$qrdata['id'] = $user['User']['id'];
$qrdata['name'] = $user['User']['realname'];
$qrdata['url'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
if ($isMyProfile || $canViewDetailedInfo || $canViewEmail) $qrdata['mail'] = $user['User']['email'];
if (($isMyProfile || $canViewDetailedInfo || $canViewPhone) && !empty($user['Userphone'])) $qrdata['phone'] = $user['Userphone'][0]['number'];
if ($isMyProfile || $canViewDetailedInfo || $canViewAddress) $qrdata['address'] = $user['User']['address'].', '.$user['User']['postcode'].' '.$user['User']['town'];
?>
<div class="row">

	<div class="col-md-12">
		<div class="page-header">
			<h2>ID #<?=$user['User']['id']?> <small><?=__("User profile")?></small></h2>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-4">
						<strong><?=__("Name")?></strong>
						<ul class="unstyled profile">
							<li><?=WbSanitize::clean($user['User']['realname'])?></li>
						</ul>
					</div>
					<div class="col-md-4">
						<strong><?=__("Nickname")?></strong>
						<ul class="unstyled profile">
							<li><?=WbSanitize::clean($user['User']['nickname'])?></li>
						</ul>
					</div>
					<div class="col-md-4">
						<?php if($isMyProfile || $canViewDetailedInfo || $canViewBirth) { ?>
							<strong><?=__("Date of birth")?></strong>
							<ul class="unstyled profile">
								<li><?=date(__("m-d-Y"), strtotime($user['User']['birth']))?> (<?=__("%s years",$userAge)?>)</li>
							</ul>
						<? } else { ?>
							<strong><?=__("Age")?></strong>
							<ul class="unstyled profile">
								<li><?=__("%s years",$userAge)?>.</li>
							</ul>
						<? } ?>
					</div>
				</div>
				<hr />

				<div class="row">
					<?php if($isMyProfile || $canViewDetailedInfo || $canViewEmail) { ?>
						<div class="col-md-4">
							<strong><?=__("Email")?></strong>
							<ul class="unstyled profile">
								<li><a class="email" href="mailto:<?=$user['User']['email']?>"><?=WbSanitize::clean($user['User']['email'])?></a></li>
							</ul>
						</div>
					<? } ?>
					<?php if($isMyProfile || $canViewDetailedInfo || $canViewPhone) { ?>
						<div class="col-md-4">
							<strong><?=__("Phone numbers")?></strong>
							<ul class="unstyled profile">
								<?php if (count($user['Userphone'])) { ?>
										<? foreach( $user['Userphone'] as $phone ) { ?>
											<li>
												<?=$phonetypes[$phone['phonetype_id']]?>: <span class="tel"><?=WbSanitize::clean($phone['number'])?></span>
											</li>
										<?} ?>
								<?php } else { ?>
									<li><em><?=__("None")?></em></li>
								<? } ?>
							</ul>
						</div>
					<? } ?>
					<div class="col-md-4">
						<strong><?=__("IM accounts")?></strong>
						<ul class="unstyled profile">
							<? if (count($user['Userim'])) { ?>
									<? foreach( $user['Userim'] as $imaccount ) { ?>
										<li>
											<?=$improtocols[$imaccount['improtocol_id']]?>: <?=WbSanitize::clean($imaccount['address'])?>
										</li>
									<?} ?>
							<? } else { ?>
								<li><em><?=__("None")?></em></li>
							<? } ?>
						</ul>
					</div>
				</div>
				<hr />
				<div class="row">
					<?php if($isMyProfile || $canViewDetailedInfo || $canViewAddress) { ?>
						<div class="col-md-4">
							<strong><?=__("Address")?></strong>
							<ul class="unstyled profile">
								<? if (!empty($user['User']['address'])) { ?>
										<li><?=WbSanitize::clean($user['User']['address'])?></li>
								<? } ?>
								<li><?=WbSanitize::clean($user['User']['countrycode'])?>-<?=WbSanitize::clean($user['User']['postcode'])?> <?=WbSanitize::clean($user['User']['town'])?></li>
							</ul>
						</div>
					<? } ?>
					<div class="col-md-4">
					<strong><?=__("Member of")?></strong>
						<ul class="unstyled profile">
							<? if (count($user['Crew']) > 0) { ?>
									<? foreach ( $user['Crew'] as $crew ) { ?>
										<li>

											<a href="<?php echo '/'.$wannabe->event->reference.'/Crew/View/'.$crew['name'];?>"><?=$crew['name']?></a>
											(<?=$this->Wb->getUsertitleForCrew($user, $crew['id'])?>)
										</li>
									<? } ?>
							<? } else { ?>
								<li><em><?=__("None")?></em></li>
							<? } ?>
						</ul>
					</div>
						<?php if($isMyProfile || $canSudo) { ?>
							<div class="col-md-4">
								<strong><?=__('Username')?></strong>
								<ul class="profile unstyled">
			                        <li><?=WbSanitize::clean($user['User']['username'])?></li>
								</ul>
							</div>
						<? } ?>
				</div>
				<hr />
				<div class="row">
		            <? // Needs span9, or else member history will wrap and it's ugly. ?>
					<div class="col-md-8">
						<strong><?=__("Member history")?></strong>
						<ul class="unstyled profile">
							<? if (count($user['Userhistory'])) { ?>
									<? foreach ( $user['Userhistory'] as $history ) { ?>
										<li>
											<?=$history['eventname']?> <?=($history['crewname']?$history['crewname']:'<em>'.__("Not crew").'</em>')?>
											(<?=$history['title']?>)
										</li>
									<? } ?>
							<? } else { ?>
								<li><em><?=__("None")?></em></li>
							<? } ?>
						</ul>
					</div>
				</div>
				<hr />
				<div class="row">
						<div class="col-md-8">
								<?php if(!$isMyProfile && !empty($application) && $canAccessEnroll) { ?>
										<a href="<?=$this->Wb->eventUrl('/Enroll/View/'.$user['User']['id'])?>" class="btn btn-default"><?=__("View users application")?></a>
								<?php } ?>
								<?php if($isMyProfile && !empty($application)) { ?>
										<a href="<?=$this->Wb->eventUrl('/Application')?>" class="btn btn-default"><?=__("View your application")?></a>
								<?php } ?>
								<?php if($canResetPicture && $user['User']['image'] != '' && $user['PictureApproval']['approved']) { ?>
										<a href="<?=$this->Wb->eventUrl('/PictureApprove/resetPicture/'.$user['User']['id'])?>" class="btn btn-default"><?=__("Reset approved picture")?></a>
								<?php } ?>
								<?php /* <a href="<?=$this->Wb->eventUrl('/Kin/View/'.$user['User']['id'])?>" class="btn"><?=__("View next of kin")?></a> */ ?>
						</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12">
					<ul class="media-grid">
					<?php if ( $user['User']['image'] != '' ) { ?>
						<li class="unstyled">
						<?php if($isMyProfile) { ?><div><a href="<?=$this->Wb->eventUrl("/Profile/Picture")?>"><?php } else { ?><div><?php } ?><img src="/<?="{$user['User']['image']}_320.png?".time();?>" alt="" border="0" /><?php if($isMyProfile) { ?></a></div><?php } else { ?></div><?php } ?>
						</li>
					<?php } ?>
						<li class="unstyled"><div><?=$this->Wb->makeQrContact($qrdata)?></div></li>
					</ul>
				</div>
			</div>
		</div>




	</div>
</div>
