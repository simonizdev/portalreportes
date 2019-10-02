<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte

$cons_inicial = $model['cons_inicial'];
$cons_final = $model['cons_final'];

/*inicio configuración array de datos*/

$query ="SET NOCOUNT ON EXEC [dbo].[COM_NOTAS_APL_FACT] 
@CONSINICIAL = N'".$cons_inicial."',
@CONSFINAL = N'".$cons_final."'
";

//echo $query;die;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Nit');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Motivo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Nota');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Factura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Vlr. nota');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Vlr. factura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Vlr. aplicado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Usuario que creo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Fecha de creación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Cantidad');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Precio unitario');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Vlr. bruto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Vlr. descuento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Vlr. impuesto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Vlr. neto');

$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$Fila = 2;

foreach ($q1 as $data) {
    
    $NIT = $data['NIT']; 
    $CLIENTE = $data['CLIENTE']; 
    $MOTIVO = $data['MOTIVO'];
    $NOTA = $data['NOTA']; 
    $FACTURA = $data['FACTURA']; 
    $VALOR_NOTA = $data['VALOR_NOTA'];
    $VALOR_FACTURA = $data['VALOR_FACTURA']; 
    $VALOR_APLICADO = $data['VALOR_APLICADO'];
    $USUARIO_CREACION = $data['USUARIO_CREACION'];
    $FECHA_CREACION = $data['FECHA_CREACION']; 
    $ITEM = $data['ITEM']; 
    $CANTIDAD = $data['CANTIDAD'];
    $PRECIO_UNITARIO = $data['PRECIO_UNITARIO'];
    $VLR_BRUTO = $data['VLR_BRUTO'];
    $VLR_DESCUENTO = $data['VLR_DESCUENTO'];
    $VLR_IMPUESTO = $data['VLR_IMPUESTO'];
    $VLR_NETO = $data['VLR_NETO'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $NIT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $CLIENTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $MOTIVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $NOTA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $FACTURA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VALOR_NOTA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VALOR_FACTURA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VALOR_APLICADO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $USUARIO_CREACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $FECHA_CREACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $CANTIDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $PRECIO_UNITARIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $VLR_BRUTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $VLR_DESCUENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $VLR_IMPUESTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $VLR_NETO);

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

$n = 'Notas_aplic_fact_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
