<?php
defined('TYPO3_MODE') || die();

(static function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Infobaza',
        'Infobaza',
        [
            \T3Dev\Infobaza\Controller\ChapterController::class => 'index, logout, ',
            \T3Dev\Infobaza\Controller\ContainController::class => 'list',
            \T3Dev\Infobaza\Controller\SubcontainController::class => 'list'
        ],
        // non-cacheable actions
        [
            \T3Dev\Infobaza\Controller\ChapterController::class => 'index, logout, ',
            \T3Dev\Infobaza\Controller\ContainController::class => '',
            \T3Dev\Infobaza\Controller\SubcontainController::class => ''
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    infobaza {
                        iconIdentifier = infobaza-plugin-infobaza
                        title = LLL:EXT:infobaza/Resources/Private/Language/locallang_db.xlf:tx_infobaza_infobaza.name
                        description = LLL:EXT:infobaza/Resources/Private/Language/locallang_db.xlf:tx_infobaza_infobaza.description
                        tt_content_defValues {
                            CType = list
                            list_type = infobaza_infobaza
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'infobaza-plugin-infobaza',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:infobaza/Resources/Public/Icons/user_plugin_infobaza.svg']
    );
})();
