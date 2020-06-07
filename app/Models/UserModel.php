<?php 

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'atendente';

	public function getAllUsers() {
		$sql = "SELECT * FROM atendente";
		$query = $this->db->query($sql);

		return $query->getResult();
    }
    
    public function getUser($login, $pass) {
        $sql   = "SELECT * FROM atendente WHERE (cod = '$login' OR nome = '$login') AND senha = '$pass' LIMIT 1";
        $query = $this->db->query($sql);

		return $query->getRow();
    }
}