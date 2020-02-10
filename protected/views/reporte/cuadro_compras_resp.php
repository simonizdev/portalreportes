<?php
/* @var $this ReporteController */
/* @var $model Reporte */

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

//se reciben los parametros para el reporte
$opcion = $model['opcion'];
$origen = trim($model['origen']);
$marca = trim($model['marca']);
$linea = trim($model['linea']);
$des_ora = trim($model['des_ora']);
$proveedor = trim($model['proveedor']);

/*inicio configuración array de datos*/

if($opcion == 1){
  /*ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";  
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Estado(s): '.$estados.'.';

}

if($opcion == 2){
  /*ORIGEN - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Estado(s): '.$estados.'.';

}

if($opcion == 3){
  /*ORIGEN*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'',
    @VAR2 = N'',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'.';

}

if($opcion == 4){
  /*CRI/MARCA - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$marca."',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Marca: '.$marca.'. / Estado(s): '.$estados.'.';

}

if($opcion == 5){
  /*CRI/LINEA - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$linea."',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Línea: '.$linea.'. / Estado(s): '.$estados.'.';

}

if($opcion == 6){
  /*CRI/ORACLE - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$des_ora."',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Desc. oracle: '.$des_ora.'. / Estado(s): '.$estados.'.';

}

if($opcion == 7){
  /*CRI/MARCA*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$marca."',
    @VAR2 = N'',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Marca: '.$marca.'.';

}

if($opcion == 8){
  /*CRI/LINEA*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$linea."',
    @VAR2 = N'',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Línea: '.$linea.'.';

}

if($opcion == 9){
  /*CRI/ORACLE*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$des_ora."',
    @VAR2 = N'',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'Desc. oracle: '.$des_ora.'.';

}

if($opcion == 10){
  /*ORIGEN - CRI/MARCA*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$marca."',
    @VAR2 = N'',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Marca: '.$marca.'.';

}

if($opcion == 11){
  /*ORIGEN - CRI/LINEA*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$linea."',
    @VAR2 = N'',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Línea: '.$linea.'.';

}

if($opcion == 12){
  /*ORIGEN - CRI/ORACLE*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$des_ora."',
    @VAR2 = N'',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Desc. oracle: '.$des_ora.'.';

}

if($opcion == 13){
  /*ORIGEN - CRI/MARCA - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$marca."',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Marca: '.$marca.'. / Estado(s): '.$estados.'.';

}

if($opcion == 14){
  /*ORIGEN - CRI/LINEA - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$linea."',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Línea: '.$linea.'. / Estado(s): '.$estados.'.';

}

if($opcion == 15){
  /*ORIGEN - CRI/ORACLE - ESTADO*/

  $array_estados =  $model['estado'];
  $estados = "";
  foreach ($array_estados as $a_estados => $valor) {
    $estados .= "".$valor.",";
  }
  $estados = substr ($estados, 0, -1);

  $texto_estados = $estados;
  $condicion_estados = $estados;

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'".$des_ora."',
    @VAR2 = N'".$condicion_estados."',
    @VAR3 = N'".$origen."',
    @VAR4 = N''
  ";

  $criterio = 'Origen: '.$origen.'. / Desc. oracle: '.$des_ora.'. / Estado(s): '.$estados.'.';

}


if($opcion == 16){
  /*PROVEEDOR*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'',
    @VAR2 = N'',
    @VAR3 = N'',
    @VAR4 = N'".$proveedor."'
  ";

  $criterio = 'Proveedor: '.$proveedor.'.';

}

if($opcion == 17){
  /*SIN FILTROS*/

  $query= "
    SET NOCOUNT ON
    EXEC [dbo].[COMP_ACUM_VT_MC_EST_TIP]
    @OPT = ".$opcion.",
    @VAR1 = N'',
    @VAR2 = N'',
    @VAR3 = N'',
    @VAR4 = N''
  ";

  $criterio = 'SIN FILTROS.';

}

//echo $query;die;

//array con titulos de meses

$mes_act=date('F');

$clave = array_search($mes_act, $ming);

$cont = $clave - 1;

$array_titulo_meses = array();

for ($i=1; $i <= 12; $i++) { 

  $m = str_replace($ming, $mesp, $ming[$clave]);
  $mes = strtoupper($m);
  $mes_abrev = substr($mes, 0, 3);

  $array_titulo_meses[] = $mes_abrev;
  if($clave == 11){

    $clave = 0;
  
  }else{
  
    $clave++;
  
  }
}

