<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Reports classes.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @package SwimTeam
 * @subpackage Reports
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("db.class.php") ;
require_once("table.class.php") ;
require_once("seasons.class.php") ;
require_once("swimmers.class.php") ;
require_once("roster.class.php") ;
require_once("swimteam.include.php") ;

/**
 * Class definition of the report generator
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see SwimTeamDBI
 */
class SwimTeamReportGenerator extends SwimTeamDBI
{
    /**
     * first name field
     */
    var $__firstname = false ;

    /**
     * middle name field
     */
    var $__middlename = false ;

    /**
     * nick name field
     */
    var $__nickname = false ;

    /**
     * last name field
     */
    var $__lastname = false ;

    /**
     * birth date field
     */
    var $__birthdate = false ;

    /**
     * gender field
     */
    var $__gender = false ;

    /**
     * age field
     */
    var $__age = false ;

    /**
     * age group field
     */
    var $__agegroup = false ;

    /**
     * primary contact
     */
    var $__primarycontact = false ;

    /**
     * primary contact detail
     */
    var $__primarycontactdetail = false ;

    /**
     * secondary contact
     */
    var $__secondarycontact = false ;

    /**
     * secondary contact detail
     */
    var $__secondarycontactdetail = false ;

    /**
     * t-shirt size
     */
    var $__tshirtsize = false ;

    /**
     * results
     */
    var $__results = false ;

    /**
     * swimmer label
     */
    var $__swimmerlabel = false ;

    /**
     * web site id
     */
    var $__websiteid = false ;

    /**
     * optional field #1
     */
    var $__option1 = false ;

    /**
     * optional field #2
     */
    var $__option2 = false ;

    /**
     * optional field #3
     */
    var $__option3 = false ;

    /**
     * optional field #4
     */
    var $__option4 = false ;

    /**
     * optional field #5
     */
    var $__option5 = false ;

    /**
     * gender filter
     */
    var $__genderfilter = false ;

    /**
     * gender filter value
     */
    var $__genderfiltervalue = WPST_NULL_STRING ;

    /**
     * status filter
     */
    var $__statusfilter = false ;

    /**
     * status filter value
     */
    var $__statusfiltervalue = WPST_NULL_STRING ;

    /**
     * t-shirt size filter
     */
    var $__tshirtfilter = false ;

    /**
     * t-shirt size filter value
     */
    var $__tshirtfiltervalue = WPST_TSHIRT_SIZE_YL_VALUE ;

    /**
     * results filter
     */
    var $__resultsfilter = false ;

    /**
     * results filter value
     */
    var $__resultsfiltervalue = WPST_PUBLIC ;

    /**
     * option field #1 filter
     */
    var $__option1filter = false ;

    /**
     * option field #1 filter value
     */
    var $__option1filtervalue = WPST_NULL_STRING ;

    /**
     * option field #2 filter
     */
    var $__option2filter = false ;

    /**
     * option field #2 filter value
     */
    var $__option2filtervalue = WPST_NULL_STRING ;

    /**
     * option field #3 filter
     */
    var $__option3filter = false ;

    /**
     * option field #3 filter value
     */
    var $__option3filtervalue = WPST_NULL_STRING ;

    /**
     * option field #4 filter
     */
    var $__option4filter = false ;

    /**
     * option field #4 filter value
     */
    var $__option4filtervalue = WPST_NULL_STRING ;

    /**
     * option field #5 filter
     */
    var $__option5filter = false ;

    /**
     * option field #5 filter value
     */
    var $__option5filtervalue = WPST_NULL_STRING ;

    /**
     * record count
     */
    var $__recordcount = 0 ;

    /**
     * report table
     */
    var $__reporttable = null ;

    /**
     * current roster
     */
    var $__currentroster = null ;

