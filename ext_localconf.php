<?php /** @noinspection PhpUndefinedVariableInspection */

defined('TYPO3_MODE') || die('Access denied.');

if (TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_BE) {
    \ChristianEssl\YamlBrowser\Utility\RequireJsUtility::addRequireJsConfiguration();
}