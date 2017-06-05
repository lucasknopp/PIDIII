<?php

require_once '../config/conexao.php';

class ClientesRepository {

    public function gravar($clientes) {
        try {
            $pdo = ConexaoDB();
            if ($clientes->getId() > 0) {
                $comando = $pdo->prepare("UPDATE clientes SET cli_nome = :cli_nome, cli_dtnasc = :cli_dtnasc, cli_sexo = :cli_sexo, cli_cpf = :cli_cpf, cli_email = :cli_email, cli_senha = :cli_senha WHERE cli_id = :cli_id");
                $comando->bindValue(":cli_id", $clientes->getId());
            } else {
                $comando = $pdo->prepare("INSERT INTO clientes (cli_nome, cli_dtnasc, cli_sexo, cli_cpf, cli_email, cli_senha, cli_data_cadastro, cli_tipo) VALUES (:cli_nome, :cli_dtnasc, :cli_sexo, :cli_cpf, :cli_email, :cli_senha, :cli_data_cadastro, :cli_tipo)");
                $comando->bindValue(":cli_data_cadastro", $clientes->getData_cadastro());
                $comando->bindValue(":cli_tipo", $clientes->getTipo());
            }
            $comando->bindValue(":cli_senha", $clientes->getSenha());
            $comando->bindValue(":cli_nome", $clientes->getNome());
            $comando->bindValue(":cli_dtnasc", $clientes->getDtnasc());
            $comando->bindValue(":cli_sexo", $clientes->getSexo());
            $comando->bindValue(":cli_cpf", $clientes->getCpf());
            $comando->bindValue(":cli_email", $clientes->getEmail());

            if ($clientes->getId() == 0) {
                $clientes->setId($pdo->lastInsertId());
            }
            $comando->execute();
            $pdo = null;
            return true;
        } catch (Exception $ex) {
            $pdo = null;
            return false;
        }
    }

    public function excluir($id) {
        try {
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("DELETE FROM clientes WHERE cli_id = :cli_id");
            $comando->bindValue(":cli_id", $id);
            $comando->execute();
            $pdo = null;
            return true;
        } catch (Exception $ex) {
            $pdo = null;
            return false;
        }
    }

    public function localizarId($id) {
        try {
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM clientes WHERE cli_id = :cli_id");
            $comando->bindValue(":cli_id", $id);
            $comando->execute();
            $clientes = null;
            if ($linha = $comando->fetch(PDO::FETCH_ASSOC)) {
                $clientes = new Clientes($linha["cli_id"], $linha["cli_nome"], $linha["cli_dtnasc"], $linha["cli_sexo"], $linha["cli_cpf"], $linha["cli_email"], $linha["cli_senha"], $linha["cli_data_cadastro"], $linha["cli_tipo"]);
            }
            $pdo = null;
            return $clientes;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

    public function listar() {
        try {
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM clientes");
            $comando->execute();
            $clientes = [];
            if ($busca = $comando->fetchAll()) {
                foreach ($busca as $linha) {
                    $clientes[] = new Clientes($linha["cli_id"], $linha["cli_nome"], $linha["cli_dtnasc"], $linha["cli_sexo"], $linha["cli_cpf"], $linha["cli_email"], $linha["cli_senha"], $linha["cli_data_cadastro"], $linha["cli_tipo"]);
                }
            }
            $pdo = null;
            return $clientes;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

    public function localizaCPF($cpf) {
        try {
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM clientes WHERE cli_cpf = :cpf");
            $comando->bindValue(":cpf", $cpf);
            $comando->execute();
            if ($comando->rowCount() == 0) {
                return true;
            } else {
                return false;
            }
            $pdo = null;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listarPorNome($nome){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM clientes WHERE cli_nome LIKE :cli_nome ORDER BY cli_nome");
            $comando->bindValue(':cli_nome', '%'.$nome.'%');
            $comando->execute();
            $clientes = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $clientes[] = array('cod_cliente' => $linha['cli_id'], 'nome' => $linha['cli_nome'], 'cpf' => $linha['cli_cpf']);
                }
            }
            $pdo = null;
            return $clientes;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}
