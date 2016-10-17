<?php
$directory = '/Applications/MAMP/htdocs/fix_wrcrca/html';
$sd = array_diff(scandir($directory), array('..', '.','.php'));
foreach($sd as $f) {
    $t = file_get_contents($f);
    $t = compress($t);
    file_put_contents($f,$t);
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