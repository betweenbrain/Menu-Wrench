<?php defined('_JEXEC') or die;

/**
 * File       mod_menubranch.php
 * Created    8/6/13 2:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/Menu-Branch-Module/issues
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

require_once __DIR__ . '/helper.php';

$helper = new modMenubranchHelper($params);
$items  = $helper->getBranches();

require(JModuleHelper::getLayoutPath('mod_menubranch'));