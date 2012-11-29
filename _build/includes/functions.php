<?php
/**
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: PHPTemplates
 * @subpackage: build
 */
function getSnippetContent($filename){
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}