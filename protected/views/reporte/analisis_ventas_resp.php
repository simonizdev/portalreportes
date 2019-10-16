<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte
$opcion = $model['opcion'];
$linea = trim($model['linea']);
$marca = trim($model['marca']);
$des_ora = trim($model['des_ora']);

$periodo_inicial = $model['periodo_inicial'];

$periodo_inicial = explode("-", $model['periodo_inicial']);
$anio_inicial = $periodo_inicial[0] - 1;
$mes_inicial = $periodo_inicial[1];

$periodo_final = $model['periodo_final'];

$periodo_final = explode("-", $model['periodo_final']);
$anio_final = $periodo_final[0];
$mes_final = $periodo_final[1];

if($opcion == 1){
  //LINEA
  $array_opc = array(10, 11, 12, 13, 14);
  $criterio = $linea;
}

if($opcion == 2){
  //MARCA
  $array_opc = array(20, 21, 22, 23, 24);
  $criterio = $marca;
}

if($opcion == 3){
  //DESC. ORACLE
  $array_opc = array(30, 31, 32, 33, 34);
  $criterio = $des_ora;
}

set_time_limit(0);

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


/*inicio configuración array de datos*/

/****** inicio array items ******/

$query = "
  SET NOCOUNT ON
  EXEC [dbo].[COM_ANALISIS_VTS_YEAR]
  @OPT = ".$array_opc[0].",
  @CRITERIO = N'".$criterio."',
  @YEAR1 = N'".$anio_inicial."',
  @YEAR2 = N'".$anio_final."',
  @MES1 = N'".$mes_inicial."',
  @MES2 = N'".$mes_final."'
";

$q = Yii::app()->db->createCommand($query)->queryAll();

$array_items = array();

foreach ($q as $reg) {
  
  $i = $reg['ITEM'];
  $desc = $reg['DESCRIPCION'];

  $array_items[$i] = array('desc' => $desc, 'c_'.$anio_inicial => '-', 'c_'.$anio_final => '-', 'v_'.$anio_inicial => '-', 'v_'.$anio_final => '-');
}

foreach ($q as $reg) {
  
  $i = $reg['ITEM'];
  $anio = $reg['ANO'];
  $cant = $reg['CANT_BASE'];
  $vlr = $reg['VLR'];

  $array_items[$i]['c_'.$anio] = $cant;
  $array_items[$i]['v_'.$anio] = $vlr;

}

/****** fin array items ******/

/****** inicio array mes ******/

$query1 = "
  SET NOCOUNT ON
  EXEC [dbo].[COM_ANALISIS_VTS_YEAR]
  @OPT = ".$array_opc[1].",
  @CRITERIO = N'".$criterio."',
  @YEAR1 = N'".$anio_inicial."',
  @YEAR2 = N'".$anio_final."',
  @MES1 = N'".$mes_inicial."',
  @MES2 = N'".$mes_final."'
";

$q1 = Yii::app()->db->createCommand($query1)->queryAll();

$array_meses = array();

foreach ($q1 as $reg1) {
  
  $m = $reg1['MES'];

  $array_meses[$m] = array('c_'.$anio_inicial => '-', 'c_'.$anio_final => '-', 'v_'.$anio_inicial => '-', 'v_'.$anio_final => '-');
}

foreach ($q1 as $reg1) {
  
  $m = $reg1['MES'];
  $anio = $reg1['ANO'];
  $cant = $reg1['CANTIDAD'];
  $vlr = $reg1['VALOR'];

  $array_meses[$m]['v_'.$anio] = $vlr;
  $array_meses[$m]['c_'.$anio] = $cant;

}

/****** fin array mes ******/

/****** inicio array clase ******/

$query2 = "
  SET NOCOUNT ON
  EXEC [dbo].[COM_ANALISIS_VTS_YEAR]
  @OPT = ".$array_opc[2].",
  @CRITERIO = N'".$criterio."',
  @YEAR1 = N'".$anio_inicial."',
  @YEAR2 = N'".$anio_final."',
  @MES1 = N'".$mes_inicial."',
  @MES2 = N'".$mes_final."'
";

$q2 = Yii::app()->db->createCommand($query2)->queryAll();

$array_clases = array();

