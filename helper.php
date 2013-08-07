<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    8/6/13 3:41 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/Menu-Branch-Module/issues
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

class modMenubranchHelper {

	/**
	 * Nulls module output every time the helper is called
	 *
	 * @var null
	 * @since 0.1
	 *
	 */
	protected $output = NULL;

	/**
	 * Constructor
	 *
	 * @param JRegistry $params: module parameters
	 * @since 0.1
	 *
	 */
	public function __construct($params) {
		$this->app    = JFactory::getApplication();
		$this->menu   = $this->app->getMenu();
		$this->active = $this->menu->getActive();
		$this->params = $params;
	}

	/**
	 * Retrieves all menu items, sorts, combines, mixes, stirs, and purges what we want in a logical order
	 *
	 * @return mixed
	 * @since 0.1
	 *
	 */
	function getBranches() {
		$parentItems = $this->params->get('parentItems');
		$items       = $this->menu->_items;

		// Convert parentItems to an array if only one item is selected
		if (!is_array($parentItems)) {
			$parentItems = str_split($parentItems, strlen($parentItems));
		}

		// Build menu hierarchy
		foreach ($items as $item) {
			if ($item->parent != 0) {
				//
				end($item->tree);
				$previous = prev($item->tree);
				if ($previous != $item->id) {
					$items[$previous]->children[$item->id] = $item;
				}
			}
		}

		foreach ($items as $key => $item) {
			// Remove non-parent menu item objects
			if (!in_array($key, $parentItems)) {
				unset($items[$key]);
			}

			//Build object classes
			$item->class = 'item' . $item->id . ' ' . $item->alias;

			// Add parent class to all parents
			if (isset($item->children)) {
				$item->class .= ' parent';
			}

			// Add current class to specific item
			if ($item->id == $this->active->id) {
				$item->class .= ' current';
			}

			// Add active class to tree
			if (in_array($item->id, $this->active->tree)) {
				$item->class .= ' active';
			}
		}

		return $items;
	}

	/**
	 * Renders the menu
	 *
	 * @param $item                 : the menu item
	 * @param string $containerTag  : optional, declare a different container HTML element
	 * @param string $containerClass: optional, declare a different container class
	 * @param string $itemTag       : optional, declare a different menu item HTML element
	 * @return string
	 *
	 * @since 0.1
	 */

	public function render($item, $containerTag = '<ul>', $containerClass = 'menu', $itemTag = '<li>') {

		$itemOpenTag       = str_replace('>', ' class="' . $item->class . '">', $itemTag);
		$itemCloseTag      = str_replace('<', '</', $itemTag);
		$containerOpenTag  = str_replace('>', ' class="' . $containerClass . '">', $containerTag);
		$containerCloseTag = str_replace('<', '</', $containerTag);

		if ($item->type == 'separator') {
			$output = $itemOpenTag . '<span class="separator">' . $item->name . '</span>';
		} else {
			$output = $itemOpenTag . '<a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a>';
		}

		if (isset($item->children)) {

			$output .= $containerOpenTag;

			foreach ($item->children as $item) {

				$output .= $this->render($item, $containerTag, $containerClass, $itemTag);
			}
			$output .= $itemCloseTag;
			$output .= $containerCloseTag;
		}

		$output .= $itemCloseTag;

		return $output;
	}
}
