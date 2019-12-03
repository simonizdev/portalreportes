<?php

//clase creada para funciones relacionadas con el modelo de reportes

class UtilidadesReportes {
  
  public static function existenciaspantalla($id_suministro) {
    
    if($id_suministro != null){

      $query1 ="
        SELECT
        S.Id_Suministro,
        S.Codigo,
        S.Descripcion
        FROM TH_SUMINISTRO S
        WHERE Id_Suministro = ".$id_suministro." 
      ";

    }else{

      $query1 ="
        SELECT
        S.Id_Suministro,
        S.Codigo,
        S.Descripcion
        FROM TH_SUMINISTRO S
        ORDER BY S.Descripcion
      ";

    }

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Suministro</th>
                <th>Cantidad</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query1)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $id_suministro    = $reg1 ['Id_Suministro']; 
        $codigo_sum       = $reg1 ['Codigo']; 
        $descripcion_sum  = $reg1 ['Descripcion'];

        $cant = UtilidadesReportes::existenciassuministros($id_suministro);

        if($cant != 0){

          if ($i % 2 == 0){
            $clase = 'odd'; 
          }else{
            $clase = 'even'; 
          }

          $tabla .= '    
          <tr class="'.$clase.'">
                <td>'.$codigo_sum.' - '.$descripcion_sum.'</td>
                <td>'.$cant.'</td>
            </tr>';

          $i++; 

        }  

      }

    }else{
      $tabla .= ' 
        <tr><td colspan="2" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function existenciassuministros($id_suministro) {

    $query_ent= Yii::app()->db->createCommand("SELECT SUM(Cantidad) AS Cant FROM TH_INVENTARIO I WHERE Tipo = 1 AND Id_Suministro = ".$id_suministro)->queryRow();

    $cant_entrada = $query_ent['Cant'];
    
    $query_sal= Yii::app()->db->createCommand("SELECT SUM(Cantidad) AS Cant FROM TH_INVENTARIO I WHERE Tipo = 2 AND Id_Suministro = ".$id_suministro)->queryRow();

    $cant_salida = $query_sal['Cant'];

    if(is_null($cant_entrada) && is_null($cant_salida)){
      $exist = 0; 
    }else{

      if(is_null($cant_entrada)){
        $cant_entrada = 0;
      }

      if(is_null($cant_salida)){
        $cant_salida = 0;
      }

      $exist = $cant_entrada - $cant_salida;

    }

    return $exist;
    
  }

  public static function logmobilepantalla($fecha_inicial, $fecha_final) {
    
    $FechaM1 = str_replace("-","",$fecha_inicial);
    $FechaM2 = str_replace("-","",$fecha_final);

    $query ="
      EXEC [dbo].[COM_CONS_LOGMOBILE_FECHA]
      @FECHA1 = N'".$FechaM1."',
      @FECHA2 = N'".$FechaM2."'
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Documento</th>
                <th>Fecha de elaboración</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Error</th>
                <th>Actualizado</th>
                <th>Eliminado</th>
                <th>Fecha de registro</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!is_null($q1)){
      foreach ($q1 as $reg1) {

        $DOCUMENTO          = $reg1 ['DOCUMENTO']; 
        $FECHA_ELABORACION  = $reg1 ['FECHA_ELABORACION']; 
        $VENDEDOR  = $reg1 ['VENDEDOR'];
        $CLIENTE  = $reg1 ['CLIENTE'];
        $ERROR  = $reg1 ['ERROR'];
        $ACTUALIZADO  = $reg1 ['ACTUALIZADO'];
        $ELIMINADO  = $reg1 ['ELIMINADO'];
        $FECHA_REGISTRO  = $reg1 ['FECHA_REGISTRO'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$DOCUMENTO.'</td>
              <td>'.$FECHA_ELABORACION.'</td>
              <td>'.$VENDEDOR.'</td>
              <td>'.$CLIENTE.'</td>
              <td>'.$ERROR.'</td>
              <td>'.$ACTUALIZADO.'</td>
              <td>'.$ELIMINADO.'</td>
              <td>'.$FECHA_REGISTRO.'</td>
          </tr>';

        $i++; 

      }

    }else{
      $tabla .= ' 
        <tr><td colspan="8" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function vendedorespantalla() {

    $query ="EXEC [dbo].[COM_CONS_VENDEDORES]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Nit</th>
                <th>Vendedor</th>
                <th>Código</th>
                <th>Celular</th>
                <th>Recibo</th>
                <th>Ruta</th>
                <th>Nombre ruta</th>
                <th>Portafolio</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $nit              = $reg1 ['Nit_Vendedor']; 
        $nombre_vendedor  = $reg1 ['Nombre_Vendedor']; 
        $codigo           = $reg1 ['Codigo'];
        $celular          = $reg1 ['Celular'];
        $recibo           = $reg1 ['Recibo'];
        $ruta             = $reg1 ['Ruta'];
        $nombre_ruta      = $reg1 ['Nombre_Ruta'];
        $portafolio       = $reg1 ['Portafolio'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$nit.'</td>
              <td>'.$nombre_vendedor.'</td>
              <td>'.$codigo.'</td>
              <td>'.$celular.'</td>
              <td>'.$recibo.'</td>
              <td>'.$ruta.'</td>
              <td>'.$nombre_ruta.'</td>
              <td>'.$portafolio.'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="8" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function diferenciasrutaspantalla() {

    $query ="EXEC [dbo].[COM_CONS_RUTAS]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Ruta visita</th>
                <th>Ruta criterio</th>
                <th>Nit</th>
                <th>Cliente</th>
                <th>Sucursal</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ruta_visita    = $reg1 ['RUTA_VISITA']; 
        $ruta_criterio  = $reg1 ['RUTA_CRITERIO']; 
        $nit            = $reg1 ['NIT'];
        $cliente        = $reg1 ['CLIENTE'];
        $sucursal       = $reg1 ['SUCURSAL'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ruta_visita.'</td>
              <td>'.$ruta_criterio.'</td>
              <td>'.$nit.'</td>
              <td>'.$cliente.'</td>
              <td>'.$sucursal.'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="5" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function diferenciasunpantalla() {

    $query ="EXEC [dbo].[COM_CONS_UN]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Item</th>
                <th>Descripción</th>
                <th>Código de inventario</th>
                <th>UN de inventario</th>
                <th>Código de criterio</th>
                <th>UN de criterio</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!is_null($q1)){
      foreach ($q1 as $reg1) {

        $item        = $reg1 ['ITEM']; 
        $desc        = $reg1 ['DESCRIPCION']; 
        $cod_inv     = $reg1 ['COD_INVENTARIO'];
        $un_inv      = $reg1 ['UN_INVENTARIO'];
        $cod_cri     = $reg1 ['COD_CRITERIO'];
        $un_cri      = $reg1 ['UN_CRITERIO'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$item.'</td>
              <td>'.$desc.'</td>
              <td>'.$cod_inv.'</td>
              <td>'.$un_inv.'</td>
              <td>'.$cod_cri.'</td>
              <td>'.$un_cri.'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="6" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function erroreptpantalla() {

    $query ="
      EXEC [dbo].[CONF_CONS_ERROR_EPW]
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Row Id</th>
                <th>Ept</th>
                <th>Item</th>
                <th>Cantidad</th>
                <th>Fecha de envío</th>
                <th>Fecha de retorno WMS</th>
                <th># Recepción</th>
                <th>Cargado</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ROWID  = $reg1 ['ROWID']; 
        $EPT  = $reg1 ['EPT']; 
        $ITEM  = $reg1 ['ITEM'];
        $CANTIDAD  = number_format($reg1 ['CANTIDAD'], 0, ',', '.');
        $FECHA_ENVIO  = $reg1 ['FECHA_ENVIO'];
        $FECHA_RETORNO  = $reg1 ['FECHA_RETORNO'];
        $RECEPCION  = $reg1 ['RECEPCION'];
        $CARGADO  = $reg1 ['CARGADO'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ROWID.'</td>
              <td>'.$EPT.'</td>
              <td>'.$ITEM.'</td>
              <td>'.$CANTIDAD.'</td>
              <td>'.$FECHA_ENVIO.'</td>
              <td>'.$FECHA_RETORNO.'</td>
              <td>'.$RECEPCION.'</td>
              <td>'.$CARGADO.'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="8" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function errortalpantalla() {

    $query ="
      EXEC [dbo].[CONF_CONS_ERROR_TAL]
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Row Id</th>
                <th>Doc. alterno</th>
                <th>Item</th>
                <th>Cantidad</th>
                <th>Fecha de retorno WMS</th>
                <th># Recepción</th>
                <th>Cargado</th>
                <th>Doc. siesa</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ROWID = $reg1 ['ROWID']; 
        $DOCTO_ALTERNO  = $reg1 ['DOCTO_ALTERNO']; 
        $ITEM  = $reg1 ['ITEM'];
        $CANTIDAD  = number_format($reg1 ['CANTIDAD'], 0, ',', '.');
        $FECHA_RETORNO  = $reg1 ['FECH_RETORNO'];
        $RECEPCION  = $reg1 ['RECEPCION'];
        $CARGADO  = $reg1 ['CARGADO'];
        $DOCTO_SIESA  = $reg1 ['DOCTO_SIESA'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ROWID.'</td>
              <td>'.$DOCTO_ALTERNO.'</td>
              <td>'.$ITEM.'</td>
              <td>'.$CANTIDAD.'</td>
              <td>'.$FECHA_RETORNO.'</td>
              <td>'.$RECEPCION.'</td>
              <td>'.$CARGADO.'</td>
              <td>'.$DOCTO_SIESA.'</td>
          </tr>';

        $i++; 

      }

    }else{
      $tabla .= ' 
        <tr><td colspan="8" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';  
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

   public static function errorconectorespantalla($fecha) {
    
    $FechaM = str_replace("-","",$fecha);

    $query ="
      SET NOCOUNT ON
      EXEC [dbo].[CONF_ERROR_CONECTORES]
      @FECHA = N'".$FechaM."'
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Fecha</th>
                <th>Conector</th>
                <th>Documento</th>
                <th>Referencia</th>
                <th>Error</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $FECHA          = $reg1 ['Fecha']; 
        $CONECTOR  = $reg1 ['Conector']; 
        $DOCUMENTO  = $reg1 ['Documento'];
        $REFERENCIA  = $reg1 ['Referencia'];
        $ERROR  = $reg1 ['Error'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$FECHA.'</td>
              <td>'.$CONECTOR.'</td>
              <td>'.$DOCUMENTO.'</td>
              <td>'.$REFERENCIA.'</td>
              <td>'.$ERROR.'</td>
          </tr>';

        $i++; 

      }

    }else{
      $tabla .= ' 
        <tr><td colspan="5" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function acttalpantalla() {

    $query ="
      EXEC [dbo].[CONF_CONS_ERROR_TAL]
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Row Id</th>
                <th>Doc. alterno</th>
                <th>Item</th>
                <th>Cantidad</th>
                <th>Fecha de retorno WMS</th>
                <th># Recepción</th>
                <th>Cargado</th>
                <th>Doc. siesa</th>
                <th></th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ROWID = $reg1 ['ROWID']; 
        $DOCTO_ALTERNO  = $reg1 ['DOCTO_ALTERNO']; 
        $ITEM  = $reg1 ['ITEM'];
        $CANTIDAD  = number_format($reg1 ['CANTIDAD'], 0, ',', '.');
        $FECHA_RETORNO  = $reg1 ['FECH_RETORNO'];
        $RECEPCION  = $reg1 ['RECEPCION'];
        $CARGADO  = $reg1 ['CARGADO'];
        $DOCTO_SIESA  = $reg1 ['DOCTO_SIESA'];
        $BOD_ENTRADA  = $reg1 ['BOD_ENTRADA'];
        $BOD_SALIDA  = $reg1 ['BOD_SALIDA'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        if($BOD_ENTRADA == 'BPMER' && $BOD_SALIDA != 'BDPOP'){

          $tabla .= '    
          <tr class="'.$clase.'">
                <td>'.$ROWID.'</td>
                <td>'.$DOCTO_ALTERNO.'</td>
                <td>'.$ITEM.'</td>
                <td>'.$CANTIDAD.'</td>
                <td>'.$FECHA_RETORNO.'</td>
                <td>'.$RECEPCION.'</td>
                <td>'.$CARGADO.'</td>
                <td>'.$DOCTO_SIESA.'</td>
                <td><input type="button" class="btn btn-success" style="padding: 0px 10px 0px 10px !important;font-size:11px !important;" onclick="actbod('.$ROWID.');" value="Cambiar bod. salida"></td>
            </tr>';

        }else{

          $tabla .= '    
          <tr class="'.$clase.'">
                <td>'.$ROWID.'</td>
                <td>'.$DOCTO_ALTERNO.'</td>
                <td>'.$ITEM.'</td>
                <td>'.$CANTIDAD.'</td>
                <td>'.$FECHA_RETORNO.'</td>
                <td>'.$RECEPCION.'</td>
                <td>'.$CARGADO.'</td>
                <td>'.$DOCTO_SIESA.'</td>
                <td><input type="button" class="btn btn-success" style="padding: 0px 10px 0px 10px !important;font-size:11px !important;" onclick="acttal('.$ROWID.');" value="Actualizar"></td>
            </tr>';

        }

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="9" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      '; 
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function invperupantalla() {

    $query ="SELECT * FROM [Qlik].[dbo].[PR_INVENTARIO]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Item</th>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Desc. corta</th>
                <th>Bodega</th>
                <th>Disponible</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ITEM             = $reg1 ['ITEM']; 
        $REFERENCIA       = $reg1 ['REFERENCIA']; 
        $DESCRIPCION      = $reg1 ['DESCRIPCION'];
        $DESCRP_CORTA     = $reg1 ['DESCRP_CORTA'];
        $BODEGA           = $reg1 ['BODEGA'];
        $DISPONIBLE       = $reg1 ['DISPONIBLE'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ITEM.'</td>
              <td>'.$REFERENCIA.'</td>
              <td>'.$DESCRIPCION.'</td>
              <td>'.$DESCRP_CORTA.'</td>
              <td>'.$BODEGA.'</td>
              <td align="right">'.number_format($DISPONIBLE, 0, ',', '.').'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="6" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function invecuadorpantalla() {

    $query ="SELECT * FROM [Qlik].[dbo].[ED_INVENTARIO]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Item</th>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Desc. corta</th>
                <th>Bodega</th>
                <th>Disponible</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ITEM             = $reg1 ['ITEM']; 
        $REFERENCIA       = $reg1 ['REFERENCIA']; 
        $DESCRIPCION      = $reg1 ['DESCRIPCION'];
        $DESCRP_CORTA     = $reg1 ['DESCRP_CORTA'];
        $BODEGA           = $reg1 ['BODEGA'];
        $DISPONIBLE       = $reg1 ['DISPONIBLE'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ITEM.'</td>
              <td>'.$REFERENCIA.'</td>
              <td>'.$DESCRIPCION.'</td>
              <td>'.$DESCRP_CORTA.'</td>
              <td>'.$BODEGA.'</td>
              <td align="right">'.number_format($DISPONIBLE, 0, ',', '.').'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="6" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function invcosecuadorpantalla() {

    $query ="EXEC [dbo].[SP_EC_INVENTARIO_COSTO]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Item</th>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Desc. corta</th>
                <th>Disponible</th>
                <th>Costo</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){

      $TOTAL_COSTO = 0;

      foreach ($q1 as $reg1) {

        $ITEM             = $reg1 ['ITEM']; 
        $REFERENCIA       = $reg1 ['REFERENCIA']; 
        $DESCRIPCION      = $reg1 ['DESCRIPCION'];
        $DESCRP_CORTA     = $reg1 ['DESCRP_CORTA'];
        $DISPONIBLE       = $reg1 ['DISPONIBLE'];
        $COSTO            = $reg1 ['COSTO'];

        $TOTAL_COSTO = $TOTAL_COSTO + $COSTO;  

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ITEM.'</td>
              <td>'.$REFERENCIA.'</td>
              <td>'.$DESCRIPCION.'</td>
              <td>'.$DESCRP_CORTA.'</td>
              <td align="right">'.number_format($DISPONIBLE, 0, ',', '.').'</td>
              <td align="right">'.number_format($COSTO, 2, ',', '.').'</td>
          </tr>';

        $i++; 

      }

      $tabla .= '
          <tr>
          <td colspan="5" align="right"><strong>Costo total</strong></td>
          <td align="right"><strong>'.number_format($TOTAL_COSTO, 2, ',', '.').'</strong></td>
          </tr>
        ';    
    }else{
      $tabla .= ' 
        <tr><td colspan="6" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '
      </tbody></table>';

    return $tabla;
  }

   public static function invcosperupantalla() {

    $query ="EXEC [Qlik].[dbo].[PR_COM_INVENTARIO_COSTO]";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Item</th>
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Desc. corta</th>
                <th>Disponible</th>
                <th>Costo</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){

      $TOTAL_COSTO = 0;

      foreach ($q1 as $reg1) {

        $ITEM             = $reg1 ['ITEM']; 
        $REFERENCIA       = $reg1 ['REFERENCIA']; 
        $DESCRIPCION      = $reg1 ['DESCRIPCION'];
        $DESCRP_CORTA     = $reg1 ['DESCRP_CORTA'];
        $DISPONIBLE       = $reg1 ['DISPONIBLE'];
        $COSTO            = $reg1 ['COSTO'];

        $TOTAL_COSTO = $TOTAL_COSTO + $COSTO;  

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ITEM.'</td>
              <td>'.$REFERENCIA.'</td>
              <td>'.$DESCRIPCION.'</td>
              <td>'.$DESCRP_CORTA.'</td>
              <td align="right">'.number_format($DISPONIBLE, 0, ',', '.').'</td>
              <td align="right">'.number_format($COSTO, 2, ',', '.').'</td>
          </tr>';

        $i++; 

      }

      
      $tabla .= '
          <tr>
          <td colspan="5" align="right"><strong>Costo total</strong></td>
          <td align="right"><strong>'.number_format($TOTAL_COSTO, 2, ',', '.').'</strong></td>
          </tr>
        ';    
    }else{
      $tabla .= ' 
        <tr><td colspan="6" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  
      </tbody></table>';

    return $tabla;
  }

  public static function listamaterialespantalla($item) {

    $q_item = Yii::app()->db->createCommand("
        SELECT   
      f120_rowid AS ROWID_ITEM,
      f121_rowid AS ROWID_ITEM_EXT
      FROM UnoEE1..t120_mc_items
      INNER JOIN UnoEE1..t121_mc_items_extensiones ON f120_rowid = f121_rowid_item
      WHERE f120_id_cia = 2 AND f120_id = ".$item
    )->queryRow();
    
    $ID = $q_item['ROWID_ITEM'];
    $ID_EXT = $q_item['ROWID_ITEM_EXT'];

    $query = "EXEC MNF_PROM_DESGLOCE @Rowid1 = ".$ID.", @Rowid2 = ".$ID_EXT;

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1;

    if(!empty($q1)){

      $tree = '<ul id="tree">';

      foreach ($q1 as $reg1) {

        if($i > 1){
          
          if($i == 2){

            $item = trim($reg1['f_item_resumen']);

            $item_res = substr($item, 0, 40);

            $tree .= '<li><strong><span style="display:inline-block;width:575px">'.$item_res.'</span><span style="display:inline-block;width:140px">UND. MEDIDA</span><span style="display:inline-block;width:140px">CANT. REQ</span><span style="display:inline-block;width:140px">CANT. BASE</span></strong>';

            $n_a =  $reg1['f_treeview_nivel'];
          
          }else{
             
            $n_n = $reg1['f_treeview_nivel'];

            if ($n_n > $n_a) {
              //si el siguiente registro es hijo

              $item = trim($reg1['f_item_resumen']);

              $item_res = substr($item, 0, 40);

              if($n_n == 2){ $width = 535;}
              if($n_n == 3){ $width = 495;}
              if($n_n == 4){ $width = 455;}


              $tree .= '<ul><li><span style="display:inline-block;width:'.$width.'px;">'.$item_res.'</span><span style="display:inline-block;width:140px">'.$reg1['f_um'].'</span><span style="display:inline-block;width:140px;text-align:right;">'.number_format($reg1['f_cant_req'], 4, ',', '.').'</span><span style="display:inline-block;width:140px;text-align:right;">'.number_format($reg1['f_cant_base'], 4, ',', '.').'</span>';

              $n_a =  $reg1['f_treeview_nivel'];

            } elseif ($n_n == $n_a) {
              //si el siguiente registro es hijo

              $item = trim($reg1['f_item_resumen']);

              $item_res = substr($item, 0, 40);

              if($n_n == 2){ $width = 535;}
              if($n_n == 3){ $width = 495;}
              if($n_n == 4){ $width = 455;}

              $tree .= '</li><li><span style="display:inline-block;width:'.$width.'px">'.$item_res.'</span><span style="display:inline-block;width:140px">'.$reg1['f_um'].'</span><span style="display:inline-block;width:140px;text-align:right;">'.number_format($reg1['f_cant_req'], 4, ',', '.').'</span><span style="display:inline-block;width:140px;text-align:right;">'.number_format($reg1['f_cant_base'], 4, ',', '.').'</span>';

              $n_a =  $reg1['f_treeview_nivel'];

            } else {
              //si el siguiente registro no es hijo

              $tree .= '</li>';

              $diff = $n_a - $n_n;

              for ($q=1; $q <= $diff ; $q++) { 
                $tree .= '</ul></li>';
              }

              $item = trim($reg1['f_item_resumen']);

              $item_res = substr($item, 0, 40);

              if($n_n == 2){ $width = 535;}
              if($n_n == 3){ $width = 495;}
              if($n_n == 4){ $width = 455;}

              $tree .= '<li><span style="display:inline-block;width:'.$width.'px">'.$item_res.'</span><span style="display:inline-block;width:140px">'.$reg1['f_um'].'</span><span style="display:inline-block;width:140px;text-align:right;">'.number_format($reg1['f_cant_req'], 4, ',', '.').'</span><span style="display:inline-block;width:140px;text-align:right;">'.number_format($reg1['f_cant_base'], 4, ',', '.').'</span>';

              $n_a =  $reg1['f_treeview_nivel'];  

            }
          }
        }
        
        $i++;

      }

    $tree .= '</li></ul>';
      
    }else{
      $tree = '';  
    }

    
    echo $tree;
  }

  public static function acteptpantalla(){

    $query ="SELECT * FROM [Repositorio_Datos].[dbo].[tbl_IN_Transf_29] WHERE Integrado_Pangea = 4";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Row Id</th>
                <th>Ept</th>
                <th>Item</th>
                <th>Cantidad</th>
                <th># Recepción</th>
                <th></th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ROWID  = $reg1 ['Rowid']; 
        $EPT  = $reg1 ['Centro_Operacion'].'-'.$reg1 ['Tipo_Docto'].'-'.$reg1 ['Consec_Docto']; 
        $ITEM  = $reg1 ['Item'];
        $CANTIDAD  = number_format($reg1 ['Cantidad'], 0, ',', '.');
        $RECEPCION  = $reg1 ['Num_Recepcion'];
        $ROWID_MOVTO  = $reg1 ['Rowid_Movto'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$ROWID.'</td>
              <td>'.$EPT.'</td>
              <td>'.$ITEM.'</td>
              <td>'.$CANTIDAD.'</td>
              <td>'.$RECEPCION.'</td>
              <td><input type="button" class="btn btn-success" style="padding: 0px 10px 0px 10px !important;font-size:11px !important;" onclick="actept('.$ROWID_MOVTO.');" value="Actualizar"></td>
          </tr>';

        $i++; 

      }

    }else{
      $tabla .= ' 
        <tr><td colspan="6" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
        
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function kardexcantidadxitem($item, $fecha) {

    $query = "SELECT
    t7.Descripcion AS LINEA
    ,t3.Id_Item AS ITEM
    ,t1.Fecha_Actualizacion AS APROBACION
    ,t1.Referencia AS REFERENCIA
    ,t8.Id AS Id_Docto
    ,CASE WHEN Id_Tipo_Docto IN (1,4,7) THEN t2.Cantidad ELSE 0 END AS ENTRADA
    ,CASE WHEN Id_Tipo_Docto IN (2,5,6) THEN t2.Cantidad ELSE 0 END AS SALIDA
    FROM TH_I_DOCTO AS t1
    INNER JOIN TH_I_DOCTO_MOVTO AS t2 ON t1.Id=t2.Id_Docto 
    INNER JOIN TH_I_ITEM AS t3 ON t2.Id_Item=t3.Id 
    INNER JOIN TH_I_EXISTENCIA  AS t4 ON t3.Id=t4.Id_Item 
    LEFT JOIN TH_I_BODEGA AS t5 ON t2.Id_Bodega_Org=t5.Id
    LEFT JOIN TH_I_BODEGA AS t6 ON t2.Id_Bodega_Dst=t6.Id
    INNER JOIN TH_I_LINEA AS t7 ON t3.Id_Linea=t7.Id
    INNER JOIN TH_I_TIPO_DOCTO AS t8 ON t1.Id_Tipo_Docto=t8.Id
    INNER JOIN TH_I_TERCERO AS t9 ON t9.Id=t1.Id_Tercero
    WHERE t1.Id_Estado=2 AND CONVERT(nvarchar,t1.Fecha_Actualizacion,112) <='".$fecha."'
    AND t3.Id_Item=".$item." AND t1.Id_Estado=2";

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    if(!empty($q1)){
      
      $entrada = 0;
      $salida  = 0;

      foreach ($q1 as $reg1) {
      
        $tipo_docto = $reg1['Id_Docto'];

        if($tipo_docto == Yii::app()->params->ent || $tipo_docto == Yii::app()->params->aje || $tipo_docto == Yii::app()->params->dev){
          //ENTRADAS - AJUSTES POR ENTRADA
          $entrada = $entrada + $reg1['ENTRADA'];
        }

        if($tipo_docto == Yii::app()->params->sal || $tipo_docto == Yii::app()->params->ajs || $tipo_docto == Yii::app()->params->sad){
          //SALIDA - AJUSTE POR SALIDA
          $salida = $salida + $reg1['SALIDA'];
        }

      }

      $cantidad = $entrada - $salida;

    }else{
      $cantidad = 0;
    }
    
    return $cantidad;
  }

  public static function movimientospantalla($tipo, $consecutivo, $fecha_inicial, $fecha_final, $tercero, $item, $bodega_origen, $bodega_destino) {

    $condicion = "WHERE 1 = 1";

    if($tipo != null){
      $condicion .= " AND DOC.Id_Tipo_Docto = ".$tipo;
    }

    if($consecutivo != null){
      $condicion .= " AND DOC.Consecutivo = ".$consecutivo;
    }

    if($fecha_inicial != null && $fecha_final != null){
      $condicion .= " AND DOC.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'";
    }else{
      if($fecha_inicial != null && $fecha_final == null){
        $condicion .= " AND DOC.Fecha = '".$fecha_inicial."'";
      }
    }

    if($tercero != null){
      $condicion .= " AND DOC.Id_Tercero = ".$tercero;
    }

    if($item != null){
      $condicion .= " AND DET.Id_Item = ".$item;
    }

    if($bodega_origen != null){
      $condicion .= " AND DET.Id_Bodega_Org = ".$bodega_origen;
    }

    if($bodega_destino != null){
      $condicion .= " AND DET.Id_Bodega_Dst = ".$bodega_destino;
    }

    $query ="
      SELECT
      TD.Descripcion AS Desc_Tipo, 
      TD.Tipo AS Tipo, 
      DOC.Consecutivo AS Consecutivo,
      CONCAT (TER.Nit, ' - ', TER.Nombre) AS Tercero,
      DOC.Fecha AS Fecha,
      ED.Descripcion AS Estado_Docto,
      CONCAT (I.Id_Item, ' (', I.Referencia, ' - ', I.Descripcion, ')') AS Item,
      DET.Cantidad AS Cantidad,
      BO.Descripcion AS Bodega_Origen,
      BD.Descripcion AS Bodega_Destino,
      DET.Vlr_Unit_Item AS Vlr_Unit,
      UC.Usuario AS Usuario_Creacion,
      UA.Usuario AS Usuario_Actualizacion
      FROM TH_I_DOCTO_MOVTO DET
      LEFT JOIN TH_I_DOCTO DOC ON DET.Id_Docto = DOC.Id
      LEFT JOIN TH_I_TIPO_DOCTO TD ON DOC.Id_Tipo_Docto = TD.Id
      LEFT JOIN TH_I_ESTADO_DOCTO ED ON DOC.Id_Estado = ED.Id
      LEFT JOIN TH_I_ITEM I ON DET.Id_Item = I.Id
      LEFT JOIN TH_I_BODEGA BO ON DET.Id_Bodega_Org = BO.Id
      LEFT JOIN TH_I_BODEGA BD ON DET.Id_Bodega_Dst = BD.Id
      LEFT JOIN TH_USUARIOS UC ON DET.Id_Usuario_Creacion = UC.Id_Usuario
      LEFT JOIN TH_USUARIOS UA ON DET.Id_Usuario_Actualizacion = UA.Id_Usuario 
      LEFT JOIN TH_I_TERCERO TER ON DOC.Id_Tercero = TER.Id
      ".$condicion."
      ORDER BY 2, 1, 5
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Tipo</th>
                <th>Consecutivo</th>
                <th>Tercero</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Item</th>
                <th>Cantidad</th>
                <th>Vlr. unitario</th>
                <th>Bodega origen</th>
                <th>Bodega destino</th>
                <th>Usuario que creo</th>
                <th>Usuario que actualizó</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){

      foreach ($q1 as $reg) {

        $Tipo    = $reg ['Desc_Tipo']; 
        $Consecutivo       =  $reg ['Tipo'].'-'.$reg ['Consecutivo']; 
        $Tercero = $reg ['Tercero']; 
        $Tipo    = $reg ['Desc_Tipo']; 
        $Fecha  = $reg ['Fecha'];
        $Estado_Docto  = $reg ['Estado_Docto'];
        $Item  = $reg ['Item'];
        $Cantidad  = $reg ['Cantidad'];
        $Vlr_Unit  = $reg ['Vlr_Unit'];

        if(is_null($reg ['Bodega_Origen'])){
          $Bodega_Origen  = '-';
        }else{
          $Bodega_Origen  = $reg ['Bodega_Origen'];
        }

        if(is_null($reg ['Bodega_Destino'])){
          $Bodega_Destino  = '-';
        }else{
          $Bodega_Destino  = $reg ['Bodega_Destino'];
        }

        $Usuario_Creacion  = $reg ['Usuario_Creacion'];
        $Usuario_Actualizacion  = $reg ['Usuario_Actualizacion'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$Tipo.'</td>
              <td>'.$Consecutivo.'</td>
              <td>'.substr($Tercero,0, 39).'</td>
              <td>'.$Fecha.'</td>
              <td>'.$Estado_Docto.'</td>
              <td>'.substr($Item,0, 40).'</td>
              <td align="right">'.$Cantidad.'</td>
              <td align="right">'.number_format(($Vlr_Unit),0,".",",").'</td>
              <td>'.$Bodega_Origen.'</td>
              <td>'.$Bodega_Destino.'</td>
              <td>'.$Usuario_Creacion.'</td>
              <td>'.$Usuario_Actualizacion.'</td>
          </tr>';

        $i++; 

      }
   
    }else{
      $tabla .= ' 
        <tr><td colspan="12" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  
      </tbody></table>';

    return $tabla;

  }

  public static function cosinvbodpantalla($bodega) {

    $criteria=new CDbCriteria;
    $criteria->join = 'LEFT JOIN TH_I_ITEM i ON i.Id = t.Id_Item LEFT JOIN TH_I_LINEA l ON i.Id_Linea = l.Id';
    $criteria->condition='t.Id_Bodega=:bodega AND t.Cantidad > 0';
    $criteria->params=array(':bodega'=>$bodega);
    $criteria->order='l.Descripcion ASC, i.Descripcion ASC';
    $items_exist=IExistencia::model()->findAll($criteria);

    $desc_bodega = IBodega::model()->findByPk($bodega)->Descripcion;

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Línea</th>
                <th>Item</th>
                <th>Costo unitario</th>
                <th>Cantidad</th>
                <th>Costo Total</th>
                </tr>
              </thead>
          <tbody>';

    $i = 1;
    $total = 0; 

    if(!empty($items_exist)){

      foreach ($items_exist as $reg) {

        $linea        = $reg->iditem->idlinea->Descripcion; 
        $item         = $reg->DescItem($reg->Id_Item); 
        $costo_unit   = $reg->iditem->Vlr_Costo / $reg->iditem->Total_Inventario; 
        $cantidad     = $reg->Cantidad;
        $costo_tot    = ($reg->iditem->Vlr_Costo / $reg->iditem->Total_Inventario) * $cantidad;

        $total = $total + $costo_tot;

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
          <tr class="'.$clase.'">
              <td>'.$linea.'</td>
              <td>'.$item.'</td>
              <td align="right">'.number_format(($costo_unit),2,".",",").'</td>
              <td align="right">'.$cantidad.'</td>
              <td align="right">'.number_format(($costo_tot),2,".",",").'</td>
          </tr>';

        $i++; 

      }

      $tabla .= '    
        <tr class="'.$clase.'">
            <td colspan="4" align="right"><strong>TOTAL '.$desc_bodega.'</strong></td>
            <td align="right"><strong>'.number_format(($total),2,".",",").'</strong></td>
        </tr>';
   
    }else{
      $tabla .= ' 
        <tr><td colspan="5" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  
      </tbody></table>';

    return $tabla;

  }

  public static function cosinvtotpantalla() {

    $criteria=new CDbCriteria;
    $criteria->join = 'LEFT JOIN TH_I_LINEA l ON l.Id = t.Id_Linea';
    $criteria->condition='t.Total_Inventario <> 0 AND t.Vlr_Costo <> 0';
    $criteria->order='l.Descripcion ASC, t.Descripcion ASC';
    $items_exist=IItem::model()->findAll($criteria);

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Línea</th>
                <th>Item</th>
                <th>Costo unitario</th>
                <th>Cantidad</th>
                <th>Costo Total</th>
                </tr>
              </thead>
          <tbody>';

    $i = 1;
    $total = 0; 

    if(!empty($items_exist)){

      foreach ($items_exist as $reg) {

        $linea        = $reg->idlinea->Descripcion; 
        $item         = $reg->Id_Item.' ('.$reg->Referencia.' - '.$reg->Descripcion.')'; 
        $costo_unit   = $reg->Vlr_Costo / $reg->Total_Inventario; 
        $cantidad     = $reg->Total_Inventario;
        $costo_tot    = ($reg->Vlr_Costo / $reg->Total_Inventario) * $cantidad;

        $total = $total + $costo_tot;

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
          <tr class="'.$clase.'">
              <td>'.$linea.'</td>
              <td>'.$item.'</td>
              <td align="right">'.number_format(($costo_unit),2,".",",").'</td>
              <td align="right">'.$cantidad.'</td>
              <td align="right">'.number_format(($costo_tot),2,".",",").'</td>
          </tr>';

        $i++; 

      }

      $tabla .= '    
        <tr class="'.$clase.'">
            <td colspan="4" align="right"><strong>TOTAL</strong></td>
            <td align="right"><strong>'.number_format(($total),2,".",",").'</strong></td>
        </tr>';
   
    }else{
      $tabla .= ' 
        <tr><td colspan="5" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  
      </tbody></table>';

    return $tabla;

  }

  public static function actrecapantalla() {

    $query ="
      SELECT 
      ROWID,
      F350_ID_TERCERO,
      F357_REFERENCIA,
      F357_VALOR_APLICAR_REAL,
      F357_ID_COBRADOR,
      F350_NOTAS,
      F353_ID_SUCURSAL_DOCTO_CRUCE,
      F358_REFERENCIA_OTROS    
      FROM [Repositorio_Datos].[dbo].[T_IN_Recibos_Caja]
      WHERE [INTEGRADO] = 1
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Row Id</th>
                <th>Nit Tercero</th>
                <th>Referencia de pago</th>
                <th>Vlr. aplicado</th>
                <th>Id cobrador</th>
                <th>Nota</th>
                <th>Id sucursal docto. cruce</th>
                <th>Factura</th>
                <th></th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db2->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $ROWID = $reg1 ['ROWID']; 
        $F350_ID_TERCERO  = $reg1 ['F350_ID_TERCERO']; 
        $F357_REFERENCIA  = $reg1 ['F357_REFERENCIA'];
        $F357_VALOR_APLICAR_REAL  = number_format($reg1 ['F357_VALOR_APLICAR_REAL'], 0, ',', '.');
        $F357_ID_COBRADOR  = $reg1 ['F357_ID_COBRADOR'];
        $F350_NOTAS  = $reg1 ['F350_NOTAS'];
        $F353_ID_SUCURSAL_DOCTO_CRUCE  = $reg1 ['F353_ID_SUCURSAL_DOCTO_CRUCE'];
        $F358_REFERENCIA_OTROS  = $reg1 ['F358_REFERENCIA_OTROS'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
          <td>'.$ROWID.'</td>
          <td>'.$F350_ID_TERCERO.'</td>
          <td>'.$F357_REFERENCIA.'</td>
          <td align="right">'.$F357_VALOR_APLICAR_REAL.'</td>
          <td>'.$F357_ID_COBRADOR.'</td>
          <td>'.$F350_NOTAS.'</td>
          <td>'.$F353_ID_SUCURSAL_DOCTO_CRUCE.'</td>
          <td>'.$F358_REFERENCIA_OTROS.'</td>
          <td><input type="button" class="btn btn-success" style="padding: 0px 10px 0px 10px !important;font-size:11px !important;" onclick="actreca('.$ROWID.');" value="Actualizar"></td>
        </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="8" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      '; 
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function consultapagospantalla() {

    $query ="
      SELECT DISTINCT 
      t1.Rowid AS Rowid
      ,Descr_Msj AS Banco
      ,Num_Ident AS Nit_Cliente
      ,Nom_Cliente AS Cliente
      ,Referencia AS Factura
      ,Num_Fact AS Numero_Factura
      ,Mod_Pago AS Medio_Pago
      ,Estado AS Estado
      ,Valor_Pago AS Valor
      ,Cus AS Referencia_Pago
      ,ts_fecha AS Fecha_Reporte 
      ,CASE WHEN ISNULL(INTEGRADO,0) = 0 THEN 'SIN REPORTE' WHEN ISNULL(INTEGRADO,0)=1 THEN 'PENDIENTE' WHEN ISNULL(INTEGRADO,0)=2 THEN 'CARGADO' END AS Reportado
      from Pagos_Inteligentes..T_PSE AS t1
      LEFT JOIN [Repositorio_Datos].[dbo].[T_IN_Recibos_Caja] AS t2 ON t1.Id_Cliente = t2.F350_ID_TERCERO AND t1.Cus = t2.F357_REFERENCIA AND t1.Referencia = t2.F350_NOTAS
      ORDER BY 1 DESC
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Row Id</th>
                <th>Banco</th>
                <th>Nit</th>
                <th>Cliente</th>
                <th>Factura</th>
                <th># Factura</th>
                <th>Medio de pago</th>
                <th>Estado</th>
                <th>Valor</th>
                <th>Ref. pago</th>
                <th>Fecha reporte</th>
                <th>Reportado</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $Rowid  = $reg1 ['Rowid']; 
        $Banco  = $reg1 ['Banco']; 
        $Nit_Cliente  = $reg1 ['Nit_Cliente']; 
        $Cliente  = $reg1 ['Cliente']; 
        $Factura  = $reg1 ['Factura']; 
        $Numero_Factura  = $reg1 ['Numero_Factura']; 
        $Medio_Pago  = $reg1 ['Medio_Pago']; 
        $Estado  = $reg1 ['Estado']; 
        $Valor  = number_format($reg1 ['Valor'], 0, ',', '.');
        $Referencia_Pago  = $reg1 ['Referencia_Pago']; 
        $Fecha_Reporte  = $reg1 ['Fecha_Reporte']; 
        $Reportado  = $reg1 ['Reportado']; 

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$Rowid.'</td>
              <td>'.$Banco.'</td>
              <td>'.$Nit_Cliente.'</td>
              <td>'.$Cliente.'</td>
              <td>'.$Factura.'</td>
              <td>'.$Numero_Factura.'</td>
              <td>'.$Medio_Pago.'</td>
              <td>'.$Estado.'</td>
              <td align="right">'.$Valor.'</td>
              <td>'.$Referencia_Pago.'</td>
              <td>'.$Fecha_Reporte.'</td>
              <td>'.$Reportado.'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="12" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function auditoriapedidospantalla($co, $tipo, $consecutivo) {

    $query ="

    SELECT DISTINCT
    t1.[Compania] AS CIA
    ,t1.[Cent_Operacion] AS CENTRO_OP
    ,t1.[Docto] AS DOCUMENTO
    ,t1.[Num_Docto] AS NUM_PEDIDO
    ,CASE WHEN t1.[Integrado] = 0 THEN 'NO' ELSE 'SI' END AS LEIDO_WMS
    ,ISNULL(CONVERT(nvarchar,t2.[FechaRegistro],103),'NO') AS LIBERADO_WMS
    FROM [Repositorio_Datos].[dbo].[Ped_Ven_Comp_Simoniz] AS t1
    LEFT JOIN [Repositorio_Datos].[dbo].FacturaSIMONIZ_Detalles AS t2 ON CentroOperacion=[Cent_Operacion] AND Tipo_Docto=[Docto] AND DocumentoPedido = [Num_Docto] WHERE Cent_Operacion = '".$co."' AND Docto = '".$tipo."' AND Num_Docto = '".$consecutivo."'";

    //echo $query;die;

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Leido por WMS</th>
                <th>Liberado por WMS</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $LEIDO_WMS     = $reg1 ['LEIDO_WMS']; 
        $LIBERADO_WMS  = $reg1 ['LIBERADO_WMS']; 

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
              <td>'.$LEIDO_WMS.'</td>
              <td>'.$LIBERADO_WMS.'</td>
          </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="2" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

  public static function venposfaltpantalla($fecha_inicial, $fecha_final) {

    $FechaM1 = str_replace("-","",$fecha_inicial);
    $FechaM2 = str_replace("-","",$fecha_final);

    $query ="
      EXEC [dbo].[COM_POS1_FONT]
      @FECHA_INI = N'".$FechaM1."',
      @FECHA_FIN = N'".$FechaM2."'
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Fecha</th>
                <th>Item</th>
                <th>Descripción</th>
                <th>Existencia</th>
                <th>Cantidad</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $FECHA            = $reg1 ['FECHA']; 
        $ITEM             = $reg1 ['ITEM']; 
        $DESCRIPCION      = $reg1 ['DESCRIPCION'];
        $EXISTENCIA       = $reg1 ['EXISTENCIA'];
        $CANTIDAD         = $reg1 ['CANTIDAD'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $cal = $EXISTENCIA - $CANTIDAD;

        if($cal < 0){
          $tabla .= '    
          <tr class="'.$clase.'">
            <td>'.$FECHA.'</td>
            <td>'.$ITEM.'</td>
            <td>'.$DESCRIPCION.'</td>
            <td align="right">'.$EXISTENCIA.'</td>
            <td align="right">'.$CANTIDAD.'</td>
          </tr>';

          $i++;
        } 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="5" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;

  }

  public static function venposentrpantalla($fecha_inicial, $fecha_final) {

    $FechaM1 = str_replace("-","",$fecha_inicial);
    $FechaM2 = str_replace("-","",$fecha_final);

    $query ="
      EXEC [dbo].[COM_POS2_FONT]
      @FECHA_INI = N'".$FechaM1."',
      @FECHA_FIN = N'".$FechaM2."'
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Pedido</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Item</th>
                <th>Descripción</th>
                <th>Und. medida</th>
                <th>Existencia</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Vlr. neto</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $PEDIDO           = $reg1 ['PEDIDO'];
        $CLIENTE          = $reg1 ['CLIENTE'];
        $FECHA            = $reg1 ['FECHA']; 
        $ITEM             = $reg1 ['ITEM']; 
        $DESCRIPCION      = $reg1 ['DESCRIPCION'];
        $UM               = $reg1 ['UM'];
        $EXISTENCIA       = $reg1 ['EXISTENCIA'];
        $CANTIDAD         = $reg1 ['CANTIDAD'];
        $PRECIO           = $reg1 ['PRECIO'];
        $VLR_NETO         = $reg1 ['VLR_NETO'];

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
          <td>'.$PEDIDO.'</td>
          <td>'.$CLIENTE.'</td>
          <td>'.$FECHA.'</td>
          <td>'.$ITEM.'</td>
          <td>'.$DESCRIPCION.'</td>
          <td>'.$UM.'</td>
          <td align="right">'.$EXISTENCIA.'</td>
          <td align="right">'.$CANTIDAD.'</td>
          <td align="right">'.number_format(($PRECIO),2,".",",").'</td>
          <td align="right">'.number_format(($VLR_NETO),2,".",",").'</td>
        </tr>';

        $i++;
       
      }
    }else{
      $tabla .= ' 
        <tr><td colspan="10" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;

  }

  public static function consultafactelectpantalla($tipo, $cons_inicial, $cons_final) {

    $query ="
      SELECT * FROM TH_FACTURA_ELECTRONICA WHERE FE_TIPO_DOCTO = '".$tipo."' AND FE_CONSECUTIVO BETWEEN ".$cons_inicial." AND ".$cons_final." ORDER BY 12
    ";

    $tabla = '
      <table class="table table-striped table-hover">
              <thead>
                <tr>
                <th>Cia</th>
                <th>CO</th>
                <th>Tipo de docto</th>
                <th>Desc. tipo</th>
                <th>Consecutivo</th>
                <th>Cufe</th>
                <th>Fecha de factura</th>
                <th>Fecha de creación</th>
                </tr>
              </thead>
          <tbody>';

    $q1 = Yii::app()->db->createCommand($query)->queryAll();

    $i = 1; 

    if(!empty($q1)){
      foreach ($q1 as $reg1) {

        $cia  = $reg1 ['FE_CIA']; 
        $co  = $reg1 ['FE_CO']; 
        $tipo_docto  = $reg1 ['FE_TIPO_DOCTO']; 

        if($tipo_docto == "FVN") {
          $tipo = 'Factura de Venta Nacional';
        }

        if($tipo_docto == "FVX") {
          $tipo = 'Factura de Exportación';
        }

        if($tipo_docto == "FEC") {
          $tipo = 'Factura de Contingencia Facturador';
        }

        $consecutivo  = $reg1 ['FE_CONSECUTIVO'];
        $cufe  = $reg1 ['FE_CUFE'];
        $fecha_factura  = $reg1 ['FE_FECHA_FACTURA']; 
        $fecha_creacion  = $reg1 ['CREACION'];  

        if ($i % 2 == 0){
          $clase = 'odd'; 
        }else{
          $clase = 'even'; 
        }

        $tabla .= '    
        <tr class="'.$clase.'">
            <td>'.$cia.'</td>
            <td>'.$co.'</td>
            <td>'.$tipo_docto.'</td>
            <td>'.$tipo.'</td>
            <td>'.$consecutivo.'</td>
            <td>'.$cufe.'</td>
            <td>'.$fecha_factura.'</td>
            <td>'.$fecha_creacion.'</td>
        </tr>';

        $i++; 

      }
    }else{
      $tabla .= ' 
        <tr><td colspan="8" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>
      ';
    }

    $tabla .= '  </tbody>
        </table>';

    return $tabla;
  }

}
