<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

if (TYPO3_MODE != 'BE') {
		/**
		 * Hooks tx_powermail_pi1
		 */
	$_hookConf =& $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['powermail'];
	$_hookFile = 'EXT:quickshop_stock/lib/class.tx_quickshopstock_hooks_powermail_pi1.php';
	$_hookCall = $_hookFile . ':tx_quickshopstock_hooks_powermail_pi1';


##	$_hookConf['PM_MarkerArrayHook'][]               = $_hookCall;  //   1  Real markerArray hook
##	$_hookConf['PM_FieldMarkerArrayHook'][]          = $_hookCall;  //   2  Adding or changing markers (for all views)
##	$_hookConf['PM_MainContentHookBefore'][]         = $_hookCall;  //   3  Hook for main manipulation1
##	$_hookConf['PM_MainContentHookAfter'][]          = $_hookCall;  //   4  Hook for main manipulation2
##	$_hookConf['PM_FormWrapMarkerHook'][]            = $_hookCall;  //   5  Hook for page with form
##	$_hookConf['PM_FormWrapMarkerHookInner'][]       = $_hookCall;  //   6  Hook for page with form for inner wrap
##	$_hookConf['PM_FieldHook']['FIELDNAME']          = $_hookCall;  //   7  Hook for adding new fields
##	$_hookConf['PM_FieldWrapMarkerHook'][]           = $_hookCall;  //   8  Hook after field generation
##	$_hookConf['PM_FieldWrapMarkerArrayHook'][]      = $_hookCall;  //   9  Hook for markerArray in field generation
##	$_hookConf['PM_FieldWrapMarkerArrayHookInner'][] = $_hookCall;  //  10  Hook for markerArray in field generation (inner markerArray for checkboxes, radiobuttons, and so on)
##	$_hookConf['PM_FieldWrapMarkerHook1'][]          = $_hookCall;  //  11  Hook for manipulation of default markers
##	$_hookConf['PM_ConfirmationHook'][]              = $_hookCall;  //  12  Hook for confirmation page
##	$_hookConf['PM_MandatoryHook'][]                 = $_hookCall;  //  13  Mandatory and error check hook
##	$_hookConf['PM_SubmitEmailHook'][]               = $_hookCall;  //  14  Hook for email change
##	$_hookConf['PM_SubmitBeforeMarkerHook'][]        = $_hookCall;  //  15  Submit hook before submit
	$_hookConf['PM_SubmitAfterMarkerHook'][]         = $_hookCall;  //  16  Submit hook after emails
##	$_hookConf['PM_SubmitLastOne'][]                 = $_hookCall;  //  17  Thx message hook
}
?>