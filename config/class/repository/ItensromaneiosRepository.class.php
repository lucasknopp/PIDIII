<?php
require_once '../config/conexao.php';

class ItensromaneiosRepository {
    public function gravar($itensromaneios) {
        try {
            $pdo = ConexaoDB();
            if($itensromaneios->getId() > 0) {
            $comando = $pdo->prepare("UPDATE itensromaneios SET itr_idromaneio = :itr_idromaneio, itr_idencomenda = :itr_idencomenda WHERE itr_id = :itr_id");
            $comando->bindValue(":itr_id", $itensromaneios->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO itensromaneios (itr_idromaneio, itr_idencomenda) VALUES (:itr_idromaneio, :itr_idencomenda)");
            }
            $comando->bindValue(":itr_idromaneio", $itensromaneios->getIdromaneio());
            $comando->bindValue(":itr_idencomenda", $itensromaneios->getIdencomenda());
            if ($itensromaneios->getId() == 0) {
                $itensromaneios->setId($pdo->lastInsertId());
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
            $comando = $pdo->prepare("DELETE FROM itensromaneios WHERE itr_id = :itr_id");
            $comando->bindValue(":itr_id", $id);
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
            $comando = $pdo->prepare("SELECT * FROM itensromaneios WHERE itr_id = :itr_id");
            $comando->bindValue(":itr_id", $id);
            $comando->execute();
            $itensromaneios = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $itensromaneios = new Itensromaneios($linha["itr_id"], $linha["itr_idromaneio"], $linha["itr_idencomenda"]);
            }
            $pdo = null;
            return $itensromaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM itensromaneios");
            $comando->execute();
            $itensromaneios = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $itensromaneios[] = new Itensromaneios($linha["itr_id"], $linha["itr_idromaneio"], $linha["itr_idencomenda"]);
                }
            }
            $pdo = null;
            return $itensromaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}