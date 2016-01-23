$(function(){
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
		
	/*
	*	Formulário de cadastro
	*/
	$( "#abas_cadastro" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	$( "#abas_cadastro li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" ); 
	$( "#enviar" ).removeClass( "ui-btn_hidden" );
	
	$("#btn_proximo_2").click(function(){$("#ui-id-2").click()});
	$("#btn_proximo_3").click(function(){$("#ui-id-3").click()});
	$("#btn_proximo_4").click(function(){$("#ui-id-4").click()});

	jQuery('form').validate({
			onBlur:	true,
			conditional: {
				conf_senha : function(){
					return $(this).val() == $("#senha").val();
					},
				cep : function(){
						var cct = $('input[name=csrf_scv]').val();
						var cep_field = $(this).val();
						var status = true;
							$.ajax({
								url: "http://www.sicove.com.br/callback/buscacep",
								type: "POST",
								data: {cep: cep_field, csrf_scv:cct},
								dataType:"json"
							}).done(function(dados){
								if(dados == false){
									$('#logradouro').val("");
									$('#bairro').val("");
									$('#cidade').val("");
									$('#estado').val("");
									$('#msg').html("<em>Cep não encontrado</em>");
								}else{
									$('#msg').html("");
									$('#logradouro').val(dados.endereco,'');
									$('#bairro').val(dados.bairro,'');
									$('#cidade').val(dados.cidade,'');
									$('#estado').val(dados.estado);
									$('#numero').focus();
								} 
							})
					return status == true;				
					}
				},
			description : {
				login : {
					required : '<p class="alert alert-danger">Você precisa criar um login para continuar</p>'
				},
				senha : {
					required : '<p class="alert alert-danger">Você precisa criar uma senha</p>'
				},
				conf_senha : {
					conditional : '<p class="alert alert-danger">As senhas informadas estão diferentes</p>'
				},
				cep : {
					required : '<p class="alert alert-danger">Digite seu CEP</p>',
				},
				nome: {
					required : '<p class="alert alert-danger">não se esqueça de preencher seu nome</p>',
				},
				data: {
					pattern : function(){
								$("#dtnasc").val("");
								return '<p class="alert alert-danger">Formato de data inválido. <br>Use o formato descrito no campo</p>'								;
							},
					},
				cpf : {
					conditional: function(){
							return '<p class="alert alert-danger">CPF inválido</p>';
						}
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
		},
		email : {
			required : true,
			conditional : function(){
						var status = true;
						var cct = $('input[name=csrf_scv]').val();
						$.ajax({
							type:"POST",
							data:"email="+$(this).val()+"&csrf_scv="+cct,
							url:"http://www.sicove.com.br/auth/email_check",
							success:function(msg){
											$("#email-description").html(msg);
											if($("#email-description p").hasClass("alert-danger")){
												$("#email").closest("div").removeClass("has-warning has-success").addClass("has-error");
												$("#email-description p").addClass("col-md-12")
												$("#email").focus();
												status = false;
											}else if($("#email-description p").hasClass("alert-warning")){
												$("#email").closest("div").removeClass("has-error has-success").addClass("has-warning");
													$("#email-description p").addClass("col-md-12")
													status = false;
											}else {
												$("#email").closest("div").removeClass("has-error has-warning").addClass("has-success");
												}
							}
						})
						return status == true;
				}
		},
		patrocinador : {
			conditional : function(){
					var status = true;
					var cct = $('input[name=csrf_scv]').val();
					$.ajax({
						type:"POST",
						data:"usuario="+$(this).val()+"&csrf_scv="+cct,
						url:"http://www.sicove.com.br/auth/patrocinador_check",
						success:function(msg){
										
										$("#patrocinador-description").html(msg);
										if($("#patrocinador-description p").hasClass("alert-danger")){
												$("#patrocinador_txt").closest("div").removeClass("has-warning has-success").addClass("has-error");
											$("#patrocinador-description p").addClass("col-md-12")
											$("#patrocinador_txt").focus();
											status = false;
										}else if($("#patrocinador-description p").hasClass("alert-warning")){
												$("#patrocinador_txt").closest("div").removeClass("has-error has-success").addClass("has-warning");
													$("#patrocinador-description p").addClass("col-md-12")
													status = false;
											}else {
												$("#patrocinador_txt").closest("div").removeClass("has-error has-warning").addClass("has-success");
												}
						}
					})
					return status === true;
				}
			}
	});
	/*
	*	Fim - Formulário de cadastro
	*/
	function validarCPF(cpf) {  
		cpf = cpf.replace(/[^\d]+/g,'');    
		if(cpf == '') return false; 
		// Elimina CPFs invalidos conhecidos    
		if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
			cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
			cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
			cpf == "88888888888" || cpf == "99999999999")
		return false;
		// Valida 1o digito 
		add = 0;    
		for (i=0; i < 9; i ++)       
			add += parseInt(cpf.charAt(i)) * (10 - i);  
		rev = 11 - (add % 11);  
		if (rev == 10 || rev == 11)
		     rev = 0;    
		if (rev != parseInt(cpf.charAt(9)))
		     return false;       
		// Valida 2o digito 
		add = 0;    
		for (i = 0; i < 10; i ++)
		    add += parseInt(cpf.charAt(i)) * (11 - i);  
		rev = 11 - (add % 11);  
		if (rev == 10 || rev == 11)
		     rev = 0;    
		if (rev != parseInt(cpf.charAt(10)))
		     return false;
		return true;
	}

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

$("#numtel").inputmask({
	mask: '(999) 9999-9999'
	})
	
$("#numcel").inputmask({
	mask: '(999) 9999-9999'
	})
$("#estado").inputmask({
	mask: 'aa'
	})


	})