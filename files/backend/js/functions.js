$(document).ready(function(){

    $(".tip-top").tooltip({placement : 'top'});
    $(".tip-right").tooltip({placement : 'right'});
    $(".tip-bottom").tooltip({placement : 'bottom'});
    $(".tip-left").tooltip({ placement : 'left'});

/*	var dates = $.fn.datepicker.dates = {
			pt: {
				days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
				daysShort: ["Dom","Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"],
				daysMin: ["D", "S", "T", "Q", "Q", "S", "S", "D"],
				months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
				today: "Hoje",
				clear: "Limpar"
			}
		};


		
*/	

	$(".pid").click(function(){
		$("#pnlFormaPagamento").attr("style","display:block");
	});

    function LoadDatepicker(){
        $('#sandbox-container input').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            language: 'pt'
        });
    }

/*	
      var g1;
      
        var g1 = new JustGage({
          id: "g1", 
          value: $("#cad_semana").val(), 
          min: 0,
          max: 100,
          title: "Cadastros da semana",
          showMinMax: false
        });
	
        setInterval(function() {
          g1.refresh($("#cad_semana").val());
        }, 2500);
*/	
	
/*$('button').attr("data-target", "bs-modal-sm").click(function(){
	$('#confirm-btn').click(function () {
		var btn = $(this);
		var closemodal = $("#close-modal");
		btn.button('loading');
	});
})*/

	
$("#associado_txt").blur(function(){
	var cct = $('input[name=csrf_s]').val();
	$.ajax({
		type:"POST",
		data:"usuario="+$(this).val()+"&csrf_s="+cct,
		url:"http://escritorio.redeseitec.com.br/callback/associado_check",
		success:function(msg){
			$("#response_associado").html(msg);
			var aid = $("#aid").val();
			var action = "http://escritorio.redeseitec.com.br/escritorio-virtual/pedidos/gerar_credito/"+aid;
			$("#gera-credito").attr("action", action);
			if($("#response_associado p").hasClass("error")){
				$("#associado_txt").val("");
				$("#save").attr("disabled", true);
			}else{
				$("#save").attr("disabled", false);
			}
		}
	})
});

$("#response_novos_cadastros").html(function(){
	var cct = $('input[name=csrf_s]').val();
	$.ajax({
		url:"http://escritorio.redeseitec.com.br/callback/get_novos_cadastros",
		success:function(msg){
			$("#response_novos_cadastros").html("");
			$("#response_novos_cadastros").html(msg);
			$("input:radio[name=novos_cadastros]").live("change", function(){
				var cct = $('input[name=csrf_s]').val();
				$.ajax({
					type:"POST",
					data:"novos_cadastros="+$(this).val()+"&csrf_s="+cct,
					url:"http://escritorio.redeseitec.com.br/callback/set_novos_cadastros",
					success:function(msg){
						$("#response_novos_cadastros").html("");
						$("#response_novos_cadastros").html(msg);
					}
				})
			})
		}
	})

});

$("select[name=tp_cadastro]").change(function(){
	$("#pessoa_juridica, #contato_empresa").toggle();
})

$("select[name=plano]").change(function(){
	$("#plano ul").each(function(i) {
		if(this.style.display !== 'none'){
			this.style.display = 'none';
		}
	});
	$("#plano ul[id="+$("select[name='plano'] option:selected").val()+"]").toggle();
})
	
$(".detalhes_associado").click(function(){
	var cct = $('input[name=csrf_s]').val();
	//Prevent link opening
	event.preventDefault();

	$.modal({
		title: 'Detalhes do associado',
		maxWidth: 500,
		data:"csrf_s="+cct,
		url:$(this).attr('id'),
		buttons: {
			'Fechar': function(win) {win.closeModal(); }
		}
	})
});
	
$('.modal-link').click(function(event){
	var cct = $('input[name=csrf_s]').val();
	var vai = this.href;
	// Prevent link opening
	event.preventDefault();

	// Open modal
	$.modal({
		content: '<p>Tem certeza de que deseja ativar o associado <strong>usando seus créditos?</strong></p>',
		title: 'Ativar associado',
		maxWidth: 500,
		buttons: {
			'Não': function(win) { win.closeModal(); },
			'Sim': function(win) {
				win.loadModalContent(vai, {loadingMessage: 'Carregando', data:"csrf_s="+cct})
			}
		}
	});
});			
	
