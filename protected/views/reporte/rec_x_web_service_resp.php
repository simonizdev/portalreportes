<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];

//opcion: 1. PDF, 2. EXCEL
$opcion = $model['opcion_exp'];

//se obtiene la cadena de la fecha actual
$diatxt=date('l');
$dianro=date('d');
$mestxt=date('F');
$anionro=date('Y');
// *********** traducciones y modificaciones de fechas a letras y a español ***********
$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$diaesp=str_replace($ding, $desp, $diatxt);
$mesesp=str_replace($ming, $mesp, $mestxt);

$fecha_act= $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);
/*inicio configuración array de datos*/

$query ="
    SELECT DISTINCT
    tp.Rowid AS Id
    ,ISNULL(CONCAT(t350.f350_id_co,'-',t350.f350_id_tipo_docto,'-',t350.f350_consec_docto),'') AS RCB
    ,t350.f350_fecha_ts_creacion AS FECHA_RCB
    ,Referencia
    ,t1.F357_REFERENCIA AS CUS
    ,Num_Ident AS Numero_Identificacion
    ,Nom_Cliente
    ,Descr_Msj AS Banco
    ,Valor_Pago
    ,convert(nvarchar,f357_fecha_elaboracion,3) AS Fecha_Documento
    ,convert(nvarchar,SUBSTRING(Fech_Pago,1,10),3) AS Fecha_Pago
    ,convert(nvarchar,FECHA_REG,3) AS Fecha_Notificado
    FROM Pagos_Inteligentes..T_PSE AS tp
    INNER JOIN UnoEE1..t357_co_ingresos_caja ON f357_notas=Referencia AND f357_referencia=Cus
    INNER JOIN Repositorio_Datos..T_IN_Recibos_Caja AS t1 ON t1.F350_NOTAS=Referencia AND t1.F357_REFERENCIA=Cus
    left join UnoEE1..t350_co_docto_contable AS t350 ON t350.f350_notas=Referencia
    WHERE convert(nvarchar,FECHA_REG,112) BETWEEN '".$FechaM1."' AND '".$FechaM2."'
    ORDER BY 3,4,2
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
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'RCB');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'FECHA RCB');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'CUS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'N° IDENTIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'CLIENTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'BANCO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'VLR. PAGO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'FECHA DOCTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'FECHA PAGO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'FECHA NOTIFICADO');


$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $ID                 = $reg1 ['Id'];
    $RCB                = $reg1 ['RCB'];
    $FECHA_RCB          = $reg1 ['FECHA_RCB']; 
    $REFERENCIA         = $reg1 ['Referencia']; 
    $CUS                = $reg1 ['CUS']; 
    $N_IDENTIFICACION   = $reg1 ['Numero_Identificacion'];
    $CLIENTE            = $reg1 ['Nom_Cliente'];
    $BANCO              = $reg1 ['Banco'];
    $VALOR_PAGO         = $reg1 ['Valor_Pago'];
    $FECHA_DOCUMENTO    = $reg1 ['Fecha_Documento'];
    $FECHA_PAGO         = $reg1 ['Fecha_Pago'];
    $FECHA_NOTIFICADO   = $reg1 ['Fecha_Notificado'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ID);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $RCB);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $FECHA_RCB);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CUS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $N_IDENTIFICACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $CLIENTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $BANCO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VALOR_PAGO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $FECHA_DOCUMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $FECHA_PAGO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $FECHA_NOTIFICADO);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila.':L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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
