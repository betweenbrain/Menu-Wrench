<?php defined('_JEXEC') or die;

/**
 * File       mod_menubranch.php
 * Created    7/15/13 2:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

$app    = JFactory::getApplication();
$menu   = $app->getMenu();
$items  = $menu->_items;
$parent = $params->get('parentItem');

foreach ($items as $key => $item) {
	if ($item->parent != $parent && $key != $parent) {
		unset($items[$key]);
	}
}

require(JModuleHelper::getLayoutPath('mod_menubranch'));