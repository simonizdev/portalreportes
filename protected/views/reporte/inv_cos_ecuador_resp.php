<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="EXEC [dbo].[SP_EC_INVENTARIO_COSTO]";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Referencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Descripción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Desc. corta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Disponible');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Costo');

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){

  $TOTAL_COSTO = 0;

  foreach ($q1 as $reg1) {

    $ITEM             = $reg1 ['ITEM']; 
    $REFERENCIA       = $reg1 ['REFERENCIA']; 
    $DESCRIPCION      = $reg1 ['DESCRIPCION'];
    $DESCRP_CORTA     = $reg1 ['DESCRP_CORTA'];
    $DISPONIBLE       = $reg1 ['DISPONIBLE'];
    $COSTO            = $reg1 ['COSTO'];

    $TOTAL_COSTO = $TOTAL_COSTO + $COSTO;

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $DESCRP_CORTA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $DISPONIBLE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $COSTO);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00'); 

    $Fila = $Fila + 1; 
      
  }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, 'Total costo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $TOTAL_COSTO);
    
  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00'); 
  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':F'.$Fila)->getFont()->setBold(true);

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

$n = 'Consulta_inv_cos_ecuador_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











