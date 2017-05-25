<?php 
require_once 'repository/ItensromaneiosRepository.class.php';

class Itensromaneios {
    
    private $id;
    private $idromaneio;
    private $idencomenda;
    private $mensagem;

    public function __construct($id = 0, $idromaneio = "", $idencomenda = "") {
        $this->id = $id;
        $this->idromaneio = $idromaneio;
        $this->idencomenda = $idencomenda;
        $this->mensagem = array();
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getIdromaneio() {
        return $this->idromaneio;
    }

    public function setIdromaneio($idromaneio) {
        $this->idromaneio = $idromaneio;
    }
    
    public function getIdencomenda() {
        return $this->idencomenda;
    }

    public function setIdencomenda($idencomenda) {
        $this->idencomenda = $idencomenda;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["itr_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->idromaneio) == "") {
            $this->mensagem["itr_idromaneio"] = "Informe o campo idromaneio corretamente!";
        }
        if(trim($this->idencomenda) == "") {
            $this->mensagem["itr_idencomenda"] = "Informe o campo idencomenda corretamente!";
        }
    }

}