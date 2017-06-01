<?php
require_once '../config/conexao.php';

class MotoristasRepository {
    public function gravar($motoristas) {
        try {
            $pdo = ConexaoDB();
            if($motoristas->getId() > 0) {
            $comando = $pdo->prepare("UPDATE motoristas SET mot_nome = :mot_nome, mot_numhabilitacao = :mot_numhabilitacao WHERE mot_id = :mot_id");
            $comando->bindValue(":mot_id", $motoristas->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO motoristas (mot_nome, mot_numhabilitacao) VALUES (:mot_nome, :mot_numhabilitacao)");
            }
            $comando->bindValue(":mot_nome", $motoristas->getNome());
            $comando->bindValue(":mot_numhabilitacao", $motoristas->getNumhabilitacao());
            if ($motoristas->getId() == 0) {
                $motoristas->setId($pdo->lastInsertId());
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
            $comando = $pdo->prepare("DELETE FROM motoristas WHERE mot_id = :mot_id");
            $comando->bindValue(":mot_id", $id);
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
            $comando = $pdo->prepare("SELECT * FROM motoristas WHERE mot_id = :mot_id");
            $comando->bindValue(":mot_id", $id);
            $comando->execute();
            $motoristas = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $motoristas = new Motoristas($linha["mot_id"], $linha["mot_nome"], $linha["mot_numhabilitacao"]);
            }
            $pdo = null;
            return $motoristas;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM motoristas");
            $comando->execute();
            $motoristas = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $motoristas[] = new Motoristas($linha["mot_id"], $linha["mot_nome"], $linha["mot_numhabilitacao"]);
                }
            }
            $pdo = null;
            return $motoristas;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listarLivre(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM motoristas M WHERE NOT EXISTS (SELECT null FROM romaneios R WHERE R.rom_idmotorista = M.mot_id AND R.rom_dtdestino = 0)");
            $comando->execute();
            $motoristas = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $motoristas[] = new Motoristas($linha["mot_id"], $linha["mot_nome"], $linha["mot_numhabilitacao"]);
                }
            }
            $pdo = null;
            return $motoristas;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}