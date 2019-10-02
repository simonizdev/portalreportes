<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//Marcas

$array_marcas =  $model['marca'];

$condicion_marcas = "";
$texto_marcas = "";

foreach ($array_marcas as $a_marcas => $valor) {

  if($valor == '||'){
    $texto_marcas .= "SIN MARCA,";
  }else{
    $marcas = Yii::app()->db->createCommand("SELECT Criterio_Descripcion FROM Qlik.dbo.ED_CRITERIOS_ITEMS where Id_Criterio='".$valor."'")->queryRow();

    $dm = $marcas['Criterio_Descripcion'];

    $texto_marcas .= "".$dm.",";
  }

  $condicion_marcas .= "".$valor.",";
}

$condicion_marcas = substr ($condicion_marcas, 0, -1);
$texto_marcas = substr ($texto_marcas, 0, -1);

//Estados

$array_estados =  $model['estado'];

$estados = "";

foreach ($array_estados as $a_estados => $valor) {
  $estados .= "".$valor.",";
}

$estados = substr ($estados, 0, -1);

$condicion_estados = $estados;
$texto_estados = $estados;

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

/*inicio configuración array de datos*/

$query= "
    SET NOCOUNT ON
    EXEC [dbo].[EC_COM_ACUM_VT_MC_EST]
    @VAR1 = N'".$condicion_marcas."',
    @VAR2 = N'".$condicion_estados."'
";  


//echo $query;
//die();


/*fin configuración array de datos*/