foreach ($q2 as $reg2) {
  
  $c = $reg2['CLASE'];

  $array_clases[$c] = array('c_'.$anio_inicial => '-', 'c_'.$anio_final => '-', 'v_'.$anio_inicial => '-', 'v_'.$anio_final => '-');
}

foreach ($q2 as $reg2) {
  
  $c = $reg2['CLASE'];
  $anio = $reg2['ANO'];
  $cant = $reg2['CANTIDAD'];
  $vlr = $reg2['VALOR'];

  $array_clases[$c]['v_'.$anio] = $vlr;
  $array_clases[$c]['c_'.$anio] = $cant;

}

/****** fin array clase ******/

/****** inicio array ev ******/

$query3 = "
  SET NOCOUNT ON
  EXEC [dbo].[COM_ANALISIS_VTS_YEAR]
  @OPT = ".$array_opc[3].",
  @CRITERIO = N'".$criterio."',
  @YEAR1 = N'".$anio_inicial."',
  @YEAR2 = N'".$anio_final."',
  @MES1 = N'".$mes_inicial."',
  @MES2 = N'".$mes_final."'
";

$q3 = Yii::app()->db->createCommand($query3)->queryAll();

$array_ev = array();

foreach ($q3 as $reg3) {
  
  $e = $reg3['ESTRUCTURA'];

  $array_ev[$e] = array('c_'.$anio_inicial => '-', 'c_'.$anio_final => '-', 'v_'.$anio_inicial => '-', 'v_'.$anio_final => '-');
}

foreach ($q3 as $reg3) {
  
  $e = $reg3['ESTRUCTURA'];
  $anio = $reg3['ANO'];
  $cant = $reg3['CANTIDAD'];
  $vlr = $reg3['VALOR'];

  $array_ev[$e]['v_'.$anio] = $vlr;
  $array_ev[$e]['c_'.$anio] = $cant;

}

/*echo '<pre>';
print_r($array_ev);die;
echo '</pre>';*/

/****** fin array ev ******/

/****** inicio array oracle ******/

$query4 = "
  SET NOCOUNT ON
  EXEC [dbo].[COM_ANALISIS_VTS_YEAR]
  @OPT = ".$array_opc[4].",
  @CRITERIO = N'".$criterio."',
  @YEAR1 = N'".$anio_inicial."',
  @YEAR2 = N'".$anio_final."',
  @MES1 = N'".$mes_inicial."',
  @MES2 = N'".$mes_final."'
";

$q4 = Yii::app()->db->createCommand($query4)->queryAll();

$array_oracle = array();

foreach ($q4 as $reg4) {
  
  $o = $reg4['ORACLE'];

  $array_oracle[$o] = array('c_'.$anio_inicial => '-', 'c_'.$anio_final => '-', 'v_'.$anio_inicial => '-', 'v_'.$anio_final => '-');
}

foreach ($q4 as $reg4) {
  
  $o = $reg4['ORACLE'];
  $anio = $reg4['ANO'];
  $cant = $reg4['CANTIDAD'];
  $vlr = $reg4['VALOR'];

  $array_oracle[$o]['v_'.$anio] = $vlr;
  $array_oracle[$o]['c_'.$anio] = $cant;

}

/****** fin array oracle ******/

/*fin configuración array de datos*/

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex();
$objPHPExcel->getActiveSheet()->setTitle('ITEMS');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CÓDIGO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'REF. - DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'VENTAS '.$anio_inicial.' (Q)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'VENTAS '.$anio_final.' (Q)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', '% VARIACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'VENTAS '.$anio_inicial.' ($)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VENTAS '.$anio_final.' ($)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', '% VARIACIÓN');

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
 
$Fila = 2;  

