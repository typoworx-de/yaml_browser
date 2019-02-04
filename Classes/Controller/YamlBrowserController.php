<?php
namespace ChristianEssl\YamlBrowser\Controller;

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

use ChristianEssl\YamlBrowser\Configuration\YamlConfigurationManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Base Controller for the YAML browser in the Template module
 */
class YamlBrowserController
{
    /**
     * @var YamlConfigurationManager
     */
    protected $yamlConfigurationmanager;

    public function __construct()
    {
        $this->yamlConfigurationmanager = GeneralUtility::makeInstance(YamlConfigurationManager::class);
    }

    /**
     * @param ServerRequestInterface $request the current request
     *
     * @return ResponseInterface the response with the content
     */
    public function mainAction(ServerRequestInterface $request): ResponseInterface
    {

        $configuration = $this->yamlConfigurationmanager->getConfiguration();
        DebuggerUtility::var_dump($configuration);
        return new HtmlResponse('DUMMY RESPONSE');
    }
}