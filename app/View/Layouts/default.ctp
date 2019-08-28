<?php
App::uses('WbSanitize', 'Lib');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			<?php if(isset($title_for_layout)) { ?>
				Wannabe 4: <?=$title_for_layout?>
				<?php if(isset($user['User'])) { ?>
					(<?=$user['User']['id']?>)
				<?php } ?>
			<?php } else { ?>
				Wannabe 4
			<?php } ?>
		</title>
		<meta charset="utf-8" />
		<link rel="author" href="mailto:wannabe@lovelan.no" />
		<link rel="icon" href="/favicon.ico" type="image/png" />
		<?=$this->Html->css('prettify')?>
		<?=$this->Html->css('bootstrap-old')?>
		<?=$this->Html->css('wannabe')?>
		<?=$this->Html->css('font-awesome.min')?>
		<?=$this->Html->script('jquery/jquery')?>
		<?=$this->Html->script('stickyfloat')?>
		<?=$this->Html->script('bootstrap/alerts')?>
		<?=$this->Html->script('bootstrap/modal')?>
		<?=$this->Html->script('bootstrap/dropdown')?>
		<?=$this->Html->script('bootstrap/scrollspy')?>
		<?=$this->Html->script('bootstrap/twipsy')?>
		<?=$this->Html->script('bootstrap/popover')?>
		<?=$this->Html->script('bootstrap/tabs')?>
		<?=$this->Html->script('prettify/prettify')?>
		<?=$this->Html->script('jquery/tablesorter')?>
		<?=$this->Html->script('jquery/jquery.browser.min')?>
		<?=$this->Html->script('moment/min/moment-with-langs.min')?>
    <script type="text/javascript">moment.lang('<?=$wannabe->langMap[$wannabe->lang]?>');</script>
		<?=$this->Html->script('wannabe/global')?>
		<script>'article aside footer header nav section time'.replace(/\w+/g,function(n){document.createElement(n)})</script>
		<script>wannabeEventReference = function() { return "<?= $wannabe->event->reference; ?>"; }</script>
	<?php echo $scripts_for_layout ?>
</head>

