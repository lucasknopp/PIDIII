<?php
include 'tema/cabecalho.php';
require_once '../config/class/Encomendas.class.php';
require_once '../config/class/Unidades.class.php';
require_once '../config/class/Estado.class.php';
require_once '../config/class/Cidade.class.php';
$urlvoltar = "listar_encomendas.php";
$ok = "";
$selEstado = "";
$encomenda = new Encomendas();
$busca = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $encomendasRepository = new EncomendasRepository();
    $encomenda = $encomendasRepository->localizarId($id);
    if (!empty($encomenda)) {
        $cidade = new Cidade();
        $cidadeRepository = new CidadeRepository();
        $cidade = $cidadeRepository->localizarId($encomenda->getCid_destino());
        $selEstado = $cidade->getEstado();
        if (isset($_POST['EditarEncomenda'])) {
            $clicod = $encomenda->getCod_cliente();
            $selEstado = $_POST['enc_estado'];
            $encomenda = new Encomendas(0, $clicod, $_POST['enc_destin_nome'], $_POST['enc_cid_destino'], $_POST['enc_end_destino'], $_POST['enc_numend_destino'], $_POST['enc_cod_unidade'], date("d/m/Y H:i"), $_POST['enc_bairro_destino'], $_POST['enc_cep_destino'], 0, 0);
            $encomenda->valida();
            $mensagem = $encomenda->getMensagem();
            if (empty($mensagem)) {
                $encomendasRepository->gravar($encomenda);
                $encomenda->setCodrastreio(GeraCodEnc($encomenda->getId()));
                $encomendasRepository->gravar($encomenda);
                $ok = "ok";
            }
        }
    } else {
        header("Location: " . $urlvoltar . "?red=" . "Encomenda não existe!");
        exit;
    }
} else {
    header("Location: " . $urlvoltar . "?red=" . "Encomenda não existe!");
    exit;
}
?>
<section class="Titulo">Editar encomenda</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Encomenda alterada com sucesso!</section>
<?php } ?>

<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Nome do cliente</label>
        <input type="text" value="<?= $encomenda->getCod_cliente() ?>" disabled=""/>
    </section>
    <section class="Item">
        <label>Selecione a unidade</label>
        <select name="enc_cod_unidade">
            <option value="">Selecione uma unidade...</option>
            <?php
            $unidades = new Unidades();
            $unidadeRepository = new UnidadesRepository();
            $unidades = $unidadeRepository->listar();
            foreach ($unidades as $valor) {
                if ($valor->getId() == $encomenda->getCod_unidade()) {
                    echo '<option selected="" value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
                } else {
                    echo '<option value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
                }
            }
            ?>
        </select>
        <?= (isset($mensagem["enc_cod_unidade"]) ? '<section class="Erro">' . $mensagem["enc_cod_unidade"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Nome do destinatário</label>
        <input type="text" name="enc_destin_nome" value="<?= $encomenda->getDestin_nome() ?>" placeholder="Digite o nome do destinatário..."/>
        <?= (isset($mensagem["enc_destin_nome"]) ? '<section class="Erro">' . $mensagem["enc_destin_nome"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Endereço</label>
        <input type="text" name="enc_end_destino" value="<?= $encomenda->getEnd_destino() ?>" placeholder="Digite o endereço do destinatário..."/>
        <?= (isset($mensagem["enc_end_destino"]) ? '<section class="Erro">' . $mensagem["enc_end_destino"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Número</label>
        <input type="text" name="enc_numend_destino" value="<?= $encomenda->getNumend_destino() ?>" placeholder="Digite o número do destinatário..."/>
        <?= (isset($mensagem["enc_numend_destino"]) ? '<section class="Erro">' . $mensagem["enc_numend_destino"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Bairro</label>
        <input type="text" name="enc_bairro_destino" value="<?= $encomenda->getBairro_destino() ?>" placeholder="Digite o bairro do destinatário..."/>
        <?= (isset($mensagem["enc_bairro_destino"]) ? '<section class="Erro">' . $mensagem["enc_bairro_destino"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Selecione um estado</label>
        <select id="SelecionarEstado" name="enc_estado">
            <option value="">Selecione um estado...</option>
            <?php
            $estado = new Estado();
            $estadoRepository = new EstadoRepository();
            $estado = $estadoRepository->listar();
            foreach ($estado as $valor) {
                if ($valor->getId() == $selEstado) {
                    echo '<option selected="" value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
                } else {
                    echo '<option value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
                }
            }
            ?>
        </select>
        <?= (isset($mensagem["enc_estado"]) ? '<section class="Erro">' . $mensagem["enc_estado"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Selecione uma cidade</label>
        <select id="SelecionarCidade" name="enc_cid_destino">
            <option value="">Primeiro selecione um estado...</option>
        </select>
        <section class="Carregando">carregando cidades...</section>
        <?= (isset($mensagem["enc_cid_destino"]) ? '<section class="Erro">' . $mensagem["enc_cid_destino"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>CEP</label>
        <input type="text" name="enc_cep_destino" value="<?= $encomenda->getCep_destino() ?>" placeholder="Digite o CEP do destinatário..."/>
        <?= (isset($mensagem["enc_cep_destino"]) ? '<section class="Erro">' . $mensagem["enc_cep_destino"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <button type="submit" name="EditarEncomenda" >Editar encomenda</button>
    </section>
</form>

<script>
    $(function () {
        $('.BuscaCliente').keyup(function () {
            AjaxClientes(this, 0);
        });
        $('#SelecionarEstado').change(function () {
            CarregarCidades(this, 0);
        });
    });

    $(document).ready(function () {
<?= ($busca != "" ? "AjaxClientes($('.BuscaCliente'),  '" . $encomenda->getCod_cliente() . "');\n" : "" ) ?>
<?= ($encomenda->getCid_destino() != "" ? "CarregarCidades($('#SelecionarEstado'),  '" . $encomenda->getCid_destino() . "');\n" : "" ) ?>
    });

    function AjaxClientes(nomeUser, UserCOD) {
        if ($(nomeUser).val()) {
            $('.ExibeClientes').hide();
            $('.Carregando').show();
            $.getJSON('clientes.ajax.php', {nome_user: $(nomeUser).val()}, function (j) {
                var options = '';
                for (var i = 0; i < j.length; i++) {
                    if (UserCOD == j[i].cod_cliente) {
                        options += '<section class="itemUser"><input checked="" type="radio" name="enc_cod_cliente" id="cli_' + j[i].nome + '" value="' + j[i].cod_cliente + '"/><label for="cli_' + j[i].nome + '">' + j[i].nome + ' - ' + j[i].cpf + '</label></section>';
                    } else {
                        options += '<section class="itemUser"><input type="radio" name="enc_cod_cliente" id="cli_' + j[i].nome + '" value="' + j[i].cod_cliente + '"/><label for="cli_' + j[i].nome + '">' + j[i].nome + ' - ' + j[i].cpf + '</label></section>';
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
