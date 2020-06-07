<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Home extends Controller {
	public function __construct() {

	}
	
	public function index() {
        $this->data['title']  = 'Tickets - Dashboard';

		echo view('includes/header');
        echo view('includes/menu');
        echo view('home/index', $this->data);

        echo view('includes/scripts');
        echo view('includes/footer');
    }
}
