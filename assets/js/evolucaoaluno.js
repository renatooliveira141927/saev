$(function () {
    $('#btSearch').click(function(){
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
        if(validaForm()){
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_turma").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_escola").val()+"/"+$("#nr_anoletivo").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaoaluno/"+parametros,
                type:'post',                
                success: function (data){
                    for(var i=0; i<data.length; i++){
                        var topico=[];
                        var descritor=[];
                        var percentual=[];
                        var cores=[];
                        var divC=document.createElement("div");
                            divC.setAttribute("id","charts"+i);
                            divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                        $('#listagem_resultado').append(divC);

                        topico=data[i].nm_aluno.split(',');    
                        descritor=data[i].mes.split(',');                        
                        percentual=data[i].pacertos.split(',');
                        var d;
                        var txtcertos=[];
                        var certos=[];
                        var total_certo=0;

                        for(d=0;d<descritor.length;d++){
                            var obj ={                              
                              name:(descritor[d]),
                              y:parseInt(percentual[d]),                              
                              drilldown:parseInt(percentual[d])
                            };
                            certos.push(obj);
                            if(percentual[d]<=50){cores[d]='#E60000';}
                            if(percentual[d]>50 &&percentual[d]<=70 ){cores[d]='#FFFF00';}
                            if(percentual[d]>70){cores[d]='#006600';}
                        }

                        $('#charts'+i).highcharts({
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

                        "series": [
                            {
                                "name": topico,
                                "colorByPoint": true,
                                "data": certos }],
                        });
                    }
                                     
                }
            });
    	}   
    });
 });   


function validaForm(){
	var estado=$('#cd_estado').val();
	var cidade=$('#cd_cidade').val();
	var etapa=$('#cd_etapa').val();			
    var disciplina=$('#cd_disciplina').val();
    var nr_anoletivo=$('#nr_anoletivo').val();	
	//var avaliacao=$('#cd_avaliacao').val();
	if(estado==''||cidade==''||etapa==''||disciplina==''||nr_anoletivo==''){
		alert('Verifique o preenchimento dos campos com asterísco (*)!');
		return false;
	}else{
		$('#avaliacaoleitura').submit();
		return true;
	}
}