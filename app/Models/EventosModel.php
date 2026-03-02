<?php
namespace App\Models;
use CodeIgniter\Model;

class EventosModel extends Model{
    protected $table      = 'eventos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['fecha_inicio', 'fecha_fin', 'id_solicitante', 'id_solicitado', 'id_servicio', 'valor', 'region_evento', 
    'comuna_evento', 'causa', 'id_usuario', 'state', 'mail_deriva', 'reservado',
    'enlace', 'texto', 'firma_solicitante', 'firma_solicitado', 'id_tienda'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


     public function eventosPendientes($id_tienda){
        $total = $this->where('state', 'Agendado')->where('id_tienda', $id_tienda)->countAllResults();
    return $total;
    }

    public function eventosRealizados($id_tienda){
        $total = $this->where('state', 'Realizado')->where('id_tienda', $id_tienda)->countAllResults();
    return $total;
    }


    public function totalDia($id_tienda, $fecha){
        
        $total = $this->select('SUM(valor) AS totalDia')->where('state', 'realizado')->where('DATE(created_at)', $fecha)->where('id_tienda', $id_tienda)->first();

        return $total['totalDia'];
    }
}

?>