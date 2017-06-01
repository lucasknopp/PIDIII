<?php
require_once '../config/conexao.php';
require_once '../config/class/Cidade.class.php';

class RomaneiosRepository {
    public function gravar($romaneios) {
        try {
            $pdo = ConexaoDB();
            if($romaneios->getId() > 0) {
            $comando = $pdo->prepare("UPDATE romaneios SET rom_idorigem = :rom_idorigem, rom_dtorigem = :rom_dtorigem, rom_iddestino = :rom_iddestino, rom_dtdestino = :rom_dtdestino, rom_idmotorista = :rom_idmotorista, rom_idcaminhao = :rom_idcaminhao WHERE rom_id = :rom_id");
            $comando->bindValue(":rom_id", $romaneios->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO romaneios (rom_idorigem, rom_dtorigem, rom_iddestino, rom_dtdestino, rom_idmotorista, rom_idcaminhao) VALUES (:rom_idorigem, :rom_dtorigem, :rom_iddestino, :rom_dtdestino, :rom_idmotorista, :rom_idcaminhao)");
            }
            $comando->bindValue(":rom_idorigem", $romaneios->getIdorigem());
            $comando->bindValue(":rom_dtorigem", $romaneios->getDtorigem());
            $comando->bindValue(":rom_iddestino", $romaneios->getIddestino());
            $comando->bindValue(":rom_dtdestino", $romaneios->getDtdestino());
            $comando->bindValue(":rom_idmotorista", $romaneios->getIdmotorista());
            $comando->bindValue(":rom_idcaminhao", $romaneios->getIdcaminhao());
            $comando->execute();
            if ($romaneios->getId() == 0) {
                $romaneios->setId($pdo->lastInsertId());
            }
            $pdo = null;
            return $romaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

    public function excluir($id){
        try{
            $pdo = ConexaoDB();
            $comandoAtualiza = $pdo->prepare("UPDATE encomendas INNER JOIN itensromaneios ON encomendas.enc_id = itensromaneios.itr_idencomenda SET enc_controleromaneio = 0 WHERE itensromaneios.itr_idromaneio = :rom_id");
            $comandoAtualiza->bindValue(":rom_id", $id);
            $comandoAtualiza->execute();
            $comandoItem = $pdo->prepare("DELETE itensromaneios FROM itensromaneios INNER JOIN romaneios WHERE itensromaneios.itr_idromaneio = romaneios.rom_id AND itensromaneios.itr_idromaneio = :rom_id");
            $comandoItem->bindValue(":rom_id", $id);
            $comandoItem->execute();
            $comandoRom = $pdo->prepare("DELETE FROM romaneios WHERE rom_id = :rom_id");
            $comandoRom->bindValue(":rom_id", $id);
            $comandoRom->execute();
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
            $comando = $pdo->prepare("SELECT * FROM romaneios WHERE rom_id = :rom_id");
            $comando->bindValue(":rom_id", $id);
            $comando->execute();
            $romaneios = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $romaneios = new Romaneios($linha["rom_id"], $linha["rom_idorigem"], $linha["rom_dtorigem"], $linha["rom_iddestino"], $linha["rom_dtdestino"], $linha["rom_idmotorista"], $linha["rom_idcaminhao"]);
            }
            $pdo = null;
            return $romaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM romaneios");
            $comando->execute();
            $romaneios = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $romaneios[] = new Romaneios($linha["rom_id"], $linha["rom_idorigem"], $linha["rom_dtorigem"], $linha["rom_iddestino"], $linha["rom_dtdestino"], $linha["rom_idmotorista"], $linha["rom_idcaminhao"]);
                }
            }
            $pdo = null;
            return $romaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listarInner(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT R.*, U1.uni_nome AS CID1, U2.uni_nome AS CID2 FROM romaneios R INNER JOIN unidades U1 ON R.rom_idorigem = U1.uni_id INNER JOIN unidades U2 ON R.rom_iddestino = U2.uni_id");
            $comando->execute();
            $romaneios = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $romaneios[] = new Romaneios($linha["rom_id"], $linha["CID1"], $linha["rom_dtorigem"], $linha["CID2"], $linha["rom_dtdestino"], $linha["rom_idmotorista"], $linha["rom_idcaminhao"]);
                }
            }
            $pdo = null;
            return $romaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listarViagem(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT R.*, U1.uni_nome AS CID1, U2.uni_nome AS CID2 FROM romaneios R INNER JOIN unidades U1 ON R.rom_idorigem = U1.uni_id INNER JOIN unidades U2 ON R.rom_iddestino = U2.uni_id WHERE R.rom_dtdestino = 0 AND R.rom_dtorigem < :data_atual");
            $comando->bindValue(':data_atual', date("d/m/Y H:i"));
            $comando->execute();
            $romaneios = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $romaneios[] = new Romaneios($linha["rom_id"], $linha["CID1"], $linha["rom_dtorigem"], $linha["CID2"], $linha["rom_dtdestino"], $linha["rom_idmotorista"], $linha["rom_idcaminhao"]);
                }
            }
            $pdo = null;
            return $romaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}