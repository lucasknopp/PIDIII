<?php
require_once '../config/conexao.php';

class EstadoRepository {
    public function gravar($estado) {
        try {
            $pdo = ConexaoDB();
            if($estado->getId() > 0) {
            $comando = $pdo->prepare("UPDATE estado SET nome = :nome, uf = :uf, pais = :pais WHERE id = :id");
            $comando->bindValue(":id", $estado->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO estado (nome, uf, pais) VALUES (:nome, :uf, :pais)");
            }
            $comando->bindValue(":nome", $estado->getNome());
            $comando->bindValue(":uf", $estado->getUf());
            $comando->bindValue(":pais", $estado->getPais());
            if ($estado->getId() == 0) {
                $estado->setId($pdo->lastInsertId());
            }
            $comando->execute();
            $pdo = null;
            return true;
        } catch (Exception $ex) {
            $pdo = null;
            return false;
        }
    }

    public function excluir($id){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("DELETE FROM estado WHERE id = :id");
            $comando->bindValue(":id", $id);
            $comando->execute();
            $pdo = null;
            return true;
        } catch (Exception $ex) {
            $pdo = null;
            return false;
        }
    }

    public function localizarId($id){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM estado WHERE id = :id");
            $comando->bindValue(":id", $id);
            $comando->execute();
            $estado = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $estado = new Estado($linha["id"], $linha["nome"], $linha["uf"], $linha["pais"]);
            }
            $pdo = null;
            return $estado;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM estado");
            $comando->execute();
            $estado = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $estado[] = new Estado($linha["id"], $linha["nome"], $linha["uf"], $linha["pais"]);
                }
            }
            $pdo = null;
            return $estado;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}