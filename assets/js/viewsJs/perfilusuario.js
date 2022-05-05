grupos = {
    initTabelaGruposUsuarios: function(columnDefs, colOrdem) {
      $('#tabelaGrupoUsuario').dataTable().fnDestroy();
      tabelaGrupoUsuario =  $('#tabelaGrupoUsuario').DataTable({
                                  "language":{
                                     url: baseUrl + 'assets/js/pt-br_datatables.js'
                                  },
                                  serverSide: true,
                                  processing: true,
                                  responsive: true,
                                  info: true,
                                  stateSave: true,
                                  ajax: {
                                    url: baseUrl + 'perfilusuarioajax/carregaGruposUsuarios',
                                    data: {CarregaGruposUsuarios: ""},
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
          tabelaGrupoUsuario.order(colOrdem).draw();
        }
    },
    initConfigTela: function(){
      $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    },
    scrollPage:function(element) {
      $('.main-panel').animate({scrollTop:$(element).offset().top}, 1000);
    },
    carregaPermissoes: function(CodPerfil, open = true) {
      $('#ConteudoModalGruposUsuarios').html("");
      $.ajax({
          url : baseUrl + 'perfilusuarioajax/carregaPermissoes',
          data: {CarregarModalPerfis:'', CodPerfil: CodPerfil},
          dataType: "json",
          type: "POST",
          success: function(data){
            
            $('#ConteudoModalGruposUsuarios').html(data);
            if(open){
              $('#modalGruposUsuarios').modal({
                  show: 'false'
              }); 
            }
          }
      });
    },
   ativaDesativaPermissao: function(codigoTelaMenu, codigoPerfil, tipo) {
      var idElemento = (tipo) ? 'menu' : 'tela';
      if( $('#' + idElemento + codigoTelaMenu).is(':checked') ){
        var vCampoSelecionado = "S";
      } else{
        var vCampoSelecionado = "N";
      }

      $.ajax({
            url : baseUrl + 'perfilusuarioajax/autalizaPermissao',
            data: {AtivaDesativaPermissao:'', codigoPerfil: codigoPerfil, codigoTelaMenu: codigoTelaMenu, tipo: tipo, vCampoSelecionado: vCampoSelecionado},
            dataType: "json",
            type: "POST",
            error: function (){
              app.showNotification('Erro ao alterar permissão', 'danger', 2);
            },
            success: function(data){
              if(data.result == "OK"){
                app.showNotification('Permissão alterada', 'success', 2);
                if(tipo){
                  grupos.carregaPermissoes(codigoPerfil, false);
                }
              }
            }
        });
    },
    salvarCadastro: function(form) {

      if(grupos.validaCampos()){
          $.ajax({
            url: baseUrl + 'perfilusuarioajax/salvaGrupos',
            data: {SalvaGrupo: '', Form: form},
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
             grupos.limpaAtivaCamposGrupos();
            }
          });
      }

    },
    carregaGrupoCampo: function(id, nome) {
        grupos.scrollPage($("#edNomeGrupo"));
        $("#edCodigo").val(id);
        $("#edEditar").val("S");
        $("#edNomeGrupo").val(nome).closest(".form-group").addClass('is-focused').removeClass('is-empty');
    },
    excluirPerfilUsuario: function(id) {
      if(id > 0){
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
                    url: baseUrl + 'perfilusuarioajax/excluiPerfil',
                    data: {ExcluiPerfil: '', CodPerfil: id},
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
                    error: function (){
                      app.showNotification('Erro ao deletar perfil', 'danger', 2);
                    },
                    success: function(data){
                      if (data.result == "OK") {
                        app.showNotification('Grupo excluído com sucesso', 'success', 2);
                      }else if(data.result == "N"){
                        app.showNotification('Não é possível excluir. <br> Há usuários vinculados a esse Grupo', 'danger', 2);
                      }
                      grupos.limpaAtivaCamposGrupos();
                    }
                  });  
                }
            }
        });
      }
    },
    limpaAtivaCamposGrupos: function() {
        $('#formGrupo').each (function(){
          this.reset();
          $("#formGrupo .form-group").removeClass('is-focused').addClass('is-empty');
        });
        
        $("#edEditar").val("N");
        $("#edCodigo").val("");
        tabelaGrupoUsuario.ajax.reload();
    },
    validaCampos: function() {
      if($("#edNomeGrupo").val() == ''){
          app.showNotification("Informe o Nome do Grupo", 'danger', 5);
          $("#edNomeGrupo").focus();
          return false; 
      }

      return true;
    }
}