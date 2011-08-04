<?php

########################################################################
# Extension Manager/Repository config file for ext "quickshop_stock".
#
# Auto generated 04-08-2011 21:07
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Quick Shop Stock',
	'description' => 'Advanced handling of Quick Shop products stock, using a powermail hook. After order the number of products in stock will be reduced by the number of ordered products.',
	'category' => 'plugin',
	'author' => 'Ulfried Herrmann (Die Netzmacher)',
	'author_email' => 'http://herrmann.at.die-netzmacher.de/',
	'shy' => '',
	'dependencies' => 'quick_shop,powermail',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'quick_shop' => '',
			'powermail' => '1.6.3-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:15:{s:9:"ChangeLog";s:4:"0d3a";s:21:"ext_conf_template.txt";s:4:"ef5a";s:12:"ext_icon.gif";s:4:"2501";s:17:"ext_localconf.php";s:4:"c5bd";s:14:"ext_tables.php";s:4:"c26f";s:14:"ext_tables.sql";s:4:"606f";s:17:"locallang_csh.xml";s:4:"92c5";s:16:"locallang_db.xml";s:4:"93c2";s:14:"doc/manual.pdf";s:4:"8d5f";s:14:"doc/manual.sxw";s:4:"c9c7";s:51:"lib/class.tx_quickshopstock_hooks_powermail_pi1.php";s:4:"44b3";s:36:"static/quickshop_stock/constants.txt";s:4:"9fee";s:32:"static/quickshop_stock/setup.txt";s:4:"4b59";s:44:"static/quickshop_stock/browser/constants.txt";s:4:"d41d";s:40:"static/quickshop_stock/browser/setup.txt";s:4:"58ff";}',
	'suggests' => array(
	),
);

?>