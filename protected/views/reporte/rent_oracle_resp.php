<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model->fecha_inicial;
$fecha_final = $model->fecha_final;
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
  EXEC  [dbo].[COM_RENT_FECH_ORACLE_SINITEM]
    @FECHA1 = N'".$FechaM1."',
    @FECHA2 = N'".$FechaM2."'
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

    function setSql($sql){
      $this->sql = $sql;
    }

    function Header(){
      $this->SetFont('Arial','B',12);
      $this->Cell(160,5,'Rentabilidad por oracle',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(120,5,utf8_decode($this->nombre_empresa.', '.$this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',9);
      $this->Cell(280,5,utf8_decode('Criterio de búsqueda: Fecha del '.$this->fecha_inicial.' al '.$this->fecha_final),0,0,'L');
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
  
      $this->Cell(29,2,utf8_decode('DESC. ORACLE'),0,0,'L');
      $this->Cell(20,2,utf8_decode('VLR BRUTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR DESC.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR'),0,0,'R');
      $this->Cell(14,2,utf8_decode('% DESC.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR BRUTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR DESC.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VENTA'),0,0,'R');
      $this->Cell(20,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('RENTABILIDAD'),0,0,'R');
      $this->Cell(17,2,utf8_decode('%'),0,0,'R');    
      $this->Ln(3);   
      
      $this->Cell(29,2,'',0,0,'L',5);
      $this->Cell(20,2,utf8_decode('FACTURA '),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(14,2,utf8_decode('FRA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('NETA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('NETO'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode(''),0,0,'R',5);
      $this->Cell(17,2,utf8_decode('RENT.'),0,0,'R',5);
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

      foreach ($query1 as $reg1) {

        $MARCA             = $reg1 ['ORACLE'];    
        $VLR_BRUTO_FAC     = $reg1 ['VLR_BRUTO_FAC']; 
        $VLR_DESC_FAC      = $reg1 ['VLR_DESC_FAC'];
        $VLR_FAC           = $reg1 ['VLR_FAC'];
        $PORC_DESC         = $reg1 ['PORC_DESC'];
        $VLR_BRUTO_DVO     = $reg1 ['VLR_BRUTO_DVO']; 
        $VLR_DESC_DVO      = $reg1 ['VLR_DESC_DVO'];
        $VLR_DVO           = $reg1 ['VLR_DVO'];
        $VENTA_NETA        = $reg1 ['VENTA_NETA'];
        $COST_PROM_FAC     = $reg1 ['COST_PROM_FAC'];
        $COST_PROM_NDV     = $reg1 ['COST_PROM_NDV'];
        $COSTO_NETO        = $reg1 ['COSTO_NETO'];
        $RENTABILIDAD      = $reg1 ['RENTABILIDAD'];
        $SUBTOTAL          = $reg1 ['SUBTOTAL'];     

        $this->SetFont('Arial','',6);
        $this->Cell(29,3,substr(utf8_decode($MARCA),0 , 22),0,0,'L');
        $this->Cell(20,3,number_format(($VLR_BRUTO_FAC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_DESC_FAC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_FAC),2,".",","),0,0,'R');
        $this->Cell(14,3,number_format(($PORC_DESC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_BRUTO_DVO),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_DESC_DVO),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_DVO),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VENTA_NETA),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($COST_PROM_FAC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($COST_PROM_NDV),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($COSTO_NETO),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($RENTABILIDAD),2,".",","),0,0,'R');
        $this->Cell(17,3,number_format(($SUBTOTAL),2,".",","),0,0,'R');
        $this->Ln();

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

      }

      $this->SetFont('Arial','B',5);
      $this->Cell(29,5,'TOTAL GENERAL',0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_FAC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_DESC_FAC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_FAC_st),2,".",","),0,0,'R');
      $PORC_DESC_st = ($VLR_DESC_FAC_st / $VLR_BRUTO_FAC_st) * 100; 
      $this->Cell(14,5,number_format(($PORC_DESC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_DVO_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_DESC_DVO_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_DVO_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VENTA_NETA_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_FAC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_NDV_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COSTO_NETO_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($RENTABILIDAD_st),2,".",","),0,0,'R');
      $SUBTOTAL_st = ($RENTABILIDAD_st / $VLR_FAC_st) * 100; 
      $this->Cell(17,5,number_format(($SUBTOTAL_st),2,".",","),0,0,'R');

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
  $pdf->setFechaActual($fecha_act);
  $pdf->setNombreEmpresa($nombre_empresa);
  $pdf->setSql($query);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Rentabilidad_oracle_'.date('Y-m-d H_i_s').'.pdf');
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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'DESC. ORACLE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'VLR BRUTO FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'VLR DESC. FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'VLR FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', '% DESC. FRA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'VLR BRUTO DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'VALOR DESC. DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VALOR DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'VENTA NETA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'COSTO FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'COSTO DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'COSTO NETO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'RENTABILIDAD');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', '% RENT.');

  $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
      
  $Fila = 2; 

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

  foreach ($query1 as $reg1) {
  
    $MARCA             = $reg1 ['ORACLE'];    
    $VLR_BRUTO_FAC     = $reg1 ['VLR_BRUTO_FAC']; 
    $VLR_DESC_FAC      = $reg1 ['VLR_DESC_FAC'];
    $VLR_FAC           = $reg1 ['VLR_FAC'];
    $PORC_DESC         = $reg1 ['PORC_DESC'];
    $VLR_BRUTO_DVO     = $reg1 ['VLR_BRUTO_DVO']; 
    $VLR_DESC_DVO      = $reg1 ['VLR_DESC_DVO'];
    $VLR_DVO           = $reg1 ['VLR_DVO'];
    $VENTA_NETA        = $reg1 ['VENTA_NETA'];
    $COST_PROM_FAC     = $reg1 ['COST_PROM_FAC'];
    $COST_PROM_NDV     = $reg1 ['COST_PROM_NDV'];
    $COSTO_NETO        = $reg1 ['COSTO_NETO'];
    $RENTABILIDAD      = $reg1 ['RENTABILIDAD'];
    $SUBTOTAL          = $reg1 ['SUBTOTAL']; 

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $MARCA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $VLR_BRUTO_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_DESC_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $PORC_DESC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VLR_BRUTO_DVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_DESC_DVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DVO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VENTA_NETA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $COST_PROM_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_NDV);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COSTO_NETO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $RENTABILIDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $SUBTOTAL);
        
    $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':N'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':N'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila = $Fila + 1;

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

  }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'TOTAL GENERAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $VLR_BRUTO_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_DESC_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_FAC_st);
  $PORC_DESC_st = ($VLR_DESC_FAC_st / $VLR_BRUTO_FAC_st) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $PORC_DESC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $VLR_BRUTO_DVO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_DESC_DVO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DVO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $VENTA_NETA_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $COST_PROM_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_NDV_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COSTO_NETO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $RENTABILIDAD_st);
  $SUBTOTAL_st = ($RENTABILIDAD_st / $VLR_FAC_st) * 100;
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $SUBTOTAL_st);
 
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':N'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':N'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':N'.$Fila)->getFont()->setBold(true);

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

  $n = 'Rentabilidad_oracle_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











