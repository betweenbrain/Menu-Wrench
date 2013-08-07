<?php defined('_JEXEC') or die;

/**
 * File       menuitems.php
 * Created    6/12/13 11:37 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

class JElementMenuitems extends JElement {

	var $name = 'Menuitems';

	function fetchElement($name, $value, &$node, $control_name) {
		$site = str_replace('/administrator', '', JPATH_BASE);
		JLoader::register('JHTMLMenu', $site . '/libraries/joomla/html/html/menu.php', TRUE);
		$items   = JHTMLMenu::linkoptions();
		$attribs = 'multiple="true" size="12"';

		return JHTML::_('select.genericlist', $items, $control_name . '[' . $name . '][]', $attribs, 'value', 'text', $value, $control_name . $name);
	}
}

