<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    8/6/13 3:41 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

class modMenubranchHelper {

	public function __construct($params) {
		$this->app    = JFactory::getApplication();
		$this->menu   = $this->app->getMenu();
		$this->active = $this->menu->getActive()->id;
		$this->params = $params;
	}

	function getBranches() {
		$parentItems = $this->params->get('parentItems');
		$items       = $this->menu->_items;

		// Convert parentItems to an array if only one item is selected
		if (!is_array($parentItems)) {
			$parentItems = str_split($parentItems, strlen($parentItems));
		}

		foreach ($items as $item) {
			if ($item->parent != 0) {
				end($item->tree);
				$previous = prev($item->tree);
				if ($previous != $item->id) {
					$items[$previous]->children[$item->id] = $item;
				}
			}
		}

		foreach ($items as $key => $item) {
			if (!in_array($key, $parentItems)) {
				unset($items[$key]);
			}
		}

		return $items;
	}

	function recurse($item) {
		$output = NULL;

		if (isset($item->children)) {
			$output .= '<ul class="menu">';

			foreach ($item->children as $item) {
				$parent  = isset($item->children) ? ' parent' : '';
				$current = ($item->id === $this->active) ? ' current' : '';
				$class   = 'item' . $item->id . ' ' . $item->alias . $parent . $current;
				$output .= '<li class="' . $class . '"><a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a>';
				$output .= $this->recurse($item);
			}

			$output .= '</ul>';
		} else {
			$output .= '';
		}

		return $output;
	}
}