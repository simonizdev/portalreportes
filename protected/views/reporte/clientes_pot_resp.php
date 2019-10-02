<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

$dias = $model['dias'];
$plan = $model['plan'];
$opc = $model['opc'];
$criterio = $model['criterio'];

/*if($plan != ""){
  $q_plan= Yii::app()->db->createCommand("SELECT DISTINCT Plan_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = '".$plan."'")->queryRow(); 
  $desc_plan = $q_plan['Plan_Descripcion']; 
}else{
  $desc_plan = "N/A";
}

if($criterio != ""){
  $q_criterio= Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Criterio = '".$criterio."'")->queryRow(); 
  $desc_criterio = $q_criterio['Criterio_Descripcion']; 
}else{
  $desc_criterio = "N/A";
}*/

if($plan != "" && $criterio != ""){
  $o = 1;
}else{
  $o = 2;
}

set_time_limit(0);

//se obtiene la cadena de la fecha actual
$diatxt=date('l');
$dianro=date('d');
$mestxt=date('F');
$anionro=date('Y');
// *********** traducciones y modificaciones de fechas a letras y a español ***********
$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$diaesp=str_replace($ding, $desp, $diatxt);
$mesesp=str_replace($ming, $mesp, $mestxt);

$fecha_act= $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;

$query ="
  SET NOCOUNT ON
  EXEC [dbo].[COM_CONS_CLIEN_POT]
  @OPT = ".$o.",
  @DIAS = ".$dias."
";

/*$query ="
  SET NOCOUNT ON
  EXEC [dbo].[COM_CONS_CLIEN_POT]
  @OPT = ".$o.",
  @DIAS = ".$dias.",
  @PLAN = '".$plan."',
  @CRITERIO = '".$criterio."',
  @COLUMNA = '".$opc."'
";*/

//echo $query;die;

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'NIT');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ID SUCURSAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'DESC. SUCURSAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'CIUDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'DIRECCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'TELÉFONO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'RUTA CRITERIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'RUTA VISITA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'VENDEDOR');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'CUPO TOTAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'CUPO DISP.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'ULT. FACTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'FECHA ULT. FACTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'DIAS ULT. FACTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'PROM. DIAS PAGO');

$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$query1 = Yii::app()->db->createCommand($query)->queryAll();
    
$Fila = 2; 

foreach ($query1 as $reg1) {

  $Cliente_Nit          = $reg1 ['Cliente_Nit'];
  $Cliente_Nombre       = $reg1 ['Cliente_Nombre'];   
  $Id_Sucursal          = $reg1 ['Id_Sucursal']; 
  $Cliente_Sucursal     = $reg1 ['Cliente_Sucursal'];
  $Contacto_Nombre      = $reg1 ['Contacto_Nombre'];
  $Ciudad               = $reg1 ['Ciudad'];
  $Direccion            = $reg1 ['Direccion'];
  $Telefono             = $reg1 ['Telefono']; 
  $Ruta_Criterio        = $reg1 ['Ruta_Criterio'];
  $Ruta_Visita          = $reg1 ['Ruta_Visita'];
  $Vendedor_Nombre      = $reg1 ['Vendedor_Nombre'];
  $Cupo_Total           = $reg1 ['Cupo_Total'];
  $Cupo_Disp            = $reg1 ['Cupo_Disp'];
  $Ult_Factura          = $reg1 ['Ult_Factura'];
  $Fech_Ult_Factura     = $reg1 ['Fech_Ult_Factura'];
  $Dias_Ult_Factura     = $reg1 ['Dias_Ult_Factura']; 
  $Prom_Dias_Pago       = $reg1 ['Prom_Dias_Pago'];

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $Cliente_Nit);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Cliente_Nombre);
  $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('C'.$Fila, $Id_Sucursal,  PHPExcel_Cell_DataType::TYPE_STRING);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Cliente_Sucursal);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Contacto_Nombre);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Ciudad);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Direccion);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Telefono);
  $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('I'.$Fila, $Ruta_Criterio,  PHPExcel_Cell_DataType::TYPE_STRING);
  $objPHPExcel->setActiveSheetIndex()->setCellValueExplicit('J'.$Fila, $Ruta_Visita,  PHPExcel_Cell_DataType::TYPE_STRING);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $Vendedor_Nombre);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $Cupo_Total);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $Cupo_Disp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $Ult_Factura);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $Fech_Ult_Factura);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $Dias_Ult_Factura);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $Prom_Dias_Pago);
      
  $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila.':M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  //$objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  //$objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  $Fila = $Fila + 1;

}

/*fin contenido tabla*/

//se configura el ancho de cada columna en automatico solo funciona en el rango A-Z
foreach($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

    $sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
}

$n = 'Clientes_pot_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