    /**
     * Get current swimmer label if it exists
     *
     * Label is a challenge because it is tied to
     * the current roster and not to the swimmer.

     * @return string - current swimmer label
     */
    function getCurrentSwimmerLabel($swimmerid)
    {
        if (is_null($this->__currentroster))
        {
            $this->__currentroster = new SwimTeamRoster() ;

            $season = new SwimTeamSeason() ;
            //$season->loadActiveSeason() ;

            $this->__currentroster->setSeasonId($season->getActiveSeasonId()) ;
        }

        $this->__currentroster->setSwimmerId($swimmerid) ;
        $this->__currentroster->loadRosterBySeasonIdAndSwimmerId() ;

        $label = $this->__currentroster->getSwimmerLabel() ;

        if (is_null($label) || ($label == WPST_NULL_STRING)) $label = "N/A" ;

        return $label ;
    }

    /**
     * set first name field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setFirstName($flag = true)
    {
        $this->__firstname = $flag ;
    }

    /**
     * get first name field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getFirstName()
    {
        return $this->__firstname ;
    }

    /**
     * set middle name field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setMiddleName($flag = true)
    {
        $this->__middlename = $flag ;
    }

    /**
     * get middle name field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getMiddleName()
    {
        return $this->__middlename ;
    }

    /**
     * set nick name field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setNickName($flag = true)
    {
        $this->__nickname = $flag ;
    }

    /**
     * get middle name field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getNickName()
    {
        return $this->__nickname ;
    }

    /**
     * set last name field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setLastName($flag = true)
    {
        $this->__lastname = $flag ;
    }

    /**
     * get last name field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getLastName()
    {
        return $this->__lastname ;
    }

    /**
     * set birth date field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setBirthDate($flag = true)
    {
        $this->__birthdate = $flag ;
    }

    /**
     * get birth date field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getBirthDate()
    {
        return $this->__birthdate ;
    }

    /**
     * set gender field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setGender($flag = true)
    {
        $this->__gender = $flag ;
    }

    /**
     * get gender field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getGender()
    {
        return $this->__gender ;
    }

    /**
     * set age field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setAge($flag = true)
    {
        $this->__age = $flag ;
    }

    /**
     * get age field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getAge()
    {
        return $this->__age ;
    }

    /**
     * set age group field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setAgeGroup($flag = true)
    {
        $this->__agegroup = $flag ;
    }

    /**
     * get age group field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getAgeGroup()
    {
        return $this->__agegroup ;
    }

    /**
     * set primary contact field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setPrimaryContact($flag = true)
    {
        $this->__primarycontact = $flag ;
    }

    /**
     * get primary contact field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getPrimaryContact()
    {
        return $this->__primarycontact ;
    }

    /**
     * set primary contact detail field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setPrimaryContactDetail($flag = true)
    {
        $this->__primarycontactdetail = $flag ;
    }

    /**
     * get primary contact detail field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getPrimaryContactDetail()
    {
        return $this->__primarycontactdetail ;
    }

    /**
     * set secondary contact field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setSecondaryContact($flag = true)
    {
        $this->__secondarycontact = $flag ;
    }

    /**
     * get secondary contact field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getSecondaryContact()
    {
        return $this->__secondarycontact ;
    }

    /**
     * set secondary contact detail field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setSecondaryContactDetail($flag = true)
    {
        $this->__secondarycontactdetail = $flag ;
    }

    /**
     * get secondary contact detail field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getSecondaryContactDetail()
    {
        return $this->__secondarycontactdetail ;
    }

    /**
     * set t-shirt size field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setTShirtSize($flag = true)
    {
        $this->__tshirtsize = $flag ;
    }

    /**
     * get t-shirt size field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getTShirtSize()
    {
        return $this->__tshirtsize ;
    }

    /**
     * set results field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setResults($flag = true)
    {
        $this->__results = $flag ;
    }

    /**
     * get results field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getResults()
    {
        return $this->__results ;
    }

    /**
     * set status field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setStatus($flag = true)
    {
        $this->__status = $flag ;
    }

    /**
     * get status field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getStatus()
    {
        return $this->__status ;
    }

    /**
     * set swimmer label field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setSwimmerLabel($flag = true)
    {
        $this->__swimmerlabel = $flag ;
    }

    /**
     * get swimmer label field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getSwimmerLabel()
    {
        return $this->__swimmerlabel ;
    }

    /**
     * set web site id field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setWebSiteId($flag = true)
    {
        $this->__websiteid = $flag ;
    }

    /**
     * get web site id field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getWebSiteId()
    {
        return $this->__websiteid ;
    }

    /**
     * set optional field #1 field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption1($flag = true)
    {
        $this->__option1 = $flag ;
    }

    /**
     * get optional field #1 field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption1()
    {
        return $this->__option1 ;
    }

    /**
     * set optional field #2 field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption2($flag = true)
    {
        $this->__option2 = $flag ;
    }

    /**
     * get optional field #2 field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption2()
    {
        return $this->__option2 ;
    }

    /**
     * set optional field #3 field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption3($flag = true)
    {
        $this->__option3 = $flag ;
    }

    /**
     * get optional field #3 field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption3()
    {
        return $this->__option3 ;
    }

    /**
     * set optional field #4 field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption4($flag = true)
    {
        $this->__option4 = $flag ;
    }

    /**
     * get optional field #4 field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption4()
    {
        return $this->__option4 ;
    }

    /**
     * set optional field #5 field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption5($flag = true)
    {
        $this->__option5 = $flag ;
    }

    /**
     * get optional field #5 field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption5()
    {
        return $this->__option5 ;
    }

    /**
     * set gender filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setGenderFilter($flag = true)
    {
        $this->__genderfilter = $flag ;
    }

    /**
     * get gender filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getGenderFilter()
    {
        return $this->__genderfilter ;
    }

    /**
     * set gender filter field value
     *
     * @param string - value to use to filter report
     */
    function setGenderFilterValue($filter = "")
    {
        $this->__genderfiltervalue = $filter ;
    }

