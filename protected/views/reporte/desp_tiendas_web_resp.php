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

$query ="
SET NOCOUNT ON
EXEC COM_PAG_DATOS
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."'
";

//echo $query;die;

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
      $this->SetFont('Arial','B',12);
      $this->Cell(200,5,utf8_decode('Despachos Tienda Web'),0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(80,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',7);
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

      $this->Cell(15,2,utf8_decode('N° PEDIDO'),0,0,'L');
      $this->Cell(15,2,utf8_decode('FECHA'),0,0,'L');
      $this->Cell(50,2,utf8_decode('CLIENTE'),0,0,'L');
      $this->Cell(60,2,utf8_decode('DIRECCIÓN'),0,0,'L');
      $this->Cell(25,2,utf8_decode('CIUDAD'),0,0,'L');
      $this->Cell(20,2,utf8_decode('TELÉFONO'),0,0,'L');
      $this->Cell(10,2,utf8_decode('ITEM'),0,0,'L');
      $this->Cell(50,2,utf8_decode('DESCRIPCIÓN'),0,0,'L');
      $this->Cell(15,2,utf8_decode('CANTIDAD'),0,0,'L');
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

        $ORDEN             = $reg1 ['ORDEN'];    
        $FECHA             = $reg1 ['FECHA']; 
        $CLIENTE_NOMBRE    = $reg1 ['CLIENTE_NOMBRE'];
        $CLIENTE_APELLIDO  = $reg1 ['CLIENTE_APELLIDO'];
        $CLIENTE_DIRECCION = $reg1 ['CLIENTE_DIRECCION'];
        //$TELEFONO1         = $reg1 ['TELEFONO1']; 
        //$TELEFONO2         = $reg1 ['TELEFONO2'];
        $CELULAR           = $reg1 ['CELULAR'];
        $CIUDAD_ENVIO      = $reg1 ['CIUDAD_ENVIO'];
        $DIRECCION_ENVIO   = $reg1 ['DIRECCION_ENVIO'];
        //$CORREO            = $reg1 ['CORREO'];
        //$TOTAL             = $reg1 ['TOTAL'];
        //$LINEA             = $reg1 ['LINEA'];
        $ITEM              = $reg1 ['ITEM']; 
        $DESCRIPCION       = $reg1 ['DESCRIPCION'];
        $CANTIDAD          = $reg1 ['CANTIDAD'];  
        //$PRECIO            = $reg1 ['PRECIO'];    

        $this->SetFont('Arial','',6);
        $this->Cell(15,3,$ORDEN,0,0,'L');
        $this->Cell(15,3,$FECHA,0,0,'L');
        $this->Cell(50,3,substr(utf8_decode($CLIENTE_NOMBRE.' '.$CLIENTE_APELLIDO),0 , 40),0,0,'L');
        $this->Cell(60,3,substr(utf8_decode($CLIENTE_DIRECCION),0 , 55),0,0,'L');
        $this->Cell(25,3,utf8_decode($CIUDAD_ENVIO),0,0,'L');
        $this->Cell(20,3,$CELULAR,0,0,'L');
        $this->Cell(10,3,$ITEM,0,0,'L');
        $this->Cell(50,3,substr(utf8_decode($DESCRIPCION),0 , 35),0,0,'L');
        $this->Cell(15,3,number_format(($CANTIDAD),0,".",","),0,0,'R');
        $this->Ln();
      
      }

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
  $pdf->setSql($query);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Desp_tiendas_web_'.date('Y-m-d H_i_s').'.pdf');
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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'N° PEDIDO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'FECHA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'CLIENTE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'DIRECCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'CIUDAD');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'TELÉFONO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'ITEM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'DESCRIPCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'CANTIDAD');

  $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
      
  $Fila = 2;

  foreach ($query1 as $reg1) {

    $ORDEN             = $reg1 ['ORDEN'];    
    $FECHA             = $reg1 ['FECHA']; 
    $CLIENTE_NOMBRE    = $reg1 ['CLIENTE_NOMBRE'];
    $CLIENTE_APELLIDO  = $reg1 ['CLIENTE_APELLIDO'];
    $CLIENTE_DIRECCION = $reg1 ['CLIENTE_DIRECCION'];
    //$TELEFONO1         = $reg1 ['TELEFONO1']; 
    //$TELEFONO2         = $reg1 ['TELEFONO2'];
    $CELULAR           = $reg1 ['CELULAR'];
    $CIUDAD_ENVIO      = $reg1 ['CIUDAD_ENVIO'];
    $DIRECCION_ENVIO   = $reg1 ['DIRECCION_ENVIO'];
    //$CORREO            = $reg1 ['CORREO'];
    $TOTAL             = $reg1 ['TOTAL'];
    $LINEA             = $reg1 ['LINEA'];
    $ITEM              = $reg1 ['ITEM']; 
    $DESCRIPCION       = $reg1 ['DESCRIPCION'];
    $CANTIDAD          = $reg1 ['CANTIDAD'];  
    //$PRECIO            = $reg1 ['PRECIO']; 

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $ORDEN);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $FECHA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $CLIENTE_NOMBRE.' '.$CLIENTE_APELLIDO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $CLIENTE_DIRECCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $CIUDAD_ENVIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $CELULAR);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $CANTIDAD);
        
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

  $n = 'Desp_tiendas_web_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>