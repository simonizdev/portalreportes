<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//print_r($model);die;

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

$query= "
SET NOCOUNT ON
EXEC [dbo].[COM_VT_NOTAS_NDV_NAC_FECH]
    @FECHA1 = N'".$FechaM1."',
    @FECHA2 = N'".$FechaM2."'
";

$query1 = Yii::app()->db->createCommand($query)->queryAll();

$array_co = array();

foreach ($query1 as $reg) {
  $motivo    = $reg['MOTIVO'];
  $nit    = $reg['NIT'];
  $cliente    = $reg['CLIENTE'];
  $nota    = $reg['NOTA'];
  $factura    = $reg['FACTURA'];
  $valor_nota    = $reg['VALOR_NOTA'];
  $valor_factura    = $reg['VALOR_FACTURA'];
  $valor_aplicado    = $reg['VALOR_APLICADO'];
  $usuario_creacion    = $reg['USUARIO_CREACION'];
  $fecha_creacion    = $reg['FECHA_CREACION'];

  if(!array_key_exists($motivo, $array_co)) {
    $array_co[$motivo] = array();
    $array_co[$motivo]['info'][] = array(
      'motivo' => $motivo, 
      'nit' => $nit, 
      'cliente' => $cliente, 
      'nota' => $nota,
      'factura' => $factura,
      'valor_nota' => $valor_nota,
      'valor_factura' => $valor_factura,
      'valor_aplicado' => $valor_aplicado,
      'usuario_creacion' => $usuario_creacion,
      'fecha_creacion' => $fecha_creacion,
    );     
  }else{
    $array_co[$motivo]['info'][] = array(
      'motivo' => $motivo, 
      'nit' => $nit, 
      'cliente' => $cliente, 
      'nota' => $nota,
      'factura' => $factura,
      'valor_nota' => $valor_nota,
      'valor_factura' => $valor_factura,
      'valor_aplicado' => $valor_aplicado,
      'usuario_creacion' => $usuario_creacion,
      'fecha_creacion' => $fecha_creacion,
    );        
  }

}

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

    function setData($data){
      $this->data = $data;
    }

    /*function setSql($sql){
      $this->sql = $sql;
    }*/

    function Header(){
      $this->SetFont('Arial','B',11);
      $this->Cell(200,5,utf8_decode('NOTAS DEVOLUCIÓN'),0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(80,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',9);
      $this->Cell(280,5,utf8_decode('Criterio de búsqueda: Fecha del '.$this->fecha_inicial.' al '.$this->fecha_final),0,0,'L');
      $this->Ln();
      
      //cabecera de tabla
      $this->SetFont('Arial','B',8);
      $this->Cell(30,5,utf8_decode('Motivo'),0,0,'L');
      $this->Cell(18,5,utf8_decode('Nit'),0,0,'L');
      $this->Cell(55,5,utf8_decode('Cliente'),0,0,'L');
      $this->Cell(25,5,utf8_decode('Nota'),0,0,'L');
      $this->Cell(25,5,utf8_decode('Factura aplicada'),0,0,'L');
      $this->Cell(24,5,utf8_decode('Valor nota'),0,0,'R');
      $this->Cell(24,5,utf8_decode('Valor factura'),0,0,'R');
      $this->Cell(24,5,utf8_decode('Valor Aplicado'),0,0,'R');
      $this->Cell(25,5,utf8_decode('Usuario que creo'),0,0,'L');
      $this->Cell(20,5,utf8_decode('Fecha de creación'),0,0,'L');
      $this->Ln();

      $this->SetDrawColor(0,0,0);
      $this->Cell(280,0,'','T');                            
      $this->Ln();
    }

    function Tabla(){

      $array_co = $this->data;

      $tf_n = 0;
      $tf_f = 0;
      $tf_a = 0;

      foreach ($array_co as $co) {
      
        $t_n = 0;
        $t_f = 0;
        $t_a = 0;

        $nota_act = "";

        foreach ($co['info'] as $info ) {
      
          if($nota_act == utf8_decode($info['nota'])){

            if($info['factura'] != "" && $info['valor_factura'] != 0){

              $this->SetFont('Arial','',7);
              $this->Cell(30,3,substr(utf8_decode($info['motivo']),0 , 18),0,0,'L');
              $this->Cell(18,3,utf8_decode($info['nit']),0,0,'L');
              $this->Cell(55,3,substr(utf8_decode($info['cliente']),0 , 33),0,0,'L');
              $this->Cell(25,3,utf8_decode($info['nota']),0,0,'L');
              $this->Cell(25,3,utf8_decode($info['factura']),0,0,'L');
              $this->Cell(24,3,number_format(($info['valor_nota']),0,".",","),0,0,'R');
              $this->Cell(24,3,number_format(($info['valor_factura']),0,".",","),0,0,'R');
              $this->Cell(24,3,number_format(($info['valor_aplicado']),0,".",","),0,0,'R');
              $this->Cell(25,3,utf8_decode($info['usuario_creacion']),0,0,'L');
              $this->Cell(20,3,utf8_decode($info['fecha_creacion']),0,0,'L');
              $this->Ln();
              
              $t_n = $t_n + $info['valor_nota'];
              $t_f = $t_f + $info['valor_factura'];
              $t_a = $t_a + $info['valor_aplicado'];

              $nota_act = utf8_decode($info['nota']); 
            
            }


          }else{
            $this->SetFont('Arial','',7);
            $this->Cell(30,3,substr(utf8_decode($info['motivo']),0 , 18),0,0,'L');
            $this->Cell(18,3,utf8_decode($info['nit']),0,0,'L');
            $this->Cell(55,3,substr(utf8_decode($info['cliente']),0 , 33),0,0,'L');
            $this->Cell(25,3,utf8_decode($info['nota']),0,0,'L');
            $this->Cell(25,3,utf8_decode($info['factura']),0,0,'L');
            $this->Cell(24,3,number_format(($info['valor_nota']),0,".",","),0,0,'R');
            $this->Cell(24,3,number_format(($info['valor_factura']),0,".",","),0,0,'R');
            $this->Cell(24,3,number_format(($info['valor_aplicado']),0,".",","),0,0,'R');
            $this->Cell(25,3,utf8_decode($info['usuario_creacion']),0,0,'L');
            $this->Cell(20,3,utf8_decode($info['fecha_creacion']),0,0,'L');
            $this->Ln();
            
            $t_n = $t_n + $info['valor_nota'];
            $t_f = $t_f + $info['valor_factura'];
            $t_a = $t_a + $info['valor_aplicado'];

            $nota_act = utf8_decode($info['nota']);
          }
        }
        
        //$this->Ln();
        $this->SetDrawColor(0,0,0);
        $this->Cell(280,1,'','T');                            
        $this->Ln();

        $this->SetFont('Arial','B',7);
        $this->Cell(153,3,'TOTALES '.utf8_decode($info['motivo']),0,0,'R');
        
        $this->Cell(24,3,number_format(($t_n),0,".",","),0,0,'R');
        $this->Cell(24,3,number_format(($t_f),0,".",","),0,0,'R');
        $this->Cell(24,3,number_format(($t_a),0,".",","),0,0,'R');;

        $this->Ln();
        $this->SetDrawColor(0,0,0);
        $this->Cell(280,1,'','T');                            
        $this->Ln();

        $tf_n = $tf_n + $t_n;
        $tf_f = $tf_f + $t_f;
        $tf_a = $tf_a + $t_a;

        $t_n = 0;
        $t_f = 0;
        $t_a = 0;
        
       }

      $this->Ln();
      $this->Ln();
      $this->SetFont('Arial','B',10);
      $this->Cell(153,3,utf8_decode('TOTALES'),0,0,'L');
      $this->SetFont('Arial','B',8);
      $this->Cell(24,3,number_format(($tf_n),0,".",","),0,0,'R');
      $this->Cell(24,3,number_format(($tf_f),0,".",","),0,0,'R');
      $this->Cell(24,3,number_format(($tf_a),0,".",","),0,0,'R');
      $this->Ln();

      $tf_n = 0;
      $tf_f = 0;
      $tf_a = 0;

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
  $pdf->setData($array_co);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Consulta_notas_devolucion_'.date('Y-m-d H_i_s').'.pdf');
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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Motivo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Nit');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Cliente');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Nota');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Factura aplicada');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Valor nota');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Valor factura');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Valor Aplicado');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Usuario que creo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Fecha de creación');

  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $Fila = 2;  

  $tf_n = 0;
  $tf_f = 0;
  $tf_a = 0;

  foreach ($array_co as $co) {
  
    $t_n = 0;
    $t_f = 0;
    $t_a = 0;

    foreach ($co['info'] as $info ) {

      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $info['motivo']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $info['nit']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $info['cliente']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $info['nota']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $info['factura']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $info['valor_nota']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $info['valor_factura']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $info['valor_aplicado']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $info['usuario_creacion']);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $info['fecha_creacion']);

      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
      $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

      $Fila = $Fila + 1;
      
      $t_n = $t_n + $info['valor_nota'];
      $t_f = $t_f + $info['valor_factura'];
      $t_a = $t_a + $info['valor_aplicado'];

    }

    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, 'TOTALES '.$info['motivo']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $t_n);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $t_f);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $t_a);

    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':H'.$Fila)->getFont()->setBold(true);

    $Fila = $Fila + 1;

    $tf_n = $tf_n + $t_n;
    $tf_f = $tf_f + $t_f;
    $tf_a = $tf_a + $t_a;

    $t_n = 0;
    $t_f = 0;
    $t_a = 0;
    
   }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, 'TOTALES');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $tf_n);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $tf_f);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $tf_a);

  $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila.':H'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

  $tf_n = 0;
  $tf_f = 0;
  $tf_a = 0;

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

  $n = 'Consulta_notas_devolucion_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











