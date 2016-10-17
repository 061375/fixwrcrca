<?php
/*****************************************************************

*
*	Database.class.php
*	Connects to Deletes, Adds and Edits Data in the database specified
*
*/

class Database
{
	private $errors;
	private $db;
	function __construct( $options )
	{
		$this->errors = new jhErrorHandler();
		$host		= isset($options['host'])	    ? $options['host']      : 'localhost';
		$user		= isset($options['user'])	    ? $options['user']      : '';
		$password	= isset($options['password'])   ? $options['password']	: '';
		$database	= isset($options['database'])	? $options['database']	: '';
		// connect to the server
        try {
            $this->db = new PDO(
                'mysql:host='.$host.';dbname='.$database,
                $user,
                $password
            );
        } catch (PDOException $e) {
            $this->_set_error_message("Unable to select database ".$e->getMessage());
	    $this->errors->display_errors();
        }	
    }
    function Query($s,$v = array(),$flags = false)
    {
        try {
            $q = $this->db->prepare($s);
	    //echo '<pre>';print_r($s );exit();/*REMOVE ME*/
            $q->execute($v);
            if(false !== $flags) {
                $re = array();
                foreach($flags as $flag) {
                    if(false !== method_exists($this,$flag))
                    $re[$flag] = $this->$flag($q);
                }
                return $re;
            }else{
                return $q;
            }
        } catch (PDOException $e) {
            $this->_set_error_message("query error ".$e->getMessage());
			$this->errors->display_errors();
        }
    }
    function lastId($q)
    {
        return $this->db->lastInsertId();
    }
    function FetchAssoc($q)
    {
        return $q->fetchAll();
    }
    function NumRows($q)
    {
        return $q->rowCount();
    }
    function RowsAffected($q)
    {
        return $q->rowCount($q);
    }
    function FetchResult($s,$k,$v = array(),$else = false)
    {
        $result = $this->Query($s,$v,array('FetchAssoc'));
        return isset($result['FetchAssoc'][0][$k]) ? $result['FetchAssoc'][0][$k] : $else;
    }
    function FetchArray($s)
    {
        $return = array();
        if(is_resource($s)) {
            while($row = $this->FetchAssoc($s)) {
                $return[] = $row;
            }
        }
        return $return;
    }
    /**
     * In the event of a catchable error be sure to unlock the database
     * */
    private function _set_error_message($message)
    {
        $this->errors->set_error_message($message);
    }
}
?>