<?php
require_once '../config/conexao.php';

class CidadeRepository {
    public function gravar($cidade) {
        try {
            $pdo = ConexaoDB();
            if($cidade->getId() > 0) {
            $comando = $pdo->prepare("UPDATE cidade SET nome = :nome, estado = :estado WHERE id = :id");
            $comando->bindValue(":id", $cidade->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO cidade (nome, estado) VALUES (:nome, :estado)");
            }
            $comando->bindValue(":nome", $cidade->getNome());
            $comando->bindValue(":estado", $cidade->getEstado());
            if ($cidade->getId() == 0) {
                $cidade->setId($pdo->lastInsertId());
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
            $comando = $pdo->prepare("DELETE FROM cidade WHERE id = :id");
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
            $comando = $pdo->prepare("SELECT * FROM cidade WHERE id = :id");
            $comando->bindValue(":id", $id);
            $comando->execute();
            $cidade = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $cidade = new Cidade($linha["id"], $linha["nome"], $linha["estado"]);
            }
            $pdo = null;
            return $cidade;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM cidade");
            $comando->execute();
            $cidade = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $cidade[] = new Cidade($linha["id"], $linha["nome"], $linha["estado"]);
                }
            }
            $pdo = null;
            return $cidade;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listarPorEstado($estado){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM cidade WHERE estado = :estado");
            $comando->bindValue(':estado', $estado);
            $comando->execute();
            $cidade = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $cidade[] = array("id" => $linha["id"],"nome" => $linha["nome"], "estado" => $linha["estado"]);
                }
            }
            $pdo = null;
            return $cidade;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}