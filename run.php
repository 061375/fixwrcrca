<?php
/**
 * version 1.0.2
 * live version
 *
 **/
// kill if not using command line
if (php_sapi_name() !== 'cli')die(); // no message

define('TEST',true);

ini_set('display_errors', 1); 
error_reporting(E_ALL);
define('TIME_ZONE','-7');

if(strpos(getcwd(),'MAMP') !== false) {
    // local version for testing
    $ppath = '/Applications/MAMP/htdocs/fix_wrcrca';
    $dbbk = $ppath;
}else{
    // live version
    $ppath = '/var/www/html/fix_wrcrca';
    $dbbk = '/home/tmp/databases/';
}
$cpath = $ppath.'/classes/';


// make a backup of the database

echo shell_exec('mysqldump -u [database] -p[password] -h localhost [database] > '.$dbbk.'[database].sql');



// Include Error Handler and Database Classses
require_once($cpath.'jhErrorHandler.class.php');
require_once($cpath.'Database.class.php');

// Instantiate Database Class
$db = new Database(array(
    'database'=>'[database name]',
    'user'=>'[database]',
    'password'=>'[password]',
    'host'=>'localhost'
));




// this is the list of URL's that need to be replaced
// 0 = old URL
// 1 = new URL
$find_replace = array(
    0=>array(
        'http://wrc-rca.org/agriculture/Agriculture_COI.Doc',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Agriculture/Agriculture_COI.DOC'
    ),
    1=>array(
        'http://wrc-rca.org/2014_SC/140123/140123_Agenda.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140123/140123_Agenda.pdf'
    ),
    2=>array(
        'http://wrc-rca.org/2014_SC/140123/140123_Meeting.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140123/140123_Meeting.pdf'
    ),
    3=>array(
        'http://wrc-rca.org/2014_SC/140123/140123_Minutes.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140123/140123_Minutes.pdf'
    ),
    4=>array(
        'http://wrc-rca.org/2014_SC/140415/140415_Agenda.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140415/140415_AGENDA.pdf'
    ),
    5=>array(
        'http://wrc-rca.org/2014_SC/140415/140415_Meeting.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140415/140415_Meeting.pdf'
    ),
    6=>array(
        'http://wrc-rca.org/2014_SC/140415/april__sc_minutes.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140415/april__sc_minutes.pdf'
    ),
    7=>array(
        'http://wrc-rca.org/2014_SC/140903/09032014_Meeting-Board-Packet.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140903/09032014_Meeting-Board-Packet.pdf'
    ),
    8=>array(
        'http://wrc-rca.org/2014_SC/140903/2014-09-03%20STAKEHOLDERS%20AGENDA.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/2014_SC/140903/2014-09-03%20STAKEHOLDERS%20AGENDA.pdf'
    ),
    9=>array(
        'http://wrc-rca.org/Forms/2009_Revised_PSE_Application_Form.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/2009_Revised_PSE_Application_Form.pdf'
    ),
    10=>array(
        'http://wrc-rca.org/Permit_Docs/Resolutions/Executed_Res_08-002.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Permit_Docs/Resolutions/Executed_Res_08-002.pdf'
    ),
    11=>array(
        'http://wrc-rca.org/Forms/Campaign_Contribution_Disclosure_Form.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/Campaign_Contribution_Disclosure_Form.pdf'
    ),
    12=>array(
        'http://wrc-rca.org/Forms/Public_Records_Request_Form.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/Public_Records_Request_Form.pdf'
    ),
    13=>array(
        'http://wrc-rca.org/Forms/Campaign_Contribution_Disclosure_Form.doc',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/Campaign_Contribution_Disclosure_Form.doc'
    ),
    14=>array(
        'http://wrc-rca.org/Forms/2009_Revised_PSE_Application_form.doc',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/2009_Revised_PSE_Application_Form.doc'
    ),
    15=>array(
        'http://wrc-rca.org/AnnualReport_2008/AppendixB/RCA_2008_AR_Appendix_B_Minor_Amendment_2007-01.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/AnnualReport_2008/AppendixB/RCA_2008_AR_Appendix_B_Minor_Amendment_2007-01.pdf'
    ),
    16=>array(
        'http://wrc-rca.org/Implementation_Manual/Permittee_Implementation_Manual_Aug_2007.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Implementation_Manual/Permittee_Implementation_Manual_Aug_2007.pdf'
    ),
    17=>array(
        'http://wrc-rca.org/permit_docs/2014-06-02_Current%20Bylaws.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Permit_Docs/2014-06-02_Current%20Bylaws.pdf'
    ),
    18=>array(
        'http://wrc-rca.org/agriculture/Agriculture_COI.Doc',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Agriculture/Agriculture_COI.DOC'
    ),
    19=>array(
        'http://wrc-rca.org/Forms/Public_Records_Request_Form.doc',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/Public_Records_Request_Form.doc'
    ),
    20=>array(
        'http://wrc-rca.org/monitoring/Monitoring_program_workplan_2015-16.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2015-16.pdf'
    ),
    21=>array(
        'http://wrc-rca.org/monitoring/Monitoring_program_workplan_2014-15.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2014-15.pdf'
    ),
    22=>array(
        'http://wrc-rca.org/monitoring/Monitoring_program_workplan_2013-14.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2013-14.pdf'
    ),
    23=>array(
        'http://wrc-rca.org/monitoring/Monitoring_program_workplan_2012-13.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2012-13.pdf'
    ),
    24=>array(
        'http://wrc-rca.org/Monitoring/Monitoring_program_workplan_2011-12.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2011-12.pdf'
    ),
    25=>array(
        'http://wrc-rca.org/Monitoring/Monitoring_program_workplan_2010-11.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2010-11.pdf'
    ),
    26=>array(
        'http://wrc-rca.org/Monitoring/monitoring_program_workplan_2009-10.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2009-10.pdf'
    ),
    27=>array(
        'http://wrc-rca.org/monitoring/monitoring_program_workplan_2008-09.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2008-09.pdf'
    ),
    28=>array(
        'http://wrc-rca.org/monitoring/monitoring_program_workplan_2007-08.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2007-08.pdf'
    ),
    29=>array(
        'http://wrc-rca.org/monitoring/monitoring_program_workplan_2006-07.pdf',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Monitoring/MONITORING_PROGRAM_WORKPLAN_2006-07.pdf'
    ),
    30=>array(
        'http://wrc-rca.org/Fees/Instructions_and_Worksheet_for_WRC_MSHCP_Contribution_Roads.xls',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Fees/Instructions_and_Worksheet_for_WRC_MSHCP_Contribution_Roads.xls'
    ),
    31=>array(
        'http://wrc-rca.org/Forms/2009_Revised_PSE_APPLICATION_FORM.doc',
        'http://6de85afa9cdd9250af26-3b22a263ed002c8175a7ed4a05021155.r33.cf1.rackcdn.com/Forms/2009_Revised_PSE_Application_Form.doc'
    )
    
);
// initialize an empty variable to count the database entries that were updated
$fixed = 0;

// loop through all the records to be updated
foreach($find_replace as $fr) {
    $target = $fr[0]; // the old url
    $replace = $fr[1]; // the new url
    
    // get all posts that have the old url from the database
    $sql = "SELECT `ID`,`post_content` FROM `wp_posts` WHERE `post_content` LIKE '%".$target."%'";
    $results = $db->Query($sql,array('FetchAssoc'));
    
    // loop the posts
    foreach($results as $row) {
        // temp place POST into a variable
        $fix = $row['post_content'];
        // replace the old URL with the new one
        $fix = str_replace($target,$replace,$fix);
        // put the updated URL back into the database
        $sql = "UPDATE `wp_posts` SET `post_content` = '".$fix."' WHERE `ID` = ".$row['ID'];
        $db->Query($sql);
        // update the count
        $fixed++;
    }
}
// display the result
die("\nprocess complete...".$fixed." records updated\n");
?>