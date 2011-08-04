<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if (!empty ($extConf['stock_advanced'])) {
		//  alter field type for `in_stock` depending on ext_conf_template.txt
	t3lib_div::loadTCA('tx_quickshop_products');

	$TCA['tx_quickshop_products']['columns']['in_stock']['config'] = array(
		'type' => 'input',
		'size' => '30',
		'eval' => 'int',
	);
}

	//  field configuration
$tempColumns = array (
	'exclude_from_stock' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:quickshop_stock/locallang_db.xml:tx_quickshop_products.exclude_from_stock',
		'config' => array (
			'type' => 'check',
		),
	),
);
t3lib_extMgm::addTCAcolumns('tx_quickshop_products', $tempColumns, 1);
	//  replace field `in_stock` by --palette--
$TCA['tx_quickshop_products']['palettes']['stock'] = array(
	'canNotCollapse' => 1,
	'showitem'       => 'in_stock, exclude_from_stock',
);
$tempSearch  = '#,\s+in_stock(.*),#U';
$tempReplace = ', --palette--;LLL:EXT:' . $_EXTKEY . '/locallang_db.xml:tx_quickshop_products.palette_stock;stock;;1-1-1,';
$TCA['tx_quickshop_products']['types']['0']['showitem'] = preg_replace($tempSearch, $tempReplace, $TCA['tx_quickshop_products']['types']['0']['showitem']);


	//  Add CSH
t3lib_extMgm::addLLrefForTCAdescr('tx_quickshop_products', 'EXT:' . $_EXTKEY . '/locallang_csh.xml');


	//  Add static TypoScript
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/quickshop_stock/',         'Quick Shop Stock');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/quickshop_stock/browser/', '+Browser: Quick Shop Stock');
?>