    /**
     * get gender filter field value
     *
     * @return string - value to use to filter report
     */
    function getGenderFilterValue()
    {
        return $this->__genderfiltervalue ;
    }

    /**
     * set status filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setStatusFilter($flag = true)
    {
        $this->__statusfilter = $flag ;
    }

    /**
     * get status filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getStatusFilter()
    {
        return $this->__statusfilter ;
    }

    /**
     * set status filter field value
     *
     * @param string - value to use to filter report
     */
    function setStatusFilterValue($filter = "")
    {
        $this->__statusfiltervalue = $filter ;
    }

    /**
     * get status filter field value
     *
     * @return string - value to use to filter report
     */
    function getStatusFilterValue()
    {
        return $this->__statusfiltervalue ;
    }

    /**
     * set t-shirt size filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setTShirtSizeFilter($flag = true)
    {
        $this->__tshirtsizefilter = $flag ;
    }

    /**
     * get t-shirt size filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getTShirtSizeFilter()
    {
        return $this->__tshirtsizefilter ;
    }

    /**
     * set t-shirt size filter field value
     *
     * @param string - value to use to filter report
     */
    function setTShirtSizeFilterValue($filter = "")
    {
        $this->__tshirtsizefiltervalue = $filter ;
    }

    /**
     * get t-shirt size filter field value
     *
     * @return string - value to use to filter report
     */
    function getTShirtSizeFilterValue()
    {
        return $this->__tshirtsizefiltervalue ;
    }

    /**
     * set results filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setResultsFilter($flag = true)
    {
        $this->__resultsfilter = $flag ;
    }

    /**
     * get results filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getResultsFilter()
    {
        return $this->__resultsfilter ;
    }

    /**
     * set results filter field value
     *
     * @param string - value to use to filter report
     */
    function setResultsFilterValue($filter = "")
    {
        $this->__resultsfiltervalue = $filter ;
    }

    /**
     * get results filter field value
     *
     * @return string - value to use to filter report
     */
    function getResultsFilterValue()
    {
        return $this->__resultsfiltervalue ;
    }

