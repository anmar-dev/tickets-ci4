<?php 

namespace App\Controllers;
use App\Models\TicketModel;
use CodeIgniter\Controller;

class Ticket extends BaseController {
    
    private $ticket_model;
    protected $response = array("status" => 0, "data" => []);

    public function __construct() { 
        $this->ticket_model = new TicketModel();
    }

	public function getTicket() { 

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

        $this->data['status'] = 1;
        $this->data['data']   = array('categories' => $categoriesFinal, 'data' => $dataFinal);

        response($this->data);
    }

    public function getCardTicket() { 

        $monthYear = $this->request->getGet('monthYear', FILTER_SANITIZE_STRING);
        $result    = $this->ticket_model->getCardsTickets($monthYear);

        if ($result) {
            $this->data['status'] = 1;
            $this->data['data']   = $result;
        } else {
            $this->data['status'] = 0;
            $this->data['data']   = [];
        }

        response($this->data);
    }
}