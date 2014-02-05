<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Users page content.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package swimteam
 * @subpackage admin
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

global $wpdb ;
global $phphtmllib ;

require_once("db.include.php") ;
require_once("users.class.php") ;
require_once("users.forms.class.php") ;

//foreach ($wpdb as $value => $key)
//	printf("%s => %s<br>", $value, $key) ;

/**
 * Class definition of the jobs
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see Container
 */
class UsersTabContainer extends Container
{
    /**
     * Construct the content of the Users Tab Container
     */
    function UsersTabContainer()
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
        $div->add(html_h2("Global Accounts Users")) ;

        //  So, how did we get here?  If $_POST is empty
        //  then it wasn't via a form submission.

        //  Show the list of jobs or process an action.  If
        //  there is no $_POST or if there isn't an action
        //  specififed, then simply display the GDL.
        if (empty($_POST) || (!array_key_exists("_action", $_POST) && !array_key_exists("_form_action", $_POST)))
        {
            $gdl = new GlobalAccountsUsersAdminGUIDataList("Global Accounts",
                "80%", "lastname", false, WPGA_USERS_COLUMNS,
                WPGA_USERS_TABLES, WPGA_USERS_WHERE_CLAUSE) ;
            $gdl->set_show_empty_datalist_actionbar(true) ;

            $div->add(html_br(2), $gdl, html_br()) ;
        }
        else  //  Crank up the action processing process
        {
            switch ($_POST['_action'])
            {
                case WPGA_USERS_PROFILE_USER:
                    $profile = new GlobalAccountsUserProfileInfoTable("User Profile", "400px") ;
                    $profile->set_alt_color_flag(true) ;
                    $profile->set_show_cellborders(true) ;
                    $profile->setId($_POST[WPGA_DB_PREFIX . "radio"][0]) ;
                    $profile->buildProfile() ;
                    break ;

                case WPGA_USERS_ADD_USER:
                    $form = new WpGlobalAccountsUserAddForm("Add User",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    break ;

                case WPGA_USERS_UPDATE_USER:
                    $form = new WpGlobalAccountsUserProfileForm("Update User",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    $form->setId($_POST[WPGA_DB_PREFIX . "radio"][0]) ;
                    $formAction = true ;
                    break ;

                case WPGA_USERS_REGISTER_USER:
                    $form = new WpGlobalAccountsUserRegisterForm("Register User",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    $form->setId($_POST[WPGA_DB_PREFIX . "radio"][0]) ;
                    break ;

                case WPGA_USERS_DELETE_USER:
                    $form = new WpGlobalAccountsUserDeleteForm("Delete User",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    $form->setId($_POST[WPGA_DB_PREFIX . "radio"][0]) ;
                    break ;

                default:
                    die("No action!!!") ;
                    break ;
            }

            //  Not all actions are form based ...

            if (isset($form))
            {
                //  Create the form processor
    
                $fp = new FormProcessor($form) ;
                $fp->set_form_action($_SERVER['REQUEST_URI']) ;
    
                //  Display the form again even if processing was successful.
    
                $fp->set_render_form_after_success(false) ;
    
                //  If the Form Processor was succesful, display
                //  some statistics about the uploaded file.
    
                if ($fp->is_action_successful())
                {
                    $gdl = new GlobalAccountsUsersAdminGUIDataList("My Users",
                        "80%", "lastname", false, WPGA_USERS_COLUMNS,
                        WPGA_USERS_TABLES, WPGA_USERS_WHERE_CLAUSE) ;
                    //$gdl->set_show_empty_datalist_actionbar(true) ;
    
                    $div->add(html_br(2), $gdl, html_br()) ;
    	            $div->add(html_br(2), $form->form_success()) ;
                }
                else
                {
    	            $div->add(html_br(2), $fp) ;
                }
            }
            else if (isset($profile))
            {
                $div->add(html_br(2), $profile) ;
            }
            else
            {
                $div->add(html_br(2), html_h4("No content to display.")) ;
            }
        }

        $this->add($div) ;
    }
}

//  Construct the Container

$c = new UsersTabContainer() ;
print $c->render();
?>
