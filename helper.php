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
		$this->active = $this->menu->getActive()->id;
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

			if (isset($item->children)) {
				$item->class .= ' parent';
			}
			if ($item->id == $this->active) {
				$item->class .= ' current';
			}
		}

		return $items;
	}

	/**
	 * Renders the menu
	 *
	 * @param $item: the menu item
	 * @param string $containerTag: optional, declare a different container HTML element
	 * @param string $containerClass: optional, declare a different container class
	 * @param string $itemTag: optional, declare a different menu item HTML element
	 * @return string
	 *
	 * @since 0.1
	 */

	public function render($item, $containerTag = '<ul>', $containerClass = 'menu', $itemTag = '<li>') {

		$itemOpenTag  = str_replace('>', ' class="' . $item->class . '">', $itemTag);
		$itemCloseTag = str_replace('<', '</', $itemTag);

		if ($item->type == 'separator') {
			$this->output = $itemOpenTag . '<span class="separator">' . $item->name . '</span>';
		} else {
			$this->output = $itemOpenTag . '<a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a>';
		}
		$this->output .= $this->recurse($item, $containerTag, $containerClass, $itemTag);
		$this->output .= $itemCloseTag;

		return $this->output;
	}

	/**
	 * Renders child items. Separated so that it can call itself recursively.
	 * TODO: Somehow feels like this could be much DRYer.
	 *
	 * @param $item
	 * @param $containerTag
	 * @param $containerClass
	 * @param $itemTag
	 * @return string
	 *
	 * @since 0.1
	 */

	private function recurse($item, $containerTag, $containerClass, $itemTag) {

		$child = NULL;

		$containerOpenTag  = str_replace('>', ' class="' . $containerClass . '">', $containerTag);
		$containerCloseTag = str_replace('<', '</', $containerTag);

		if (isset($item->children)) {
			$child .= $containerOpenTag;

			foreach ($item->children as $item) {

				$itemOpenTag  = str_replace('>', ' class="' . $item->class . '">', $itemTag);
				$itemCloseTag = str_replace('<', '</', $itemTag);

				if ($item->type == 'separator') {
					$child .= $itemOpenTag . '<span class="separator">' . $item->name . '</span>';
				} else {
					$child .= $itemOpenTag . '<a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a>';
				}
				$child .= $this->recurse($item, $containerTag, $containerClass, $itemTag);
			}
			$child .= $itemCloseTag;
			$child .= $containerCloseTag;
		} else {
			$child .= '';
		}

		return $child;
	}
}
