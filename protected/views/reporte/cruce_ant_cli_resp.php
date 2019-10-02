<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];

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
$diaesp=str_replace($ding, $desp, $diatxt);
$mesesp=str_replace($ming, $mesp, $mestxt);

$fecha_act= $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

//opcion: 1. PDF, 2. EXCEL
$opcion = $model['opcion_exp'];

$query ="
  SET NOCOUNT ON
  EXEC [dbo].[COM_CONS_CRUCE_NRC]
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."'
";

$query1 = Yii::app()->db->createCommand($query)->queryAll();

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

    function setSql($sql){
      $this->sql = $sql;
    }

    function Header(){
      $this->SetFont('Arial','B',10);
      $this->Cell(200,5,'CRUCE ANTICIPOS / CLIENTE',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(80,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(280,5,utf8_decode('Criterio de búsqueda: Fecha del '.$this->fecha_inicial.' al '.$this->fecha_final),0,0,'L');
      $this->Ln();
      
      //linea superior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(280,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      $this->Ln();  
      
      //cabecera de tabla
      $this->SetFont('Arial','B',7);

      $this->Cell(15,2,utf8_decode('NIT'),0,0,'L');
      $this->Cell(70,2,utf8_decode('CLIENTE'),0,0,'L');
      $this->Cell(25,2,utf8_decode('N° NOTA'),0,0,'L');
      $this->Cell(10,2,utf8_decode('FECHA NOTA'),0,0,'L');
      $this->Cell(30,2,utf8_decode('VALOR NOTA'),0,0,'R');
      $this->Cell(25,2,utf8_decode('RECIBO CRUCE'),0,0,'L');
      $this->Cell(10,2,utf8_decode('FECHA CRUCE'),0,0,'L');
      $this->Cell(30,2,utf8_decode('VALOR CRUCE'),0,0,'R');
      $this->Cell(25,2,utf8_decode('FACTURA APLIC.'),0,0,'L');
      $this->Cell(10,2,utf8_decode('FECHA APLIC.'),0,0,'L');
      $this->Cell(30,2,utf8_decode('VALOR APLIC.'),0,0,'R');
      
     
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

      foreach ($query1 as $reg1) {

        $nit_cliente = $reg1['NIT_CLIENTE'];
        $nombre_cliente = $reg1['NOMBRE_CLIENTE'];
        $numero_nota = $reg1['NUMERO_NOTA'];
        $fecha_docto = $reg1['FECHA_DOCTO'];
        $valor_docto = $reg1['VALOR_DOCTO'];
        $recibo_cruce = $reg1['RECIBO_CRUCE'];
        $fecha_cruce = $reg1['FECHA_CRUCE'];
        $valor_cruce = $reg1['VALOR_CRUCE'];
        $factura_aplicada = $reg1['FACTURA_APLICADA'];
        $fecha_factura = $reg1['FECHA_FACTURA'];
        $valor_factura = $reg1['VALOR_FACTURA'];
        

        $this->SetFont('Arial','',6);
        $this->Cell(15,3,$nit_cliente,0,0,'L');
        $this->Cell(70,3,substr(utf8_decode($nombre_cliente),0,50),0,0,'L');
        $this->Cell(25,3,$numero_nota,0,0,'L');
        $this->Cell(10,3,$fecha_docto,0,0,'L');
        $this->Cell(30,3,number_format(($valor_docto),2,".",","),0,0,'R');
        $this->Cell(25,3,$recibo_cruce,0,0,'L');
        $this->Cell(10,3,$fecha_cruce,0,0,'L');
        $this->Cell(30,3,number_format(($valor_cruce),2,".",","),0,0,'R');
        $this->Cell(25,3,$factura_aplicada,0,0,'L');
        $this->Cell(10,3,$fecha_factura,0,0,'L');
        $this->Cell(30,3,number_format(($valor_factura),2,".",","),0,0,'R');
        $this->Ln();
      } 

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
  $pdf->setSql($query);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Cruce_anticipos_cliente_'.date('Y-m-d H_i_s').'.pdf');

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
      
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'NIT');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'CLIENTE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'N° NOTA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'FECHA NOTA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VALOR NOTA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'RECIBO CRUCE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'FECHA CRUCE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VALOR CRUCE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'FACTURA APLIC.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'FECHA APLIC.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'VALOR APLIC.');

  $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
   
  $Fila = 2;  

  foreach ($query1 as $reg1) {

    $nit_cliente = $reg1['NIT_CLIENTE'];
    $nombre_cliente = $reg1['NOMBRE_CLIENTE'];
    $numero_nota = $reg1['NUMERO_NOTA'];
    $fecha_docto = $reg1['FECHA_DOCTO'];
    $valor_docto = $reg1['VALOR_DOCTO'];
    $recibo_cruce = $reg1['RECIBO_CRUCE'];
    $fecha_cruce = $reg1['FECHA_CRUCE'];
    $valor_cruce = $reg1['VALOR_CRUCE'];
    $factura_aplicada = $reg1['FACTURA_APLICADA'];
    $fecha_factura = $reg1['FECHA_FACTURA'];
    $valor_factura = $reg1['VALOR_FACTURA'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $nit_cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $nombre_cliente);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $numero_nota);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $fecha_docto);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $valor_docto);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $recibo_cruce);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $fecha_cruce);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $valor_cruce);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $factura_aplicada);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $fecha_factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $valor_factura);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

  $n = 'Cruce_anticipos_cliente_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>












