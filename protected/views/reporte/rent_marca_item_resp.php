<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model->fecha_inicial;
$fecha_final = $model->fecha_final;
$marca_inicial = trim($model->marca_inicial);
$marca_final = trim($model->marca_final);
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

//se obtiene el nombre de la empresa de las variables de sesión
$nombre_empresa = Yii::app()->user->getState('name_empresa');

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

$query ="
EXEC [dbo].[COM_RENT_FECH_MARCA]
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

    function setFechaActual($fecha_actual){
      $this->fecha_actual = $fecha_actual;
    }

    function setNombreEmpresa($nombre_empresa){
      $this->nombre_empresa = $nombre_empresa;
    }

    function setMarcaInicial($marca_inicial){
      $this->marca_inicial = $marca_inicial;
    }

    function setMarcaFinal($marca_final){
      $this->marca_final = $marca_final;
    }

    function setSql($sql){
      $this->sql = $sql;
    }

    function Header(){
      $this->SetFont('Arial','B',12);
      $this->Cell(200,5,'Rentabilidad por marca / item',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(140,5,utf8_decode($this->nombre_empresa.', '.$this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',9);
      $this->Cell(340,5,utf8_decode('Criterio de búsqueda: Fecha del '.$this->fecha_inicial.' al '.$this->fecha_final.' / Marca de '.$this->marca_inicial.' a '.$this->marca_final),0,0,'L');
      $this->Ln();
      $this->Ln();
      
      //linea superior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(340,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      $this->Ln();  
      
      //cabecera de tabla
      $this->SetFont('Arial','B',6);
  
      $this->Cell(10,2,utf8_decode('MARCA'),0,0,'L');
      $this->Cell(35,2,utf8_decode('REFERENCIA'),0,0,'L');
      $this->Cell(42,2,utf8_decode('DESCRIPCIÓN'),0,0,'L');
      $this->Cell(20,2,utf8_decode('VLR BRUTO'),0,0,'R');
      $this->Cell(18,2,utf8_decode('VLR DESC.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR'),0,0,'R');
      $this->Cell(12,2,utf8_decode('% DESC.'),0,0,'R');
      $this->Cell(18,2,utf8_decode('VLR BRUTO'),0,0,'R');
      $this->Cell(18,2,utf8_decode('VLR DESC.'),0,0,'R');
      $this->Cell(18,2,utf8_decode('VLR'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VENTA'),0,0,'R');
      $this->Cell(18,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(18,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(18,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('RENTABILIDAD'),0,0,'R');
      $this->Cell(15,2,utf8_decode('%'),0,0,'R');
      $this->Cell(18,2,utf8_decode('COSTO'),0,0,'R');   
      $this->Ln(3);   
      
      $this->Cell(10,2,'ITEM',0,0,'L',5);
      $this->Cell(35,2,utf8_decode(''),0,0,'L',5);
      $this->Cell(42,2,utf8_decode(''),0,0,'L',5);
      $this->Cell(20,2,utf8_decode('FACTURA '),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(12,2,utf8_decode('FRA'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('NETA'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('NETO'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode(''),0,0,'R',5);
      $this->Cell(15,2,utf8_decode('RENT.'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('INVENTARIO'),0,0,'R',5);
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
      
      $marca = "";

      $VLR_BRUTO_FAC_sp = 0;
      $VLR_DESC_FAC_sp = 0;
      $VLR_FAC_sp = 0;
      $PORC_DESC_sp = 0;
      $VLR_BRUTO_DVO_sp = 0;
      $VLR_DESC_DVO_sp = 0;
      $VLR_DVO_sp = 0;
      $VENTA_NETA_sp = 0;
      $COST_PROM_FAC_sp = 0;
      $COST_PROM_NDV_sp = 0;
      $COSTO_NETO_sp = 0;
      $RENTABILIDAD_sp = 0;
      $SUBTOTAL_sp = 0;
      $COSTO_INV_sp = 0;

      $VLR_BRUTO_FAC_st = 0;
      $VLR_DESC_FAC_st = 0;
      $VLR_FAC_st = 0;
      $PORC_DESC_st = 0;
      $VLR_BRUTO_DVO_st = 0;
      $VLR_DESC_DVO_st = 0;
      $VLR_DVO_st = 0;
      $VENTA_NETA_st = 0;
      $COST_PROM_FAC_st = 0;
      $COST_PROM_NDV_st = 0;
      $COSTO_NETO_st = 0;
      $RENTABILIDAD_st = 0;
      $SUBTOTAL_st = 0;
      $COSTO_INV_st = 0;

      foreach ($query1 as $reg1) {

        $marca_act = $reg1['MARCA'];
        
        $ITEM              = $reg1 ['ITEM']; 
        $DESCRIPCION       = $reg1 ['DESCRIPCION'];    
        $REFERENCIA        = $reg1 ['REFERENCIA'];    
        $VLR_BRUTO_FAC     = $reg1 ['VLR_BRUTO_FAC']; 
        $VLR_DESC_FAC      = $reg1 ['VLR_DESC_FAC'];
        $VLR_FAC           = $reg1 ['VLR_FAC'];
        $PORC_DESC         = $reg1 ['PORC_DESC'];
        $VLR_BRUTO_DVO     = $reg1 ['VLR_BRUTO_DVO']; 
        $VLR_DESC_DVO      = $reg1 ['VLR_DESC_DVO'];
        $VLR_DVO           = $reg1 ['VLR_DVO'];
        $VENTA_NETA        = $reg1 ['VENTA_NETA'];
        $COST_PROM_FAC    = $reg1 ['COST_PROM_FAC'];
        $COST_PROM_NDV    = $reg1 ['COST_PROM_NDV'];
        $COSTO_NETO        = $reg1 ['COSTO_NETO'];
        $RENTABILIDAD      = $reg1 ['RENTABILIDAD'];
        $SUBTOTAL          = $reg1 ['SUBTOTAL']; 
        $COSTO_INV         = $reg1 ['COSTO_INV'];    

        if($marca != $marca_act){

          if($marca != ""){
            $this->SetFont('Arial','B',5);
            $this->Cell(87,5,'TOTAL '.$marca,0,0,'R');
            $this->Cell(20,5,number_format(($VLR_BRUTO_FAC_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($VLR_DESC_FAC_sp),2,".",","),0,0,'R');
            $this->Cell(20,5,number_format(($VLR_FAC_sp),2,".",","),0,0,'R');
            if($PORC_DESC_sp > 0){
              $PORC_DESC_sp = ($VLR_DESC_FAC_sp / $VLR_BRUTO_FAC_sp) * 100;
            }else{
              $PORC_DESC_sp = 0; 
            }
            $this->Cell(12,5,number_format(($PORC_DESC_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($VLR_BRUTO_DVO_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($VLR_DESC_DVO_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($VLR_DVO_sp),2,".",","),0,0,'R');
            $this->Cell(20,5,number_format(($VENTA_NETA_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($COST_PROM_FAC_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($COST_PROM_NDV_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($COSTO_NETO_sp),2,".",","),0,0,'R');
            $this->Cell(20,5,number_format(($RENTABILIDAD_sp),2,".",","),0,0,'R');
            if($VLR_FAC_sp > 0){
              $SUBTOTAL_sp = ($RENTABILIDAD_sp / $VLR_FAC_sp) * 100;
            }else{
              $SUBTOTAL_sp = 0; 
            }
            $this->Cell(15,5,number_format(($SUBTOTAL_sp),2,".",","),0,0,'R');
            $this->Cell(18,5,number_format(($COSTO_INV_sp),2,".",","),0,0,'R');
                                           
            $VLR_BRUTO_FAC_sp = 0;
            $VLR_DESC_FAC_sp = 0;
            $VLR_FAC_sp = 0;
            $PORC_DESC_sp = 0;
            $VLR_BRUTO_DVO_sp = 0;
            $VLR_DESC_DVO_sp = 0;
            $VLR_DVO_sp = 0;
            $VENTA_NETA_sp = 0;
            $COST_PROM_FAC_sp = 0;
            $COST_PROM_NDV_sp = 0;
            $COSTO_NETO_sp = 0;
            $RENTABILIDAD_sp = 0;
            $SUBTOTAL_sp = 0;
            $COSTO_INV_sp = 0;
          }

          $marca = $reg1['MARCA'];
          $this->SetFont('Arial','B',7);
          $this->Ln();
          $this->Cell(340,8, $marca ,0,0,'L');
          $this->Ln();
        }

        $this->SetFont('Arial','',6);
        $this->Cell(10,3,$ITEM,0,0,'L');
        $this->Cell(35,3,$REFERENCIA,0,0,'L');
        $this->Cell(42,3,substr(utf8_decode($DESCRIPCION), 0, 30),0,0,'L');
        $this->Cell(20,3,number_format(($VLR_BRUTO_FAC),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($VLR_DESC_FAC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_FAC),2,".",","),0,0,'R');
        $this->Cell(12,3,number_format(($PORC_DESC),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($VLR_BRUTO_DVO),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($VLR_DESC_DVO),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($VLR_DVO),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VENTA_NETA),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($COST_PROM_FAC),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($COST_PROM_NDV),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($COSTO_NETO),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($RENTABILIDAD),2,".",","),0,0,'R');
        $this->Cell(15,3,number_format(($SUBTOTAL),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($COSTO_INV),2,".",","),0,0,'R');
        $this->Ln();

        $VLR_BRUTO_FAC_sp += $VLR_BRUTO_FAC;
        $VLR_DESC_FAC_sp += $VLR_DESC_FAC;
        $VLR_FAC_sp += $VLR_FAC;
        $PORC_DESC_sp += $PORC_DESC;
        $VLR_BRUTO_DVO_sp += $VLR_BRUTO_DVO;
        $VLR_DESC_DVO_sp += $VLR_DESC_DVO;
        $VLR_DVO_sp += $VLR_DVO;
        $VENTA_NETA_sp += $VENTA_NETA;
        $COST_PROM_FAC_sp += $COST_PROM_FAC;
        $COST_PROM_NDV_sp += $COST_PROM_NDV;
        $COSTO_NETO_sp += $COSTO_NETO;
        $RENTABILIDAD_sp += $RENTABILIDAD;
        $COSTO_INV_sp += $COSTO_INV;

        $VLR_BRUTO_FAC_st += $VLR_BRUTO_FAC;
        $VLR_DESC_FAC_st += $VLR_DESC_FAC;
        $VLR_FAC_st += $VLR_FAC;
        $VLR_BRUTO_DVO_st += $VLR_BRUTO_DVO;
        $VLR_DESC_DVO_st += $VLR_DESC_DVO;
        $VLR_DVO_st += $VLR_DVO;
        $VENTA_NETA_st += $VENTA_NETA;
        $COST_PROM_FAC_st += $COST_PROM_FAC;
        $COST_PROM_NDV_st += $COST_PROM_NDV;
        $COSTO_NETO_st += $COSTO_NETO;
        $RENTABILIDAD_st += $RENTABILIDAD;
        $COSTO_INV_st += $COSTO_INV;

      }

      //se imprime el total de la ultima marca
      $this->SetFont('Arial','B',5);
      $this->Cell(87,5,'TOTAL '.$marca,0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_FAC_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_FAC_sp),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_FAC_sp),2,".",","),0,0,'R');
      if($PORC_DESC_sp > 0){
        $PORC_DESC_sp = ($VLR_DESC_FAC_sp / $VLR_BRUTO_FAC_sp) * 100;
      }else{
        $PORC_DESC_sp = 0; 
      }
      $this->Cell(12,5,number_format(($PORC_DESC_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_BRUTO_DVO_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_DVO_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DVO_sp),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VENTA_NETA_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COST_PROM_FAC_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COST_PROM_NDV_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COSTO_NETO_sp),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($RENTABILIDAD_sp),2,".",","),0,0,'R');
      if($VLR_FAC_sp > 0){
        $SUBTOTAL_sp = ($RENTABILIDAD_sp / $VLR_FAC_sp) * 100;
      }else{
        $SUBTOTAL_sp = 0; 
      }
      $this->Cell(15,5,number_format(($SUBTOTAL_sp),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COSTO_INV_sp),2,".",","),0,0,'R');

      $this->SetDrawColor(0,0,0);
      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(340,0,'','T');
      $this->SetDrawColor(255,255,255);
      $this->Ln();

      $this->SetFont('Arial','B',5);
      $this->Cell(87,5,'TOTAL GENERAL',0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_FAC_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_FAC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_FAC_st),2,".",","),0,0,'R');
      $PORC_DESC_st = ($VLR_DESC_FAC_st / $VLR_BRUTO_FAC_st) * 100; 
      $this->Cell(12,5,number_format(($PORC_DESC_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_BRUTO_DVO_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_DVO_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DVO_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VENTA_NETA_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COST_PROM_FAC_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COST_PROM_NDV_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COSTO_NETO_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($RENTABILIDAD_st),2,".",","),0,0,'R');
      $SUBTOTAL_st = ($RENTABILIDAD_st / $VLR_FAC_st) * 100; 
      $this->Cell(15,5,number_format(($SUBTOTAL_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($COSTO_INV_st),2,".",","),0,0,'R');

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
  $pdf->setFechaInicial($fecha_inicial);
  $pdf->setFechaFinal($fecha_final);
  $pdf->setMarcaInicial($marca_inicial);
  $pdf->setMarcaFinal($marca_final);
  $pdf->setFechaActual($fecha_act);
  $pdf->setNombreEmpresa($nombre_empresa);
  $pdf->setSql($query);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Rentabilidad_marca_item_'.date('Y-m-d H_i_s').'.pdf');
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
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'VLR BRUTO FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VLR DESC. FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'VLR FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', '% DESC. FRA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VLR BRUTO DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'VALOR DESC. DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'VALOR DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'VENTA NETA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'COSTO FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'COSTO DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'COSTO NETO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'RENTABILIDAD');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', '% RENT.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'COSTO INVENTARIO');

  $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
      
  $Fila = 2; 
  $marca = "";

  $VLR_BRUTO_FAC_sp = 0;
  $VLR_DESC_FAC_sp = 0;
  $VLR_FAC_sp = 0;
  $PORC_DESC_sp = 0;
  $VLR_BRUTO_DVO_sp = 0;
  $VLR_DESC_DVO_sp = 0;
  $VLR_DVO_sp = 0;
  $VENTA_NETA_sp = 0;
  $COST_PROM_FAC_sp = 0;
  $COST_PROM_NDV_sp = 0;
  $COSTO_NETO_sp = 0;
  $RENTABILIDAD_sp = 0;
  $SUBTOTAL_sp = 0;
  $COSTO_INV_sp = 0;

  $VLR_BRUTO_FAC_st = 0;
  $VLR_DESC_FAC_st = 0;
  $VLR_FAC_st = 0;
  $PORC_DESC_st = 0;
  $VLR_BRUTO_DVO_st = 0;
  $VLR_DESC_DVO_st = 0;
  $VLR_DVO_st = 0;
  $VENTA_NETA_st = 0;
  $COST_PROM_FAC_st = 0;
  $COST_PROM_NDV_st = 0;
  $COSTO_NETO_st = 0;
  $RENTABILIDAD_st = 0;
  $SUBTOTAL_st = 0;
  $COSTO_INV_st = 0;

  foreach ($query1 as $reg1) {

    $marca_act = $reg1['MARCA'];
      
    $ITEM              = $reg1 ['ITEM']; 
    $DESCRIPCION       = $reg1 ['DESCRIPCION'];    
    $REFERENCIA        = $reg1 ['REFERENCIA'];    
    $VLR_BRUTO_FAC     = $reg1 ['VLR_BRUTO_FAC']; 
    $VLR_DESC_FAC      = $reg1 ['VLR_DESC_FAC'];
    $VLR_FAC           = $reg1 ['VLR_FAC'];
    $PORC_DESC         = $reg1 ['PORC_DESC'];
    $VLR_BRUTO_DVO     = $reg1 ['VLR_BRUTO_DVO']; 
    $VLR_DESC_DVO      = $reg1 ['VLR_DESC_DVO'];
    $VLR_DVO           = $reg1 ['VLR_DVO'];
    $VENTA_NETA        = $reg1 ['VENTA_NETA'];
    $COST_PROM_FAC    = $reg1 ['COST_PROM_FAC'];
    $COST_PROM_NDV    = $reg1 ['COST_PROM_NDV'];
    $COSTO_NETO        = $reg1 ['COSTO_NETO'];
    $RENTABILIDAD      = $reg1 ['RENTABILIDAD'];
    $SUBTOTAL          = $reg1 ['SUBTOTAL'];
    $COSTO_INV         = $reg1 ['COSTO_INV']; 

    if($marca != $marca_act){

      if($marca != ""){

        $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, 'TOTAL '.$marca);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_BRUTO_FAC_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $VLR_DESC_FAC_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VLR_FAC_sp);
        $PORC_DESC_sp = ($VLR_DESC_FAC_sp / $VLR_BRUTO_FAC_sp) * 100;
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $PORC_DESC_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_BRUTO_DVO_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VLR_DESC_DVO_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VLR_DVO_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VENTA_NETA_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_FAC_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COST_PROM_NDV_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $COSTO_NETO_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $RENTABILIDAD_sp);
        $SUBTOTAL_sp = ($RENTABILIDAD_sp / $VLR_FAC_sp) * 100; 
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $SUBTOTAL_sp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $COSTO_INV_sp);

       
        $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':Q'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getFont()->setBold(true);

        $Fila = $Fila + 1;
                             
        $VLR_BRUTO_FAC_sp = 0;
        $VLR_DESC_FAC_sp = 0;
        $VLR_FAC_sp = 0;
        $VLR_BRUTO_DVO_sp = 0;
        $VLR_DESC_DVO_sp = 0;
        $VLR_DVO_sp = 0;
        $VENTA_NETA_sp = 0;
        $COST_PROM_FAC_sp = 0;
        $COST_PROM_NDV_sp = 0;
        $COSTO_NETO_sp = 0;
        $RENTABILIDAD_sp = 0;
        $COSTO_INV_sp = 0;
      }

      $marca = $reg1['MARCA'];

      $Fila = $Fila + 1;
      
      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $marca);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getFont()->setBold(true);
      
      $Fila = $Fila + 2;

    }

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_BRUTO_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $VLR_DESC_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VLR_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $PORC_DESC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_BRUTO_DVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VLR_DESC_DVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VLR_DVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VENTA_NETA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COST_PROM_NDV);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $COSTO_NETO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $RENTABILIDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $SUBTOTAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $COSTO_INV);
        
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':Q'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila = $Fila + 1;

    $VLR_BRUTO_FAC_sp += $VLR_BRUTO_FAC;
    $VLR_DESC_FAC_sp += $VLR_DESC_FAC;
    $VLR_FAC_sp += $VLR_FAC;
    $VLR_BRUTO_DVO_sp += $VLR_BRUTO_DVO;
    $VLR_DESC_DVO_sp += $VLR_DESC_DVO;
    $VLR_DVO_sp += $VLR_DVO;
    $VENTA_NETA_sp += $VENTA_NETA;
    $COST_PROM_FAC_sp += $COST_PROM_FAC;
    $COST_PROM_NDV_sp += $COST_PROM_NDV;
    $COSTO_NETO_sp += $COSTO_NETO;
    $RENTABILIDAD_sp += $RENTABILIDAD;
    $COSTO_INV_sp += $COSTO_INV;

    $VLR_BRUTO_FAC_st += $VLR_BRUTO_FAC;
    $VLR_DESC_FAC_st += $VLR_DESC_FAC;
    $VLR_FAC_st += $VLR_FAC;
    $VLR_BRUTO_DVO_st += $VLR_BRUTO_DVO;
    $VLR_DESC_DVO_st += $VLR_DESC_DVO;
    $VLR_DVO_st += $VLR_DVO;
    $VENTA_NETA_st += $VENTA_NETA;
    $COST_PROM_FAC_st += $COST_PROM_FAC;
    $COST_PROM_NDV_st += $COST_PROM_NDV;
    $COSTO_NETO_st += $COSTO_NETO;
    $RENTABILIDAD_st += $RENTABILIDAD;
    $COSTO_INV_st += $COSTO_INV;

  }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, 'TOTAL '.$marca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_BRUTO_FAC_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $VLR_DESC_FAC_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VLR_FAC_sp);
  $PORC_DESC_sp = ($VLR_DESC_FAC_sp / $VLR_BRUTO_FAC_sp) * 100;
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $PORC_DESC_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_BRUTO_DVO_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VLR_DESC_DVO_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VLR_DVO_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VENTA_NETA_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_FAC_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COST_PROM_NDV_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $COSTO_NETO_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $RENTABILIDAD_sp);
  $SUBTOTAL_sp = ($RENTABILIDAD_sp / $VLR_FAC_sp) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $SUBTOTAL_sp);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $COSTO_INV_sp);
 
  $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':Q'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, 'TOTAL GENERAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_BRUTO_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $VLR_DESC_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VLR_FAC_st);
  $PORC_DESC_st = ($VLR_DESC_FAC_st / $VLR_BRUTO_FAC_st) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $PORC_DESC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_BRUTO_DVO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VLR_DESC_DVO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VLR_DVO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $VENTA_NETA_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COST_PROM_NDV_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $COSTO_NETO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $RENTABILIDAD_st);
  $SUBTOTAL_st = ($RENTABILIDAD_st / $VLR_FAC_st) * 100;
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $SUBTOTAL_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $COSTO_INV_st);
 
  $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':Q'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':Q'.$Fila)->getFont()->setBold(true);

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

  $n = 'Rentabilidad_marca_item_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;
  
}

?>











