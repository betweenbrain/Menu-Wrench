<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    8/6/13 2:34 PM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/Menu-Wrench/issues
 * Copyright  Copyright (C) 2013-2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */
?>
<ul class="menu<?php echo htmlspecialchars($params->get('moduleclass_sfx'))?>">
	<?php foreach ($items as $item) {
		echo $helper->render($item, '<ul>', 'menu', '<li>');
	}
	?>
</ul>
