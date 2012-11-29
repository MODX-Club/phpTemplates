<?php
/**
 * Author: proxyfabio
 * Date: 29.11.12
 *
 * @package: PHPTemplates
 * @subpackage: build
 */

class PhpTemplateCreateManagerController extends ResourceCreateManagerController {
    /**
     * Returns language topics
     * @return array
     */
    public function getLanguageTopics() {
        return array('resource','phptemplates:default');
    }


    /**
     * Check for any permissions or requirements to load page
     * @return bool
     */
    public function checkPermissions() {
        return $this->modx->hasPermission('new_document');
    }

    /**
     * Register custom CSS/JS for the page
     * @return void
     */
    public function loadCustomCssJs() {
        $mgrUrl = $this->modx->getOption('manager_url',null,MODX_MANAGER_URL);

        $ticketsAssetsUrl = $this->modx->getOption('phptemplates.assets_url',null,$this->modx->getOption('assets_url',null,MODX_ASSETS_URL).'components/phptemplates/');
        $connectorUrl = $ticketsAssetsUrl.'connector.php';
        $ticketsJsUrl = $ticketsAssetsUrl.'js/mgr/';

        $this->addJavascript($mgrUrl.'assets/modext/util/datetime.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/element/modx.panel.tv.renders.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/resource/modx.grid.resource.security.local.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/resource/modx.panel.resource.tv.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/resource/modx.panel.resource.js');
        $this->addJavascript($mgrUrl.'assets/modext/sections/resource/create.js');
        $this->addJavascript($ticketsJsUrl.'tickets.js');
        $this->addJavascript($ticketsJsUrl.'section/section.common.js');
        $this->addLastJavascript($ticketsJsUrl.'section/create.js');
        $this->addHtml('
		<script type="text/javascript">
		// <![CDATA[
		Tickets.assets_url = "'.$ticketsAssetsUrl.'";
		Tickets.connector_url = "'.$connectorUrl.'";
		MODx.config.publish_document = "'.$this->canPublish.'";
		MODx.onDocFormRender = "'.$this->onDocFormRender.'";
		MODx.ctx = "'.$this->ctx.'";
		Ext.onReady(function() {
			MODx.load({
				xtype: "tickets-page-section-create"
				,record: '.$this->modx->toJSON($this->resourceArray).'
				,publish_document: "'.$this->canPublish.'"
				,canSave: "'.($this->modx->hasPermission('save_document') ? 1 : 0).'"
				,show_tvs: '.(!empty($this->tvCounts) ? 1 : 0).'
				,mode: "create"
			});
		});
		// ]]>
		</script>');
        /* load RTE */
        $this->loadRichTextEditor();
    }

}
