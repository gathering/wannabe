<!DOCTYPE html>
<html lang="en">
	<head>
		<?php if(isset($title_for_layout)) { ?>
			<title>Wannabe 4: <?php echo $title_for_layout?></title>
		<?php } else { ?>
			<title>Wannabe 4</title>
		<?php } ?>
		<meta charset="utf-8" />
		<link rel="author" href="mailto:wannabe@gathering.org" />
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<?=$this->Html->css('bootstrap-old')?>
		<?=$this->Html->css('wannabe')?>
        <?=$this->Html->css('iframe')?>
		<?=$this->Html->script('jquery/jquery')?>
		<?=$this->Html->script('bootstrap/alerts')?>
		<?=$this->Html->script('bootstrap/modal')?>
		<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script>
		<script>'article aside footer header nav section time'.replace(/\w+/g,function(n){document.createElement(n)})</script>
		<?php echo $scripts_for_layout ?>
	</head>
	<body>
        <div class="messages">
            <?=$this->Session->flash()?>
        </div>
        <?php echo $content_for_layout ?>
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
