<?php
namespace App\Models;
use CodeIgniter\Model;

class GoogleModel extends Model{
    protected $table      = 'google';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['credentials', 'token'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
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



 public function __getCredentials(){
        $this->select('credentials');   
        $datos = $this->first();

        return $datos['credentials'];
    }

     public function __getToken(){
        $this->select('token');   
        $datos = $this->first();

        return $datos['token'];
    }
}
?>
