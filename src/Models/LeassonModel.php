<?php
    
namespace App\Models;

use App\Api\Sql;

class LeassonModel  {

    public $db;

    public function __construct()
    {
        $this->db = (new Sql())->getDb();
    }

    public function deneme(){
    }
}

?>