    /**
     * set optional field #1 filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption1Filter($flag = true)
    {
        $this->__option1filter = $flag ;
    }

    /**
     * get optional field #1 filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption1Filter()
    {
        return $this->__option1filter ;
    }

    /**
     * set optional field #1 filter field value
     *
     * @param string - value to use to filter report
     */
    function setOption1FilterValue($filter = "")
    {
        $this->__option1filtervalue = $filter ;
    }

    /**
     * get optional field #1 filter field value
     *
     * @return string - value to use to filter report
     */
    function getOption1FilterValue()
    {
        return $this->__option1filtervalue ;
    }

    /**
     * set optional field #2 filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption2Filter($flag = true)
    {
        $this->__option2filter = $flag ;
    }

    /**
     * get optional field #2 filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption2Filter()
    {
        return $this->__option2filter ;
    }

    /**
     * set optional field #2 filter field value
     *
     * @param string - value to use to filter report
     */
    function setOption2FilterValue($filter = "")
    {
        $this->__option2filtervalue = $filter ;
    }

    /**
     * get optional field #2 filter field value
     *
     * @return string - value to use to filter report
     */
    function getOption2FilterValue()
    {
        return $this->__option2filtervalue ;
    }

    /**
     * set optional field #3 filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption3Filter($flag = true)
    {
        $this->__option3filter = $flag ;
    }

    /**
     * get optional field #3 filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption3Filter()
    {
        return $this->__option3filter ;
    }

    /**
     * set optional field #3 filter field value
     *
     * @param string - value to use to filter report
     */
    function setOption3FilterValue($filter = "")
    {
        $this->__option3filtervalue = $filter ;
    }

    /**
     * get optional field #3 filter field value
     *
     * @return string - value to use to filter report
     */
    function getOption3FilterValue()
    {
        return $this->__option3filtervalue ;
    }

    /**
     * set optional field #4 filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption4Filter($flag = true)
    {
        $this->__option4filter = $flag ;
    }

    /**
     * get optional field #4 filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption4Filter()
    {
        return $this->__option4filter ;
    }

    /**
     * set optional field #4 filter field value
     *
     * @param string - value to use to filter report
     */
    function setOption4FilterValue($filter = "")
    {
        $this->__option4filtervalue = $filter ;
    }

    /**
     * get optional field #4 filter field value
     *
     * @return string - value to use to filter report
     */
    function getOption4FilterValue()
    {
        return $this->__option4filtervalue ;
    }

    /**
     * set optional field #5 filter field inclusion
     *
     * @param boolean - flag to turn field inclusion on or off
     */
    function setOption5Filter($flag = true)
    {
        $this->__option5filter = $flag ;
    }

    /**
     * get optional field #5 filter field inclusion
     *
     * @return boolean - flag to turn field inclusion on or off
     */
    function getOption5Filter()
    {
        return $this->__option5filter ;
    }

    /**
     * set optional field #5 filter field value
     *
     * @param string - value to use to filter report
     */
    function setOption5FilterValue($filter = "")
    {
        $this->__option5filtervalue = $filter ;
    }

    /**
     * get optional field #5 filter field value
     *
     * @return string - value to use to filter report
     */
    function getOption5FilterValue()
    {
        return $this->__option5filtervalue ;
    }

    /**
     * Get report record count
     *
     * @return int - count of report records
     */
    function getRecordCount()
    {
        return $this->__recordcount ;
    }

    /**
     * Get report
     *
     * @return html_table - report table
     */
    function getReport()
    {
        return $this->__reporttable ;
    }

