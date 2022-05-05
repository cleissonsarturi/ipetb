usuarios = {
  initTabelaUsuarios: function(columnDefs, colOrdem) {
    $('#tabelaUsuarios').dataTable().fnDestroy();
    tabelaUsuarios =  $('#tabelaUsuarios').DataTable({
                            "language":{
                                url: 'assets/js/pt-br_datatables.js'
                            },
                            serverSide: true,
                            processing: true,
                            responsive: true,
                            info: true,
                            stateSave: true,
                            ajax: {
                              url: baseUrl + 'usuariosajax/carregaUsuarios',
                              data: {CarregaUsuarios: ""},
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
        tabelaUsuarios.order(colOrdem).draw();
      }
  },
  initConfigTela: function(){
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    $('#btnExcluirUsuario').attr("disabled", true);
    usuarios.carregaComboGrupos();
  },
  scrollPage:function(element) {
    $('.main-panel').animate({scrollTop:$(element).offset().top}, 1000);
  },
  carregaComboGrupos: function(codGrupo = null){
    $("#cbGrupoUsuario").empty();
    $.post(baseUrl + 'usuariosajax/carregaComboGrupos', {CarregaComboGrupos: ''}, function(j){
        if(j != null){
          for (var i = 0; i < j.length; i++) {
              $("#cbGrupoUsuario").append($('<option>', {
                value: j[i].vIdGrupo,
                text: j[i].vNomeGrupo,
                selected: function(){
                  if(codGrupo != null){
                    if(j[i].vIdGrupo == codGrupo){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        } 
        $("#cbGrupoUsuario")
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
    }, "json");
  },
  salvarCadastro: function(form) {
    if(usuarios.validaCampos()){
        $('#edResponsavelUsuario').attr("disabled", false);
        $.ajax({
          url: baseUrl + 'usuariosajax/salvaUsuario',
          data: {SalvaUsuario: '', Form: form, responsavel: $('#edResponsavelUsuario').val()},
          dataType: "JSON",
          type: "POST",
          beforeSend: function() {
            $.loader({
                className:"blue-with-image-2",
                content:'Aguarde, salvando dados.'
            }); 
          },
          error: function (){
            app.showNotification('Erro ao cadastrar', 'danger', 2);
          },
          complete: function(){
            $.loader('close');
          },
          success: function(data){
            if (data.result == "OK") {
                app.showNotification('Dados salvos com sucesso', 'success', 2);
            }
            usuarios.limpaAtivaCamposUsuarios();
          }
        });
    }

  },
  carregaDadosUsuario: function(id) {
      $.ajax({
        url: baseUrl + 'usuariosajax/carregaDadosUsuario',
        data: {DadosUsuario: '', usuario: id},
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
          usuarios.scrollPage($("#edNomeUsuario"));
          $("#edCodigo").val(id);
          $("#edEditar").val("S");
          $('#btnExcluirUsuario').attr("disabled", false);
          usuarios.carregaComboGrupos(data.vPerfil);
          $("#edNomeUsuario").val(data.vNome).closest(".form-group").removeClass('is-empty');
          $("#edEmailUsuario").val(data.vEmail).closest(".form-group").removeClass('is-empty');
          $("#edLoginUsuario").val(data.vUsuario).closest(".form-group").removeClass('is-empty');
          $("#edSenhaUsuario").val(data.vSenha).closest(".form-group").removeClass('is-empty');
          $("#edConfirmaSenhaUsuario").val(data.vSenha).closest(".form-group").removeClass('is-empty');
          $("#edResponsavelUsuario").val(data.vResponsavel).closest(".form-group").removeClass('is-empty');
          $("#edIdWinthor").val(data.vIdWinthor).closest(".form-group").removeClass('is-empty');
          $("#cbGrupoUsuario").selectpicker('val', [data.vPerfil]);
          $("#cbSituacaoUsuario").selectpicker('val', [data.vSituacao]);
          $("#cbAlterarSenhaUsuario").selectpicker('val', [data.vTrocaSenha]);
        }
      });
  },
  excluiUsuario: function(codUsuario) {
    if(codUsuario > 0){
      bootbox.confirm({
          title: "Atenção",
          message: "Deseja realmente excluir?",
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
                  url: baseUrl + 'usuariosajax/excluiUsuario',
                  data: {ExcluiUsuario: '', codUsuario: codUsuario},
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
                      app.showNotification('Usuário excluído com sucesso', 'success', 2);
                    }
                    usuarios.limpaAtivaCamposUsuarios();
                  }
                });  
              }
          }
      });
    }
  },
  limpaAtivaCamposUsuarios: function() {
      $('#formUsuarios').each (function(){
        this.reset();
        $("#formUsuarios .form-group").removeClass('is-focused').addClass('is-empty');
      });
      $("#edResponsavelUsuario")
        .val(responsavel).closest(".form-group").removeClass('is-empty')
        .attr("disabled", true);
      $('#btnExcluirUsuario').attr("disabled", true);

      $('#cbAlterarSenhaUsuario, #cbSituacaoUsuario')
          .selectpicker('render')
          .selectpicker('refresh')
          .closest(".form-group").addClass('is-focused').removeClass('is-empty');
      
      $("#edEditar").val("N");
      $("#edCodigo").val("");
      usuarios.carregaComboGrupos();
      tabelaUsuarios.ajax.reload();
  },
  validaCampos: function() {
    if($("#edNomeUsuario").val() == ''){
        app.showNotification("Informe o Nome do Usuário", 'danger', 2);
        $("#edNomeUsuario").focus();
        return false; 
    }

    if($("#edEmailUsuario").val() == ''){
        app.showNotification("Informe um E-mail", 'danger', 2);
        $("#edEmailUsuario").focus();
        return false;    
    }

    if(!$("#cbGrupoUsuario").selectpicker('val')){
        app.showNotification("Selecione o Grupo de Usuário", 'danger', 2);
        $("#cbGrupoUsuario")
          .selectpicker('toggle')
          .selectpicker('render');
        return false;    
    }

    if($("#edLoginUsuario").val() == ''){
        app.showNotification("Informe o Login do Usuario", 'danger', 2);
        $("#edLoginUsuario").focus();
        return false;    
    }

    if($("#edSenhaUsuario").val() == ''){
        app.showNotification("Informe uma Senha para o Usuario", 'danger', 2);
        $("#edSenhaUsuario").focus();
        return false;    
    }

    if($("#edConfirmaSenhaUsuario").val() == ''){
        app.showNotification("Confirme a Senha informada", 'danger', 2);
        $("#edConfirmaSenhaUsuario").focus();
        return false;    
    }

    var senha         = $("#edSenhaUsuario").val();
    var confirmaSenha = $("#edConfirmaSenhaUsuario").val();

    if (senha != confirmaSenha) {
      $('#edConfirmaSenhaUsuario').css("border-color", "red").focus();
      app.showNotification("Senhas não conferem", 'danger', 2);
      setTimeout(function() {
        $('#edConfirmaSenhaUsuario').css("border-color", "#337ab7");
      }, 5000);
      return false;

    }

  if($("#edEmailUsuario").val() != ''){
      var re_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
      if(!re_email.test($("#edEmailUsuario").val())){
        app.showNotification("Email inválido", 'danger', 2);
        $("#edEmailUsuario").focus();
        return false; 
      }
    }  

    return true;
  }
}