mesAno = '';
inicio = {
    initApp: function() {
        $('#edDataDados').bootstrapMaterialDatePicker({ format : 'MM/YYYY', lang : 'pt-br', cancelText : 'Cancelar', time: false });

        $('#edCalendarioCampoData1, #alterar').click(function(){
          $('#edDataDados').focus();
        
        });

        inicio.getMesAnoAtual();

    },
    getMesAnoAtual: function() {

        $.post(baseUrl + 'Inicioajax/getMesAnoAtual', {getMesAnoAtual: ''}, function(j){
            if(j != null){
                mesAno = j;
                inicio.buscaQtdDados('E');
                inicio.buscaQtdDados('P');
                inicio.buscaQtdDados('A');
            } 
        }, "json");

    },
    atualizar: function() {

        if($('#edDataDados').val() != '') {
            novaData = $('#edDataDados').val();

            $('#dadosDe').html('');
            
            $.post(baseUrl + 'Inicioajax/atualizaData', {AtualizaData: '', data: novaData}, function(j){
                if(j != null) {
                    $('#dadosDe').html(j.mes+' de '+j.ano);
                }
            });

            
            inicio.buscaQtdDados('E', novaData);
            inicio.buscaQtdDados('P', novaData);
            inicio.buscaQtdDados('A', novaData);
            
        
        } else {
            inicio.buscaQtdDados('E');
            inicio.buscaQtdDados('P');
            inicio.buscaQtdDados('A');
        }

    },
    buscaQtdDados: function(tipo, novaData = null) {

        $('#qtdEnviado').html('');
        $('#valorEnviado').html('');
        $('#qtdPago').html('');
        $('#valorPago').html('');
        $('#qtdAberto').html('');
        $('#valorAberto').html('');
       
        if(novaData == null) {
            $.post(baseUrl + 'Inicioajax/buscaQtdDados', {BuscaDados: '', data: mesAno, tipo}, function(j){
                if(j != null){

                    if(tipo == 'E') {
                        $('#qtdEnviado').html(j.quantia);
                        if(j.valor == 'R$ ') {
                            $('#valorEnviado').html('R$ 0,00');
                        } else {
                            $('#valorEnviado').html(j.valor);
                        }
                    } else if(tipo == 'P') {
                        $('#qtdPago').html(j.quantia);
                        if(j.valor == 'R$ ') {
                            $('#valorPago').html('R$ 0,00');
                        } else {
                            $('#valorPago').html(j.valor);
                        }
                    } else if(tipo == 'A') {
                        $('#qtdAberto').html(j.quantia);
                        if(j.valor == 'R$ ') {
                            $('#valorAberto').html('R$ 0,00');
                        } else {
                            $('#valorAberto').html(j.valor);
                        }
                    }
                } 
            }, "json");
        } else {
            $.post(baseUrl + 'Inicioajax/buscaQtdDados', {BuscaDados: '', data:novaData, tipo}, function(j){
                if(j != null){
                    if(tipo == 'E') {
                        $('#qtdEnviado').html(j.quantia);
                        if(j.valor == 'R$ ') {
                            $('#valorEnviado').html('R$ 0,00');
                        } else {
                            $('#valorEnviado').html(j.valor);
                        }
                    } else if(tipo == 'P') {
                        $('#qtdPago').html(j.quantia);
                        if(j.valor == 'R$ ') {
                            $('#valorPago').html('R$ 0,00');
                        } else {
                            $('#valorPago').html(j.valor);
                        }
                    } else if(tipo == 'A') {
                        $('#qtdAberto').html(j.quantia);
                        if(j.valor == 'R$ ') {
                            $('#valorAberto').html('R$ 0,00');
                        } else {
                            $('#valorAberto').html(j.valor);
                        }
                    }
                } 
            }, "json");
        }

    },
    
    buscaDadosEnviados: function() {

        if($('#edDataDados').val() != '') {


            $.post(baseUrl + 'Inicioajax/buscaDadosEnviados', {buscaDadosEnviados: '', data:$('#edDataDados').val()}, function(j){
                if(j != null){
                    

                    $('#tituloTitulos').html('');
                    $('#append').html('');
                    $('#tituloTitulos').html('Títulos Enviados');

                    for(let i = 0; i < j.length; i++) {

                        var html = '';

                        html += '<tr>';
                        html += '   <td>'+j[i].nossoNumero+'</td>';
                        html += '   <td>'+j[i].saldo+'</td>';
                        html += '   <td>'+j[i].data+'</td>';
                        html += '   <td>'+j[i].cliente+'</td>';
                        html += '<tr>';

                        $('#append').append(html);
                    }

                    $('#modalDados').modal('show');
    
                } 
            }, "json");

        } else {
            $.post(baseUrl + 'Inicioajax/buscaDadosEnviados', {buscaDadosEnviados: '', data: 'atual'}, function(j){
                if(j != null){

                    $('#tituloTitulos').html('');
                    $('#append').html('');
                    $('#tituloTitulos').html('Títulos Enviados');

                    for(let i = 0; i < j.length; i++) {

                        var html = '';

                        html += '<tr>';
                        html += '   <td>'+j[i].nossoNumero+'</td>';
                        html += '   <td>'+j[i].saldo+'</td>';
                        html += '   <td>'+j[i].data+'</td>';
                        html += '   <td>'+j[i].cliente+'</td>';
                        html += '<tr>';

                        $('#append').append(html);
                    }

                    $('#modalDados').modal('show');
    
                } 
            }, "json");

        }

    },
    
    buscaDadosPagos: function(novaData = null){

        if($('#edDataDados').val() != '') {

            $.post(baseUrl + 'Inicioajax/buscaDadosPagos', {buscaDadosPagos: '', data:$('#edDataDados').val()}, function(j){
                if(j != null){

                    $('#tituloTitulos').html('');
                    $('#append').html('');
                    $('#tituloTitulos').html('Títulos Pagos');

                    for(let i = 0; i < j.length; i++) {

                        var html = '';

                        html += '<tr>';
                        html += '   <td>'+j[i].nossoNumero+'</td>';
                        html += '   <td>'+j[i].saldo+'</td>';
                        html += '   <td>'+j[i].data+'</td>';
                        html += '   <td>'+j[i].cliente+'</td>';
                        html += '<tr>';

                        $('#append').append(html);
                    }

                    $('#modalDados').modal('show');
    
                } 
            }, "json");
        } else {
            $.post(baseUrl + 'Inicioajax/buscaDadosPagos', {buscaDadosPagos: '', data: 'atual'}, function(j){
                if(j != null){
    
                    $('#tituloTitulos').html('');
                    $('#append').html('');
                    $('#tituloTitulos').html('Títulos Pagos');

                    for(let i = 0; i < j.length; i++) {

                        var html = '';

                        html += '<tr>';
                        html += '   <td>'+j[i].nossoNumero+'</td>';
                        html += '   <td>'+j[i].saldo+'</td>';
                        html += '   <td>'+j[i].data+'</td>';
                        html += '   <td>'+j[i].cliente+'</td>';
                        html += '<tr>';

                        $('#append').append(html);
                    }

                    $('#modalDados').modal('show');
                } 
            }, "json");
        }
        
    },
    
    buscaDadosEmAberto: function(novaData = null) {
        if($('#edDataDados').val() != '') {

            $.post(baseUrl + 'Inicioajax/buscaDadosEmAberto', {buscaDadosEmAberto: '', data:$('#edDataDados').val()}, function(j){
                if(j != null){
                    
                    $('#tituloTitulos').html('');
                    $('#append').html('');
                    $('#tituloTitulos').html('Títulos em Aberto');

                    for(let i = 0; i < j.length; i++) {

                        var html = '';

                        html += '<tr>';
                        html += '   <td>'+j[i].nossoNumero+'</td>';
                        html += '   <td>'+j[i].saldo+'</td>';
                        html += '   <td>'+j[i].data+'</td>';
                        html += '   <td>'+j[i].cliente+'</td>';
                        html += '<tr>';

                        $('#append').append(html);
                    }

                    $('#modalDados').modal('show');
    
                } 
            }, "json");
        } else {
            $.post(baseUrl + 'Inicioajax/buscaDadosEmAberto', {buscaDadosEmAberto: '', data: 'atual'}, function(j){
                if(j != null){
                
                    $('#tituloTitulos').html('');
                    $('#append').html('');
                    $('#tituloTitulos').html('Títulos em Aberto');
                
                    for(let i = 0; i < j.length; i++) {

                        var html = '';

                        html += '<tr>';
                        html += '   <td>'+j[i].nossoNumero+'</td>';
                        html += '   <td>'+j[i].saldo+'</td>';
                        html += '   <td>'+j[i].data+'</td>';
                        html += '   <td>'+j[i].cliente+'</td>';
                        html += '<tr>';

                        $('#append').append(html);
                    }

                    $('#modalDados').modal('show');
    
                } 
            }, "json");
        }
    }
}