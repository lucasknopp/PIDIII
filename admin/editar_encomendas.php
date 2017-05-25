<?php
include 'tema/cabecalho.php';
require '../config/conexao.php';
require '../config/funcoes.php';

$pdo = Conexao();

$select_unidades = $pdo->prepare("SELECT uni_id, uni_nome FROM unidades ORDER BY uni_nome");
$select_unidades->execute();
$linha_unidades = $select_unidades->fetchAll();

$select_estados = $pdo->prepare("SELECT id, nome FROM estado ORDER BY nome");
$select_estados->execute();
$linha_estados = $select_estados->fetchAll();

$ok = "";
$RestauraCITY = -1;
$RestauraUSER = -1;
$values = array("enc_estado" => "", "cli_cod" => "", "enc_destin_nome" => "", "enc_end_destino" => "", "enc_numend_destino" => "", "enc_bairro_destino" => "", "enc_cid_destino" => "", "enc_cep_destino" => "");

if (isset($_GET['id'])) {
    $idEnc = $_GET['id'];
    $select_encomendas = $pdo->prepare("SELECT enc_cod_cliente, enc_destin_nome, enc_cid_destino, enc_end_destino, enc_numend_destino, enc_cod_unidade, enc_cep_destino, enc_bairro_destino, enc_data FROM encomendas WHERE enc_id = :id");
    $EncParametros[':id'] = $idEnc;
    $select_encomendas->execute($EncParametros);
    $linhaenc = $select_encomendas->fetchAll();
    $values['enc_cod_cliente'] = $linhaenc[0]['enc_cod_cliente'];
    $values['enc_cid_destino'] = $linhaenc[0]['enc_cid_destino'];
    $values['enc_end_destino'] = $linhaenc[0]['enc_end_destino'];
    $values['enc_cod_unidade'] = $linhaenc[0]['enc_cod_unidade'];
    $values['enc_destin_nome'] = $linhaenc[0]['enc_destin_nome'];
    $values['enc_numend_destino'] = $linhaenc[0]['enc_numend_destino'];
    $values['enc_bairro_destino'] = $linhaenc[0]['enc_bairro_destino'];
    $values['enc_cid_destino'] = $linhaenc[0]['enc_cid_destino'];
    $values['enc_cep_destino'] = $linhaenc[0]['enc_cep_destino'];

    $select_clientes = $pdo->prepare("SELECT cli_nome FROM clientes WHERE cli_id = :id");
    $parCli[":id"] = $values['enc_cod_cliente'];
    $select_clientes->execute($parCli);
    $linhacli = $select_clientes->fetchAll();
    $nomeCLiente = $linhacli[0]["cli_nome"];

    $select_cidades = $pdo->prepare("SELECT estado FROM cidade WHERE id = :id");
    $parCidSEL[':id'] = $linhaenc[0]['enc_cid_destino'];
    $select_cidades->execute($parCidSEL);
    $linha_cidades = $select_cidades->fetchAll();
    $values['enc_estado'] = $linha_cidades[0]['estado'];
    
    if ($values['enc_cid_destino'] != "erro") {
        $RestauraCITY = $values['enc_cid_destino'];
    } else {
        $RestauraCITY = -1;
    }
}

if (isset($_POST['CadastrarEncomenda'])) {
    $values = ValidaPOST($values);
    if ($values['enc_cid_destino'] != "erro") {
        $RestauraCITY = $values['enc_cid_destino'];
    } else {
        $RestauraCITY = -1;
    }
    $id_update = $_GET['id'];
    $update_encomendas = $pdo->prepare("UPDATE encomendas SET enc_destin_nome = :enc_destin_nome, enc_cid_destino = :enc_cid_destino, enc_end_destino = :enc_end_destino, enc_numend_destino = :enc_numend_destino, enc_cod_unidade = :enc_cod_unidade, enc_cep_destino = :enc_cep_destino, enc_bairro_destino = :enc_bairro_destino WHERE enc_id = :id");
    $paramUpdate = array(':enc_destin_nome' => $values['enc_destin_nome'], ':enc_cid_destino' => $values['enc_cid_destino'], ':enc_end_destino' => $values['enc_end_destino'], ':enc_numend_destino' => $values['enc_numend_destino'], ':enc_cod_unidade' => $values['enc_cod_unidade'], ':enc_cep_destino' => $values['enc_cep_destino'], ':enc_bairro_destino' => $values['enc_bairro_destino'], ':id' => $id_update);
    if($update_encomendas->execute($paramUpdate)){ // JÁ TA ARRUMADO :)
        $ok = "ok";
    }
   
}

$pdo = null;
?>
<section class="Titulo">Editar encomenda</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Encomenda editada com sucesso!</section>
<?php } else if ($ok == "falhou") { ?>
    <section class="MensagemVermelha">OPS! Ocorreu um erro ao editar a encomenda!</section>
<?php } ?>

