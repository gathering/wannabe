<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if(isset($title_for_layout)) { ?>
			<title>Wannabe 4: <?php echo $title_for_layout?></title>
		<?php } else { ?>
			<title>Wannabe 4</title>
		<?php } ?>
		<meta charset="utf-8" />
		<link rel="author" href="mailto:wannabe@gathering.org" />
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<?=$this->Html->css('bootstrap')?>
		<?=$this->Html->css('front')?>

		<?=$this->Html->script('jquery/jquery')?>
		<?=$this->Html->script('bootstrap/alerts')?>
		<?=$this->Html->script('bootstrap/modal')?>
		<?=$this->Html->script('wannabe/front')?>

        <script type="text/javascript"> var eventREF = '<?=$wannabe->event->reference?>';</script>
		<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
		<script>'article aside footer header nav section time'.replace(/\w+/g,function(n){document.createElement(n)})</script>
		<?php echo $scripts_for_layout ?>
	</head>

	<body>

		<div class="container" >

			<div class="row" style="margin-bottom: 40px; margin-top: 80px;">
				<div class="col-xs-12" style="text-align:center;">
						<div class="hidden-xs" style="margin-top: 120px;"></div>
					<img src="/img/wtextlogo-<?=$wannabe->lang?>.png" alt="<?=__("Wannabe – The event database")?>"/>
				</div>
			</div>
			<div class="row">
				<?=$this->Session->flash()?>
				<div class="col-md-6 ">
					<div class="front-login">
						<?php echo $content_for_layout ?>
					</div>
				</div>
				<div class="col-md-6">
					<?=$this->element('frontnews')?>
				</div>
			</div>
		</div>







		<footer>
			<img src="/img/wlogo.png" alt="W" />
			<div id="debugInfo">
				<?=$this->element('sql_dump')?>
			</div>
		</footer>

		<div id="modal" class="modal hide fade">
		</div>

		<script type="text/javascript">
			_uacct = "UA-55789-3";
			urchinTracker();
		</script>

	</body>
</html>
<?php
echo $this->Js->writeBuffer(); // Write cached scripts
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-55789-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