if($opcion == 1){
  //PDF

  //se incluye la libreria pdf
  require_once Yii::app()->basePath . '/extensions/fpdf/fpdf.php';

  class PDF extends FPDF{

    function setFechaActual($fecha_actual){
      $this->fecha_actual = $fecha_actual;
    }
    
    function setMarca($marca){
      $this->marca = $marca;
    }

    function setEstados($estados){
      $this->estados = $estados;
    }

    function setTipos($tipos){
      $this->tipos = $tipos;
    }

    function setSql($sql){
      $this->sql = $sql;
    }

    function setTitulos($titulos){
      $this->titulos = $titulos;
    }

    function Header(){
      $this->SetFont('Arial','B',9);
      $this->Cell(200,5,utf8_decode('CONTROL DE PEDIDOS ACUMULADO / MARCA (ECUADOR)'),0,0,'L');
      $this->SetFont('Arial','',7);
      $this->Cell(140,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(340,5,utf8_decode('Criterio de búsqueda / Marca(s): '.$this->marca),0,0,'L');
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(340,5,utf8_decode('Criterio de búsqueda / Estado(s): '.$this->estados),0,0,'L');
      $this->Ln();
      $this->Ln();
      
      //linea superior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(340,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      $this->Ln();  
      
      //cabecera de tabla
      $this->SetFont('Arial','B',5);
  
      $this->Cell(10,2,utf8_decode('CÓDIGO'),0,0,'L');
      $this->Cell(18,2,utf8_decode('REFERENCIA'),0,0,'L');
      $this->Cell(44,2,utf8_decode('DESCRIPCIÓN'),0,0,'L');
      $this->Cell(8,2,utf8_decode('ESTADO'),0,0,'L');
      $this->Cell(13,2,utf8_decode('UND.'),0,0,'R');

      $array_titulos = $this->titulos;

      foreach ($array_titulos as $llave => $valor) {
        $this->Cell(13,2,utf8_decode($valor),0,0,'R');
      }


      $this->Cell(13,2,utf8_decode('PROM.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('STOCK'),0,0,'R');
      $this->Cell(13,2,utf8_decode('BASE'),0,0,'R');
      $this->Cell(13,2,utf8_decode('EXIST.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('O.C'),0,0,'R');
      $this->Cell(13,2,utf8_decode('A.D'),0,0,'R');
      $this->Cell(13,2,utf8_decode('# DÍAS'),0,0,'R');
      
      $this->Ln(3);   
      
      $this->Cell(10,2,utf8_decode(''),0,0,'L');
      $this->Cell(18,2,utf8_decode(''),0,0,'L');
      $this->Cell(44,2,utf8_decode(''),0,0,'L');
      $this->Cell(8,2,utf8_decode(''),0,0,'L');
      $this->Cell(13,2,utf8_decode('COMPRA'),0,0,'R');

      foreach ($array_titulos as $llave => $valor) {
        $this->Cell(13,2,utf8_decode(''),0,0,'R');
      }

      $this->Cell(13,2,utf8_decode('VTA 6-3-2'),0,0,'R');
      $this->Cell(13,2,utf8_decode('MESES'),0,0,'R');
      $this->Cell(13,2,utf8_decode('PEDIDO'),0,0,'R');
      $this->Cell(13,2,utf8_decode('A LA FECHA'),0,0,'R');
      $this->Cell(13,2,utf8_decode('PEND.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('PEDIR'),0,0,'R');
      $this->Cell(13,2,utf8_decode('CUBRIM.'),0,0,'R');


      $this->Ln(3);
      
      //linea inferior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(340,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      

      $this->Ln();
    }

    function Tabla(){

      $query1 = Yii::app()->db->createCommand($this->sql)->queryAll();

      foreach ($query1 as $reg1) {
        
        $ITEM                = $reg1 ['ITEM'];
        $DESCRIPCION         = $reg1 ['DESCRIPCION'];
        $REFERENCIA          = $reg1 ['REFERENCIA'];    
        $ESTADO              = $reg1 ['ESTADO'];

        if($reg1 ['UND_COMPRA'] == NULL){
          $UND_COMPRA = 0;
        }else{
          $UND_COMPRA = $reg1 ['UND_COMPRA'];
        }

        if($reg1 ['MES12'] == NULL){
          $MES12 = 0;
        }else{
          $MES12 = $reg1 ['MES12'];
        }

        if($reg1 ['MES11'] == NULL){
          $MES11 = 0;
        }else{
          $MES11 = $reg1 ['MES11'];
        }

        if($reg1 ['MES10'] == NULL){
          $MES10 = 0;
        }else{
          $MES10 = $reg1 ['MES10'];
        }

        if($reg1 ['MES9'] == NULL){
          $MES9 = 0;
        }else{
          $MES9 = $reg1 ['MES9'];
        }

        if($reg1 ['MES8'] == NULL){
          $MES8 = 0;
        }else{
          $MES8 = $reg1 ['MES8'];
        }

        if($reg1 ['MES7'] == NULL){
          $MES7 = 0;
        }else{
          $MES7 = $reg1 ['MES7'];
        }

        if($reg1 ['MES6'] == NULL){
          $MES6 = 0;
        }else{
          $MES6 = $reg1 ['MES6'];
        }

        if($reg1 ['MES5'] == NULL){
          $MES5 = 0;
        }else{
          $MES5 = $reg1 ['MES5'];
        }

        if($reg1 ['MES4'] == NULL){
          $MES4 = 0;
        }else{
          $MES4 = $reg1 ['MES4'];
        }

        if($reg1 ['MES3'] == NULL){
          $MES3 = 0;
        }else{
          $MES3 = $reg1 ['MES3'];
        }

        if($reg1 ['MES2'] == NULL){
          $MES2 = 0;
        }else{
          $MES2 = $reg1 ['MES2'];
        }

        if($reg1 ['MES1'] == NULL){
          $MES1 = 0;
        }else{
          $MES1 = $reg1 ['MES1'];
        }

        if($reg1 ['PROMEDIO'] == NULL){
          $PROM_VENTAS = 0;
        }else{
          $PROM_VENTAS = $reg1 ['PROMEDIO'];
        }

        if($reg1 ['STOCK'] == NULL){
          $STOCK_MESES = 0;
        }else{
          $STOCK_MESES = $reg1 ['STOCK'];
        }

        if($reg1 ['BASE'] == NULL){
          $BASE_PEDIDOS = 0;
        }else{
          $BASE_PEDIDOS = $reg1 ['BASE'];
        }

        if($reg1 ['EXISTENCIA'] == NULL){
          $EXIST_FECHA = 0;
        }else{
          $EXIST_FECHA = $reg1 ['EXISTENCIA'];
        }

        if($reg1 ['OC_PEND'] == NULL){
          $O_C_PEND = 0;
        }else{
          $O_C_PEND = $reg1 ['OC_PEND'];
        }

        if($reg1 ['AD_PEDIR'] == NULL){
          $AD_PEDIR = 0;
        }else{
          $AD_PEDIR = $reg1 ['AD_PEDIR'];
        }

        if($reg1 ['DIAS'] == NULL){
          
          $DIAS_CUB = number_format((0),1,".",",");
          $o = 0;

        }else{
          $DC = number_format(($reg1 ['DIAS']),0,".",",");

          if(strlen($DC) > 7){

            $pos_pc = strpos($DC, ',');
            $DIAS_CUB = substr($DC, 0, $pos_pc + 4);
            $o = 1;

          }else{

            $o = 0;
            $DIAS_CUB = number_format(($reg1 ['DIAS']),1,".",",");
          
          }
        }

        $this->SetFont('Arial','',5);
        $this->Cell(10,3,$ITEM,0,0,'L');
        $this->Cell(18,3,substr(utf8_decode($REFERENCIA),0, 20) ,0,0,'L');
        $this->Cell(44,3,substr(utf8_decode($DESCRIPCION), 0, 40),0,0,'L');
        $this->Cell(8,3,substr(utf8_decode($ESTADO), 0, 3),0,0,'L');
        $this->Cell(13,3,number_format(($UND_COMPRA),0,".",","),0,0,'R');

        $this->Cell(13,3,number_format(($MES12),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES11),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES10),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES9),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES8),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES7),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES6),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES5),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES4),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES3),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES2),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($MES1),0,".",","),0,0,'R');

        $this->Cell(13,3,number_format(($PROM_VENTAS),1,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($STOCK_MESES),1,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($BASE_PEDIDOS),1,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($EXIST_FECHA),1,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($O_C_PEND),1,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($AD_PEDIR),1,".",","),0,0,'R');
        if($o == 1){
          $this->Cell(13,3,$DIAS_CUB.' ...',0,0,'R');
        }else{
          $this->Cell(13,3,$DIAS_CUB,0,0,'R'); 
        }
        
        $this->Ln();

      }

      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(340,0,'','T');                            
      $this->Ln();

    }//fin tabla

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','B',6);
        $this->Cell(0,8,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }
  }

  $pdf = new PDF('L','mm','Legal');
  //se definen las variables extendidas de la libreria FPDF
  $pdf->setMarca($texto_marcas);
  $pdf->setEstados($texto_estados);
  $pdf->setFechaActual($fecha_act);
  $pdf->setSql($query);
  $pdf->setTitulos($array_titulo_meses);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Control_pedidos_acumulado_marca_ecuador_'.date('Y-m-d H_i_s').'.pdf');
}

