<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

/*inicio configuración array de datos*/

//se reciben los parametros para el reporte
$id_suministro = $model['sum'];
//$id_departamento = $model['dep'];

if($id_suministro != null){

  $query1 ="
    SELECT
    S.Id_Suministro,
    S.Codigo,
    S.Descripcion
    FROM TH_SUMINISTRO S
    WHERE Id_Suministro = ".$id_suministro."

  ";

  $model_sum = Suministro::model()->findByPk($id_suministro);
  $texto_suministro = $model_sum->Codigo.' - '.$model_sum->Descripcion;

}else{

  $query1 ="
    SELECT
    S.Id_Suministro,
    S.Codigo,
    S.Descripcion
    FROM TH_SUMINISTRO S
    ORDER BY S.Descripcion
  ";

  $texto_suministro = 'TODOS';

}

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

/*fin configuración array de datos*/

if($opcion == 1){
  //PDF

  //se incluye la libreria pdf
  require_once Yii::app()->basePath . '/extensions/fpdf/fpdf.php';

  class PDF extends FPDF{

    function setFechaActual($fecha_actual){
      $this->fecha_actual = $fecha_actual;
    }

    function setTextoSuministro($suministro){
      $this->suministro = $suministro;
    }

    function setSql1($sql1){
      $this->sql1 = $sql1;
    }

    function setSql2($sql2){
      $this->sql2 = $sql2;
    }

    function Header(){
      $this->SetFont('Arial','B',12);
      $this->Cell(140,5,'Existencias de suministros por departamento',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(55,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(195,5,utf8_decode('Criterio de búsqueda: Suministro(s): '.$this->suministro),0,0,'L');
      $this->Ln();
      $this->Ln();
      
      //linea superior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(195,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      $this->Ln();  
      
      //cabecera de tabla
      $this->SetFont('Arial','B',7);
  
      $this->Cell(140,2,utf8_decode('Suministro'),0,0,'L');
     // $this->Cell(70,2,utf8_decode('Departamento'),0,0,'L');
      $this->Cell(40,2,utf8_decode('Cantidad'),0,0,'R');  
      $this->Ln(3);   
      
      //linea inferior a la cabecera de la tabla
      $this->SetDrawColor(0,0,0);
      $this->Cell(195,1,'','T');
      $this->SetFillColor(224,235,255);
      $this->SetTextColor(0);
      

      $this->Ln();
    }

    function Tabla(){

      $q1 = Yii::app()->db->createCommand($this->sql1)->queryAll();

      if(!empty($q1)){
        foreach ($q1 as $reg1) {

          $id_suministro    = $reg1 ['Id_Suministro']; 
          $codigo_sum       = $reg1 ['Codigo']; 
          $descripcion_sum  = $reg1 ['Descripcion'];

          $cant = UtilidadesReportes::existenciassuministros($id_suministro);

          $this->SetFont('Arial','',7);
          $this->Cell(140,3,utf8_decode($codigo_sum.' - '.$descripcion_sum),0,0,'L');
          $this->Cell(40,3,$cant,0,0,'R');
          $this->Ln(); 
        }
      }

      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(195,0,'','T');                            
      $this->Ln();

    }//fin tabla

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','B',6);
        $this->Cell(0,8,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
    }
  }

  $pdf = new PDF('P','mm','A4');
  //se definen las variables extendidas de la libreria FPDF
  $pdf->setFechaActual($fecha_act); 
  $pdf->setTextoSuministro($texto_suministro);
  $pdf->setSql1($query1);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Existencias_'.date('Y-m-d H_i_s').'.pdf');
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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Suministro');
  //$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Departamento');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Cantidad');

  $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/
      
  $Fila = 2;

  $q1 = Yii::app()->db->createCommand($query1)->queryAll();

  if(!empty($q1)){
    foreach ($q1 as $reg1) {

      $id_suministro    = $reg1 ['Id_Suministro']; 
      $codigo_sum       = $reg1 ['Codigo']; 
      $descripcion_sum  = $reg1 ['Descripcion'];

      $text_sum = $codigo_sum.' - '.$descripcion_sum;

      $cant = UtilidadesReportes::existenciassuministros($id_suministro);

      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $text_sum);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $cant);

     
      $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila)->getNumberFormat()->setFormatCode('0');
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

      $Fila = $Fila + 1; 

         
    }
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

  $n = 'Existencias_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











