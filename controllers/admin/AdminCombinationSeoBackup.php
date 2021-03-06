<?php
/**
* 2017 Manuel José Pulgar Anguita
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author    Manuel José Pulgar Anguita <cibermanu@hotmail.com>
*  @copyright 2017 Manuel José Pulgar Anguita
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

/**
 * Tab Metadata - Controller Admin Metadata
 *
 * @category   	Module / frontofficefeatures
 * @author     	Manuel José Pulgar Anguita <cibermanu@hotmail.com>
 * @copyright  	2017 Manuel José Pulgar Anguita
*/


class AdminCombinationSeoBackupController extends ModuleAdminController
{
	public function __construct()
	{
		// $this -> table = 'combinationseometadata';
		// $this -> identifier = 'id'; // identifier in the table where the data is stored (for renderList method)

		$this -> bootstrap = true;
		//$this->display = 'view';
		// $this->show_form_cancel_button = false;

		// $this -> className = 'CombinationSeoBackup'; 
		$this -> lang = true;

		$this -> name = 'CombinationSeoBackup';

		$this->multishop_context = Shop::CONTEXT_SHOP;

		$this -> display = 'backupform';
// $this->bulk_actions = array('delete' => array('text' => $this->trans('Delete selected', array(), 'Modules.cmsseo.Admin'), 'confirm' => $this->trans('Delete selected items?', array(), 'Modules.cmsseo.Admin')));
		$this->context = Context::getContext();


		$this->setTemplate('backupform.tpl');


		parent::__construct();
		
	}


	public function display() {
		parent::display();
		// echo "<h1> This is a test of function display()</h1>";
    }

	public function renderForm()
	{

		// En principio este controlador no va a tener renderform

		return parent::renderForm();
	}


	public function postProcess()
	{
		// if (Tools::isSubmit('submitAdd'.$this->table))
		if (Tools::isSubmit('submitBackup'))
		{
			if (Tools::isSubmit('extracts')) {
				CodeExtract::getXML_Backup_File();
			}
			else if (Tools::isSubmit('combinations')) {
				CodeCombination::getXML_Backup_File();
			}
            else if (Tools::isSubmit('metadata')) {
				CombinationSeoMetaData::getXML_Backup_File();
			}
			else if (Tools::isSubmit('replacements')) {
				CodeReplacement::getXML_Backup_File();
			}
		}
		else if (Tools::isSubmit('submitRestore')){

			$temp_file = $_FILES['combination_file']['tmp_name'];

			if (!empty($temp_file)) {

				if (Tools::isSubmit('extracts')) {
					CodeExtract::saveXML_Restore_File($temp_file);
				}
				else if (Tools::isSubmit('combinations')) {
					CodeCombination::saveXML_Restore_File($temp_file);
				}
				else if (Tools::isSubmit('metadata')) {
					CombinationSeoMetaData::saveXML_Restore_File($temp_file);
				}
				
			}

		}
	}


	public function setMedia()
	{
		parent::setMedia();
		
		$this -> addCSS(_MODULE_DIR_.$this->module->name.'/views/css/backup.css');
		$this -> addJS(_MODULE_DIR_.$this->module->name.'/views/js/backup.js');


	}

}