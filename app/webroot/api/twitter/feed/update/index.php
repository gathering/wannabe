<?php
require_once('/srv/vhosts/wannabe.gathering.org/wannabe/app/webroot/api/twitter/link/twitteroauth/twitteroauth.php');
require_once('/srv/vhosts/wannabe.gathering.org/wannabe/app/webroot/api/db2.lib.php');
$db = new Database();

function twitterify($ret) {
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
	$ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
	$ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
	$ret = str_replace(array('æ', 'ø', 'å', 'Æ', 'Ø', 'Å'),array('&aelig;', '&oslash;', '&aring;', '&AElig;', '&Oslash;', '&Aring;'),$ret);
	$ret = htmlentities($ret);
	return $ret;
}

$consumer = $db->queryRow('SELECT twitter_consumers.key, secret FROM twitter_consumers WHERE id = 1');
$user = $db->queryRow('SELECT twitter_users.key, secret FROM twitter_users WHERE id = 1');

$connection = new TwitterOAuth($consumer['key'], $consumer['secret'], $user['key'], $user['secret']);
$posts = $connection->get('statuses/user_timeline');

if(isset($_REQUEST['debug'])) {
	print_r($posts);
}

$db->query("DELETE FROM twitter_gathering");

foreach($posts as $post):
	$post = json_encode($post);
	$post = json_decode($post, true);
	//$post['created_at'] =  date('Y-m-d H:i:s', strtotime($post['created_at']));
	//echo $post['created_at']."\n";
	if(!$post['in_reply_to_screen_name']) $post['in_reply_to_screen_name'] = 0;
	if(!$post['in_reply_to_user_id']) $post['in_reply_to_user_id'] = 0;
	if(!$post['in_reply_to_status_id']) $post['in_reply_to_status_id'] = 0;
	$text_twitterified = twitterify($post['text']);
	$db->query('INSERT INTO twitter_gathering VALUES ('.$post['id'].', 
"'.$post['text'].'","'.$post['in_reply_to_screen_name'].'",'.$post['in_reply_to_status_id'].',"'.$post['in_reply_to_user_id'].'",FROM_UNIXTIME('.strtotime($post['created_at']).'),"'.$text_twitterified.'", 
0 )');
endforeach;

$recent = $db->query('SELECT id FROM twitter_gathering ORDER BY id DESC LIMIT 3');

//print_r($recent);

$counts = array();

foreach($recent as $id):
        $retweets = $connection->get('statuses/retweets/'.$id['id']);
        $counts[$id['id']] = 0;
        foreach ($retweets as $user):
                $counts[$id['id']]++;
        endforeach;
endforeach;

//print_r($counts);

foreach($counts as $id => $count):
        $db->query('UPDATE twitter_gathering SET retweet = '.$count.' WHERE id = '.$id);
endforeach;
?>
