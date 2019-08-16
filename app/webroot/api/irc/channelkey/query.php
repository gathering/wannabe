<?php
require_once('/srv/vhosts/wannabe.gathering.org/wannabe/app/webroot/api/db.lib.php');
$db = new Database();
if($_GET['apikey'] != 'NJueg7BHBgay6GadIhBgdJ8'):
	echo "<error>Not authorized</error>";
elseif(!isset($_GET['channel'])):
	echo "<error>No channel</error>";
else:
	$key = $db->queryRow("SELECT value from wb4_ircchannelkeys where name ='#".$_GET['channel']."' order by event_id desc limit 1;");
	if(empty($key)):
		echo "<error>No such channel</error>";
	else:
		echo "<key>".$key['value']."</key>";
	endif;
endif;

?>