//calcula o valor das parcelas
$("#qtde_parcelas").blur(function(){
	$("#valor_parcelas").val(($("#valor_plano").val() - $("#valor_entrada").val()) / $("#qtde_parcelas").val());
	$("#pontos_linear").focus();
})
/*	
	if($('.tooltip')[0]){
		$('.tooltip').tooltipster();
		}
*/
	/*
	*	Formulário de cadastro
	*/
jQuery('form').validate({
    valid :function() {
        $("#save").attr("disabled", true);
    },
    invalid : function(e, o){


        if($("#patrocinador_txt").val() == "" || $("#patrocinador-description p").hasClass("alert-danger") ||
            $("#nome_completo").val() == "" ||
            $("#cpf").val() == "" || $("#cpf-description p").hasClass("alert-danger") ||
            $("#dtnasc").val() == "" ||
            $("#data-description p").hasClass("alert-danger")
            ){
            $("#lnk1").click();
        }else if($("#cep").val() == "" || $("#cep-description p").hasClass("alert-danger") ||
                 $("#numero").val() == "" || $("#logradouro").val() == "" || $("#bairro").val() == "" ||
                 $("#cidade").val() == "" || $("#estado").val() == null){
            $("#lnk2").click();
        }else if($("#email").val() == "" || $("#email-description p").hasClass("alert-danger")){
            $("#lnk3").click();
        }else if($("#login").val() == "" || $("#login-description p").hasClass("alert-danger")){
            $("#lnk4").click();
        }
    },
	onBlur:	true,
	conditional: {
		conf_senha : function(){
			return $(this).val() == $("#senha").val();
        },
		cep : function(){
            var status = true;
            var cct = $('input[name=csrf_s]').val();
            var cep_field = $(this).val();

            if($("#cep").val() == "" || $("#cep").val() == "_____-___"){
                $("#cep-description").html('<p class="alert alert-danger">O Cep deve ser informado.</p>');

                $("#cep").closest("div").removeClass("has-warning has-success").addClass("has-error");
                $("#cep-description p").addClass("col-md-12");
                status = false;
            }
            else {
            $.getJSON("http://escritorio.redeseitec.com.br/callback/buscacep2", {cep: cep_field, csrf_s:cct})
                .always(function(json){
                    var dados = $.parseJSON($.trim(json.responseText));
                    if(dados == false){
                        $("#cep-description").html('<p class="alert alert-danger">O Cep informado não foi encontrado.</p>');
                        $("#cep").closest("div").removeClass("has-warning has-success").addClass("has-error");
                        $("#cep-description p").addClass("col-md-12");
                        status = false;
                    }else{
                        $("#cep-description").html('');
                        $("#cep").closest("div").removeClass("has-error has-warning").addClass("has-success");

                        if(dados.endereco != ""){
                            $('#logradouro').val(dados.endereco,'');
                            $("#logradouro-description").html('');
                            $("#logradouro").closest("div").removeClass("has-error has-warning").addClass("has-success");
                        }
                        if(dados.bairro){
                            $('#bairro').val(dados.bairro,'');
                            $("#bairro-description").html('');
                            $("#bairro").closest("div").removeClass("has-error has-warning").addClass("has-success");
                        }
                        if(dados.cidade){
                            $('#cidade').val(dados.cidade,'');
                            $("#cidade-description").html('');
                            $("#cidade").closest("div").removeClass("has-error has-warning").addClass("has-success");
                        }
                        if(dados.estado != ""){
                            $('#estado').val(dados.estado);

                            $("#estado-description").html('');
                            $("#estado").closest("div").removeClass("has-error has-warning").addClass("has-success");
                        }
                    }
                })

				
			}
			return status == true;
        },
        cpf : function(){
            var status = true;
            var cct = $('input[name=csrf_s]').val();
            $.post("http://escritorio.redeseitec.com.br/callback/cpf_check", {csrf_s:cct, cpf: $(this).val()})
                .always(function(msg){
                    $("#cpf-description").html(msg);
                    if($("#cpf-description p").hasClass("alert-danger")){
                        $("#cpf").closest("div").removeClass("has-warning has-success").addClass("has-error");
                        $("#cpf-description p").addClass("col-md-12")
                        status = false;
                    }else {
                        $("#cpf").closest("div").removeClass("has-error has-warning").addClass("has-success");
                    }
                })
                return status == true;
        },
        patrocinador : function(){
            var cct = $('input[name=csrf_s]').val();
            var status = true;
            $.post("http://escritorio.redeseitec.com.br/callback/patrocinador_check", {csrf_s:cct, usuario: $(this).val()})
                .always(function(msg){
                    $("#patrocinador-description").html(msg);
                    if($("#patrocinador-description p").hasClass("alert-danger")){
                        $("#patrocinador_txt").closest("div").removeClass("has-warning has-success").addClass("has-error");
                        $("#patrocinador-description p").addClass("col-md-12")
                        status = false;
                    }else if($("#patrocinador-description p").hasClass("alert-warning")){
                        $("#patrocinador_txt").closest("div").removeClass("has-error has-success").addClass("has-warning");
                        $("#patrocinador-description p").addClass("col-md-12")
                        status = false;
                    }else {
                        $("#patrocinador_txt").closest("div").removeClass("has-error has-warning").addClass("has-success");
                    }
                })
            return status === true;
        },
        email : function(){
            var status = true;
            var cct = $('input[name=csrf_s]').val();
            $.post("http://escritorio.redeseitec.com.br/auth/email_check", {csrf_s:cct, email: $(this).val()})
                .always(function(msg){
                    $("#email-description").html(msg);
                    if($("#email-description p").hasClass("alert-danger")){
                        $("#email").closest("div").removeClass("has-warning has-success").addClass("has-error");
                        $("#email-description p").addClass("col-md-12")
                        status = false;
                    }else if($("#email-description p").hasClass("alert-warning")){
                        $("#email").closest("div").removeClass("has-error has-success").addClass("has-warning");
                        $("#email-description p").addClass("col-md-12")
                        status = false;
                    }else {
                        $("#email").closest("div").removeClass("has-error has-warning").addClass("has-success");
                    }
                })
            return status === true;
        },
        data : function(){
            var status = false;
            if($().calculaIdade($(this).val()) < 18)
                status = false
            else
                status = true;
            return status == true;
        },
        profissao : function(){

            var status = false;
            if($().calculaIdade($(this).val()) < 18)
                status = false

            else
                status = true;
            return status == true;
        },
        login : function(){
            var status = true;
            var cct = $('input[name=csrf_s]').val();
            $.post("http://escritorio.redeseitec.com.br/callback/login_check", {csrf_s:cct, login: $(this).val()})
                .always(function(msg){
                    $("#login-description").html(msg);
                    if($("#login-description p").hasClass("alert-danger")){
                        $("#login").closest("div").removeClass("has-warning has-success").addClass("has-error");
                        $("#login-description p").addClass("col-md-12")
                        status = false;
                    }else {
                        $("#login").closest("div").removeClass("has-error has-warning").addClass("has-success");
                    }
                })
            return status == true;
        }
    },
    description : {
		//login : {
		//	required : '<p class="alert alert-danger">Você precisa criar um login para continuar.</p>'

		//},
		senha : {
			required : '<p class="alert alert-danger">Você precisa criar uma senha.</p>'
		},
		conf_senha : {
			conditional : '<p class="alert alert-danger">As senhas informadas estão diferentes.</p>'
		},
		//cep : {
		//	required : '<p class="alert alert-danger">O Cep deve ser informado.</p>'

		//},
		nome: {
			required : '<p class="alert alert-danger">Não se esqueça de preencher seu nome!</p>'
		},
		data: {
            required : '<p class="alert alert-danger">Por favor, informe sua data de nascimento!</p>',
            conditional : '<p class="alert alert-danger">Atenção: Não será possível continuar o cadastro pois, somente maiores de 18 anos podem se cadastrar.</p>',
			pattern : function(){
				$("#dtnasc").val("");
				return '<p class="alert alert-danger">Formato de data inválido. <br>Use o formato descrito no campo.</p>'								;
			}
		},
        numero: {
            required : '<p class="alert alert-danger">O número deve ser nformado.</p>'
        },
        logradouro: {
            required : '<p class="alert alert-danger">O logradouro deve ser informado</p>'
        },
        bairro: {
            required : '<p class="alert alert-danger">O bairro deve ser informado</p>'
        },
        cidade: {
            required : '<p class="alert alert-danger">A cidade deve ser informada.</p>'
        },
        estado: {
            required : '<p class="alert alert-danger">O estado deve ser informado.</p>'
        }
	},
	eachInvalidField : function(){
		$(this).addClass('form-control');				
		$(this).closest('p').removeClass('form-group has-success').addClass('form-group has-error');				
	},
	eachValidField : function(){

		$(this).addClass('form-control');				
		$(this).closest('p').removeClass('form-group has-error').addClass('form-group has-success');				
	}

});
	
		
jQuery.validateExtend({
	data : {
		required : true,
		pattern : /^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/
	}
});
	/*
	*	Fim - Formulário de cadastro
	*/

