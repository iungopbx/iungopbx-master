<?php
/*
	IungoPBX
	Version: MPL 1.1

	The contents of this file are subject to the Mozilla Public License Version
	1.1 (the "License"); you may not use this file except in compliance with
	the License. You may obtain a copy of the License at
	http://www.mozilla.org/MPL/

	Software distributed under the License is distributed on an "AS IS" basis,
	WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
	for the specific language governing rights and limitations under the
	License.

	The Original Code is IungoPBX

	The Initial Developer of the Original Code is
	Daniel Paixao <daniel@iungo.cloud>
	Portions created by the Initial Developer are Copyright (C) 2008-2020
	the Initial Developer. All Rights Reserved.

	Contributor(s):
	Lucas Santos <lucas.santos@iungo.cloud>
*/

//set the include path
	$conf = glob("{/usr/local/etc,/etc}/iungopbx/config.conf", GLOB_BRACE);
	set_include_path(parse_ini_file($conf[0])['document.root']);

//includes files
	require_once "resources/require.php";

//add multi-lingual support
	$language = new text;
	$text = $language->get(null,'core/user_settings');

//get action, if any
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
	}

//retrieve parse reset key
	if ($action == 'define') {
		$key = $_GET['key'];
		$key_part = explode('|', decrypt($_SESSION['login']['password_reset_key']['text'], $key));
		$username = $key_part[0];
		$domain_uuid = $key_part[1];
		$password_submitted = $key_part[2];

		//get current salt, see if same as submitted salt
			$sql = "select password from v_users ";
			$sql .= "where domain_uuid = :domain_uuid ";
			$sql .= "and username = :username ";
			$parameters['domain_uuid'] = $domain_uuid;
			$parameters['username'] = $username;
			$database = new database;
			$password_current = $database->select($sql, $parameters, 'column');
			unset($sql, $parameters);

		//set flag
			if ($username != '' && $password_submitted == $password_current) {
				$password_reset = true;
				$_SESSION['valid_username'] = $username;
				$_SESSION['valid_domain'] = $domain_uuid;
			}
			else {
				header("Location: /login.php");
				exit;
			}
	}

