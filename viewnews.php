<?php
define('loadet', true);
require_once(dirname(__FILE__).'/common.php');

/* **********
 * viewnews.php
 * **********
 */

if(defined('CACHING'))
{
$expires = 60*15;
header("Pragma: private");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
}
$newsPerPage = 5;

$start = $in->get('start', 0);
$newsid = $in->get('id', 0);

$total_news = $db->query_first('SELECT count(*) FROM ' . T_NEWS);

if ($newsid)
{
	$sql = "SELECT n.*, u.user_displayname as user_name FROM ".T_NEWS." n, ".T_USER." u WHERE n.user_id = u.user_id AND n.news_id='".$db->sql_escape($newsid)."' AND n.news_permissions <= '".$user->get_auth('rank_read_news')."'";

	$result = $db->query($sql);
}
else
{
	$sql = "SELECT n.*, u.user_displayname as user_name FROM ".T_NEWS." n, ".T_USER." u WHERE n.user_id = u.user_id AND n.news_permissions <= '".$user->get_auth('rank_read_news')."' ORDER BY n.news_flags DESC, n.news_date DESC LIMIT ".$start.", ".intval($newsPerPage).";";
	$result = $db->query($sql);
	if ( $db->num_rows($result) == 0 )
	{
		die("Keine News");
	}
}
$cur_news_number = 0;
$sticky_news = 0;
$news_array = array();
while( $news = $db->fetch_record($result) )
{
	if ($news['nocomments']==0 && $newsid)
	{
		if($user->check_auth('rank_read_comment'))
		{
			$tpl->assign('SHOW_COMMENTS', true);
		}
	}

	$t = time()-$news['news_date'];
	$t = ($t<60) ? "Vor weniger als einer Minute" : (($t<3600)?"Vor ".date("i",$t)." Minuten":date("G:i - d.m.Y", $news['news_date']));
	$tpl->append('news_obj', 
		array(
			'STICKY' => ($news['news_flags']) ? true : false,
			'HEADLINE' => stripslashes($news['news_headline']),
			'CLEANTITLE' => str_replace(array('|',' ','-'),array('','_','_'),$news['news_headline']),
			'AUTHOR' => $news['user_name'],
			'TIME' => $t,
			'ID' => $news['news_id'],
			'MESSAGE' => bbDeCode(nl2br($news['news_message']))
		)
	);
	if($newsid)
		$single_news_title = ": ".$news['news_headline'];
}
$db->free_result($result);	

$tpl->assign('title', $config->get('title').' - News'.$single_news_title);
$tpl->display('viewnews.tpl');
?>
