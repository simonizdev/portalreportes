<?php
/* @var $this ReporteController */
/* @var $model Reporte */

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

/*inicio configuración array de datos*/

$query ="SET NOCOUNT ON EXEC [dbo].[FIN_PED_RET]";

$query1 = Yii::app()->db->createCommand($query)->queryAll();

//EXCEL

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Estructura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Regional');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Vendedor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Nit');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Ruta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Docto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha retenido');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Calificación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Retenido cupo ?');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Retenido mora ?');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Vlr. neto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Cupo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Saldo cartera');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Max. mora');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Saldo mora');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Saldo favor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Cupo adicional');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'C - P');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Liberar');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'PQRS');

$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$Fila = 2; 

foreach ($query1 as $reg) {

	$estructura = $reg['Estructura'];
	$regional = $reg['Regional'];
	$vendedor = $reg['Vendedor'];
	$nit = $reg['Nit'];
	$cliente = $reg['Cliente'];
	$ruta = $reg['Ruta'];
	$docto = $reg['Docto'];
	$fecha_retenido = $reg['Fecha_Retenido'];
	$calificacion = $reg['Calificacion'];
	$retenido_cupo = $reg['Retenido_Cupo'];
	$retenido_mora = $reg['Retenido_Mora'];
	$vlr_neto = $reg['VNeto'];
	$cupo = $reg['Cupo'];
	$saldo_cartera = $reg['Saldo_Cartera'];
	$max_mora = $reg['Max_Mora'];
	$saldo_mora = $reg['Saldo_Mora'];
	$saldo_favor = $reg['Saldo_Favor'];
	$cupo_adicional = $reg['Cupo_adicional'];
	$c_p = $reg['C_P'];
	$liberar = $reg['Liberar'];
	$pqrs = $reg['PQRS'];

	$objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $estructura);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $regional);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $vendedor);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $nit);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $cliente);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $ruta);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $docto);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $fecha_retenido);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $calificacion);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $retenido_cupo);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $retenido_mora);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $vlr_neto);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $cupo);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $saldo_cartera);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $max_mora);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $saldo_mora);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $saldo_favor);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $cupo_adicional);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $c_p);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $liberar);
	$objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $pqrs);


	$objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$Fila.':S'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$Fila.':N'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('O'.$Fila)->getNumberFormat()->setFormatCode('0');
	$objPHPExcel->getActiveSheet()->getStyle('P'.$Fila.':S'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
	$objPHPExcel->getActiveSheet()->getStyle('T'.$Fila.':U'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);   

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

$n = 'Pedidos_retenidos_'.date('Y_m_d_H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>