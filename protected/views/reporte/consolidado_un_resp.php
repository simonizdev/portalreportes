<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];
$un = $model['un'];

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

$array_un = $un;

$cond_un = "";

foreach ($array_un as $key => $value) {
  $cond_un .= "".trim($value).",";
}

$cond_u_n = substr($cond_un, 0, -1);

$query1 = "
  SET NOCOUNT ON
  EXEC FIN_CT_CONSOLIDADO_UN_DET
  @Fecha_Ini = N'".$FechaM1."',
  @Fecha_Fin = N'".$FechaM2."',
  @Criterio = N'".$cond_u_n."'
";

$q1 = Yii::app()->db->createCommand($query1)->queryAll();

$query2 = "
  SET NOCOUNT ON
  EXEC FIN_CT_CONSOLIDADO_UN
  @Fecha_Ini = N'".$FechaM1."',
  @Fecha_Fin = N'".$FechaM2."',
  @Criterio = N'".$cond_u_n."'
";

$q2 = Yii::app()->db->createCommand($query2)->queryAll();

//echo $query1;die();

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex();
$objPHPExcel->getActiveSheet()->setTitle('Detalle');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Docto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Consecutivo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Fecha');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Mes');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Cliente');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'OC');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Id Sucursal');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Sucursal');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Estructura');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Id Vendedor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Vendedor');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Descripción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Origen');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Tipo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Clasificación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Clase');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Marca');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Submarca');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Segmento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'Familia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'Subfamilia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'Línea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'Sublínea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'Grupo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'UN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'Cat. Oracle');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'Cantidad');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'Motivo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', 'Moneda');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', 'Tasa');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', 'Vlr. bruto alterno');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AH1', 'Vlr. bruto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AI1', 'Vlr. subtotal alterno');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AJ1', 'Vlr. subtotal');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AK1', 'Vlr. imp. alterno');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AL1', 'Vlr. imp');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AM1', 'Vlr. neto alterno');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AN1', 'Vlr. neto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AO1', 'Notas');

$objPHPExcel->getActiveSheet()->getStyle('A1:AO1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AO1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$Fila = 2; 

foreach ($q1 as $reg) {

  $CO = $reg['CO'];
  $DOCTO = $reg['DOCTO'];
  $CONSECUTIVO = $reg['CONSECUTIVO'];
  $FECHA = $reg['FECHA'];
  $MES = $reg['MES'];
  $CLIENTE = $reg['CLIENTE'];
  $OC = $reg['OC'];
  $ID_SUCURSAL = $reg['ID_SUCURSAL'];
  $SUCURSAL = $reg['SUCURSAL'];
  $ESTRUCTURA = $reg['ESTRUCTURA'];
  $ID_VENDEDOR = $reg['ID_VENDEDOR'];
  $VENDEDOR = $reg['VENDEDOR'];
  $ITEM = $reg['ITEM'];
  $DESCRIPCION = $reg['DESCRIPCION'];
  $ORIGEN = $reg['ORIGEN'];
  $TIPO = $reg['TIPO'];
  $CLASIFICACION = $reg['CLASIFICACION'];
  $CLASE = $reg['CLASE'];
  $MARCA = $reg['MARCA'];
  $SUBMARCA = $reg['SUBMARCA'];
  $SEGMENTO = $reg['SEGMENTO'];
  $FAMILIA = $reg['FAMILIA'];
  $SUBFAMILIA = $reg['SUBFAMILIA'];
  $LINEA = $reg['LINEA'];
  $SUBLINEA = $reg['SUBLINEA'];
  $GRUPO = $reg['GRUPO'];
  $UN = $reg['UN'];
  $ORACLE = $reg['ORACLE'];
  $CANTIDAD = $reg['CANTIDAD'];
  $MOTIVO = $reg['MOTIVO'];
  $MONEDA = $reg['MONEDA'];
  $TASA = $reg['TASA'];
  $Vlr_Bruto_Alt = $reg['Vlr_Bruto_Alt'];
  $Vlr_Bruto = $reg['Vlr_Bruto'];
  $Vlr_Subtotal_Alt = $reg['Vlr_Subtotal_Alt'];
  $Vlr_Subtotal = $reg['Vlr_Subtotal'];
  $Vlr_Imp_Alt = $reg['Vlr_Imp_Alt'];
  $Vlr_Imp = $reg['Vlr_Imp'];
  $Vlr_Neto_Alt = $reg['Vlr_Neto_Alt'];
  $Vlr_Neto = $reg['Vlr_Neto'];
  $Notas = $reg['Notas'];
  
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $CO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $DOCTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $CONSECUTIVO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $FECHA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $MES);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CLIENTE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $OC);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $ID_SUCURSAL);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUCURSAL);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $ESTRUCTURA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ID_VENDEDOR);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $VENDEDOR);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $ITEM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $DESCRIPCION);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $ORIGEN);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $TIPO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $CLASIFICACION);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $CLASE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $MARCA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $SUBMARCA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $SEGMENTO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $FAMILIA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $SUBFAMILIA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $LINEA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $SUBLINEA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $GRUPO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $UN);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $ORACLE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila, $CANTIDAD);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $MOTIVO);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $MONEDA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $TASA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, $Vlr_Bruto_Alt);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $Vlr_Bruto);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $Vlr_Subtotal_Alt);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $Vlr_Subtotal);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, $Vlr_Imp_Alt);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $Vlr_Imp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, $Vlr_Neto_Alt);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, $Vlr_Neto);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, $Notas);

  $objPHPExcel->getActiveSheet()->getStyle('AF'.$Fila.':AN'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('AF'.$Fila.':AN'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setTitle('Consolidado');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'CO');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'Mes');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', 'Cliente');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Autos');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', 'Mecánica');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', 'Hogar');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'Administración');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'Otras marcas');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', 'Total general');

