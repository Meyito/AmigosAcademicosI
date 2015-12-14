<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/helperDB.php";
	include_once "Core/Model/userDB.php";

	class Amigo extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_amigo.html");
			$this->indexP($index);
		}

		public function changeAvatar(){
			$view=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function help(){
			$view=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function adviceRegister(){
			$index=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_asesoria.html");
			$content=$this->listarMaterias($content, -1);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$aux=$this->getTemplate("Static/js/ninjaScripts/AjaxTemas-Cursos.js");
			$index=$this->renderView($index, "{{COMPUESTO:LIBRERIAS_JS}}", $aux);
			$this->showView($index);
		}

		public function courseAssistantR(){
			$index=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_lista_curso.html");
			$courses=$this->getCursos3();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $courses);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}

		public function getCursos3(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_asistencia.html");
			$userModel=new UserDB();
			$data=$userModel->getCursos();

			$aux="";
			$list="";

			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_CURSO}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA_CURSO}}", $data[$i][2]);
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_AMIGO}}", $data[$i][4]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
				$list=$list.$aux;
			}
			return $list;
		}

		public function registrarAsesoria($materia, $tema, $codigos, $tipoC, $comentarios){
			
			$amigoDB=new helperDB();

			$idAsesoria=$amigoDB->addAsesoria($_SESSION["codigo"], $materia, $tema);

			$coment="";
			if($tipoC!=1){
				$coment=$comentarios[0];
			}

			for($i=0; $i<count($codigos); $i++){
				if($tipoC==1){
					$coment=$comentarios[$i];
				}

				$amigoDB->addAsistenciaAsesoria($codigos[$i], $idAsesoria, $coment);
			}
			$this->adviceRegister();
		}

		public function registrarAsisC($id){
			$index=$this->base("Core/View/assets/menu_amigo.html");

			$adminModel=new AdminDB();
			$data=$adminModel->getCurso($id);

			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_curso.html");
			$content=$this->renderView($content, "{{NOMBRE_CURSO}}", $data[0][0]);
			$content=$this->renderView($content, "{{id}}", $id);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$aux=$this->getTemplate("Static/js/ninjaScripts/registrarAsistenciaCurso.js");
			$index=$this->renderView($index, "{{COMPUESTO:LIBRERIAS_JS}}", $aux);
			$this->showView($index);
		}

		public function registrarAsistenciaCurso($idCurso, $codigos){

			$amigoDB=new helperDB();

			for($i=0; $i<count($codigos); $i++){
				$amigoDB->addAsistenciaCurso($codigos[$i],$idCurso);
			}

			$this->registrarAsisC($idCurso);
		}

		public function estadistica(){
			$view=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/estadisticaPorAmigo.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$js=$this->getTemplate("Core/View/assets/estadisticaPorAmigo.html");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $js);
			$this->showView($view);
		}
	}
?>