//send password reset link
	if ($action == 'request') {
		if (valid_email($_REQUEST['email'])) {
			$email = $_REQUEST['email'];

			//see if email exists
				$sql = "select ";
				$sql .= "user_uuid, ";
				$sql .= "username, ";
				$sql .= "password, ";
				$sql .= "domain_uuid ";
				$sql .= "from ";
				$sql .= "v_users ";
				$sql .= "where user_email = :email ";
				$parameters['email'] = $email;
				$database = new database;
				$results = $database->select($sql, $parameters, 'all');
				unset($sql, $parameters);

			//check for duplicates
				if (is_array($results) && @sizeof($results) != 0) {

					if (@sizeof($results) == 1) {
						$result = $results[0];

						if ($result['username'] != '') {

							//generate reset link email and body variables
								$domain_uuid = $result['domain_uuid'];
								if ($_SESSION['login']['password_reset_domain']['text'] != '') {
									$domain_name = $_SESSION['login']['password_reset_domain']['text'];
								}
								else {
									foreach ($_SESSION['domains'] as $uuid => $domain) {
										if (strtolower($domain['domain_name']) == strtolower($_SERVER['HTTP_HOST'])) {
											$domain_name = $_SERVER['HTTP_HOST'];
											break;
										}
									}
									$domain_name = $domain_name ? $domain_name : $_SESSION['domains'][$domain_uuid]['domain_name'];
								}
								$key = encrypt($_SESSION['login']['password_reset_key']['text'], $result['username'].'|'.$result['domain_uuid'].'|'.$result['password']);
								$reset_link = "https://".$domain_name.PROJECT_PATH."/login.php?action=define&key=".urlencode($key);
								$reset_button = email_button(strtoupper($text['label-reset_password']), $reset_link, ($_SESSION['theme']['button_background_color_email']['text'] ? $_SESSION['theme']['button_background_color_email']['text'] : '#2e82d0'), ($_SESSION['theme']['button_text_color_email']['text'] ? $_SESSION['theme']['button_text_color_email']['text'] : '#ffffff'));
								$logo_full = 'data:image/png;base64,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 IpfLRJuaxw8K40QBpbG+9PAp/BtnmpLFYuT9zqqmFw9Em9pm2ZLdvobDgksCpEma04+CdHS89JJR r80YsfmoV/FUJRBRY8QGkq/9jBHrrIYieMaIFcHzVKWAty40xgS2oDdGrHWhARdx42OodrBievh4 R8erfV7gDx1D6QXo2r3urUsuu3shvt4BXI9Srehzvj/4y0zb+j0kkzZdqK0miBrtD3KD/Yek9BRA bffmDQerbtkbqLvPonMLOCuSz9EGH2Bp99Yn98+78V847xcIDcDYB8Gph/wwklp27NE+JWllvHgt bAWYjo4XeyFv83kSyReThXYj2WLPhkyeQwcqE9uYyW3Ju9W3lgAciDbd2T3vu7p/3o2fA8jEkkVn W3Gq1uZMwzHn6TqbpMzEQyeTLZZzknQW6kha5aN1MtGm5e9UfVs7o02v5PX5l9NC0k7s7baT8qbq Ez9tKTR+ehYdfNw/CWfiT2MLvVxnVVM9yj0zTXHjh25sQFykpqb30e6Jvd74JiKfbL/zKuYchukn NHoy1gCIat008Rr7XfYRyYWLanof7W4haWVyQvjk+51X+TepRf2tDAGoYgAAAIRlWElmTU0AKgAA AAgABQESAAMAAAABAAEAAAEaAAUAAAABAAAASgEbAAUAAAABAAAAUgEoAAMAAAABAAIAAIdpAAQA AAABAAAAWgAAAAAAAABIAAAAAQAAAEgAAAABAAOgAQADAAAAAQABAACgAgAEAAAAAQAAAEqgAwAE AAAAAQAAABEAAAAAgjQWkQAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMS0wNy0xM1QwNjoxMDo0MSsw MDowMLyy85sAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjEtMDctMTNUMDY6MTA6NDErMDA6MDDN70sn AAAAEXRFWHRleGlmOkNvbG9yU3BhY2UAMQ+bAkkAAAASdEVYdGV4aWY6RXhpZk9mZnNldAA5MFmM 3psAAAAXdEVYdGV4aWY6UGl4ZWxYRGltZW5zaW9uADc0BaMHJgAAABd0RVh0ZXhpZjpQaXhlbFlEaW1lbnNpb24AMTcXZiifAAAAAElFTkSuQmCC';
								$logo_shield = 'data:image/png;base64,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';

							//get user language code, if exists
								$sql = "select user_setting_value from v_user_settings ";
								$sql .= "where user_uuid = :user_uuid ";
								$sql .= "and domain_uuid = :domain_uuid ";
								$sql .= "and user_setting_category = 'domain' ";
								$sql .= "and user_setting_subcategory = 'language' ";
								$sql .= "and user_setting_name = 'code' ";
								$parameters['user_uuid'] = $result['user_uuid'];
								$parameters['domain_uuid'] = $domain_uuid;
								$database = new database;
								$row = $database->select($sql, $parameters, 'row');
								if (is_array($row) && @sizeof($row) != 0) {
									$user_language_code = $row['user_setting_value'];
								}
								unset($sql, $parameters, $row);

							//get email template from db
								$sql = "select template_subject, template_body from v_email_templates ";
								$sql .= "where template_language = :template_language ";
								$sql .= "and (domain_uuid = :domain_uuid or domain_uuid is null) ";
								$sql .= "and template_category = 'password_reset' ";
								$sql .= "and template_subcategory = 'default' ";
								$sql .= "and template_type = 'html' ";
								$sql .= "and template_enabled = 'true' ";
								$parameters['template_language'] = $user_language_code ? $user_language_code : $_SESSION['domain']['language']['code'];
								$parameters['domain_uuid'] = $domain_uuid;
								$database = new database;
								$row = $database->select($sql, $parameters, 'row');
								if (is_array($row)) {
									$email_subject = $row['template_subject'];
									$email_body = $row['template_body'];
								}
								unset($sql, $parameters, $row);

							//replace variables in email body
								$email_body = str_replace('${reset_link}', $reset_link, $email_body);
								$email_body = str_replace('${reset_button}', $reset_button, $email_body);
								$email_body = str_replace('${logo_full}', $logo_full, $email_body);
								$email_body = str_replace('${logo_shield}', $logo_shield, $email_body);
								$email_body = str_replace('${domain}', $domain_name, $email_body);

							//send reset link
								if (send_email($email, $email_subject, $email_body, $eml_error)) {
									//email sent
										message::add($text['message-reset_link_sent'], 'positive', 2500);
								}
								else {
									//email failed
										message::add($eml_error, 'negative', 5000);
								}
						}
						else {
							//not found
								message::add($text['message-invalid_email'], 'negative', 5000);
						}

					}
					else {
						//matched multiple users
							message::add($text['message-email_assigned_mutliple_users'], 'negative', 5000);
					}

				}
				else {
					//not found
						message::add($text['message-invalid_email'], 'negative', 5000);
				}

		}
		else {
			//invalid email
				message::add($text['message-invalid_email'], 'negative', 5000);
		}
	}

