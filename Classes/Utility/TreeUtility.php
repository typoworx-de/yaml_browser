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

/**
 * Get the JSON tree output required for fancytree
 */
class TreeUtility
{

    /**
     * @param array $array
     *
     * @return string
     */
    public static function getJSON($array) : string
    {
        $array = self::buildTree($array);

        return json_encode(
            $array,
            JSON_HEX_TAG || JSON_HEX_AMP || JSON_HEX_APOS || JSON_HEX_QUOT
        );
    }

    /**
     * @param array $array
     * @param string $parentIndex
     *
     * @return array
     */
    protected static function buildTree($array, $parentIndex = '') : array
    {
        $output = [];
        $i = 1;
        foreach($array as $key => $value) {
            $index = $parentIndex.$i;

            if (is_array($value)) {
                $output[] = [
                    'key' => $index,
                    'title' => '[' . $key . ']',
                    'children' => self::buildTree($value, $index.'_')
                ];
            } else {
                $value = self::sanitizeValue((string)$value);
                $output[] = [
                    'key' => $index,
                    'title' => '[' . $key . ']' . ' = <strong>' . $value . '</strong>'
                ];
            }

            $i++;
        }
        return $output;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected static function sanitizeValue($value) : string
    {
        if (strpos($value, "\\") !== false) {
            $value = str_replace("\\", '&bsol;', $value);
        }
        if (strpos($value, '"') !== false) {
            $value = str_replace('"', '&quot;', $value);
        }
        return $value;
    }
}