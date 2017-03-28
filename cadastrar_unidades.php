<?php
require 'config/conexao.php';
require 'config/funcoes.php';
$pdo = Conexao();
$ok = "";

$select_estados = $pdo->prepare("SELECT id, nome FROM estado ORDER BY nome");
$select_estados->execute();
$linha_estados = $select_estados->fetchAll();

$values = array("uni_nome" => "", "uni_endereco" => "", "uni_numero" => "", "uni_bairro" => "", "uni_estado" => "", "uni_tipo" => "", "uni_cidade" => "");
if (isset($_POST['cadastrar_unidade'])) {
    $values = ValidaPOST($values);
    if($values['uni_cidade'] != "erro"){
        $RestauraCITY = $values['uni_cidade'];
    }else {
        $RestauraCITY = -1;
    }
    if (VerificaArray($values)) {
        $inserir_unidades = $pdo->prepare("INSERT INTO unidades (uni_nome, uni_endereco, uni_numero, uni_bairro, uni_cidade, uni_tipo) VALUES (:uni_nome, :uni_endereco, :uni_numero, :uni_bairro, :uni_cidade, :uni_tipo)");
        $parametros = array(":uni_nome" => $values['uni_nome'], ":uni_endereco" => $values['uni_endereco'], ":uni_numero" => $values['uni_numero'], ":uni_bairro" => $values['uni_bairro'], ":uni_cidade" => $values['uni_cidade'], ":uni_tipo" => $values['uni_tipo']);
        $inserir_unidades->execute($parametros);
        $ok = "ok";
    }
}

include 'tema/cabecalho.php';
?>

<h1 class="TituloPagina">Cadastro de Unidades</h1>

<form class="FormCadastro" action="cadastrar_unidades.php" method="post">
    <section class="Item">
        <label>Nome da Unidade</label>
        <input type="text" name="uni_nome" placeholder="Digite nome da unidade..." value="<?php MantemValor($values['uni_nome']); ?>" />
        <?php ExibeErro($values['uni_nome'], "Preencha o nome."); ?>
    </section>
    <section class="Item">
        <label>Endereço</label>
        <input type="text" name="uni_endereco" placeholder="Digite o endereço..." value="<?php MantemValor($values['uni_endereco']); ?>" />
        <?php ExibeErro($values['uni_endereco'], "Preencha o endereço."); ?>
    </section>
    <section class="Item">
        <label>Número</label>
        <input type="text" name="uni_numero" placeholder="Digite um número..." value="<?php MantemValor($values['uni_numero']); ?>" />
        <?php ExibeErro($values['uni_numero'], "Preencha o número."); ?>
    </section>
    <section class="Item">
        <label>Bairro</label>
        <input type="text" name="uni_bairro" placeholder="Digite um bairro..." value="<?php MantemValor($values['uni_bairro']); ?>" />
        <?php ExibeErro($values['uni_bairro'], "Preencha o bairro."); ?>
    </section>
    <section class="Item">
        <label>Selecione um estado</label>
        <select id="SelecionarEstado" name="uni_estado">
            <option value=""></option>
            <?php
            foreach ($linha_estados as $value) {
                if ($values['uni_estado'] == $value['id']) {
                    echo '<option selected="" value="' . $value['id'] . '">' . $value['nome'] . '</option>';
                } else {
                    echo '<option value="' . $value['id'] . '">' . $value['nome'] . '</option>';
                }
            }
            ?>
        </select>
        <?php ExibeErro($values['uni_estado'], "Selecione um estado."); ?>
    </section>
    <section class="Item">
        <label>Selecione uma cidade</label>
        <select id="SelecionarCidade" name="uni_cidade">
            <option value="">Escolha um estado...</option>
        </select>
        <section class="Carregando">carregando cidades...</section>
        <?php ExibeErro($values['uni_cidade'], "Selecione uma cidade."); ?>
    </section>
    <section class="Item">
        <label>Tipo</label>
        <select name="uni_tipo">
            <option value="1" <?= ($values['uni_tipo'] == "1" ? "selected=\"\"" : "" ) ?>>Filial</option>
            <option value="2" <?= ($values['uni_tipo'] == "2" ? "selected=\"\"" : "" ) ?>>Matriz</option>
        </select>
        <?php ExibeErro($values['uni_tipo'], "Selecione o tipo."); ?>
    </section>
    <section class="Item">
        <button type="submit" name="cadastrar_unidade">Cadastrar unidade</button>
    </section>
</form>

<script>
    $(function () {
<?= ($values['uni_cidade'] != "" ? "AjaxCidades($('#SelecionarEstado'),  " .$RestauraCITY. ");\n" : "" ) ?>
        $('#SelecionarEstado').change(function () {
            AjaxCidades(this, -1);
        });
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
