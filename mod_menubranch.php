<?php defined('_JEXEC') or die;

/**
 * File       mod_menubranch.php
 * Created    7/15/13 2:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

// Include the helper.
require_once __DIR__ . '/helper.php';

$app    = JFactory::getApplication();
$menu   = $app->getMenu();
$active = $menu->getActive()->id;

$helper = new modMenubranchHelper($params);
$items  = $helper->getBranches();

require(JModuleHelper::getLayoutPath('mod_menubranch'));