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
	Portions created by the Initial Developer are Copyright (C) 2008-2016
	the Initial Developer. All Rights Reserved.

	Contributor(s):
	Lucas Santos <lucas.santos@iungo.cloud>
*/

//if there are no items in the menu then add the default menu
	if ($domains_processed == 1) {
		require_once "resources/classes/menu.php";
		$o = new menu;
		$o->menu_default();
		unset($o);
	} //if

?>
