<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

$tipo = $model['tipo'];
$lista = $model['lista'];
$marca_inicial = trim($model['marca_inicial']);
$marca_final = trim($model['marca_final']);
$des_ora_ini = trim($model['des_ora_ini']);
$des_ora_fin = trim($model['des_ora_fin']);

$lp = Yii::app()->db->createCommand("SELECT DISTINCT f112_descripcion FROM UnoEE1..t112_mc_listas_precios WHERE f112_id = '".$lista."'")->queryRow();
$lista_pr = $lista.' - '.$lp['f112_descripcion'];

if($tipo == 1){
  //query rango de marcas
  $cad_rango_mar = $marca_inicial.' a '.$marca_final;
  $cad_rango_ora = '';
}else{
  //query rango de oracle
  $cad_rango_mar = '';
  $cad_rango_ora = $des_ora_ini.' a '.$des_ora_fin;
}

//print_r($model);die;

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



if($tipo == 1){
  //query rango de marcas
  $query= "
    SELECT
    I_CRI_MARCA
    ,I_CRI_LINEA
    ,f120_id AS ID
    ,f120_referencia AS REFERENCIA
    ,f120_descripcion AS DESCRIPCION
    ,f120_id_unidad_inventario AS UNL
    ,f126_precio AS PRECIO
    ,f5801_foto AS FOTO
    FROM UnoEE1..t120_mc_items
    INNER JOIN UnoEE1..t126_mc_items_precios as t126 WITH (NOLOCK) ON f120_rowid = t126.f126_rowid_item AND t126.f126_id_lista_precio = '".$lista."' AND CONVERT(date,f126_fecha_activacion) BETWEEN CONVERT(date,(SELECT DISTINCT MAX(f126_fecha_activacion) FROM UnoEE1.dbo.t126_mc_items_precios AS T2 WHERE T2.f126_id_lista_precio = '".$lista."' AND t126.f126_rowid_item = T2.f126_rowid_item AND CONVERT(date,f126_fecha_activacion)<=CONVERT(date,getdate()))) AND CONVERT(date,getdate())
    LEFT JOIN Portal_Reportes..TH_ITEMS ON I_ROWID_ITEM=f120_rowid
    INNER JOIN UnoEE1..t5801_ff_fotos_baja_calidad ON f120_rowid_foto=f5801_rowid_foto
    WHERE I_CRI_MARCA BETWEEN '".$marca_inicial."' AND '".$marca_final."'
    ORDER BY 1,2,3
  ";
}else{
  //query rango de oracle
  $query= "
    SELECT
    I_CRI_ORACLE
    ,I_CRI_LINEA
    ,f120_id AS ID
    ,f120_referencia AS REFERENCIA
    ,f120_descripcion AS DESCRIPCION
    ,f120_id_unidad_inventario AS UNL
    ,f126_precio AS PRECIO
    ,f5801_foto AS FOTO
    FROM UnoEE1..t120_mc_items
    INNER JOIN UnoEE1..t126_mc_items_precios as t126 WITH (NOLOCK) ON f120_rowid = t126.f126_rowid_item AND t126.f126_id_lista_precio = '".$lista."' AND CONVERT(date,f126_fecha_activacion) BETWEEN CONVERT(date,(SELECT DISTINCT MAX(f126_fecha_activacion) FROM UnoEE1.dbo.t126_mc_items_precios AS T2 WHERE T2.f126_id_lista_precio = '".$lista."' AND t126.f126_rowid_item = T2.f126_rowid_item AND CONVERT(date,f126_fecha_activacion)<=CONVERT(date,getdate()))) AND CONVERT(date,getdate())
    LEFT JOIN Portal_Reportes..TH_ITEMS ON I_ROWID_ITEM=f120_rowid
    INNER JOIN UnoEE1..t5801_ff_fotos_baja_calidad ON f120_rowid_foto=f5801_rowid_foto
    WHERE I_CRI_ORACLE BETWEEN '".$des_ora_ini."' AND '".$des_ora_fin."'
    ORDER BY 1,2,3
  ";
}

/*fin configuración array de datos*/

//PDF

//se incluye la libreria pdf
require_once Yii::app()->basePath . '/extensions/fpdf/fpdf.php';

class PDF extends FPDF{

  function setFechaActual($fecha_actual){
    $this->fecha_actual = $fecha_actual;
  }

  function setSql($sql){
    $this->sql = $sql;
  }

  function setTipo($tipo){
    $this->tipo = $tipo;
  }

  function setLista($lista){
    $this->lista = $lista;
  }

  function setCriterioMar($criteriomar){
    $this->criteriomar = $criteriomar;
  }

  function setCriterioOra($criterioora){
    $this->criterioora = $criterioora;
  }

