<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Plugin initialization.  This code will ensure that the
 * include_path is correct for phpHtmlLib, PEAR, and the local
 * site class and include files.
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @package Wp-SwimTeam
 * @subpackage Reports
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("forms.class.php") ;
require_once("reportgen.class.php") ;

define("FEFILTER", " Filter") ;
define("FEFILTERLB", FEFILTER . " Listbox") ;

/**
 * Construct the Add Age Group form
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see WpSwimTeamForm
 */
class WpSwimTeamReportGeneratorForm extends WpSwimTeamForm
{
    /**
     * generated report
     */
    var $__report ;

    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        $firstname = new FECheckBox("First Name") ;
        $this->add_element($firstname) ;

        $middlename = new FECheckBox("Middle Name") ;
        $this->add_element($middlename) ;

        $nickname = new FECheckBox("Nick Name") ;
        $this->add_element($nickname) ;

        $lastname = new FECheckBox("Last Name") ;
        $this->add_element($lastname) ;

        $gender = new FECheckBox("Gender") ;
        $this->add_element($gender) ;

        $birthdate = new FECheckBox("Birth Date") ;
        $this->add_element($birthdate) ;

        $age = new FECheckBox("Age") ;
        $this->add_element($age) ;

        $agegroup = new FECheckBox("Age Group") ;
        $this->add_element($agegroup) ;

        $primarycontact = new FECheckBox("Primary Contact") ;
        $primarycontact->set_disabled(true) ;
        $this->add_element($primarycontact) ;

        $primarycontactdetail = new FECheckBox("Primary Contact Detail") ;
        $primarycontactdetail->set_disabled(true) ;
        $this->add_element($primarycontactdetail) ;

        $secondarycontact = new FECheckBox("Secondary Contact") ;
        $secondarycontact->set_disabled(true) ;
        $this->add_element($secondarycontact) ;

        $secondarycontactdetail = new FECheckBox("Secondary Contact Detail") ;
        $secondarycontactdetail->set_disabled(true) ;
        $this->add_element($secondarycontactdetail) ;

        $status = new FECheckBox("Status") ;
        $this->add_element($status) ;

        $results = new FECheckBox("Results") ;
        $this->add_element($results) ;

        $swimmerlabel = new FECheckBox("Swimmer Label") ;
        $this->add_element($swimmerlabel) ;

        $websitreid = new FECheckBox("Web Site Id") ;
        $this->add_element($websitreid) ;

        $genderfilter = new FECheckBox("Gender" . FEFILTER) ;
        $this->add_element($genderfilter) ;

        $genderfilterlb = new FEListBox("Gender" . FEFILTERLB, true, "100px");
        $genderfilterlb->set_list_data(array(
             ucfirst(WPST_GENDER_MALE) => WPST_GENDER_MALE
            ,ucfirst(WPST_GENDER_FEMALE) => WPST_GENDER_FEMALE
        )) ;
        $this->add_element($genderfilterlb) ;

        $statusfilter = new FECheckBox("Status" . FEFILTER) ;
        $this->add_element($statusfilter) ;

        $statusfilterlb = new FEListBox("Status" . FEFILTERLB, true, "100px");
        $statusfilterlb->set_list_data(array(
             ucfirst(WPST_ACTIVE) => WPST_ACTIVE
            ,ucfirst(WPST_INACTIVE) => WPST_INACTIVE
        )) ;
        $this->add_element($statusfilterlb) ;

        $resultsfilter = new FECheckBox("Results" . FEFILTER) ;
        $this->add_element($resultsfilter) ;

        $resultsfilterlb = new FEListBox("Results" . FEFILTERLB, true, "100px");
        $resultsfilterlb->set_list_data(array(
             ucfirst(WPST_PUBLIC) => WPST_PUBLIC
            ,ucfirst(WPST_PRIVATE) => WPST_PRIVATE
        )) ;
        $this->add_element($resultsfilterlb) ;

        $send_to = new FEListBox("Report", true, "200px");
        $send_to->set_list_data(array(
             ucfirst(WPST_GENERATE_STATIC_WEB_PAGE) => WPST_GENERATE_STATIC_WEB_PAGE
            //,ucfirst(WPST_GENERATE_DYNAMIC_WEB_PAGE) => WPST_GENERATE_DYNAMIC_WEB_PAGE
            ,ucfirst(WPST_GENERATE_CSV) => WPST_GENERATE_CSV
        )) ;
        $this->add_element($send_to) ;

