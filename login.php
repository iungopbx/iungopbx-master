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
	Portions created by the Initial Developer are Copyright (C) 2008-2022
	the Initial Developer. All Rights Reserved.

	Contributor(s):
	Lucas Santos <lucas.santos@iungo.cloud>
*/
//set the include path
	$conf = glob("{/usr/local/etc,/etc}/iungopbx/config.conf", GLOB_BRACE);
	set_include_path(parse_ini_file($conf[0])['document.root']);

//includes files
	require_once "resources/require.php";

//start session
	if (!isset($_SESSION)) { session_start(); }

//if config.conf file does not exist then redirect to the install page
	if (file_exists("/usr/local/etc/iungopbx/config.conf")) {
		//BSD
	} elseif (file_exists("/etc/iungopbx/config.conf")) {
		//Linux
	} else {
		header("Location: /core/install/install.php");
		exit;
	}

//use custom login, if present, otherwise use default login
	if (file_exists($_SERVER["PROJECT_ROOT"]."/themes/".$_SESSION['domain']['template']['name']."/login.php")) {
		require_once "themes/".$_SESSION['domain']['template']['name']."/login.php";
	}
	else {
		require_once "resources/login.php";
	}

?>
