
	var mailnumber=2;
	var telnumber=2;

	function adcorreo(){
		var label_correo = document.createTextNode("Email "+mailnumber+" ");
		var form_label = document.createElement("label");
		var form_imput = document.createElement("input");
		var form_boton = document.createElement("button");
		var awesom = document.createElement("i");
		awesom.setAttribute("class", "fa fa-times");
		form_boton.appendChild(awesom);
		var insertar = document.createElement("div");
		insertar.setAttribute("class", "di");
		insertar.setAttribute("id", "correo"+mailnumber); //dentro de funci�n
		form_label.setAttribute("for", "mail"+mailnumber); //dentro de funci�n
		form_imput.setAttribute("id", "mail"+mailnumber); //dentro de funci�n
		form_imput.setAttribute("name", "mail"+mailnumber); //dentro de funci�n
		form_imput.setAttribute("value", " "); //dentro de funci�n
		form_boton.setAttribute("type", "button");

		form_label.appendChild(label_correo);
		insertar.appendChild(form_label);
		insertar.appendChild(form_imput);
		insertar.appendChild(form_boton);
	
		var nuevonodo = document.querySelector("#correo");
		nuevonodo.insertBefore(insertar, nuevonodo.lastChild);
		mailnumber++; //dentro de funci�n
	}

	function adtelefono(){
		var label_telefono = document.createTextNode("Telefono "+telnumber+" ");
		var form_label = document.createElement("label");
		var form_imput = document.createElement("input");
		var form_boton = document.createElement("button");
		var awesom = document.createElement("i");
		awesom.setAttribute("class", "fa fa-times");
		form_boton.appendChild(awesom);
		var insertar = document.createElement("div");
		insertar.setAttribute("class", "di");
		insertar.setAttribute("id", "telefon"+telnumber); //dentro de funci�n
		form_label.setAttribute("for", "telefon"+telnumber); //dentro de funci�n
		form_imput.setAttribute("id", "telefon"+telnumber); //dentro de funci�n
		form_imput.setAttribute("name", "telefon"+telnumber); //dentro de funci�n
		form_imput.setAttribute("value", " "); //dentro de funci�n
		form_boton.setAttribute("type", "button");

		form_label.appendChild(label_telefono);
		insertar.appendChild(form_label);
		insertar.appendChild(form_imput);
		insertar.appendChild(form_boton);
	
		var nuevonodo = document.querySelector("#telef");
		nuevonodo.insertBefore(insertar, nuevonodo.lastChild);
		telnumber++; //dentro de funci�n
	}
