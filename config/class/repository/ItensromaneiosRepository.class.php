<?php

require_once '../config/conexao.php';

class ItensromaneiosRepository {

    public function gravar($itensromaneios) {
        try {
            $pdo = ConexaoDB();
            if ($itensromaneios->getId() > 0) {
                $comando = $pdo->prepare("UPDATE itensromaneios SET itr_idromaneio = :itr_idromaneio, itr_idencomenda = :itr_idencomenda WHERE itr_id = :itr_id");
                $comando->bindValue(":itr_id", $itensromaneios->getId());
            } else {
                $comando = $pdo->prepare("UPDATE encomendas SET enc_controleromaneio = 1 WHERE enc_id = :itr_idencomenda");
                $comando->bindValue(":itr_idencomenda", $itensromaneios->getIdencomenda());
                $comando->execute();
                $comando = $pdo->prepare("INSERT INTO itensromaneios (itr_idromaneio, itr_idencomenda) VALUES (:itr_idromaneio, :itr_idencomenda)");
            }
            $comando->bindValue(":itr_idromaneio", $itensromaneios->getIdromaneio());
            $comando->bindValue(":itr_idencomenda", $itensromaneios->getIdencomenda());
            $comando->execute();
            if ($itensromaneios->getId() == 0) {
                $itensromaneios->setId($pdo->lastInsertId());
            }
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
            $comando = $pdo->prepare("DELETE FROM itensromaneios WHERE itr_idencomenda = :itr_id");
            $comando->bindValue(":itr_id", $id);
            $comando->execute();
            $comando = $pdo->prepare("UPDATE encomendas SET enc_controleromaneio = 0 WHERE enc_id = :itr_idencomenda");
            $comando->bindValue(":itr_idencomenda", $id);
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
            $comando = $pdo->prepare("SELECT * FROM itensromaneios WHERE itr_id = :itr_id");
            $comando->bindValue(":itr_id", $id);
            $comando->execute();
            $itensromaneios = null;
            if ($linha = $comando->fetch(PDO::FETCH_ASSOC)) {
                $itensromaneios = new Itensromaneios($linha["itr_id"], $linha["itr_idromaneio"], $linha["itr_idencomenda"]);
            }
            $pdo = null;
            return $itensromaneios;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

    public function listar($idromaneio) {
        try {
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM itensromaneios WHERE itr_idromaneio = :rom_id");
            $comando->bindValue(':rom_id', $idromaneio);
            $comando->execute();
            $itensromaneios = [];
            if ($busca = $comando->fetchAll()) {
                foreach ($busca as $linha) {
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
