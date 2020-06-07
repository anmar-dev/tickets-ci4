<?php 

namespace App\Controllers;
use App\Models\TicketModel;
use CodeIgniter\Controller;

class Ticket extends BaseController {
    
    public function __construct() { 
        
    }

	public function getTicket() { 

        $monthYear   = $this->request->getGet('monthYear', FILTER_SANITIZE_STRING);
        $ticketModel = new TicketModel();

        $result     = $ticketModel->getTicketsMonth($monthYear);
        $categories = []; 

        foreach (returnDaysOfMonth() as $dia) {
            $categories[$dia] = [
                'dia'  => $dia, 
                'data' => 0
            ];
        }

        foreach ($result as $row) {
            $categories[$row->dia] = array(
                'dia'  => $row->dia, 
                'data' => $row->total_chamados
            );
        }

        foreach($categories as $cat) {
			$categoriesFinal[] = $cat['dia'];
			$dataFinal[]       = floatval($cat['data']);   
        }

        $this->data['status'] = 1;
        $this->data['data']   = [
            'categories' => $categoriesFinal,
            'data'       => $dataFinal
        ];

        response($this->data);
    }

    public function getCardTicket() { 

        $monthYear   = $this->request->getGet('monthYear', FILTER_SANITIZE_STRING);
        $ticketModel = new TicketModel();
        $result      = $ticketModel->getCardsTickets($monthYear);

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