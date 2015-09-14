/*Función grafica: Ajusta el sidebar al tamaño de la pantalla*/
function sidebarAdjust(){
	a = document.getElementById("front");
	b = document.getElementById("sidebar");
	c = document.getElementById("navbar");
	d = document.getElementById("footer");
	b.style.height = (a.offsetHeight-c.offsetHeight-d.offsetHeight)+"px";
}

function agregarCampo(){
	text = '<input name="codigo[]" type="text" class="form-control" placeholder="Código"><span class="input-group-btn"><button class="btn btn-default btn-add" type="button" onclick="agregarCampo()">&nbsp;+&nbsp;</button></span>';
	campos = document.getElementById("campos");
	div = document.createElement("div");
	div.innerHTML = text;
	div.className = "input-group";
	campos.appendChild(div);
	sidebarAdjust();
}



window.addEventListener("resize", sidebarAdjust, false);

