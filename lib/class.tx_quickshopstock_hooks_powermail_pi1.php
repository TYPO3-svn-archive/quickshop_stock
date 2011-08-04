<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Ulfried Herrmann <herrmann@die-netzmacher.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   47: class tx_quickshopstock_hooks_powermail_pi1
 *   65:     public function PM_SubmitAfterMarkerHook(&$pObj, &$markerArray, &$sessiondata)
 *  163:     protected function setConfig(&$pObj)
 *  187:     protected function clearCache_pages()
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

/**
 * Hooks for use in tx_powermail_pi1
 *
 * @author	Ulfried Herrmann <herrmann@die-netzmacher.de>
 * @package	TYPO3
 * @subpackage	tx_quickshopstock
 */
class tx_quickshopstock_hooks_powermail_pi1 {
	public $prefixId = 'tx_quickshopstock_hooks_powermail_pi1';  // Same as class name
	public $extKey   = 'quickshop_stock';                        // The extension key.
	protected $conf  = array();                                  // The relevant part of plugin configuration


	// -------------------------------------------------------------------------
	/**
	 * Submit hook after emails
	 * If you want to do something after a correct submit, you can use this hook (maybe an additional db entry)
	 *
	 * @param   &object  $pObj:     parent plugin object
	 * @param   &array   $params:   parent plugins marker array
	 * @param   &array   $params:   parent plugins session data
	 * @return  void
	 * @access  public
	 * @since   version 0.1.0
	 */
	public function PM_SubmitAfterMarkerHook(&$pObj, &$markerArray, &$sessiondata) {
			//  set configuration
		$this->setConfig($pObj);

			//  abort if stock control is disabled
			if (empty ($this->conf['enable'])) {
					//  log
				if ($this->conf['devlog'] <= 2) {
					t3lib_div::devLog('WARNING: Stock control is disabled. Abort. (Change this? Set TypoScript constant `enable` to TRUE.)', $this->extKey, 2);
				}

				return;
			}
			//  get ordered products from wt_cart session
		$sesArray = $GLOBALS['TSFE']->fe_user->getKey('ses', 'wt_cart_cart'); // get already exting products from session
		unset($sesArray['shipping'], $sesArray['payment']);
			//  check session array
		if (!is_array($sesArray) OR count($sesArray) < 1) {
				//  log
			if ($this->conf['devlog'] <= 2) {
				t3lib_div::devLog('WARNING: no ordered products detected! Abort.', $this->extKey, 2);
			}

			return;
		}

			//  extract ordered products uid and quantity
		$oProducts = array();
		foreach ($sesArray as $sesVal) {
			$oProducts[] = array(
				'uid' => (int)$sesVal['puid'],
				'qty' => (int)$sesVal['qty'],
			);
		}
			//  log
		if ($this->conf['devlog'] <= -1) {
			t3lib_div::devLog('DEBUG: get ordered products', $this->extKey, -1, array(
				'Session array'    => $sesArray,
				'ordered products' => $oProducts,
			));
		}


		$num = 0;
		foreach ($oProducts as $opVal) {
			/**
			 * build stock update query
			 */
			$table           = 'tx_quickshop_products';
				//  affect only entry with given uid and not excluded
			$where           = 'uid = ' . $opVal['uid'] . ' AND exclude_from_stock = 0';
			$fields_values   = array(
					//  extConf stock_advanced is empty: set to 0 (otherwise deduct number of ordered products)
				'in_stock' => (empty ($this->conf['stock_advanced'])) ? 0 : '(in_stock - ' . $opVal['qty'] . ')'
			);
			$no_quote_fields = array(
					//  prevent quoting to allow math calculation in field value
				'in_stock',
			);
				//  log stock update query
			if ($this->conf['devlog'] <= -1) {
				$sql = $GLOBALS['TYPO3_DB']->UPDATEquery($table, $where, $fields_values, $no_quote_fields);
					//  log
				t3lib_div::devLog('DEBUG: SQL stock update query: ' . $sql, $this->extKey, -1);
			}

			/**
			 * execute stock update query
			 */
			$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields);
			
			/**
			 * check result
			 */
			$err = $GLOBALS['TYPO3_DB']->sql_error();
			if (!empty ($err)) {
				if ($this->conf['devlog'] <= 2) {
						//  log
					t3lib_div::devLog('ERROR: SQL error in stock update query! Abort. (' . $err . ')', $this->extKey, 3);
				}
			}
			$num += $GLOBALS['TYPO3_DB']->sql_affected_rows();
		}

			//  log result
		if ($this->conf['devlog'] <= 0) {
			t3lib_div::devLog('INFO: update result', $this->extKey, 0, array(
				'products to update' => count($oProducts),
				'products updated'   => $num,
			));
		}

		/**
		 * clear cache
		 */
		$this->clearCache_pages();
	}


	// -------------------------------------------------------------------------
	/**
	 * Set configuration values
	 *
	 * @return  obj  this
	 * @access  protected
	 * @since   version 0.1.0
	 */
	protected function setConfig(&$pObj) {
		$this->conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_quickshopstock.'];

		$extConf           = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
		$extConf['devlog'] = str_replace('off', 999, $extConf['devlog']);  //  high value disables logging
		$this->conf        = array_merge($this->conf, $extConf);
			//  log
		if ($this->conf['devlog'] <= -1) {
			t3lib_div::devLog('DEBUG: config', $this->extKey, -1, $this->conf);
		}

		$this->pObj =& $pObj;

		return $this;
	}


	// -------------------------------------------------------------------------
	/** Clear cache for configured pages
	 *
	 * @return  obj  this
	 * @access  protected
	 * @since   version 0.1.0
	 */
	protected function clearCache_pages() {
		$clearCache_pages     = $GLOBALS['TYPO3_DB']->cleanIntList($this->conf['clearCache_pages']);
		$clearCache_recursive = (int)$this->conf['clearCache_recursive'];
		$pidList              = $this->pObj->pi_getPidList($clearCache_pages, $clearCache_recursive);

		if (empty ($pidList)) {
				//  log
			if ($this->conf['devlog'] <= 0) {
				t3lib_div::devlog('INFO: clear cache for page(s) skipped: no page(s) configured. [Use plugin.tx_quickshopstock.clearCache_pages]', $this->extKey, 1);
			}
		} else {
				//  log
			if ($this->conf['devlog'] <= 0) {
				t3lib_div::devlog('INFO: clear cache for page(s) \'' . $pidList . '\'', $this->extKey, 0);
			}
			$GLOBALS['TSFE']->clearPageCacheContent_pidList($pidList);
		}

		return $this;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_stock/lib/class.tx_quickshopstock_hooks_powermail_pi1.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/quickshop_stock/lib/class.tx_quickshopstock_hooks_powermail_pi1.php']);
}
?>