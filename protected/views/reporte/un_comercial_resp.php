<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

// *********** traducciones y modificaciones de fechas a letras y a español ***********
$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

/*inicio configuración array de datos*/

$query ="SELECT DISTINCT [I_ID_ITEM], [I_DESCRIPCION], [I_INVENTARIO], [I_UNIDAD_NEGOCIO] FROM [TH_ITEMS] WHERE I_CIA = 2";

//EXCEL

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'INVENTARIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'UNIDAD DE NEGOCIO');


$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $I_ID_ITEM = $reg1 ['I_ID_ITEM']; 
    $I_DESCRIPCION = $reg1 ['I_DESCRIPCION']; 
    $I_INVENTARIO = $reg1 ['I_INVENTARIO'];
    $I_UNIDAD_NEGOCIO = $reg1 ['I_UNIDAD_NEGOCIO'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $I_ID_ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $I_DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $I_INVENTARIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $I_UNIDAD_NEGOCIO);

    $Fila = $Fila + 1; 
      
  }
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

$n = 'UN_Comercial_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
