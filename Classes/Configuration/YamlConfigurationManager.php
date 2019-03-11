<?php
namespace ChristianEssl\YamlBrowser\Configuration;

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

use Symfony\Component\Finder\Finder;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Form\Mvc\Configuration\ConfigurationManagerInterface;

/**
 * Get all the YAML configuration from different places in TYPO3
 */
class YamlConfigurationManager
{

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var YamlFileLoader
     */
    protected $loader;

    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->loader = GeneralUtility::makeInstance(YamlFileLoader::class);
    }

    public function getConfiguration() : array
    {
        return [
            'form' => $this->getFormConfiguration(),
            'site_configuration' => $this->getSiteConfiguration(),
            'rte' => $this->getRTEConfiguration()
        ];
    }

    /**
     * Load the YAML configuration for extension "form" from its specific ConfigurationManager to make
     * sure the structure, overrides, etc. are handled correctly
     *
     * @return array
     */
    protected function getFormConfiguration() : array
    {
        return $this->objectManager->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_YAML_SETTINGS, 'form');
    }

    /**
     * Load the YAML configuration for the "Sites" module
     *
     * @return array
     */
    protected function getSiteConfiguration() : array
    {
        if (version_compare(TYPO3_branch, '9.0', '>='))
        {
            return $this->getMatchingConfigurationInPath(
                Environment::getConfigPath() . '/sites',
                'config.yaml'
            );
        }
        else
        {
            $fileFinder = Finder::create();
            $fileFinder->files()->in(constant('PATH_typo3conf'))->name('*.yaml');

            $availableConfigurationFiles = [];

            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            foreach($fileFinder as $file)
            {
                $extensionName = substr(
                    $file->getPathname(),
                    strpos($file->getPathname(), DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR) + 5
                );
                $extensionName = substr(
                    $extensionName,
                    0,
                    strpos($extensionName, DIRECTORY_SEPARATOR)
                );

                if(ExtensionManagementUtility::isLoaded($extensionName))
                {
                    $availableConfigurationFiles[] = $file;
                }
            }

            return $availableConfigurationFiles;
        }
    }

    /**
     * Load the YAML configuration for ckeditor
     *
     * @return array
     */
    protected function getRTEConfiguration() : array
    {
        $configuration = [];
        foreach($GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets'] as $presetName => $presetPath) {
            $configuration[$presetName] = $this->loader->load($GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets'][$presetName]);
        }
        return $configuration;
    }

    /**
     * Search for YAML configuration files in the specified path, matching the fileName pattern
     *
     * @param string $path
     * @param string $fileName
     *
     * @return array
     */
    protected function getMatchingConfigurationInPath($path, $fileName) : array
    {
        $configuration = [];
        try {
            $finder = (new Finder())
                ->files()
                ->depth(0)
                ->name($fileName)
                ->in($path . '/*');
        } catch (\InvalidArgumentException $e) {
            return [];
        }

        foreach ($finder as $fileInfo) {
            /** @var \SplFileInfo $fileInfo */
            $fileName = GeneralUtility::fixWindowsFilePath((string)$fileInfo);
            $identifier = basename($fileInfo->getPath());
            $configuration[$identifier] = $this->getConfigurationFromFilename($fileName);
        }

        return $configuration;
    }

    /**
     * Get the YAML configuration for the files path
     *
     * @param string $fileName
     *
     * @return array
     */
    protected function getConfigurationFromFilename($fileName) : array
    {
        return $this->loader->load($fileName);
    }


}
