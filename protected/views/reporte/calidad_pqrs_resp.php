<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

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

$query ="
SET NOCOUNT ON
EXEC CAL_CRM_CASE
  @Fecha_Ini = N'".$FechaM1."',
  @Fecha_Fin = N'".$FechaM2."'
";

//echo $query;die();

/*inicio configuración array de datos*/

/*fin configuración array de datos*/

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex();
$objPHPExcel->getActiveSheet()->setTitle('Pedidos');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Consecutivo PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Estado PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Referencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cantidad');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Tipificación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', '# Reclamación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Área');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Tipo PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Tipo solución');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Descripción caso');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Fecha PQRS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Fecha auditoría');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Estado auditoría');

$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$resp = Yii::app()->db->createCommand($query)->queryAll();

$Fila = 2; 

foreach ($resp as $reg) {

  $consecutivo        = $reg['Consecutivo_PQRS'];
  $estado_pqrs        = $reg['Estado_PQRS'];
  $referencia         = $reg['Referencia'];
  $cantidad           = $reg['Cantidad'];
  $tipificacion       = $reg['Tipificacion'];
  $numero_reclamacion = $reg['Numero_Reclamacion'];
  $area_empresa       = $reg['Area_Empresa'];
  $tipo_pqrs          = $reg['Tipo_PQRS'];
  $tipo_solucion      = $reg['Tipo_Solucion'];
  $descripcion_caso   = $reg['descripcion_caso'];
  $fecha_pqrs         = $reg['Fecha_PQRS'];
  $fecha_auditoria    = $reg['Fecha_Auditoria'];
  $estado_auditoria   = $reg['Estado_Auditoria'];

  if(is_numeric ($referencia)){

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $consecutivo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $estado_pqrs);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $referencia);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $cantidad);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $tipificacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $numero_reclamacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $area_empresa);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $tipo_pqrs);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $tipo_solucion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $descripcion_caso);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $fecha_pqrs);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $fecha_auditoria);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $estado_auditoria);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    
    $Fila = $Fila + 1;


  }else{
    //echo $referencia.' no es numero.<br>';
    $array_ref = json_decode($referencia);

    if(!empty($array_ref)){
      foreach ($array_ref as $key => $val) {
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $consecutivo);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $estado_pqrs);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $val);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $cantidad);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $tipificacion);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $numero_reclamacion);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $area_empresa);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $tipo_pqrs);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $tipo_solucion);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $descripcion_caso);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $fecha_pqrs);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $fecha_auditoria);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $estado_auditoria);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $Fila = $Fila + 1;
      }
    }else{
      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $consecutivo);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $estado_pqrs);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, '');
      $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $cantidad);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $tipificacion);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $numero_reclamacion);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $area_empresa);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $tipo_pqrs);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $tipo_solucion);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $descripcion_caso);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $fecha_pqrs);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $fecha_auditoria);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $estado_auditoria);

      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      
      $Fila = $Fila + 1;
    } 
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

$objPHPExcel->setActiveSheetIndex(0);

$n = 'Calidad_PQRS_'.date('Y_m_d_H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>