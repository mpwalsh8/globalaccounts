<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Overview admin page content.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage admin
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

global $wpdb ;
global $phphtmllib ;

/**
 * Class definition of the overview tab
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see Container
 */
class OverviewTabContainer extends Container
{
    /**
     * Construct the content of the Overview Tab Container
     */
    function OverviewTabContainer()
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
        $div->add(html_h2("Global Accounts Overview")) ;

        $div->add(html_h4("People ...")) ;
        $div->add(html_h4("Org ...")) ;
        $div->add(html_h4("Events ...")) ;

        $this->add($div) ;
    }
}

//  Construct the Container

$c = new OverviewTabContainer() ;
print $c->render();
?>
