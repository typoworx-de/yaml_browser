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
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Base Controller for the YAML browser in the Template module
 */
class YamlBrowserController
{
    /**
     * ModuleTemplate Container
     *
     * @var ModuleTemplate
     */
    protected $moduleTemplate;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var YamlConfigurationManager
     */
    protected $yamlConfigurationmanager;

    /**
     * @var string
     */
    protected $templatePathAndFilename = 'EXT:yaml_browser/Resources/Private/Templates/YamlBrowser/Main.html';

    public function __construct()
    {
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->yamlConfigurationmanager = GeneralUtility::makeInstance(YamlConfigurationManager::class);
    }

    /**
     * @param ServerRequestInterface $request the current request
     *
     * @return ResponseInterface the response with the content
     */
    public function mainAction(ServerRequestInterface $request): ResponseInterface
    {
        $this->loadJavaScript();
        $configuration = $this->yamlConfigurationmanager->getConfiguration();

        return $this->renderResponse([
            'configuration' => $configuration
        ]);
    }

    /**
     * @param array $variables
     *
     * @return HtmlResponse
     */
    protected function renderResponse($variables = []) : HtmlResponse
    {
        $mainView = $this->objectManager->get(StandaloneView::class);
        $mainView->setTemplatePathAndFilename($this->templatePathAndFilename);
        $mainView->assignMultiple($variables);

        $content = $mainView->render();
        $this->moduleTemplate->setContent($content);

        return new HtmlResponse($this->moduleTemplate->renderContent());
    }

    /**
     * @return void
     */
    protected static function loadJavaScript()
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/YamlBrowser/YamlBrowser', 'function(YamlBrowser) {
			YamlBrowser.init();
		}');
    }
}