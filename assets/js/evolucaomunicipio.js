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
        
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_cidade").val()+"/"+$("#nr_anoletivo").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaomunicipio/"+parametros,
                type:'post',                
                success: function (data){
                    var cores=[];
                    for(var i=0; i<data.length; i++){
                        var divC=document.createElement("div");
                            divC.setAttribute("id","charts"+i);
                            divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                        $('#listagem_resultado').append(divC);

                        var topico=data[i].nm_escola;    
                        var descritor=data[i].mes.split(',');                        
                        var percentual=data[i].pacertos.split(',');

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
    });
 });   

$('input[name=rd_rel]').change(
    function(){        
        var valor=$('input[name=rd_rel]:checked').val();         
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
         if(valor=='M'){           
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_cidade").val()+"/"+$("#nr_anoletivo").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaomunicipio/"+parametros,
                type:'post',                
                success: function (data){
                    $('#carregando').show();
                    var cores=[];
                    for(var i=0; i<data.length; i++){
                        var divC=document.createElement("div");
                            divC.setAttribute("id","charts"+i);
                            divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                        $('#listagem_resultado').append(divC);

                        var topico=data[i].nm_escola;    
                        var descritor=data[i].mes.split(',');                        
                        var percentual=data[i].pacertos.split(',');

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
                        title: {
                            text: topico
                        },
                        colors: cores,
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
                            headerFormat: '<span style="font-size:11px">{topico}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do total<br/>'
                        },
                        "series": [
                            {
                                "name": topico,
                                "colorByPoint": true,
                                "data": certos }],
                        });
                    }
                    
                }, complete : function(xhr, status) {
                        $('#carregando').hide();
                }
            });
    //}
           
            //fim do grafico por mes
         }else if(valor=="A"){        
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_cidade").val()+"/"+$("#nr_anoletivo").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaomunicipioano/"+parametros,
                type:'post',                
                success: function (data){
                    $('#carregando').show();
                    var cores=[];
                    for(var i=0; i<data.length; i++){
                        var divC=document.createElement("div");
                            divC.setAttribute("id","charts"+i);
                            divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                        $('#listagem_resultado').append(divC);

                        var topico=data[i].nm_escola;    
                        var descritor=data[i].ano.split(',');                        
                        var percentual=data[i].pacertos.split(',');

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
                            headerFormat: '<span style="font-size:11px">{topico}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do total<br/>'
                        },

                        "series": [
                            {
                                "name": topico,
                                "colorByPoint": true,
                                "data": certos }],
                        });
                    }
                                     
                }, complete : function(xhr, status) {
                        $('#carregando').hide();
                }                
            });
            //fim do grafico por ano            
         }  
        }  
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