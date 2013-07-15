<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    7/15/13 2:34 PM 
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

foreach ($items as $item) {
	echo '<li class="item' . $item->id . ' ' . $item->alias . '"><a href="' . JURI::root(TRUE) . '/' . $item->route . '"/>' . $item->name . '</a></li>';
}