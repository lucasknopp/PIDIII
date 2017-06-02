<?php 
require_once 'repository/ClientesRepository.class.php';

class Clientes {
    
    private $id;
    private $nome;
    private $dtnasc;
    private $sexo;
    private $cpf;
    private $email;
    private $senha;
    private $data_cadastro;
    private $tipo;
    private $mensagem;

    public function __construct($id = 0, $nome = "", $dtnasc = "", $sexo = "", $cpf = "", $email = "", $senha = "", $data_cadastro = "", $tipo = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->dtnasc = $dtnasc;
        $this->sexo = $sexo;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha = $senha;
        $this->data_cadastro = $data_cadastro;
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
    
    public function getDtnasc() {
        return $this->dtnasc;
    }

    public function setDtnasc($dtnasc) {
        $this->dtnasc = $dtnasc;
    }
    
    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }
    
    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }
    
    public function getData_cadastro() {
        return $this->data_cadastro;
    }

    public function setData_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
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
            $this->mensagem["cli_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->nome) == "") {
            $this->mensagem["cli_nome"] = "Informe o nome corretamente!";
        }
        if(trim($this->dtnasc) == "") {
            $this->mensagem["cli_dtnasc"] = "Informe uma data de nascimento!";
        } //fazer validação data sem o explode da hora
        if(trim($this->sexo) == "") {
            $this->mensagem["cli_sexo"] = "Informe o sexo do cliente!";
        }
        if(trim($this->cpf) == "") {
            $this->mensagem["cli_cpf"] = "Informe o campo cpf corretamente!";
        }else if(!validaCPF($this->cpf)){
            $this->mensagem["cli_cpf"] = "CPF informado invalido, informe um CPF valido!";
        }else if(!ClientesRepository::localizaCPF($this->cpf)){
            $this->mensagem["cli_cpf"] = "CPF já existente dentro da base de dados!";
        }
        if(trim($this->email) == "") {
            $this->mensagem["cli_email"] = "Informe o campo email corretamente!";
        }//validar email
        if(trim($this->senha) == "") {
            $this->mensagem["cli_senha"] = "Informe o campo senha corretamente!";
        }
        if(trim($this->data_cadastro) == "") {
            $this->mensagem["cli_data_cadastro"] = "Informe o campo data_cadastro corretamente!";
        }
        if(trim($this->tipo) == "") {
            $this->mensagem["cli_tipo"] = "Informe o campo tipo corretamente!";
        }
    }

}