<?php 
require_once 'repository/MotoristasRepository.class.php';

class Motoristas {
    
    private $id;
    private $nome;
    private $numhabilitacao;
    private $mensagem;

    public function __construct($id = 0, $nome = "", $numhabilitacao = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->numhabilitacao = $numhabilitacao;
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
    
    public function getNumhabilitacao() {
        return $this->numhabilitacao;
    }

    public function setNumhabilitacao($numhabilitacao) {
        $this->numhabilitacao = $numhabilitacao;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["mot_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->nome) == "") {
            $this->mensagem["mot_nome"] = "Informe nome corretamente!";
        }
        if(trim($this->numhabilitacao) == "") {
            $this->mensagem["mot_numhabilitacao"] = "Informe o número da habilitação!";
        }
    }

}