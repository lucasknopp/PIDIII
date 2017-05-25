<?php 
require_once 'repository/UnidadesRepository.class.php';

class Unidades {
    
    private $id;
    private $nome;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $tipo;
    private $mensagem;

    public function __construct($id = 0, $nome = "", $endereco = "", $numero = "", $bairro = "", $cidade = "", $tipo = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->tipo = $tipo;
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
    
    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
    
    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    public function getBairro() {
        return $this->bairro;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }
    
    public function getCidade() {
        return $this->cidade;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }
    
    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["uni_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->nome) == "") {
            $this->mensagem["uni_nome"] = "Informe o campo nome corretamente!";
        }
        if(trim($this->endereco) == "") {
            $this->mensagem["uni_endereco"] = "Informe o campo endereco corretamente!";
        }
        if(trim($this->numero) == "") {
            $this->mensagem["uni_numero"] = "Informe o campo numero corretamente!";
        }
        if(trim($this->bairro) == "") {
            $this->mensagem["uni_bairro"] = "Informe o campo bairro corretamente!";
        }
        if(trim($this->cidade) == "") {
            $this->mensagem["uni_cidade"] = "Informe o campo cidade corretamente!";
        }
        if(trim($this->tipo) == "") {
            $this->mensagem["uni_tipo"] = "Informe o campo tipo corretamente!";
        }
    }

}