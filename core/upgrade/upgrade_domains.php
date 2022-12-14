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
	Portions created by the Initial Developer are Copyright (C) 2008-2012
	the Initial Developer. All Rights Reserved.

	Contributor(s):
	Lucas Santos <lucas.santos@iungo.cloud>
*/

//check the permission
	if(defined('STDIN')) {
		//set the include path
		$conf = glob("{/usr/local/etc,/etc}/iungopbx/config.conf", GLOB_BRACE);
		set_include_path(parse_ini_file($conf[0])['document.root']);

		//includes files
		require_once "resources/require.php";
		$_SERVER["DOCUMENT_ROOT"] = $document_root;
		$display_type = 'text'; //html, text
	}
	else if (!$included) {
		//set the include path
		$conf = glob("{/usr/local/etc,/etc}/iungopbx/config.conf", GLOB_BRACE);
		set_include_path(parse_ini_file($conf[0])['document.root']);

		//includes files
		require_once "resources/require.php";
		require_once "resources/check_auth.php";
		if (permission_exists('upgrade_apps') || if_group("superadmin")) {
			//echo "access granted";
		}
		else {
			echo "access denied";
			exit;
		}
		$display_type = 'html'; //html, text
	}

//run all app_defaults.php files
	require_once "resources/classes/config.php";
	require_once "resources/classes/domains.php";
	$domain = new domains;
	$domain->display_type = $display_type;
	$domain->upgrade();

?>
