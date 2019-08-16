<?php
require_once('/srv/vhosts/wannabe.gathering.org/wannabe/webroot/api/twitter/link/twitteroauth/twitteroauth.php');
require_once('/srv/vhosts/wannabe.gathering.org/wannabe/webroot/api/db.lib.php');
$db = new Database();

$consumer = $db->queryRow('SELECT twitter_consumers.key, secret FROM twitter_consumers WHERE id = 1');
$user = $db->queryRow('SELECT twitter_users.key, secret FROM twitter_users WHERE id = 1');

$connection = new TwitterOAuth($consumer['key'], $consumer['secret'], $user['key'], $user['secret']);

$recent = $db->query('SELECT id FROM twitter_gathering ORDER BY id DESC LIMIT 3');

$counts = array();

foreach($recent as $id):
	$retweets = $connection->get('statuses/retweets/'.$id['id']);
	$counts[$id['id']] = 0;
	foreach ($retweets as $user):
		$counts[$id['id']]++;		
	endforeach;
endforeach;

foreach($counts as $id => $count):
	$db->query('UPDATE twitter_gathering SET retweet = '.$count.' WHERE id = '.$id);
endforeach;
?>
