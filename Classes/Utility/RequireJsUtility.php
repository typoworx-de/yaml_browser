<?php
namespace ChristianEssl\YamlBrowser\Utility;

/***
 *
 * This file is part of the "YamlBrowser" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Christian Eßl <indy.essl@gmail.com>, https://christianessl.at
 *
 ***/

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Add all the needed libraries to requireJS
 */
class RequireJsUtility
{

    /**
     * Add all the needed libraries to requireJS
     */
    public static function addRequireJsConfiguration() : void
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addRequireJsConfiguration([
            'paths' => [
                'jquery.fancytree' => self::getJavaScriptLibraryPath('jquery.fancytree'),
                'jquery.fancytree.ui-deps' => self::getJavaScriptLibraryPath('jquery.fancytree.ui-deps'),
                'jquery.fancytree.filter' => self::getJavaScriptLibraryPath('jquery.fancytree.filter'),
            ]
        ]);
    }

    /**
     * @param string $libraryName
     *
     * @return string
     */
    protected static function getJavaScriptLibraryPath($libraryName) : string
    {
        return PathUtility::getAbsoluteWebPath(
            ExtensionManagementUtility::extPath(
                'yaml_browser',
                'Resources/Public/JavaScript/Contrib/'
            )
        ) . $libraryName;
    }

}