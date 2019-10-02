<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte
$fecha_inicial = $model['fecha_inicial'];
$fecha_final = $model['fecha_final'];
$cliente_inicial = $model['cliente_inicial'];
$cliente_final = $model['cliente_final'];

$clase = $model['clase'];

if ($clase == "") {

  $opt = 1;
  $condicion_clase = "";
  $condicion_canal = "";
  $condicion_ev = "";

  $texto_clase = "TODOS";
  $texto_canal = "TODOS";
  $texto_ev = "TODOS";

} else {

  $opt = 2;

  $array_canales =  $model['canal'];
  $canales = "";
  foreach ($array_canales as $a_canales => $valor) {
    $canales .= "'".$valor."',";
  }
  $canales = substr ($canales, 0, -1);

  $array_evs =  $model['ev'];
  $evs = "";
  foreach ($array_evs as $a_evs => $valor) {
    $evs .= "'".$valor."',";
  }
  $evs = substr ($evs, 0, -1);

  //clase
  $q_clases = Yii::app()->db->createCommand("SELECT f206_id_plan, f204_descripcion, f206_id, f206_descripcion FROM TH_CRITERIOS_CLIENTES WHERE f206_id_plan = ".Yii::app()->params->clases." AND f206_id = '".$clase."' ORDER BY f206_descripcion")->queryRow();

  $condicion_clase = $q_clases['f206_id'].'';
  $texto_clase = $q_clases['f206_descripcion'].'';

  //canales
  $q_canales = Yii::app()->db->createCommand("SELECT DISTINCT f206_id_plan, f204_descripcion, f206_id, f206_descripcion FROM TH_CRITERIOS_CLIENTES WHERE f206_id_plan = ".Yii::app()->params->canales." AND f206_id IN (".$canales.") ORDER BY f206_descripcion")->queryAll();

  $condicion_canal = '';
  $texto_canal = '';

  foreach ($q_canales as $can) {
    $condicion_canal .= $can['f206_id'].',';
    $texto_canal .= $can['f206_descripcion'].',';
  }

  $texto_canal = substr ($texto_canal, 0, -1);
  $condicion_canal = substr ($condicion_canal, 0, -1);

  //estructura de ventas
  $q_evs = Yii::app()->db->createCommand("SELECT DISTINCT f206_id_plan, f204_descripcion, f206_id, f206_descripcion FROM TH_CRITERIOS_CLIENTES WHERE f206_id_plan = ".Yii::app()->params->evs." AND f206_id IN (".$evs.") ORDER BY f206_descripcion")->queryAll();

  $condicion_ev = '';
  $texto_ev = '';

  foreach ($q_evs as $ev) {
    $condicion_ev .= $ev['f206_id'].',';
    $texto_ev .= $ev['f206_descripcion'].',';
  }

  $texto_ev = substr ($texto_ev, 0, -1);
  $condicion_ev = substr ($condicion_ev, 0, -1);

}

$texto_cliente_inicial = Cliente::model()->FindByAttributes(array('C_ROWID_CLIENTE' => $cliente_inicial))->C_NOMBRE_CLIENTE;
$texto_cliente_final = Cliente::model()->FindByAttributes(array('C_ROWID_CLIENTE' => $cliente_final))->C_NOMBRE_CLIENTE;

//se extraen las iniciales de los clientes para pasar como parametro al procedimiento
$abr_cliente_inicial = substr($texto_cliente_inicial, 0, 5);
$abr_cliente_final = substr($texto_cliente_final, 0, 5);

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

//se obtiene el nombre de la empresa de las variables de sesión
$nombre_empresa = Yii::app()->user->getState('name_empresa');

/*inicio configuración array de datos*/

$FechaM1 = str_replace("-","",$fecha_inicial);
$FechaM2 = str_replace("-","",$fecha_final);

