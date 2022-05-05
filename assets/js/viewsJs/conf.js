let vetorImagens = [];

conf = {
    initApp: function() {
      conf.getData();
      conf.carregaComboEstado();
      conf.carregaComboEndosso();
      conf.carregaComboMotivo();
      conf.carregaComboPortador();
      conf.carregaComboEspecie();
      conf.getComboCobrancas()

      var cpfMascara = function (val) {
        return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
     },
     cpfOptions = {
        onKeyPress: function(val, e, field, options) {
           field.mask(cpfMascara.apply({}, arguments), options);
        }
     };

     $('#edCpfCnpj').mask(cpfMascara, cpfOptions);
     conf.maskTelefone();

      $("#edImagens").filestyle({buttonText: "&nbsp;Carregar Imagens"});  
      $("#edImagens").filestyle('buttonName', 'btn-primary'); 
      $("#edImagens").filestyle({buttonBefore: true});

      var principal = "";
      var teste = 0;
      
      $('#edImagens').change(function(){
        Loader.open();
        var files = $('#edImagens')[0].files;
        var error = '';
        var form_data = new FormData();
    
        for(var count = 0; count<files.length; count++)
        {
         var name = files[count].name;
         var extension = name.split('.').pop().toLowerCase();
         var filesize = ((files[count].size/1024)/1024).toFixed(4); // MB
  
         if(filesize <= 1) {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            error += "Invalid " + count + " Image File"
          }
          else
          {
            form_data.append("edImagens[]", files[count]);
          }
        } else {
            error += "Invalid " + count + " Image File"
            app.showNotification("Imagem maior de que 1MB.", "danger", 5);
            Loader.close();
         }
  
        }
        if(error == '')
        {
          form_data.append('qtImagem',vetorImagens.length);
         $.ajax({
          url:baseUrl + "confajax/imageupload",
          method:"POST",
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          success:function(data)
          {
              $.map( data, function( val, i ) {
                vetorImagens.push(val)
              });
  
              Loader.close();
    
           conf.controlaPreview(vetorImagens);
           //$('#files').val('');
          }
         })
        }
        else
        {
         // alert(error);
        }
       });

      $('#edDataInicial, #edDataFinal').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', lang : 'pt-br', cancelText : 'Cancelar', time: false });
  
      $('#edCalendarioCampoData1').click(function(){
        $('#edDataInicial').focus();
      });
  
      $('#edCalendarioCampoData2').click(function(){
          $('#edDataFinal').focus();
        });
  
  
      },
  
      controlaPreview: function(v, n = null) {
   
        let preview = "";
        preview = '<br><center><div class="owl-carousel owl-theme" id="edPreviewImagens">';
        
        for(let i = 0; i < v.length; i++) {
            preview += '<div class="item">';
            preview +=      '<a href="javascript:conf.excluirPreview(\''+v[i].cod+'\', \''+v[i].url+'\');">';
            preview +=        '<img src="'+baseUrl+'assets/images/delete.png" style="width: 30px !important;" />';
            preview +=      '</a>';
            preview +=          '<img src="'+baseUrl+v[i].url+'">';
            preview += '</div>';
        }
        
        preview += "</div></center>";
        $('#previewFotosNoticia').html(preview);
    
        /*owl carousel*/
        $('#edPreviewImagens').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false
                }
            }
        }); 
    
    },
    getCobrancas() {
      $.post(baseUrl + 'Confajax/getCobrancas', {getCobrancas: ''}, function(j){
          if(j == true){
            app.showNotification('Cobranças salvas com sucesso', 'success', 5)
            conf.getComboCobrancas()
          } 
      }, "json")
    },
    getComboCobrancas: function(selecionado = null) {
      $("#cbCobranca").empty();
      $.post(baseUrl + 'Confajax/getComboCobrancas', {getComboCobrancas: ''}, function(j){
          if(j != null){
            for (var i = 0; i < j.length; i++) {
                $("#cbCobranca").append($('<option>', {
                  value: j[i].vId,
                  text: j[i].vId + ' - ' + j[i].vNome,
                  selected: function(){
                    if(selecionado != null){
                      if(j[i].vId == selecionado){
                        return true;
                      } 
                    }
                    return false;
                  }
                }));
            }
          } 
          $("#cbCobranca")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
      }, "json");
    },
    maskTelefone: function() {
      jQuery("#edTelefone1, #edTelefone2")
      .mask("(99) 9999-9999?9")
      .focusout(function (event) {  
          var target, phone, element;  
          target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
          phone = target.value.replace(/\D/g, '');
          element = $(target);  
          element.unmask();  
          if(phone.length > 10) {  
              element.mask("(99)9 9999-9999");  
          } else {  
              element.mask("(99) 9999-99999");  
          }  
      });
    },

    carregaComboEstado: function(codEstado = null){
        $("#cbEstado").empty();
        $.post(baseUrl + 'Confajax/carregaComboEstado', {carregaComboEstado: ''}, function(j){
            if(j != null){
              for (var i = 0; i < j.length; i++) {
                  $("#cbEstado").append($('<option>', {
                    value: j[i].vId,
                    text: j[i].vNome,
                    selected: function(){
                      if(codEstado != null){
                        if(j[i].vId == codEstado){
                          return true;
                        } 
                      }
                      return false;
                    }
                  }));
              }
            } 
            $("#cbEstado")
              .selectpicker('refresh')
              .closest(".form-group").addClass('is-focused').removeClass('is-empty');
        }, "json");
    },
    carregaComboCidade: function(idEstado, codCidade = null){
      
      $("#cbCidade").empty();
      $.post(baseUrl + 'Confajax/carregaComboCidade', {carregaComboCidade: '', idEstado: idEstado}, function(j){
          if(j != null){
            for (var i = 0; i < j.length; i++) {
                $("#cbCidade").append($('<option>', {
                  value: j[i].vId,
                  text: j[i].vNome,
                  selected: function(){
                    if(codCidade != null){
                      if(j[i].vId == codCidade){
                        return true;
                      } 
                    }
                    return false;
                  }
                }));
            }
          } 
          $("#cbCidade")
            .selectpicker('refresh')
            .closest(".form-group").addClass('is-focused').removeClass('is-empty');
      }, "json");
    },    

    carregaComboEndosso: function(cod = null){
      $("#cbEndosso").empty();
      $.post(baseUrl + 'Confajax/carregaEndosso', {carregaEndosso: ''}, function(j){
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
      $.post(baseUrl + 'Confajax/carregaMotivo', {carregaMotivo: ''}, function(j){
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
      $.post(baseUrl + 'Confajax/carregaPortador', {carregaPortador: ''}, function(j){
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
      $.post(baseUrl + 'Confajax/carregaEspecie', {carregaEspecie: ''}, function(j){
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

    excluirPreview: function(p, url) {
      vetorImagens = $.grep(vetorImagens, function(e) { return e.cod != p });
      //conf.excluiImagem(url);
    
      conf.controlaPreview(vetorImagens);
    },

    salvarConf: function($form) {
      if(conf.validaCampos()) {
        $.ajax({
          url: baseUrl + 'confajax/salvarConf',
          data: {salvarConf: '', Form: $("#formConf").serialize(), endosso: $('#cbEndosso').selectpicker('val'), motivo: $('#cbMotivo').selectpicker('val'), aceite: $('#cbAceite').selectpicker('val'), portador: $('#cbPortador').selectpicker('val'), especie: $('#cbEspecie').selectpicker('val'), cobranca: $('#cbCobranca').selectpicker('val'), imagens: vetorImagens},
          dataType: "JSON",
          type: "POST",
          error: function (){
            app.showNotification("Erro ao cadastrar.", 'danger', 5); 
          },
          success: function(data){
           if (data.result == 'OK') {
              app.showNotification("Configuração salva com sucesso.", "success", 5);
              setTimeout(() => {
                location.reload();realod
              }, 2000);
           }
          }
        });
      }
    },

    getData: function($form) {
      $.ajax({
        url: baseUrl + 'confajax/getData',
        data: {GetData: ''},
        dataType: "JSON",
        type: "POST",
        error: function (){
          app.showNotification("Erro ao buscar.", 'danger', 5); 
        },
        success: function(data){
          if (data.result !== null) {

          $('#edNome').val(data.nome).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edCpfCnpj').val(data.cpfcnpj).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edEndereco').val(data.endereco).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edTelefone1').val(data.telefone1).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edTelefone2').val(data.telefone2).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edAPI').val(data.api).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          conf.carregaComboEstado(data.estado);
          conf.carregaComboCidade(data.estado, data.cidade);
          $('#edClienteI7').val(data.idclientei7).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edProdI7').val(data.prodi7).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edDiasEnvioProtesto').val(data.diasenvioprotesto).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#ieptburl').val(data.webservice_ieptb_url).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#ieptbusuario').val(data.webservice_ieptb_usuario).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#ieptbsenha').val(data.webservice_ieptb_senha).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edTokenIeptb').val(data.token).closest(".form-group").addClass('is-focused').removeClass('is-empty');
          $('#edDataCriacaoToken').val(data.datatoken).closest(".form-group").addClass('is-focused').removeClass('is-empty');

        
          $("#cbAceite").selectpicker('val', [data.aceite]).closest(".form-group").removeClass('is-empty');

          conf.carregaComboEndosso(data.endosso);
          conf.carregaComboEspecie(data.especie);
          conf.carregaComboMotivo(data.motivo);
          conf.carregaComboPortador(data.portador);
          conf.getComboCobrancas(data.cobranca);


          $.map( data.logo, function( val, i ) {
            vetorImagens.push(val)
          });

          conf.controlaPreview(vetorImagens);


            /*
            'id'                     
            'nome'                   
            'cpfcnpj'                
            'endereco'               
            'cidade'                 
            'estado'                 
            'telefone1'              
            'telefone2'              
            'logo'                   
            'idclientei7'            
            'prodi7'                 
            'diasenvioprotesto'      
            'webservice_ieptb_url'   
            'webservice_ieptb_usuario
            'webservice_ieptb_senha' 
            'token'                  
            'datatoken'              
            */

          }
        }
      });
      
    },
  
    getToken: function() {
  
      $.ajax({
        url: baseUrl + 'Titulosajax/getToken',
        data: {GetToken: ''},
        dataType: "JSON",
        type: "POST",
        error: function (){
          app.showNotification("Erro ao buscar.", 'danger', 5); 
        },
        success: function(data){
          console.log(data);
        }
      });
  
    },
  
    // Função para trazer notícias cadastradas na tabela
    initTabela: function(columnDefs, colOrdem) {

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
                                  data: {CarregaTitulos: ""},
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
    },
  
    scrollPage:function(element) {
      $('.main-panel').animate({scrollTop:$(element).offset().top}, 1000);
    },


    validaCampos() {
      if($('#edNome').val() == '') {
        app.showNotification("Informe o nome.", 'danger', 5);
        return false;
      }

      if($('#edCpfCnpj').val() == '') {
        app.showNotification("Informe o cpf/cnpj.", 'danger', 5);
        return false;
      }

      if($('#edEndereco').val() == '') {
        app.showNotification("Informe o endereço.", 'danger', 5);
        return false;
      }

      if($('#cbEstado').selectpicker('val') == '') {
        app.showNotification("Informe o estado.", 'danger', 5);
        return false;
      }

      if($('#cbCidade').selectpicker('val') == '') {
        app.showNotification("Informe a cidade.", 'danger', 5);
        return false;
      }

      if($('#edTelefone1').val() == '') {
        app.showNotification("Informe pelo menos um telefone.", 'danger', 5);
        return false;
      }

      if(vetorImagens.length === 0) {
        app.showNotification("Faça upload de uma logo.", 'danger', 5);
        return false;
      }

      if($('#edCliente').val() == '') {
        app.showNotification("Informe o id do Cliente I7.", 'danger', 5);
        return false;
      }    
      return true;  
    }
    
  }
  
  