/*fin configuración array de datos*/

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->mergeCells('A1:Z1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Criterio de búsqueda / '.$criterio);

$objPHPExcel->setActiveSheetIndex()->setCellValue('A3', 'CÓDIGO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B3', 'PROVEEDOR REAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C3', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D3', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E3', 'ESTADO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F3', 'UND. EMP. PRINCIPAL');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G3', 'UND. DE COMPRA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H3', $array_titulo_meses[0]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('I3', $array_titulo_meses[1]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('J3', $array_titulo_meses[2]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('K3', $array_titulo_meses[3]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('L3', $array_titulo_meses[4]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('M3', $array_titulo_meses[5]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('N3', $array_titulo_meses[6]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('O3', $array_titulo_meses[7]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('P3', $array_titulo_meses[8]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q3', $array_titulo_meses[9]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('R3', $array_titulo_meses[10]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('S3', $array_titulo_meses[11]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('T3', 'PROM. VENTAS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U3', 'STOCK MESES');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V3', 'PROM. MAX. * MESES STOCK');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W3', 'EXIST. A LA FECHA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X3', 'IMPORT');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y3', 'O.C PEND.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z3', 'CANT. TOTAL INV. DISP. + INV. PROC. + OC');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA3', 'CUB. MESES INV. DISP.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB3', 'CUB. MESES TOTAL INV. DISP. + OC');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC3', 'A.D PEDIR');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD3', 'FORECAST PROX. 6 MESES '.date('Y').' (SUM)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE3', 'FORECAST MENSUAL '.date('Y'));
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF3', 'A PEDIR FINAL');

$objPHPExcel->getActiveSheet()->getStyle('A3:AF3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:AF3')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$query1 = Yii::app()->db->createCommand($query)->queryAll();
 
$Fila = 4;  

