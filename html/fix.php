<?php
$directory = '/Applications/MAMP/htdocs/fix_wrcrca/html';
$sd = array_diff(scandir($directory), array('..', '.','fix.php'));
foreach($sd as $f) {
    if($f == 'fix.php')continue;
    $t = file_get_contents($f);
    $t = compress(replace($t));
    file_put_contents($f,$t);
}
function replace($f)
{
    $find_replace = array(
        array(
              'href="style.css"',
              'href="/css/style.css"'
        ),
        array(
              "HREF='style.css'",
              'href="/css/style.css"'
        ),
        array(
            '../../webimages/rca_logo_09092008.jpg',
            'http://wrc-rca.org/wp-content/uploads/wrcalogo.png'
        ),
        array(
            '.../images/RCA_Logo.jpg',
            'http://wrc-rca.org/wp-content/uploads/wrcalogo.png'
        ),
        array(
            '../images/RCA_Logo.jpg',
            'http://wrc-rca.org/wp-content/uploads/wrcalogo.png'
        )
    );
    foreach($find_replace as $row) {
        $f = str_replace($row[0],$row[1],$f);
    }
    return $f;
}
/**
 * Strips line breaks, white space and comments
 * 
 * @param string $in
 *
 * @return string
 * */
function compress($in)
{
    $out = str_replace("\n",'',$in);
    $out = str_replace("\t",'',$out);
    $out = str_replace("\r",'',$out);
    $out = preg_replace('!\s+!', ' ', $out);
    $out = preg_replace('/<!--(.*)-->/Uis', '', $out);
    return $out;
}