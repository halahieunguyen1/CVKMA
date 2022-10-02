<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Seeder;
use PDO;

trait SeederTrait
{
    public function cursor() {
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->dbh->query($sql);
        $data = array();
        while($data = $stmt->fetch()){
            yield $data;
        }

    }

    public function piiCursor() {
        $connection = match ($this->connection) {
            'cvo' => 'pii_cvo', 
            'cvo_admin' => 'pii_admin',
            'cvo_crm' => 'pii_crm', 
        };
        $table = 'pii_' . $this->table;
        $pii_primary = match ($this->table) {
            'users' => 'pii_user_id',
            'companies' => 'company_id',
            'employers' => 'employer_id',
            'jobs' => 'job_id',
        };
        $dbh = new PDO("mysql:dbname=$connection;host=127.0.0.1;port=3306", 'root', '');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM $table order by $pii_primary";
        $stmt = $dbh->query($sql);
        $data = array();
        while($data = $stmt->fetch()){
            yield $data;
        }

    }

    public function __construct()
    {
        $this->primary = 'id';
        $arr = explode('\\', __CLASS__);
        $class = $arr[count($arr) - 1];
        $output = strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $class));
        $this->table = $output;
        $this->table = str_replace('y_seeder', 'ies', $this->table);
        $this->table = str_replace('_seeder', 's', $this->table);
        $this->connection = match ($this->table) {
            'users'|'companies' => 'cvo',
            default => 'cvo'
        };
        if ($this->table == 'users') $this->primary = 'user_id';
        $this->dbh = new PDO("mysql:dbname=$this->connection;host=127.0.0.1;port=3306", 'root', '');
    }

    function getAll() {
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM $this->table order by $this->primary";
        $stmt = $this->dbh->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }
}
