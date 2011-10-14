<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Dmitry Dulepov (dmitry.dulepov@gmail.com)
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * This class implements a hook to the list module to build a search field list
 * for the extension tables in TYPO3 4.6. Hook parameters are defined in the
 * list module and at the time of the writing were:
 *	- tableHasSearchConfiguration: boolean
 *	- tableName: string
 *	- searchFields: array (column names for the table, one per entry)
 *	- searchString: string
 * This class is singleton to avoid instantiating it many times in the list
 * module.
 *
 * @author Dmitry Dulepov >dmitry.dulepov@typo3.org>
 * @package TYPO3
 * @subpackage tx_compatbesearch
 */
class tx_compatbesearch_listmodulehook implements t3lib_Singleton {

	/** @var array */
	protected $hookParameters;

	/**
	 * Hook's entry point.
	 *
	 * @param array $hookParameters
	 * @return void
	 */
	public function updateSearchFieldList(array &$hookParameters) {
		$this->hookParameters = $hookParameters;
		if ($this->isExtensionTable() && $this->shouldBuildFieldList()) {
			$this->buildFieldListForExtensionTable();
		}
	}

	/**
	 * Creates a list of searchable fields for the extension table.
	 *
	 * @return void
	 */
	protected function buildFieldListForExtensionTable() {
		$fieldList = array();
		$tableName = $this->hookParameters['tableName'];
		t3lib_div::loadTCA($tableName);

		if (!$GLOBALS['TCA'][$tableName]['ctrl']['hideTable']) {
			$isIntQuery = t3lib_utility_Math::canBeInterpretedAsInteger($this->hookParameters['searchString']);

			foreach ($GLOBALS['TCA'][$tableName]['columns'] as $columnName => $columnConfig) {
				$addColumn = FALSE;
				$columnType = $columnConfig['config']['type'];
				if ($columnType == 'text' && !$isIntQuery) {
					$addColumn = TRUE;
				}
				elseif ($columnType == 'input') {
					if (isset($columnConfig['config']['eval'])) {
						$evalInt = t3lib_div::inList($columnConfig['config']['eval'], 'int');
						$evalPassword = t3lib_div::inList($columnConfig['config']['eval'], 'password');
						$evalTime = preg_match('/date|time/', $columnConfig['config']['eval']);
					}
					else {
						$evalInt = $evalPassword = $evalTime = FALSE;
					}
					if ($isIntQuery) {
						if ($evalInt) {
							$addColumn = TRUE;
						}
					}
					elseif (!$evalInt && !$evalPassword && !$evalTime) {
						$addColumn = TRUE;
					}
				}
				if ($addColumn) {
					$fieldList[] = $columnName;
				}
			}
		}

		$this->hookParameters['searchFields'] = $fieldList;
	}

	/**
	 * Checks if the table belongs to the extension.
	 *
	 * @return bool
	 */
	protected function isExtensionTable() {
		$tableName = $this->hookParameters['tableName'];
		return (strncasecmp($tableName, 'tx_', 3) == 0 || strncmp($tableName, 'tt_', 3) == 0);
	}

	/**
	 * Checks if field list should be built for the table.
	 *
	 * @return bool
	 */
	protected function shouldBuildFieldList() {
		return !$this->hookParameters['tableHasSearchConfiguration'] && (count($this->hookParameters['searchFields']) == 0);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3conf/ext/compat_besearch/class.tx_compatbesearch_listmodulehook.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3conf/ext/compat_besearch/class.tx_compatbesearch_listmodulehook.php']);
}
