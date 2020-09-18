<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Home extends Controller {
	public function __construct() {
        $this->data['title']  = 'Tickets - Dashboard';
	}
	
	public function index() {
		echo view('includes/header', $this->data);
        echo view('includes/menu', $this->data);
        echo view('home/index', $this->data);
        echo view('includes/scripts', $this->data);
        echo view('includes/footer', $this->data);
    }
}
