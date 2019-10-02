<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model->fecha_inicial;
$fecha_final = $model->fecha_final;
$marca_inicial = trim($model->marca_inicial);
$marca_final = trim($model->marca_final);

$origen = $model->origen;
if ($origen == "") {
  $origen = 0;
  $texto_origen = "TODOS";
} else if ($origen == 1) {
  $texto_origen = "NACIONAL";
} else if ($origen == 1) {
  $texto_origen = "EXTERIOR";
}

//opcion: 1. PDF, 2. EXCEL
$opcion = $model->opcion_exp;

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

$query= "
EXEC   [dbo].[COM_VENT_PROM_FECH_MARC_ORI]
  @OPT = ".$origen.",
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."',
  @MARCA1 = N'".$marca_inicial."',
  @MARCA2 = N'".$marca_final."'
";

/*fin configuración array de datos*/

if($opcion == 1){
  //PDF

  //se incluye la libreria pdf
  require_once Yii::app()->basePath . '/extensions/fpdf/fpdf.php';

  class PDF extends FPDF{
    
    function setFechaInicial($fecha_inicial){
      $this->fecha_inicial = $fecha_inicial;
    }

    function setFechaFinal($fecha_inicial){
      $this->fecha_final = $fecha_inicial;
    }

    function setOrigen($origen){
      $this->origen = $origen;
    }

    function setMarcaInicial($marca_inicial){
      $this->marca_inicial = $marca_inicial;
    }

    function setMarcaFinal($marca_final){
      $this->marca_final = $marca_final;
    }

    function setFechaActual($fecha_actual){
      $this->fecha_actual = $fecha_actual;
    }

    function setSql($sql){
      $this->sql = $sql;
    }

    function Header(){
      $this->SetFont('Arial','B',12);
      $this->Cell(200,5,'Reporte ventas por periodo + promociones',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(80,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',9);
      $this->Cell(280,5,utf8_decode('Criterio de búsqueda: Fecha del '.$this->fecha_inicial.' al '.$this->fecha_final.' / Origen '.$this->origen.' / Marca de '.$this->marca_inicial.' a '.$this->marca_final),0,0,'L');

      $this->Ln();
      $this->Ln();
      
      //linea superior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(280,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      $this->Ln();  
      
      //cabecera de tabla
      $this->SetFont('Arial','B',6);
  
      $this->Cell(10,2,utf8_decode('MARCA'),0,0,'L');
      $this->Cell(35,2,utf8_decode('REFERENCIA'),0,0,'L');
      $this->Cell(60,2,utf8_decode('DESCRIPCIÓN'),0,0,'L');
      $this->Cell(10,2,utf8_decode('TIPO'),0,0,'L');
      $this->Cell(14,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(14,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(14,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(22,2,utf8_decode('VALOR'),0,0,'R');
      $this->Cell(22,2,utf8_decode('VALOR'),0,0,'R');
      $this->Cell(22,2,utf8_decode('VALOR'),0,0,'R');
      $this->Cell(19,2,utf8_decode('VALOR'),0,0,'R');
      $this->Cell(19,2,utf8_decode('VALOR'),0,0,'R');
      $this->Cell(19,2,utf8_decode('VALOR'),0,0,'R');

      
      $this->Ln(3);   
      
      $this->Cell(10,2,utf8_decode('ITEM'),0,0,'L');
      $this->Cell(35,2,utf8_decode(''),0,0,'L');
      $this->Cell(60,2,utf8_decode(''),0,0,'L');
      $this->Cell(10,2,utf8_decode(''),0,0,'L');
      $this->Cell(14,2,utf8_decode('PROM.'),0,0,'R');
      $this->Cell(14,2,utf8_decode('ITEM'),0,0,'R');
      $this->Cell(14,2,utf8_decode('TOTAL'),0,0,'R');
      $this->Cell(22,2,utf8_decode('PROM.'),0,0,'R');
      $this->Cell(22,2,utf8_decode('ITEM'),0,0,'R');
      $this->Cell(22,2,utf8_decode('TOTAL'),0,0,'R');
      $this->Cell(19,2,utf8_decode('DSCTO PROM.'),0,0,'R');
      $this->Cell(19,2,utf8_decode('DSCTO ITEM'),0,0,'R');
      $this->Cell(19,2,utf8_decode('DSCTO TOTAL'),0,0,'R');

      $this->Ln(3);
      
      //linea inferior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(280,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      

      $this->Ln();
    }

    function Tabla(){

      $query1 = Yii::app()->db->createCommand($this->sql)->queryAll();
      
      $marca = "";

      $CANT_PROMOCION_sp = 0;
      $CANT_ITEM_sp = 0;
      $CANT_TOTAL_sp = 0;
      $VALOR_PROMO_sp = 0;
      $VALOR_IT_sp = 0;
      $VALOR_TOTAL_sp = 0;
      $VLR_DSCTO_PROM_sp = 0;
      $VLR_DSCTO_ITEM_sp = 0;
      $VLR_DSCTO_TOTAL_sp = 0;

      $CANT_PROMOCION_st = 0;
      $CANT_ITEM_st = 0;
      $CANT_TOTAL_st = 0;
      $VALOR_PROMO_st = 0;
      $VALOR_IT_st = 0;
      $VALOR_TOTAL_st = 0;
      $VLR_DSCTO_PROM_st = 0;
      $VLR_DSCTO_ITEM_st = 0;
      $VLR_DSCTO_TOTAL_st = 0;

      foreach ($query1 as $reg1) {

        $marca_act = $reg1['I_CRI_MARCA'];
        
        $ITEM               = $reg1 ['ITEM']; 
        $DESCRIPCION        = $reg1 ['DESCRIPCION'];    
        $REFERENCIA         = $reg1 ['REFERENCIA'];    
        $TIPO               = $reg1 ['TIPO'];
        if ($TIPO == "") {
          $TIPO = "-"; 
        }   
        $CANT_PROMOCION     = $reg1 ['CANT_PROMOCION'];    
        $CANT_ITEM          = $reg1 ['CANT_ITEM'];    
        $CANT_TOTAL         = $reg1 ['CANT_TOTAL'];    
        $VALOR_PROMO        = $reg1 ['VALOR_PROMO'];    
        $VALOR_IT           = $reg1 ['VALOR_IT'];    
        $VALOR_TOTAL        = $reg1 ['VALOR_TOTAL'];    
        $VLR_DSCTO_PROM     = $reg1 ['VLR_DSCTO_PROM'];    
        $VLR_DSCTO_ITEM     = $reg1 ['VLR_DSCTO_ITEM'];    
        $VLR_DSCTO_TOTAL    = $reg1 ['VLR_DSCTO_TOTAL'];

        if($marca != $marca_act){

          if($marca != ""){
            $this->SetFont('Arial','B',6);
            $this->Cell(115,5,'TOTAL '.$marca,0,0,'R');
            $this->Cell(14,5,number_format(($CANT_PROMOCION_sp),0,".",","),0,0,'R');
            $this->Cell(14,5,number_format(($CANT_ITEM_sp),0,".",","),0,0,'R');
            $this->Cell(14,5,number_format(($CANT_TOTAL_sp),0,".",","),0,0,'R');
            $this->Cell(22,5,number_format(($VALOR_PROMO_sp),2,".",","),0,0,'R');
            $this->Cell(22,5,number_format(($VALOR_IT_sp),2,".",","),0,0,'R');
            $this->Cell(22,5,number_format(($VALOR_TOTAL_sp),2,".",","),0,0,'R');
            $this->Cell(19,5,number_format(($VLR_DSCTO_PROM_sp),2,".",","),0,0,'R');
            $this->Cell(19,5,number_format(($VLR_DSCTO_ITEM_sp),2,".",","),0,0,'R');
            $this->Cell(19,5,number_format(($VLR_DSCTO_TOTAL_sp),2,".",","),0,0,'R');
                                 
            $CANT_PROMOCION_sp = 0;
            $CANT_ITEM_sp = 0;
            $CANT_TOTAL_sp = 0;
            $VALOR_PROMO_sp = 0;
            $VALOR_IT_sp = 0;
            $VALOR_TOTAL_sp = 0;
            $VLR_DSCTO_PROM_sp = 0;
            $VLR_DSCTO_ITEM_sp = 0;
            $VLR_DSCTO_TOTAL_sp = 0;
          }

          $marca = $reg1['I_CRI_MARCA'];
          $this->SetFont('Arial','B',7);
          $this->Ln();
          $this->Cell(280,8, $marca ,0,0,'L');
          $this->Ln();
        }

        $this->SetFont('Arial','',6);
        $this->Cell(10,3,$ITEM,0,0,'L');
        $this->Cell(35,3,$REFERENCIA,0,0,'L');
        $this->Cell(60,3,utf8_decode($DESCRIPCION),0,0,'L');
        $this->Cell(10,3,$TIPO,0,0,'L');
        $this->Cell(14,3,number_format(($CANT_PROMOCION),0,".",","),0,0,'R');
        $this->Cell(14,3,number_format(($CANT_ITEM),0,".",","),0,0,'R');
        $this->Cell(14,3,number_format(($CANT_TOTAL),0,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($VALOR_PROMO),2,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($VALOR_IT),2,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($VALOR_TOTAL),2,".",","),0,0,'R');
        $this->Cell(19,3,number_format(($VLR_DSCTO_PROM),2,".",","),0,0,'R');
        $this->Cell(19,3,number_format(($VLR_DSCTO_ITEM),2,".",","),0,0,'R');
        $this->Cell(19,3,number_format(($VLR_DSCTO_TOTAL),2,".",","),0,0,'R');
        $this->Ln();

        $CANT_PROMOCION_sp += $CANT_PROMOCION;
        $CANT_ITEM_sp += $CANT_ITEM;
        $CANT_TOTAL_sp += $CANT_TOTAL;
        $VALOR_PROMO_sp += $VALOR_PROMO;
        $VALOR_IT_sp += $VALOR_IT;
        $VALOR_TOTAL_sp += $VALOR_TOTAL;
        $VLR_DSCTO_PROM_sp += $VLR_DSCTO_PROM;
        $VLR_DSCTO_ITEM_sp += $VLR_DSCTO_ITEM;
        $VLR_DSCTO_TOTAL_sp += $VLR_DSCTO_TOTAL;

        $CANT_PROMOCION_st += $CANT_PROMOCION;
        $CANT_ITEM_st += $CANT_ITEM;
        $CANT_TOTAL_st += $CANT_TOTAL;
        $VALOR_PROMO_st += $VALOR_PROMO;
        $VALOR_IT_st += $VALOR_IT;
        $VALOR_TOTAL_st += $VALOR_TOTAL;
        $VLR_DSCTO_PROM_st += $VLR_DSCTO_PROM;
        $VLR_DSCTO_ITEM_st += $VLR_DSCTO_ITEM;
        $VLR_DSCTO_TOTAL_st += $VLR_DSCTO_TOTAL;

      }

      //se imprime el total de la ultima marca
      $this->SetFont('Arial','B',6);
      $this->Cell(115,5,'TOTAL '.$marca,0,0,'R');
      $this->Cell(14,5,number_format(($CANT_PROMOCION_sp),0,".",","),0,0,'R');
      $this->Cell(14,5,number_format(($CANT_ITEM_sp),0,".",","),0,0,'R');
      $this->Cell(14,5,number_format(($CANT_TOTAL_sp),0,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VALOR_PROMO_sp),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VALOR_IT_sp),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VALOR_TOTAL_sp),2,".",","),0,0,'R');
      $this->Cell(19,5,number_format(($VLR_DSCTO_PROM_sp),2,".",","),0,0,'R');
      $this->Cell(19,5,number_format(($VLR_DSCTO_ITEM_sp),2,".",","),0,0,'R');
      $this->Cell(19,5,number_format(($VLR_DSCTO_TOTAL_sp),2,".",","),0,0,'R');

      $this->SetDrawColor(0,0,0);
      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(280,0,'','T');
      $this->SetDrawColor(255,255,255);
      $this->Ln();

      $this->SetFont('Arial','B',6);
      $this->Cell(115,5,'TOTAL GENERAL',0,0,'R');
      $this->Cell(14,5,number_format(($CANT_PROMOCION_st),0,".",","),0,0,'R');
      $this->Cell(14,5,number_format(($CANT_ITEM_st),0,".",","),0,0,'R');
      $this->Cell(14,5,number_format(($CANT_TOTAL_st),0,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VALOR_PROMO_st),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VALOR_IT_st),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VALOR_TOTAL_st),2,".",","),0,0,'R');
      $this->Cell(19,5,number_format(($VLR_DSCTO_PROM_st),2,".",","),0,0,'R');
      $this->Cell(19,5,number_format(($VLR_DSCTO_ITEM_st),2,".",","),0,0,'R');
      $this->Cell(19,5,number_format(($VLR_DSCTO_TOTAL_st),2,".",","),0,0,'R');

      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(280,0,'','T');                            
      $this->Ln();

    }//fin tabla

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','B',6);
        $this->Cell(0,8,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }
  }

  $pdf = new PDF('L','mm','A4');
  //se definen las variables extendidas de la libreria FPDF
  $pdf->setFechaInicial($fecha_inicial);
  $pdf->setFechaFinal($fecha_final);
  $pdf->setOrigen($texto_origen);
  $pdf->setMarcaInicial($marca_inicial);
  $pdf->setMarcaFinal($marca_final);
  $pdf->setFechaActual($fecha_act);
  $pdf->setSql($query);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Ventas_periodo_promocion_'.date('Y-m-d H_i_s').'.pdf');
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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'MARCA / ITEM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'REFERENCIA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'DESCRIPCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'TIPO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'CANT. PROM.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'CANT. ITEM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'CANT. TOTAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VALOR PROM.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'VALOR ITEM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'VALOR TOTAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'VALOR DSCTO PROM.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'VALOR DSCTO ITEM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'VALOR DSCTO TOTAL');

  $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
      
  $Fila = 2; 
  $marca = "";

  $CANT_PROMOCION_sp = 0;
  $CANT_ITEM_sp = 0;
  $CANT_TOTAL_sp = 0;
  $VALOR_PROMO_sp = 0;
  $VALOR_IT_sp = 0;
  $VALOR_TOTAL_sp = 0;
  $VLR_DSCTO_PROM_sp = 0;
  $VLR_DSCTO_ITEM_sp = 0;
  $VLR_DSCTO_TOTAL_sp = 0;

  $CANT_PROMOCION_st = 0;
  $CANT_ITEM_st = 0;
  $CANT_TOTAL_st = 0;
  $VALOR_PROMO_st = 0;
  $VALOR_IT_st = 0;
  $VALOR_TOTAL_st = 0;
  $VLR_DSCTO_PROM_st = 0;
  $VLR_DSCTO_ITEM_st = 0;
  $VLR_DSCTO_TOTAL_st = 0;

  foreach ($query1 as $reg1) {

    $marca_act = $reg1['I_CRI_MARCA'];
    
    $ITEM               = $reg1 ['ITEM']; 
    $DESCRIPCION        = $reg1 ['DESCRIPCION'];    
    $REFERENCIA         = $reg1 ['REFERENCIA'];    
    $TIPO               = $reg1 ['TIPO'];
    if ($TIPO == "") {
      $TIPO = "-"; 
    }      
    $CANT_PROMOCION     = $reg1 ['CANT_PROMOCION'];    
    $CANT_ITEM          = $reg1 ['CANT_ITEM'];    
    $CANT_TOTAL         = $reg1 ['CANT_TOTAL'];    
    $VALOR_PROMO        = $reg1 ['VALOR_PROMO'];    
    $VALOR_IT           = $reg1 ['VALOR_IT'];    
    $VALOR_TOTAL        = $reg1 ['VALOR_TOTAL'];    
    $VLR_DSCTO_PROM     = $reg1 ['VLR_DSCTO_PROM'];    
    $VLR_DSCTO_ITEM     = $reg1 ['VLR_DSCTO_ITEM'];    
    $VLR_DSCTO_TOTAL    = $reg1 ['VLR_DSCTO_TOTAL'];

    if($marca != $marca_act){

      if($marca != ""){

        $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, 'TOTAL '.$marca);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CANT_PROMOCION_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CANT_ITEM_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $CANT_TOTAL_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VALOR_PROMO_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VALOR_IT_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VALOR_TOTAL_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VLR_DSCTO_PROM_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $VLR_DSCTO_ITEM_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $VLR_DSCTO_TOTAL_sp);

        $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':G'.$Fila)->getNumberFormat()->setFormatCode('0');        
        $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':M'.$Fila)->getFont()->setBold(true);

        $Fila = $Fila + 1;
                             
        $CANT_PROMOCION_sp = 0;
        $CANT_ITEM_sp = 0;
        $CANT_TOTAL_sp = 0;
        $VALOR_PROMO_sp = 0;
        $VALOR_IT_sp = 0;
        $VALOR_TOTAL_sp = 0;
        $VLR_DSCTO_PROM_sp = 0;
        $VLR_DSCTO_ITEM_sp = 0;
        $VLR_DSCTO_TOTAL_sp = 0;
      }

      $marca = $reg1['I_CRI_MARCA'];

      $Fila = $Fila + 1;
      
      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $marca);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getFont()->setBold(true);
      
      $Fila = $Fila + 2;

    }

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $TIPO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CANT_PROMOCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CANT_ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $CANT_TOTAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VALOR_PROMO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VALOR_IT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VALOR_TOTAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VLR_DSCTO_PROM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $VLR_DSCTO_ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $VLR_DSCTO_TOTAL);


    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':G'.$Fila)->getNumberFormat()->setFormatCode('0');        
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila = $Fila + 1;

    $CANT_PROMOCION_sp += $CANT_PROMOCION;
    $CANT_ITEM_sp += $CANT_ITEM;
    $CANT_TOTAL_sp += $CANT_TOTAL;
    $VALOR_PROMO_sp += $VALOR_PROMO;
    $VALOR_IT_sp += $VALOR_IT;
    $VALOR_TOTAL_sp += $VALOR_TOTAL;
    $VLR_DSCTO_PROM_sp += $VLR_DSCTO_PROM;
    $VLR_DSCTO_ITEM_sp += $VLR_DSCTO_ITEM;
    $VLR_DSCTO_TOTAL_sp += $VLR_DSCTO_TOTAL;

    $CANT_PROMOCION_st += $CANT_PROMOCION;
    $CANT_ITEM_st += $CANT_ITEM;
    $CANT_TOTAL_st += $CANT_TOTAL;
    $VALOR_PROMO_st += $VALOR_PROMO;
    $VALOR_IT_st += $VALOR_IT;
    $VALOR_TOTAL_st += $VALOR_TOTAL;
    $VLR_DSCTO_PROM_st += $VLR_DSCTO_PROM;
    $VLR_DSCTO_ITEM_st += $VLR_DSCTO_ITEM;
    $VLR_DSCTO_TOTAL_st += $VLR_DSCTO_TOTAL;

  }

  //se imprime el total de la ultima marca
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, 'TOTAL '.$marca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CANT_PROMOCION_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CANT_ITEM_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $CANT_TOTAL_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VALOR_PROMO_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VALOR_IT_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VALOR_TOTAL_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VLR_DSCTO_PROM_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $VLR_DSCTO_ITEM_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $VLR_DSCTO_TOTAL_sp);

  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':G'.$Fila)->getNumberFormat()->setFormatCode('0');        
  $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':M'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, 'TOTAL GENERAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CANT_PROMOCION_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CANT_ITEM_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $CANT_TOTAL_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VALOR_PROMO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VALOR_IT_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VALOR_TOTAL_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VLR_DSCTO_PROM_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $VLR_DSCTO_ITEM_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $VLR_DSCTO_TOTAL_st);

  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':G'.$Fila)->getNumberFormat()->setFormatCode('0');        
  $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':M'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

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

  $n = 'Ventas_periodo_promocion_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