<body onload="prettyPrint()">
	<div class="topbar" data-scrollspy="scrollspy">
		<div class="fill">
			<div class="container">
		      <?php if(isset($wannabe->event->reference)) { ?>
		          <h3><a href="/<?=$wannabe->event->reference?>/Home">Wannabe</a></h3>
		      <?php } else { ?>
		          <h3><a href="/">Wannabe</a></h3>
		      <?php } ?>
				<?php if(isset($wannabe->user['User']['id'])): ?>
				<?php $secNav = array_pop($wannabe->menu); ?>
				<ul>
				<?php foreach($wannabe->menu as $menuitem): ?>
                    <?php if($menuitem['Menuitem']['name'] == '') $menuitem['Menuitem']['name'] = $menuitem[0]['Menuitem__i18n_name']; ?>
					<li class="dropdown" data-dropdown="dropdown">
						<a href="<?=$this->Wb->eventUrl($menuitem['Menuitem']['path'])?>" class="dropdown-toggle"><?=$menuitem['Menuitem']['name']?></a>
						<?php if(isset($menuitem['Child'])): ?>
							<ul class="dropdown-menu">
								<?php foreach($menuitem['Child'] as $menuchild): ?>
                                    <?php if($menuchild['Menuitem']['name'] == '') $menuchild['Menuitem']['name'] = $menuchild[0]['Menuitem__i18n_name']; ?>
									<li><a href="<?=$this->Wb->eventUrl($menuchild['Menuitem']['path'])?>"><?=$menuchild['Menuitem']['name']?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				</ul>
				<?php if(isset($searchAccess) && $searchAccess == true):
				?>
				<form class="pull-left" action="<?=$this->Wb->eventUrl('/Search/process')?>" method="GET">
					<input type="text" name="query" placeholder="Search">
				</form>
				<?php endif; ?>
				<ul class="nav secondary-nav pull-right">
					<li class="dropdown" data-dropdown="dropdown">
						<a href="#" class="dropdown-toggle"><? if($wannabe->user['User']['nickname']) { echo WbSanitize::clean($wannabe->user['User']['nickname']); } else { echo $wannabe->user['User']['email']; } ?></a>
						<ul class="dropdown-menu">
							<?php if($wannabe->user['User']['registered'] == 'done'): foreach($secNav['Child'] as $secNavChild): ?>
                                <?php if($secNavChild['Menuitem']['name'] == '') $secNavChild['Menuitem']['name'] = $secNavChild[0]['Menuitem__i18n_name']; ?>
								<?php if($secNavChild['Menuitem']['position'] > 97): ?>
									<li class="divider"></li>
								<?php endif; ?>
								<li><a href="<?=$this->Wb->eventUrl($secNavChild['Menuitem']['path'])?>"><?=$secNavChild['Menuitem']['name']?></a></li>
							<?php endforeach; else: ?>
								<li><a href="<?=$this->Wb->eventUrl('/Profile/'.$wannabe->user['User']['registered'])?>"><?=__("Complete registration")?></a></li>
							<?php endif; ?>
						</ul>
					</li>
				</ul>
				<p class="pull-right"><?=__("Logged in as")?></p>
				<?php endif; ?>
			</div>
		</div>
	</div> <!-- /topbar -->

	<header class="pagehader">
		<div class="inner">
			<div class="container">
				<?php if(isset($title_for_layout)) { ?>
					<h1><?php echo $title_for_layout?></h1>
				<?php } else { ?>
					<h1>Wannabe 4</h1>
				<?php } ?>
				<?php if(isset($desc_for_layout)) { ?>
					<p class="lead"><?=$desc_for_layout?></p>
				<?php } else { ?>
					<p class="lead"><?=isset($wannabe->event->name)?$wannabe->event->name:''?></p>
				<?php } ?>
                <?php if(isset($taskHandler) && $taskHandler->task_button) { ?>
                <div class="row">
                    <div class="span4 offset12 in-header">
                        <div class="well">
                            <p><?=__("If you do not have anything to fill in here, you kan skip this.")?></p>
                            <?=$this->Wb->eventLink(__("Skip"), '/Task/complete/'.$taskHandler->task['Task']['id'], array('class' => 'btn danger'))?>
                        </div>
                    </div>
                </div>
                <?php } else if(isset($box_into_header)) { ?>
                <div class="row">
                    <div class="span4 offset12 in-header">
                        <h4><?=$box_into_header['Header']?></h4>
                        <div class="well">
                            <?php foreach($box_into_header['Link'] as $link) { ?>
                                <?=$this->Wb->eventLink($link['title'], $link['href'], array('class' => $link['class']))?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
			</div>
		</div>
	</header>

	<div class="container">
		<section id="content">
			<?=$this->Session->flash()?>
			<?=$this->Flash->render()?>
			<?php echo $content_for_layout ?>
		</section>

	</div> <!-- /container -->

	<footer>
        <div class="container">
            <div class="row">
                <div class="span-one-third">
                    <p>Wannabe <?=__("version")?> 4.0<br /><?=__("Copyright © KANDU")?><br /><?=__("Problems")?>? <a href="mailto:wannabe@lovelan.no"><?=__("Report it")?>!</a></p>
                </div>
                <div class="span-one-third">
                    <div class="footer-logo">
                        <a href="/About"><img src="/img/wlogo.png" alt="W"></a>
                    </div>
                </div>
                <div class="span-one-third">
                    <p class="pull-right"><a href="/About"><?=__("Read more…")?></a><br /><?=$this->Wb->eventLink("{$olang[1]}","/User/Language/{$olang[0]}")?></p>
                </div>
		</div>
            <div id="debugInfo">
                <?=$this->element('sql_dump')?>
            </div>
	</footer>
    <div id="modal" class="modal hide fade"></div>

</body>
</html>
<?php
echo $this->Js->writeBuffer(); // Write cached scripts
?>
<script type="text/javascript">
    function showAlert(header, actions) {
        var alertMessage =
            '<div class="alert-message block-message error fade in">'+
                '<a class="close" href="#">×</a>'+
                '<p><strong><?php echo __('Error'); ?>: </strong> '+header+'</p>'+
                '<div class="alert-actions">'+
                    actions+
                '</div>'+
            '</div>';
        $('section#content').prepend(alertMessage);
        $(".alert-message").alert()
    };
/*
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-55789-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
*/
</script>
