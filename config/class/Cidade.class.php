<?php 
require_once 'repository/CidadeRepository.class.php';

class Cidade {
    
    private $id;
    private $nome;
    private $estado;
    private $mensagem;

    public function __construct($id = 0, $nome = "", $estado = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->estado = $estado;
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
    
    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
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
        if(trim($this->estado) == "") {
            $this->mensagem["estado"] = "Informe o campo estado corretamente!";
        }
    }

}