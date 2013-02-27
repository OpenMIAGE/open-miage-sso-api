<?php

Import::php("util.wrapper.RegExp");

/**
 * Description of OpenM_SSOAdmin_Tool
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api
 * @copyright (c) 2013, www.open-miage.org
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * @link http://www.open-miage.org
 * @author Gaël Saunier
 */
class OpenM_SSOAdmin_Tool {

    public static function apiAndMethodToRegExp($api = null, $method = null) {
        if ($api == null)
            $api = "*";
        if ($method == null)
            $method = "*";
        if (!self::isValidMethodOrAPI($api))
            throw new InvalidArgumentException("API not in a valid format");
        if (!self::isValidMethodOrAPI($method))
            throw new InvalidArgumentException("method not in a valid format");

        return self::convertToRights($api) . "::" . self::convertToRights($method);
    }

    public static function isValid($api, $method, $rights) {
        if (!self::isValidMethodOrAPI($api))
            throw new InvalidArgumentException("API not in a valid format");
        if (!self::isValidMethodOrAPI($method))
            throw new InvalidArgumentException("method not in a valid format");
        if (!self::isValidRights($rights))
            throw new InvalidArgumentException("rights not in a valid format");

        $preg = "/^" . self::convertToRights($rights) . "$/";
        $string = self::apiAndMethodToRegExp($api, $method);
        OpenM_Log::debug("preg($preg, $string)", __CLASS__, __METHOD__, __LINE__);
        return RegExp::preg($preg, $string);
    }

    private static function convertToRights($string) {
        return str_replace("*", ".*", $string);
    }

    public static function isValidRights($rights) {
        if (!String::isString($rights))
            throw new InvalidArgumentException("rights must be a string");

        return RegExp::ereg("^([0-9a-zA-Z]|_|\*)+::([0-9a-zA-Z]|_|\*)+$", $rights);
    }

    public static function isValidMethodOrAPI($methodOrAPI) {
        if (!String::isString($methodOrAPI))
            throw new InvalidArgumentException("methodOrAPI must be a string");

        return RegExp::ereg("^([0-9a-zA-Z]|_)+$", $methodOrAPI);
    }

}

?>
