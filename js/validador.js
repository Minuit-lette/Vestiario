function validarSuscripcion(){
	correoVal=$("#emailSuscripcion").data("previousVal");
	var correo=$("#emailSuscripcion");
	if (correo.val()!=""){
		if( !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(correo.val()))){
			if(correoVal!=1){
				errorCorreo=$('<div/>',{'class': 'alert alert-danger'});
				errorCorreo.text("La sintaxis del email no es válido");
				errorCorreo.insertAfter(correo);				
			}
			correoVal=1;
		}
		else{
				if(correoVal==1)
					errorCorreo.remove();
				correoVal=0;
		}
	}
	correo.data("previousVal",correoVal);
}