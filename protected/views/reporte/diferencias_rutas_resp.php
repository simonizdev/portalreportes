<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="EXEC [dbo].[COM_CONS_RUTAS]";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Ruta visita');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Ruta criterio');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Nit');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Sucursal');

$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ruta_visita    = $reg1 ['RUTA_VISITA']; 
    $ruta_criterio  = $reg1 ['RUTA_CRITERIO']; 
    $nit            = $reg1 ['NIT'];
    $cliente        = $reg1 ['CLIENTE'];
    $sucursal       = $reg1 ['SUCURSAL'];

    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$Fila, $ruta_visita,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$Fila, $ruta_criterio,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $nit);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $cliente);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$Fila, $sucursal,  PHPExcel_Cell_DataType::TYPE_STRING);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Consulta_diferencias_rutas_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











