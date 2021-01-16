$(function () {
    $('input[name=rd_rel]').change(function(){
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
        
        if($('input[name=rd_rel]:checked').val()=='M') {
            parametros=$("#cd_etapa").val()+"/"+$("#cd_turma").val()+"/"+$("#cd_disciplina").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/munleituraescola/"+parametros,
                type:'post',                
                success: function (data){
                    var meses=[];
                    var certos=[];
                    var leitor_fluente=[];
                    var leitor_sfluente=[];
                    var leitor_frase=[];
                    var leitor_palavra=[];
                    var leitor_silaba=[];
                    var nao_leitor=[];
                    var nao_avaliado=[];
                    var str = JSON.stringify(data);
                    var jason = JSON.parse(str);
                    for(var i=0; i<jason.length; i++){
                        meses[i]=jason[i].mes;

                                    leitor_fluente[i]=parseInt(jason[i].leitor_fluente);
                                    leitor_sfluente[i]=parseInt(jason[i].leitor_sfluente);    
                                    leitor_frase[i]=parseInt(jason[i].leitor_frase);
                                    leitor_palavra[i]=parseInt(jason[i].leitor_palavra);
                                    leitor_silaba[i]=parseInt(jason[i].leitor_silaba);
                                    nao_leitor[i]=parseInt(jason[i].nao_leitor);        
                                    nao_avaliado[i]=parseInt(jason[i].nao_avaliado);
                    }
                        var obj1={
                              name:('Leitor Fluente'),
                              data:leitor_fluente
                            };
                        var obj2={
                              name:('Leitor Sem Fluência'),
                              data:leitor_sfluente
                            };
                        var obj3={
                              name:('Leitor de Frase'),
                              data:leitor_frase
                            };    
                        var obj4={
                              name:('Leitor de Palavra'),
                              data:leitor_palavra
                            };    
                        var obj5={
                              name:('Leitor de Sílaba'),
                              data:leitor_silaba
                            };    
                        var obj6={
                              name:('Não Leitor'),
                              data:nao_leitor
                            };    
                        var obj7={
                                name:('Não Avaliado'),
                                data:nao_avaliado
                              }; 
                        certos.push(obj1);
                        certos.push(obj2);
                        certos.push(obj3);
                        certos.push(obj4);
                        certos.push(obj5);
                        certos.push(obj6);
                        certos.push(obj7);
                        
                        var divC=document.createElement("div");
                            divC.setAttribute("id","charts");
                            divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                        $('#listagem_resultado').append(divC);                        

                        $('#charts').highcharts({
                        chart: {
                            type: 'line'
                        },
                        colors: ['#006600','#B3E6B3','#FFFF00', '#FF9900','#FF8080','#E60000'],

                        title: {
                            text: jason[0].nm_escola
                        },
                        subtitle: {
                            text: 'Situação de Leitura da Escola por Mês'
                        },
                        xAxis: {
                            categories: meses
                        },
                        yAxis: {
                            title: {
                                text: 'Qtd de Estudantes'
                            }

                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: certos
                    });
                }
            });
        }
        if($('input[name=rd_rel]:checked').val()=='A') {
            
            parametros=$("#cd_etapa").val()+"/"+$("#cd_turma").val()+"/"+$("#cd_disciplina").val();
            $.ajax({
                //componente:componente.id,
                url:"partials/munleituraescolaano/"+parametros,
                type:'post',                
                success: function (data){
                    var anos=[];
                    var certos=[];
                    var leitor_fluente=[];
                    var leitor_sfluente=[];
                    var leitor_frase=[];
                    var leitor_palavra=[];
                    var leitor_silaba=[];
                    var nao_leitor=[];
                    var nao_avaliado=[];
                    var str = JSON.stringify(data);
                    var jason = JSON.parse(str);
                    for(var i=0; i<jason.length; i++){
                        anos[i]=jason[i].ano;

                                    leitor_fluente[i]=parseInt(jason[i].leitor_fluente);
                                    leitor_sfluente[i]=parseInt(jason[i].leitor_sfluente);    
                                    leitor_frase[i]=parseInt(jason[i].leitor_frase);
                                    leitor_palavra[i]=parseInt(jason[i].leitor_palavra);
                                    leitor_silaba[i]=parseInt(jason[i].leitor_silaba);
                                    nao_leitor[i]=parseInt(jason[i].nao_leitor);  
                                    nao_avaliado[i]=parseInt(jason[i].nao_avaliado);
                    }
                    //console.log(meses);
                    //console.log(leitor_fluente);
                        var obj1={
                              name:('Leitor Fluente'),
                              data:leitor_fluente
                            };
                        var obj2={
                              name:('Leitor Sem Fluência'),
                              data:leitor_sfluente
                            };
                        var obj3={
                              name:('Leitor de Frase'),
                              data:leitor_frase
                            };    
                        var obj4={
                              name:('Leitor de Palavra'),
                              data:leitor_palavra
                            };    
                        var obj5={
                              name:('Leitor de Sílaba'),
                              data:leitor_silaba
                            };    
                        var obj6={
                              name:('Não Leitor'),
                              data:nao_leitor
                            };
                        var obj7={
                                name:('Não Avaliado'),
                                data:nao_avaliado
                              }; 
                        certos.push(obj1);
                        certos.push(obj2);
                        certos.push(obj3);
                        certos.push(obj4);
                        certos.push(obj5);
                        certos.push(obj6);
                        certos.push(obj7);

                        var divC=document.createElement("div");
                            divC.setAttribute("id","charts");
                            divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                        $('#listagem_resultado').append(divC);                        

                        $('#charts').highcharts({
                        chart: {
                            type: 'line'
                        },
                        colors: ['#006600','#B3E6B3','#FFFF00', '#FF9900','#FF8080','#E60000'],

                        title: {
                            text: jason[0].nm_escola
                        },
                        subtitle: {
                            text: 'Situação de Leitura da Escola por Ano'
                        },
                        xAxis: {
                            categories: anos
                        },
                        yAxis: {
                            title: {
                                text: 'Qtd de Estudantes'
                            }

                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: false
                            }
                        },
                        series: certos
                    });
                }
            });
        }
    });
 });    