foreach ($array_items as $i => $reg) {


  $item = $i;
  $desc = $reg['desc'];
  $c_a = $reg['c_'.$anio_inicial];
  $c_b = $reg['c_'.$anio_final];

  if($c_a == '-' && $c_b != '-'){
    $variacion_c = $c_b;
    $por_variacion_c = '';
  }else{
    if($c_a != '-' && $c_b == '-'){
      $variacion_c = $c_a;
      $por_variacion_c = '';
    }else{
      $variacion_c = abs($c_a - $c_b);

      if($c_a == 0){
        $c_a = 0.0000001;
      }

      $por_variacion_c = ($variacion_c / $c_a) * 100;
    }
  }

  $v_a = $reg['v_'.$anio_inicial];
  $v_b = $reg['v_'.$anio_final];

  if($v_a == '-' && $v_b != '-'){
    $variacion_v = $v_b;
    $por_variacion_v = '';
  }else{
    if($v_a != '-' && $v_b == '-'){
      $variacion_v = $v_a;
      $por_variacion_v = '';
    }else{
      $variacion_v = abs($v_a - $v_b);

      if($v_a == 0){
        $v_a = 0.0000001;
      }
      
      $por_variacion_v = ($variacion_v / $v_a) * 100;
    }
  }
      
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $item);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $desc);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $c_a);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $c_b);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $variacion_c);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $por_variacion_c);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $v_a);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $v_b);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $variacion_v);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $por_variacion_v);


  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

  if($c_a == '-'){
    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }else{
    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }

  if($c_b == '-'){
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }else{
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }

  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  if($por_variacion_c != ''){
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }

  if($v_a == '-'){
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }else{
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }

  if($v_b == '-'){
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }else{
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }

  $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  if($por_variacion_v != ''){
    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  }

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
$objPHPExcel->getActiveSheet()->setTitle('MESES');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'MES');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'VENTAS '.$anio_inicial.' (Q)');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', 'VENTAS '.$anio_final.' (Q)');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', '% VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', 'VENTAS '.$anio_inicial.' ($)');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'VENTAS '.$anio_final.' ($)');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', '% VARIACIÓN');

$objPHPExcel->getActiveSheet(1)->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(1)->getStyle('A1:I1')->getFont()->setBold(true);

$Fila = 2; 

$s_c_a = 0;
$s_c_b = 0;
$s_v_a = 0;
$s_v_b = 0; 

foreach ($array_meses as $m => $reg) {

  $mes = $m;
  
  //$c_a = $reg['c_'.$anio_inicial];

  if($reg['c_'.$anio_inicial] == '-'){
    $c_a = 0;
  }else{
    $c_a = $reg['c_'.$anio_inicial];
  } 

  $s_c_a = $s_c_a + $c_a;

  //$c_b = $reg['c_'.$anio_final];

  if($reg['c_'.$anio_final] == '-'){
    $c_b = 0;
  }else{
    $c_b = $reg['c_'.$anio_final];
  } 

  $s_c_b = $s_c_b + $c_b;

  $variacion_c = abs($c_a - $c_b);

  if($c_a == 0){
    $c_a = 0.0000001;
  }

  $por_variacion_c = ($variacion_c / $c_a) * 100;
    
  //$v_a = $reg['v_'.$anio_inicial];

  if($reg['v_'.$anio_inicial] == '-'){
    $v_a = 0;
  }else{
    $v_a = $reg['v_'.$anio_inicial];
  } 

  $s_v_a = $s_v_a + $v_a;

  //$v_b = $reg['v_'.$anio_final];

  if($reg['v_'.$anio_final] == '-'){
    $v_b = 0;
  }else{
    $v_b = $reg['v_'.$anio_final];
  } 

  $s_v_b = $s_v_b + $v_b;

  $variacion_v = abs($v_a - $v_b);

  if($v_a == 0){
    $v_a = 0.0000001;
  }

  $por_variacion_v = ($variacion_v / $v_a) * 100;
      
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$Fila, $mes);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$Fila, $c_a);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$Fila, $c_b);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$Fila, $variacion_c);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$Fila, $por_variacion_c);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$Fila, $v_a);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$Fila, $v_b);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$Fila, $variacion_v);
  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$Fila, $por_variacion_v);

  $objPHPExcel->getActiveSheet(1)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet(1)->getStyle('B'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(1)->getStyle('B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(1)->getStyle('C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('D'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(1)->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(1)->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(1)->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('G'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(1)->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(1)->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(1)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(1)->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  $Fila = $Fila + 1;

}

$s_variacion_c = abs($s_c_a - $s_c_b);
$s_por_variacion_c = ($s_variacion_c / $s_c_a) * 100;

$s_variacion_v = abs($s_v_a - $s_v_b);
$s_por_variacion_v = ($s_variacion_v / $s_v_a) * 100;

$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$Fila, 'TOTAL GENERAL');
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$Fila, $s_c_a);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$Fila, $s_c_b);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$Fila, $s_variacion_c);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$Fila, $s_por_variacion_c);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$Fila, $s_v_a);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$Fila, $s_v_b);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$Fila, $s_variacion_v);
$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$Fila, $s_por_variacion_v);