//reset password
	if ($action == 'reset') {
		$username = trim($_REQUEST['username']);
		$password_new = trim($_REQUEST['password_new']);
		$password_repeat = trim($_REQUEST['password_repeat']);

		//if not requiring usernames to be of email format, strip off @domain as the valid domain for the reset is already being provided in the where clause below
		if ($_SESSION['users']['username_format']['text'] != 'email') {
			$username = substr_count($username, '@') != 0 ? explode('@', $username)[0] : $username;
		}

		if ($username !== '' &&
			$username === $_SESSION['valid_username'] &&
			$password_new !== '' &&
			$password_repeat !== '' &&
			$password_new === $password_repeat
			) {

			if (!check_password_strength($password_new, $text, 'user')) {
				$password_reset = true;
			}
			else {
				$salt = uuid();
				$sql  = "update v_users set ";
				$sql .= "password = :password, ";
				$sql .= "salt = :salt ";
				$sql .= "where domain_uuid = :domain_uuid ";
				$sql .= "and username = :username ";
				$parameters['domain_uuid'] = $_SESSION['valid_domain'];
				$parameters['password'] = md5($salt.$password_new);
				$parameters['salt'] = $salt;
				$parameters['username'] = $username;
				$database = new database;
				$database->execute($sql, $parameters);
				unset($sql, $parameters);

				message::add($text['message-password_reset'], 'positive', 2500);
				unset($_SESSION['valid_username'], $_SESSION['valid_domain']);

				header('Location: //'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				exit;

			}
		}
		else {
			//not found
				message::add($text['message-invalid_username_mismatch_passwords'], 'negative', 5000);
				$password_reset = true;
		}
	}

//get the http values and set as variables
	$msg = isset($_GET["msg"]) ? $_GET["msg"] : null;

//set variable if not set
	if (!isset($_SESSION['login']['domain_name_visible']['boolean'])) { $_SESSION['login']['domain_name_visible']['boolean'] = null; }

//santize the login destination url and set a default value
	if (isset($_SESSION['login']['destination']['url'])) {
		$destination_path = parse_url($_SESSION['login']['destination']['url'])['path'];
		$destination_query = parse_url($_SESSION['login']['destination']['url'])['query'];
		$destination_path = preg_replace('#[^a-zA-Z0-9_\-\./]#', '', $destination_path);
		$destination_query = preg_replace('#[^a-zA-Z0-9_\-\./&=]#', '', $destination_query);
		$_SESSION['login']['destination']['url'] = (strlen($destination_query) > 0) ? $destination_path.'?'.$destination_query : $destination_path;
	}
	else {
		$_SESSION['login']['destination']['url'] = PROJECT_PATH."/core/dashboard/";
	}

	if (strlen($_REQUEST['path']) > 0) {
		$_SESSION['redirect_path'] = $_REQUEST['path'];
	}

//add the header
	$document['title'] = $text['title-login'];
	include "resources/header.php";

//show the content
	echo "<script>";
	echo "	var speed = 350;";
	echo "	function toggle_password_reset(hide_id, show_id, focus_id) {";
	echo "		if (focus_id == undefined) { focus_id = ''; }";
	echo "		$('#'+hide_id).slideToggle(speed, function() {";
	echo "			$('#'+show_id).slideToggle(speed, function() {";
	echo "				if (focus_id != '') {";
	echo "					$('#'+focus_id).trigger('focus');";
	echo "				}";
	echo "			});";
	echo "		});";
	echo "	}";
	echo "</script>";

	echo "<br />\n";

	if (!$password_reset) {

		//create token
			$object = new token;
			$token = $object->create('login');

		echo "<div id='login_form'>\n";
		echo "<form name='login' method='post' action='".$_SESSION['login']['destination']['url']."'>\n";
		echo "<input type='text' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-bottom: 8px;' name='username' id='username' placeholder=\"".$text['label-username']."\"><br />\n";
		echo "<input type='password' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-bottom: 8px;' name='password' placeholder=\"".$text['label-password']."\"><br />\n";
		if ($_SESSION['login']['domain_name_visible']['boolean'] == "true") {
			if (count($_SESSION['login']['domain_name']) > 0) {
				$click_change_color = ($_SESSION['theme']['login_input_text_color']['text'] != '') ? $_SESSION['theme']['login_input_text_color']['text'] : (($_SESSION['theme']['input_text_color']['text'] != '') ? $_SESSION['theme']['input_text_color']['text'] : '#000000');
				$placeholder_color = ($_SESSION['theme']['login_input_text_placeholder_color']['text'] != '') ? 'color: '.$_SESSION['theme']['login_input_text_placeholder_color']['text'].';' : 'color: #999999;';
				echo "<select name='domain_name' class='txt login' style='".$placeholder_color." width: 200px; text-align: center; text-align-last: center; margin-bottom: 8px;' onclick=\"this.style.color='".$click_change_color."';\" onchange=\"this.style.color='".$click_change_color."';\">\n";
				echo "	<option value='' disabled selected hidden>".$text['label-domain']."</option>\n";
				sort($_SESSION['login']['domain_name']);
				foreach ($_SESSION['login']['domain_name'] as &$row) {
					echo "	<option value='".escape($row)."'>".escape($row)."</option>\n";
				}
				echo "</select><br />\n";
			}
			else {
				echo "<input type='text' name='domain_name' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-bottom: 8px;' placeholder=\"".$text['label-domain']."\"><br />\n";
			}
		}
		echo "<input type='submit' id='btn_login' class='btn' style='width: 100px; margin-top: 15px;' value='".$text['button-login']."'>\n";
		if (
			function_exists('openssl_encrypt') &&
			$_SESSION['login']['password_reset_key']['text'] != '' &&
			$_SESSION['email']['smtp_host']['text'] != ''
			) {
			echo "<br><br><a class='login_link' onclick=\"toggle_password_reset('login_form','request_form','email');\">".$text['label-reset_password']."</a>";
		}
		echo "<input type='hidden' name='".$token['name']."' value='".$token['hash']."'>\n";
		echo "</form>";
		echo "<script>$('#username').trigger('focus');</script>";
		echo "</div>";

		echo "<div id='request_form' style='display: none;'>\n";
		echo "<form name='request' method='post'>\n";
		echo "<input type='hidden' name='action' value='request'>\n";
		echo "<input type='text' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-bottom: 8px;' name='email' id='email' placeholder=\"".$text['label-email_address']."\"><br />\n";
		echo "<input type='submit' id='btn_reset' class='btn' style='width: 100px; margin-top: 15px;' value='".$text['button-reset']."'>\n";
		echo "<br><br><a class='login_link' onclick=\"toggle_password_reset('request_form','login_form','username');\">".$text['label-cancel']."</a>";
		echo "</form>";
		echo "</div>";

	}
	else {

		echo "<script>\n";
		echo "	function compare_passwords() {\n";
		echo "		if (document.getElementById('password') === document.activeElement || document.getElementById('password_confirm') === document.activeElement) {\n";
		echo "			if ($('#password').val() != '' || $('#password_confirm').val() != '') {\n";
		echo "				if ($('#password').val() != $('#password_confirm').val()) {\n";
		echo "					$('#password').removeClass('formfld_highlight_good');\n";
		echo "					$('#password_confirm').removeClass('formfld_highlight_good');\n";
		echo "					$('#password').addClass('formfld_highlight_bad');\n";
		echo "					$('#password_confirm').addClass('formfld_highlight_bad');\n";
		echo "				}\n";
		echo "				else {\n";
		echo "					$('#password').removeClass('formfld_highlight_bad');\n";
		echo "					$('#password_confirm').removeClass('formfld_highlight_bad');\n";
		echo "					$('#password').addClass('formfld_highlight_good');\n";
		echo "					$('#password_confirm').addClass('formfld_highlight_good');\n";
		echo "				}\n";
		echo "			}\n";
		echo "		}\n";
		echo "		else {\n";
		echo "			$('#password').removeClass('formfld_highlight_bad');\n";
		echo "			$('#password_confirm').removeClass('formfld_highlight_bad');\n";
		echo "			$('#password').removeClass('formfld_highlight_good');\n";
		echo "			$('#password_confirm').removeClass('formfld_highlight_good');\n";
		echo "		}\n";
		echo "	}\n";

		$setting['length'] = $_SESSION['users']['password_length']['numeric'];
		$setting['number'] = ($_SESSION['users']['password_number']['boolean'] == 'true') ? true : false;
		$setting['lowercase'] = ($_SESSION['users']['password_lowercase']['boolean'] == 'true') ? true : false;
		$setting['uppercase'] = ($_SESSION['users']['password_uppercase']['boolean'] == 'true') ? true : false;
		$setting['special'] = ($_SESSION['users']['password_special']['boolean'] == 'true') ? true : false;

		echo "	function check_password_strength(pwd) {\n";
		echo "		if ($('#password').val() != '' || $('#password_confirm').val() != '') {\n";
		echo "			var msg_errors = [];\n";
		if (is_numeric($setting['length']) && $setting['length'] != 0) {
			echo "		var re = /.{".$setting['length'].",}/;\n"; //length
			echo "		if (!re.test(pwd)) { msg_errors.push('".$setting['length']."+ ".$text['label-characters']."'); }\n";
		}
		if ($setting['number']) {
			echo "		var re = /(?=.*[\d])/;\n";  //number
			echo "		if (!re.test(pwd)) { msg_errors.push('1+ ".$text['label-numbers']."'); }\n";
		}
		if ($setting['lowercase']) {
			echo "		var re = /(?=.*[a-z])/;\n";  //lowercase
			echo "		if (!re.test(pwd)) { msg_errors.push('1+ ".$text['label-lowercase_letters']."'); }\n";
		}
		if ($setting['uppercase']) {
			echo "		var re = /(?=.*[A-Z])/;\n";  //uppercase
			echo "		if (!re.test(pwd)) { msg_errors.push('1+ ".$text['label-uppercase_letters']."'); }\n";
		}
		if ($setting['special']) {
			echo "		var re = /(?=.*[\W])/;\n";  //special
			echo "		if (!re.test(pwd)) { msg_errors.push('1+ ".$text['label-special_characters']."'); }\n";
		}
		echo "			if (msg_errors.length > 0) {\n";
		echo "				var msg = '".$text['message-password_requirements'].": ' + msg_errors.join(', ');\n";
		echo "				display_message(msg, 'negative', '6000');\n";
		echo "				return false;\n";
		echo "			}\n";
		echo "			else {\n";
		echo "				return true;\n";
		echo "			}\n";
		echo "		}\n";
		echo "		else {\n";
		echo "			return true;\n";
		echo "		}\n";
		echo "	}\n";

		echo "	function show_strenth_meter() {\n";
		echo "		$('#pwstrength_progress').slideDown();\n";
		echo "	}\n";
		echo "</script>\n";

		echo "<span id='reset_form'>\n";
		echo "<form name='reset' id='frm' method='post'>\n";
		echo "<input type='hidden' name='action' value='reset'>\n";
		echo "<input type='text' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-bottom: 8px;' name='username' id='username' placeholder=\"".$text['label-username']."\"><br />\n";
		echo "<input type='password' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-bottom: 4px;' name='password_new' id='password' autocomplete='off' placeholder=\"".$text['label-new_password']."\" onkeypress='show_strenth_meter();' onfocus='compare_passwords();' onkeyup='compare_passwords();' onblur='compare_passwords();'><br />\n";
		echo "<div id='pwstrength_progress' class='pwstrength_progress pwstrength_progress_password_reset'></div>";
		echo "<input type='password' class='txt login' style='text-align: center; min-width: 200px; width: 200px; margin-top: 4px; margin-bottom: 8px;' name='password_repeat' id='password_confirm' autocomplete='off' placeholder=\"".$text['label-repeat_password']."\" onfocus='compare_passwords();' onkeyup='compare_passwords();' onblur='compare_passwords();'><br />\n";
		echo "<input type='button' class='btn' style='width: 100px; margin-top: 15px;' value='".$text['button-save']."' onclick=\"if (check_password_strength(document.getElementById('password').value)) { submit_form(); }\">\n";
		echo "<br><br><a class='login_link' onclick=\"document.location.href='login.php';\">".$text['label-cancel']."</a>";
		echo "</form>";

		echo "<script>\n";
		echo "	$('#username').trigger('focus');\n";
		// convert password fields to text
		echo "	function submit_form() {\n";
		echo "		hide_password_fields();\n";
		echo "		$('form#frm').submit();\n";
		echo "	}\n";
		echo "</script>\n";
		echo "</span>";

	}

//add the footer
	$login_page = true;
	include "resources/footer.php";

?>
