<?php
defined('_SECURE_') or die('Forbidden');

// insert to left menu array
$menutab = $core_config['menutab']['features'];
$menu_config[$menutab][] = array("index.php?app=main&inc=feature_sms_subscribe&op=sms_subscribe_list", _('Manage subscribe'));

$subscribe_icon_add_message = "<img src=\"".$core_config['http_path']['themes']."/".core_themes_get()."/images/edit_action.gif\" alt=\""._('Add message')."\" title=\""._('Add message')."\" border=0>";
$subscribe_icon_view_members = "<img src=\"".$core_config['http_path']['themes']."/".core_themes_get()."/images/view_action.gif\" alt=\""._('View members')."\" title=\""._('View members')."\" border=0>";
$subscribe_icon_view_messages = "<img src=\"".$core_config['http_path']['themes']."/".core_themes_get()."/images/view_action.gif\" alt=\""._('View messages')."\" title=\""._('View messages')."\" border=0>";
