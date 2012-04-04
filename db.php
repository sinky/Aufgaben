<?php 
/*

Single Record
	
require_once("database.php");
$db = new Database();
$db->connect($Host, $Database, $User, $Password); 
$sql = "SELECT * FROM tbl_user WHERE userId='1' ";
$db->query($sql);
$db->singleRecord(); //call this if the query will only return a single row
echo $db->Record['userId']; // use the field name for example or;
echo $db->Record[0]; //use indexes


Multiple Records
 
require_once("database.php");
$db = new Database();
$db->connect($Host, $Database, $User, $Password);
$sql = "SELECT * FROM tbl_user WHERE ";
$db->query($sql);
while($db->nextRecord()){
echo $db->Record['userId'];
}//will output all rows with the field of userId returned by the query

Other Functions	
$db->lastId(); // Returns the primary key of the last inserted record 
$db->numRows(); //Returns the number of rows in a recordset 
$db->numFields(); //Returns the number of fields in a recordset 
$db->mysql_escape_mimic($string); // Returns escaped string


http://kjventura.com/2011/11/kickass-php-database-class-for-simple-web-apps/

*/
class Database
    {

    var $Link_ID  = 0;                  // Result of mysql_connect().
    var $Query_ID = 0;                  // Result of most recent mysql_query().
    var $Record   = array();            // current mysql_fetch_array()-result.
    var $Row;                           // current row number.
    var $LoginError = "";
 
    var $Errno    = 0;                  // error state of query...
    var $Error    = "";
 
//-------------------------------------------
//    Connects to the database
//-------------------------------------------
    function connect($Host, $Database, $User, $Password)
        {
        if( 0 == $this->Link_ID )
            $this->Link_ID=mysql_connect( $Host, $User, $Password );
        if( !$this->Link_ID )
            $this->halt( "Link-ID == false, connect failed" );
        if( !mysql_query( sprintf( "use %s", $Database ), $this->Link_ID ) )
            $this->halt( "cannot use database ".$this->Database );
        } // end function connect
 
//-------------------------------------------
//    Queries the database
//-------------------------------------------
    function query( $Query_String )
        {
        //$this->connect();
        $this->Query_ID = mysql_query( $Query_String,$this->Link_ID );
        $this->Row = 0;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        if( !$this->Query_ID )
            $this->halt( "Invalid SQL: ".$Query_String );
        //return $this->Query_ID;
        return mysql_insert_id();
        } // end function query
 
//-------------------------------------------
//    If error, halts the program
//-------------------------------------------
    function halt( $msg )
        {
        printf( "
<strong>Database error:</strong> %s
n", $msg );
        printf( "<strong>MySQL Error</strong>: %s (%s)
n", $this->Errno, $this->Error );
        die( "Session halted." );
        } // end function halt
 
//-------------------------------------------
//    Retrieves the next record in a recordset
//-------------------------------------------
    function nextRecord()
        {
        @ $this->Record = mysql_fetch_array( $this->Query_ID );
        $this->Row += 1;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        $stat = is_array( $this->Record );
        if( !$stat )
            {
            @ mysql_free_result( $this->Query_ID );
            $this->Query_ID = 0;
            }
        return $stat;
        } // end function nextRecord
 
//-------------------------------------------
//    Retrieves a single record
//-------------------------------------------
    function singleRecord()
        {
        $this->Record = mysql_fetch_array( $this->Query_ID );
        $stat = is_array( $this->Record );
        return $stat;
        } // end function singleRecord
 
//-------------------------------------------
//    Returns the number of rows  in a recordset
//-------------------------------------------
    function numRows()
        {
        return mysql_num_rows( $this->Query_ID );
        } // end function numRows
 
//-------------------------------------------
//    Returns the Last Insert Id
//-------------------------------------------
    function lastId()
        {
        return mysql_insert_id();
        } // end function numRows
 
//-------------------------------------------
//    Returns Escaped string
//-------------------------------------------
    function mysql_escape_mimic($inp)
        {
        if(is_array($inp))
            return array_map(__METHOD__, $inp);
        if(!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }
        return $inp;
        }
//-------------------------------------------
//    Returns the number of rows  in a recordset
//-------------------------------------------
    function affectedRows()
        {
            return mysql_affected_rows();
        } // end function numRows
 
//-------------------------------------------
//    Returns the number of fields in a recordset
//-------------------------------------------
    function numFields()
        {
            return mysql_num_fields($this->Query_ID);
        } // end function numRows
 
    } // end class Database
/* From: kjventura.com */