$objPHPExcel->getActiveSheet(1)->getStyle('A'.$Fila.':I'.$Fila)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet(1)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet(1)->getStyle('B'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet(1)->getStyle('B'.$Fila.':D'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(1)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet(1)->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(1)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');

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

$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->setTitle('CLASE');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', 'CLASE');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', 'VENTAS '.$anio_inicial.' (Q)');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('C1', 'VENTAS '.$anio_final.' (Q)');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('D1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('E1', '% VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('F1', 'VENTAS '.$anio_inicial.' ($)');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('G1', 'VENTAS '.$anio_final.' ($)');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('H1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('I1', '% VARIACIÓN');

$objPHPExcel->getActiveSheet(2)->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(2)->getStyle('A1:I1')->getFont()->setBold(true);

$Fila = 2; 

$s_c_a = 0;
$s_c_b = 0;
$s_v_a = 0;
$s_v_b = 0; 

foreach ($array_clases as $c => $reg) {

  $clase = $c;
  
  //$c_a = $reg['c_'.$anio_inicial];

  if($reg['c_'.$anio_inicial] == '-'){
    $c_a = 0;
  }else{
    $c_a = $reg['c_'.$anio_inicial];
  } 

  $s_c_a = $s_c_a + $c_a;

  //$c_b = $reg['c_'.$anio_final];

  if($reg['c_'.$anio_final] == '-'){
    $c_b = 0;
  }else{
    $c_b = $reg['c_'.$anio_final];
  } 

  $s_c_b = $s_c_b + $c_b;

  $variacion_c = abs($c_a - $c_b);

  if($c_a == 0){
    $c_a = 0.0000001;
  }

  $por_variacion_c = ($variacion_c / $c_a) * 100;
    
  //$v_a = $reg['v_'.$anio_inicial];

  if($reg['v_'.$anio_inicial] == '-'){
    $v_a = 0;
  }else{
    $v_a = $reg['v_'.$anio_inicial];
  } 

  $s_v_a = $s_v_a + $v_a;

  //$v_b = $reg['v_'.$anio_final];

  if($reg['v_'.$anio_final] == '-'){
    $v_b = 0;
  }else{
    $v_b = $reg['v_'.$anio_final];
  } 

  $s_v_b = $s_v_b + $v_b;

  $variacion_v = abs($v_a - $v_b);

  if($v_a == 0){
    $v_a = 0.0000001;
  }

  $por_variacion_v = ($variacion_v / $v_a) * 100;
      
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$Fila, $clase);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$Fila, $c_a);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$Fila, $c_b);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D'.$Fila, $variacion_c);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E'.$Fila, $por_variacion_c);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F'.$Fila, $v_a);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G'.$Fila, $v_b);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H'.$Fila, $variacion_v);
  $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I'.$Fila, $por_variacion_v);

  $objPHPExcel->getActiveSheet(2)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet(2)->getStyle('B'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(2)->getStyle('B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(2)->getStyle('C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('D'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(2)->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(2)->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(2)->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('G'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(2)->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(2)->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(2)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(2)->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  $Fila = $Fila + 1;

}

$s_variacion_c = abs($s_c_a - $s_c_b);
$s_por_variacion_c = ($s_variacion_c / $s_c_a) * 100;

$s_variacion_v = abs($s_v_a - $s_v_b);
$s_por_variacion_v = ($s_variacion_v / $s_v_a) * 100;

$objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$Fila, 'TOTAL GENERAL');
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$Fila, $s_c_a);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$Fila, $s_c_b);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('D'.$Fila, $s_variacion_c);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('E'.$Fila, $s_por_variacion_c);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('F'.$Fila, $s_v_a);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('G'.$Fila, $s_v_b);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('H'.$Fila, $s_variacion_v);
$objPHPExcel->setActiveSheetIndex(2)->setCellValue('I'.$Fila, $s_por_variacion_v);

