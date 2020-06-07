<?php 

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends BaseController {
    
    public function __construct() { 
        $this->session = session();
    }

	public function index() { 
        $this->data['title']      = 'Authentication - Tickets';
		$this->data['complement'] = '';

        echo view('user/auth', $this->data);
    }

    public function login() {

        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            $this->data['validation'] = $this->validator;
        } else {

            $userModel = new UserModel();
            $userData  = $userModel->where('nome', $this->request->getPost("login", FILTER_SANITIZE_STRING))
                            ->where('senha', md5($this->request->getPost("password", FILTER_SANITIZE_STRING)))
                            ->first();

            if ($userData) {

                $this->session->set([
                    'id'         => $userData['cod'],
                    'firstname'  => $userData['nome'],
                    'email'      => $userData['nome'] . '@adminformatica.com.br',
                    'isLoggedIn' => true
                ]);
    
                return redirect()->to(base_url('home'));
            } else {
                $this->data['validation'] = 'Invalid Credentials';
            }
        }
        
        echo view('user/auth', $this->data);
    }

    public function logout(){
        $this->session->destroy();

        return redirect()->to(base_url()); 
	}
}