$objPHPExcel->getActiveSheet(1)->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(1)->getStyle('A1:I1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$Fila = 2; 

$total_autos = 0;
$total_mecanica = 0;
$total_hogar = 0;
$total_administracion = 0;
$total_otras_marcas = 0;
$t_total_general = 0;

foreach ($q2 as $reg) {

  $co = $reg['CO'];
  $mes = $reg['MES'];
  $cliente = $reg['CLIENTE'];
  $autos = $reg['AUTOS'];
  $mecanica = $reg['MECANICA'];
  $hogar = $reg['HOGAR'];
  $administracion = $reg['ADMINISTRACION'];
  $otras_marcas = $reg['OTRAS_MARCAS'];
  $total_general = $autos + $mecanica + $hogar + $administracion + $otras_marcas;

  $total_autos = $total_autos + $autos;
  $total_mecanica = $total_mecanica + $mecanica;
  $total_hogar = $total_hogar + $hogar;
  $total_administracion = $total_administracion + $administracion;
  $total_otras_marcas = $total_otras_marcas + $otras_marcas;
  $t_total_general = $t_total_general + $total_general;
  
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$Fila, $co);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$Fila, $mes);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$Fila, $cliente);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$Fila, $autos);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$Fila, $mecanica);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$Fila, $hogar);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$Fila, $administracion);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$Fila, $otras_marcas);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$Fila, $total_general);

  $objPHPExcel->getActiveSheet(1)->getStyle('D'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('D'.$Fila.':I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00'); 

  $Fila = $Fila + 1;
}

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$Fila, 'Total');
$objPHPExcel->setActiveSheetIndex(1)->mergeCells('A'.$Fila.':C'.$Fila);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$Fila, $total_autos);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$Fila, $total_mecanica);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$Fila, $total_hogar);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$Fila, $total_administracion);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$Fila, $total_otras_marcas);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$Fila, $t_total_general);


$objPHPExcel->getActiveSheet(1)->getStyle('D'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet(1)->getStyle('D'.$Fila.':I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet(1)->getStyle('A'.$Fila.':I'.$Fila)->getFont()->setBold(true);

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

$n = 'Consolidado_Detalle_UN_'.date('Y_m_d_H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>