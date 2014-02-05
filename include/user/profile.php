<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * User Profile page content.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage admin
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

global $wpdb ;
global $phphtmllib ;

require_once("users.class.php") ;
require_once("users.forms.class.php") ;

//foreach ($wpdb as $value => $key)
//	printf("%s => %s<br>", $value, $key) ;

/**
 * Class definition of the UserProfileTab
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see Container
 */
class UserProfileTabContainer extends Container
{
    /**
     * Construct the content of the UserProfile Tab Container
     */
    function UserProfileTabContainer()
    {
        //  The container content is either a GUIDataList of 
        //  the jobs which have been defined OR form processor
        //  content to add, delete, or update jobs.  Wbich type
        //  of content the container holds is dependent on how
        //  the page was reached.
        //
        //  No matter what the container content is, it must be
        //  enclosed in a DIV with a class of "wrap" to fit in
        //  the Wordpress admin page structure.
 
        $div = html_div("wrap") ;
        $div->add(html_h2("Global Accounts User Profile")) ;

        //  Start building the form

        //  Cache the current user's data
        global $userdata ;
        get_currentuserinfo() ;

        $form = new GlobalAccountsUserForm("Global Accounts User Profile",
            $_SERVER['HTTP_REFERER'], 600) ;
        $form->setId($userdata->ID) ;

        //  Create the form processor

        $fp = new FormProcessor($form) ;
        $fp->set_form_action($_SERVER['REQUEST_URI']) ;

        //  Display the form again even if processing was successful.

        $fp->set_render_form_after_success(false) ;

        //  If the Form Processor was succesful, let the user know

        if ($fp->is_action_successful())
        {
	        $div->add(html_br(2), $fp) ;
            //$div->add(html_br(2), html_a($_SERVER['REQUEST_URI'], "Return")) ;
        }
        else
        {
	        $div->add(html_br(2), $fp) ;
        }

        $this->add($div) ;
    }
}
?>
