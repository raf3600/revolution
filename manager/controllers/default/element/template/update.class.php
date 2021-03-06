<?php
/**
 * Load update template page
 *
 * @package modx
 * @subpackage manager.controllers
 */
class ElementTemplateUpdateManagerController extends modManagerController {
    public $category;
    public $template;
    public $templateArray;
    public $onTempFormRender = '';
    public $onTempFormPrerender = '';

    /**
     * Check for any permissions or requirements to load page
     * @return bool
     */
    public function checkPermissions() {
        return $this->modx->hasPermission('edit_template');
    }

    /**
     * Register custom CSS/JS for the page
     * @return void
     */
    public function loadCustomCssJs() {
        $mgrUrl = $this->modx->getOption('manager_url',null,MODX_MANAGER_URL);
        $this->addJavascript($mgrUrl.'assets/modext/widgets/core/modx.grid.local.property.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/element/modx.grid.element.properties.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/element/modx.grid.template.tv.js');
        $this->addJavascript($mgrUrl.'assets/modext/widgets/element/modx.panel.template.js');
        $this->addJavascript($mgrUrl.'assets/modext/sections/element/template/update.js');
        $this->addHtml('
        <script type="text/javascript">
        // <![CDATA[
        Ext.onReady(function() {
            MODx.load({
                xtype: "modx-page-template-update"
                ,id: "'.$this->templateArray['id'].'"
                ,record: '.$this->modx->toJSON($this->templateArray).'
            });
        });
        MODx.onTempFormRender = "'.$this->onTempFormRender.'";
        MODx.perm.unlock_element_properties = "'.($this->modx->hasPermission('unlock_element_properties') ? 1 : 0).'";
        // ]]>
        </script>');
    }

    /**
     * Custom logic code here for setting placeholders, etc
     * @param array $scriptProperties
     * @return mixed
     */
    public function process(array $scriptProperties = array()) {
        $placeholders = array();

        /* load template */
        if (empty($scriptProperties['id'])) return $this->failure($this->modx->lexicon('template_err_ns'));
        $this->template = $this->modx->getObject('modTemplate',$scriptProperties['id']);
        if ($this->template == null) return $this->failure($this->modx->lexicon('template_err_nf'));
        if (!$this->template->checkPolicy('view')) return $this->failure($this->modx->lexicon('access_denied'));

        /* get properties */
        $properties = $this->template->get('properties');
        if (!is_array($properties)) $properties = array();

        $data = array();
        foreach ($properties as $property) {
            $data[] = array(
                $property['name'],
                $property['desc'],
                $property['type'],
                $property['options'],
                $property['value'],
                $property['lexicon'],
                false, /* overridden set to false */
                $property['desc_trans'],
            );
        }
        $this->templateArray = $this->template->toArray();
        $this->templateArray['properties'] = $data;

        /* load template into parser */
        $placeholders['template'] = $this->template;

        /* invoke OnTempFormRender event */
        $placeholders['onTempFormRender'] = $this->fireRenderEvent();

        return $placeholders;
    }

    /**
     * Invoke OnTempFormPrerender event
     * @return void
     */
    public function firePreRenderEvents() {
        /* PreRender events inject directly into the HTML, as opposed to the JS-based Render event which injects HTML
        into the panel */
        $this->onTempFormPrerender = $this->modx->invokeEvent('OnTempFormPrerender',array(
            'id' => $this->templateArray['id'],
            'template' => &$this->template,
            'mode' => modSystemEvent::MODE_NEW,
        ));
        if (is_array($this->onTempFormPrerender)) $this->onTempFormPrerender = implode('',$this->onTempFormPrerender);
    }

    /**
     * Invoke OnTempFormRender event
     * @return string
     */
    public function fireRenderEvent() {
        $this->onTempFormRender = $this->modx->invokeEvent('OnTempFormRender',array(
            'id' => $this->templateArray['id'],
            'template' => &$this->template,
            'mode' => modSystemEvent::MODE_NEW,
        ));
        if (is_array($this->onTempFormRender)) $this->onTempFormRender = implode('',$this->onTempFormRender);
        $this->onTempFormRender = str_replace(array('"',"\n","\r"),array('\"','',''),$this->onTempFormRender);
        return $this->onTempFormRender;
    }

    /**
     * Return the pagetitle
     *
     * @return string
     */
    public function getPageTitle() {
        return $this->modx->lexicon('template').': '.$this->templateArray['templatename'];
    }

    /**
     * Return the location of the template file
     * @return string
     */
    public function getTemplateFile() {
        return 'element/template/update.tpl';
    }

    /**
     * Specify the language topics to load
     * @return array
     */
    public function getLanguageTopics() {
        return array('template','category','system_events','propertyset','element');
    }
}