<?php

if (defined('TYPO3_MODE') && TYPO3_MODE == 'BE' && version_compare(TYPO3_version, '4.7.0', '<')) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['mod_list']['getSearchFieldList'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/class.tx_compatbesearch_listmodulehook.php:tx_compatbesearch_listmodulehook->updateSearchFieldList';
}

?>