<?php 

namespace App\Models;
use CodeIgniter\Model;

class TicketsModel extends Model {

    protected $table = 'chamados';
    
    public function getMyTickets() {
        $sql = "SELECT DISTINCT chamado.*, 
        chamado.cod as id, 
        chamado.descricao as description, 
        DATE_FORMAT(chamado.inicio, '%d/%m/%Y') as created_date,
        tipo.nome AS type_name,
        cliente.nome AS client_name,
        modulo.nome AS module_name,
        atendente.nome AS caller_name,
        chamado.andamento AS status,
        chamado.prioridade AS priority
        FROM chamado
        LEFT JOIN evento ON chamado.cod = evento.chamado_cod
        LEFT JOIN AREA ON evento.area_cod = area.cod
        LEFT JOIN tipo ON chamado.tipo_cod = tipo.cod
        LEFT JOIN cliente ON chamado.cliente_cod = cliente.cod
        LEFT JOIN modulo ON chamado.modulo_cod = modulo.cod
        LEFT JOIN atendente ON evento.atendente_cod = atendente.cod
        LEFT JOIN grupo ON cliente.grupo_cod = grupo.cod
        LEFT JOIN orcamento ON chamado.orcamento_cod = orcamento.cod
        WHERE evento.atendente_cod = ? AND chamado.situacao = ? AND evento.concluido = ?
        GROUP BY chamado.cod
        ORDER BY chamado.inicio DESC";

        $result = $this->db->query($sql, [session()->get('id'), 0, 0]);

        return $result->getResult();
    }

    public function getTickets() {
        $sql = "SELECT DISTINCT chamado.*, 
        chamado.cod as id, 
        chamado.descricao as description, 
        DATE_FORMAT(chamado.inicio, '%d/%m/%Y') as created_date,
        tipo.nome AS type_name,
        cliente.nome AS client_name,
        modulo.nome AS module_name,
        atendente.nome AS caller_name,
        chamado.andamento AS status,
        chamado.prioridade AS priority
        FROM chamado
        LEFT JOIN evento ON chamado.cod = evento.chamado_cod
        LEFT JOIN AREA ON evento.area_cod = area.cod
        LEFT JOIN tipo ON chamado.tipo_cod = tipo.cod
        LEFT JOIN cliente ON chamado.cliente_cod = cliente.cod
        LEFT JOIN modulo ON chamado.modulo_cod = modulo.cod
        LEFT JOIN atendente ON evento.atendente_cod = atendente.cod
        LEFT JOIN grupo ON cliente.grupo_cod = grupo.cod
        LEFT JOIN orcamento ON chamado.orcamento_cod = orcamento.cod
        GROUP BY chamado.cod
        ORDER BY chamado.inicio DESC";

        $result = $this->db->query($sql);

        return $result->getResult();
    }

    public function getTicketsMonth(string $monthYear = null) {

        $filter = "DATE_FORMAT(chamado.inicio, '%m%Y') = DATE_FORMAT(CURDATE(), '%m%Y')";

        if ($monthYear) 
            $filter = "DATE_FORMAT(chamado.inicio, '%m%Y') = ?";

        $sql = "SELECT COUNT(DISTINCT(chamado.cod)) AS total, DATE_FORMAT(chamado.inicio, '%d') as day, DATE_FORMAT(chamado.inicio, '%d/%m/%Y') AS daymonthyear
        FROM chamado
        LEFT JOIN evento ON chamado.cod = evento.chamado_cod
        LEFT JOIN AREA ON evento.area_cod = area.cod
        LEFT JOIN tipo ON chamado.tipo_cod = tipo.cod
        LEFT JOIN cliente ON chamado.cliente_cod = cliente.cod
        LEFT JOIN modulo ON chamado.modulo_cod = modulo.cod
        LEFT JOIN atendente ON evento.atendente_cod = atendente.cod
        LEFT JOIN grupo ON cliente.grupo_cod = grupo.cod
        LEFT JOIN orcamento ON chamado.orcamento_cod = orcamento.cod
        WHERE $filter
        GROUP BY DAY(chamado.inicio)
        ORDER BY chamado.inicio ASC";

        $result = $this->db->query($sql, [$monthYear]);

        return $result->getResult();
    }

    public function getCardsTickets(string $monthYear = null) {

        $filter = "DATE_FORMAT(chamado.inicio, '%m%Y') = DATE_FORMAT(CURDATE(), '%m%Y')";

        if ($monthYear) 
            $filter = "DATE_FORMAT(chamado.inicio, '%m%Y') = ?";

        $sql1 = "SELECT cod FROM chamado";
        $sql2 = "SELECT DISTINCT chamado.cod FROM chamado INNER JOIN evento ON chamado.cod = evento.chamado_cod WHERE evento.atendente_cod = ?";
        $sql3 = "SELECT DISTINCT chamado.cod FROM chamado INNER JOIN evento ON chamado.cod = evento.chamado_cod WHERE evento.atendente_cod = ? AND chamado.situacao = ? AND evento.concluido = ?";
        $sql4 = "SELECT DISTINCT chamado.cod FROM chamado INNER JOIN evento ON chamado.cod = evento.chamado_cod WHERE $filter";
        $sql5 = "SELECT COUNT(chamado.cod) / MONTH(CURDATE()) AS avgMonth FROM chamado WHERE YEAR(chamado.inicio) = ?";

        return array(
            'totalTickets'      => count($this->db->query($sql1)->getResult()),
            'myTickets'         => count($this->db->query($sql2, [session()->get('id')])->getResult()),
            'myOpenTickets'     => count($this->db->query($sql3, [session()->get('id'), 0, 0])->getResult()),
            'totalTicketsMonth' => count($this->db->query($sql4, [$monthYear])->getResult()),
            "avgMonth"          => count($this->db->query($sql5, ["YEAR(CURDATE())"])->getResult())
        );
    }
}