$(document).ready(function () {
    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();
        $('#carregando').show();
        var cd_escola       = $('#cd_escola').val();
        var nr_inep_escola  = $('#nr_inep_escola').val();
        var nm_escola       = $('#nm_escola').val();        
        var cd_turma        = $('#cd_turma').val();
        var cd_etapa        = $('#cd_etapa').val();        
        var url_listar      = $('#url_base').val()+'/listagem_consulta';
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {            
            cd_escola       : cd_escola,
            nr_inep_escola  : nr_inep_escola,
            nm_escola       : nm_escola,
            cd_turma        : cd_turma,
            cd_etapa        : cd_etapa

        }, function (data) {
            $('#listagem_resultado').html(data);
            $('#carregando').hide();
        });
    });
    
    $("#btn_infrequencia").click(function (ev) {
        ev.preventDefault();
        $('#carregando').show();
        var cd_escola       = $('#cd_escola').val();
        var cd_turma        = $('#cd_turma').val();
        var cd_etapa        = $('#cd_etapa').val();
        var cd_mes          = $('#cd_mes').val();  
        
        var url_listar      = $('#url_base').val()+'/listagem_infrequencia';
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {            
            cd_escola       : cd_escola,            
            cd_turma        : cd_turma,
            cd_etapa        : cd_etapa,
            cd_mes          : cd_mes

        }, function (data) {
            $('#listagem_resultado').html(data);
            $('#carregando').hide();
        });
    });
     
});

function carregamodal(id) {
	
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
	 
    var cd_turma=$('#cd_turma').val();
    var cd_aluno=id;    
    var textnode ='';         
    $.ajax({
		    url:"infrequencia/partials/infrequencia/",
		    type: 'POST',
		    data: {cd_turma:cd_turma,cd_aluno:cd_aluno},
		    dataType:"json",
		    success: function(data) { 
		    	var meses=[];
		    	var faltas=[];
		    	var disciplinas=[];
		    	var pavaliaacerto=[];
		    	var lavaliaacerto=[];
		    	var mavaliaacerto=[];
		    	var dpostugues;var dleitura; var dmatematica;
		    	
		    	for(var i=0; i<data.length; i++){
		    		meses[i]=data[i].nr_mes;		    		
		    		faltas[i]=parseInt(data[i].nr_faltas);
		    		dpostugues=data[i].portugues;
		    		dleitura=data[i].leitura;
		    		dmatematica=data[i].matematica;
		    		pavaliaacerto[i]=parseInt(data[i].pacerto);
		    		mavaliaacerto[i]=parseInt(data[i].macerto);
		    		lavaliaacerto[i]=parseInt(data[i].lacerto);
		    	}
		    	
		    	
		    	$('#divFalta'+id).highcharts({
		    		chart: {
		    	        type: 'column'
		    	    },
		            plotOptions: {
		                column: {
		                    pointPadding: 0.2,
		                    borderWidth: 0
		                }
		            },
		    	    title: {
		    	        text: 'Evolução Mensal de Infrequência e Avaliações por Aluno'
		    	    },

		    	    subtitle: {
		    	        text: 'Clique nos botões botões para exibílos ou ocultá-los'
		    	    },

		    	    legend: {
		    	        align: 'right',
		    	        verticalAlign: 'middle',
		    	        layout: 'vertical'
		    	    },

		    	    xAxis: {
		    	        categories: meses,
		    	        crosshair: true
		    	        /*labels: {
		    	            x: -10
		    	        }*/
		    	    },

		    	    yAxis: {
		    	        allowDecimals: false,
		    	        title: {
		    	            text: 'Totais'
		    	        }
		    	    },
		    	    tooltip: {
		    	        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		    	        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		    	            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
		    	        footerFormat: '</table>',
		    	        shared: true,
		    	        useHTML: true
		    	    },
		    	    series: [{
		    	        name: 'Meses',
		    	        data: faltas
		    	    }, {
		    	        name: dpostugues,
		    	        data: pavaliaacerto
		    	    }, {
		    	        name: dleitura,
		    	        data: lavaliaacerto
		    	    }, {
		    	        name: dmatematica,
		    	        data: mavaliaacerto
		    	    }],

		    	    responsive: {
		    	        rules: [{
		    	            condition: {
		    	                maxWidth: 700
		    	            },
		    	            chartOptions: {
		    	                legend: {
		    	                    align: 'center',
		    	                    verticalAlign: 'bottom',
		    	                    layout: 'horizontal'
		    	                },
		    	                yAxis: {
		    	                    labels: {
		    	                        align: 'left',
		    	                        x: 0,
		    	                        y: -5
		    	                    },
		    	                    title: {
		    	                        text: null
		    	                    }
		    	                },
		    	                subtitle: {
		    	                    text: null
		    	                },
		    	                credits: {
		    	                    enabled: false
		    	                }
		    	            }
		    	        }]
		    	    }
		    	});
		    	
		        //$("#divFalta"+id).append($('#charts'+id));	    
			  }  
	});            
	$('#modalFalta'+id).modal('show');        
}        
