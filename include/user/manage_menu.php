<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Management admin page content.
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

/**
 * Class definition for the tab content
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access private
 */
class TabWidgetContent
{
    /**
     * Tab Label
     */
    var $_label ;

    /**
     * Tab Index
     */
    var $_index ;

    /**
     * Tab Include File
     */
    var $_include_file ;

    /**
     * Tab Class Name
     */
    var $_class_name ;

    /**
     * Class Constructor
     *
     * @return void
     */
    function TabWidgetContent($label, $index, $include_file, $class_name)
    {
        $this->setLabel($label) ;
        $this->setIndex($index) ;
        $this->setIncludeFile($include_file) ;
        $this->setClassName($class_name) ;
    }

    /**
     * Set Tab Label
     *
     * @param string - tab label
     */
    function setLabel($label)
    {
        $this->_label = $label ;
    }

    /**
     * Get Tab Label
     *
     * @return string - tab label
     */
    function getLabel()
    {
        return $this->_label ;
    }

    /**
     * Set Tab Index
     *
     * @param string - tab index
     */
    function setIndex($index)
    {
        $this->_index = $index ;
    }

    /**
     * Get Tab Index
     *
     * @return string - tab index
     */
    function getIndex()
    {
        return $this->_index ;
    }

    /**
     * Set Tab IncludeFile
     *
     * @param string - tab include file
     */
    function setIncludeFile($include_file)
    {
        $this->_include_file = $include_file ;
    }

    /**
     * Get Tab Include File
     *
     * @return string - tab include file
     */
    function getIncludeFile()
    {
        return $this->_include_file ;
    }

    /**
     * Set Tab Class Name
     *
     * @param string - tab class name
     */
    function setClassName($class_name)
    {
        $this->_class_name = $class_name ;
    }

    /**
     * Get Tab Class Name
     *
     * @return string - tab class name
     */
    function getClassName()
    {
        return $this->_class_name ;
    }
}

/**
 * Class definition of the Management Page
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see Container
 */
class ManagementTabContainer extends Container
{
    /**
     * Construct the content of the Management Tab Container
     */
    function ManagementTabContainer()
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
        $div->add(html_h2("Global Accounts Management")) ;

        //  Default to Tab #1 if no tab passed as part of URI

        $activetab = (array_key_exists('tab', $_GET)) ? $_GET['tab'] : "1" ;

        //  Build up the tab content
 
        $tab_index = 1 ;
        $tab_content = array() ;

        $tab_content[] = new TabWidgetContent("Mentor Org Tools",
            $tab_index++, "orgchart.php", "OrgChartTabContainer") ;

        $tab_content[] = new TabWidgetContent("Mentor Users",
            $tab_index++, "users.php", "AdminMentorUsersTabContainer") ;

        /*
        $tab_content[] = new TabWidgetContent("MGC Divisions",
            $tab_index++, "mgcdivisions.php", "AdminMGCDivisionsTabContainer") ;

        $tab_content[] = new TabWidgetContent("Global Parents",
            $tab_index++, "globalparents.php", "AdminGlobalParentsTabContainer") ;
        $tab_content[] = new TabWidgetContent("Customers",
            $tab_index++, "customers.php", "CustomersTabContainer") ;
         */

        $tabs = new TabControlWidget() ;

        $url = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ;

        //  Clean up the URL or the tab=N argument
        //  will continue to be appended indefinitely.

        $url = preg_replace('/&?tab=[1-9][0-9]*/i', '', $url) ;

        //  Add the tabs to the widget

        foreach ($tab_content as $tc)
        {
            $tabs->add_tab(html_a(sprintf("%s&tab=%d",
                $url, $tc->getIndex()), $tc->getLabel()),
                ($activetab == $tc->getIndex()));
        }

        $div->add($tabs);

        //  Load the tab content

        foreach ($tab_content as $tc)
        {
            if ($tc->getIndex() == $activetab)
            {
                require_once(WPGA_PATH .
                    "/include/user/" . $tc->getIncludeFile()) ;
                $class = $tc->getClassName() ;
                $div->add(new $class()) ;
                break ;
            }
        }

        $this->add($div) ;
    }
}

//  Construct the Container

$c = new ManagementTabContainer() ;
print $c->render();
?>
