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

define(["jquery", "jquery.fancytree", "jquery.fancytree.filter"], function($, fancytree) {
    "use strict";

    var YamlBrowser = {

    };
    var self = YamlBrowser;

    YamlBrowser.init = function() {
        console.log('INIT');
        console.log(fancytree);
    };

    return YamlBrowser;
});