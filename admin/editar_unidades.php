<?php
include 'tema/cabecalho.php';
require_once '../config/class/Unidades.class.php';
require_once '../config/class/Estado.class.php';
require_once '../config/class/Cidade.class.php';
$urlvoltar = 'listar_unidades.php';

if (isset($_GET['id'])) {
    $ok = "";
    $estado = "";
    $unidades = new Unidades();
    $id = trim($_GET['id']);
    $unidadesRepository = new UnidadesRepository();
    $unidades = $unidadesRepository->localizarId($id);
    if (!empty($unidades)) {
        $cidadeRepository = new CidadeRepository();
        $cidade = $cidadeRepository->localizarId($unidades->getCidade());
        $estado = $cidade->getEstado();
        if (isset($_POST["cadastrar"])) {
            $estado = $_POST['uni_estado'];
            $unidades = new Unidades($id, $_POST["uni_nome"], $_POST["uni_endereco"], $_POST["uni_numero"], $_POST["uni_bairro"], $_POST["uni_cidade"], $_POST["uni_tipo"]);
            $unidades->valida();
            $mensagem = $unidades->getMensagem();
            if (empty($mensagem)) {
                $unidadesRepository->gravar($unidades);
                $unidades = new Unidades();
                $ok = "ok";
            }
        }
    } else {
        header("Location: " . $urlvoltar . "?red=" . "Unidade não existe!");
        exit;
    }
} else {
    header("Location: " . $urlvoltar . "?red=" . "Unidade não existe!");
    exit;
}
?>
<section class="Titulo">Cadastro de Unidades</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Unidades adicionado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Nome da Unidade</label>
        <input type="text" name="uni_nome" value="<?= $unidades->getNome(); ?>" placeholder="Digite o nome..."/>
        <?= (isset($mensagem["uni_nome"]) ? '<section class="Erro">' . $mensagem["uni_nome"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Endereço</label>
        <input type="text" name="uni_endereco" value="<?= $unidades->getEndereco(); ?>" placeholder="Digite o endereço..."/>
        <?= (isset($mensagem["uni_endereco"]) ? '<section class="Erro">' . $mensagem["uni_endereco"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Número</label>
        <input type="text" name="uni_numero" value="<?= $unidades->getNumero(); ?>" placeholder="Digite o número..."/>
        <?= (isset($mensagem["uni_numero"]) ? '<section class="Erro">' . $mensagem["uni_numero"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Bairro</label>
        <input type="text" name="uni_bairro" value="<?= $unidades->getBairro(); ?>" placeholder="Digite o bairro..."/>
        <?= (isset($mensagem["uni_bairro"]) ? '<section class="Erro">' . $mensagem["uni_bairro"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Estado</label>
        <select id="SelecionarEstado" name="uni_estado">
            <option value="">Selecione um estado...</option>
            <?php
            $estadoRepository = new EstadoRepository();
            $estados = $estadoRepository->listar();
            foreach ($estados as $valor) {
                if ($estado == $valor->getId())
                    echo '<option selected value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
                else
                    echo '<option value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
            }
            ?>
        </select>
        <?= (isset($mensagem["uni_cidade"]) ? '<section class="Erro">' . $mensagem["uni_cidade"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Cidade</label>
        <select id="SelecionarCidade" name="uni_cidade">
            <option value="">Primeiro selecione um estado...</option>
        </select>
        <section class="Carregando">carregando cidades...</section>
        <?= (isset($mensagem["uni_cidade"]) ? '<section class="Erro">' . $mensagem["uni_cidade"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Tipo</label>
        <select name="uni_tipo">
            <option <?= $unidades->getTipo() == "1" ? "selected" : "" ?> value="1">Filial</option>
            <option <?= $unidades->getTipo() == "2" ? "selected" : "" ?> value="2">Matriz</option>
        </select>
        <?= (isset($mensagem["uni_tipo"]) ? '<section class="Erro">' . $mensagem["uni_tipo"] . "</section>" : "") ?>
    </section>

    <section class="Item">
        <button type="submit" name="cadastrar">Cadastrar unidades</button>
    </section>
</form>
<script>
    $(document).ready(function () {
<?= ($unidades->getCidade() != "" ? "CarregarCidades($('#SelecionarEstado'),  " . $unidades->getCidade() . ");\n" : "" ) ?>
        $("#SelecionarEstado").change(function () {
            CarregarCidades(this, 0);
        });
    });

    function CarregarCidades(SelEstado, SelCid) {
        var estado = $(SelEstado).val();
        if (estado != "") {
            $("#SelecionarCidade").hide();
            $(".Carregando").show();
            $.getJSON('cidades.ajax.php', {estado: estado}, function (j) {
                var imprime = '<option value="">Selecione uma cidade...</option>';
                for (var i = 0; i < j.length; i++) {
                    if (SelCid == j[i].id)
                        imprime += '<option selected value="' + j[i].id + '">' + j[i].nome + '</option>';
                    else
                        imprime += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
                }
                $(".Carregando").hide();
                $("#SelecionarCidade").html(imprime).show();
            });
        } else {
            var imprime = '<option value="">Primeiro selecione um estado...</option>';
            $("#SelecionarCidade").html(imprime);
        }
    }
</script>
<?php
include 'tema/rodape.php';
