<?php

	//application details
		$apps[$x]['name'] = "Operator Panel";
		$apps[$x]['uuid'] = "dd3d173a-5d51-4231-ab22-b18c5b712bb2";
		$apps[$x]['category'] = "Switch";
		$apps[$x]['subcategory'] = "";
		$apps[$x]['version'] = "1.0";
		$apps[$x]['license'] = "Mozilla Public License 1.1";
		$apps[$x]['url'] = "https://iungo.cloud";
		$apps[$x]['description']['en-us'] = "Operator panel shows the status.";
		$apps[$x]['description']['en-gb'] = "Operator panel shows the status.";
		$apps[$x]['description']['ar-eg'] = "";
		$apps[$x]['description']['de-at'] = "Das Bedienfeld zeigt den Status an.";
		$apps[$x]['description']['de-ch'] = "";
		$apps[$x]['description']['de-de'] = "Das Bedienfeld zeigt den Status an.";
		$apps[$x]['description']['es-cl'] = "";
		$apps[$x]['description']['es-mx'] = "";
		$apps[$x]['description']['fr-ca'] = "";
		$apps[$x]['description']['fr-fr'] = "";
		$apps[$x]['description']['he-il'] = "";
		$apps[$x]['description']['it-it'] = "";
		$apps[$x]['description']['nl-nl'] = "Bedieningspaneel laat de status zien";
		$apps[$x]['description']['pl-pl'] = "";
		$apps[$x]['description']['pt-br'] = "";
		$apps[$x]['description']['pt-pt'] = "Canais ativos no sistema.";
		$apps[$x]['description']['ro-ro'] = "";
		$apps[$x]['description']['ru-ru'] = "";
		$apps[$x]['description']['sv-se'] = "";
		$apps[$x]['description']['uk-ua'] = "";

	//permission details
		$y=0;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_view";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_manage";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_eavesdrop";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_hangup";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_record";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_call_details";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "operator_panel_on_demand";

	//default settings
		$y=0;
		$apps[$x]['default_settings'][$y]['default_setting_uuid'] = "569280f2-a433-4eaf-9c08-945efdc6cf8f";
		$apps[$x]['default_settings'][$y]['default_setting_category'] = "operator_panel";
		$apps[$x]['default_settings'][$y]['default_setting_subcategory'] = "refresh";
		$apps[$x]['default_settings'][$y]['default_setting_name'] = "numeric";
		$apps[$x]['default_settings'][$y]['default_setting_value'] = "1500";
		$apps[$x]['default_settings'][$y]['default_setting_enabled'] = "true";
		$apps[$x]['default_settings'][$y]['default_setting_description'] = "Set the refresh rate in seconds (<=120) or milliseconds (>=500).";
		$y++;
		$apps[$x]['default_settings'][$y]['default_setting_uuid'] = "0c273cad-1ee4-48d9-9336-08bc8260579a";
		$apps[$x]['default_settings'][$y]['default_setting_category'] = "operator_panel";
		$apps[$x]['default_settings'][$y]['default_setting_subcategory'] = "group_extensions";
		$apps[$x]['default_settings'][$y]['default_setting_name'] = "boolean";
		$apps[$x]['default_settings'][$y]['default_setting_value'] = "true";
		$apps[$x]['default_settings'][$y]['default_setting_enabled'] = "true";
		$apps[$x]['default_settings'][$y]['default_setting_description'] = "Set if extensions are grouped by call_group when viewing all extensions.";
		$y++;
		$apps[$x]['default_settings'][$y]['default_setting_uuid'] = "a9ccd174-5ae1-4f90-8ee2-b79a183a04f8";
		$apps[$x]['default_settings'][$y]['default_setting_category'] = "theme";
		$apps[$x]['default_settings'][$y]['default_setting_subcategory'] = "operator_panel_main_background_color";
		$apps[$x]['default_settings'][$y]['default_setting_name'] = "text";
		$apps[$x]['default_settings'][$y]['default_setting_value'] = "#ffffff";
		$apps[$x]['default_settings'][$y]['default_setting_enabled'] = "true";
		$apps[$x]['default_settings'][$y]['default_setting_description'] = "Set main background color (and opacity) of extensions";
		$y++;
		$apps[$x]['default_settings'][$y]['default_setting_uuid'] = "b9d34460-db41-40d5-becd-5da037fa8942";
		$apps[$x]['default_settings'][$y]['default_setting_category'] = "theme";
		$apps[$x]['default_settings'][$y]['default_setting_subcategory'] = "operator_panel_sub_background_color";
		$apps[$x]['default_settings'][$y]['default_setting_name'] = "text";
		$apps[$x]['default_settings'][$y]['default_setting_value'] = "#e5eaf5";
		$apps[$x]['default_settings'][$y]['default_setting_enabled'] = "true";
		$apps[$x]['default_settings'][$y]['default_setting_description'] = "Set sub background color (and opacity) of extensions";
		$y++;
		$apps[$x]['default_settings'][$y]['default_setting_uuid'] = "9cb6477d-0454-4b9c-b0fb-11c258d4f35f";
		$apps[$x]['default_settings'][$y]['default_setting_category'] = "theme";
		$apps[$x]['default_settings'][$y]['default_setting_subcategory'] = "operator_panel_border_color";
		$apps[$x]['default_settings'][$y]['default_setting_name'] = "text";
		$apps[$x]['default_settings'][$y]['default_setting_value'] = "#b9c5d8";
		$apps[$x]['default_settings'][$y]['default_setting_enabled'] = "true";
		$apps[$x]['default_settings'][$y]['default_setting_description'] = "Set border color (and opacity) of extensions";
		$y++;

?>