$(document).ready(function(){
    $(".ExcluirLinha").height($(".ExcluirLinha .ECaixa").height()+12).css("margin-top", -(($(".ExcluirLinha .ECaixa").height()/2)+6));
});

function LimpaAlert() {
    $(".Alertas").html('');
}

function ExcluirLinha(id, tabela, coluna, texto){
    $(".Alertas").html('<section class="ExcluirLinha"><section class="ECaixa"><section class="TituloCaixa">'+texto+'</section><section class="Botoes"><a class="CV" style="background: #bb0022;" href="excluir_linha.php?tabela='+tabela+'&coluna='+coluna+'&id='+id+'">Excluir</a><a class="CA" style="background: #ddaa00;" href="javascript:void(0)" onclick="LimpaAlert()">Cancelar</a></section></section></section><section class="preto60"></section>');
}

function ExcluirLinhaRomaneios(id, texto){
    $(".Alertas").html('<section class="ExcluirLinha"><section class="ECaixa"><section class="TituloCaixa">'+texto+'</section><section class="Botoes"><a class="CV" style="background: #bb0022;" href="excluir_linha_romaneios.php?id='+id+'">Excluir</a><a class="CA" style="background: #ddaa00;" href="javascript:void(0)" onclick="LimpaAlert()">Cancelar</a></section></section></section><section class="preto60"></section>');
}

function ExcluirLinhaMotoristas(id, texto){
    $(".Alertas").html('<section class="ExcluirLinha"><section class="ECaixa"><section class="TituloCaixa">'+texto+'</section><section class="Botoes"><a class="CV" style="background: #bb0022;" href="excluir_linha_motoristas.php?id='+id+'">Excluir</a><a class="CA" style="background: #ddaa00;" href="javascript:void(0)" onclick="LimpaAlert()">Cancelar</a></section></section></section><section class="preto60"></section>');
}

function ExcluirLinhaVeiculos(id, texto){
    $(".Alertas").html('<section class="ExcluirLinha"><section class="ECaixa"><section class="TituloCaixa">'+texto+'</section><section class="Botoes"><a class="CV" style="background: #bb0022;" href="excluir_linha_veiculos.php?id='+id+'">Excluir</a><a class="CA" style="background: #ddaa00;" href="javascript:void(0)" onclick="LimpaAlert()">Cancelar</a></section></section></section><section class="preto60"></section>');
}