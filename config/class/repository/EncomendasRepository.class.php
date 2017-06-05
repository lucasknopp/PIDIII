<?php

require_once '../config/conexao.php';

class EncomendasRepository {

    public function gravar($encomendas) {
        try {
            $pdo = ConexaoDB();
            if ($encomendas->getId() > 0) {
                $comando = $pdo->prepare("UPDATE encomendas SET enc_destin_nome = :enc_destin_nome, enc_cid_destino = :enc_cid_destino, enc_end_destino = :enc_end_destino, enc_numend_destino = :enc_numend_destino, enc_cod_unidade = :enc_cod_unidade, enc_data = :enc_data, enc_bairro_destino = :enc_bairro_destino, enc_cep_destino = :enc_cep_destino, enc_codrastreio = :enc_codrastreio, enc_controleromaneio = :enc_controleromaneio WHERE enc_id = :enc_id");
                $comando->bindValue(":enc_id", $encomendas->getId());
            } else {
                $comando = $pdo->prepare("INSERT INTO encomendas (enc_cod_cliente, enc_destin_nome, enc_cid_destino, enc_end_destino, enc_numend_destino, enc_cod_unidade, enc_data, enc_bairro_destino, enc_cep_destino, enc_codrastreio, enc_controleromaneio) VALUES (:enc_cod_cliente, :enc_destin_nome, :enc_cid_destino, :enc_end_destino, :enc_numend_destino, :enc_cod_unidade, :enc_data, :enc_bairro_destino, :enc_cep_destino, :enc_codrastreio, :enc_controleromaneio)");
                $comando->bindValue(":enc_cod_cliente", $encomendas->getCod_cliente());
            }
            $comando->bindValue(":enc_destin_nome", $encomendas->getDestin_nome());
            $comando->bindValue(":enc_cid_destino", $encomendas->getCid_destino());
            $comando->bindValue(":enc_end_destino", $encomendas->getEnd_destino());
            $comando->bindValue(":enc_numend_destino", $encomendas->getNumend_destino());
            $comando->bindValue(":enc_cod_unidade", $encomendas->getCod_unidade());
            $comando->bindValue(":enc_data", $encomendas->getData());
            $comando->bindValue(":enc_bairro_destino", $encomendas->getBairro_destino());
            $comando->bindValue(":enc_cep_destino", $encomendas->getCep_destino());
            $comando->bindValue(":enc_codrastreio", $encomendas->getCodrastreio());
            $comando->bindValue(":enc_controleromaneio", $encomendas->getControleromaneio());
            $comando->execute();
            if ($encomendas->getId() == 0) {
                $encomendas->setId($pdo->lastInsertId());
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
            $comando = $pdo->prepare("DELETE FROM encomendas WHERE enc_id = :enc_id");
            $comando->bindValue(":enc_id", $id);
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
            $comando = $pdo->prepare("SELECT * FROM encomendas INNER JOIN clientes ON clientes.cli_id = encomendas.enc_cod_cliente WHERE enc_id = :enc_id");
            $comando->bindValue(":enc_id", $id);
            $comando->execute();
            $encomendas = null;
            if ($linha = $comando->fetch(PDO::FETCH_ASSOC)) {
                $encomendas = new Encomendas($linha["enc_id"], $linha["cli_nome"], $linha["enc_destin_nome"], $linha["enc_cid_destino"], $linha["enc_end_destino"], $linha["enc_numend_destino"], $linha["enc_cod_unidade"], $linha["enc_data"], $linha["enc_bairro_destino"], $linha["enc_cep_destino"], $linha["enc_codrastreio"], $linha["enc_controleromaneio"]);
            }
            $pdo = null;
            return $encomendas;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

    public function listar($status = "") {
        try {
            $pdo = ConexaoDB();
            if ($status == "") {
                $comando = $pdo->prepare("SELECT * FROM encomendas ORDER BY enc_id DESC");
            } else if ($status == 0) {
                $comando = $pdo->prepare("SELECT * FROM encomendas WHERE enc_controleromaneio = :enc_controleromaneio");
                $comando->bindValue(':enc_controleromaneio', $status);
            } else {
                $comando = $pdo->prepare("SELECT E.*, C.nome as NOMECIDADE FROM encomendas E LEFT JOIN itensromaneios I ON E.enc_id = I.itr_idencomenda INNER JOIN cidade C ON E.enc_cid_destino = C.id WHERE I.itr_idromaneio = :rom_id OR E.enc_controleromaneio = 0");
                $comando->bindValue(':rom_id', $status);
            }
            $comando->execute();
            $encomendas = [];
            if ($busca = $comando->fetchAll()) {
                foreach ($busca as $linha) {
                    if ($status > 0) {
                        $encomendas[] = new Encomendas($linha["enc_id"], $linha["enc_cod_cliente"], $linha["enc_destin_nome"], $linha["NOMECIDADE"], $linha["enc_end_destino"], $linha["enc_numend_destino"], $linha["enc_cod_unidade"], $linha["enc_data"], $linha["enc_bairro_destino"], $linha["enc_cep_destino"], $linha["enc_codrastreio"], $linha["enc_controleromaneio"]);
                    } else {
                        $encomendas[] = new Encomendas($linha["enc_id"], $linha["enc_cod_cliente"], $linha["enc_destin_nome"], $linha["enc_cid_destino"], $linha["enc_end_destino"], $linha["enc_numend_destino"], $linha["enc_cod_unidade"], $linha["enc_data"], $linha["enc_bairro_destino"], $linha["enc_cep_destino"], $linha["enc_codrastreio"], $linha["enc_controleromaneio"]);
                    }
                }
            }
            $pdo = null;
            return $encomendas;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }


}
