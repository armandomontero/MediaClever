<?php
namespace App\Models;
use CodeIgniter\Model;

class ServiciosModel extends Model{
    protected $table      = 'servicios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'valor', 'activo', 'id_tienda'];

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


    public function cuentaMaterias($id_tienda){
       $cuentaMaterias = $this->where("id_tienda = " . $id_tienda . " OR id = 1")->countAllResults();
       return $cuentaMaterias;
    }
}

?>
