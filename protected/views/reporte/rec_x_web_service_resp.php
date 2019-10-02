<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="
    SELECT  
    Rowid AS Id
    ,Referencia 
    ,Num_Ident AS Numero_Identificacion
    ,Descr_Msj AS Banco
    ,Valor_Pago
    ,convert(nvarchar,f357_fecha_elaboracion,3) AS Fecha_Documento
    ,convert(nvarchar,SUBSTRING(Fech_Pago,1,10),3) AS Fecha_Pago
    FROM Pagos_Inteligentes..T_PSE
    INNER JOIN UnoEE1..t357_co_ingresos_caja ON f357_notas=Referencia AND f357_referencia=Cus
    ORDER BY 1 DESC
";

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
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'N° IDENTIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'BANCO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VLR. PAGO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'FECHA DOCTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'FECHA PAGO');


$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ID                 = $reg1 ['Id']; 
    $REFERENCIA         = $reg1 ['Referencia']; 
    $N_IDENTIFICACION   = $reg1 ['Numero_Identificacion']; 
    $BANCO              = $reg1 ['Banco'];
    $VALOR_PAGO         = $reg1 ['Valor_Pago'];
    $FECHA_DOCUMENTO    = $reg1 ['Fecha_Documento'];
    $FECHA_PAGO         = $reg1 ['Fecha_Pago'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ID);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $N_IDENTIFICACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $BANCO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $VALOR_PAGO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $FECHA_DOCUMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $FECHA_PAGO);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Recaudos_X_Web_Service_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
