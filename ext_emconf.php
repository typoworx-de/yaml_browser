<?php /** @noinspection PhpUndefinedVariableInspection */

/***************************************************************
 * Extension Manager/Repository config file for ext: "yaml_browser"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'YAML Browser',
    'description' => 'Browse and debug YAML definitions in TYPO3 in a similar way to the "TypoScript Object Browser". This patched release provides TYPO3 8.x support (added by info@typoworx.com <Gabriel Kaufmann>).',
    'category' => 'misc',
    'author' => 'Gabriel Kaufmann, Christian Eßl',
    'author_email' => 'info@typoworx.com, indy.essl@gmail.com',
    'state' => 'beta',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0~0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