    /**
     * Create the filter used to during the report generation.
     *
     * @return string - filter - filter string used with SQL WHERE clause.
     */
    function getFilter()
    {
        //  Construct filters

        $filter = "" ;

        if ($this->getGenderFilter())
            $filter .= sprintf("%sgender='%s'",
                ($filter == "" ? "" : " AND "), $this->getGenderFilterValue()) ;

        if ($this->getStatusFilter())
            $filter .= sprintf("%sstatus='%s'",
                ($filter == "" ? "" : " AND "), $this->getStatusFilterValue()) ;

        if ($this->getResultsFilter())
            $filter .= sprintf("%sresults='%s'",
                ($filter == "" ? "" : " AND "), $this->getResultsFilterValue()) ;

        if ($this->getOption1Filter())
            $filter .= sprintf("%soption1='%s'",
                ($filter == "" ? "" : " AND "), $this->getOption1FilterValue()) ;

        if ($this->getOption2Filter())
            $filter .= sprintf("%soption2='%s'",
                ($filter == "" ? "" : " AND "), $this->getOption2FilterValue()) ;

        if ($this->getOption3Filter())
            $filter .= sprintf("%soption3='%s'",
                ($filter == "" ? "" : " AND "), $this->getOption3FilterValue()) ;

        if ($this->getOption4Filter())
            $filter .= sprintf("%soption4='%s'",
                ($filter == "" ? "" : " AND "), $this->getOption4FilterValue()) ;

        if ($this->getOption5Filter())
            $filter .= sprintf("%soption5='%s'",
                ($filter == "" ? "" : " AND "), $this->getOption5FilterValue()) ;
        return $filter ;
    }

    /**
     * Generate the Report
     *
     */
    function generateReport()
    {
        $this->__reporttable = new SwimTeamInfoTable("Swim Team Report", "100%") ;
        $table = &$this->__reporttable ;
        $table->set_alt_color_flag(true) ;

        $season = new SwimTeamSeason() ;

        $swimmer = new SwimTeamSwimmer() ;

        $tr = array() ;

        if ($this->getFirstName()) $tr[] = "First Name" ;
        if ($this->getMiddleName()) $tr[] = "Middle Name" ;
        if ($this->getNickName()) $tr[] = "Nick Name" ;
        if ($this->getLastName()) $tr[] = "Last Name" ;
        if ($this->getBirthDate()) $tr[] = "Birth Date" ;
        if ($this->getAge()) $tr[] = "Age" ;
        if ($this->getAgeGroup()) $tr[] = "Age Group" ;
        if ($this->getGender()) $tr[] = "Gender" ;
        if ($this->getStatus()) $tr[] = "Status" ;
        if ($this->getSwimmerLabel()) $tr[] = "Swimmer Label" ;
        if ($this->getResults()) $tr[] = "Results" ;
        if ($this->getWebSiteId()) $tr[] = "Web Site Id" ;

        //  Handle the optional fields

        if ($this->getOption1())
            $tr[] = get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) ;

