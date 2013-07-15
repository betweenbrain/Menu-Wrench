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
		echo '<li class="item' . $item->id . ' ' . $item->alias . '"><a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a></li>';
	}
	?>
</ul>