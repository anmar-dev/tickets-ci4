<?php 

namespace App\Controllers;
use App\Models\UsersModel;
use CodeIgniter\Controller;

class Authentication extends BaseController {
    
    protected $users_model;

    public function __construct() { 
        $this->data['title']      = 'Authentication - Tickets';
        $this->data['complement'] = '';
        
        $this->users_model = new UsersModel();
    }

	public function index() { 
        echo view('users/auth', $this->data);
    }

    public function login() {

        $rules = array('login' => 'required', 'password' => 'required');

        if (!$this->validate($rules)) {
            $this->data['validation'] = $this->validator;
        } else {

            $login    = $this->request->getPost("login", FILTER_SANITIZE_STRING);
            $password = $this->request->getPost("password", FILTER_SANITIZE_STRING);

            $userData = $this->users_model->getUser($login, md5($password));

            if ($userData) {

                session()->set([
                    'id'         => $userData->cod,
                    'firstname'  => $userData->nome,
                    'email'      => $userData->nome . '@adminformatica.com.br',
                    'isLoggedIn' => true
                ]);
    
                return redirect()->to(base_url('home'));
            } else {
                $this->data['validation'] = 'Invalid Credentials';
            }
        }
        
        echo view('users/auth', $this->data);
    }

    public function logout(){
        session()->destroy();
        return redirect()->to(base_url()); 
	}
}