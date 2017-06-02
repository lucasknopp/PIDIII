<?php
include 'tema/cabecalho.php';
require_once '../config/class/Romaneios.class.php';
require_once '../config/class/Unidades.class.php';
require_once '../config/class/Motoristas.class.php';
require_once '../config/class/Veiculos.class.php';
require_once '../config/class/Encomendas.class.php';
require_once '../config/class/Cidade.class.php';
require_once '../config/class/Itensromaneios.class.php';
$urlvoltar = "listar_romaneios.php";
$ok = "";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $romaneiosRepository = new RomaneiosRepository();
    $romaneios = $romaneiosRepository->localizarId($id);
    if (!empty($romaneios)) {
        if (validaDTMaiorTrue($romaneios->getDtorigem(), date("d/m/Y H:i")) || $_SESSION['user'] == 'master') {
            
        } else {
            header("Location: " . $urlvoltar . "?red=" . "Romaneio ainda não foi concluido!");
            exit;
        }
    } else {
        header("Location: " . $urlvoltar . "?red=" . "Romaneio não existe!");
        exit;
    }
}
?>
<section class="Titulo">Detalhes do Romaneio</section>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Unidade Origem</label>
        <?php
        $unidades = new Unidades();
        $unidadesRepository = new UnidadesRepository();
        $unidades = $unidadesRepository->listar();
        foreach ($unidades as $valor) {
            if ($romaneios->getIdorigem() == $valor->getId()) {
                echo '<p>' . $valor->getNome() . '</p>';
            }
        }
        ?>
    </section>
    <section class="Item">
        <label>Data/Hora de Saída</label>
        <p><?= $romaneios->getDtorigem() ?></p>
    </section>
    <section class="Item">
        <label>Data/Hora de Chegada</label>
        <p><?= $romaneios->getDtdestino() ?></p>
    </section>
    <section class="Item">
        <label>Unidade Destino</label>
        <?php
        $unidades = new Unidades();
        $unidadesRepository = new UnidadesRepository();
        $unidades = $unidadesRepository->listar();
        foreach ($unidades as $valor) {
            if ($romaneios->getIdorigem() == $valor->getId()) {
                echo '<p>' . $valor->getNome() . '</p>';
            }
        }
        ?>
    </section>
    <section class="Item">
        <label>Motorista</label>
        <?php
        $motoristas = new Motoristas();
        $motoristasRepository = new MotoristasRepository();
        $motoristas = $motoristasRepository->listar();
        foreach ($motoristas as $valor) {
            if ($romaneios->getIdmotorista() == $valor->getId()) {
                echo '<p>' . $valor->getNome() . '</p>';
            }
        }
        ?>
    </section>
    <section class="Item">
        <label>Placa do veículo</label>
        <?php
        $veiculos = new Veiculos();
        $veiculosRepository = new VeiculosRepository();
        $veiculos = $veiculosRepository->listar();
        foreach ($veiculos as $valor) {
            if ($romaneios->getIdcaminhao() == $valor->getId()) {
                echo '<p>' . $valor->getNumplaca() . '</p>';
            }
        }
        ?>
    </section>

    <section class="Item">
        <label>Encomendas do Romaneio</label>
        <section class="Lista Check">
            <table>
                <tbody>
                    <?php
                    $encomendasRepository = new EncomendasRepository();
                    $encomendas = $encomendasRepository->listar($romaneios->getId());
                    foreach ($encomendas as $valor) {
                        echo '<p>Cod rastreio: ' . $valor->getCodrastreio() . ' - Cidade destino: ' . $valor->getCid_destino() . '</p>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
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