$("#pis_pasep").inputmask({
	mask: '999.99999.99-9'
})

$("#cpf").inputmask({
	mask: '999.999.999-99'
})

$("#cep").inputmask({
	mask: '99999-999'
})

$("#dtnasc").inputmask({
	mask: '99/99/9999'
})

$("#cnpj").inputmask({
	mask: '99.999.999/9999-99'
})

$("#tel_fixo").inputmask({
	mask: '(999) 9999-9999'
})

$(".telefone").inputmask({
    mask: '(999) 9999-9999'
})

$("#tel_celular").inputmask({
	mask: '(999) 9999-9999'
})

$("#tel_comercial").inputmask({
    mask: '(999) 9999-9999'
})

$("#estado").inputmask({
	mask: 'aa'
})
	function LoadTableConfig(){
        $('#table-geral').dataTable({
            oLanguage: {
                sLengthMenu: "_MENU_ registros por página",
                sSearch: "Pesquisar",
                sInfo: "Exibindo registros de _START_ a _END_ de _TOTAL_",
                sInfoEmpty: "Exibindo registros de 0 a 0 de 0",
                sZeroRecords: "Nenhum registro encontrado",
                sInfoFiltered: "(filtrado de _MAX_ registros)",
                oPaginate: {
                    sPrevious: "Anterior",
                    sNext: "Próximo"
                }
            }
        });
    }




    /**
     * jQuery CalculaIdade v1.0.0 - http://wborbajr.blogspot.com/jquery.CalculaIdade.php
     *
     * Copyright (c) 2008 Waldir Borba Junior (stilbuero.de)
     * Adaptado por Ramires Teixeira
     * Dual licensed under the MIT and GPL licenses:
     * http://www.opensource.org/licenses/mit-license.php
     * http://www.gnu.org/licenses/gpl.html
     *
     * Usando calculaIdade().
     *
     * @exemplo
     *
     * $('#campos_formulario').val( $().calculaIdade( "dd/mm/yyyy" ) );
     *
     * $('#campos_formulario').val( $().calculaIdade( "dd/mm/yy" ) );
     *
     * @desc Calcula a idade de uma data informada e retorno no formato 99 a 99 m -
     *            #ERR# - se a data informada  nao estiver correta
     *
     */

    $.fn.calculaIdade = function ( dataNascimento ) {
        var hoje = new Date();

        var arrayData = dataNascimento.split("/");

        var retorno = "#ERR#";

        if (arrayData.length == 3) {
            // Decompoem a data em array
            var ano = parseInt( arrayData[2] );
            var mes = parseInt( arrayData[1] );
            var dia = parseInt( arrayData[0] );

            // Valida a data informada
            if ( arrayData[0] > 31 || arrayData[1] > 12 ) {
                return retorno;
            }

            ano = ( ano.length == 2 ) ? ano += 1900 : ano;

            // Subtrai os anos das duas datas
            var idade = ( hoje.getFullYear() ) - ano;

            // Subtrai os meses das duas datas
            var meses = ( hoje.getMonth() + 1 ) - mes;

            // Se meses for menor que 0 entao nao cumpriu anos. Se for maior sim ja cumpriu
            idade = ( meses < 0 ) ? idade - 1 : idade;

            meses = ( meses < 0 ) ? meses + 12 : meses;

            retorno = ( idade );
        }

        return retorno;
    };

})
