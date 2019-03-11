<?php /** @noinspection PhpUndefinedVariableInspection */

defined('TYPO3_MODE') || die('Access denied.');

if (TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_BE) {
    \ChristianEssl\YamlBrowser\Utility\RequireJsUtility::addRequireJsConfiguration();
}

if (version_compare(TYPO3_branch, '9.5', '<')) {
    $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('yaml_browser');

    /** @var \Composer\Autoload\ClassLoader $composerClassLoader */
    $composerClassLoader = \TYPO3\CMS\Core\Core\Bootstrap::getInstance()->getEarlyInstance(\Composer\Autoload\ClassLoader::class);

    // Inject \TYPO3\CMS\Core\Environment into our TYPO3 8.x Core
    $composerClassLoader->addPsr4('TYPO3\\CMS\\Core\\Http\\', $extPath . 'Classes/Compatibility/TYPO3/CMS/Core/Http');

    $composerClassLoader->setUseIncludePath(true);
    $composerClassLoader->register();

    // Re-Inject our altered ClassLoader back into Core-Bootstrap
    \TYPO3\CMS\Core\Core\Bootstrap::getInstance()->setEarlyInstance(\Composer\Autoload\ClassLoader::class, $composerClassLoader);
}
