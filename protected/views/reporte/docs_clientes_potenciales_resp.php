<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="EXEC [dbo].[CRM_CONS_USUARIO2]";

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ID');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'NOMBRE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'NIT');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'RAZÓN SOCIAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'DOCUMENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'CONSECUTIVO');

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ID = $reg1 ['ID']; 
    $NOMBRE = $reg1 ['NOMBRE']; 
    $NIT = $reg1 ['NIT'];
    $RAZON_SOCIAL = $reg1 ['RAZON_SOCIAL'];
    $DOCUMENTO = $reg1 ['DOCUMENTO'];
    $CONSECUTIVO = $reg1 ['CONSECUTIVO'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ID);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $NOMBRE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $NIT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $RAZON_SOCIAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $DOCUMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CONSECUTIVO);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Docs_clientes_potenciales_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
