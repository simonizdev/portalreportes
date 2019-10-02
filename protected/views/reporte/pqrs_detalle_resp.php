<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="EXEC [dbo].[CRM_CONS_USUARIO3]";

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CONSECUTIVO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'ESTADO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'N° RECLAMACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'FECHA DE CREACIÓN PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'TIPIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'CASO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'USUARIO EJECUCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'TIPO DE CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'RAZÓN SOCIAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'SUCURSAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'FACTURA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'NIT');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'DIRECCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'PAÍS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'DEPTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'CIUDAD');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'E-MAIL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'TElÉFONO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'TIPO DE SOLUCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'FECHA DE CREACIÓN GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'FECHA DE ACTUALIZACIÓN GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'GESTIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'USUARIO CREACIÓN DE GESTIÓN');

$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $CONSECUTIVO = $reg1 ['CONSECUTIVO']; 
    $ESTADO = $reg1 ['ESTADO']; 
    $NUM_RECLAMACION = $reg1 ['NUM_RECLAMACION'];
    $FECH_CR_PQRS = $reg1 ['FECH_CR_PQRS'];
    $TIPIFICACION = $reg1 ['TIPIFICACION'];
    $CASO = $reg1 ['CASO'];
    $USUARIO_EJECUCION = $reg1 ['USUARIO_EJECUCION'];
    $TIPO_CLIENTE = $reg1 ['TIPO_CLIENTE'];
    $RAZON_SOCIAL = $reg1 ['RAZON_SOCIAL']; 
    $SUCURSAL = $reg1 ['SUCURSAL']; 
    $FACTURA = $reg1 ['FACTURA'];
    $NIT = $reg1 ['NIT'];
    $DIRECCION = $reg1 ['DIRECCION'];
    $PAIS = $reg1 ['PAIS'];
    $DEPTO = $reg1 ['DEPTO'];
    $CIUDAD = $reg1 ['CIUDAD'];
    $EMAIL = $reg1 ['EMAIL']; 
    $TELEFONO = $reg1 ['TELEFONO']; 
    $TIPO_SOLUCION = $reg1 ['TIPO_SOLUCION'];
    $FECH_CR_GESTION = $reg1 ['FECH_CR_GESTION'];
    $FECH_AC_GESTION = $reg1 ['FECH_AC_GESTION'];
    $GESTION = $reg1 ['GESTION'];
    $USUARIO_CREACION_GESTION = $reg1 ['USUARIO_CREACION_GESTION'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $CONSECUTIVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $ESTADO);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$Fila, $NUM_RECLAMACION,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $FECH_CR_PQRS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $TIPIFICACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CASO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $USUARIO_EJECUCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $TIPO_CLIENTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $RAZON_SOCIAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $SUCURSAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $FACTURA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $NIT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $DIRECCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $PAIS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $DEPTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $CIUDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $EMAIL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $TELEFONO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $TIPO_SOLUCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $FECH_CR_GESTION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $FECH_AC_GESTION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $GESTION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $USUARIO_CREACION_GESTION);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':W'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'PQRS_detalle_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
