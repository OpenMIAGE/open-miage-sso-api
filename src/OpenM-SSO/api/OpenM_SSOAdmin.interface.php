<?php

Import::php("OpenM-Services.api.OpenM_Service");

/**
 * Administrator Interface to manage client validation and their access rights
 * on diferents api provided.
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
interface OpenM_SSOAdmin extends OpenM_Service {

    const RETURN_CLIENT_RIGHTS_LIST_PARAMETER = "CLIENT_RIGHTS_LIST";
    const RETURN_ERROR_MESSAGE_NO_SSO_SESSION_ACTIVE_VALUE = "no SSO session active";
    const RETURN_ERROR_MESSAGE_NOT_ENOUGH_RIGHTS_VALUE = "not enought rights";
    
    const DEFAULT_CLIENT_RIGHTS = "*::*";
    
    const VERSION = "1.0 beta";

    /**
     * get client list return the client registered
     * @see OpenM_SSO::addClient.
     * it's possible to filter on client not validated only.
     * @param String $notValidOnly could take 'true' or 'false' value.
     * @return HashtableString contains the list of all client waiting validation, or not.
     */
    public function getClientList($notValidOnly = null);

    /**
     * validate client permit to validate a client. a validate client could open SSO session
     * @see OpenM_SSO::openSession
     * @param String $clientId is the ID of a registered client (@see OpenM_SSO::addClient)
     * @return HashtableString contains status OK if client associated to the clientId,
     * is successfully validated.
     */
    public function validateClient($clientId);

    /**
     * remove client unregister the added client
     * @see OpenM_SSO::addClient
     * @param String $clientId is the ID of a registered client
     * @return HashtableString contains status OK if client associated to the clientId,
     * is successfully removed.
     */
    public function removeClient($clientId);

    /**
     * add client rights open access rights for a client on specific method on specific api.
     * @see OpenM_SSO::addClient
     * @param String $clientId is the ID of a registered client
     * @param String $rights is a pattern of api name and method name separated by "::"
     * to filter method access on api for each client.
     * @return HashtableString contains status Ok if access rights have been
     * successfully added to the client associated to the clientId. Contains also
     * the right ID associated to the right added (to remove it if necessary).
     */
    public function addClientRights($clientId, $rights = null);

    /**
     * remove client rights remove access rights on specific method on specific api.
     * remove a right could have no effect if another right more open persist.
     * @param String $rightsId is the right ID of a previewsly added right 
     * @see self::addClientRights
     * @return HashtableString Description
     */
    public function removeClientRights($rightsId);

    /**
     * get client rights return the list of added rights for each registered client validated.
     * it's used to remove specific rights or check if rights exists for a client, for example.
     * @param String $clientId is the ID of a registered client
     * @see OpenM_SSO::addClient
     * @return HashtableString Description
     */
    public function getClientRights($clientId = null);
}

?>