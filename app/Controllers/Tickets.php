<?php 

namespace App\Controllers;
use App\Models\TicketsModel;

class Tickets extends BaseController {
    
    private $ticket_model;

    public function __construct() { 
        $this->ticket_model = new TicketsModel();
        $this->data['title'] = 'Tickets - Dashboard';
    }

    public function index() {
		echo view('includes/header', $this->data);
        echo view('includes/menu', $this->data);
        echo view('tickets/index', $this->data);
        echo view('includes/scripts', $this->data);
        echo view('includes/footer', $this->data);
    }

    public function getTickets() {
        $this->response
            ->setStatusCode(200)
            ->setJSON($this->ticket_model->getTickets())
            ->send();
    }

    public function getMyTickets() {
        $this->response
            ->setStatusCode(200)
            ->setJSON($this->ticket_model->getMyTickets())
            ->send();
    }

	public function getChartTickets() { 

        $monthYear  = $this->request->getGet('monthYear', FILTER_SANITIZE_STRING);
        $result     = $this->ticket_model->getTicketsMonth($monthYear);
        $categories = []; 

        foreach (returnDaysOfMonth() as $day) 
            $categories[$day] = array('day' => $day, 'data' => 0);
 
        foreach ($result as $row)
            $categories[$row->day] = array('day' => $row->day, 'data' => $row->total);

        foreach($categories as $cat) {
			$categoriesFinal[] = $cat['day'];
			$dataFinal[]       = floatval($cat['data']);   
        }

        $this->response
            ->setStatusCode(200)
            ->setJSON(array('categories' => $categoriesFinal, 'data' => $dataFinal))
            ->send();
    }

    public function getCardTicket() { 

        $monthYear = $this->request->getGet('monthYear', FILTER_SANITIZE_STRING);

        $this->response
            ->setStatusCode(200)
            ->setJSON($this->ticket_model->getCardsTickets($monthYear))
            ->send();
    }
}