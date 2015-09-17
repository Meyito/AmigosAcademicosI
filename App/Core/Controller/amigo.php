<?php

	require_once "Core/Controller/controller.php";
	//include_once "Core/Modelo/AmigoBD.php";
	include_once "Core/Model/userDB.php";

	class Amigo extends Controller{

		public function index(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/inicio_amigo_academico.html");

			//temporal
			$temas=$this->getTemplate("Core/View/assets/estatico_tmp_temasInicio.html");
			$content=$this->renderView($content, "{{CICLO:TEMAS_SEMANA}}",$temas);
			$amigos=$this->getTemplate("Core/View/assets/estatico_tmp_amigosHora.html");
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA2}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA3}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA4}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA5}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA6}}",$amigos);
			//
			$courses=$this->getCourses2();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}",$temas);
			$menu=$this->getTemplate("Core/View/assets/menu_amigo.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function changeAvatar(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_amigo.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function help(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_amigo.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function adviceRegister(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_asesoria.html");
			$menu=$this->getTemplate("Core/View/assets/menu_amigo.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function courseAssistantR(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_lista_curso.html");
			$menu=$this->getTemplate("Core/View/assets/menu_amigo.html");
			$course=$this->getCourses();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $course);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function getCourses(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_asistencia.html");
			$userModel=new UserDB();
			$data=$userModel->getCourses();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_CURSO}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA_CURSO}}", $data[$i][4]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
				$list=$list.$aux;
			}
			return $list;
		}

		public function getCourses2(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos.html");
			$userModel=new UserDB();
			$data=$userModel->getCourses();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_CURSO}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA_CURSO}}", $data[$i][4]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
				$list=$list.$aux;
			}
			return $list;
		}

		public function registrarAsisC($id){
			$index=$this->base();

			$adminModel=new AdminDB();
			$data=$adminModel->getCourse($id);
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_curso.html");
			$content=$this->renderView($content, "{{NOMBRE_CURSO}}", $data[0][1]);
			$menu=$this->getTemplate("Core/View/assets/menu_amigo.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$index=$this->renderView($index, "{{COMPUESTO:LIBRERIAS_JS}}", "document.getElementById('tipoComentario1').addEventListener('click', cambiarTipoComentario, false);
      document.getElementById('tipoComentario2').addEventListener('click', cambiarTipoComentario, false);
      document.getElementById('0').addEventListener('keyup', copiarTextArea, false);");
			$this->showView($index);
		}
	}
?>