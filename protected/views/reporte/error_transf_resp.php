<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte
$fecha = $model['fecha'];

set_time_limit(0);

$FechaM = str_replace("-","",$fecha);


/*inicio configuración array de datos*/

//EXCEL

$query ="
  SET NOCOUNT ON
  EXEC [dbo].[CONF_ERROR_TRANSFERENCIAS]
  @FECHA = N'".$FechaM."'
";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Fecha');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Conector');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Documento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Referencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Error');

$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $Fecha  = $reg1 ['Fecha']; 
    $Conector  = $reg1 ['Conector'];
    $Documento  = $reg1 ['Documento'];
    $Referencia  = $reg1 ['Referencia'];
    $Error  = $reg1 ['Error'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $Fecha);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Conector);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $Documento);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Referencia);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Error);
        
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
  
$n = 'Log_transf_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











