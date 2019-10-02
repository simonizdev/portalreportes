<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];
$vendedor_inicial = $model['vendedor_inicial'];
$vendedor_final = $model['vendedor_final'];

set_time_limit(0);

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

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

/*inicio configuración array de datos*/

$query ="
  EXEC [dbo].[FIN_RC_VENDEDOR]
  @VENDEDOR1 = N'".$vendedor_inicial."',
  @VENDEDOR2 = N'".$vendedor_final."',
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."'
";

$query1 = Yii::app()->db->createCommand($query)->queryAll();

$array_vendedores = array();

foreach ($query1 as $reg) {
  
  $DOCTO_RECIBO = $reg['DOCTO_RECIBO'];
  $FECHA_RECIBO = $reg['FECHA_RECIBO'];
  $DOCTO_APLICADO = $reg['DOCTO_APLICADO'];
  $FECHA_DOCUMENTO = $reg['FECHA_DOCUMENTO'];
  $CLIENTE = $reg['CLIENTE'];
  $NIT = $reg['NIT'];
  $MEDIO_PAGO = $reg['MEDIO_PAGO'];
  $COBRADOR_PAGO = $reg['COBRADOR_PAGO'];
  $FECHA_PRONT_PAGO = $reg['FECHA_PRONT_PAGO'];
  $FECHA = $reg['FECHA'];
  $FECHA_RECAUDO = $reg['FECHA_RECAUDO'];
  $FECHA_CONSIGNACION = $reg['FECHA_CONSIGNACION'];
  $BANCO = $reg['BANCO'];
  $NRO_CUENTA = $reg['NRO_CUENTA'];
  $NRO_CHEQUE = $reg['NRO_CHEQUE'];
  $VALOR_RECIBO = $reg['VALOR_RECIBO'];
  $NOTAS = $reg['NOTAS'];
  $FECHA_VCTO = $reg['FECHA_VCTO'];
  $SALDO = $reg['SALDO'];
  $VALOR_APLICADO = $reg['VALOR_APLICADO'];

  $array_vendedores[$COBRADOR_PAGO][$MEDIO_PAGO][] = array(
    'nit' => $NIT, 
    'cliente' => $CLIENTE, 
    'n_recibo' => $DOCTO_RECIBO, 
    'n_documento' => $DOCTO_APLICADO,
    'fecha_recuado' => $FECHA_RECAUDO, 
    'fecha_recibo' => $FECHA_RECIBO,
    'referencia' => $NRO_CHEQUE,
    'banco' => $BANCO,
    'fecha_consignacion' => $FECHA_CONSIGNACION,
    'valor_recibido' => $VALOR_RECIBO,
    'valor_aplicado' => $VALOR_APLICADO,
    'saldo_FVE' => $SALDO,
    'notas' => $NOTAS,
  );  

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

    function setVendedorInicial($vendedor_inicial){
      $this->vendedor_inicial = $vendedor_inicial;
    }

    function setVendedorFinal($vendedor_final){
      $this->vendedor_final = $vendedor_final;
    }

    function setData($data){
      $this->data = $data;
    }

    function setTitulos($titulos){
      $this->titulos = $titulos;
    }

    function Header(){
      $this->SetFont('Arial','B',10);
      $this->Cell(150,5,'PAGOS POR VENDEDOR',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(130,5,utf8_decode($this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(280,5,utf8_decode('Criterio de búsqueda: Fecha inicial: '.$this->fecha_inicial.' / Fecha final: '.$this->fecha_final),0,0,'L');
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(280,5,utf8_decode('Criterio de búsqueda: Vendedor inicial: '.$this->vendedor_inicial.' / Vendedor final: '.$this->vendedor_final),0,0,'L');
      $this->Ln();
      $this->Ln();

      if ($this->titulos == 1){

        $this->SetFont('Arial','B',6);
        $this->Cell(14,5, utf8_decode('NIT'),0,0,'L');
        $this->Cell(40,5, utf8_decode('CLIENTE'),0,0,'L');
        $this->Cell(22,5, utf8_decode('N° RECIBO'),0,0,'L');
        $this->Cell(22,5, utf8_decode('DOC. APLICADO'),0,0,'L');
        $this->Cell(15,5, utf8_decode('FEC. RECAU.'),0,0,'L');
        $this->Cell(15,5, utf8_decode('FEC. RECIB.'),0,0,'L');
        $this->Cell(19,5, utf8_decode('REF.'),0,0,'L');
        $this->Cell(28,5, utf8_decode('BANCO'),0,0,'L');
        $this->Cell(15,5, utf8_decode('FEC. CONSIG.'),0,0,'L');
        $this->Cell(20,5, utf8_decode('VLR. RECIBIDO'),0,0,'R');
        $this->Cell(20,5, utf8_decode('VLR. APLICADO'),0,0,'R');
        $this->Cell(20,5, utf8_decode('SALDO FVE'),0,0,'R');
        $this->Cell(30,5, utf8_decode('NOTAS'),0,0,'R');
        $this->Ln();

        $this->SetDrawColor(0,0,0);    
        $this->Cell(280,1,'','T');                            
        $this->Ln();

      }
      
    }

    function Tabla(){

      $array_vendedores = $this->data;
      $array_resumen = array();

      $i = 1;

      $tp_vr = 0;
      $tp_va = 0;
      $tp_sa = 0;

      $tpc_vr = 0;
      $tpc_va = 0;
      $tpc_sa = 0;

      foreach ($array_vendedores as $vendedor => $info) {

        if($i > 1){
          $this->AddPage(); 
        }
        
        $this->SetFont('Arial','B',8);
        $this->Cell(340,3, 'VENDEDOR '.$vendedor,0,0,'L');
        $this->Ln();
        $this->Ln();

        $mpa = "";
        $rea = "";

        foreach ($info as $medio_pago => $docs) {
          
          foreach ($docs as $reg) {

            $mpn = $medio_pago;
            $ren = $reg['n_recibo'];

            $this->SetFont('Arial','',6);
            $this->Cell(14,2,utf8_decode($reg['nit']),0,0,'L');
            $this->Cell(40,2,substr(utf8_decode($reg['cliente']),0, 28),0,0,'L');
            $this->Cell(22,2,utf8_decode($reg['n_recibo']),0,0,'L');
            $this->Cell(22,2,utf8_decode($reg['n_documento']),0,0,'L');
            $this->Cell(15,2,utf8_decode($reg['fecha_recuado']),0,0,'L');
            $this->Cell(15,2,utf8_decode($reg['fecha_recibo']),0,0,'L');
            $this->Cell(19,2,utf8_decode($reg['referencia']),0,0,'L');
            $this->Cell(28,2,substr(utf8_decode($reg['banco']),0, 20),0,0,'L');
            $this->Cell(15,2,utf8_decode($reg['fecha_consignacion']),0,0,'L');
            $this->Cell(20,2,number_format(($reg['valor_recibido']),0,".",","),0,0,'R');
            $this->Cell(20,2,number_format(($reg['valor_aplicado']),0,".",","),0,0,'R');
            $this->Cell(20,2,number_format(($reg['saldo_FVE']),0,".",","),0,0,'R');
            $this->MultiCell(30,2,utf8_decode($reg['notas']),0,'R');
            $this->Ln();

            if($rea != $ren){
              $tp_vr = $tp_vr + $reg['valor_recibido'];
            }else{
              if($mpa != $mpn){
                $tp_vr = $tp_vr + $reg['valor_recibido'];
              } 
            }

            $tp_va = $tp_va + $reg['valor_aplicado'];
            $tp_sa = $tp_sa + $reg['saldo_FVE'];


            $mpa = $medio_pago;
            $rea = $reg['n_recibo'];
            
          }

          $this->SetFont('Arial','B',6);
          $this->Cell(190,3,utf8_decode('TOTAL '.$medio_pago),0,0,'R');
          $this->Cell(20,3,number_format(($tp_vr),0,".",","),0,0,'R');
          $this->Cell(20,3,number_format(($tp_va),0,".",","),0,0,'R');
          $this->Cell(20,3,number_format(($tp_sa),0,".",","),0,0,'R');
          $this->Cell(30,3,'',0,0,'R');

          $tpc_vr = $tpc_vr + $tp_vr;
          $tpc_va = $tpc_va + $tp_va;
          $tpc_sa = $tpc_sa + $tp_sa;

          $tp_vr = 0;
          $tp_va = 0;
          $tp_sa = 0;

          $this->Ln();
          $this->SetDrawColor(0,0,0);
          $this->Cell(280,1,'','T');                            
          $this->Ln();
          $this->Ln();

        }

        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',9);
        $this->Cell(190,3,utf8_decode('TOTALES PARA EL VENDEDOR '.$vendedor),0,0,'L');
        $this->SetFont('Arial','B',7);
        $this->Cell(20,3,number_format(($tpc_vr),0,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($tpc_va),0,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($tpc_sa),0,".",","),0,0,'R');
        $this->Cell(30,3,'',0,0,'L');
        $this->Ln();

        $array_resumen[] = array(
          'vendedor' => $vendedor,
          'valor_recibido' => $tpc_vr,
          'valor_aplicado' => $tpc_va,

        );

        $tpc_vr = 0;
        $tpc_va = 0;
        $tpc_sa = 0;

        $i++;

      }


      $r_tvr = 0;
      $r_tva = 0;

      $this->titulos = 0;
      $this->AddPage();

      $this->SetFont('Arial','B',10);
      $this->Cell(200,5,'RESUMEN DE OPERACIONES',0,0,'L');
      $this->Ln();
      $this->Ln();

      $this->SetFont('Arial','B',8);
      $this->Cell(70,5, utf8_decode('VENDEDOR'),0,0,'L');
      $this->Cell(40,5, utf8_decode('VALOR RECIBIDO'),0,0,'R');
      $this->Cell(40,5, utf8_decode('VALOR APLICADO'),0,0,'R');
      $this->Ln();
      
      foreach ($array_resumen as $r) {
        $this->SetFont('Arial','',8); 
        $this->Cell(70,3,utf8_decode($r['vendedor']),0,0,'L');
        $this->Cell(40,3,number_format(($r['valor_recibido']),0,".",","),0,0,'R');
        $this->Cell(40,3,number_format(($r['valor_aplicado']),0,".",","),0,0,'R');
        $this->Ln();

        $r_tvr = $r_tvr + $r['valor_recibido'];
        $r_tva = $r_tva + $r['valor_aplicado'];

      }

      $this->SetFont('Arial','B',8); 
      $this->Cell(70,3,utf8_decode('TOTAL'),0,0,'R');
      $this->Cell(40,3,number_format(($r_tvr),0,".",","),0,0,'R');
      $this->Cell(40,3,number_format(($r_tva),0,".",","),0,0,'R');
      $this->Ln();

      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(150,1,'','T');                            
      $this->Ln();
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
  $pdf->setTitulos(1);
  $pdf->setFechaInicial($fecha_inicial);
  $pdf->setFechaFinal($fecha_final);
  $pdf->setFechaActual($fecha_act);
  $pdf->setData($array_vendedores);
  $pdf->setVendedorInicial($vendedor_inicial);
  $pdf->setVendedorFinal($vendedor_final);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Recaudos_vendedor_'.date('Y-m-d H_i_s').'.pdf');

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

  $objPHPExcel->setActiveSheetIndex()->mergeCells('A1:M1');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Criterio de búsqueda: Fecha inicial: '.$fecha_inicial.' / Fecha final: '.$fecha_final);

  $objPHPExcel->setActiveSheetIndex()->mergeCells('A2:M2');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('A2', 'Criterio de búsqueda: Vendedor inicial: '.$vendedor_inicial.' / Vendedor final: '.$vendedor_final);

  /*Cabecera tabla*/

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A4', 'NIT');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B4', 'CLIENTE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C4', 'N° RECIBO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D4', 'DOC. APLICADO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E4', 'FEC. RECAU.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F4', 'FEC. RECIB.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G4', 'REF.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H4', 'BANCO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I4', 'FEC. CONSIG.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J4', 'VLR. RECIBIDO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K4', 'VLR. APLICADO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L4', 'SALDO FVE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M4', 'NOTAS');

  $objPHPExcel->getActiveSheet()->getStyle('A4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A4:M4')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $Fila = 6; 

  $array_resumen = array();

  $i = 1;

  $tp_vr = 0;
  $tp_va = 0;
  $tp_sa = 0;

  $tpc_vr = 0;
  $tpc_va = 0;
  $tpc_sa = 0;

  foreach ($array_vendedores as $vendedor => $info) {

    if($i > 1){
      $Fila = $Fila + 1;  
    }

    $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$Fila.':M'.$Fila);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'VENDEDOR '.$vendedor);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getFont()->setBold(true);

    $Fila = $Fila + 1; 

    $mpa = "";
    $rea = "";

    foreach ($info as $medio_pago => $docs) {
      
      foreach ($docs as $reg) {

        $mpn = $medio_pago;
        $ren = $reg['n_recibo'];


        $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $reg['nit']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $reg['cliente']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $reg['n_recibo']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $reg['n_documento']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $reg['fecha_recuado']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $reg['fecha_recibo']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $reg['referencia']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $reg['banco']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $reg['fecha_consignacion']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $reg['valor_recibido']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $reg['valor_aplicado']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $reg['saldo_FVE']);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $reg['notas']);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila.':L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila.':L'.$Fila)->getNumberFormat()->setFormatCode('0');       

        $Fila = $Fila + 1;

        if($rea != $ren){
          $tp_vr = $tp_vr + $reg['valor_recibido'];
        }else{
          if($mpa != $mpn){
            $tp_vr = $tp_vr + $reg['valor_recibido'];
          } 
        }

        $tp_va = $tp_va + $reg['valor_aplicado'];
        $tp_sa = $tp_sa + $reg['saldo_FVE'];


        $mpa = $medio_pago;
        $rea = $reg['n_recibo'];
        
      }

      $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$Fila.':I'.$Fila);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'TOTAL '.$medio_pago);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $tp_vr);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $tp_va);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $tp_sa);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':L'.$Fila)->getFont()->setBold(true);

      $tpc_vr = $tpc_vr + $tp_vr;
      $tpc_va = $tpc_va + $tp_va;
      $tpc_sa = $tpc_sa + $tp_sa;

      $tp_vr = 0;
      $tp_va = 0;
      $tp_sa = 0;

      $Fila = $Fila + 1;

    }

    $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$Fila.':I'.$Fila);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'TOTALES PARA EL VENDEDOR '.$vendedor);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $tpc_vr);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $tpc_va);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $tpc_sa);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila.':L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':L'.$Fila)->getFont()->setBold(true);

    $Fila = $Fila + 1;

    $array_resumen[] = array(
      'vendedor' => $vendedor,
      'valor_recibido' => $tpc_vr,
      'valor_aplicado' => $tpc_va,

    );

    $tpc_vr = 0;
    $tpc_va = 0;
    $tpc_sa = 0;

    $i++;

  }

  $Fila = $Fila + 1;

  $r_tvr = 0;
  $r_tva = 0;

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'RESUMEN DE OPERACIONES');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 2;
  

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'VENDEDOR');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, 'VALOR RECIBIDO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, 'VALOR APLICADO');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

  foreach ($array_resumen as $r) {

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $r['vendedor']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $r['valor_recibido']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $r['valor_aplicado']);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':C'.$Fila)->getNumberFormat()->setFormatCode('0'); 

    $Fila = $Fila + 1;

    $r_tvr = $r_tvr + $r['valor_recibido'];
    $r_tva = $r_tva + $r['valor_aplicado'];

  }

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'TOTAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $r_tvr);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $r_tva);

  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':C'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':C'.$Fila)->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':C'.$Fila)->getFont()->setBold(true);

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

  $n = 'Recaudos_vendedor_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>