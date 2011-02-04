<?php
	if($_GET['a'])
	{
		define('loadet', true);
		define('api', true);
		require_once(dirname(__FILE__).'/common.php');
	}
	if($_GET['a']=='r')
	{
		//GET data to create acc and valide this data
		// var data - needed data to create acc
		if(strlen($in->get('birthday', '')) < 8)
		{
			print('bday');
			die();
		}
		$b_day = explode('.', $in->get('birthday', ''));
		$data=array(
			'user_name'=>$in->get('user_name', ''),
			'display_name'=>$in->get('display_name', ''),
			'password'=>$in->get('password', ''),
			'password_b'=>$in->get('password_b', ''),
			'email'=>$in->get('email', ''),
			'birthday'=>mktime(0,0,0,$b_day[1],$b_day[0],$b_day[2])
		);
		$name_query = $db->query("SELECT * FROM ".T_USER." WHERE user_name ='".strtolower($data['user_name'])."'");
		if($db->fetch_record($name_query))
		{
			print('given_usr');
			die();
		}
		elseif(strlen($data['user_name']) < 3)
		{
			print('short_usr');
			die();
		}
		elseif(strlen($data['password']) < 5)
		{
			print('short_pwd');
			die();
		}
		elseif($data['password_b']!=$data['password'])
		{
			print('re_pwd');
			die();
		}
		// var additional_data - data not neccesary but nice to have
		$additional_data=array(
			'pic'=>$in->get('pic', '')
		);
		foreach($data as $field)
			if($field==''||!$field)
			{
				//header('Content-Type: application/json; charset=utf8');
				print('fail_data');
				die();
			}
		// LOG-Eintrag erstellen
		// user anlegen (active = 0)
		$sql = "INSERT INTO dkp_user 
		(user_name,
		user_displayname,
		user_password,
		user_decrypt_password,
		user_email,
		user_icon,
		user_rank,
		user_key,
		user_active,
		birthday
		)
		VALUES(
		'".strtolower($data['user_name'])."',
		'".$data['display_name']."',
		'".md5(sha1(str_rot13($data['password'])))."',
		'".base64_encode(str_rot13($data['password']))."',
		'".$data['email']."',
		'".$db->sql_escape($additional_data['pic'])."',
		'2',
		'".md5($data['user_name'].rand(1111,9999))."',
		'0',
		'".date($data['birthday'])."'
		);";
		echo( ($db->query($sql))?"OK":"E");
		die();
	}
	elseif($_GET['a']=='c')
	{
		if($_GET['w']=='un')
		{
			$query = $db->query("SELECT * FROM ".T_USER." WHERE user_name ='".strtolower($in->get('un'))."'");
			header('Content-Type: application/json; charset=utf8');
			print(($db->fetch_record($query))?'0':'1');
			die();
		}
	}
	elseif($_GET['a']=='reg')
	{
		if($_GET['s']='2')
		{
			die('<form class="reg_form" action="register.php" methode="post"><table class="reg_tbl">'.
				'<tr><td>Loginname:</td><td><input type="text" name="username" id="user_name" class="text ui-widget-content ui-corner-all" value="" /></td></tr>'.
				'<tr><td>Name:</td><td><input type="text" name="display_name" id="display_name" class="text ui-widget-content ui-corner-all" value="" /></td></tr>'.
				'<tr><td>Passwort:</td><td><input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" /></td></tr>'.
				'<tr><td>Passwort bestätigen:</td><td><input type="password" name="password_b" id="password_b" value="" class="text ui-widget-content ui-corner-all" /></td></tr>'.
				'<tr><td>E-Mail:</td><td><input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" /></td></tr>'.
				'<tr><td>Geburtsdatum:</td><td><input type="text" name="date" id="birthday_c" value="" class="text ui-widget-content ui-corner-all" /></td></tr>'.
				'<tr><td>Profilbild:</td><td><input type="text" name="pic_url" id="pic_url" value="" class="text ui-widget-content ui-corner-all" /></td></tr>'.
				'<tr><td><input type="submit" value="Registrieren"/></td><td><input type="reset" value="Abbrechen"/></td></tr>'.
				'</table></form><div class="login_loading" />');
		}
	}
?>
