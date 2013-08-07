<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    7/15/13 2:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */
?>
<ul class="menu">
	<?php foreach ($items as $item) {
		$parent  = isset($item->children) ? ' parent' : '';
		$current = ($item->id == $active) ? ' current' : '';
		$class   = 'item' . $item->id . ' ' . $item->alias . $parent . $current;
		echo '<li class="' . $class . '"><a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a>';
		echo $helper->recurse($item);
		echo '</li>';
	}
	?>
</ul>
