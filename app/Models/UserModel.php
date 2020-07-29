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
    
    public function getUser(string $login, string $pass) {
        $sql   = "SELECT * FROM atendente WHERE (cod = ? OR nome = ?) AND senha = ? LIMIT 1";
        $query = $this->db->query($sql, [$login, $login, $pass]);

		return $query->getRow();
    }
}