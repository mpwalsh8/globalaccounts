<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * User classes.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage User
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("users.include.php") ;
require_once("globalaccounts.include.php") ;
require_once("db.class.php") ;
require_once("table.class.php") ;
require_once("widgets.class.php") ;

/**
 * Class definition of the agegroups
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsUser extends GlobalAccountsDBI
{
    /**
     * user id property
     */
    var $__userid ;

    /**
     * wp user id property
     */
    var $__wpuserid ;

    /**
     * street1 property - street address field 1
     */
    var $__street1 ;

    /**
     * street2 property - street address field 2
     */
    var $__street2 ;

    /**
     * street3 property - street address field 3
     */
    var $__street3 ;

    /**
     * city property
     */
    var $__city ;

    /**
     * stateorprovince property
     */
    var $__stateorprovince ;

    /**
     * postal code property
     */
    var $__postalcode ;

    /**
     * country property
     */
    var $__country ;

    /**
     * primary phone property
     */
    var $__primaryphone ;

    /**
     * secondary phone property
     */
    var $__secondaryphone ;

    /**
     * gender property
     */
    var $__gender ;

    /**
     * date of birth property
     */
    var $__birthday ;

    /**
     * option property #1
     */
    var $__option1 ;

    /**
     * option property #2
     */
    var $__option2 ;

    /**
     * option property #3
     */
    var $__option3 ;

    /**
     * option property #4
     */
    var $__option4 ;

    /**
     * option property #5
     */
    var $__option5 ;

    /**
     * dress shirt size property
     */
    var $__dressshirtsize ;

    /**
     * polo shirt size property
     */
    var $__poloshirtsize ;

    /**
     * tee shirt size property
     */
    var $__teeshirtsize ;

    /**
     * jacket size property
     */
    var $__jacketsize ;

    /**
     * sweater size property
     */
    var $__sweatersize ;

    /**
     * user profile record - used when reading data from database
     */
    var $__userRecord ;

    /**
     * Set the user id
     *
     * @param - string - user id
     */
    function setUserId($userid)
    {
        $this->__userid = $userid ;
    }

    /**
     * Get the user id
     *
     * @return - string - user id
     */
    function getUserId()
    {
        return ($this->__userid) ;
    }

    /**
     * Set the wpuserid
     *
     * @param - string - wpuserid
     */
    function setWpUserId($wpuserid)
    {
        $this->__wpuserid = $wpuserid ;
    }

    /**
     * Get the wpuserid
     *
     * @return - string - wpuserid
     */
    function getWpUserId()
    {
        return ($this->__wpuserid) ;
    }

    /**
     * Set the street1 property
     *
     * @param - string - street address 1
     */
    function setStreet1($street1)
    {
        $this->__street1 = $street1 ;
    }

    /**
     * Get the street1 property
     *
     * @return - string - street address 1
     */
    function getStreet1()
    {
        return ($this->__street1) ;
    }

    /**
     * Set the street2 property
     *
     * @param - string - street address 2
     */
    function setStreet2($street2)
    {
        $this->__street2 = $street2 ;
    }

    /**
     * Get the street2 property
     *
     * @return - string - street address 2
     */
    function getStreet2()
    {
        return ($this->__street2) ;
    }

    /**
     * Set the street3 property
     *
     * @param - string - street address 3
     */
    function setStreet3($street3)
    {
        $this->__street3 = $street3 ;
    }

    /**
     * Get the street3 property
     *
     * @return - string - street address 3
     */
    function getStreet3()
    {
        return ($this->__street3) ;
    }

    /**
     * Set the city property
     *
     * @param - string - city
     */
    function setCity($city)
    {
        $this->__city = $city ;
    }

    /**
     * Get the city property
     *
     * @return - string - city
     */
    function getCity()
    {
        return ($this->__city) ;
    }

    /**
     * Set the stateorprovince property
     *
     * @param - string - stateorprovince
     */
    function setStateOrProvince($stateorprovince)
    {
        $this->__stateorprovince = $stateorprovince ;
    }

    /**
     * Get the stateorprovince property
     *
     * @return - string - stateorprovince
     */
    function getStateOrProvince()
    {
        return ($this->__stateorprovince) ;
    }

    /**
     * Set the postal code property
     *
     * @param - string - postal code
     */
    function setPostalCode($postalcode)
    {
        $this->__postalcode = $postalcode ;
    }

    /**
     * Get the postal code property
     *
     * @return - string - postal code
     */
    function getPostalCode()
    {
        return ($this->__postalcode) ;
    }

    /**
     * Set the country property
     *
     * @param - string - country
     */
    function setCountry($country)
    {
        $this->__country = $country ;
    }

    /**
     * Get the country property
     *
     * @return - string - country
     */
    function getCountry()
    {
        return ($this->__country) ;
    }

    /**
     * Set the primary phone property
     *
     * @param - string - primary phone
     */
    function setPrimaryPhone($p)
    {
        $this->__primaryphone = $p;
    }

    /**
     * Get the primary phone property
     *
     * @return - string - primary phone
     */
    function getPrimaryPhone()
    {
        return ($this->__primaryphone) ;
    }

    /**
     * Set the secondary phone property
     *
     * @param - string - secondary phone
     */
    function setSecondaryPhone($p)
    {
        $this->__secondaryphone = $p;
    }

    /**
     * Get the secondary phone property
     *
     * @return - string - secondary phone
     */
    function getSecondaryPhone()
    {
        return ($this->__secondaryphone) ;
    }

    /**
     * Set the gender property
     *
     * @param - string - gender
     */
    function setGender($g)
    {
        $this->__gender = $g;
    }

    /**
     * Get the gender property
     *
     * @return - string - gender
     */
    function getGender()
    {
        return ($this->__gender) ;
    }

    /**
     * Set the date of birth
     *
     * @param - array - start of season date
     */
    function setBirthDay($dob)
    {
        $this->__dateOfBirth = $dob ;
    }

    /**
     * Set the date of birth
     *
     * @param - array - start of season date
     */
    function setBirthDayAsDate($dob)
    {
        //  strtotime() can't deal with years earlier than 1970 on Windows!
 
        //$this->__dateOfBirth = array("year" => date("Y", strtotime($dob)),
        //   "month" => date("m", strtotime($dob)), "day" => date("d", strtotime($dob))) ;

        $d = explode("-", $dob) ;
        $this->__dateOfBirth = array("year" => $d[0], "month" => $d[1], "day" => $d[2]) ;
    }

    /**
     * Get the date of birth
     *
     * @return - array - start of season date as an array
     */
    function getBirthDay()
    {
        return ($this->__dateOfBirth) ;
    }

    /**
     * Get the date of birth
     *
     * @return - string - start of season date as a string
     */
    function getBirthDayAsDate()
    {
        $d = &$this->__dateOfBirth ;

        return sprintf("%04s-%02s-%02s", $d["year"], $d["month"], $d["day"]) ;
    }

    /**
     * Set the option1 property
     *
     * @param - string - option1
     */
    function setUserOption1($o)
    {
        $this->__option1 = $o ;
    }

    /**
     * Get the option1 property
     *
     * @return - string - option1
     */
    function getUserOption1()
    {
        return ($this->__option1) ;
    }

    /**
     * Set the option2 property
     *
     * @param - string - option2
     */
    function setUserOption2($o)
    {
        $this->__option2 = $o ;
    }

    /**
     * Get the option2 property
     *
     * @return - string - option2
     */
    function getUserOption2()
    {
        return ($this->__option2) ;
    }

    /**
     * Set the option3 property
     *
     * @param - string - option3
     */
    function setUserOption3($o)
    {
        $this->__option3 = $o ;
    }

    /**
     * Get the option3 property
     *
     * @return - string - option3
     */
    function getUserOption3()
    {
        return ($this->__option3) ;
    }

    /**
     * Set the option4 property
     *
     * @param - string - option4
     */
    function setUserOption4($o)
    {
        $this->__option4 = $o ;
    }

    /**
     * Get the option4 property
     *
     * @return - string - option4
     */
    function getUserOption4()
    {
        return ($this->__option4) ;
    }

    /**
     * Set the option5 property
     *
     * @param - string - option5
     */
    function setUserOption5($o)
    {
        $this->__option5 = $o ;
    }

    /**
     * Get the option5 property
     *
     * @return - string - option5
     */
    function getUserOption5()
    {
        return ($this->__option5) ;
    }

    /**
     * Set the dress shirt size property
     *
     * @param - string - dress shirt size
     */
    function setDressShirtSize($s)
    {
        $this->__dressshirtsize = $s ;
    }

    /**
     * Get the dress shirt size property
     *
     * @return - string - dress shirt size
     */
    function getDressShirtSize()
    {
        return ($this->__dressshirtsize) ;
    }

    /**
     * Set the polo shirt size property
     *
     * @param - string - polo shirt size
     */
    function setPoloShirtSize($s)
    {
        $this->__poloshirtsize = $s ;
    }

    /**
     * Get the polo shirt size property
     *
     * @return - string - polo shirt size
     */
    function getPoloShirtSize()
    {
        return ($this->__poloshirtsize) ;
    }

    /**
     * Set the tee shirt size property
     *
     * @param - string - tee shirt size
     */
    function setTeeShirtSize($s)
    {
        $this->__teeshirtsize = $s ;
    }

    /**
     * Get the tee shirt size property
     *
     * @return - string - tee shirt size
     */
    function getTeeShirtSize()
    {
        return ($this->__teeshirtsize) ;
    }

    /**
     * Set the jacket size property
     *
     * @param - string - jacket size
     */
    function setJacketSize($s)
    {
        $this->__jacketsize = $s ;
    }

    /**
     * Get the jacket size property
     *
     * @return - string - jacket size
     */
    function getJacketSize()
    {
        return ($this->__jacketsize) ;
    }

    /**
     * Set the sweater size property
     *
     * @param - string - sweater size
     */
    function setSweaterSize($s)
    {
        $this->__sweatersize = $s ;
    }

    /**
     * Get the sweater size property
     *
     * @return - string - sweater size
     */
    function getSweaterSize()
    {
        return ($this->__sweatersize) ;
    }

    /**
     * check if a record already exists
     * by unique id in the user profile table
     *
     * @return boolean - true if it exists, false otherwise
     */
    function userExistsByUserId($userid = null)
    {
        if (is_null($userid)) $userid = $this->getUserId() ;

        $query = sprintf("SELECT id FROM %s WHERE id=\"%s\"",
            WPGA_USERS_TABLE, $userid) ;

        $this->setQuery($query) ;
        $this->runSelectQuery(false) ;

        return (bool)($this->getQueryCount()) ;
    }

    /**
     * check if a record already exists
     * by WP user id in the user profile table
     *
     * @return boolean - true if it exists, false otherwise
     */
    function userExistsByWpUserId($wpuserid = null)
    {
        if (is_null($wpuserid)) $wpuserid = $this->getWpUserId() ;

        $query = sprintf("SELECT userid FROM %s WHERE userid=\"%s\"",
            WPGA_USERS_TABLE, $wpuserid) ;

        $this->setQuery($query) ;
        $this->runSelectQuery(false) ;

        return (bool)($this->getQueryCount()) ;
    }

    /**
     * load a user profile record by the wpuserid
     *
     * @param - integer - option user id
     */
    function loadUserByWpUserId($wpuserid = null)
    {
        if (is_null($wpuserid)) $wpuserid = $this->getWpUserId() ;

        if (is_null($wpuserid))
			die(sprintf("%s(%s):  %s", basename(__FILE__), __LINE__, "Null Id")) ;
        $query = sprintf("SELECT * FROM %s WHERE userid = \"%s\"",
            WPGA_USERS_TABLE, $wpuserid) ;

        $this->setQuery($query) ;
        $this->runSelectQuery() ;

        //  Make sure we only selected one record

        if ($this->getQueryCount() == 1)
        {
            $this->__userRecord = $this->getQueryResult() ;

            //  Short cut to save typing ... 

            $u = &$this->__userRecord ;

            $this->setUserId($u['id']) ;
            $this->setWpUserId($u['userid']) ;
            $this->setStreet1($u['street1']) ;
            $this->setStreet2($u['street2']) ;
            $this->setStreet3($u['street3']) ;
            $this->setCity($u['city']) ;
            $this->setStateOrProvince($u['stateorprovince']) ;
            $this->setPostalCode($u['postalcode']) ;
            $this->setCountry($u['country']) ;
            $this->setPrimaryPhone($u['primaryphone']) ;
            $this->setSecondaryPhone($u['secondaryphone']) ;
            $this->setGender($u['gender']) ;
            $this->setBirthDayAsDate($u['birthday']) ;
            $this->setUserOption1($u['option1']) ;
            $this->setUserOption2($u['option2']) ;
            $this->setUserOption3($u['option3']) ;
            $this->setUserOption4($u['option4']) ;
            $this->setUserOption5($u['option5']) ;
            $this->setDressShirtSize($u['dressshirtsize']) ;
            $this->setPoloShirtSize($u['poloshirtsize']) ;
            $this->setTeeShirtSize($u['teeshirtsize']) ;
            $this->setJacketSize($u['jacketsize']) ;
            $this->setSweaterSize($u['sweatersize']) ;
        }
        else
        {
            $this->__userRecord = null ;
        }
    }
    /**
     * save a user profile record by the wpuserid
     *
     * @return - integer - insert id
     */
    function saveUser()
    {
        if (is_null($this->getWpUserId()))
			die(sprintf("%s(%s):  %s", basename(__FILE__), __LINE__, "Null Id")) ;
        //  Update or new save?
 
        if ($this->userExistsByWpUserId())
            $query = sprintf("UPDATE %s ", WPGA_USERS_TABLE) ;
        else
            $query = sprintf("INSERT INTO %s ", WPGA_USERS_TABLE) ;

        $query .= sprintf("SET 
            userid=\"%s\",
            street1=\"%s\",
            street2=\"%s\",
            street3=\"%s\",
            city=\"%s\",
            stateorprovince=\"%s\",
            postalcode=\"%s\",
            country=\"%s\",
            primaryphone=\"%s\",
            secondaryphone=\"%s\",
            gender=\"%s\",
            birthday=\"%s\",
            option1=\"%s\", 
            option2=\"%s\",
            option3=\"%s\",
            option4=\"%s\",
            option5=\"%s\",
            dressshirtsize=\"%s\",
            poloshirtsize=\"%s\",
            teeshirtsize=\"%s\",
            jacketsize=\"%s\",
            sweatersize=\"%s\"",
            $this->getWpUserId(),
            $this->getStreet1(),
            $this->getStreet2(),
            $this->getStreet3(),
            $this->getCity(),
            $this->getStateOrProvince(),
            $this->getPostalCode(),
            $this->getCountry(),
            $this->getPrimaryPhone(),
            $this->getSecondaryPhone(),
            $this->getGender(),
            $this->getBirthDayAsDate(),
            $this->getUserOption1(),
            $this->getUserOption2(),
            $this->getUserOption3(),
            $this->getUserOption4(),
            $this->getUserOption5(),
            $this->getDressShirtSize(),
            $this->getPoloShirtSize(),
            $this->getTeeShirtSize(),
            $this->getJacketSize(),
            $this->getSweatersize()) ;

        //  Query is processed differently for INSERT and UPDATE

        if ($this->userExistsByWpUserId())
        {
            $query .= sprintf(" WHERE userid=\"%s\"", $this->getWpUserId()) ;

            $this->setQuery($query) ;
            $this->runUpdateQuery() ;
        }
        else
        {
            $this->setQuery($query) ;
            $this->runInsertQuery() ;
            $this->setUserId($this->getInsertId()) ;
        }
    }
}