        if ($this->getOption2())
            $tr[] = get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) ;

        if ($this->getOption3())
            $tr[] = get_option(WPST_OPTION_SWIMMER_OPTION3_LABEL) ;

        if ($this->getOption4())
            $tr[] = get_option(WPST_OPTION_SWIMMER_OPTION4_LABEL) ;

        if ($this->getOption5())
            $tr[] = get_option(WPST_OPTION_SWIMMER_OPTION5_LABEL) ;

        //  Generate the column headers
 
        for ($i = 0 ; $i < count($tr) ; $i++)
            $table->set_column_header($i, $tr[$i], null, "left") ;

        //  Get all the swimmer ids using the appropriate filter

        $swimmerIds = $swimmer->getAllSwimmerIds($this->getFilter()) ;

        //  Loop through the swimmers

        $this->__recordcount = 0 ;

        foreach ($swimmerIds as $swimmerId)
        {
            $this->__recordcount++ ;

            $tr = array() ;

            $swimmer->loadSwimmerById($swimmerId["swimmerid"]) ;

            if ($this->getFirstName())
                $tr[] = $swimmer->getFirstName() ;

            if ($this->getMiddleName())
                $tr[] = $swimmer->getMiddleName() ;

            if ($this->getNickName())
                $tr[] = $swimmer->getNickName() ;

            if ($this->getLastName())
                $tr[] = $swimmer->getLastName() ;

            if ($this->getBirthDate())
                $tr[] = $swimmer->getDateOfBirthAsDate() ;

            if ($this->getAge())
                $tr[] = $swimmer->getAge() . " (" .
                   $swimmer->getAgeGroupAge() . ")" ;

            if ($this->getAgeGroup())
                $tr[] = $swimmer->getAgeGroupText() ;

            if ($this->getGender())
                $tr[] = ucfirst($swimmer->getGender()) ;

            if ($this->getStatus())
                $tr[] = ucfirst($swimmer->getStatus()) ;

            if ($this->getSwimmerLabel())
                $tr[] = $this->getCurrentSwimmerLabel($swimmerId["swimmerid"]) ;

            if ($this->getResults())
                $tr[] = ucfirst($swimmer->getResults()) ;
            if ($this->getWebSiteId())
            {
                if ($swimmer->getWPUserId() == WPST_NONE)
                {
                    $tr[] = "&nbsp;" ;
                }
                else
                {
                    $u = get_userdata($swimmer->getWPUserId()) ;
                    $tr[] = $u->user_login ;
                }
            }

            if ($this->getOption1())
                $tr[] = ucfirst($swimmer->getSwimmerOption1()) ;

            if ($this->getOption2())
                $tr[] = ucfirst($swimmer->getSwimmerOption2()) ;

            if ($this->getOption3())
                $tr[] = ucfirst($swimmer->getSwimmerOption3()) ;

            if ($this->getOption4())
                $tr[] = ucfirst($swimmer->getSwimmerOption4()) ;

            if ($this->getOption5())
                $tr[] = ucfirst($swimmer->getSwimmerOption5()) ;

            //  Can't simply add a row to the table because we
            //  don't know how many cells the table has.  Use this
            //  PHP trick to pass an undetermined number of arguments
            //  to a method.

            call_user_method_array('add_row', $table, $tr) ;
        }
    }
}

/**
 * Class definition of the CSV report generator
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see SwimTeamDBI
 */
class SwimTeamReportGeneratorCSV extends SwimTeamReportGenerator
{
    /**
     * csv data
     */
    var $__csvData ;

    /**
     * csv File
     */
    var $__csvFile ;

    /**
     * csv record count
     */
    var $__csvCount ;

    /**
     * Get CSV record count
     *
     * @return int - count of CSV records
     */
    function getCSVCount()
    {
        return $this->__csvCount ;
    }

    /**
     * Get CSV file name
     *
     * @return string - CSV file name
     */
    function getCSVFile()
    {
        return $this->__csvFile ;
    }

    /**
     * Set CSV file name
     *
     * @param string - CSV file name
     */
    function setCSVFile($f)
    {
        $this->__csvFile = $f ;
    }

    /**
     * Get report
     *
     * @return html_table - report table
     */
    function getReport()
    {
        return new Container(html_pre($this->__csvData)) ;
    }

    /**
     * Generate the Report
     *
     */
    function generateReport()
    {
        $this->__csvData = "" ;

        $csv = &$this->__csvData ;

        $season = new SwimTeamSeason() ;

        $swimmer = new SwimTeamSwimmer() ;

        //  Generate the column headers
 
        if ($this->getFirstName())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : ""). "\"First Name\"" ;

