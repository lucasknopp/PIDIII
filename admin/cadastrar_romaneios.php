<?php
include 'tema/cabecalho.php';
require_once '../config/class/Romaneios.class.php';
require_once '../config/class/Unidades.class.php';
require_once '../config/class/Motoristas.class.php';
require_once '../config/class/Veiculos.class.php';
require_once '../config/class/Encomendas.class.php';
require_once '../config/class/Cidade.class.php';
require_once '../config/class/Itensromaneios.class.php';

$ok = "";
if (isset($_POST["cadastrar"])) {
    if (isset($_POST['encomendasRomaneio'])) {
        $encomendasRomaneio = $_POST['encomendasRomaneio'];
    }
    $romaneios = new Romaneios(0, $_POST["rom_idorigem"], $_POST["rom_dtorigem"], $_POST["rom_iddestino"], 0, $_POST["rom_idmotorista"], $_POST["rom_idcaminhao"]);
    $romaneios->valida();
    $mensagem = $romaneios->getMensagem();
    if (empty($mensagem) && !empty($encomendasRomaneio)) {
        $romaneiosRepository = new RomaneiosRepository();
        $romaneiosU = $romaneiosRepository->gravar($romaneios);
        foreach ($encomendasRomaneio as $valor) {
            $itemRomaneio = new Itensromaneios(0, $romaneiosU->getId(), $valor);
            $itemRomaneioRepo = new ItensromaneiosRepository();
            $itemRomaneioRepo->gravar($itemRomaneio);
            $encomendaAlterar = new Encomendas();
            $encomendaAlterarRepo = new EncomendasRepository();
            $encomendaAlterar = $encomendaAlterarRepo->localizarId($valor);
            $encomendaAlterar->setControleromaneio(1);
            $encomendaAlterarRepo->gravar($encomendaAlterar);
        }
        $romaneios = new Romaneios();
        if ($romaneios) {
            $ok = "ok";
        }
    }
}
?>
<section class="Titulo">Cadastro de Romaneios</section>
<?php if ($ok == "ok") { ?>
    <section class="MensagemVerde">Romaneios adicionado com sucesso!</section>
<?php } ?>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Unidade Origem</label>
        <select name="rom_idorigem">
            <option selected value="">Selecione um unidade origem...</option>
            <?php
            $unidades = new Unidades();
            $unidadesRepository = new UnidadesRepository();
            $unidades = $unidadesRepository->listar();
            foreach ($unidades as $valor) {
                echo '<option value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
            }
            ?>
        </select>
        <?= (isset($mensagem["rom_idorigem"]) ? '<section class="Erro">' . $mensagem["rom_idorigem"] . "</section>" : "") ?>
    </section><section class="Item">
        <label>Data/Hora de Saída - Ex(<?php echo date("d/m/Y H:i"); ?>)</label>
        <input id="dataSaida" type="text" name="rom_dtorigem" value="" placeholder="Digite um data de saída..."/>
        <?= (isset($mensagem["rom_dtorigem"]) ? '<section class="Erro">' . $mensagem["rom_dtorigem"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Unidade Destino</label>
        <select name="rom_iddestino">
            <option selected value="">Selecione um unidade destino...</option>
            <?php
            $unidades = new Unidades();
            $unidadesRepository = new UnidadesRepository();
            $unidades = $unidadesRepository->listar();
            foreach ($unidades as $valor) {
                echo '<option value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
            }
            ?>
        </select>
        <?= (isset($mensagem["rom_iddestino"]) ? '<section class="Erro">' . $mensagem["rom_iddestino"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <label>Motorista</label>
        <select name="rom_idmotorista">
            <option selected value="">Selecione um motorista...</option>
            <?php
            $motoristas = new Motoristas();
            $motoristasRepository = new MotoristasRepository();
            $motoristas = $motoristasRepository->listarLivre();
            foreach ($motoristas as $valor) {
                echo '<option value="' . $valor->getId() . '">' . $valor->getNome() . '</option>';
            }
            ?>
        </select>
        <?= (isset($mensagem["rom_idmotorista"]) ? '<section class="Erro">' . $mensagem["rom_idmotorista"] . "</section>" : "") ?>
    </section><section class="Item">
        <label>Caminhão</label>
        <select name="rom_idcaminhao">
            <option selected value="">Selecione um caminhão...</option>
            <?php
            $veiculos = new Veiculos();
            $veiculosRepository = new VeiculosRepository();
            $veiculos = $veiculosRepository->listarLivre();
            foreach ($veiculos as $valor) {
                echo '<option value="' . $valor->getId() . '">' . $valor->getNumplaca() . '</option>';
            }
            ?>
        </select>
        <?= (isset($mensagem["rom_idcaminhao"]) ? '<section class="Erro">' . $mensagem["rom_idcaminhao"] . "</section>" : "") ?>
    </section>

    <section class="Item">
        <label>Encomendas do Romaneio</label>
        <section class="Lista Check">
            <table>
                <thead><tr><td>Identificação</td><td><a class="BTSELEALL" style="float: right;" href="javascript:void(0)">Selecionar Tudo</a></td></tr></thead>
                <tbody>
                    <?php
                    $cidadeRepository = new CidadeRepository();
                    $encomendasRepository = new EncomendasRepository();
                    $encomendas = $encomendasRepository->listar('0');
                    if ($encomendas == null) {
                        echo '<tr><td colspan="2">Nenhuma encomenda disponível para adicionar ao romaneio.</td></tr>';
                    }
                    foreach ($encomendas as $valor) {
                        $cidade = $cidadeRepository->localizarId($valor->getCid_destino());
                        echo '<tr><td colspan="2"><input type="checkbox" value="' . $valor->getId() . '" name="encomendasRomaneio[]" /><b>Cod rastreio:</b> ' . $valor->getCodrastreio() . ' - <b>Cidade destino:</b> ' . $cidade->getNome() . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </section>
    <section class="Item">
        <button type="submit" name="cadastrar">Cadastrar romaneios</button>
    </section>
</form>
<script type="text/javascript">
    $(function () {
        $('input[name="rom_dtorigem"]').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            pick12HourFormat: false,
            minDate: '<?php echo date("d/m/Y H:i"); ?>',
            locale: {
                format: 'DD/MM/YYYY HH:mm'
                        // 2016-11-10T03:28:15+00:00
            }
        });
    });
</script>
<script>
    $('.Check tbody').find('tr').click(function () {
        var checkBoxes = $(this).find("input[name=encomendasRomaneio\\[\\]]");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));

        $(this).toggleClass('checked');
    });
    $('.BTSELEALL').click(function () {
        var checkAll = $('.Check tbody').find("input[name=encomendasRomaneio\\[\\]]");
        checkAll.prop("checked", !checkAll.prop("checked"));
        if (checkAll.prop("checked")) {
            $('.Check tbody').find('tr').addClass('checked');
        } else {
            $('.Check tbody').find('tr').removeClass('checked');
        }
    });
</script>
<?php
include 'tema/rodape.php';
