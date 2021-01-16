function test() {
    var valid = true;
    var messages = [];
    $("#form").find("input,select,textarea").each(function(index) {
        $(this).parent().removeClass("has-error");
    });

    var etapa = $("#nr_anoletivo");
    var turma = $("#cd_turma");
    var disciplina = $("#cd_disciplina");
    var cd_avaliacao = $("#cd_avaliacao");
    var escola = $("#cd_escola");


    if (etapa.val() == '0') {
        addError('O preenchimento do campo Etapa é obrigatório', messages);
        valid = false;
    } else if (cd_avaliacao.val() == '0') {
        addError('O preenchimento do campo Avaliação é obrigatório', messages);
        valid = false;
    } else if (disciplina.val() == '0') {
        addError('O preenchimento do campo Disciplina é obrigatorio', messages);
        valid = false;
    } else if (escola.val() == '0') {
        addError('O preenchimento do campo Escola é obrigatorio', messages);
        valid = false;
    } else if (turma.val() == '0') {
        addError('O preenchimento do campo Turma é obrigatorio', messages);
        valid = false;
    }
    if (!valid) {
        errorMessage = '';
        messages.forEach(function(entry) {
            errorMessage += entry + '!<br/>';
        });
        growAlert("Alerta", errorMessage, "danger", "ban", 5000);
    }

    return valid;
}

function validaForm() {
    var estado = $('#cd_estado').val();
    var cidade = $('#cd_cidade').val();
    var escola = $('#cd_escola').val();
    var etapa = $('#cd_etapa').val();
    var turma = $('#cd_turma').val();
    var disciplina = $('#cd_disciplina').val();
    var avaliacao = $('#cd_avaliacao').val();
    //var avaliacao=$('#cd_avaliacao').val();
    //if(estado==''||cidade==''||etapa==''||disciplina==''||avaliacao==''||turma==''||escola==''){
    if (etapa == '' || disciplina == '' || avaliacao == '' || turma == '' || escola == '') {
        alert('Verifique o preenchimento dos campos com asterísco (*)!');
        return false;
    } else {
        $('#acertoerros').submit();
        return true;
    }
}

$(function() {
    $('#btSearch').click(function() {
        if (validaForm()) {

            Highcharts.setOptions({
                lang: {
                    contextButtonTitle: 'Menu de exportação',
                    downloadPNG: "Baixar em PNG",
                    downloadSVG: "Baixar vetor em SVG",
                    downloadPDF: "Baixar em PDF",
                    downloadJPEG: "Baixar Imagem JPG",
                    printChart: "Imprimir o gráfico",
                    decimalPoint: ',',
                    thousandsSep: '.',
                    numericSymbols: ['.000', '.000.000', '', '', '']
                }
            });
            //$('#modalLoad').modal('hide');
            if (test() == true) {
                $('#listagem_resultado').empty();
                parametros = $("#cd_avaliacao").val() + "/" + $("#cd_disciplina").val() + "/" + $("#cd_turma").val() + "/" + $("#cd_etapa").val() + "/" + $("#cd_escola").val();
                $.ajax({
                    //componente:componente.id,
                    url: "partials/buscar/" + parametros,
                    type: 'post',
                    data: { cd_topico: $('#cd_topico').val() },
                    success: function(data) {
                        var cores = [];
                        for (var i = 0; i < data.length; i++) {
                            var divC = document.createElement("div");
                            divC.setAttribute("id", "charts" + i);
                            divC.setAttribute("style", "min-width: 310px; height: 400px; margin: 0 auto");
                            $('#listagem_resultado').append(divC);

                            var topico = data[i].topico;
                            var descritor = data[i].descritor.split(',');
                            var trues = data[i].tt_certo.split(',');
                            var percentual = data[i].pacerto.split(',');

                            var d;
                            var txtcertos = [];
                            var certos = [];
                            var total_certo = 0;

                            for (d = 0; d < descritor.length; d++) {
                                var obj = {
                                    name: (descritor[d]),
                                    y: parseInt(percentual[d]),
                                    drilldown: parseInt(percentual[d])
                                };
                                certos.push(obj);
                                total_certo += parseInt(trues[d]);
                                if (percentual[d] <= 50) { cores[d] = '#E60000'; }
                                if (percentual[d] > 50 && percentual[d] <= 70) { cores[d] = '#FFFF00'; }
                                if (percentual[d] > 70) { cores[d] = '#006600'; }
                            }
                            $('#charts' + i).highcharts({
                                chart: {
                                    type: 'column'
                                },
                                colors: cores,
                                title: {
                                    text: topico
                                },
                                subtitle: {
                                    text: ''
                                },
                                xAxis: {
                                    type: 'category'
                                },
                                yAxis: {
                                    title: {
                                        text: 'Percentual Total de Acertos'
                                    }

                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%'
                                        }
                                    }
                                },

                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do total<br/>'
                                },

                                "series": [{
                                    "name": topico,
                                    "colorByPoint": true,
                                    "data": certos
                                }],
                            });
                        }
                    }
                });
            }

        }

    });
});