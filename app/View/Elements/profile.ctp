<?php 
$profile = $this->requestAction($wannabe->event->reference.'/Profile/View/'.$user); 
if(isset($profile['User']['id'])) {
?>
	<div class="page-header">
		<h2><?=$profile['User']['realname']?> <?=$header?'<small>'.$header.'</small>':''?></h2>
	</div>
	<div class="row">
		<?php if($profile['User']['image']) { ?>
			<div class="span2">
				<ul class="media-grid">
					<li>
						<div><img src="<?=$this->Wb->profilePictureUrl($profile, 100)?>" alt="" border="0" /></div>
					</li>
				</ul>
			</div>
		<?php } ?>
		<div class="span6">
			<div class="row">
				<div class="span3">
					<strong><?=__("Name")?></strong>
					<ul class="unstyled profile">
						<li><?=$profile['User']['realname']?></li>
					</ul>
				</div>
				<div class="span3">
					<strong><?=__("Nickname")?></strong>
					<ul class="unstyled profile">
						<li><?=$profile['User']['nickname']?></li>
					</ul>
				</div>
			</div>	
			<hr />
			<div class="row">
				<div class="span3">
					<strong><?=__("Email")?></strong>
					<ul class="unstyled profile">
						<li><a class="email" href="mailto:<?=$profile['User']['email']?>"><?=$profile['User']['email']?></a></li>
					</ul>
				</div>
				<div class="span3">
					<strong><?=__("Phone numbers")?></strong>
					<ul class="unstyled profile">
						<?php if (count($profile['Userphone'])) { ?>
								<? foreach( $profile['Userphone'] as $phone ) { ?>
									<li>
										<?=$phonetypes[$phone['phonetype_id']]?>: <span class="tel"><?=$phone['number']?></span>
									</li>
								<?} ?>
						<?php } else { ?>
							<li><em><?=__("None")?></em></li>
						<? } ?>
					</ul>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="span3">
					<strong><?=__("Age")?></strong>
					<ul class="unstyled">
						<li><?=__("%s years",$profile['User']['age'])?>.</li>
					</ul>
				</div>
				<div class="span3">
					<strong><?=__("IM accounts")?></strong>
					<ul class="unstyled">
						<? if (count($profile['Userim'])) { ?>
								<? foreach( $profile['Userim'] as $imaccount ) { ?>
									<li>
										<?=$improtocols[$imaccount['improtocol_id']]?>: <?=$imaccount['address']?>
									</li>
								<?} ?>
						<? } else { ?>
							<li><em><?=__("None")?></em></li>
						<? } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span16">
			<p><a href="<?=$this->Wb->eventUrl("/Profile/View/{$profile['User']['id']}")?>" class="btn"><?=__("View %s's full profile", $profile['User']['realname'])?></a></p>
		</div>
	</div>
<?php
} else {
?>
<p><?=__("No such user")?></p>
<?php
}
?>
