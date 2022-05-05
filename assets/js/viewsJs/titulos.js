
//titulos a serem baixados

let titulosArray = [];
let titulosPagos = [];

//titulos a serem cancelados

let titulosArray_Cancel = [];
let titulosProtestados = [];

titulos = {
  initApp: function() {

    
    $('#cbFilial').selectpicker('val', 'null');

    $('#modal').modal().on('shown', function(){
      $('body, .wrapper, .main-panel').css('overflow', 'hidden', 'important');
    }).on('hidden', function(){
      $('body, .wrapper, .main-panel').css('overflow', 'auto', 'important');
    })


    $('#edDataInicial, #edDataFinal').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', lang : 'pt-br', cancelText : 'Cancelar', time: false });

    $('#edCalendarioCampoData1').click(function(){
      $('#edDataInicial').focus();
    });

    $('#edCalendarioCampoData2').click(function(){
      $('#edDataFinal').focus();
    });

    titulos.carregaComboFilial();
    titulos.carregaComboCliente();
    titulos.carregaComboStatusTitulo();
    titulos.carregaComboPracaCobranca();
    titulos.carregaComboVendedores();
    titulos.comboUsuariosWinthor();
    titulos.comboMoeda();
    titulos.comboCaixa();
  },
  scrollPage:function(element) {
    $('.main-panel').animate({scrollTop:$(element).offset().top}, 1000);
  },
  getCaixasMoedas() {
    $.post(baseUrl + 'Titulosajax/getCaixasMoedas', {getCaixasMoedas: ''}, function(j){
        if(j == true){
          app.showNotification('Caixas e moedas salvas com sucesso', 'success', 5)
          titulos.comboMoeda();
          titulos.comboCaixa();
        } 
    }, "json")
  },
  atualizarStatus: function() {
    $.ajax({
      url: baseUrl + 'Titulosajax/atualizarStatus',
      data: {AtualizarStatus: ''},
      dataType: "JSON",
      type: "POST",
      beforeSend: function() {
      $.loader({
          className:"blue-with-image-2",
          content:'Aguarde, atualizando dados.'
      }); 
      },
      complete: function(){
        $.loader('close');
      },
      success: function(data){}
    });
  },
  BuscaDadoECarregaTabela: function(columnDefs, colOrdem) {
    // carrega filtros da tela
    let vFilial      = $('#cbFilial').val();
    let vCliente     = $('#cbCliente').val();
    let vStatus      = $('#cbStatus').val();
    let vPracaCob    = $('#cbPracaCobranca').val();
    let vTipoData         = $('#cbTipoData').selectpicker('val');
    let vDataInicial = $('#edDataInicial').val();
    let vDataFinal   = $('#edDataFinal').val();

    if(titulos.validaCamposConsulta()){
      $('#tabela').dataTable().fnDestroy();
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
                                url: baseUrl + 'Titulosajax/carregaTitulos',
                                data: {CarregaTitulos: "",
                                      vFilial: vFilial,
                                      vCliente: vCliente,
                                      vStatus: vStatus,
                                      vTipoData: vTipoData,
                                      vDataInicial: vDataInicial,
                                      vDataFinal: vDataFinal },
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

      if(colOrdem.length > 0){
        tabela.order(colOrdem).draw();
      }

      $("#divApresentacaoTitulos").css("display", "block");
    }
  },
  carregaComboFilial: function(){
    $("#cbFilial").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboFilial', {CarregaComboFilial: ''}, function(j){
        if(j != null){
          $("#cbFilial").append($('<option>', {
            value: 'null',
            text: 'Todas as Filiais',
            selected: function(){
              return true;
            }
          }));
          for (var i = 0; i < j.length; i++) {
              $("#cbFilial").append($('<option>', {
                value: j[i].vIdFilial,
                text: j[i].vNomeFilial
              }));
          }
        } 
        $("#cbFilial")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboCliente: function(){
    $("#cbCliente").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboCliente', {CarregaComboCliente: ''}, function(j){
        if(j != null){
          $("#cbCliente").append($('<option>', {
            value: 'null',
            text: 'Todos os Clientes'
          }));
          for (var i = 0; i < j.length; i++) {
              $("#cbCliente").append($('<option>', {
                value: j[i].vIdCliente,
                text: j[i].vNomeCliente
              }));
          }
        } 
        $("#cbCliente")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboStatusTitulo: function(){
    $("#cbStatus").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboStatusTitulo', {CarregaComboStatusTitulo: ''}, function(j){
        if(j != null){
          $("#cbStatus").append($('<option>', {
            value: 'null',
            text: 'Todos os Titulos'
          }));
          for (var i = 0; i < j.length; i++) {
              $("#cbStatus").append($('<option>', {
                value: j[i].vIdStatus,
                text: j[i].vNomeStatus
              }));
          }
        } 
        $("#cbStatus")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboPracaCobranca: function(){
    $("#cbPracaCobranca").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboPracaCobranca', {CarregaComboPracaCobranca: ''}, function(j){
        if(j != null){
          $("#cbPracaCobranca").append($('<option>', {
            value: 'null',
            text: 'Todas as Praças'
          }));
          for (var i = 0; i < j.length; i++) {
              $("#cbPracaCobranca").append($('<option>', {
                value: j[i].vIdPracaCobranca,
                text: j[i].vNomePracaCobranca
              }));
          }
        } 
        $("#cbPracaCobranca")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  carregaComboVendedores: function(){
    $("#cbVendedor").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboVendedores', {CarregaComboVendedores: ''}, function(j){
        if(j != null){
          $("#cbVendedor").append($('<option>', {
            value: 'null',
            text: 'Todos os Vendedores'
          }));
          for (var i = 0; i < j.length; i++) {
              $("#cbVendedor").append($('<option>', {
                value: j[i].vIdVendedor,
                text: j[i].vNomeVendedor
              }));
          }
        } 
        $("#cbVendedor")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  LimparDadosTela: function(){
    
    $('#cbFilial').selectpicker('val', 'null');
    $('#cbCliente').selectpicker('val', 0);
    $('#cbStatus').selectpicker('val', 0);
    $('#cbPracaCobranca').selectpicker('val', 0);
    $('#cbVendedor').selectpicker('val', 0);

    $('#edDataInicial').val('');
    $('#edDataFinal').val('');
    
    $("#divApresentacaoTitulos").css("display", "none");
  },
  validaCamposConsulta: function(){

  	if($('#edDataInicial').val() == '') {
      app.showNotification("Informe a data inicial", 'danger', 2);
      $("#edDataInicial").focus();
      return false; 
    }

    if($('#edDataFinal').val() == '') {
      app.showNotification("Informe a data final", 'danger', 2);
      $("#edDataFinal").focus();
      return false; 
    }
    return true;
  },
  EnviaTitulosParaIEPTB: function(id) {
    let titulos = 0;
    $.ajax({
      url: baseUrl + 'Titulosajax/EnviaTitulosParaIEPTB',
      data: {EnviaTitulosParaIEPTB: '', titulos: titulos},
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
        console.log(data);
      }
    });
  },
  modalInfo: function(id) {
    $.ajax({
      url: baseUrl + 'Titulosajax/modalInfo',
      data: {ModalInfo: '', id},
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
        $('#modalInfo').modal('show');
        $('#nossoNumeroH').html(data[0].vNossoNumero);
        $('#numeroH').html(data[0].vNumero);
        $('#statusPagamentoH').html(data[0].vStatusieptb);
        $('#devedor').html(data[0].vClienteNome);
        $('#docDevedor').html(data[0].vClienteCPFCNPJ);
        $('#juroDivida').html('R$ ' + data[0].vJuro);
        $('#multaDivida').html('R$ ' + data[0].vMulta);

        // Sacador / Filial 

        $('#nomeSacador').html(data[0].vFilialNome);
        $('#enderecoSacador').html(data[0].vFilialEndereco);
        $('#cidadeSacador').html(data[0].vFilialCidade);
        $('#documentoSacador').html(data[0].vFilialCNPJ);
        $('#ufSacador').html(data[0].vFilialUF);
        $('#cepSacador').html(data[0].vFilialCep);
        
        // Devedor / Cliente

        $('#nomeDevedor').html(data[0].vClienteNome);
        $('#enderecoDevedor').html(data[0].vClienteEndereco);
        $('#cidadeDevedor').html(data[0].vClienteCidade);
        $('#bairroDevedor').html(data[0].vClienteBairro);
        $('#emailDevedor').html(data[0].vClienteEmail);
        $('#documentoDevedor').html(data[0].vClienteCPFCNPJ);
        $('#ufDevedor').html(data[0].vClienteUF);
        $('#foneDevedor').html(data[0].vClienteTelefone);

        // Divida 

        $('#numeroDivida').html(data[0].vNumero);
        $('#nossoNumero').html(data[0].vNossoNumero);
        $('#valorDivida').html('R$ ' + data[0].vValor);
        $('#saldoDivida').html('R$ ' + data[0].vSaldo);
        $('#emissaoDivida').html(data[0].vDataEmissao);
        $('#vencimentoDivida').html(data[0].vDataVencimento);
        $('#especieDivida').html(data[0].vEspecie);
        $('#endossoDivida').html(data[0].vEndosso);
        $('#motivoDivida').html(data[0].vMotivo);
        $('#aceiteDivida').html(data[0].vAceite);
        $('#declaracaoDivida').html(data[0].vPortador);

        // Baixa

        $('#dataBaixa').html(data[0].vDataBaixaWinthor);
        $('#usuarioBaixa').html(data[0].vUsuarioBaixa);
        $('#caixaBaixa').html(data[0].vCaixaBaixa);
        $('#moedaBaixa').html(data[0].vMoedaBaixa);

      }
    });
  },
  verificaPago: function() {
    titulosArray = [];
    titulosPagos = [];

    $("input:checkbox[name=titulosCheckbox]:checked").each(function(){
      titulosArray.push($(this).val());

      let esseTitulo = $(this).val();
    
      $.ajax({
        url: baseUrl + 'titulosajax/isPago',
        data: {IsPago: '', id: $(this).val()},
        dataType: "JSON",
        type: "POST",
        beforeSend: function() {
        $.loader({
            className:"blue-with-image-2",
            content:'Aguarde, verificando dados.'
        }); 
        },
        complete: function(){
          $.loader('close');
        },
        success: function(data){
          if(data !== null) {
            if(data.status == 'PA') {
              titulosPagos.push(esseTitulo);

              if(!$('#modalBaixa').hasClass('show')) {
                $('#modalBaixa').modal('show');
              }

            } else {
              app.showNotification('O título '+data.nome+' - '+data.duplicata + ' não pode ser baixado', 'danger', 5);
            }

          } else {
             app.showNotification('Título não pode ser baixado', 'danger', 3);
          }
        }
      });
      
    });

  },
  comboUsuariosWinthor: function() {

    $("#cbUsuarioWinthor").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboUsuariosWinthor', {CarregaComboUsuariosWinthor: ''}, function(j){
        if(j != null){
          for (var i = 0; i < j.length; i++) {
              $("#cbUsuarioWinthor").append($('<option>', {
                value: j[i].vIdWinthor,
                text: j[i].vNomeWinthor
              }));
          }
        } 
        $("#cbUsuarioWinthor")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
    
  },
  comboMoeda: function() {

    $("#cbMoeda").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboMoeda', {CarregaComboMoeda: ''}, function(j){
        if(j != null){
          // $("#cbMoeda").append($('<option>', {
          //   value: 0,
          //   text: 'Todas as Praças'
          // }));
          for (var i = 0; i < j.length; i++) {
              $("#cbMoeda").append($('<option>', {
                value: j[i].vId,
                text: j[i].vNome
              }));
          }
        } 
        $("#cbMoeda")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
    
  },
  comboCaixa: function() {

    $("#cbCaixa").empty();
    $.post(baseUrl + 'Titulosajax/carregaComboCaixa', {CarregaComboCaixa: ''}, function(j){
        if(j != null){
          // $("#cbCaixa").append($('<option>', {
          //   value: 0,
          //   text: 'Todas as Praças'
          // }));
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
  baixarWinthor: function() {
    let usuario = $('#cbUsuarioWinthor').val();
    let caixa = $('#cbCaixa').val();
    let moeda = $('#cbMoeda').val();

    let usuarioNome = $("#cbUsuarioWinthor :selected").text();
    let caixaNome = $("#cbCaixa :selected").text();
    let moedaNome = $("#cbMoeda :selected").text();

    $.post(baseUrl + 'Titulosajax/baixarWinthor', {BaixarWinthor: '', usuario, usuarioNome, caixaNome, moedaNome, caixa, moeda, titulosPagos}, function(j){
      if(j > 0){
        app.showNotification('Baixado(s) com sucesso!', 'success', 5);
        titulosPagos = [];
        titulosArray = [];
        titulos.removeCheckbox();

        $('#modalBaixa').modal('hide');
      }
  }, "json");


  },
  validaCamposBaixar: function() {
  	
    if($('#cbUsuarioWinthor').val() == '') {
      app.showNotification("Informe o usuário", 'danger', 2);
      $("#cbUsuarioWinthor").focus();
      return false; 
    }

  	if($('#cbCaixa').val() == '') {
      app.showNotification("Informe o caixa", 'danger', 2);
      $("#cbCaixa").focus();
      return false; 
    }  

  	if($('#cbMoeda').val() == '') {
      app.showNotification("Informe a moeda", 'danger', 2);
      $("#cbMoeda").focus();
      return false; 
    }  

    return true;

  },
  removeCheckbox: function() {
    $("input:checkbox[name=titulosCheckbox]:checked").each(function() {
      $(this).prop('checked', false);
    });
  },
  verificaProtestado: function() {
    titulosArray_Cancel = [];
    titulosProtestados  = [];

    $("input:checkbox[name=titulosCheckbox]:checked").each(function(){
      titulosArray_Cancel.push($(this).val());

      let esseTitulo = $(this).val();
    
      $.ajax({
        url: baseUrl + 'titulosajax/isPago',
        data: {IsPago: '', id: $(this).val()},
        dataType: "JSON",
        type: "POST",
        beforeSend: function() {
        $.loader({
            className:"blue-with-image-2",
            content:'Aguarde, verificando dados.'
        }); 
        },
        complete: function(){
          $.loader('close');
        },
        success: function(data){
          if(data !== null) {
            if(data.status == 'PR') {
              titulosProtestados.push(esseTitulo);

              titulos.cancelaProtesto();

            } else {
              app.showNotification('O título '+data.nome+' - '+data.duplicata + ' não pode ser cancelado', 'danger', 5);
            }

          } else {
             app.showNotification('Título não encontrado', 'danger', 3);
          }
        }
      });
      
    });

  },
  cancelaProtesto: function() {
    $.post(baseUrl + 'Titulosajax/cancelaProtesto', {CancelaProtesto: '', titulosProtestados}, function(j){
      if(j.rows > 0){
        app.showNotification('Cancelado(s) com sucesso!', 'success', 5);
        titulosProtestados = [];
        titulosArray_Cancel = [];
        titulos.removeCheckbox();
      } else {

        for(let i = 0; i<j.error.length; i++) {
          app.showNotification('Título - '+j.error[i].nome+' - '+j.error[i].duplicata+' não encontrado!', 'danger', 5);
        }

      }
    }, "json");
  },

  buscaStatusTitulos: function() {
    let titulos = 0;
    $.ajax({
      url: baseUrl + 'Titulosajax/buscaStatusTitulos',
      data: {buscaStatusTitulos: ''},
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
        
      }
    });
  },
  selecionarTudo: function() {
    $("input[name='titulosCheckbox']").prop('checked', true);
  },
}