<?php
	if(!defined('loadet'))
	{
		die('Do not access this file directly.');
	}
	define('intern', true);
	
	$root_dir = dirname(__FILE__);
	set_include_path($root_dir.'/includes/');
	require_once('filehandler.php');
	require_once('IDS/Init.php');
	require_once('input.php');
	require_once('mysql.php');
	require_once('session.php');
	if(!defined('api'))
		require_once('tpl/Smarty.class.php');

	$config = new config_handler($root_dir."/includes/config.php");
	$cache = new cache_handler($root_dir."/includes/cache/");
	// IDS
	if($config->get('ids_enabled'))
	{
		try{
			$ids_init = IDS_Init::init($path.'includes/IDS/Config/Config.ini.php');
			$ids = new IDS_Monitor(array_merge_recursive($_GET, $_POST), $ids_init);
			$ids_result = $ids->run();
			if(!$ids_result->isEmpty())
			{
				if(is_array($config->get('IDS')))
				{
					require_once('IDS/Log/Composite.php');
					$ids_logger = new IDS_Log_Composite();
					foreach($config->get('IDS') as $k => $v)
						if($v)
						{
							require_once('IDS/Log/'.$k.'.php');
							// For php < 5.3 (i hate my hoster...)
							if($k=="File")
								$ids_logger->addLogger(IDS_Log_File::getInstance($ids_init));
							elseif($k=="Database")
								$ids_logger->addLogger(IDS_Log_Database::getInstance($ids_init));
							elseif($k=="Email")
								$ids_logger->addLogger(IDS_Log_Email::getInstance($ids_init));
						}
					$ids_logger->execute($ids_result);
				}
			}
		}
		catch(Exepetion $e)
		{
			printf('Fehler: %s', $e->getMessage());
		}
	}

	$in = new Input;
	//include db-connection
	$db = new dbal_mysql;
	$conn = new config_handler($root_dir."/includes/db_conf.php");
	$db->sql_connect($conn->get('host'), $conn->get('name'), $conn->get('user'), $conn->get('pwd'), false);
	// Database Table names
	unset($conn);
	//include tpl-system
	if(!defined('api'))
	{
		$tpl = new Smarty;
		$tpl->template_dir = $root_dir.'/templates';
		$tpl->setTpl($config->get('default_template'));
		$tpl->compile_check = ($config->get('template_compile_check'))?true:false;
		$tpl->debugging = ($config->get('template_debug'))?true:false;
		$tpl->assign('base_page', $config->get('main_page'));
		$tpl->assign('domain', $config->get('domain'));
		$tpl->assign('FB', ($config->get('facebook'))?true:false);
	}

	$SID = '';
	$user = new User;
	$user->start();
	$user->setup();
	//$cache = new cache_handler($root_dir."/includes/cache/user_".$user->data['user_id'].".php");
	if(!defined('api'))
	{
		$tpl->assign('SID', ($SID!='?s=')?$SID:'');
		$tpl->assign('user_icon', ($user->data['user_icon'] != '')? $user->data['user_icon']:"https://secure.gravatar.com/avatar/".md5($user->data['user_email'])."?d=".$config->get("domain")."/images/default_profile.png");
		
		$active_user = array();
		$query = $db->query("SELECT u.user_displayname as name, u.user_icon as icon, MD5(u.user_email) as hash FROM ".T_SESSIONS." s, ".T_USER." u WHERE session_user_id > 0 AND s.session_user_id = u.user_id;");
		while($k = $db->fetch_record($query))
			$active_user[] = $k;
		$currentUser="";
		foreach($active_user as $k=>$v)
			$currentUser.='<img alt="'.$v['name'].'" title="'.$v['name'].'" src="'.(($v['icon']!='')?$v['icon']:"https://secure.gravatar.com/avatar/".$v['hash']."?d=".$config->get("domain")."/images/default_profile.png").'" />';
		$tpl->assign('ACTIVE_USER', $currentUser);
		require_once('forum.class.php');
	}
	

	//include sessions
	//include login
	//include usermanagment


?>