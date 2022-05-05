let titulosArray = [];
enviartitulos = {
  initApp: function() {
    // fazer um consulta para pegar a configuração padrao e carregar os combos com as configurações padrões

    enviartitulos.comboCaixa();

    $.ajax({
      url: baseUrl + 'enviartitulosajax/BuscaConfiguracoesPadrao',
      data: {BuscaConfiguracoesPadrao: ''},
      dataType: "JSON",
      type: "POST",
      beforeSend: function() {
        $.loader({
            className:"blue-with-image-2",
            content:'Aguarde, carregando dados.'
        }); 
      },
      complete: function(){
        $.loader('close');
      },
      error: function (){
        app.showNotification("Erro ao buscar as configurações.", 'danger', 5); 
      },
      success: function(data){
        $("#cbAceite").selectpicker('val', [data.vAceitePadrao]);
        enviartitulos.carregaComboEndosso(data.vEndossoPadrao);
        enviartitulos.carregaComboMotivo(data.vMotivoPadrao);
        enviartitulos.carregaComboPortador(data.vPortadorPadrao);
        enviartitulos.carregaComboEspecie(data.vEspeciePadrao);
      }
    });
  },
  comboCaixa: function() {

    $("#cbCaixa").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboCaixa', {CarregaComboCaixa: ''}, function(j){
        if(j != null){
          $("#cbCaixa").append($('<option>', {
            value: 0,
            text: 'Todos'
          }));
          for (var i = 0; i < j.length; i++) {
              $("#cbCaixa").append($('<option>', {
                value: j[i].vId,
                text: j[i].vNome
              }));
          }
        } 
        $("#cbCaixa")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");

  },
  initTabelaComCaixa: function(caixa) {
    enviartitulos.initTabela(columnDefs, colOrdem, caixa);
  },
  initTabela: function(columnDefs, colOrdem, caixa = null) {
    $('#tabela').dataTable().fnDestroy();
    if(caixa !=  null) {
      tabela =  $('#tabela').DataTable({
                              "language":{
                                  url: 'assets/js/pt-br_datatables.js'
                              },
                              serverSide: true,
                              processing: true,
                              responsive: true,
                              info: true,
                              stateSave: true,
                              ajax: {
                                url: baseUrl + 'enviartitulosajax/carregaTitulos',
                                data: {CarregaTitulos: "", caixa},
                                type: "POST"
                              },
                              ordering: true,
                              columnDefs: columnDefs,
                                deferRender: true,
                                scrollCollapse: true,
                                scroller: {
                                    loadingIndicator: true
                                }
                        });
    } else {
      tabela =  $('#tabela').DataTable({
            "language":{
                url: 'assets/js/pt-br_datatables.js'
            },
            serverSide: true,
            processing: true,
            responsive: true,
            info: true,
            stateSave: true,
            ajax: {
              url: baseUrl + 'enviartitulosajax/carregaTitulos',
              data: {CarregaTitulos: "", caixa: ""},
              type: "POST"
            },
            ordering: true,
            columnDefs: columnDefs,
              deferRender: true,
              scrollCollapse: true,
              scroller: {
                  loadingIndicator: true
              }
      });
    }

    if(colOrdem.length > 0){
      tabela.order(colOrdem).draw();
    }
  },     
  toggleColuna: function(id) {
    if(tabela.column(parseInt(id)).visible() == false) {
      tabela.column(parseInt(id)).visible(true);
    } else {
      tabela.column(parseInt(id)).visible(false);
    }
  }, 
  scrollPage:function(element) {
    $('.main-panel').animate({scrollTop:$(element).offset().top}, 1000);
  },
  BuscaDadosNoWinthor: function (){
   
    $.ajax({
      url: baseUrl + 'enviartitulosajax/BuscaDadosWinthor',
      data: {BuscaDadosWinthor: ''},
      dataType: "JSON",
      type: "POST",
      beforeSend: function() {
        $.loader({
            className:"blue-with-image-2",
            content:'Aguarde, carregando dados.'
        }); 
      },
      complete: function(){
        $.loader('close');
      },
      error: function (){
        app.showNotification("Erro ao buscar os titulos no Winthor.", 'danger', 5); 
      },
      success: function(data){
        enviartitulos.initTabela(columnDefs, colOrdem);
      }
    });
  },
  excluiTituloParaNaoEnviarProCartorio: function(idTitulo) {
    if(idTitulo > 0){
      bootbox.confirm({
          title: "Atenção",
          message: "Ao remover o título da lista, ele não será enviado para o cartório, Deseja continuar?",
          buttons: {
              confirm: {
                  label: '<i class="fa fa-check"></i> Excluir',
                  className: "btn-info marginButton"
              },
              cancel: {
                  label: '<i class="fa fa-times"></i> Cancelar',
                  className: "pull-right"
              }
          },
          callback: function (result) {
              if(result){
                $.ajax({
                  url: baseUrl + 'enviartitulosajax/excluiTituloParaNaoEnviarProCartorio',
                  data: {ExcluiTituloParaNaoEnviarProCartorio: '', idTitulo: idTitulo},
                  dataType: "JSON",
                  type: "POST",
                  beforeSend: function() {
                    $.loader({
                        className:"blue-with-image-2",
                        content:'Aguarde, excluíndo dados.'
                    }); 
                  },
                  complete: function(){
                    $.loader('close');
                  },
                  success: function(data){
                    if (data.result == "OK") {
                      app.showNotification('Título removido da lista de envio.', 'success', 2);
                      enviartitulos.initTabela(columnDefs, colOrdem);
                    }
                  }
                });  
              }
          }
      });
    }
  },
  EnviaTitulosParaIEPTB: function() {
    let titulos = 0;
    titulosArray = [];
    $("input:checkbox[name=titulosCheckbox]:checked").each(function(){
      titulosArray.push($(this).val());
    });

    $.ajax({
      url: baseUrl + 'enviartitulosajax/EnviaTitulosParaIEPTB',
      data: {EnviaTitulosParaIEPTB: '', titulos: titulosArray},
      dataType: "JSON",
      type: "POST",
      beforeSend: function() {
        $.loader({
          className:"blue-with-image-2",
          content:'Aguarde, carregando dados.'
        }); 
      },
      complete: function(){
        $.loader('close');
      },
      success: function(data){
        
        console.log(data)

        itens = '';
        itens += '<table class="table">';
        itens += '<thead>';
        itens += '  <tr>';
        itens += '    <th scope="col">CNPJ Cliente</th>';
        itens += '    <th scope="col">Nosso Número</th>';
        itens += '    <th scope="col">Vencimento</th>';
        itens += '    <th scope="col">Sincronizado</th>';
        itens += '    <th scope="col">Mensagem</th>';
        itens += '  </tr>';
        itens += '</thead>';
        itens += '<tbody>';
        
        if(titulosArray.length > 1) {
          for (let i = 0; i < data.length; i++) {
            
            if(data[i].vCodigoMensagem == 'WS_SUC_201'){
              vSincronizar = 'Sim';
              vCorLinha = 'background: #dbf1e6;';
            } else {
              vSincronizar = 'Não';
              vCorLinha = 'background: #edd8d8;';
            }
  
            itens += '  <tr style="'+vCorLinha+'">';
            itens += '    <th scope="row">'+data[i].vDevedor+'</th>';
            itens += '    <td>'+data[i].vNossoNumero+'</td>';
            itens += '    <td>'+data[i].vVencimento+'</td>';
            itens += '    <td>'+vSincronizar+'</td>';
            itens += '    <td>'+data[i].vMensagem+'</td>';
            itens += '  </tr>';
          }
        } else {
          console.log('menor que 1');
            
            if(data.vCodigoMensagem == 'WS_SUC_201'){
              vSincronizar = 'Sim';
              vCorLinha = 'background: #dbf1e6;';
            } else {
              vSincronizar = 'Não';
              vCorLinha = 'background: #edd8d8;';
            }
  
            itens += '  <tr style="'+vCorLinha+'">';
            itens += '    <th scope="row">'+data.vDevedor+'</th>';
            itens += '    <td>'+data.vNossoNumero+'</td>';
            itens += '    <td>'+data.vVencimento+'</td>';
            itens += '    <td>'+vSincronizar+'</td>';
            itens += '    <td>'+data.vMensagem+'</td>';
            itens += '  </tr>';

        }

        
        itens += '</tbody>';
        itens += '</table>';

        $('#modalDetalhamentoRetornoEnvio').modal('show');
        $('#SpanConteudoModalDetalhamentoRetorno').html(itens);
        enviartitulos.initTabela(columnDefs, colOrdem);
      }
    });
  },
  carregaComboEndosso: function(cod = null){
    $("#cbEndosso").empty();
    $.post(baseUrl + 'enviartitulosajax/carregaEndosso', {carregaEndosso: ''}, function(j){
        if(j != null){
          for (var i = 0; i < j.length; i++) {
              $("#cbEndosso").append($('<option>', {
                value: j[i].vValue,
                text: j[i].vDesc,
                selected: function(){
                  if(cod != null){
                    if(j[i].vValue == cod){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        } 
        $("#cbEndosso")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboMotivo: function(cod = null){
    $("#cbMotivo").empty();
    $.post(baseUrl + 'enviartitulosajax/carregaMotivo', {carregaMotivo: ''}, function(j){
        if(j != null){
          for (var i = 0; i < j.length; i++) {
              $("#cbMotivo").append($('<option>', {
                value: j[i].vValue,
                text: j[i].vDesc,
                selected: function(){
                  if(cod != null){
                    if(j[i].vValue == cod){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        } 
        $("#cbMotivo")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboPortador: function(cod = null){
    $("#cbPortador").empty();
    $.post(baseUrl + 'enviartitulosajax/carregaPortador', {carregaPortador: ''}, function(j){
        if(j != null){
          for (var i = 0; i < j.length; i++) {
              $("#cbPortador").append($('<option>', {
                value: j[i].vValue,
                text: j[i].vDesc,
                selected: function(){
                  if(cod != null){
                    if(j[i].vValue == cod){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        } 
        $("#cbPortador")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboEspecie: function(cod = null){
    $("#cbEspecie").empty();
    $.post(baseUrl + 'enviartitulosajax/carregaEspecie', {carregaEspecie: ''}, function(j){
        if(j != null){
          for (var i = 0; i < j.length; i++) {
              $("#cbEspecie").append($('<option>', {
                value: j[i].vValue,
                text: j[i].vDesc,
                selected: function(){
                  if(cod != null){
                    if(j[i].vValue == cod){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        } 
        $("#cbEspecie")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  abrirModalAlterarConfiguracao: function() {
    //validar se tem titulos selecionados
    $("input:checkbox[name=titulosCheckbox]:checked").each(function(){
      titulosArray.push($(this).val());
    });

    $('#modalAlteracaoConfiguracaoTitulos').modal('show');
  },
  removeCheckbox: function() {
    $("input:checkbox[name=titulosCheckbox]:checked").each(function() {
      $(this).prop('checked', false);
    });
  },
  AtualizaInformacoesTitulos: function() {
    $.ajax({
      url: baseUrl + 'enviartitulosajax/AtualizaInformacoesTitulos',
      data: {AtualizaInformacoesTitulos: '',
             vEndosso: $('#cbEndosso').selectpicker('val'), 
             vMotivo: $('#cbMotivo').selectpicker('val'), 
             vAceite: $('#cbAceite').selectpicker('val'), 
             vPortador: $('#cbPortador').selectpicker('val'), 
             vEspecie: $('#cbEspecie').selectpicker('val'), 
             vTitulos: titulosArray},
      dataType: "JSON",
      type: "POST",
      beforeSend: function() {
        $.loader({
          className:"blue-with-image-2",
          content:'Aguarde, carregando dados.'
        }); 
      },
      complete: function(){
        $.loader('close');
      },
      error: function (){
        app.showNotification("Erro ao atualizar as informações do titulos.", 'danger', 5); 
      },
      success: function(data){
        app.showNotification("Títulos Alterados com Sucesso", 'success', 5); 
        titulosArray = [];
        enviartitulos.removeCheckbox();

        $('#modalAlteracaoConfiguracaoTitulos').modal('hide');
      }
    });
  }
}