<form method="post" class="FormPadrao">
    <section class="Item">
        <label>Nome do cliente</label>
        <input type="text" value="<?= $nomeCLiente; ?>" disabled=""/>
    </section>
    <section class="Item">
        <label>Selecione a unidade</label>
        <select name="enc_cod_unidade">
            <option value="">Selecione uma unidade...</option>
            <?php
            foreach ($linha_unidades as $valor) {
                if ($valor['uni_id'] == $values['enc_cod_unidade']) {
                    echo '<option selected="" value="' . $valor['uni_id'] . '">' . $valor['uni_nome'] . '</option>';
                } else {
                    echo '<option value="' . $valor['uni_id'] . '">' . $valor['uni_nome'] . '</option>';
                }
            }
            ?>
        </select>
        <?php ExibeErro($values['enc_cod_unidade'], "Selecione uma unidade!"); ?>
    </section>
    <section class="Item">
        <label>Nome do destinatário</label>
        <input type="text" name="enc_destin_nome" value="<?php MantemValor($values['enc_destin_nome']); ?>" placeholder="Digite o nome do destinatário..."/>
        <?php ExibeErro($values['enc_destin_nome'], "Preencha o nome do destinatário!"); ?>
    </section>
    <section class="Item">
        <label>Endereço</label>
        <input type="text" name="enc_end_destino" value="<?php MantemValor($values['enc_end_destino']); ?>" placeholder="Digite o endereço do destinatário..."/>
        <?php ExibeErro($values['enc_end_destino'], "Preencha o endereço do destinatário!"); ?>
    </section>
    <section class="Item">
        <label>Número</label>
        <input type="text" name="enc_numend_destino" value="<?php MantemValor($values['enc_numend_destino']); ?>" placeholder="Digite o número do destinatário..."/>
        <?php ExibeErro($values['enc_numend_destino'], "Preencha o número do destinatário!"); ?>
    </section>
    <section class="Item">
        <label>Bairro</label>
        <input type="text" name="enc_bairro_destino" value="<?php MantemValor($values['enc_bairro_destino']); ?>" placeholder="Digite o bairro do destinatário..."/>
        <?php ExibeErro($values['enc_bairro_destino'], "Preencha o bairro do destinatário!"); ?>
    </section>
    <section class="Item">
        <label>Selecione um estado</label>
        <select id="SelecionarEstado" name="enc_estado">
            <option value=""></option>
            <?php
            foreach ($linha_estados as $value) {
                if ($values['enc_estado'] == $value['id']) {
                    echo '<option selected="" value="' . $value['id'] . '">' . $value['nome'] . '</option>';
                } else {
                    echo '<option value="' . $value['id'] . '">' . $value['nome'] . '</option>';
                }
            }
            ?>
        </select>
        <?php ExibeErro($values['enc_estado'], "Selecione um estado."); ?>
    </section>
    <section class="Item">
        <label>Selecione uma cidade</label>
        <select id="SelecionarCidade" name="enc_cid_destino">
            <option value="">Escolha um estado...</option>
        </select>
        <section class="Carregando">carregando cidades...</section>
        <?php ExibeErro($values['enc_cid_destino'], "Selecione uma cidade."); ?>
    </section>
    <section class="Item">
        <label>CEP</label>
        <input type="text" name="enc_cep_destino" value="<?php MantemValor($values['enc_cep_destino']); ?>" placeholder="Digite o CEP do destinatário..."/>
        <?php ExibeErro($values['enc_cep_destino'], "Preencha o CEP do destinatário!"); ?>
    </section>
    <section class="Item">
        <button type="submit" name="CadastrarEncomenda" >Editar encomenda</button>
    </section>
</form>

<script>
    $(function () {
        $('#SelecionarEstado').change(function () {
            AjaxCidades(this, -1);
        });
    });

    $(document).ready(function () {
<?= ($values['enc_cid_destino'] != "" ? "AjaxCidades($('#SelecionarEstado'),  " . $RestauraCITY . ");\n" : "" ) ?>
    });

    function AjaxCidades(campoUF, CidCOD) {
        if ($(campoUF).val()) {
            $('#SelecionarCidade').hide();
            $('.Carregando').show();
            $.getJSON('cidades.ajax.php?search=', {cod_estados: $(campoUF).val(), ajax: 'true'}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    if (CidCOD == j[i].cod_cidades) {
                        options += '<option selected="" value="' + j[i].cod_cidades + '">' + j[i].nome + '</option>';
                    } else {
                        options += '<option value="' + j[i].cod_cidades + '">' + j[i].nome + '</option>';
                    }
                }
                $('#SelecionarCidade').html(options).show();
                $('.Carregando').hide();
            });
        } else {
            $('#SelecionarCidade').html('<option value="">Escolha um estado...</option>');
        }
    }
</script>
<?php
include 'tema/rodape.php';
