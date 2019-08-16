<user>
    <id><?=utf8_encode($user['User']['id'])?></id>
    <username><?=utf8_encode($user['User']['username'])?></username>
    <realname><![CDATA[<?=utf8_encode($user['User']['realname'])?>]]></realname>
    <nickname><?=utf8_encode($user['User']['nickname'])?></nickname>
    <email><?=utf8_encode($user['User']['email'])?></email>
    <sexe><?=utf8_encode($user['User']['sexe'])?></sexe>
    <crews>
    <?php
    if(isset($user['Crew'][0])) {
        foreach($user['Crew'] as $crew) {
            echo $this->element('api_crew', array('crew' => array('Crew' => $crew), 'teamnames' => $teamnames, 'userroles' => $userroles));
        }
    } else {
        echo $this->element('api_crew', array('crew' => $user, 'teamnames' => $teamnames, 'userroles' => $userroles));
    }
    ?>
    </crews>
    <longitude><?=utf8_encode($user['User']['longitude'])?></longitude>
    <latitude><?=utf8_encode($user['User']['latitude'])?></latitude>
    <?php if(strlen($user['User']['image'])) { ?>
    <images>
        <image width="50">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_50.png</image>
        <image width="100">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_100.png</image>
        <image width="150">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_150.png</image>
        <image width="200">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_200.png</image>
        <image width="210">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_210.png</image>
        <image width="256">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_256.png</image>
        <image width="320">http://<?=$_SERVER['SERVER_NAME']?>/<?=$user['User']['image']?>_320.png</image>
    </images>
    <?php } ?>
</user>
