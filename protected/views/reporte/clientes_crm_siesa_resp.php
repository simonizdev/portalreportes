<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="EXEC [dbo].[CRM_CONS_USUARIO1]";

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'FECHA DE CREACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'NÚMERO WEB');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'MEDIO CAPTACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'NIT SIESA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VENTAS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'CLIENTE ERP');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'RAZÓN SOCIAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'CONTACTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'CIUDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'DEPTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'PAÍS');


$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $FECHA_CREACION = $reg1 ['FECHA_CREACION']; 
    $NUMERO_WEB = $reg1 ['NUMERO_WEB']; 
    $MEDIO_CAPTACION = $reg1 ['MEDIO_CAPTACION'];
    $NIT_SIESA = $reg1 ['NIT_SIESA'];
    $VENTAS = $reg1 ['VENTAS'];
    $CLIENTE_ERP = $reg1 ['CLIENTE_ERP'];
    $RAZON_SOCIAL = $reg1 ['RAZON_SOCIAL']; 
    $CONTACTO = $reg1 ['CONTACTO'];
    $CIUDAD = $reg1 ['CIUDAD'];
    $DEPARTAMENTO = $reg1 ['DEPARTAMENTO'];
    $PAIS = $reg1 ['PAIS'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $FECHA_CREACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $NUMERO_WEB);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $MEDIO_CAPTACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $NIT_SIESA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $VENTAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CLIENTE_ERP);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $RAZON_SOCIAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $CONTACTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $CIUDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $DEPARTAMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $PAIS);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Clientes_CRM_Siesa_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
