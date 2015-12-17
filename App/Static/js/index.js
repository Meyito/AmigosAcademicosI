


var cont = 1; //Variable usada en las pestañas de agregar asesoria
var cant = 0;
var valores = ["lunes2", "martes2", "miercoles2", "jueves2", "viernes2","lunes3", "martes3", "miercoles3", "jueves3", "viernes3","lunes4", "martes4", "miercoles4", "jueves4", "viernes4","lunes5", "martes5", "miercoles5", "jueves5", "viernes5","lunes6", "martes6", "miercoles6", "jueves6", "viernes6"];

/*Función grafica: Ajusta el sidebar al tamaño de la pantalla*/
function sidebarAdjust(){

	a = document.getElementById("front");
	b = document.getElementById("sidebar");
	c = document.getElementById("navbar");
	d = document.getElementById("footer");

	setTimeout(function(){
		b.style.height = (a.offsetHeight-c.offsetHeight-d.offsetHeight)+"px";
    }, 500); 
	$(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
}
/**
*	Genera alertas modales
*/
function alerta () {
	var content = "";
	if(arguments.length >= 2){

		content = "<h3>"+arguments[0]+"</h3><p>"+arguments[1]+"</p>";
	}else{
		content= "<p>"+arguments[0]+"</p>";
	}

	var div = document.createElement("div");
	var claseDiv = "alerta";
	div.setAttribute("class", claseDiv);
	div.innerHTML = content;
	document.body.appendChild(div);
	/*setTimeout(function() {
		div.style.opacity = "0";
	}, arguments[2] || 10000);
	setTimeout(function() {
		document.body.removeChild(div);
	}, arguments[2]+1000 ||  11000);*/
}




/*Función que edita el DOM para agregar un input para código adicional en el registro de cursos*/
function agregarCampo(){
	text = '<input name="codigo[]" type="text" class="form-control" placeholder="Código" required><span class="input-group-btn"><button class="btn btn-default btn-add" type="button" onclick="agregarCampo()">&nbsp;+&nbsp;</button></span>';
	campos = document.getElementById("campos");
	div = document.createElement("div");
	div.innerHTML = text;
	div.className = "input-group";
	campos.appendChild(div);
	sidebarAdjust();
}

/*Función que edita el DOM para agregar un input para código adicional en el registro de asesorias*/
function agregarCampoAsesoria(){
	text = '<div class="input-group"><input name="codigo[]" type="text" class="form-control" placeholder="Código"><span class="input-group-btn"><button class="btn btn-default btn-add" type="button" onclick="agregarTab(REPLACECONT)"><span class="glyphicon glyphicon-ok"></span></button><button class="btn btn-default btn-add" type="button" onclick="agregarCampoAsesoria();agregarTab(REPLACECONT)"><span class="glyphicon glyphicon-plus"></span></button></span></div>';
	text = text.replace("REPLACECONT", cont);
	text = text.replace("REPLACECONT", cont);
	campos = document.getElementById("codigos-asesoria");
	div = document.createElement("div");
	div.innerHTML = text;
	cont++;
	div.className = "col-md-6";
	campos.appendChild(div);
	sidebarAdjust();
}

/*Función que edita el DOM y agrega pestañas a los comentarios sobre las asesorias*/
function agregarTab(a){
	codigos = document.getElementsByName("codigo[]");
	tabs = document.getElementById("tabs");
	tabContent = document.getElementById("tab-contents");
	tabActual = document.getElementById("link"+a);
	li = '<a href="#REPLACEC1" aria-controls="REPLACEC2" role="tab" data-toggle="tab" id="REPLACEC3">REPLACECODIGO</a>';
	pane = '<textarea name="comentario[]" id="comentarioREPLACEC1" class="form-control" rows="3"  placeholder="Ingrese un comentario"></textarea>';
	if(tabActual != null){
		if(codigos[a].value != ""){
			document.getElementById("link"+a).innerHTML = codigos[a].value;
		}
		
	}else{
		if(codigos[a]!=""){
			li = li.replace("REPLACEC1", a);
			li = li.replace("REPLACEC2", a);
			li = li.replace("REPLACEC3", "link"+a);
			li = li.replace("REPLACECODIGO", codigos[a].value);
			pane = pane.replace("REPLACEC1",a);
			listed = document.createElement("li");
			listed.innerHTML = li;
			listed.setAttribute("role","presentation");
			tabs.appendChild(listed);
			tabPane = document.createElement("div");
			tabPane.setAttribute("role","tabpanel");
			tabPane.className = "tab-pane";
			tabPane.id = a;
			tabPane.innerHTML = pane;
			tabContent.appendChild(tabPane);
		}
	}
	sidebarAdjust();
	cambiarTipoComentario();
}

/*Función que habilita o deshabilita los comentarios similares en todas las pestañas*/
function cambiarTipoComentario(){
	radio = document.getElementsByName("tipoComentario");
	tabs = document.getElementById("tabs").childNodes;
	content = document.getElementById("tab-contents").childNodes;
	if(radio[0].checked){
		for(i=1;i<tabs.length;i++){
			if(tabs[i].nodeName=="LI" && tabs[i].className.search("disabled")!=-1){
				tabs[i].className = tabs[i].className.replace("disabled", "");
			}
		}
		for(i=1;i<content.length;i++){
			if(content[i].nodeName=="DIV"){
				aux = content[i].childNodes;
				for(j=0;j<aux.length;j++){
					if(aux[j].nodeName=="TEXTAREA"){
						aux[j].disabled = false;
					}
				}
			}
		}
	}else{
		for(i=1;i<tabs.length;i++){
			if(tabs[i].nodeName=="LI" && tabs[i].className.search("disabled")==-1){
				tabs[i].className = tabs[i].className+" disabled";
			}
		}
		for(i=1;i<content.length;i++){
			if(content[i].nodeName=="DIV" && content[i].id!="0"){
				aux = content[i].childNodes;
				for(j=0;j<aux.length;j++){
					if(aux[j].nodeName=="TEXTAREA"){
						aux[j].disabled = true;
					}
				}
			}
		}
	}
}

/*Copia el contenido del textarea principal en todos los demas*/
function copiarTextArea(){
	original = document.getElementById("comentario0");
	if(radio[1].checked){
		for(i=1;i<content.length;i++){
			if(content[i].nodeName=="DIV" && content[i].id!="0"){
				aux = content[i].childNodes;
				for(j=0;j<aux.length;j++){
					if(aux[j].nodeName=="TEXTAREA"){
						aux[j].value = original.value;
					}
				}
			}
		}
	}
}

function ajustarCalificacion (actual) {
	s = new Array();
	s[0] = document.getElementById("star-1");
	s[1] = document.getElementById("star-2");
	s[2] = document.getElementById("star-3");
	s[3] = document.getElementById("star-4");
	s[4] = document.getElementById("star-5");
	var i;
	for(i=0;i<actual;i++){
		s[i].checked = true;
	}
	for(;i<s.length;i++){
		s[i].checked = false;
	}
}

function cargarAlerta (identificador) {
	document.getElementById("asesoria").value = identificador;
}

function cargarSelect(){
	var str=document.getElementById("materias").value;

	var parameters = {
            "q":str
          };

          $.ajax({
                data:  parameters,
                url:   'Core/Model/selectTema.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
                  $("#temas").html(response);
                  console.log(response);
              }
          });
}
function conteoInicial(){
	if(document.getElementById("lunes2")){
		for(i = 0; i < 25; i++){
        	if(document.getElementById(valores[i]).checked){
        	  cant++;
        	}
    	}
	}
}



function conteo(id){
    setTimeout(function(){
        if(document.getElementById(id).checked){
            if(cant<20){
              cant++;
            }else{
              $('#excedido').modal('show');
              document.getElementById(id).checked = false;
            }
        }else{
            cant--;
        }
    }, 300);       
}



conteoInicial();
/*Escuchadores*/
window.addEventListener("resize", sidebarAdjust, false);
