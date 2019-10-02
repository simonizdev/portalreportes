<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="EXEC [dbo].[COM_CONS_VENDEDORES]";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Nit');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Vendedor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Código');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Celular');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Recibo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Ruta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Nombre ruta');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Portafolio');

$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $nit              = $reg1 ['Nit_Vendedor']; 
    $nombre_vendedor  = $reg1 ['Nombre_Vendedor']; 
    $codigo           = $reg1 ['Codigo'];
    $celular          = $reg1 ['Celular'];
    $recibo           = $reg1 ['Recibo'];
    $ruta             = $reg1 ['Ruta'];
    $nombre_ruta      = $reg1 ['Nombre_Ruta'];
    $portafolio       = $reg1 ['Portafolio'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $nit);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $nombre_vendedor);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $codigo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $celular);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $recibo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $ruta);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $nombre_ruta);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $portafolio);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Consulta_vendedores_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