foreach ($query1 as $reg1) {

  $ITEM                = $reg1 ['CI_ITEM'];

  if($reg1 ['CI_PROVEEDOR'] == NULL){
    $PROVEEDOR = '-';
  }else{
    $PROVEEDOR = $reg1 ['CI_PROVEEDOR'];
  } 

  $REFERENCIA          = $reg1 ['CI_REFERENCIA'];
  $DESCRIPCION         = $reg1 ['CI_DESCRIPCION'];
  $ESTADO              = $reg1 ['CI_ESTADO'];

  if($reg1 ['UMP'] == NULL){
    $UND_EMP_P = '-';
  }else{
    $UND_EMP_P = $reg1 ['UMP'];
  }

  if($reg1 ['CI_LOTE'] == NULL){
    $UND_COMPRA = 0;
  }else{
    $UND_COMPRA = $reg1 ['CI_LOTE'];
  }

  if($reg1 ['CI_MES12'] == NULL){
    $MES12 = 0;
  }else{
    $MES12 = $reg1 ['CI_MES12'];
  }

  if($reg1 ['CI_MES11'] == NULL){
    $MES11 = 0;
  }else{
    $MES11 = $reg1 ['CI_MES11'];
  }

  if($reg1 ['CI_MES10'] == NULL){
    $MES10 = 0;
  }else{
    $MES10 = $reg1 ['CI_MES10'];
  }

  if($reg1 ['CI_MES9'] == NULL){
    $MES9 = 0;
  }else{
    $MES9 = $reg1 ['CI_MES9'];
  }

  if($reg1 ['CI_MES8'] == NULL){
    $MES8 = 0;
  }else{
    $MES8 = $reg1 ['CI_MES8'];
  }

  if($reg1 ['CI_MES7'] == NULL){
    $MES7 = 0;
  }else{
    $MES7 = $reg1 ['CI_MES7'];
  }

  if($reg1 ['CI_MES6'] == NULL){
    $MES6 = 0;
  }else{
    $MES6 = $reg1 ['CI_MES6'];
  }

  if($reg1 ['CI_MES5'] == NULL){
    $MES5 = 0;
  }else{
    $MES5 = $reg1 ['CI_MES5'];
  }

  if($reg1 ['CI_MES4'] == NULL){
    $MES4 = 0;
  }else{
    $MES4 = $reg1 ['CI_MES4'];
  }

  if($reg1 ['CI_MES3'] == NULL){
    $MES3 = 0;
  }else{
    $MES3 = $reg1 ['CI_MES3'];
  }

  if($reg1 ['CI_MES2'] == NULL){
    $MES2 = 0;
  }else{
    $MES2 = $reg1 ['CI_MES2'];
  }

  if($reg1 ['CI_MES1'] == NULL){
    $MES1 = 0;
  }else{
    $MES1 = $reg1 ['CI_MES1'];
  }

  if($reg1 ['CI_PROMEDIO'] == NULL){
    $PROM_VENTAS = 0;
  }else{
    $PROM_VENTAS = $reg1 ['CI_PROMEDIO'];
  }

  if($reg1 ['CI_STOCK'] == NULL){
    $STOCK_MESES = 0;
  }else{
    $STOCK_MESES = $reg1 ['CI_STOCK'];
  }

  if($reg1 ['CI_BASE'] == NULL){
    $PROMEDIO_MAXIMO_x_MESES_STOCK = 0;
  }else{
    $PROMEDIO_MAXIMO_x_MESES_STOCK = $reg1 ['CI_BASE'];
  }

  if($reg1 ['CI_EXIS'] == NULL){
    $EXIST_FECHA = 0;
  }else{
    $EXIST_FECHA = $reg1 ['CI_EXIS'];
  }

  if($reg1 ['CI_IMP'] == NULL){
    $IMP = 0;
  }else{
    $IMP = $reg1 ['CI_IMP'];
  }

  if($reg1 ['CI_ENTRAR'] == NULL){
    $O_C_PEND = 0;
  }else{
    $O_C_PEND = $reg1 ['CI_ENTRAR'];
  }

  if($reg1 ['CI_TOTAL'] == NULL){
    $CANTIDAD_TOTAL_INV_DISP_INV_PROC_OC = 0;
  }else{
    $CANTIDAD_TOTAL_INV_DISP_INV_PROC_OC = $reg1 ['CI_TOTAL'];
  }

  if($reg1 ['CI_CUB_MES'] == NULL){
    $CUBRI_MESES_INV_DISPONIBLE = 0;
  }else{
    $CUBRI_MESES_INV_DISPONIBLE = $reg1 ['CI_CUB_MES'];
  }

  if($reg1 ['CI_CUB_MES_TOT'] == NULL){
    $CUBRI_MESES_TOTAL_INV_DISPON_OC = 0;
  }else{
    $CUBRI_MESES_TOTAL_INV_DISPON_OC = $reg1 ['CI_CUB_MES_TOT'];
  }

  if($reg1 ['CI_AD_PEDIR'] == NULL){
    $AD_PEDIR = 0;
  }else{
    $AD_PEDIR = $reg1 ['CI_AD_PEDIR'];
  }

  if($reg1 ['CI_FORCAST'] == NULL){
    $FORECAST = 0;
  }else{
    $FORECAST = $reg1 ['CI_FORCAST'];
  }

  if($reg1 ['CI_FORCAST_MES'] == NULL){
    $FORECAST_MES = 0;
  }else{
    $FORECAST_MES = $reg1 ['CI_FORCAST_MES'];
  }

  if($reg1 ['CI_PEDIR_TOT'] == NULL){
    $A_PEDIR_TOTAL = 0;
  }else{
    $A_PEDIR_TOTAL = $reg1 ['CI_PEDIR_TOT'];
  }
      
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ITEM);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, substr($PROVEEDOR, 0, 15));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, substr($REFERENCIA,0,20));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, substr($DESCRIPCION,0,35 ));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, substr($ESTADO, 0, 8));
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $UND_EMP_P);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $UND_COMPRA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $MES12);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $MES11);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $MES10);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $MES9);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $MES8);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $MES7);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $MES6);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $MES5);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $MES4);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $MES3);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $MES2);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $MES1);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $PROM_VENTAS);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $STOCK_MESES);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $PROMEDIO_MAXIMO_x_MESES_STOCK);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $EXIST_FECHA);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $IMP);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $O_C_PEND);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $CANTIDAD_TOTAL_INV_DISP_INV_PROC_OC);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $CUBRI_MESES_INV_DISPONIBLE);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $CUBRI_MESES_TOTAL_INV_DISPON_OC);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila, $AD_PEDIR);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $FORECAST);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $FORECAST_MES);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $A_PEDIR_TOTAL);

  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':S'.$Fila)->getNumberFormat()->setFormatCode('0'); 
  $objPHPExcel->getActiveSheet()->getStyle('T'.$Fila.':AG'.$Fila)->getNumberFormat()->setFormatCode('#,#0.0');
  $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':AG'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

$n = 'Cuadro_compras_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;



?>











