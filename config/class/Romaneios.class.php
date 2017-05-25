<?php 
require_once 'repository/RomaneiosRepository.class.php';

class Romaneios {
    
    private $id;
    private $idorigem;
    private $dtorigem;
    private $iddestino;
    private $dtdestino;
    private $idmotorista;
    private $idcaminhao;
    private $mensagem;

    public function __construct($id = 0, $idorigem = "", $dtorigem = "", $iddestino = "", $dtdestino = "", $idmotorista = "", $idcaminhao = "") {
        $this->id = $id;
        $this->idorigem = $idorigem;
        $this->dtorigem = $dtorigem;
        $this->iddestino = $iddestino;
        $this->dtdestino = $dtdestino;
        $this->idmotorista = $idmotorista;
        $this->idcaminhao = $idcaminhao;
        $this->mensagem = array();
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getIdorigem() {
        return $this->idorigem;
    }

    public function setIdorigem($idorigem) {
        $this->idorigem = $idorigem;
    }
    
    public function getDtorigem() {
        return $this->dtorigem;
    }

    public function setDtorigem($dtorigem) {
        $this->dtorigem = $dtorigem;
    }
    
    public function getIddestino() {
        return $this->iddestino;
    }

    public function setIddestino($iddestino) {
        $this->iddestino = $iddestino;
    }
    
    public function getDtdestino() {
        return $this->dtdestino;
    }

    public function setDtdestino($dtdestino) {
        $this->dtdestino = $dtdestino;
    }
    
    public function getIdmotorista() {
        return $this->idmotorista;
    }

    public function setIdmotorista($idmotorista) {
        $this->idmotorista = $idmotorista;
    }
    
    public function getIdcaminhao() {
        return $this->idcaminhao;
    }

    public function setIdcaminhao($idcaminhao) {
        $this->idcaminhao = $idcaminhao;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["rom_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->idorigem) == "") {
            $this->mensagem["rom_idorigem"] = "Informe o campo unidade origem corretamente!";
        }
        if(trim($this->dtorigem) == "") {
            $this->mensagem["rom_dtorigem"] = "Informe o campo data de saã­da corretamente!";
        }
        if(trim($this->iddestino) == "") {
            $this->mensagem["rom_iddestino"] = "Informe o campo unidade destino corretamente!";
        }
        if(trim($this->dtdestino) == "") {
            $this->mensagem["rom_dtdestino"] = "Informe o campo data de chegada corretamente!";
        }
        if(trim($this->idmotorista) == "") {
            $this->mensagem["rom_idmotorista"] = "Informe o campo motorista corretamente!";
        }
        if(trim($this->idcaminhao) == "") {
            $this->mensagem["rom_idcaminhao"] = "Informe o campo caminhã£o corretamente!";
        }
    }

}