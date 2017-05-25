<?php 
require_once 'repository/VeiculosRepository.class.php';

class Veiculos {
    
    private $id;
    private $numplaca;
    private $mensagem;

    public function __construct($id = 0, $numplaca = "") {
        $this->id = $id;
        $this->numplaca = $numplaca;
        $this->mensagem = array();
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNumplaca() {
        return $this->numplaca;
    }

    public function setNumplaca($numplaca) {
        $this->numplaca = $numplaca;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["vei_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->numplaca) == "") {
            $this->mensagem["vei_numplaca"] = "Informe o campo numplaca corretamente!";
        }
    }

}