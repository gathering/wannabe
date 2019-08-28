<!DOCTYPE html>
<html lang="en">
	<head>
		<?php if(isset($title_for_layout)) { ?>
			<title>Wannabe 4: <?php echo $title_for_layout?></title>
		<?php } else { ?>
			<title>Wannabe 4</title>
		<?php } ?>
		<meta charset="utf-8" />
		<link rel="author" href="mailto:wannabe@lovelan.no" />
		<link rel="icon" href="/favicon.ico" type="image/png" />
		<?=$this->Html->css('bootstrap-old')?>
		
		<?=$this->Html->css('front')?>
		<?=$this->Html->script('jquery/jquery')?>
		<?=$this->Html->script('bootstrap/alerts')?>
		<?=$this->Html->script('bootstrap/modal')?>
		<?=$this->Html->script('wannabe/front')?>
		<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
		<script>'article aside footer header nav section time'.replace(/\w+/g,function(n){document.createElement(n)})</script>
		<?php echo $scripts_for_layout ?>
	</head>

	<body>
		<header>
			<a href="/"><img src="/img/wtextlogo-<?=$wannabe->lang?>.png" alt="<?=__("Wannabe – The event database")?>"/></a>
		</header>

		<footer>
			<a href="/"><img src="/img/wlogo.png" alt="W" /></a>
			<div id="debugInfo">
                                <?=$this->element('sql_dump')?>
                        </div>
		</footer>

		<div id="modal" class="modal hide fade in" style="display: block; ">
<?php
if(isset($form)):
	echo "<form style='margin-bottom: 0' method='POST' action='".$form['action']."'>";
endif;
?>
			<div class="modal-header">
				<a href="/" class="close">×</a>
				<h3><?php echo $title_for_layout?></h3>
			</div>
			<div class="modal-body">
				<div class="messages">
					<?=$this->Session->flash('modal')?>
				</div>
				<?php echo $content_for_layout ?>
			</div>
<?php if(isset($form)): ?>
<div class="modal-footer">
<?php foreach($form['button'] as $button): ?>
	<button type="<?=$button['type']?>" class="btn <?=$button['class']?>" id="<?=$button['id']?>"><?=$button['text']?></button>
<?php endforeach; ?>
</div>
</form>
<?php endif; ?>
		</div>

		<script type="text/javascript">
			_uacct = "UA-55789-3";
			urchinTracker();
		</script>

	</body>
</html>
<script type="text/javascript">
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
