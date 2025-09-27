<?php

namespace App\Controllers;

use App\Models\EventosModel;
use App\Models\GoogleModel;
use App\Models\ProductosModel;
use App\Models\VentasModel;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{
  protected $productosModel, $ventasModel, $eventosModel, $GoogleModel;

     public function __construct() {
      $this->productosModel = new ProductosModel();
      $this->ventasModel = new VentasModel();
      $this->eventosModel = new EventosModel();
      $this->GoogleModel = new GoogleModel();
    }

    public function index()
    {

      $ventas_dia = $this->ventasModel->cuentaDia($this->session->id_tienda, date('Y-m-d'));
      $total_dia = $this->ventasModel->totalDia($this->session->id_tienda, date('Y-m-d'));
      $eventos_pendientes = $this->eventosModel->eventosPendientes($this->session->id_tienda);
      $eventos_realizados = $this->eventosModel->eventosRealizados($this->session->id_tienda);


      //grafico
      $string_grafico = "[";
      for($i=6; $i>=0; $i--){
        $fecha = date("Y-m-d", strtotime("-".$i." day"));
        $time = Time::parse($fecha, 'America/Santiago');
        $dia =  $time->toLocalizedString('EEE');
        $total = $this->eventosModel->totalDia($this->session->id_tienda, $fecha);
        if($total==null){
          $total = 0;
        }
        
        $string_grafico .="{ dia: '".$dia."' , count: $total },";
      
      }
      $string_grafico .="]";

      //chequeamos conexion con google respecto del usuario
      $google = $this->GoogleModel->checkGoogle($this->session->id_usuario);
     
      $datos = ['eventos_realizados' => $eventos_realizados, 'total_dia' => $total_dia, 'ventas_dia' => $ventas_dia, 'eventos_pendientes' => $eventos_pendientes, 'string_grafico' => $string_grafico, 'google' => $google];


      echo view('header');
      echo view('index', $datos);
      echo view('footer');
    }
}
