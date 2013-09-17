<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    8/6/13 3:41 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/Menu-Wrench/issues
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

class modMenuwrenchHelper {

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
		$hiddenItems   = $this->params->get('hiddenItems', 0);
		$hideSubmenu   = $this->params->get('hideSubmenu', 0);
		$items         = $this->menu->_items;
		$renderedItems = $this->params->get('renderedItems');
		$showSubmenu   = $this->params->get('showSubmenu', 1);

		if (!is_array($hiddenItems)) {
			$hiddenItems = str_split($hiddenItems, strlen($hiddenItems));
		}

		if (!is_array($hideSubmenu)) {
			$hideSubmenu = str_split($hideSubmenu, strlen($hideSubmenu));
		}

		// Convert renderedItems to an array if only one item is selected
		if (!is_array($renderedItems)) {
			$renderedItems = str_split($renderedItems, strlen($renderedItems));
		}

		//die('<pre>' . print_r($hiddenItems, true) . '</pre>');

		/**
		 * Builds menu hierarchy by nesting children in parent object's 'children' property
		 */
		foreach ($items as $item) {
			if ($item->parent != 0) {
				// Reset array counter to last tree item, which is self
				end($item->tree);
				// Set $previous to next to last tree item value
				$previous = prev($item->tree);
				// If $previous is not self, it's a parent
				if ($previous != $item->id) {
					$items[$previous]->children[$item->id] = $item;
				}
			}
		}

		foreach ($items as $key => $item) {

			// Remove non-selected menu item objects
			if (!in_array($key, $renderedItems)) {
				unset($items[$key]);
			}

			// Hide selected items, promote children up one level
			if (in_array($item->id, $hiddenItems)) {

				if (isset($item->children)) {
					foreach ($item->children as $child) {
						$items[$item->parent]->children[$child->id] = $child;
					}
				}

				$this->recursiveUnset($item->id, $items);
			}

			/**
			 * Builds object classes
			 */
			$item->class = 'item' . $item->id . ' ' . $item->alias;

			// Add parent class to all parents
			if (isset($item->children) && !in_array($item->id, $hideSubmenu)) {
				$item->class .= ' parent';
			}

			// Add current class to specific item
			if ($item->id == $this->active->id) {
				$item->class .= ' current';
			}

			// Add active class to all items in active branch
			if (in_array($item->id, $this->active->tree)) {
				$item->class .= ' active';
			}

			// Hide sub-menu items if parameter set to no and parent not active
			if ((!in_array($item->id, $this->active->tree) && $showSubmenu == 0) || in_array($item->id, $hideSubmenu)) {
				unset($item->children);
			}
		}

		$this->countChildren($items);

		return $items;
	}

	/**
	 * Recursively count children for later splitting
	 *
	 * @param $items
	 * @return mixed
	 */

	private function recursiveUnset($key, $items) {
		foreach ($items as $item) {
			if (isset($item->children)) {
				if (isset($item->children[$key])) {
					unset($item->children[$key]);
				}
				$this->recursiveUnset($key, $item->children);
			}
		}
	}

	/**
	 * Recursively count children for later splitting
	 *
	 * @param $items
	 * @return mixed
	 */

	private function countChildren($items) {

		foreach ($items as $item) {
			if (isset($item->children)) {
				$item->childrentotal = count($item->children);
				foreach ($item->children as $item) {
					if (isset($item->children)) {
						$item->childrentotal = count($item->children);
						$this->countChildren($item);
					}
				}
			} else {
				return $items;
			}
		}
	}

	/**
	 * Renders the menu
	 *
	 * @param $item                        : the menu item
	 * @param string $containerTag         : optional, declare a different container HTML element
	 * @param string $containerClass       : optional, declare a different container class
	 * @param string $itemTag              : optional, declare a different menu item HTML element
	 * @param int $currentDepth            : counter for level of depth that is rendering.
	 * @return string
	 *
	 * @since 0.1
	 */

	public function render($item, $containerTag = '<ul>', $containerClass = 'menu', $itemTag = '<li>', $currentDepth = 0) {

		$containerCloseTag = str_replace('<', '</', $containerTag);
		$containerOpenTag  = str_replace('>', ' class="' . $containerClass . '">', $containerTag);
		$itemCloseTag      = str_replace('<', '</', $itemTag);
		$itemOpenTag       = str_replace('>', ' class="' . $item->class . '">', $itemTag);

		$alphaSortSubmenu = $this->params->get('alphaSortSubmenu', NULL);
		$renderDepth      = $this->params->get('renderDepth', 10);
		$splitMinimum     = $this->params->get('splitMinimum', 10);
		$submenuSplit     = $this->params->get('submenuSplit', 0);

		if ($item->type == 'separator') {
			$output = $itemOpenTag . '<span class="separator">' . $item->name . '</span>';
		} else {
			$output = $itemOpenTag . '<a href="' . JRoute::_($item->link . '&Itemid=' . $item->id) . '"/>' . $item->name . '</a>';
		}

		$currentDepth++;

		if (isset($item->children) && $currentDepth <= $renderDepth) {

			if ($alphaSortSubmenu) {
				usort($item->children, function ($a, $b) {
					return strcmp(strtolower($a->name), strtolower($b->name));
				});
			}

			$output .= $containerOpenTag;

			if (isset($item->childrentotal) && $item->childrentotal >= $splitMinimum && $submenuSplit > 0) {
				// Set split flag
				$splitSubmenus = TRUE;
				// Split markup
				$output .= $containerTag;
				// Calculate divisor based on this item's total children and parameter
				$divisor = ceil($item->childrentotal / $submenuSplit);
			}

			// Zero counter for calculating column split
			$index = 0;

			foreach ($item->children as $item) {

				if ($splitSubmenus && $index > 0 && fmod($index, $divisor) == 0) {
					$output .= $containerCloseTag . $containerTag;
				}

				$output .= $this->render($item, $containerTag, $containerClass, $itemTag, $currentDepth);

				// Increment, rinse, repeat.
				$index++;
			}
			$output .= $itemCloseTag;

			if ($splitSubmenus) {
				$output .= $containerCloseTag;
			}

			$output .= $containerCloseTag;
		}

		$output .= $itemCloseTag;

		return $output;
	}
}
