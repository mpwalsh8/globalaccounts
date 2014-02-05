<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Age Groups admin page content.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @package swimteam
 * @subpackage admin
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

global $wpdb ;

require_once("reportgen.class.php") ;
require_once("reportgen.forms.class.php") ;

//foreach ($wpdb as $value => $key)
//	printf("%s => %s<br>", $value, $key) ;

/**
 * Class definition of the ReportGeneratorTab
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see Container
 */
class ReportGeneratorTabContainer extends Container
{
    /**
     * Construct the content of the ReportGenerator Tab Container
     */
    function ReportGeneratorTabContainer()
    {
        //  The container content is either a GUIDataList of 
        //  the jobs which have been defined OR form processor
        //  content to add, delete, or update jobs.  Wbich type
        //  of content the container holds is dependent on how
        //  the page was reached.
 
        $div = html_div() ;
        $div->add(html_h2("Swim Team Report Generator")) ;

        //  Start building the form

        $form = new WpSwimTeamReportGeneratorForm("Swim Team Report Generator",
            $_SERVER['HTTP_REFERER'], 600) ;

        //  Create the form processor

        $fp = new FormProcessor($form) ;
        //$fp->set_form_action($_SERVER['REQUEST_URI']) ;
        $fp->set_form_action($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']) ;
        //

        //  Display the form again even if processing was successful.

        $fp->set_render_form_after_success(false) ;

        //  If the Form Processor was succesful, let the user know

        if ($fp->is_action_successful())
        {
	        $div->add(html_br(2), $fp) ;

            $div->add(html_br(2), $c) ;
            $div->add(SwimTeamGUIBackHomeButtons::getButtons()) ;
        }
        else
        {
	        $div->add(html_br(1), $fp) ;
        }

        $this->add($div) ;
    }
}

//  Construct the Container

//$c = new ReportGeneratorTabContainer() ;
//print $c->render();
?>
