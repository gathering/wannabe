<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="author" href="mailto:wannabe@lovelan.no" />
    <link rel="icon" href="/favicon.ico" type="image/png" />

    <title>
			<?php if(isset($title_for_layout)) { ?>
				Wannabe 4: <?=$title_for_layout?>
				<?php if(isset($user)) { ?>
					(<?=$user['User']['id']?>)
				<?php } ?>
			<?php } else { ?>
				Wannabe 4
			<?php } ?>
		</title>

    <?=$this->Html->css('bootstrap')?>
    <?=$this->Html->css('responsive-default')?>

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php if(isset($wannabe->event->reference)) { ?>
              <a class="navbar-brand" href="/<?=$wannabe->event->reference?>/Home">Wannabe</a>
          <?php } else { ?>
              <a class="navbar-brand" href="/">Wannabe</a>
          <?php } ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse" style="overflow-x: hidden;">
          <?php if(isset($wannabe->user['User']['id'])): ?>
  				<?php $secNav = array_pop($wannabe->menu); ?>
  				<ul class="nav navbar-nav">
  				<?php foreach($wannabe->menu as $menuitem): ?>
            <?php if($menuitem['Menuitem']['name'] == '') $menuitem['Menuitem']['name'] = $menuitem[0]['Menuitem__i18n_name']; ?>
  					<li class="dropdown">
              <a href="<?=$this->Wb->eventUrl($menuitem['Menuitem']['path'])?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$menuitem['Menuitem']['name']?><span class="caret"></span></a>
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
          <?php if(isset($searchAccess) && $searchAccess == true): ?>
          <li>
            <form class="navbar-form navbar-right" action="<?=$this->Wb->eventUrl('/Search/process')?>" method="GET">
             <div class="form-group">
               <input type="text" name="query" placeholder="Search" class="form-control" style="width: 70%;">
             </div>
           </form>
          </li>
  				<?php endif; ?>
  				</ul>

          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
  						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span style="margin-top: 15px; color: #999;"><?=__("Logged in as")?></span> <? if($wannabe->user['User']['nickname']) { echo WbSanitize::clean($wannabe->user['User']['nickname']); } else { echo $wannabe->user['User']['email']; } ?><span class="caret"></span></a>
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
  				<?php endif; ?>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

		<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container" style="padding-top: 30px;">
        <div class="row">
          <div class="col-md-7">
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
        </div>
                <?php if(isset($taskHandler) && $taskHandler->task_button) { ?>

                    <div class="col-md-3 in-header pull-right">
                        <div class="well">
                            <p><?=__("If you do not have anything to fill in here, you kan skip this.")?></p>
                            <?=$this->Wb->eventLink(__("Skip"), '/Task/complete/'.$taskHandler->task['Task']['id'], array('class' => 'btn btn-warning btn-lg'))?>
                        </div>
                    </div>

                <?php } else if(isset($box_into_header)) { ?>

                    <div class="col-md-3 in-header pull-right">
                        <h4><?=$box_into_header['Header']?></h4>
                        <div class="well">
                            <?php foreach($box_into_header['Link'] as $link) { ?>
                                <?=$this->Wb->eventLink($link['title'], $link['href'], array('class' => $link['class']))?>
                            <?php } ?>
                        </div>
                    </div>

                <?php } ?>
        </div>
      </div>
    </div>

		<div Class="container-fullscreen">
      <div id="alerts"></div>
      <?php echo $content_for_layout; ?>
		</div>

      <div id="modal" class="modal hide fade"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function showAlert(header, actions) {
            var alertMessage =
                '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<p><strong><?php echo __('Error'); ?>: </strong> '+header+'</p>'+
                    '<div class="alert-actions">'+
                        actions+
                    '</div>'+
                '</div>';
            $('#alerts').prepend(alertMessage);
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
  </body>
</html>
<?php
echo $this->Js->writeBuffer(); // Write cached scripts
?>