/**
 * Extended InfoTable Class for presenting GlobalAccounts
 * information as a table extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsInfoTable
 */
class GlobalAccountsUserProfile extends GlobalAccountsUser
{
    /**
     * Build the location profile as an InfoTable
     *
     * @return GlobalAccountsInfoTable
     * @see InfoTable
     */
    function profileUser($title = null, $width = "700px")
    {
        if (is_null($this->getUserId()))
        {
            $profile = new GlobalAccountsInfoTable("User Profile", $width) ;
            $profile->add_row("No user profile data available.") ;
        }
        else
        {
            $u = get_userdata($this->getWpUserId()) ;

            if (is_null($title)) $title = $u->first_name . " " . $u->last_name ;

            $profile = new GlobalAccountsInfoTable($title, $width) ;

            $profile->set_alt_color_flag(true) ;
            $profile->set_show_cellborders(true) ;

            $profile->add_row("Name", $u->first_name . " " . $u->last_name) ;
            $profile->add_row("Username", $u->user_login) ;

            //$td = html_td(null, null, html_b("Clothing Preferences")) ;
            //$td->set_tag_attributes(array("colspan" => "2", "class" => "contentvertical")) ;
            //$this->add_row($td) ;
            $profile->add_row(html_b("Contact Information"), "&nbsp;") ;

            $address = $this->getStreet1() ;
            if ($this->getStreet2() != "")
                $address .= "<br/>" . $this->getStreet2() ;
            if ($this->getStreet3() != "")
                $address .= "<br/>" . $this->getStreet3() ;

            $address .= "<br/>" . $this->getCity() ;
            $address .= ", " . $this->getStateOrProvince() ;
            $address .= "<br/>" . $this->getPostalCode() ;
            $address .= "<br/>" . $this->getCountry() ;

            $profile->add_row("Address", $address) ;

            $phone = $this->getPrimaryPhone() ;
            if ($this->getSecondaryPhone() != "")
                $phone .= "<br/>" . $this->getSecondaryPhone() ;
            $profile->add_row("Phone", $phone) ;
            $profile->add_row("E-mail", $u->user_email) ;

            $profile->add_row(html_b("Personal"), "&nbsp;") ;

            $profile->add_row("Birthday",
                date("F, d", strtotime($this->getBirthDayAsDate()))) ;

            if (get_option(WPGA_OPTION_USER_OPTION1) != WPGA_DISABLED)
            {
                $label = get_option(WPGA_OPTION_USER_OPTION1_LABEL) ;
                $profile->add_row($label, $this->getUserOption1()) ;
            }

            if (get_option(WPGA_OPTION_USER_OPTION2) != WPGA_DISABLED)
            {
                $label = get_option(WPGA_OPTION_USER_OPTION2_LABEL) ;
                $profile->add_row($label, $this->getUserOption2()) ;
            }

            $profile->add_row(html_b("Clothing Preferences"), "&nbsp;") ;
            $profile->add_row("Dress Shirt Size",
                strtoupper($this->getDressShirtSize())) ;
            $profile->add_row("Polo Shirt Size",
                strtoupper($this->getPoloShirtSize())) ;
            $profile->add_row("Tee Shirt Size",
                strtoupper($this->getTeeShirtSize())) ;
            $profile->add_row("Jacket Size",
                strtoupper($this->getJacketSize())) ;
            $profile->add_row("Sweater Size",
                strtoupper($this->getSweaterSize())) ;
        }

        return $profile ;
    }
}

