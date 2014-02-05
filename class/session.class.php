<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Global Accounts web site Session class.
 *
 * (c) 2005 by Mike Walsh for Toolbox.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage Session
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once('session.include.php') ;

/**
 * Class for managing the Toolbox session storage
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 *
 */
class GlobalAccountsSession
{
    /**
     * Save some data to a session variable for use later on.
     *
     * @param mixed - data to save to session storage
     * @param string - name of session variable
     * @param boolean - serialize data prior to storage, defaults to false
     */
    function writeSession($sVar, $sData, $serialize = false)
    {
	    session_register($sVar) ;

        if ($serialize)
	        $_SESSION[$sVar] = serialize($sData) ;
        else
	        $_SESSION[$sVar] = $sData ;
    }

    /**
     * Save some data to a session variable for use later on.
     *
     * @param string - name of session variable
     * @param boolean - unserialize stored data, defaults to false
     * @return mixed - data to read from session storage
     */
    function readSession($sVar, $unserialize = false)
    {
        $sData = null ;

        if (session_is_registered($sVar))
        {
            $sData = $_SESSION[$sVar] ;

            if ($unserialize)
            {
                $sData = unserialize($sData) ;
            }
        }

        return $sData ;
    }

    /**
     * Purge a session variable - unregister a session
     * variable (if it exists), otherwise do nothing
     *
     * @param string - name of session variable
     */
    function purgeSession($sVar)
    {
        if (session_is_registered($sVar))
        {
            session_unregister($sVar) ;
        }
    }

    /**
     * Test for a session variable - determine if a 
     * session variable exists
     *
     * @param string - name of session variable
     */
    function existSession($sVar)
    {
        return session_is_registered($sVar) ;
    }
}
?>