        if ($this->getMiddleName())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : ""). "\"Middle Name\"" ;

        if ($this->getNickName())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : ""). "\"Nick Name\"" ;

        if ($this->getLastName())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Last Name\"" ;

        if ($this->getBirthDate())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Birth Date\"" ;

        if ($this->getAge())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Age\"" ;

        if ($this->getAgeGroup())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Age Group\"" ;

        if ($this->getGender())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Gender\"" ;

        if ($this->getStatus())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Status\"" ;

        if ($this->getSwimmerLabel())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Swimmer Label\"" ;

        if ($this->getResults())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Results\"" ;

        if ($this->getWebSiteId())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"Web Site Id\"" ;


        //  Handle the optional fields

        if ($this->getOption1())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"" .
                get_option(WPST_OPTION_SWIMMER_OPTION1_LABEL) . "\"" ;

        if ($this->getOption2())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"" .
                get_option(WPST_OPTION_SWIMMER_OPTION2_LABEL) . "\"" ;

        if ($this->getOption3())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"" .
                get_option(WPST_OPTION_SWIMMER_OPTION3_LABEL) . "\"" ;

        if ($this->getOption4())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"" .
                get_option(WPST_OPTION_SWIMMER_OPTION4_LABEL) . "\"" ;

        if ($this->getOption5())
            $csv .= (($csv != WPST_NULL_STRING) ? "," : "") . "\"" .
                get_option(WPST_OPTION_SWIMMER_OPTION5_LABEL) . "\"" ;

        $csv .= "\r\n" ;

        //  Get all the swimmer ids using the appropriate filter

        $swimmerIds = $swimmer->getAllSwimmerIds($this->getFilter()) ;

        //  Loop through the swimmers

        $this->__recordcount = 0 ;

        foreach ($swimmerIds as $swimmerId)
        {
            $csvRow = "" ;

            $this->__recordcount++ ;

            $swimmer->loadSwimmerById($swimmerId["swimmerid"]) ;

            if ($this->getFirstName())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getFirstName() . "\"" ;

            if ($this->getMiddleName())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getMiddleName() . "\"" ;

            if ($this->getNickName())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getNickName() . "\"" ;

            if ($this->getLastName())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getLastName() . "\"" ;

            if ($this->getBirthDate())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getDateOfBirthAsDate() . "\"" ;

            if ($this->getAge())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getAge() . " (" .
                    $swimmer->getAgeGroupAge() . ")" . "\"" ;

            if ($this->getAgeGroup())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . $swimmer->getAgeGroupText() . "\"" ;

            if ($this->getGender())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . ucfirst($swimmer->getGender()) . "\"" ;

            if ($this->getStatus())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . ucfirst($swimmer->getStatus()) . "\"" ;

            if ($this->getSwimmerLabel())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") .  "\"" .
                $this->getCurrentSwimmerLabel($swimmerId["swimmerid"]) . "\"" ;

            if ($this->getResults())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                    "\"" . ucfirst($swimmer->getResults()) . "\"" ;

            if ($this->getWebSiteId())
            {
                if ($swimmer->getWPUserId() == WPST_NONE)
                {
                     $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . "\"\"" ;
                }
                else
                {
                    $u = get_userdata($swimmer->getWPUserId()) ;
                    $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") . 
                        "\"" . $u->user_login . "\"" ;
                }
            }

            //  Handle the optional fields

            if ($this->getOption1())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") .
                    "\"" . ucfirst($swimmer->getSwimmerOption1()) . "\"" ;

            if ($this->getOption2())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") .
                    "\"" . ucfirst($swimmer->getSwimmerOption2()) . "\"" ;

            if ($this->getOption3())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") .
                    "\"" . ucfirst($swimmer->getSwimmerOption3()) . "\"" ;

            if ($this->getOption4())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") .
                    "\"" . ucfirst($swimmer->getSwimmerOption4()) . "\"" ;

            if ($this->getOption5())
                $csvRow .= (($csvRow != WPST_NULL_STRING) ? "," : "") .
                    "\"" . ucfirst($swimmer->getSwimmerOption5()) . "\"" ;

            //  Add the constructed row to the CSV stream

            $csv .= $csvRow . "\r\n" ;
        }
    }

    /**
     * Write the CSV data to a file which can be sent to the browser
     *
     */
    function generateCSVFile()
    {
        //  Generate a temporary file to hold the data
 
        $this->setCSVFile(tempnam(ABSPATH .
            "/" . get_option('upload_path'), "CSV")) ;

        $this->setCSVFile(tempnam('', "CSV")) ;

        //  Write the CSV data to the file

        $f = fopen($this->getCSVFile(), "w") ;
        fwrite($f, $this->__csvData) ;
        fclose($f) ;
    }
}
?>