        // Optional swimmer field #1

        if (get_option(WPST_OPTION_SWIMMER_OPTION1) != WPST_DISABLED)
        {
            $option1 = new FECheckBox(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL)) ;
            $this->add_element($option1) ;

            // Field is enabled, can it be a filter?
 
            if (get_option(WPST_OPTION_SWIMMER_OPTION1) == WPST_YES_NO)
            {
                $option1filtercb = new FECheckBox(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . FEFILTER) ;
                $option1filter = new FEYesNoListBox(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . FEFILTERLB) ;
                $this->add_element($option1filtercb) ;
                $this->add_element($option1filter) ;
            }
        }

        // Optional swimmer field #2

        if (get_option(WPST_OPTION_SWIMMER_OPTION2) != WPST_DISABLED)
        {
            $option2 = new FECheckBox(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL)) ;
            $this->add_element($option2) ;

            // Field is enabled, can it be a filter?
 
            if (get_option(WPST_OPTION_SWIMMER_OPTION2) == WPST_YES_NO)
            {
                $option2filtercb = new FECheckBox(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . FEFILTER) ;
                $option2filter = new FEYesNoListBox(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . FEFILTERLB) ;
                $this->add_element($option2filtercb) ;
                $this->add_element($option2filter) ;
            }
        }

    }

    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $this->set_element_value("First Name", true) ;
        $this->set_element_value("Middle Name", false) ;
        $this->set_element_value("Nick Name", false) ;
        $this->set_element_value("Last Name", true) ;
        $this->set_element_value("Gender", true) ;
        $this->set_element_value("Birth Date", true) ;
        $this->set_element_value("Age", true) ;
        $this->set_element_value("Age Group", true) ;
        $this->set_element_value("Primary Contact", false) ;
        $this->set_element_value("Secondary Contact", false) ;
        $this->set_element_value("Primary Contact Detail", false) ;
        $this->set_element_value("Secondary Contact Detail", false) ;
        $this->set_element_value("Results", false) ;
        $this->set_element_value("Status", false) ;
        $this->set_element_value("Swimmer Label", true) ;
        $this->set_element_value("Web Site Id", false) ;
        $this->set_element_value("Results" . FEFILTER, false) ;
        $this->set_element_value("Status" . FEFILTER, true) ;
        $this->set_element_value("Gender" . FEFILTERLB, WPST_GENDER_BOTH) ;
        $this->set_element_value("Status" . FEFILTERLB, WPST_ACTIVE) ;
        $this->set_element_value("Results" . FEFILTERLB, WPST_PUBLIC) ;
        $this->set_element_value("Report", WPST_GENERATE_STATIC_WEB_PAGE) ;
    }


    /**
     * This is the method that builds the layout of where the
     * FormElements will live.  You can lay it out any way
     * you like.
     *
     */
    function form_content()
    {
        $this->add_form_block("Report Fields", $this->_report_options()) ;
        $this->add_form_block("Report Filters", $this->_report_filters()) ;
        $this->add_form_block("Report Output", $this->_send_report_to()) ;
    }

    /**
     * This is the method that builds the layout of
     * the Swim Team plugin options.
     *
     */
    function &_report_options()
    {
        $table = html_table($this->_width, 0, 4) ;
        //$table->set_style("border: 1px solid") ;

        $table->add_row($this->element_form("First Name"),
            $this->element_form("Middle Name")) ;

        $table->add_row($this->element_form("Last Name"),
            $this->element_form("Nick Name")) ;

        $table->add_row($this->element_form("Birth Date"),
            $this->element_form("Gender")) ;

        $table->add_row($this->element_form("Age"),
            $this->element_form("Age Group")) ;

        $table->add_row($this->element_form("Primary Contact"),
            $this->element_form("Primary Contact Detail")) ;

        $table->add_row($this->element_form("Secondary Contact"),
            $this->element_form("Secondary Contact Detail")) ;

        $table->add_row($this->element_form("Status"),
            $this->element_form("Results")) ;

        $table->add_row($this->element_form("Swimmer Label"),
            $this->element_form("Web Site Id")) ;

        //  Optional swimmer field #1

        if (get_option(WPST_OPTION_SWIMMER_OPTION1) != WPST_DISABLED)
            $table->add_row($this->element_form(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL))) ;

        if (get_option(WPST_OPTION_SWIMMER_OPTION2) != WPST_DISABLED)
            $table->add_row($this->element_form(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL))) ;

        if (get_option(WPST_OPTION_SWIMMER_OPTION3) != WPST_DISABLED)
            $table->add_row($this->element_form(get_option(WPST_OPTION_SWIMMER_OPTION3_LABEL))) ;

        if (get_option(WPST_OPTION_SWIMMER_OPTION4) != WPST_DISABLED)
            $table->add_row($this->element_form(get_option(WPST_OPTION_SWIMMER_OPTION4_LABEL))) ;

        if (get_option(WPST_OPTION_SWIMMER_OPTION5) != WPST_DISABLED)
            $table->add_row($this->element_form(get_option(WPST_OPTION_SWIMMER_OPTION5_LABEL))) ;

        return $table ;
    }

    /**
     * This is the method that builds the layout of
     * the Swim Team plugin options.
     *
     */
    function &_send_report_to()
    {
        $table = html_table($this->_width, 0, 4) ;

        $table->add_row($this->element_form("Report")) ;

        return $table ;
    }

    /**
     * This is the method that builds the layout of
     * the Swim Team plugin options.
     *
     */
    function &_report_filters()
    {
        $table = html_table($this->_width, 0, 4) ;

        $table->add_row($this->element_form("Gender" . FEFILTER),
            $this->element_form("Gender" . FEFILTERLB)) ;

        $table->add_row($this->element_form("Status" . FEFILTER),
            $this->element_form("Status" . FEFILTERLB)) ;

        $table->add_row($this->element_form("Results" . FEFILTER),
            $this->element_form("Results" . FEFILTERLB)) ;

        //  Filter for optional swimmer field #1

        if (get_option(WPST_OPTION_SWIMMER_OPTION1) == WPST_YES_NO)
        {
            $table->add_row($this->element_form(
                get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . FEFILTER),
                $this->element_form(
                get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . FEFILTERLB)) ;
        }

        //  Filter for optional swimmer field #2

        if (get_option(WPST_OPTION_SWIMMER_OPTION2) == WPST_YES_NO)
        {
            $table->add_row($this->element_form(
                get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . FEFILTER),
                $this->element_form(
                get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . FEFILTERLB)) ;
        }

        return $table ;
    }

    /**
     * This method gets called after the FormElement data has
     * passed the validation.  This enables you to validate the
     * data against some backend mechanism, say a DB.
     *
     */
    function form_backend_validation()
    {
	    return true ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        if ($this->get_element_value("Report") == WPST_GENERATE_STATIC_WEB_PAGE)
        {
            $csv = false ;
            $this->__report = new SwimTeamReportGenerator() ;
            //$this->__report = new SwimTeamInfoTable("Swim Team Report", "800px") ;
            
        }
        else if ($this->get_element_value("Report") == WPST_GENERATE_CSV)
        {
            $csv = true ;
            $this->__report = new SwimTeamReportGeneratorCSV() ;
            //$this->__report = new SwimTeamInfoTable("Swim Team Report", "800px") ;
            //$this->__report = new Container() ;
        }
        else
        {
            return false ;
        }

        //  $rpt is a shortcut to the class property

        $rpt = &$this->__report ;

        if (!is_null($this->get_element_value("First Name")))
            $rpt->setFirstName(true) ;

        if (!is_null($this->get_element_value("Middle Name")))
            $rpt->setMiddleName(true) ;

        if (!is_null($this->get_element_value("Nick Name")))
            $rpt->setNickName(true) ;

        if (!is_null($this->get_element_value("Last Name")))
            $rpt->setLastName(true) ;

        if (!is_null($this->get_element_value("Birth Date")))
            $rpt->setBirthDate(true) ;

        if (!is_null($this->get_element_value("Age")))
            $rpt->setAge(true) ;

        if (!is_null($this->get_element_value("Age Group")))
            $rpt->setAgeGroup(true) ;

        if (!is_null($this->get_element_value("Gender")))
            $rpt->setGender(true) ;

        if (!is_null($this->get_element_value("Primary Contact")))
            $rpt->setPrimaryContact(true) ;

        if (!is_null($this->get_element_value("Primary Contact Detail")))
            $rpt->setPrimaryContactDetail(true) ;

        if (!is_null($this->get_element_value("Secondary Contact")))
            $rpt->setSecondaryContact(true) ;

        if (!is_null($this->get_element_value("Secondary Contact Detail")))
            $rpt->setSecondaryContactDetail(true) ;

        if (!is_null($this->get_element_value("Status")))
            $rpt->setStatus(true) ;

        if (!is_null($this->get_element_value("Results")))
            $rpt->setResults(true) ;

        if (!is_null($this->get_element_value("Swimmer Label")))
            $rpt->setSwimmerLabel(true) ;

        if (!is_null($this->get_element_value("Web Site Id")))
            $rpt->setWebSiteId(true) ;

        if (get_option(WPST_OPTION_SWIMMER_OPTION1) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL))))
            {
                $rpt->setOption1(true) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION2) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL))))
            {
                $rpt->setOption2(true) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION3) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION3_LABEL))))
            {
                $rpt->setOption3(true) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION4) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION4_LABEL))))
            {
                $rpt->setOption4(true) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION5) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION5_LABEL))))
            {
                $rpt->setOption5(true) ;
            }
        }

        //  Filters
 
        if (!is_null($this->get_element_value("Gender" . FEFILTER)))
        {
            $rpt->setGenderFilter(true) ;
            $rpt->setGenderFilterValue($this->get_element_value("Gender" . FEFILTERLB)) ;
        }

        if (!is_null($this->get_element_value("Status" . FEFILTER)))
        {
            $rpt->setStatusFilter(true) ;
            $rpt->setStatusFilterValue($this->get_element_value("Status" . FEFILTERLB)) ;
        }

        if (!is_null($this->get_element_value("Results" . FEFILTER)))
        {
            $rpt->setResultsFilter(true) ;
            $rpt->setResultsFilterValue($this->get_element_value("Results" . FEFILTERLB)) ;
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION1) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . FEFILTER)))
            {
                $rpt->setOption1Filter(true) ;
                $rpt->setOption1FilterValue($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . FEFILTERLB)) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION2) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . FEFILTER)))
            {
                $rpt->setOption2Filter(true) ;
                $rpt->setOption2FilterValue($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . FEFILTERLB)) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION3) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION3_LABEL) . FEFILTER)))
            {
                $rpt->setOption3Filter(true) ;
                $rpt->setOption3FilterValue($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION3_LABEL) . FEFILTERLB)) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION4) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION4_LABEL) . FEFILTER)))
            {
                $rpt->setOption4Filter(true) ;
                $rpt->setOption4FilterValue($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION4_LABEL) . FEFILTERLB)) ;
            }
        }

        if (get_option(WPST_OPTION_SWIMMER_OPTION5) != WPST_DISABLED)
        {
            if (!is_null($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION5_LABEL) . FEFILTER)))
            {
                $rpt->setOption5Filter(true) ;
                $rpt->setOption5FilterValue($this->get_element_value(get_option(WPST_OPTION_SWIMMER_OPTION5_LABEL) . FEFILTERLB)) ;
            }
        }

        $rpt->generateReport() ;
        
        //$this->__report = $rpt->getReport() ;

        $this->set_action_message(sprintf("Swim Team Report Generated,
            %s record%s returned.", $rpt->getRecordCount(),
            $rpt->getRecordCount() == 1 ? "" : "s")) ;

        return true ;
    }

    /**
     * container to hold success message
     *
     * @return container
     */
    function form_success()
    {
        $c = container() ;

        $rpt = &$this->__report ;

        if ($this->get_element_value("Report") == WPST_GENERATE_STATIC_WEB_PAGE)
        {
            $c->add($rpt->getReport()) ;
        }
        else if ($this->get_element_value("Report") == WPST_GENERATE_CSV)
        {
            $rpt->generateCSVFile() ;

            $arg = urlencode($rpt->getCSVFile()) ;

            $if = html_iframe(sprintf("%s/wp-content/plugins/swimteam/include/admin/reportgenCSV.php?file=%s", get_option('siteurl'), $arg)) ;
            $if->set_tag_attributes(array("width" => 0, "height" => 0)) ;
            $c->add($if) ;
        }
            
        $c->add(html_h4($this->_action_message)) ;

        return $c ;
    }

    /**
     * Overload form_content_buttons() method to have the
     * button display "Generate" instead of the default "Save".
     *
     */
    function form_content_buttons()
    {
        return $this->form_content_buttons_Generate_Cancel() ;
    }
}
?>