/**
 * Extended GUIDataList Class for presenting GlobalAccounts
 * information extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGUIDataList
 */
class GlobalAccountsUsersGUIDataList extends GlobalAccountsGUIDataList
{
    /**
     * Property to store the requested action
     */
    var $__action ;

    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "profile" => WPGA_ACTION_PROFILE
        ,"directory" => WPGA_ACTION_DIRECTORY
    ) ;

    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__empty_actions = array(
         "add" => WPGA_USERS_ADD_USER
    ) ;

    /**
     * The constructor
     *
     * @param string - the title of the data list
     * @param string - the overall width
     * @param string - the column to use as the default sorting order
     * @param boolean - sort the default column in reverse order?
     * @param string - columns to query return from database
     * @param string - tables to query from database
     * @param string - where clause for database query
     */
    function GlobalAccountsUsersGUIDataList($title, $width = "100%",
        $default_orderby='', $default_reverseorder=FALSE,
        $columns = WPGA_USERS_DEFAULT_COLUMNS,
        $tables = WPGA_USERS_DEFAULT_TABLES,
        $where_clause = WPGA_USERS_DEFAULT_WHERE_CLAUSE)
    {
        //  Set the properties for this child class
        //$this->setColumns($columns) ;
        //$this->setTables($tables) ;
        //$this->setWhereClause($where_clause) ;

        //  Call the constructor of the parent class
        $this->GlobalAccountsGUIDataList($title, $width,
            $default_orderby, $default_reverseorder,
            $columns, $tables, $where_clause) ;
    }

    /**
     * This method is used to setup the options
	 * for the DataList object's display
	 * Which columns to show, their respective 
	 * source column name, width, etc. etc.
	 *
     * The constructor automatically calls 
	 * this function.
	 *
     */
	function user_setup()
    {
		//add the columns in the display that you want to view.
		//The API is :
		//Title, width, DB column name, field SORTABLE?, field SEARCHABLE?, align
	  	//$this->add_header_item("ID",
	    //     	    "200", "id", SORTABLE, SEARCHABLE, "left") ;

  	  	$this->add_header_item("First Name",
	         	    "200", "firstname", SORTABLE, SEARCHABLE, "left") ;

	  	$this->add_header_item("Last Name",
	         	    "200", "lastname", SORTABLE, SEARCHABLE, "left") ;

	  	$this->add_header_item("Username",
	         	    "200", "username", SORTABLE, SEARCHABLE, "left") ;
        //  Construct the DB query
        $this->_datasource->setup_db_options($this->getColumns(),
            $this->getTables(), $this->getWhereClause()) ;

        //  turn on the 'collapsable' search block.
        //  The word 'Search' in the output will be clickable,
        //  and hide/show the search box.

        $this->_collapsable_search = true ;

        //  lets add an action column of checkboxes,
        //  and allow us to save the checked items between pages.
	    //  Use the last field for the check box action.

        //  The unique item is the second column.

	    $this->add_action_column('radio', 'FIRST', "userid") ;

        //  we have to be in POST mode, or we could run out
        //  of space in the http request with the saved
        //  checkbox items
        
        $this->set_form_method('POST') ;

        //  set the flag to save the checked items
        //  between pages.
        
        $this->save_checked_items(true) ;
	}

    /**
     * This is the basic function for letting us
     * do a mapping between the column name in
     * the header, to the value found in the DataListSource.
     *
     * NOTE: this function can be overridden so that you can
     *       return whatever you want for any given column.  
     *
     * @param array - $row_data - the entire data for the row
     * @param string - $col_name - the name of the column header
     *                             for this row to render.
     * @return mixed - either a HTMLTag object, or raw text.
     */
	function build_column_item($row_data, $col_name)
    {
        //  Need to the user data from the Wordpress user profile
        $u = get_userdata($row_data["userid"]) ;

		switch ($col_name)
        {
                /*
            case "Updated" :
                $obj = strftime("%Y-%m-%d @ %T", (int)$row_data["updated"]) ;
                break ;
                */

            case "First Name" :
                //$obj = get_usermeta($row_data["wpuserid"], 'first_name') ; ;
                $obj = $u->first_name ;
                break ;

            case "Last Name" :
                //$obj = get_usermeta($row_data["wpuserid"], 'last_name') ; ;
                $obj = $u->last_name ;
                break ;

            case "Username" :
                $obj = $u->user_login ;
                break ;

            case "Gender" :
                $obj = __(ucfirst($row_data["gender"])) ;
                break ;

		    default:
			    $obj = DefaultGUIDataList::build_column_item($row_data, $col_name);
			    break;
		}
		return $obj;
    }

    /**
     * Action Bar - build a set of Action Bar buttons
     *
     * @return container - container holding action bar content
     */
    function actionbar_cell()
    {
        //  Add an ActionBar button based on the action the page
        //  was called with.

        $c = container() ;

        foreach($this->__normal_actions as $key => $button)
        {
            //$b = $this->action_button($button, $_SERVER['REQUEST_URI']) ;

            /**
             * The above line is commented out because it doesn't work
             * under Safari.  For some reason Safari doesn't pass the value
             * argument of the submit button via Javascript.  The below line
             * will work as long as the intended target is the same as
             * what is specified in the FORM's action tag.
             */

            $b = $this->action_button($button) ;
            $b->set_tag_attribute("type", "submit") ;
            $c->add($b) ;
        }

        return $c ;
    }

    /**
     * Action Bar - build a set of Action Bar buttons
     *
     * @return container - container holding action bar content
     */
    function empty_datalist_actionbar_cell()
    {
        //  Add an ActionBar button based on the action the page
        //  was called with.

        $c = container() ;

        foreach($this->__empty_actions as $key => $button)
        {
            //$b = $this->action_button($button, $_SERVER['REQUEST_URI']) ;

            /**
             * The above line is commented out because it doesn't work
             * under Safari.  For some reason Safari doesn't pass the value
             * argument of the submit button via Javascript.  The below line
             * will work as long as the intended target is the same as
             * what is specified in the FORM's action tag.
             */

            $b = $this->action_button($button) ;
            $b->set_tag_attribute("type", "submit") ;
            $c->add($b) ;
        }

        return $c ;
    }
}

/**
 * GUIDataList class for performaing administration tasks
 * on the various swimmers.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsUsersGUIDataList
 */
class GlobalAccountsUsersAdminGUIDataList extends GlobalAccountsUsersGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "profile" => WPGA_ACTION_PROFILE
        ,"directory" => WPGA_ACTION_DIRECTORY
        ,"add" => WPGA_ACTION_ADD
        ,"update" => WPGA_ACTION_UPDATE
        ,"delete" => WPGA_ACTION_DELETE
    ) ;

}
?>
