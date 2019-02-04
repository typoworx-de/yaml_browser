<?php /** @noinspection PhpUndefinedVariableInspection */

defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
    'tools',
    'yamlbrowser',
    '',
    '',
    [
        'routeTarget' => \ChristianEssl\YamlBrowser\Controller\YamlBrowserController::class . '::mainAction',
        'access' => 'admin',
        'name' => 'tools_yamlbrowser',
        'icon' => 'EXT:yaml_browser/Resources/Public/Icons/module-icon.png',
        'labels' => 'LLL:EXT:yaml_browser/Resources/Private/Language/locallang.xlf'
    ]
);