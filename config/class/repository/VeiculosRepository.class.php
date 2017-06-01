<?php
require_once '../config/conexao.php';

class VeiculosRepository {
    public function gravar($veiculos) {
        try {
            $pdo = ConexaoDB();
            if($veiculos->getId() > 0) {
            $comando = $pdo->prepare("UPDATE veiculos SET vei_numplaca = :vei_numplaca WHERE vei_id = :vei_id");
            $comando->bindValue(":vei_id", $veiculos->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO veiculos (vei_numplaca) VALUES (:vei_numplaca)");
            }
            $comando->bindValue(":vei_numplaca", $veiculos->getNumplaca());
            if ($veiculos->getId() == 0) {
                $veiculos->setId($pdo->lastInsertId());
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
            $comando = $pdo->prepare("DELETE FROM veiculos WHERE vei_id = :vei_id");
            $comando->bindValue(":vei_id", $id);
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
            $comando = $pdo->prepare("SELECT * FROM veiculos WHERE vei_id = :vei_id");
            $comando->bindValue(":vei_id", $id);
            $comando->execute();
            $veiculos = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $veiculos = new Veiculos($linha["vei_id"], $linha["vei_numplaca"]);
            }
            $pdo = null;
            return $veiculos;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM veiculos");
            $comando->execute();
            $veiculos = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $veiculos[] = new Veiculos($linha["vei_id"], $linha["vei_numplaca"]);
                }
            }
            $pdo = null;
            return $veiculos;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listarLivre(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM veiculos V WHERE NOT EXISTS (SELECT null FROM romaneios R WHERE R.rom_idcaminhao = V.vei_id AND R.rom_dtdestino = 0)");
            $comando->execute();
            $veiculos = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $veiculos[] = new Veiculos($linha["vei_id"], $linha["vei_numplaca"]);
                }
            }
            $pdo = null;
            return $veiculos;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
        
        
    }

}