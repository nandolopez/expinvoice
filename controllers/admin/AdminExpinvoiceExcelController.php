<?php

class AdminExpinvoiceExcelController extends ModuleAdminController
{
  function __construct(){
  		$this->bootstrap=true;
  		parent::__construct();
  	}
    public function initContent(){
		parent::initContent();
		//Comprobando submits
		if(Tools::isSubmit('inicio') && Tools::isSubmit('fin')){
			//Omocoañozamdp varoanñes
			$inicio =str_replace("/","-",Tools::getValue('inicio'));
      $fin =str_replace("/","-",Tools::getValue('fin'));
			$this->generarExcel($inicio,$fin);
		}elseif(Tools::isSubmit('del')){
			unlink(_PS_UPLOAD_DIR_.Tools::getValue('del'));
      $this->addJs(_MODULE_DIR_.$this->module->name.'/views/js/scripts.js');
			$this->addCss(_MODULE_DIR_.$this->module->name.'/views/css/estilo.css');
			$this->setTemplate('Formulario.tpl');
		}else{
			$this->addJs(_MODULE_DIR_.$this->module->name.'/views/js/scripts.js');
			$this->addCss(_MODULE_DIR_.$this->module->name.'/views/css/estilo.css');
			$this->setTemplate('Formulario.tpl');
		}

	}

	public function mostrarDescargar($direccion=null){
		if($direccion!=null)
			$this->context->smarty->assign('fichero',$direccion);

			$this->addCss(_MODULE_DIR_.$this->module->name.'/views/css/estilo.css');
		$this->setTemplate('Descargar.tpl');
	}
	public function generarExcel($inicio,$fin){
			$info = facturas::obtenerFacturas($inicio,$fin);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Comercial Patricia Web");
		$objPHPExcel->getProperties()->setLastModifiedBy("Comercial Patricia Web");
		$objPHPExcel->getProperties()->setTitle("Ultimas Facturas");
		$objPHPExcel->getProperties()->setSubject("Comentario");
		$objPHPExcel->getProperties()->setDescription("Descrpccion");
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Ejercicio");
		$objPHPExcel->getActiveSheet()->SetCellValue('B1','Serie');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', "Num.Factura");
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', "Fecha");
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', "Apellidos y nombre");
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', "dni");
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', "IVA");
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', "IMP.BRUTO");
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'IMP.DESCUENTO');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', "IMP. IVA");
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', "IMP. LIQUIDO");

		for ($i=0; $i < count($info); $i++)
		{
			$n = $i+2;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$n, date('Y'));
  			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n,'W');
  			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$n, $info[$i]['id_order_invoice']);
  			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$n, $info[$i]['date_add']);
  			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$n, $info[$i]['firstname']." ".$info[$i]['lastname']);
  			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$n, $info[$i]['dni']);
  			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$n, 21);
  			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$n, round($info[$i]['total_paid_tax_excl'],2));
  			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$n, '0');
  			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$n, round($info[$i]['total_paid_tax_incl'],2));
  			$objPHPExcel->getActiveSheet()->SetCellValue('k'.$n, round($info[$i]['total_paid_tax_excl'],2));
		}
		$objPHPExcel->getActiveSheet()->setTitle('Libro 1');
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$archivo ="Facturas-".str_replace("/","-",$inicio)."-".str_replace("/","-",$fin).".xls";
		$direccion = _PS_UPLOAD_DIR_.$archivo;
		if(file_exists($direccion))
			unlink($direccion);
		$objWriter->save($direccion);
		$this->mostrarDescargar($archivo);
	}
}

?>
