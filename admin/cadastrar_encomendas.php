<?php
include 'tema/cabecalho.php';
require '../config/conexao.php';
require '../config/funcoes.php';

$pdo = Conexao();

$select_unidades = $pdo->prepare("SELECT uni_id, uni_nome FROM unidades ORDER BY uni_nome");
$select_unidades->execute();
$linha_unidades = $select_unidades->fetchAll();

$select_cidades = $pdo->prepare("SELECT id, nome FROM cidade ORDER BY nome");
$select_cidades->execute();
$linha_cidades = $select_cidades->fetchAll();

$select_estados = $pdo->prepare("SELECT id, nome FROM estado ORDER BY nome");
$select_estados->execute();
$linha_estados = $select_estados->fetchAll();

$ok = "";
$RestauraCITY = -1;
$RestauraUSER = -1;
$values = array("enc_cod_unidade" => "", "enc_estado" => "", "cli_cod" => "", "enc_destin_nome" => "", "enc_end_destino" => "", "enc_numend_destino" => "", "enc_bairro_destino" => "", "enc_cid_destino" => "", "enc_cep_destino" => "", "busca_nome" => "");

if (isset($_POST['CadastrarEncomenda'])) {
    $values = ValidaPOST($values);
    if ($values['cli_cod'] != "erro") {
        $RestauraUSER = $values['cli_cod'];
    } else {
        $RestauraUSER = -1;
    }
    if ($values['enc_cid_destino'] != "erro") {
        $RestauraCITY = $values['enc_cid_destino'];
    } else {
        $RestauraCITY = -1;
    }
    if (VerificaArray($values)) {
        $inserir_encomendas = $pdo->prepare("INSERT INTO encomendas (enc_cod_cliente, enc_destin_nome, enc_cid_destino, enc_end_destino, enc_numend_destino, enc_cod_unidade, enc_data, enc_bairro_destino, enc_cep_destino) VALUES (:enc_cod_cliente, :enc_destin_nome, :enc_cid_destino, :enc_end_destino, :enc_numend_destino, :enc_cod_unidade, :enc_data, :enc_bairro_destino, :enc_cep_destino)");
        $parametros[':enc_cod_cliente'] = $values['cli_cod'];
        $parametros[':enc_destin_nome'] = $values['enc_destin_nome'];
        $parametros[':enc_cid_destino'] = $values['enc_cid_destino'];
        $parametros[':enc_end_destino'] = $values['enc_end_destino'];
        $parametros[':enc_numend_destino'] = $values['enc_numend_destino'];
        $parametros[':enc_cod_unidade'] = $values['enc_cod_unidade'];
        $parametros[':enc_cep_destino'] = $values['enc_cep_destino'];
        $parametros[':enc_bairro_destino'] = $values['enc_bairro_destino'];
        $parametros[':enc_data'] = date('c', time());
        if ($inserir_encomendas->execute($parametros)) {
            $values = array("enc_cod_unidade" => "", "enc_estado" => "", "cli_cod" => "", "enc_destin_nome" => "", "enc_end_destino" => "", "enc_numend_destino" => "", "enc_bairro_destino" => "", "enc_cid_destino" => "", "enc_cep_destino" => "", "busca_nome" => "");
            $ok = "ok";
        } else {
            $ok = "falhou";
        }
    }
}

$pdo = null;
?>
<section class="Titulo">Cadastro de encomendas</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Encomenda cadastrada com sucesso!</section>
<?php } else if ($ok == "falhou") { ?>
    <section class="MensagemVermelha">OPS! Ocorreu um erro ao cadastrar a encomenda!</section>
<?php } ?>

<form action="cadastrar_encomendas.php" method="post" class="FormPadrao">
    <section class="ItemForms">
        <label>Buscar cliente</label>
        <input type="search" class="BuscaCliente" name="busca_nome" placeholder="Digite o nome do cliente..." value="<?php MantemValor($values['busca_nome']); ?>" />
        <?php ExibeErro($values['busca_nome'], "Preencha a busca corretamente!"); ?>
    </section>

    <section class="Oculto" style="display: none;">
        <section class="Item"><label>Escolha o cliente:</label></section>
        <section class="ExibeClientes">

        </section>
        <section class="Carregando">carregando clientes...</section>
        <?php ExibeErro($values['cli_cod'], "Selecione um cliente!"); ?>
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
            <button type="submit" name="CadastrarEncomenda" >Cadastrar encomenda</button>
        </section>
    </section>
</form>

<script>
    $(function () {
        $('.BuscaCliente').keyup(function () {
            AjaxClientes(this, -1);
        });
        $('#SelecionarEstado').change(function () {
            AjaxCidades(this, -1);
        });
    });

    $(document).ready(function () {
<?= ($values['busca_nome'] != "" ? "AjaxClientes($('.BuscaCliente'),  " . $RestauraUSER . ");\n" : "" ) ?>
<?= ($values['enc_cid_destino'] != "" ? "AjaxCidades($('#SelecionarEstado'),  " . $RestauraCITY . ");\n" : "" ) ?>
    });

    function AjaxClientes(nomeUser, UserCOD) {
        if ($(nomeUser).val()) {
            $('.ExibeClientes').hide();
            $('.Carregando').show();
            $.getJSON('clientes.ajax.php?search=', {nome_user: $(nomeUser).val(), ajax: 'true'}, function (j) {
                var options = '';
                for (var i = 0; i < j.length; i++) {
                    if (UserCOD == j[i].cod_cliente) {
                        options += '<section class="itemUser"><input checked="" type="radio" name="cli_cod" id="cli_' + j[i].nome + '" value="' + j[i].cod_cliente + '"/><label for="cli_' + j[i].nome + '">' + j[i].nome + ' - ' + j[i].cpf + '</label></section>';
                    } else {
                        options += '<section class="itemUser"><input type="radio" name="cli_cod" id="cli_' + j[i].nome + '" value="' + j[i].cod_cliente + '"/><label for="cli_' + j[i].nome + '">' + j[i].nome + ' - ' + j[i].cpf + '</label></section>';
                    }
                }
                if (i > 0) {
                    $('.Oculto').show();
                } else {
                    $('.Oculto').hide();
                }
                $('.ExibeClientes').html(options).show();
                $('.Carregando').hide();
            });
        } else {
            $('.Oculto').hide();
            $('.ExibeClientes').html('<span>Pesquise o nome do cliente!</span>');
        }
    }

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
