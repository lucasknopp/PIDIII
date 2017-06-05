<?php 
require_once 'repository/EstadoRepository.class.php';

class Estado {
    
    private $id;
    private $nome;
    private $uf;
    private $pais;
    private $mensagem;

    public function __construct($id = 0, $nome = "", $uf = "", $pais = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->uf = $uf;
        $this->pais = $pais;
        $this->mensagem = array();
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function getUf() {
        return $this->uf;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }
    
    public function getPais() {
        return $this->pais;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->nome) == "") {
            $this->mensagem["nome"] = "Informe o campo nome corretamente!";
        }
        if(trim($this->uf) == "") {
            $this->mensagem["uf"] = "Informe o campo uf corretamente!";
        }
        if(trim($this->pais) == "") {
            $this->mensagem["pais"] = "Informe o campo pais corretamente!";
        }
    }

}