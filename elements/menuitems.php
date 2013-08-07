<?php defined('_JEXEC') or die;

/**
 * File       menuitems.php
 * Created    8/6/13 2:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/Menu-Branch-Module/issues
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

