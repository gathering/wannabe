<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <?php if(isset($wannabe->event->reference)) { ?>
                <a class="navbar-brand" href="/<?=$wannabe->event->reference?>/">Wannabe</a>
            <?php } else { ?>
                <a class="navbar-brand" href="/">Wannabe</a>
            <?php } ?>
        </div>
    </div>
</nav>

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
        </div>
    </div>
</div>

<div class="container">
    <?php
    if(isset($form)):
        echo "<form style='margin-bottom: 0' method='POST' action='".$form['action']."'>";
    endif;
    ?>

    <?php echo $content_for_layout; ?>

    <?php if(isset($form)): ?>
        <div class="modal-footer">
            <?php foreach($form['button'] as $button): ?>
                <button type="<?=$button['type']?>" class="btn <?=$button['class']?>" id="<?=$button['id']?>"><?=$button['text']?></button>
            <?php endforeach; ?>
        </div>
        </form>
    <?php endif; ?>
</div>

<footer style="margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <p>Wannabe <?=__("version")?> 4.0<br /><?=__("Copyright © KANDU")?><br /><?=__("Problems")?>? <a href="mailto:wannabe@lovelan.no"><?=__("Report it")?>!</a></p>
            </div>
            <div class="col-md-4">
                <div class="footer-logo" style="text-align: center;">
                    <a href="/About"><img src="/img/wlogo.png" alt="W"></a>
                </div>
            </div>
            <div class="col-md-4">
                <p class="pull-right"><a href="/About"><?=__("Read more…")?></a><br /><?=$this->Wb->eventLink("{$olang[1]}","/User/Language/{$olang[0]}")?></p>
            </div>
        </div>
        <div id="debugInfo">
            <?=$this->element('sql_dump')?>
        </div>
</footer>
<div id="modal" class="modal hide fade"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?=$this->fetch('bottom');?>
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