if($opcion == 2){
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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'CÓDIGO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'REFERENCIA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'DESCRIPCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'ESTADO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'UND. COMPRA');

  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', $array_titulo_meses[0]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', $array_titulo_meses[1]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', $array_titulo_meses[2]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', $array_titulo_meses[3]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', $array_titulo_meses[4]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', $array_titulo_meses[5]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', $array_titulo_meses[6]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', $array_titulo_meses[7]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', $array_titulo_meses[8]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', $array_titulo_meses[9]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', $array_titulo_meses[10]);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', $array_titulo_meses[11]);

  $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'PROM. VENTAS');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'STOCK MESES');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'BASE PEDIDOS');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'EXIST. A LA FECHA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'O.C PEND.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'A.D PEDIR');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X1', '# DÍAS CUBRIM.');

  $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
   
  $Fila = 2;  

  foreach ($query1 as $reg1) {

    $ITEM                = $reg1 ['ITEM'];
    $DESCRIPCION         = $reg1 ['DESCRIPCION'];
    $REFERENCIA          = $reg1 ['REFERENCIA'];    
    $ESTADO              = $reg1 ['ESTADO'];

    if($reg1 ['UND_COMPRA'] == NULL){
      $UND_COMPRA = 0;
    }else{
      $UND_COMPRA = $reg1 ['UND_COMPRA'];
    }

    if($reg1 ['MES12'] == NULL){
      $MES12 = 0;
    }else{
      $MES12 = $reg1 ['MES12'];
    }

    if($reg1 ['MES11'] == NULL){
      $MES11 = 0;
    }else{
      $MES11 = $reg1 ['MES11'];
    }

    if($reg1 ['MES10'] == NULL){
      $MES10 = 0;
    }else{
      $MES10 = $reg1 ['MES10'];
    }

    if($reg1 ['MES9'] == NULL){
      $MES9 = 0;
    }else{
      $MES9 = $reg1 ['MES9'];
    }

    if($reg1 ['MES8'] == NULL){
      $MES8 = 0;
    }else{
      $MES8 = $reg1 ['MES8'];
    }

    if($reg1 ['MES7'] == NULL){
      $MES7 = 0;
    }else{
      $MES7 = $reg1 ['MES7'];
    }

    if($reg1 ['MES6'] == NULL){
      $MES6 = 0;
    }else{
      $MES6 = $reg1 ['MES6'];
    }

    if($reg1 ['MES5'] == NULL){
      $MES5 = 0;
    }else{
      $MES5 = $reg1 ['MES5'];
    }

    if($reg1 ['MES4'] == NULL){
      $MES4 = 0;
    }else{
      $MES4 = $reg1 ['MES4'];
    }

    if($reg1 ['MES3'] == NULL){
      $MES3 = 0;
    }else{
      $MES3 = $reg1 ['MES3'];
    }

    if($reg1 ['MES2'] == NULL){
      $MES2 = 0;
    }else{
      $MES2 = $reg1 ['MES2'];
    }

    if($reg1 ['MES1'] == NULL){
      $MES1 = 0;
    }else{
      $MES1 = $reg1 ['MES1'];
    }

    if($reg1 ['PROMEDIO'] == NULL){
      $PROM_VENTAS = 0;
    }else{
      $PROM_VENTAS = $reg1 ['PROMEDIO'];
    }

    if($reg1 ['STOCK'] == NULL){
      $STOCK_MESES = 0;
    }else{
      $STOCK_MESES = $reg1 ['STOCK'];
    }

    if($reg1 ['BASE'] == NULL){
      $BASE_PEDIDOS = 0;
    }else{
      $BASE_PEDIDOS = $reg1 ['BASE'];
    }

    if($reg1 ['EXISTENCIA'] == NULL){
      $EXIST_FECHA = 0;
    }else{
      $EXIST_FECHA = $reg1 ['EXISTENCIA'];
    }

    if($reg1 ['OC_PEND'] == NULL){
      $O_C_PEND = 0;
    }else{
      $O_C_PEND = $reg1 ['OC_PEND'];
    }

    if($reg1 ['AD_PEDIR'] == NULL){
      $AD_PEDIR = 0;
    }else{
      $AD_PEDIR = $reg1 ['AD_PEDIR'];
    }

    if($reg1 ['DIAS'] == NULL){
      
      $DIAS_CUB = number_format((0),1,".",",");
      $o = 0;

    }else{
      $DC = number_format(($reg1 ['DIAS']),0,".",",");

      if(strlen($DC) > 7){

        $pos_pc = strpos($DC, ',');
        $DIAS_CUB = substr($DC, 0, $pos_pc + 4);
        $o = 1;

      }else{

        $o = 0;
        $DIAS_CUB = number_format(($reg1 ['DIAS']),1,".",",");
      
      }
    }


    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, substr($REFERENCIA,0,20));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, substr($DESCRIPCION,0,40));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, substr($ESTADO, 0, 8));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $UND_COMPRA);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $MES12);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $MES11);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $MES10);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $MES9);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $MES8);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $MES7);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $MES6);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $MES5);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $MES4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $MES3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $MES2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $MES1);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $PROM_VENTAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $STOCK_MESES);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $BASE_PEDIDOS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $EXIST_FECHA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $O_C_PEND);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $AD_PEDIR);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $DIAS_CUB);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':Q'.$Fila)->getNumberFormat()->setFormatCode('0'); 
    $objPHPExcel->getActiveSheet()->getStyle('R'.$Fila.':X'.$Fila)->getNumberFormat()->setFormatCode('#,#0.0');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':X'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

  $n = 'Control_pedidos_acumulado_marca_ecuador_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











