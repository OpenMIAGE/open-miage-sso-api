<?php

Import::php("OpenM-Services.api.OpenM_Service");

/**
 * Interface of SSO (Single Sign On) management, to open/close session.
 * This interface permit to an api to protect access and ensure that
 * user that calling api has authorization to call.
 * An OpenM-SSO api instanciation is associate with an OpenM_ID provider,
 * to check you're correctly authentificate on it.
 * OpenM-SSO ensure user identity to the API called.
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
interface OpenM_SSO extends OpenM_Service {

    const SSID_PARAMETER = "OpenM_SSID";
    const RETURN_SSID_PARAMETER = "OpenM_SSID";
    const RETURN_SSID_TIMER_PARAMETER = "OpenM_SSID_TIMER";
    const RETURN_OpenM_ID_PROVIDER_PARAMETER = "OpenID_PROVIDER";
    const RETURN_SERVICE_ID_PARAMETER = "SERVICE_ID";
    const RETURN_ERROR_MESSAGE_NOT_YOUR_SSID_VALUE = "It's not your SSID";
    const RETURN_ERROR_MESSAGE_NO_SESSION_ACTIVE_VALUE = "No session active";
    const RETURN_ERROR_MESSAGE_EXPIRED_SESSION_VALUE = "Expired session";
    const RETURN_ERROR_MESSAGE_CLIENT_NOT_VALID_VALUE = "Client not validated";
    const RETURN_CLIENT_ID_PARAMETER = "CLIENT_ID";
    const RETURN_ERROR_MESSAGE_NOT_CONNECTED_VALUE = "Not connected";
    const RETURN_ERROR_CODE_NOT_CONNECTED_VALUE = -1;
    
    const VERSION = "1.0.2";
    
    /**
     * open session is necessary to keep an SSID use to call an api
     * @param String $oid is the user openId provided by OpenM_ID
     * @param String $token is a temporary token provided by OpenM_ID
     * to open a session on an api that use OpenM-SSO
     * @return HashtableString contains the status of call, the SSID and
     * the validity timer
     */
    public function openSession($oid, $token);

    /**
     * is Session Ok, return the status of the session associated to the SSID
     * give in parameter.
     * @param String $SSID need to be a valid session ID returned 
     * by an open session calling.
     * @return HashtableString contains the status of call: OK if session is
     * already open.
     */
    public function isSessionOK($SSID);

    /**
     * close session is used to logout a OpenM-SSO session. It's not absolutly
     * necessary because of session timeout.
     * @param String $SSID need to be a valid session ID returned by an
     * open session calling.
     * @return HashtableString contains the status of call: OK if session correctly closed.
     * Else containing an error.
     */
    public function closeSession($SSID);
    
    /**
     * add client is used by clients to be registered on an OpenM-SSO api.
     * after registered, client must be validated by an administrator.
     * before validation, a client never could open session.
     * @param String $oid is the user openId provided by OpenM_ID
     * @param String $token is a temporary token provided by OpenM_ID
     * to open a session on an api that use OpenM-SSO
     * @return HashtableString contains the status of call: OK if client is
     * correclty added. Contains also the client registration id (could be use,
     * if you're an administrator, to add access rights on this one).
     */
    public function addClient($oid, $token);

    /**
     * get OpenM_ID URL return the URL of the associated OpenM_ID provider.
     * User that open a session must be logged on it to open session.
     * @return HashtableString contains the URL of OpenM_ID provider associated.
     */
    public function getOpenM_ID_URL();
}

?>