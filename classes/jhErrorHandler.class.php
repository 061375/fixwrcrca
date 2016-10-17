<?php
class jhErrorHandler
{
    /**
     * Get Error messages
     *
     * @return array
     */
    public static function get_error_message()
    {
        if (count($GLOBALS['jer1024']['errors']) > 0) {
            $tmp = $GLOBALS['jer1024']['errors'];
            $GLOBALS['jer1024']['errors'] = array();
            return $tmp;
        }
        return array();
    }
    // --------------------------------------------------------------------
    /**
     * Set Error messages
     *
     * @return array
     */
    public static function set_error_message($message)
    {
        if ($message != '') {
            $GLOBALS['jer1024']['errors'][] = $message;
        }
    }
	
    // --------------------------------------------------------------------

    /**
     * Has Error
     *
     * @return array
     */
    public static function has_error()
    {
        if (isset($GLOBALS['jer1024']['errors'])) {
            if (count($GLOBALS['jer1024']['errors']) > 0) {
                return true;
            }
        }
        return false;
    }
    // --------------------------------------------------------------------
    /**
     * Clear Error
     *
     * @return array
     */
    public static function clear_error()
    {
        $GLOBALS['jer1024']['errors'] = array();
    }
    /**
     * Gathers errors and converts them to XML to be returned to the user
     *
     * @return void
     */
    public static function display_errors($echo = false,$cmd = false)
    {
        $errors = jhErrorHandler::get_error_message();
        if (false === $echo) {
                $result = array(
                        'success' => 0,
                        'errors' => $errors
                );
                echo json_encode($result);
                die();
        } else {
            foreach( $errors as $row) {
				if (false === $cmd) {
					echo '<p>'.$row.'</p>';
				} else {
					echo $row."\n";
				}
            }
            exit();
        }
    }
    public static function log_errors()
    {
	$error_log = isset($GLOBALS['jer1024']['error_log']) ? $GLOBALS['jer1024']['error_log'] : GEO_ALERT_PATH.'/.jh_errors';
	$errors = jhErrorHandler::get_error_message();
	if(file_exists($error_log)) {
	    $chk = file_get_contents($error_log);
	}else{
	    $chk = '';
	}
	//100000
	if (strlen($chk) > 5000) {
		file_put_contents($error_log.'_'.date('Ymd'),$chk);
		foreach( $errors as $row) {
			file_put_contents($error_log,date('Y-m-d H:i:s').' '.$row."\n",FILE_APPEND);
		}
	}else{
	    foreach( $errors as $row) {
		    file_put_contents($error_log,date('Y-m-d H:i:s').' '.$row."\n",FILE_APPEND);
	    }
	}
    }
}
?>