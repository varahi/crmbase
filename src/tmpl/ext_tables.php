<?php
if (! defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Tmpl',
            'Tmpl',
            'Tmpl Config Site template'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tmpl', 'Configuration/TypoScript', 'Tmpl Config Site templaten');

        /**
         * Page TS Config
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl/Configuration/TsConfig/page.tsconfig">');

        /**
         * Add some basic User TS Config
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:tmpl/Configuration/TsConfig/user.tsconfig">');

        /**
         * Add rte_ckeditor custom config
         */
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['custom'] = 'EXT:tmpl/Configuration/RTE/Custom.yaml';
    }
);
