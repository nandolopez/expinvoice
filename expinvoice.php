<?php
  require_once (dirname(__FILE__).'/PHPExcel/PHPExcel.php');
  require_once (dirname(__FILE__).'/models/Facturas.php');
  if(!defined('_PS_VERSION_')) exit;
	class expinvoice extends Module
	{

		function __construct()
		{
			//Module definition
			$this->name = "expinvoice";
	  		$this->displayName = $this->l("Exportador de Facturas a Excel");
	  		$this->description = $this->l("Exportador de Facturas a Excel");
	  		$this->tab = "administration";
	  		$this->author = "Fernando Lopez";
	  		$this->version = "1.0";
	  		$this->bootstrap = true;
	  		//If uninstall... confirms
	  		$this->confirmUninstall = $this->l('¿Estás seguro de desinstalar el módulo?');
	  		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
	  		$this->need_instance =0;
	  		parent::__construct();
		}

		public function uninstallTab($class_name){
			$id_tab = (int)Tab::getIdFromClassName($class_name);
			$tab = new Tab((int)$id_tab);
			return $tab->delete();
		}

		public function installTab($class_name, $name, $parent=0){
			// Create new admin tab
			$tab = new Tab();
			$tab->id_parent = (int)Tab::getIdFromClassName($parent);
			$tab->name = array();
			foreach (Language::getLanguages(true) as $lang)
				$tab->name[$lang['id_lang']] = $name;
				$tab->class_name = $class_name;
				$tab->module = $this->name;
				$tab->active = 1;
				return $tab->add();
		}

		public function install(){
				//Check if parent have a install's function
			if(!parent::install())
				return false;
				//Build the admintab
			if(!$this->installTab('AdminExpinvoiceExcel' , 'Exportar Facturas'))
				return false;
				//If all success
			return true;
		}

		public function uninstall(){
		if(!parent::uninstall())
			return false;
			$this->uninstallTab('AdminExpinvoiceExcel');
			return true;
		}
	}

?>
