<?php
	if($_GET['a'])
	{
		define('loadet', true);
		require_once(dirname(__FILE__).'/common.php');
	}
	if($_GET['a']=='r')
	{
		require_once('recaptchalib.php');
		$privatekey = "6Lcldr4SAAAAAJEtOWhQU-3gGBUPk6xaXcBTUY2J ";
		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		if (!$resp->is_valid)
		{
			print('captcha');
			die();
		}


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
	elseif($_GET['a']=='g')
	{
		if($_GET['w']=='captcha')
		{
			require_once('recaptchalib.php');
			$publickey = "6Lcldr4SAAAAAI0ZPMrDCPMAoNE9ktKkwz0ZRaDE";
			//print(recaptcha_get_html($publickey));
			print('<div id="recaptcha_widget" style="display:none">

   <div id="recaptcha_image"></div>
   <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>

   <span class="recaptcha_only_if_image">Enter the words above:</span>
   <span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>

   <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

   <div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>
   <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type(\'audio\')">Get an audio CAPTCHA</a></div>
   <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type(\'image\')">Get an image CAPTCHA</a></div>

   <div><a href="javascript:Recaptcha.showhelp()">Help</a></div>

 </div>

 <script type="text/javascript"
    src="http://www.google.com/recaptcha/api/challenge?k='.$publickey.'">
 </script>
 <noscript>
   <iframe src="http://www.google.com/recaptcha/api/noscript?k='.$publickey.'"
        height="300" width="500" frameborder="0"></iframe><br>
   <textarea name="recaptcha_challenge_field" rows="3" cols="40">
   </textarea>
   <input type="hidden" name="recaptcha_response_field"
        value="manual_challenge">
 </noscript>');
			die();
		}
	}
?>
