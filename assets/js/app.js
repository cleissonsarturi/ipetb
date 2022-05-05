app = { 
  showNotification: function(message, type, time) {

      $.notify({
          icon: "notifications",
          message: message
      }, {
          z_index: 9999,
          type: type,
          timer: time * 1000,
          placement: {
              from: 'top',
              align: 'right'
          }
      });
  },
  verificaNotificacao: function() {
    $("ul.itensNotificacoes .notficDropSoliticacoes ul li").remove();
    $("ul.itensNotificacoes .notficDropAvisos ul li").remove();
    $("ul.itensNotificacoes span").remove();

    $.post(baseUrl + 'appajax/buscaNotificacoes', {Notificacoes: ''}, function(j){
        if(j != null){
          $("ul.itensNotificacoes .notficDropSoliticacoes ul").append(['<span class="notification">'].join(''));
          var totalSolicitacoesNL = 0;
          var totalAvisosNL       = 0;
          var contS               = 0;
          var contA               = 0;
          for (var i = 0; i < j.length; i++) {
            if(j[i].vNotTipo == 'S'){
              if(j[i].vNotLida == "N"){
                totalSolicitacoesNL++;
              }
              $("ul.itensNotificacoes .notficDropSoliticacoes ul")
                .append([
                    '<li>',
                      '<span class"text-muted" style="font-size:10px; float: right; margin-right:15px;">'+ j[i].vNotDataHora +'</span>',
                      (j[i].vNotLida == "S") ? '<span class"text-muted" style="font-size:10px; float:left; margin-left:15px; cursor:pointer;" onclick="app.atualizaNotificacaoLerNaoLerExcluir('+ j[i].vNotId +',\'N\')"><i class="iconAction fa fa-undo"></i>Não lida</span>' : '',
                      '<span class"text-muted" style="font-size:10px; float:left; margin-left:15px; cursor:pointer;" onclick="app.atualizaNotificacaoLerNaoLerExcluir('+ j[i].vNotId +',\'S\',\''+ '' +'\',\'S\')"><i class="iconAction fa fa-close"></i>Excluir</span>',
                      '<a href="#" class="notfic" onclick="app.atualizaNotificacaoLerNaoLerExcluir('+ j[i].vNotId +',\'S\',\''+ j[i].vNotDireciona +'\')">',
                        ((j[i].vNotLida == "S") ? '<i class="fa fa-envelope-open-o" style="color:#17bcd0;" aria-hidden="true"></i> ' : '<i class="fa fa-envelope-o" style="color:#f44336;" aria-hidden="true"></i> ') + j[i].vNotDesc,
                      '</a>',
                    '</li>'
                ].join(''));
              contS++;
            }else{
              if(j[i].vNotLida == "N"){
                totalAvisosNL++;
              }
              $("ul.itensNotificacoes .notficDropAvisos ul")
                .append([
                    '<li>',
                      '<span class"text-muted" style="font-size:10px; float: right; margin-right:15px;">'+ j[i].vNotDataHora +'</span>',
                      (j[i].vNotLida == "S") ? '<span class"text-muted" style="font-size:10px; float:left; margin-left:15px; cursor:pointer;" onclick="app.atualizaNotificacaoLerNaoLerExcluir('+ j[i].vNotId +',\'N\')"><i class="iconAction fa fa-undo"></i>Não lida</span>' : '',
                      '<span class"text-muted" style="font-size:10px; float:left; margin-left:15px; cursor:pointer;" onclick="app.atualizaNotificacaoLerNaoLerExcluir('+ j[i].vNotId +',\'S\',\''+ '' +'\',\'S\')"><i class="iconAction fa fa-close"></i>Excluir</span>',
                      '<a href="#" class="notfic" onclick="app.atualizaNotificacaoLerNaoLerExcluir('+ j[i].vNotId +',\'S\',\''+ j[i].vNotDireciona +'\')">',
                        ((j[i].vNotLida == "S") ? '<i class="fa fa-envelope-open-o" style="color:#17bcd0;" aria-hidden="true"></i> ' : '<i class="fa fa-envelope-o" style="color:#f44336;" aria-hidden="true"></i> ') + j[i].vNotDesc,
                      '</a>',
                    '</li>'
                ].join('')); 
              contA++;     
            }
          }

          if(totalSolicitacoesNL > 0 && contS > 0){
            $("ul.itensNotificacoes .notficDropSoliticacoes a.dropdown-toggle").append(['<span class="notification">'+ totalSolicitacoesNL +'</span>'].join(''));
            if(contS > 3){
               $("ul.itensNotificacoes .notficDropSoliticacoes ul").css('height', '350px');
            }
          }else if(totalSolicitacoesNL == 0 && contS == 0){
            $("ul.itensNotificacoes .notficDropSoliticacoes ul").append(['<li><a href="#" class="notfic">Sem solicitações</a></li>'].join('')); 
          }

          if(totalAvisosNL > 0 && contA > 0){
            $("ul.itensNotificacoes .notficDropAvisos a.dropdown-toggle").append(['<span class="notification">'+ totalAvisosNL +'</span>'].join(''));
            if(contA > 3){
               $("ul.itensNotificacoes .notficDropAvisos ul").css('height', '350px');
            }
          }else if(totalAvisosNL == 0 && contA == 0){
            $("ul.itensNotificacoes .notficDropAvisos ul").append(['<li><a href="#" class="notfic">Sem notificações</a></li>'].join(''));
          }

        }else{
          $("ul.itensNotificacoes .notficDropSoliticacoes ul").append(['<li><a href="#" class="notfic">Sem solicitações</a></li>'].join('')); 
          $("ul.itensNotificacoes .notficDropAvisos ul").append(['<li><a href="#" class="notfic">Sem notificações</a></li>'].join('')); 
        }
    }, "json");
  },
  atualizaNotificacaoLerNaoLerExcluir: function(cod, lerNaoler, linkDireciona = '', excluir = 'N') {
    $.post(baseUrl + 'appajax/atualizaStatusNotificacao', {Notificacao: '', codNotificacao: cod, lerNaoler: lerNaoler, excluir: excluir}, function(data){
      if(data.result == "OK"){
        app.verificaNotificacao();
        setTimeout(function(){
          if(linkDireciona != ''){
            window.location = baseUrl + linkDireciona;
          }
        }, 100);
      }
    }, "json");
  },
  initApp: function(){

    //Controle para o scroll ficar dentro das notificações e não na página.
    $('ul.itensNotificacoes .notficDropAvisos ul, ul.itensNotificacoes .notficDropSoliticacoes ul').mouseover(function() {
        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
    }).mouseout(function() {
        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
    });

    $('.et').on('click', function() {
      $(this).parent().parent().siblings('.etapas-select').slideToggle( "fast", function() {
      });
    });

    $('.et-info-button').hover(function() {
      $(this).parent().parent().siblings('.et-info').fadeIn();
    }, 
    function() {
      $(this).parent().parent().siblings('.et-info').fadeOut();
    });

    //Controla active li do menu pessoas.
    $('.sidebar-wrapper ul.nav li a.firstA').click(function() {
      $('.sidebar-wrapper ul.nav li').removeClass('active');
      $(this).parent().addClass('active');
    });
  },
  mascaraValorReal: function(valor) {
    valor = valor.toString().replace(/\D/g,"");
    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
    return valor;                   
  },
  AjustaValorMonetarioParaCalculo: function(valor) {
    var valorAjustado = '';

    valorAjustado = valor.replace(/[.]/ig, "");
    valorAjustado = valorAjustado.replace(/[,]/ig, ".");

    return valorAjustado;
  },
  buscaDataHoje: function() {
    var data = new Date(),
        mes = data.getMonth() + 1,
        ano = data.getFullYear();
    return mes+'/'+ano;
  }
}