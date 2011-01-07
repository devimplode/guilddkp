<?php
	define('loadet', true);
	require_once(dirname(__FILE__).'/common.php');

	/* **********
	 * forum.php
	 * **********
	 */

	if (!$user->check_auth('rank_read_forum'))
	{
		$tpl->assign('title', $config->get('title').' - Forum - Access denied');
		$tpl->assign('access',false);
		$tpl->display('forum.tpl');
		die();
		// Ende der Fahnenstange
	}
	else
		$tpl->assign('access',true);

	//Variablen auslesen
	$request_id	= $in->get('id',0);
	$request_cmd		= $in->get('c','');


	switch($request_cmd)
	{
		case "topic":
			$forum->show_topic_main($request_id);
			$tpl->display('forum.tpl');
        break;
		case "forum":
			$request_cmd = 'view_forum';
			$tpl->display('forum.tpl');
        break;
		case "api_topic":
			$forum->show_topic_api($request_id);
			exit();
		break;
		case "execute":
			$post_set			= $in->get('set','');
			$post_forum			= $in->get('forum','');
			$post_topic			= $in->get('topic',0);
			$post_post 			= $in->get('post',0);
			$post_title			= $in->get('title','');
			$post_text			= $in->get('post_text','');
			
			if(($post_set == 'delete_post') && ($request_forum_id) && ($request_topic_id) && ($request_post_id))
				die($user->check_auth('a_forum_delete_post')?(($forum->delete_post($request_forum_id, $request_topic_id, $request_post_id))?'1':'0'):'403');
			elseif(($post_set == 'delete_topic') && ($request_forum_id) && ($request_topic_id))
				die($user->check_auth('a_forum_delete_topic')?(($forum->delete_topic($request_forum_id, $request_topic_id))?'1':'0'):'403');
			elseif(($post_set == 'close_topic') && ($request_forum_id) && ($request_topic_id))
				die($user->check_auth('a_forum_close_topic')?(($forum->close_toogle_topic($request_forum_id, $request_topic_id))?'1':'0'):'403');
			elseif(($post_set == 'hide_topic') && ($request_forum_id) && ($request_topic_id))
				die($user->check_auth('a_forum_hide_topics')?(($forum->hide_toogle_topic($request_forum_id, $request_topic_id))?'1':'0'):'403');
			elseif(($post_set == 'hide_forum') && ($request_forum_id))
				die($user->check_auth('a_forum_hide_forum')?(($forum->hide_toogle_forum($request_forum_id))?'1':'0'):'403');
			elseif(($post_set == 'move_topic') && ($request_topic_id) && ($request_forum_id))
				die($user->check_auth('a_forum_move_topic')?(($forum->move_topic($request_topic_id, $request_forum_id))?'1':'0'):'403');
			elseif(($post_set == 'create_topic') && ($post_title) && ($post_text) && ($post_forum))
				die($user->check_auth('u_forum_create_topic')?(($forum->create_topic($post_forum, $post_title, $post_text, 0))?'1':'0'):'403');
			elseif(($post_set == 'create_post') && ($post_forum) && ($post_topic) && ($post_text))
				die($user->check_auth('u_forum_create_post')?(($forum->create_post($post_forum, $post_topic, $post_text, 0))?'1':'0'):'403');
			elseif(($post_set == 'edit_post') && ($post_forum != false) && ($post_topic != false) && ($post_post != false) && ($post_text != false))
			{
				$sql = "SELECT post_user_id FROM eqdkp_fmod_posts WHERE topic_id = '".$post_topic."' AND post_id = '".$post_post."'";
				$post_query = $db->query($sql);
				$post = $db->fetch_record($post_query);
				if ( ($user->check_auth('a_forum_edit_post')) || ( ($user->check_auth('u_forum_edit_own_post')) && ($post['post_user_id'] == $user->data['user_id'] ) ) )
					die(($forum->edit_post($post_forum, $post_topic, $post_post, $post_text) == true)?'1':'0');
				else
					die('403');
			}
			elseif(($post_set == 'move_topic') && ($post_topic) && ($post_forum))
				die($user->check_auth('a_forum_move_topic')?(($forum->move_topic($post_topic, $post_forum))?'1':'0'):'403');
		break;
		
		default:
			header("Location: news");
			exit();
	}
?>