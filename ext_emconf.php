<?php

########################################################################
# Extension Manager/Repository config file for ext "compat_besearch".
#
# Auto generated 14-10-2011 11:28
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Compatible Backend search',
	'description' => 'TYPO3 4.6 has changed Backend search to require explicit search configuration for each table. If the table lacks such configuration, it will not be searchable in the Backend. This extension makes extension tables searchable even if the extension does not provide search configuration. This extension meant only to provide compatibility with the previous behavior and give extension authors time to update their extensions. It is not a permanent solution. The extension will work only for certain amount of TYPO3 4.6.x versions and will not work for any newer or older TYPO3 version.',
	'category' => 'be',
	'author' => 'Dmitry Dulepov',
	'author_email' => 'dmitry.dulepov@gmail.com',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => 'TYPO3 Core team',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.6.0-4.6.999'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:4:{s:9:"ChangeLog";s:4:"ed20";s:12:"ext_icon.gif";s:4:"1bdc";s:19:"doc/wizard_form.dat";s:4:"d90e";s:20:"doc/wizard_form.html";s:4:"f15b";}',
);

?>