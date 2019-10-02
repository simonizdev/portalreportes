<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="EXEC [dbo].[COM_CONS_UN]";

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
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Descripción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Código de inventario');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'UN de inventario');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Código de criterio');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'UN de criterio');

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $item        = $reg1 ['ITEM']; 
    $desc        = $reg1 ['DESCRIPCION']; 
    $cod_inv     = $reg1 ['COD_INVENTARIO'];
    $un_inv      = $reg1 ['UN_INVENTARIO'];
    $cod_cri     = $reg1 ['COD_CRITERIO'];
    $un_cri      = $reg1 ['UN_CRITERIO'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $item);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $desc);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$Fila, $cod_inv,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $un_inv);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$Fila, $cod_cri,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $un_cri);
        
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

$n = 'Consulta_diferencias_un_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











