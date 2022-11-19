<?php
defined('TYPO3_MODE') || die();

(static function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_infobaza_domain_model_chapter', 'EXT:infobaza/Resources/Private/Language/locallang_csh_tx_infobaza_domain_model_chapter.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_infobaza_domain_model_chapter');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_infobaza_domain_model_contain', 'EXT:infobaza/Resources/Private/Language/locallang_csh_tx_infobaza_domain_model_contain.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_infobaza_domain_model_contain');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_infobaza_domain_model_subcontain', 'EXT:infobaza/Resources/Private/Language/locallang_csh_tx_infobaza_domain_model_subcontain.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_infobaza_domain_model_subcontain');
})();