$query ="
EXEC [dbo].[COM_RENT_CLIENT_FECHA]
  @FECHA1 = N'".$FechaM1."',
  @FECHA2 = N'".$FechaM2."',
  @CLIENTE1 = N'".$abr_cliente_inicial."',
  @CLIENTE2 = N'".$abr_cliente_final."',
  @OPT = ".$opt.",
  @VAR1 = N'".$condicion_clase."',
  @VAR2 = N'".$condicion_canal."',
  @VAR3 = N'".$condicion_ev."'
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

    function setClienteInicial($cliente_inicial){
      $this->cliente_inicial = $cliente_inicial;
    }

    function setClienteFinal($cliente_final){
      $this->cliente_final = $cliente_final;
    }

    function setClases($clases){
      $this->clases = $clases;
    }

    function setCanales($canales){
      $this->canales = $canales;
    }

    function setEvs($evs){
      $this->evs = $evs;
    }

    function setSql($sql){
      $this->sql = $sql;
    }

    function Header(){
      $this->SetFont('Arial','B',12);
      $this->Cell(200,5,'Rentabilidad por cliente',0,0,'L');
      $this->SetFont('Arial','',9);
      $this->Cell(140,5,utf8_decode($this->nombre_empresa.', '.$this->fecha_actual),0,0,'R');
      $this->Ln();
      $this->SetFont('Arial','',7);
      $this->Cell(340,5,utf8_decode('Criterio de búsqueda: Fecha del '.$this->fecha_inicial.' al '.$this->fecha_final.', Cliente de '.$this->cliente_inicial.' a '.$this->cliente_final),0,0,'L');
      $this->Ln();
      $this->Cell(340,5,utf8_decode('Criterio de búsqueda: Clases: '.$this->clases.' / Canales: '.$this->canales.' / Estructura de ventas: '.$this->evs),0,0,'L');
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
  
      $this->Cell(15,2,utf8_decode('NIT'),0,0,'L');
      $this->Cell(70,2,utf8_decode('CLIENTE'),0,0,'L');
      $this->Cell(22,2,utf8_decode('VLR BRUTO'),0,0,'R');
      $this->Cell(22,2,utf8_decode('VLR DESC.'),0,0,'R');
      $this->Cell(22,2,utf8_decode('VLR'),0,0,'R');
      $this->Cell(12,2,utf8_decode('% DESC.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR BRUTO'),0,0,'R');
      $this->Cell(18,2,utf8_decode('VLR DESC.'),0,0,'R');
      $this->Cell(20,2,utf8_decode('VLR'),0,0,'R');
      $this->Cell(22,2,utf8_decode('VENTA'),0,0,'R');
      $this->Cell(20,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(20,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(21,2,utf8_decode('COSTO'),0,0,'R');
      $this->Cell(22,2,utf8_decode('RENTABILIDAD'),0,0,'R');
      $this->Cell(15,2,utf8_decode('%'),0,0,'R');    
      $this->Ln(3);   
      
      $this->Cell(15,2,'',0,0,'L',5);
      $this->Cell(70,2,utf8_decode(''),0,0,'L',5);
      $this->Cell(22,2,utf8_decode('FACTURA '),0,0,'R',5);
      $this->Cell(22,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(22,2,utf8_decode('FACTURA'),0,0,'R');
      $this->Cell(12,2,utf8_decode('FRA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(18,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(22,2,utf8_decode('NETA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('FACTURA'),0,0,'R',5);
      $this->Cell(20,2,utf8_decode('DEVOLUCIÓN'),0,0,'R',5);
      $this->Cell(21,2,utf8_decode('NETO'),0,0,'R',5);
      $this->Cell(22,2,utf8_decode(''),0,0,'R',5);
      $this->Cell(15,2,utf8_decode('RENT.'),0,0,'R',5);
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
      
      $canal = "";
      $clase = "";
      
      $canal_ant = "";
      $clase_ant = "";

      $VLR_BRUTO_FAC_cl = 0; 
      $VLR_DESC_FAC_cl = 0;     
      $SUBTOTAL_VTA_cl = 0;
      $PORC_FAC_cl = 0;
      $VLR_BRUTO_NDV_cl = 0;     
      $VLR_DESC_NDV_cl = 0;      
      $SUBTOTAL_DVL_cl = 0;     
      $VENTA_NETA_cl = 0;      
      $COST_PROM_FAC_cl = 0;    
      $COST_PROM_NDV_cl = 0;     
      $COSTO_NETO_cl = 0;        
      $RENTABILIDAD_cl = 0;
      $SUBTOTAL_cl = 0; 

      $VLR_BRUTO_FAC_ca = 0; 
      $VLR_DESC_FAC_ca = 0;     
      $SUBTOTAL_VTA_ca = 0;
      $PORC_FAC_ca = 0;
      $VLR_BRUTO_NDV_ca = 0;     
      $VLR_DESC_NDV_ca = 0;      
      $SUBTOTAL_DVL_ca = 0;     
      $VENTA_NETA_ca = 0;      
      $COST_PROM_FAC_ca = 0;    
      $COST_PROM_NDV_ca = 0;     
      $COSTO_NETO_ca = 0;        
      $RENTABILIDAD_ca = 0;
      $SUBTOTAL_ca = 0;

      $VLR_BRUTO_FAC_st = 0; 
      $VLR_DESC_FAC_st = 0;
      $SUBTOTAL_VTA_st = 0;
      $PORC_FAC_st = 0;
      $VLR_BRUTO_NDV_st = 0;     
      $VLR_DESC_NDV_st = 0;
      $SUBTOTAL_DVL_st = 0;     
      $VENTA_NETA_st = 0; 
      $COST_PROM_FAC_st = 0;    
      $COST_PROM_NDV_st = 0;     
      $COSTO_NETO_st = 0;        
      $RENTABILIDAD_st = 0;     
      $SUBTOTAL_st = 0;    

      foreach ($query1 as $reg1) {

        $clase_act = $reg1['CLASE'];
        $canal_act = $reg1['CANAL'];
        
        $NIT               = $reg1 ['NIT']; 
        $CLIENTE           = $reg1 ['CLIENTE'];       
        $VLR_BRUTO_FAC     = $reg1 ['VLR_BRUTO_FAC']; 
        $VLR_DESC_FAC      = $reg1 ['VLR_DESC_FAC'];
        $SUBTOTAL_VTA      = $reg1 ['SUBTOTAL_VTA'];
        $PORC_FAC          = $reg1 ['PORC_FAC'];
        $VLR_BRUTO_NDV     = $reg1 ['VLR_BRUTO_NDV']; 
        $VLR_DESC_NDV      = $reg1 ['VLR_DESC_NDV'];
        $SUBTOTAL_DVL      = $reg1 ['SUBTOTAL_DVL'];
        $VENTA_NETA        = $reg1 ['VENTA_NETA'];
        $COST_PROM_FAC     = $reg1 ['COST_PROM_FAC'];
        $COST_PROM_NDV     = $reg1 ['COST_PROM_NDV'];
        $COSTO_NETO        = $reg1 ['COSTO_NETO'];
        $RENTABILIDAD      = $reg1 ['RENTABILIDAD'];
        $SUBTOTAL          = $reg1 ['SUBTOTAL'];

        //total por canal
        if($canal_act != $canal_ant && $canal_ant != ""){

          $this->SetFont('Arial','B',6);
          $this->Cell(85,5,'TOTAL '.$canal,0,0,'R');
          $this->Cell(22,5,number_format(($VLR_BRUTO_FAC_ca),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($VLR_DESC_FAC_ca),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($SUBTOTAL_VTA_ca),2,".",","),0,0,'R');
          $PORC_FAC_ca = ($VLR_DESC_FAC_ca / $VLR_BRUTO_FAC_ca) * 100; 
          $this->Cell(12,5,number_format(($PORC_FAC_ca),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($VLR_BRUTO_NDV_ca),2,".",","),0,0,'R');
          $this->Cell(18,5,number_format(($VLR_DESC_NDV_ca),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($SUBTOTAL_DVL_ca),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($VENTA_NETA_ca),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($COST_PROM_FAC_ca),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($COST_PROM_NDV_ca),2,".",","),0,0,'R');
          $this->Cell(21,5,number_format(($COSTO_NETO_ca),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($RENTABILIDAD_ca),2,".",","),0,0,'R');
          $SUBTOTAL_ca = ($RENTABILIDAD_ca / $SUBTOTAL_VTA_ca) * 100; 
          $this->Cell(15,5,number_format(($SUBTOTAL_ca),2,".",","),0,0,'R');
          
          //se resetea la sumatoria por estructura de venta
          $VLR_BRUTO_FAC_ca = 0; 
          $VLR_DESC_FAC_ca = 0;     
          $SUBTOTAL_VTA_ca = 0;
          $PORC_FAC_ca = 0;
          $VLR_BRUTO_NDV_ca = 0;     
          $VLR_DESC_NDV_ca = 0;      
          $SUBTOTAL_DVL_ca = 0;     
          $VENTA_NETA_ca = 0;      
          $COST_PROM_FAC_ca = 0;    
          $COST_PROM_NDV_ca = 0;     
          $COSTO_NETO_ca = 0;        
          $RENTABILIDAD_ca = 0;
          $SUBTOTAL_ca = 0;

        }

        //total por clase
        if($clase_act != $clase_ant && $clase_ant != ""){
          $this->Ln();
          $this->SetFont('Arial','B',6);
          $this->Cell(85,5,'TOTAL '.$clase,0,0,'R');
          $this->Cell(22,5,number_format(($VLR_BRUTO_FAC_cl),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($VLR_DESC_FAC_cl),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($SUBTOTAL_VTA_cl),2,".",","),0,0,'R');
          $PORC_FAC_cl = ($VLR_DESC_FAC_cl / $VLR_BRUTO_FAC_cl) * 100; 
          $this->Cell(12,5,number_format(($PORC_FAC_cl),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($VLR_BRUTO_NDV_cl),2,".",","),0,0,'R');
          $this->Cell(18,5,number_format(($VLR_DESC_NDV_cl),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($SUBTOTAL_DVL_cl),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($VENTA_NETA_cl),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($COST_PROM_FAC_cl),2,".",","),0,0,'R');
          $this->Cell(20,5,number_format(($COST_PROM_NDV_cl),2,".",","),0,0,'R');
          $this->Cell(21,5,number_format(($COSTO_NETO_cl),2,".",","),0,0,'R');
          $this->Cell(22,5,number_format(($RENTABILIDAD_cl),2,".",","),0,0,'R');
          $SUBTOTAL_cl = ($RENTABILIDAD_cl / $SUBTOTAL_VTA_cl) * 100; 
          $this->Cell(15,5,number_format(($SUBTOTAL_cl),2,".",","),0,0,'R');
          
          //se resetea la sumatoria por estructura de venta
          $VLR_BRUTO_FAC_cl = 0; 
          $VLR_DESC_FAC_cl = 0;     
          $SUBTOTAL_VTA_cl = 0;
          $PORC_FAC_cl = 0;
          $VLR_BRUTO_NDV_cl = 0;     
          $VLR_DESC_NDV_cl = 0;      
          $SUBTOTAL_DVL_cl = 0;     
          $VENTA_NETA_cl = 0;      
          $COST_PROM_FAC_cl = 0;    
          $COST_PROM_NDV_cl = 0;     
          $COSTO_NETO_cl = 0;        
          $RENTABILIDAD_cl = 0;
          $SUBTOTAL_cl = 0;

        }

        if($clase != $clase_act){
          $clase = $reg1['CLASE'];
          $this->SetFont('Arial','B',7);
          $this->Ln();
          $this->Cell(340,5, 'CLASE: '.$clase ,0,0,'L');
          $this->Ln();
        }

        if($canal != $canal_act){
          $canal = $reg1['CANAL'];
          $this->SetFont('Arial','B',7);
          $this->Ln();
          $this->Cell(340,5, 'CANAL: '.$canal ,0,0,'L');
          $this->Ln();
        }

        $this->SetFont('Arial','',6);
        $this->Cell(15,3,$NIT,0,0,'L');
        $this->Cell(70,3,substr(utf8_decode($CLIENTE),0,50),0,0,'L');
        $this->Cell(22,3,number_format(($VLR_BRUTO_FAC),2,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($VLR_DESC_FAC),2,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($SUBTOTAL_VTA),2,".",","),0,0,'R');
        $this->Cell(12,3,number_format(($PORC_FAC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($VLR_BRUTO_NDV),2,".",","),0,0,'R');
        $this->Cell(18,3,number_format(($VLR_DESC_NDV),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($SUBTOTAL_DVL),2,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($VENTA_NETA),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($COST_PROM_FAC),2,".",","),0,0,'R');
        $this->Cell(20,3,number_format(($COST_PROM_NDV),2,".",","),0,0,'R');
        $this->Cell(21,3,number_format(($COSTO_NETO),2,".",","),0,0,'R');
        $this->Cell(22,3,number_format(($RENTABILIDAD),2,".",","),0,0,'R');
        $this->Cell(15,3,number_format(($SUBTOTAL),2,".",","),0,0,'R');
        $this->Ln();

        $canal_ant = $reg1['CANAL'];
        $clase_ant = $reg1['CLASE'];

        //Sumatoria por clase
        $VLR_BRUTO_FAC_cl += $VLR_BRUTO_FAC; 
        $VLR_DESC_FAC_cl += $VLR_DESC_FAC;     
        $SUBTOTAL_VTA_cl += $SUBTOTAL_VTA;
        $VLR_BRUTO_NDV_cl += $VLR_BRUTO_NDV;     
        $VLR_DESC_NDV_cl += $VLR_DESC_NDV;      
        $SUBTOTAL_DVL_cl += $SUBTOTAL_DVL;     
        $VENTA_NETA_cl += $VENTA_NETA;      
        $COST_PROM_FAC_cl += $COST_PROM_FAC;    
        $COST_PROM_NDV_cl += $COST_PROM_NDV;     
        $COSTO_NETO_cl += $COSTO_NETO;        
        $RENTABILIDAD_cl += $RENTABILIDAD; 

        //Sumatoria por canal
        $VLR_BRUTO_FAC_ca += $VLR_BRUTO_FAC; 
        $VLR_DESC_FAC_ca += $VLR_DESC_FAC;     
        $SUBTOTAL_VTA_ca += $SUBTOTAL_VTA;
        $VLR_BRUTO_NDV_ca += $VLR_BRUTO_NDV;     
        $VLR_DESC_NDV_ca += $VLR_DESC_NDV;      
        $SUBTOTAL_DVL_ca += $SUBTOTAL_DVL;     
        $VENTA_NETA_ca += $VENTA_NETA;      
        $COST_PROM_FAC_ca += $COST_PROM_FAC;    
        $COST_PROM_NDV_ca += $COST_PROM_NDV;     
        $COSTO_NETO_ca += $COSTO_NETO;        
        $RENTABILIDAD_ca += $RENTABILIDAD; 

        //Sumatoria por estructura de venta
        $VLR_BRUTO_FAC_st += $VLR_BRUTO_FAC; 
        $VLR_DESC_FAC_st += $VLR_DESC_FAC;     
        $SUBTOTAL_VTA_st += $SUBTOTAL_VTA;
        $VLR_BRUTO_NDV_st += $VLR_BRUTO_NDV;     
        $VLR_DESC_NDV_st += $VLR_DESC_NDV;      
        $SUBTOTAL_DVL_st += $SUBTOTAL_DVL;     
        $VENTA_NETA_st += $VENTA_NETA;      
        $COST_PROM_FAC_st += $COST_PROM_FAC;    
        $COST_PROM_NDV_st += $COST_PROM_NDV;     
        $COSTO_NETO_st += $COSTO_NETO;        
        $RENTABILIDAD_st += $RENTABILIDAD;           
      }

      //ultimo total por canal
      $this->SetFont('Arial','B',6);
      $this->Cell(85,5,'TOTAL '.$canal,0,0,'R');
      $this->Cell(22,5,number_format(($VLR_BRUTO_FAC_ca),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VLR_DESC_FAC_ca),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($SUBTOTAL_VTA_ca),2,".",","),0,0,'R');
      $PORC_FAC_ca = ($VLR_DESC_FAC_ca / $VLR_BRUTO_FAC_ca) * 100; 
      $this->Cell(12,5,number_format(($PORC_FAC_ca),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_NDV_ca),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_NDV_ca),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($SUBTOTAL_DVL_ca),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VENTA_NETA_ca),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_FAC_ca),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_NDV_ca),2,".",","),0,0,'R');
      $this->Cell(21,5,number_format(($COSTO_NETO_ca),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($RENTABILIDAD_ca),2,".",","),0,0,'R');
      $SUBTOTAL_ca = ($RENTABILIDAD_ca / $SUBTOTAL_VTA_ca) * 100; 
      $this->Cell(15,5,number_format(($SUBTOTAL_ca),2,".",","),0,0,'R');

      //ultimo total por clase
      $this->Ln();
      $this->SetFont('Arial','B',6);
      $this->Cell(85,5,'TOTAL '.$clase,0,0,'R');
      $this->Cell(22,5,number_format(($VLR_BRUTO_FAC_cl),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VLR_DESC_FAC_cl),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($SUBTOTAL_VTA_cl),2,".",","),0,0,'R');
      $PORC_FAC_cl = ($VLR_DESC_FAC_cl / $VLR_BRUTO_FAC_cl) * 100; 
      $this->Cell(12,5,number_format(($PORC_FAC_cl),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_NDV_cl),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_NDV_cl),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($SUBTOTAL_DVL_cl),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VENTA_NETA_cl),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_FAC_cl),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_NDV_cl),2,".",","),0,0,'R');
      $this->Cell(21,5,number_format(($COSTO_NETO_cl),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($RENTABILIDAD_cl),2,".",","),0,0,'R');
      $SUBTOTAL_cl = ($RENTABILIDAD_cl / $SUBTOTAL_VTA_cl) * 100; 
      $this->Cell(15,5,number_format(($SUBTOTAL_cl),2,".",","),0,0,'R');

      $this->SetDrawColor(0,0,0);
      $this->Ln();
      $this->SetDrawColor(0,0,0);
      $this->Cell(340,0,'','T');
      $this->SetDrawColor(255,255,255);
      $this->Ln();

      $this->SetFont('Arial','B',6);
      $this->Cell(85,5,'TOTAL GENERAL',0,0,'R');
      $this->Cell(22,5,number_format(($VLR_BRUTO_FAC_st),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VLR_DESC_FAC_st),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($SUBTOTAL_VTA_st),2,".",","),0,0,'R');
      $PORC_FAC_st = ($VLR_DESC_FAC_st / $VLR_BRUTO_FAC_st) * 100; 
      $this->Cell(12,5,number_format(($PORC_FAC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($VLR_BRUTO_NDV_st),2,".",","),0,0,'R');
      $this->Cell(18,5,number_format(($VLR_DESC_NDV_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($SUBTOTAL_DVL_st),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($VENTA_NETA_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_FAC_st),2,".",","),0,0,'R');
      $this->Cell(20,5,number_format(($COST_PROM_NDV_st),2,".",","),0,0,'R');
      $this->Cell(21,5,number_format(($COSTO_NETO_st),2,".",","),0,0,'R');
      $this->Cell(22,5,number_format(($RENTABILIDAD_st),2,".",","),0,0,'R');
      $SUBTOTAL_st = ($RENTABILIDAD_st / $SUBTOTAL_VTA_st) * 100; 
      $this->Cell(15,5,number_format(($SUBTOTAL_st),2,".",","),0,0,'R');

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
  $pdf->setFechaActual($fecha_act);
  $pdf->setClienteInicial($texto_cliente_inicial);
  $pdf->setClienteFinal($texto_cliente_final);
  $pdf->setNombreEmpresa($nombre_empresa);
  $pdf->setSql($query);
  $pdf->setClases($texto_clase);
  $pdf->setCanales($texto_canal);
  $pdf->setEvs($texto_ev);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->Tabla();
  ob_end_clean();
  $pdf->Output('D','Rentabilidad_cliente_'.date('Y-m-d H_i_s').'.pdf');
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
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'VLR BRUTO FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'VLR DESC. FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'VLR FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', '% DESC. FRA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'VLR BRUTO DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'VLR DESC. DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'VLR DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'VENTA NETA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'COSTO FACTURA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'COSTO DEVOLUCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'COSTO NETO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'RENTABILIDAD');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', '% RENT.');

  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);

  /*Inicio contenido tabla*/

  $query1 = Yii::app()->db->createCommand($query)->queryAll();
      
  $Fila = 2; 
  
  $canal = "";
  $clase = "";
  
  $canal_ant = "";
  $clase_ant = "";

  $VLR_BRUTO_FAC_cl = 0; 
  $VLR_DESC_FAC_cl = 0;     
  $SUBTOTAL_VTA_cl = 0;
  $PORC_FAC_cl = 0;
  $VLR_BRUTO_NDV_cl = 0;     
  $VLR_DESC_NDV_cl = 0;      
  $SUBTOTAL_DVL_cl = 0;     
  $VENTA_NETA_cl = 0;      
  $COST_PROM_FAC_cl = 0;    
  $COST_PROM_NDV_cl = 0;     
  $COSTO_NETO_cl = 0;        
  $RENTABILIDAD_cl = 0;
  $SUBTOTAL_cl = 0; 

  $VLR_BRUTO_FAC_ca = 0; 
  $VLR_DESC_FAC_ca = 0;     
  $SUBTOTAL_VTA_ca = 0;
  $PORC_FAC_ca = 0;
  $VLR_BRUTO_NDV_ca = 0;     
  $VLR_DESC_NDV_ca = 0;      
  $SUBTOTAL_DVL_ca = 0;     
  $VENTA_NETA_ca = 0;      
  $COST_PROM_FAC_ca = 0;    
  $COST_PROM_NDV_ca = 0;     
  $COSTO_NETO_ca = 0;        
  $RENTABILIDAD_ca = 0;
  $SUBTOTAL_ca = 0;

  $VLR_BRUTO_FAC_st = 0; 
  $VLR_DESC_FAC_st = 0;
  $SUBTOTAL_VTA_st = 0;
  $PORC_FAC_st = 0;
  $VLR_BRUTO_NDV_st = 0;     
  $VLR_DESC_NDV_st = 0;
  $SUBTOTAL_DVL_st = 0;     
  $VENTA_NETA_st = 0; 
  $COST_PROM_FAC_st = 0;    
  $COST_PROM_NDV_st = 0;     
  $COSTO_NETO_st = 0;        
  $RENTABILIDAD_st = 0;     
  $SUBTOTAL_st = 0;    
   
  foreach ($query1 as $reg1) {
    
    $clase_act = $reg1['CLASE'];
    $canal_act = $reg1['CANAL'];
    
    $NIT               = $reg1 ['NIT']; 
    $CLIENTE           = $reg1 ['CLIENTE'];       
    $VLR_BRUTO_FAC     = $reg1 ['VLR_BRUTO_FAC']; 
    $VLR_DESC_FAC      = $reg1 ['VLR_DESC_FAC'];
    $SUBTOTAL_VTA      = $reg1 ['SUBTOTAL_VTA'];
    $PORC_FAC          = $reg1 ['PORC_FAC'];
    $VLR_BRUTO_NDV     = $reg1 ['VLR_BRUTO_NDV']; 
    $VLR_DESC_NDV      = $reg1 ['VLR_DESC_NDV'];
    $SUBTOTAL_DVL      = $reg1 ['SUBTOTAL_DVL'];
    $VENTA_NETA        = $reg1 ['VENTA_NETA'];
    $COST_PROM_FAC     = $reg1 ['COST_PROM_FAC'];
    $COST_PROM_NDV     = $reg1 ['COST_PROM_NDV'];
    $COSTO_NETO        = $reg1 ['COSTO_NETO'];
    $RENTABILIDAD      = $reg1 ['RENTABILIDAD'];
    $SUBTOTAL          = $reg1 ['SUBTOTAL'];

    //total por canal
    if($canal_act != $canal_ant && $canal_ant != ""){

      $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, 'TOTAL '.$canal);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_BRUTO_FAC_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_DESC_FAC_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $SUBTOTAL_VTA_ca);
      $PORC_FAC_ca = ($VLR_DESC_FAC_ca / $VLR_BRUTO_FAC_ca) * 100; 
      $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PORC_FAC_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_BRUTO_NDV_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DESC_NDV_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUBTOTAL_DVL_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VENTA_NETA_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_FAC_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_NDV_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COSTO_NETO_ca);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $RENTABILIDAD_ca);
      $SUBTOTAL_ca = ($RENTABILIDAD_ca / $SUBTOTAL_VTA_ca) * 100; 
      $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $SUBTOTAL_ca);
     
      $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getFont()->setBold(true);

      $Fila = $Fila + 1;
      
      //se resetea la sumatoria por estructura de venta
      $VLR_BRUTO_FAC_ca = 0; 
      $VLR_DESC_FAC_ca = 0;     
      $SUBTOTAL_VTA_ca = 0;
      $PORC_FAC_ca = 0;
      $VLR_BRUTO_NDV_ca = 0;     
      $VLR_DESC_NDV_ca = 0;      
      $SUBTOTAL_DVL_ca = 0;     
      $VENTA_NETA_ca = 0;      
      $COST_PROM_FAC_ca = 0;    
      $COST_PROM_NDV_ca = 0;     
      $COSTO_NETO_ca = 0;        
      $RENTABILIDAD_ca = 0;
      $SUBTOTAL_ca = 0;

    }

    //total por clase
    if($clase_act != $clase_ant && $clase_ant != ""){

      $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, 'TOTAL '.$clase);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_BRUTO_FAC_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_DESC_FAC_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $SUBTOTAL_VTA_cl);
      $PORC_FAC_cl = ($VLR_DESC_FAC_cl / $VLR_BRUTO_FAC_cl) * 100; 
      $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PORC_FAC_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_BRUTO_NDV_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DESC_NDV_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUBTOTAL_DVL_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VENTA_NETA_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_FAC_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_NDV_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COSTO_NETO_cl);
      $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $RENTABILIDAD_cl);
      $SUBTOTAL_cl = ($RENTABILIDAD_cl / $SUBTOTAL_VTA_cl) * 100; 
      $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $SUBTOTAL_cl);
     
      $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getFont()->setBold(true);

      $Fila = $Fila + 1;
      
      //se resetea la sumatoria por estructura de venta
      $VLR_BRUTO_FAC_cl = 0; 
      $VLR_DESC_FAC_cl = 0;     
      $SUBTOTAL_VTA_cl = 0;
      $PORC_FAC_cl = 0;
      $VLR_BRUTO_NDV_cl = 0;     
      $VLR_DESC_NDV_cl = 0;      
      $SUBTOTAL_DVL_cl = 0;     
      $VENTA_NETA_cl = 0;      
      $COST_PROM_FAC_cl = 0;    
      $COST_PROM_NDV_cl = 0;     
      $COSTO_NETO_cl = 0;        
      $RENTABILIDAD_cl = 0;
      $SUBTOTAL_cl = 0;

    }

    if($clase != $clase_act){
      $clase = $reg1['CLASE'];
      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'CLASE '.$clase);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getFont()->setBold(true);
      
      $Fila = $Fila + 1;

    }

    if($canal != $canal_act){
      $canal = $reg1['CANAL'];
      $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, 'CANAL '.$canal);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila)->getFont()->setBold(true);
      
      $Fila = $Fila + 1;
    } 

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $NIT);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $CLIENTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_BRUTO_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_DESC_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $SUBTOTAL_VTA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PORC_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_BRUTO_NDV);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DESC_NDV);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUBTOTAL_DVL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VENTA_NETA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_FAC);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_NDV);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COSTO_NETO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $RENTABILIDAD);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $SUBTOTAL);
        
    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':B'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila = $Fila + 1;

    $canal_ant = $reg1['CANAL'];
    $clase_ant = $reg1['CLASE'];

    //Sumatoria por clase
    $VLR_BRUTO_FAC_cl += $VLR_BRUTO_FAC; 
    $VLR_DESC_FAC_cl += $VLR_DESC_FAC;     
    $SUBTOTAL_VTA_cl += $SUBTOTAL_VTA;
    $VLR_BRUTO_NDV_cl += $VLR_BRUTO_NDV;     
    $VLR_DESC_NDV_cl += $VLR_DESC_NDV;      
    $SUBTOTAL_DVL_cl += $SUBTOTAL_DVL;     
    $VENTA_NETA_cl += $VENTA_NETA;      
    $COST_PROM_FAC_cl += $COST_PROM_FAC;    
    $COST_PROM_NDV_cl += $COST_PROM_NDV;     
    $COSTO_NETO_cl += $COSTO_NETO;        
    $RENTABILIDAD_cl += $RENTABILIDAD; 

    //Sumatoria por canal
    $VLR_BRUTO_FAC_ca += $VLR_BRUTO_FAC; 
    $VLR_DESC_FAC_ca += $VLR_DESC_FAC;     
    $SUBTOTAL_VTA_ca += $SUBTOTAL_VTA;
    $VLR_BRUTO_NDV_ca += $VLR_BRUTO_NDV;     
    $VLR_DESC_NDV_ca += $VLR_DESC_NDV;      
    $SUBTOTAL_DVL_ca += $SUBTOTAL_DVL;     
    $VENTA_NETA_ca += $VENTA_NETA;      
    $COST_PROM_FAC_ca += $COST_PROM_FAC;    
    $COST_PROM_NDV_ca += $COST_PROM_NDV;     
    $COSTO_NETO_ca += $COSTO_NETO;        
    $RENTABILIDAD_ca += $RENTABILIDAD; 

    //Sumatoria por estructura de venta
    $VLR_BRUTO_FAC_st += $VLR_BRUTO_FAC; 
    $VLR_DESC_FAC_st += $VLR_DESC_FAC;     
    $SUBTOTAL_VTA_st += $SUBTOTAL_VTA;
    $VLR_BRUTO_NDV_st += $VLR_BRUTO_NDV;     
    $VLR_DESC_NDV_st += $VLR_DESC_NDV;      
    $SUBTOTAL_DVL_st += $SUBTOTAL_DVL;     
    $VENTA_NETA_st += $VENTA_NETA;      
    $COST_PROM_FAC_st += $COST_PROM_FAC;    
    $COST_PROM_NDV_st += $COST_PROM_NDV;     
    $COSTO_NETO_st += $COSTO_NETO;        
    $RENTABILIDAD_st += $RENTABILIDAD;      
  }

  //ultimo total por canal
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, 'TOTAL '.$canal);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_BRUTO_FAC_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_DESC_FAC_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $SUBTOTAL_VTA_ca);
  $PORC_FAC_ca = ($VLR_DESC_FAC_ca / $VLR_BRUTO_FAC_ca) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PORC_FAC_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_BRUTO_NDV_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DESC_NDV_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUBTOTAL_DVL_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VENTA_NETA_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_FAC_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_NDV_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COSTO_NETO_ca);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $RENTABILIDAD_ca);
  $SUBTOTAL_ca = ($RENTABILIDAD_ca / $SUBTOTAL_VTA_ca) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $SUBTOTAL_ca);
 
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

  //ultimo total por clase
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, 'TOTAL '.$clase);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_BRUTO_FAC_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_DESC_FAC_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $SUBTOTAL_VTA_cl);
  $PORC_FAC_cl = ($VLR_DESC_FAC_cl / $VLR_BRUTO_FAC_cl) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PORC_FAC_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_BRUTO_NDV_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DESC_NDV_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUBTOTAL_DVL_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VENTA_NETA_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_FAC_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_NDV_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COSTO_NETO_cl);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $RENTABILIDAD_cl);
  $SUBTOTAL_cl = ($RENTABILIDAD_cl / $SUBTOTAL_VTA_cl) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $SUBTOTAL_cl);
 
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getFont()->setBold(true);

  $Fila = $Fila + 1;

  $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, 'TOTAL GENERAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $VLR_BRUTO_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $VLR_DESC_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $SUBTOTAL_VTA_st);
  $PORC_FAC_st = ($VLR_DESC_FAC_st / $VLR_BRUTO_FAC_st) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $PORC_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $VLR_BRUTO_NDV_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $VLR_DESC_NDV_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $SUBTOTAL_DVL_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $VENTA_NETA_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $COST_PROM_FAC_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $COST_PROM_NDV_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $COSTO_NETO_st);
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $RENTABILIDAD_st);
  $SUBTOTAL_st = ($RENTABILIDAD_st / $SUBTOTAL_VTA_st) * 100; 
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $SUBTOTAL_st);
 
  $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$Fila.':O'.$Fila)->getFont()->setBold(true);

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

  $n = 'Rentabilidad_cliente_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

}

?>











