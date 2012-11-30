<?php
/**
 * DB creating
 *
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: PHPTemplates
 * @subpackage: build
 */

$pkgName = 'phptemplates';

if ($object->xpdo) {
    $modx =& $object->xpdo;
    $modelPath = $modx->getOption($pkgName.'.core_path',null,$modx->getOption('core_path').'components/'.$pkgName.'/').'model/';

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:

            if ($modx instanceof modX) {
                $modx->addExtensionPackage($pkgName, '[[++core_path]]components/'.$pkgName.'/model/');
                $modx->log(xPDO::LOG_LEVEL_INFO, 'Adding ext package');
            } 
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            if ($modx instanceof modX) {
                $modx->removeExtensionPackage($pkgName);
            }
            break;
    }
}
return true;