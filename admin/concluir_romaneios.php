<?php
include 'tema/cabecalho.php';
require_once '../config/class/Romaneios.class.php';
require_once '../config/class/Unidades.class.php';
require_once '../config/class/Motoristas.class.php';
require_once '../config/class/Veiculos.class.php';
require_once '../config/class/Encomendas.class.php';
require_once '../config/class/Cidade.class.php';
require_once '../config/class/Itensromaneios.class.php';
$urlvoltar = "listar_romaneios_viagem.php";
$ok = "";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $romaneiosRepository = new RomaneiosRepository();
    $romaneios = $romaneiosRepository->localizarId($id);
    if (!empty($romaneios)) {
        if (validaDTMaiorTrueIgual($romaneios->getDtorigem(), date("d/m/Y H:i"))) {
            if (isset($_POST["editar"])) {
                $romaneios->setDtdestino($_POST['rom_dtdestino']);
                $romaneios->valida();
                $romaneiosRepository->gravar($romaneios);
                header("Location: " . $urlvoltar . "?green=" . "Romaneio finalizado com sucesso!");
                exit;
            }
        } else {
            header("Location: " . $urlvoltar . "?red=" . "Romaneio ainda não saiu do ponto de partida!");
            exit;
        }
    } else {
        header("Location: " . $urlvoltar . "?red=" . "Romaneio não existe!");
        exit;
    }
}
?>
<section class="Titulo">Concluir Romaneio</section>
<form action="" method="post" class="FormPadrao">
    <section class="Item">
        <label>Data/Hora de Chegada - Ex(<?php echo date("d/m/Y H:i"); ?>)</label>
        <input id="dataSaida" type="text" name="rom_dtdestino" value="<?php echo date("d/m/Y H:i"); ?>" placeholder="Digite um data de saída..."/>
        <?= (isset($mensagem["rom_dtdestino"]) ? '<section class="Erro">' . $mensagem["rom_dtorigem"] . "</section>" : "") ?>
    </section>
    <section class="Item">
        <button type="submit" name="editar">Concluir romaneio</button>
    </section>
</form>
<script type="text/javascript">
    $(function () {
        $('input[name="rom_dtdestino"]').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            pick12HourFormat: false,
            maxDate: '<?php echo date("d/m/Y H:i"); ?>',
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
