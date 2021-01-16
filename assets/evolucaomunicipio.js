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
        
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_cidade").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaomunicipio/"+parametros,
                type:'post',                
                success: function (data){

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
                        }

                        $('#charts'+i).highcharts({
                        chart: {
                            type: 'column'
                        },
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

         if(valor=='M'){
           //function(){        
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
        
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_cidade").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaomunicipio/"+parametros,
                type:'post',                
                success: function (data){

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
                        }

                        $('#charts'+i).highcharts({
                        chart: {
                            type: 'column'
                        },
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
    //}

            //fim do grafico por mes
         }else if(valor=="A"){

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
        
            parametros=$("#cd_disciplina").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_cidade").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/evolucaomunicipioano/"+parametros,
                type:'post',                
                success: function (data){

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
                        }

                        $('#charts'+i).highcharts({
                        chart: {
                            type: 'column'
                        },
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

            //fim do grafico por ano
         }   


    });