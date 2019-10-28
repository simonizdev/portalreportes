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

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

$query= "
  SET NOCOUNT ON
  EXEC [dbo].[COM_REDES_RQM_FECH_ITEMS_TOP]
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

    function setSql($sql){
      $this->sql = $sql;
    }

    function Header(){
      $this->SetFont('Arial','B',9);
      $this->Cell(200,5,utf8_decode('PEDIDOS PENDIENTES POR DESPACHO Y REQUISICIONES (TOP 10)'),0,0,'L');
      $this->SetFont('Arial','',7);
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
      $this->SetFont('Arial','B',5);
      $this->Cell(8,2,utf8_decode('#'),0,0,'L');
      $this->Cell(10,2,utf8_decode('ITEM'),0,0,'L');
      $this->Cell(20,2,utf8_decode('REFERENCIA'),0,0,'L');
      $this->Cell(50,2,utf8_decode('DESCRIPCIÓN'),0,0,'L');
      $this->Cell(30,2,utf8_decode('MARCA'),0,0,'L');
      $this->Cell(35,2,utf8_decode('LINEA'),0,0,'L');
      $this->Cell(13,2,utf8_decode('ESTADO'),0,0,'L');
      $this->Cell(13,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('CANT.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VALOR'),0,0,'R');
      $this->Cell(14,2,utf8_decode('PEND. POR'),0,0,'R');
      $this->Cell(14,2,utf8_decode('EN'),0,0,'R');
      $this->Ln(3);   
      
      $this->Cell(8,2,utf8_decode('POS.'),0,0,'L');
      $this->Cell(10,2,utf8_decode(''),0,0,'L');
      $this->Cell(20,2,utf8_decode(''),0,0,'L');
      $this->Cell(50,2,utf8_decode(''),0,0,'L');
      $this->Cell(30,2,utf8_decode(''),0,0,'L');
      $this->Cell(35,2,utf8_decode(''),0,0,'L');
      $this->Cell(13,2,utf8_decode(''),0,0,'L');
      $this->Cell(13,2,utf8_decode('PEDIDA'),0,0,'R');
      $this->Cell(13,2,utf8_decode('ENVIADA'),0,0,'R');
      $this->Cell(13,2,utf8_decode('REDESP.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('PEND.'),0,0,'R');
      $this->Cell(13,2,utf8_decode('PEND. RQM'),0,0,'R');
      $this->Cell(20,2,utf8_decode('PEDIDO'),0,0,'R');
      $this->Cell(14,2,utf8_decode('ENTRAR'),0,0,'R');
      $this->Cell(14,2,utf8_decode('EXIST.'),0,0,'R');
      


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

      $Cant_Ped_st = 0;
      $Cant_Env_st = 0;
      $Cant_Redes_st = 0;
      $Cant_Pend_st = 0;
      $Vlr_Pedido_st = 0;
      $P_Entrar_st = 0;
      $Existencia_st = 0;
      $Cant_Pend_RQM_st = 0;

      foreach ($query1 as $reg1) {
        
        $POS               = $reg1 ['POSICION_PARETO'];
        $ITEM               = $reg1 ['ITEM'];
        $REFERENCIA        = $reg1 ['REFERENCIA'];    
        $DESCRIPCION        = $reg1 ['DESCRIPCION'];
        $MARCA              = $reg1 ['MARCA'];    
        $LINEA              = $reg1 ['LINEA'];    
        $ESTADO             = $reg1 ['ESTADO'];

        $Cant_Ped           = $reg1 ['Cant_Ped'];    
        $Cant_Env           = $reg1 ['Cant_Env'];    
        $Cant_Redes         = $reg1 ['Cant_Redes'];    
        $Cant_Pend          = $reg1 ['Cant_Pend'];    
        $Vlr_Pedido         = $reg1 ['Vlr_Pedido'];    
        $P_Entrar           = $reg1 ['P_Entrar'];    
        $Existencia         = $reg1 ['Existencia'];
        $Cant_Pend_RQM      = $reg1 ['Cant_Pend_RQM'];

        $this->SetFont('Arial','',6);
        $this->Cell(8,3,$POS,0,0,'L');
        $this->Cell(10,3,$ITEM,0,0,'L');
        $this->Cell(20,3,substr(utf8_decode($REFERENCIA),0, 20) ,0,0,'L');
        $this->Cell(50,3,substr(utf8_decode($DESCRIPCION), 0, 30),0,0,'L');
        $this->Cell(30,3,substr(utf8_decode($MARCA), 0, 20),0,0,'L');
        $this->Cell(35,3,substr(utf8_decode($LINEA), 0, 25),0,0,'L');
        $this->Cell(13,3,substr(utf8_decode($ESTADO), 0, 8),0,0,'L');
        $this->Cell(13,3,number_format(($Cant_Ped),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($Cant_Env),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($Cant_Redes),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($Cant_Pend),0,".",","),0,0,'R');
        $this->Cell(13,3,number_format(($Cant_Pend_RQM),0,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($Vlr_Pedido),2,".",","),0,0,'R');
        $this->Cell(14,3,number_format(($P_Entrar),0,".",","),0,0,'R');
        $this->Cell(14,3,number_format(($Existencia),0,".",","),0,0,'R');
        
        $Cant_Ped_st += $Cant_Ped;
        $Cant_Env_st += $Cant_Env;
        $Cant_Redes_st += $Cant_Redes;
        $Cant_Pend_st += $Cant_Pend;
        $Cant_Pend_RQM_st += $Cant_Pend_RQM;
        $Vlr_Pedido_st += $Vlr_Pedido;
        $P_Entrar_st += $P_Entrar;
        $Existencia_st += $Existencia;
        
        $this->Ln();

      }

      $this->SetDrawColor(0,0,0);
      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(280,0,'','T');
      $this->SetDrawColor(255,255,255);
      $this->Ln();

      $this->SetFont('Arial','B',5);
      $this->Cell(166,3,'TOTAL GENERAL',0,0,'R');
      $this->SetFont('Arial','B',6);
      $this->Cell(13,3,number_format(($Cant_Ped_st),0,".",","),0,0,'R');
      $this->Cell(13,3,number_format(($Cant_Env_st),0,".",","),0,0,'R');
      $this->Cell(13,3,number_format(($Cant_Redes_st),0,".",","),0,0,'R');
      $this->Cell(13,3,number_format(($Cant_Pend_st),0,".",","),0,0,'R');
      $this->Cell(13,3,number_format(($Cant_Pend_RQM_st),0,".",","),0,0,'R');
      $this->Cell(20,3,number_format(($Vlr_Pedido_st),2,".",","),0,0,'R');
      $this->Cell(14,3,number_format(($P_Entrar_st),0,".",","),0,0,'R');
      $this->Cell(14,3,number_format(($Existencia_st),0,".",","),0,0,'R');

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
  $pdf->setSql($query);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Ped_pend_des_rqm_top_'.date('Y-m-d H_i_s').'.pdf');
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

  $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Criterio de búsqueda: Fecha del '.$fecha_inicial.' al '.$fecha_final);
  $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

  /*Cabecera tabla*/

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A3', '# POS.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B3', 'ITEM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C3', 'REFERENCIA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D3', 'DESCRIPCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E3', 'MARCA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F3', 'LÍNEA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G3', 'ESTADO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H3', 'CANT. PEDIDA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I3', 'CANT. ENVIADA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J3', 'CANT. REDESP.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K3', 'CANT. PEND.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L3', 'CANT. PEND. RQM');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M3', 'VALOR PEDIDO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N3', 'PEND. POR ENTRAR');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O3', 'EN EXIST.');

  $objPHPExcel->getActiveSheet()->getStyle('A3:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A3:O3')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
   
  $Fila = 4;  
  $linea = "";

  $Cant_Ped_st = 0;
  $Cant_Env_st = 0;
  $Cant_Redes_st = 0;
  $Cant_Pend_st = 0;
  $Cant_Pend_RQM_st = 0;
  $Vlr_Pedido_st = 0;
  $P_Entrar_st = 0;
  $Existencia_st = 0;

  foreach ($query1 as $reg1) {
    
    $POS               = $reg1 ['POSICION_PARETO'];
    $ITEM               = $reg1 ['ITEM'];
    $REFERENCIA        = $reg1 ['REFERENCIA'];    
    $DESCRIPCION        = $reg1 ['DESCRIPCION'];
    $MARCA              = $reg1 ['MARCA'];    
    $LINEA              = $reg1 ['LINEA'];    
    $ESTADO             = $reg1 ['ESTADO'];

    $Cant_Ped           = $reg1 ['Cant_Ped'];    
    $Cant_Env           = $reg1 ['Cant_Env'];    
    $Cant_Redes         = $reg1 ['Cant_Redes'];    
    $Cant_Pend          = $reg1 ['Cant_Pend'];    
    $Vlr_Pedido         = $reg1 ['Vlr_Pedido'];    
    $P_Entrar           = $reg1 ['P_Entrar'];    
    $Existencia         = $reg1 ['Existencia'];
    $Cant_Pend_RQM      = $reg1 ['Cant_Pend_RQM'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $POS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, substr($REFERENCIA,0,20));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, substr($DESCRIPCION,0,30));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, substr($MARCA,0,20));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, substr($LINEA,0,25));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, substr($ESTADO, 0, 8));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Cant_Ped);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $Cant_Env);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $Cant_Redes);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $Cant_Pend);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $Cant_Pend_RQM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $Vlr_Pedido);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $P_Entrar);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $Existencia);
    
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':L'.$Fila)->getNumberFormat()->setFormatCode('0');        
    $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila = $Fila + 1;
  
    $Cant_Ped_st += $Cant_Ped;
    $Cant_Env_st += $Cant_Env;
    $Cant_Redes_st += $Cant_Redes;
    $Cant_Pend_st += $Cant_Pend;
    $Cant_Pend_RQM_st += $Cant_Pend_RQM;
    $Vlr_Pedido_st += $Vlr_Pedido;
    $P_Entrar_st += $P_Entrar;
    $Existencia_st += $Existencia;

  }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, 'TOTAL GENERAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Cant_Ped_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $Cant_Env_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $Cant_Redes_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $Cant_Pend_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $Cant_Pend_RQM_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $Vlr_Pedido_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $P_Entrar_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $Existencia_st);
  
  $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':L'.$Fila)->getNumberFormat()->setFormatCode('0');        
  $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('H'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':O'.$Fila)->getFont()->setBold(true);

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

  $n = 'Ped_pend_des_rqm_top_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











