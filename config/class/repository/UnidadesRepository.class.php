<?php
require_once '../config/conexao.php';

class UnidadesRepository {
    public function gravar($unidades) {
        try {
            $pdo = ConexaoDB();
            if($unidades->getId() > 0) {
            $comando = $pdo->prepare("UPDATE unidades SET uni_nome = :uni_nome, uni_endereco = :uni_endereco, uni_numero = :uni_numero, uni_bairro = :uni_bairro, uni_cidade = :uni_cidade, uni_tipo = :uni_tipo WHERE uni_id = :uni_id");
            $comando->bindValue(":uni_id", $unidades->getId());
            }else {
                $comando = $pdo->prepare("INSERT INTO unidades (uni_nome, uni_endereco, uni_numero, uni_bairro, uni_cidade, uni_tipo) VALUES (:uni_nome, :uni_endereco, :uni_numero, :uni_bairro, :uni_cidade, :uni_tipo)");
            }
            $comando->bindValue(":uni_nome", $unidades->getNome());
            $comando->bindValue(":uni_endereco", $unidades->getEndereco());
            $comando->bindValue(":uni_numero", $unidades->getNumero());
            $comando->bindValue(":uni_bairro", $unidades->getBairro());
            $comando->bindValue(":uni_cidade", $unidades->getCidade());
            $comando->bindValue(":uni_tipo", $unidades->getTipo());
            if ($unidades->getId() == 0) {
                $unidades->setId($pdo->lastInsertId());
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
            $comando = $pdo->prepare("DELETE FROM unidades WHERE uni_id = :uni_id");
            $comando->bindValue(":uni_id", $id);
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
            $comando = $pdo->prepare("SELECT * FROM unidades WHERE uni_id = :uni_id");
            $comando->bindValue(":uni_id", $id);
            $comando->execute();
            $unidades = null;
            if($linha = $comando->fetch(PDO::FETCH_ASSOC)){
                $unidades = new Unidades($linha["uni_id"], $linha["uni_nome"], $linha["uni_endereco"], $linha["uni_numero"], $linha["uni_bairro"], $linha["uni_cidade"], $linha["uni_tipo"]);
            }
            $pdo = null;
            return $unidades;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }
    
    public function listar(){
        try{
            $pdo = ConexaoDB();
            $comando = $pdo->prepare("SELECT * FROM unidades");
            $comando->execute();
            $unidades = [];
            if($busca = $comando->fetchAll()){
                foreach ($busca as $linha){
                    $unidades[] = new Unidades($linha["uni_id"], $linha["uni_nome"], $linha["uni_endereco"], $linha["uni_numero"], $linha["uni_bairro"], $linha["uni_cidade"], $linha["uni_tipo"]);
                }
            }
            $pdo = null;
            return $unidades;
        } catch (Exception $ex) {
            $pdo = null;
            return null;
        }
    }

}