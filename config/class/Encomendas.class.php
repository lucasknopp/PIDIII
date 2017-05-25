<?php 
require_once 'repository/EncomendasRepository.class.php';

class Encomendas {
    
    private $id;
    private $cod_cliente;
    private $destin_nome;
    private $cid_destino;
    private $end_destino;
    private $numend_destino;
    private $cod_unidade;
    private $data;
    private $bairro_destino;
    private $cep_destino;
    private $codrastreio;
    private $controleromaneio;
    private $mensagem;

    public function __construct($id = 0, $cod_cliente = "", $destin_nome = "", $cid_destino = "", $end_destino = "", $numend_destino = "", $cod_unidade = "", $data = "", $bairro_destino = "", $cep_destino = "", $codrastreio = "", $controleromaneio = "") {
        $this->id = $id;
        $this->cod_cliente = $cod_cliente;
        $this->destin_nome = $destin_nome;
        $this->cid_destino = $cid_destino;
        $this->end_destino = $end_destino;
        $this->numend_destino = $numend_destino;
        $this->cod_unidade = $cod_unidade;
        $this->data = $data;
        $this->bairro_destino = $bairro_destino;
        $this->cep_destino = $cep_destino;
        $this->codrastreio = $codrastreio;
        $this->controleromaneio = $controleromaneio;
        $this->mensagem = array();
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getCod_cliente() {
        return $this->cod_cliente;
    }

    public function setCod_cliente($cod_cliente) {
        $this->cod_cliente = $cod_cliente;
    }
    
    public function getDestin_nome() {
        return $this->destin_nome;
    }

    public function setDestin_nome($destin_nome) {
        $this->destin_nome = $destin_nome;
    }
    
    public function getCid_destino() {
        return $this->cid_destino;
    }

    public function setCid_destino($cid_destino) {
        $this->cid_destino = $cid_destino;
    }
    
    public function getEnd_destino() {
        return $this->end_destino;
    }

    public function setEnd_destino($end_destino) {
        $this->end_destino = $end_destino;
    }
    
    public function getNumend_destino() {
        return $this->numend_destino;
    }

    public function setNumend_destino($numend_destino) {
        $this->numend_destino = $numend_destino;
    }
    
    public function getCod_unidade() {
        return $this->cod_unidade;
    }

    public function setCod_unidade($cod_unidade) {
        $this->cod_unidade = $cod_unidade;
    }
    
    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }
    
    public function getBairro_destino() {
        return $this->bairro_destino;
    }

    public function setBairro_destino($bairro_destino) {
        $this->bairro_destino = $bairro_destino;
    }
    
    public function getCep_destino() {
        return $this->cep_destino;
    }

    public function setCep_destino($cep_destino) {
        $this->cep_destino = $cep_destino;
    }
    
    public function getCodrastreio() {
        return $this->codrastreio;
    }

    public function setCodrastreio($codrastreio) {
        $this->codrastreio = $codrastreio;
    }
    
    public function getControleromaneio() {
        return $this->controleromaneio;
    }

    public function setControleromaneio($controleromaneio) {
        $this->controleromaneio = $controleromaneio;
    }
    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function valida() {
        if(trim($this->id) == "") {
            $this->mensagem["enc_id"] = "Informe o campo id corretamente!";
        }
        if(trim($this->cod_cliente) == "") {
            $this->mensagem["enc_cod_cliente"] = "Informe o campo cod_cliente corretamente!";
        }
        if(trim($this->destin_nome) == "") {
            $this->mensagem["enc_destin_nome"] = "Informe o campo destin_nome corretamente!";
        }
        if(trim($this->cid_destino) == "") {
            $this->mensagem["enc_cid_destino"] = "Informe o campo cid_destino corretamente!";
        }
        if(trim($this->end_destino) == "") {
            $this->mensagem["enc_end_destino"] = "Informe o campo end_destino corretamente!";
        }
        if(trim($this->numend_destino) == "") {
            $this->mensagem["enc_numend_destino"] = "Informe o campo numend_destino corretamente!";
        }
        if(trim($this->cod_unidade) == "") {
            $this->mensagem["enc_cod_unidade"] = "Informe o campo cod_unidade corretamente!";
        }
        if(trim($this->data) == "") {
            $this->mensagem["enc_data"] = "Informe o campo data corretamente!";
        }
        if(trim($this->bairro_destino) == "") {
            $this->mensagem["enc_bairro_destino"] = "Informe o campo bairro_destino corretamente!";
        }
        if(trim($this->cep_destino) == "") {
            $this->mensagem["enc_cep_destino"] = "Informe o campo cep_destino corretamente!";
        }
        if(trim($this->codrastreio) == "") {
            $this->mensagem["enc_codrastreio"] = "Informe o campo codrastreio corretamente!";
        }
        if(trim($this->controleromaneio) == "") {
            $this->mensagem["enc_controleromaneio"] = "Informe o campo controleromaneio corretamente!";
        }
    }

}