  function Header(){
    $this->SetFont('Arial','B',9);
    $this->Cell(100,5,utf8_decode('LISTA DE PRECIOS'),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(85,5,utf8_decode($this->fecha_actual),0,0,'R');
    $this->Ln();
    $this->Ln();
    $this->SetFont('Arial','',8);
    $this->Cell(185,5,utf8_decode('Criterio de búsqueda / Lista: '.$this->lista),0,0,'L');
    $this->Ln();
    
    if($this->tipo == 1){
      $this->SetFont('Arial','',8);
      $this->Cell(185,5,utf8_decode('Criterio de búsqueda / Rango marcas: '.$this->criteriomar),0,0,'L');
      $this->Ln();
    }else{
      $this->SetFont('Arial','',8);
      $this->Cell(185,5,utf8_decode('Criterio de búsqueda / Rango desc. oracle: '.$this->criterioora),0,0,'L');
      $this->Ln();    
    }

    $this->Ln();

  }

  function Tabla(){

    $MARCA_LINEA_ACT = "";
    $ORACLE_LINEA_ACT = "";

    $query1 = Yii::app()->db->createCommand($this->sql)->queryAll();

    foreach ($query1 as $reg1) {
      
      if($this->tipo == 1){
        
        $I_CRI_MARCA       = trim($reg1 ['I_CRI_MARCA']);
        $I_CRI_LINEA       = trim($reg1 ['I_CRI_LINEA']);
        $ID                = $reg1 ['ID'];
        $REFERENCIA        = trim($reg1 ['REFERENCIA']);
        $DESCRIPCION       = trim($reg1 ['DESCRIPCION']);    
        $UND               = $reg1 ['UNL'];
        $PRECIO            = $reg1 ['PRECIO'];

        $MARCA_LINEA = $I_CRI_MARCA.' - '.$I_CRI_LINEA;
        
        if (file_exists('images/imgs_listas_tmp/'.$ID.'.jpg')) {
          $FOTO = 'images/imgs_listas_tmp/'.$ID.'.jpg';
        }else{
          $FOTO = 'images/items/default.jpg';
        }


        if($MARCA_LINEA_ACT != $MARCA_LINEA){

          $this->SetFont('Arial','B',7);
          $this->Cell(185,10,utf8_decode($MARCA_LINEA),0,0,'L');
          $this->Ln();

          $MARCA_LINEA_ACT = $MARCA_LINEA;

        }

        $this->SetFont('Arial','',7);
        $this->Cell(5,10,'',0,0,'L');
        $this->Cell(25,10,'',0,0,'C',$this->Image($FOTO,$this->GetX(),$this->GetY(),10,10),0,0,'C');
        $this->Cell(15,10,$ID,0,0,'L');
        $this->Cell(25,10,substr(utf8_decode($REFERENCIA),0, 15),0,0,'L');
        $this->Cell(85,10,substr(utf8_decode($DESCRIPCION), 0, 50),0,0,'L');
        $this->Cell(10,10,substr(utf8_decode($UND), 0, 3),0,0,'L');
        $this->Cell(15,10,number_format(($PRECIO),2,".",","),0,0,'R');
        $this->Ln();

      }else{

        $I_CRI_ORACLE      = $reg1 ['I_CRI_ORACLE'];
        $I_CRI_LINEA       = $reg1 ['I_CRI_LINEA'];
        $ID                = $reg1 ['ID'];
        $REFERENCIA        = $reg1 ['REFERENCIA'];
        $DESCRIPCION       = $reg1 ['DESCRIPCION'];    
        $UND               = $reg1 ['UNL'];
        $PRECIO            = $reg1 ['PRECIO'];

        $ORACLE_LINEA = $I_CRI_ORACLE.' - '.$I_CRI_LINEA;
        
        if (file_exists('images/imgs_listas_tmp/'.$ID.'.jpg')) {
          $FOTO = 'images/imgs_listas_tmp/'.$ID.'.jpg';
        }else{
          $FOTO = 'images/items/default.jpg';
        }

        if($ORACLE_LINEA_ACT != $ORACLE_LINEA){

          $this->SetFont('Arial','B',7);
          $this->Cell(185,10,utf8_decode($ORACLE_LINEA),0,0,'L');
          $this->Ln();

          $ORACLE_LINEA_ACT = $ORACLE_LINEA;

        }

        $this->SetFont('Arial','',7);
        $this->Cell(5,10,'',0,0,'L');
        $this->Cell(25,10,'',0,0,'C',$this->Image($FOTO,$this->GetX(),$this->GetY(),10,10),1,0,'C');
        $this->Cell(15,10,$ID,0,0,'L');
        $this->Cell(25,10,substr(utf8_decode($REFERENCIA),0, 15),0,0,'L');
        $this->Cell(85,10,substr(utf8_decode($DESCRIPCION), 0, 50),0,0,'L');
        $this->Cell(10,10,substr(utf8_decode($UND), 0, 3),0,0,'L');
        $this->Cell(15,10,number_format(($PRECIO),2,".",","),0,0,'R');
        $this->Ln();

      }
      
    }


  }//fin tabla*/

  function Footer()
  {
      $this->SetY(-20);
      $this->SetFont('Arial','B',6);
      $this->Cell(0,8,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
  }
}

$pdf = new PDF('P','mm','A4');
//se definen las variables extendidas de la libreria FPDF
$pdf->setFechaActual($fecha_act);
$pdf->setSql($query);
$pdf->setTipo($tipo);
$pdf->setLista($lista_pr);
$pdf->setCriterioMar($cad_rango_mar);
$pdf->setCriterioOra($cad_rango_ora);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Tabla();
ob_end_clean();
$pdf->Output('D','Lista_'.$lista.'_'.date('Y-m-d H_i_s').'.pdf');

?>