$objPHPExcel->getActiveSheet(2)->getStyle('A'.$Fila.':I'.$Fila)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet(2)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet(2)->getStyle('B'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet(2)->getStyle('B'.$Fila.':D'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(2)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet(2)->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(2)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');

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

$objPHPExcel->setActiveSheetIndex(3);
$objPHPExcel->getActiveSheet()->setTitle('EV');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', 'ESTRUCTURA DE VENTAS');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('B1', 'VENTAS '.$anio_inicial.' (Q)');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('C1', 'VENTAS '.$anio_final.' (Q)');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('D1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('E1', '% VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('F1', 'VENTAS '.$anio_inicial.' ($)');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('G1', 'VENTAS '.$anio_final.' ($)');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('H1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', '% VARIACIÓN');

$objPHPExcel->getActiveSheet(3)->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(3)->getStyle('A1:I1')->getFont()->setBold(true);

$Fila = 2; 

$s_c_a = 0;
$s_c_b = 0;
$s_v_a = 0;
$s_v_b = 0; 

foreach ($array_ev as $ev => $reg) {

  $est_v = $ev;

  //$c_a = $reg['c_'.$anio_inicial];

  if($reg['c_'.$anio_inicial] == '-'){
    $c_a = 0;
  }else{
    $c_a = $reg['c_'.$anio_inicial];
  } 

  $s_c_a = $s_c_a + $c_a;

  //$c_b = $reg['c_'.$anio_final];

  if($reg['c_'.$anio_final] == '-'){
    $c_b = 0;
  }else{
    $c_b = $reg['c_'.$anio_final];
  } 

  $s_c_b = $s_c_b + $c_b;

  $variacion_c = abs($c_a - $c_b);

  if($c_a == 0){
    $c_a = 0.0000001;
  }

  $por_variacion_c = ($variacion_c / $c_a) * 100;
    
  //$v_a = $reg['v_'.$anio_inicial];

  if($reg['v_'.$anio_inicial] == '-'){
    $v_a = 0;
  }else{
    $v_a = $reg['v_'.$anio_inicial];
  } 

  $s_v_a = $s_v_a + $v_a;

  //$v_b = $reg['v_'.$anio_final];

  if($reg['v_'.$anio_final] == '-'){
    $v_b = 0;
  }else{
    $v_b = $reg['v_'.$anio_final];
  } 

  $s_v_b = $s_v_b + $v_b;

  $variacion_v = abs($v_a - $v_b);

  if($v_a == 0){
    $v_a = 0.0000001;
  }

  $por_variacion_v = ($variacion_v / $v_a) * 100;
      
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A'.$Fila, $est_v);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B'.$Fila, $c_a);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C'.$Fila, $c_b);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D'.$Fila, $variacion_c);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E'.$Fila, $por_variacion_c);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F'.$Fila, $v_a);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G'.$Fila, $v_b);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H'.$Fila, $variacion_v);
  $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I'.$Fila, $por_variacion_v);

  $objPHPExcel->getActiveSheet(3)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet(3)->getStyle('B'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(3)->getStyle('B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(3)->getStyle('C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('D'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(3)->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(3)->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(3)->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('G'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(3)->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(3)->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(3)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(3)->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  $Fila = $Fila + 1;

}

$s_variacion_c = abs($s_c_a - $s_c_b);
$s_por_variacion_c = ($s_variacion_c / $s_c_a) * 100;

$s_variacion_v = abs($s_v_a - $s_v_b);
$s_por_variacion_v = ($s_variacion_v / $s_v_a) * 100;

$objPHPExcel->setActiveSheetIndex(3)->setCellValue('A'.$Fila, 'TOTAL GENERAL');
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('B'.$Fila, $s_c_a);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('C'.$Fila, $s_c_b);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('D'.$Fila, $s_variacion_c);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('E'.$Fila, $s_por_variacion_c);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('F'.$Fila, $s_v_a);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('G'.$Fila, $s_v_b);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('H'.$Fila, $s_variacion_v);
$objPHPExcel->setActiveSheetIndex(3)->setCellValue('I'.$Fila, $s_por_variacion_v);

$objPHPExcel->getActiveSheet(3)->getStyle('A'.$Fila.':I'.$Fila)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet(3)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet(3)->getStyle('B'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet(3)->getStyle('B'.$Fila.':D'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(3)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet(3)->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(3)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');

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

$objPHPExcel->setActiveSheetIndex(4);
$objPHPExcel->getActiveSheet()->setTitle('CAT. ORACLE');

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex(4)->setCellValue('A1', 'CAT. ORACLE');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('B1', 'VENTAS '.$anio_inicial.' (Q)');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('C1', 'VENTAS '.$anio_final.' (Q)');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('D1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('E1', '% VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('F1', 'VENTAS '.$anio_inicial.' ($)');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('G1', 'VENTAS '.$anio_final.' ($)');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('H1', 'VARIACIÓN');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('I1', '% VARIACIÓN');

$objPHPExcel->getActiveSheet(4)->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(4)->getStyle('A1:I1')->getFont()->setBold(true);

$Fila = 2; 

$s_c_a = 0;
$s_c_b = 0;
$s_v_a = 0;
$s_v_b = 0; 

foreach ($array_oracle as $or => $reg) {

  $oracle = $or;
  
  //$c_a = $reg['c_'.$anio_inicial];

  if($reg['c_'.$anio_inicial] == '-'){
    $c_a = 0;
  }else{
    $c_a = $reg['c_'.$anio_inicial];
  } 

  $s_c_a = $s_c_a + $c_a;

  //$c_b = $reg['c_'.$anio_final];

  if($reg['c_'.$anio_final] == '-'){
    $c_b = 0;
  }else{
    $c_b = $reg['c_'.$anio_final];
  } 

  $s_c_b = $s_c_b + $c_b;

  $variacion_c = abs($c_a - $c_b);

  if($c_a == 0){
    $c_a = 0.0000001;
  }

  $por_variacion_c = ($variacion_c / $c_a) * 100;
    
  //$v_a = $reg['v_'.$anio_inicial];

  if($reg['v_'.$anio_inicial] == '-'){
    $v_a = 0;
  }else{
    $v_a = $reg['v_'.$anio_inicial];
  } 

  $s_v_a = $s_v_a + $v_a;

  //$v_b = $reg['v_'.$anio_final];

  if($reg['v_'.$anio_final] == '-'){
    $v_b = 0;
  }else{
    $v_b = $reg['v_'.$anio_final];
  } 

  $s_v_b = $s_v_b + $v_b;

  $variacion_v = abs($v_a - $v_b);

  if($v_a == 0){
    $v_a = 0.0000001;
  }

  $por_variacion_v = ($variacion_v / $v_a) * 100;
      
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A'.$Fila, $oracle);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B'.$Fila, $c_a);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C'.$Fila, $c_b);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D'.$Fila, $variacion_c);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E'.$Fila, $por_variacion_c);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F'.$Fila, $v_a);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G'.$Fila, $v_b);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H'.$Fila, $variacion_v);
  $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I'.$Fila, $por_variacion_v);

  $objPHPExcel->getActiveSheet(4)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet(4)->getStyle('B'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(4)->getStyle('B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(4)->getStyle('C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('D'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(4)->getStyle('D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(4)->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(4)->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('G'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(4)->getStyle('G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet(4)->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet(4)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet(4)->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  $Fila = $Fila + 1;

}

$s_variacion_c = abs($s_c_a - $s_c_b);
$s_por_variacion_c = ($s_variacion_c / $s_c_a) * 100;

$s_variacion_v = abs($s_v_a - $s_v_b);
$s_por_variacion_v = ($s_variacion_v / $s_v_a) * 100;

$objPHPExcel->setActiveSheetIndex(4)->setCellValue('A'.$Fila, 'TOTAL GENERAL');
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('B'.$Fila, $s_c_a);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('C'.$Fila, $s_c_b);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('D'.$Fila, $s_variacion_c);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('E'.$Fila, $s_por_variacion_c);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('F'.$Fila, $s_v_a);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('G'.$Fila, $s_v_b);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('H'.$Fila, $s_variacion_v);
$objPHPExcel->setActiveSheetIndex(4)->setCellValue('I'.$Fila, $s_por_variacion_v);

$objPHPExcel->getActiveSheet(4)->getStyle('A'.$Fila.':I'.$Fila)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet(4)->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet(4)->getStyle('B'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet(4)->getStyle('B'.$Fila.':D'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(4)->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet(4)->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
$objPHPExcel->getActiveSheet(4)->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');

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

$n = 'Analisis_ventas_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>