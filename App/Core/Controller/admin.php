<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/adminDB.php";

	class Admin extends Controller{

		public function index(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/inicio_amigo_academico.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			//gethorario, get cursos, get temas para renderizar la vista.
			$this->showView($index);
		}

		public function statistics(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function topics(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function showAA(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/administrar_amigos.html");
			
			$aa=$this->getAA();
			$content=$this->renderView($content, "{{CICLO:AMIGOS}}", $aa);

			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function getAA(){
			//$adminModel=new AdminDB();
			//$data=$adminModel->getAmigos();

			//prueba
			$data=array();
			$aa=[12, "Denis", "activo"];
			array_push($data, $aa);
			$aa=[24, "Yurley", "inactivo"];
			array_push($data, $aa);
			//

			$lista="";
			$template=$this->getTemplate("Core/View/assets/lista_amigos.html");
			$aux="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_AMIGO}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:ID}}", $data[$i][0]);
				$aux=$this->renderView($aux, "{{BASICO:ESTADO}}", $data[$i][2]);
				$lista=$lista.$aux;
			}
			return $lista;
		}

		public function courses(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/administrar_cursos.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function aaViewRegister(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/registrar_amigo_academico.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function aaUpdate($id){
			$view=$this->base();
			$content=$this->getUpdate($id);
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function getUpdate($id){
			$template=$this->getTemplate("Core/View/contenedores/editar_amigo_academico.html");
			//$adminModel=new AdminDB();
			//$data=$adminModel->getAmigo();

			//prueba
			$data=[1150990, "1234", "amelisdl@gmail.com"];
			//

			$_POST["id"]=$id;
			$_POST["password"]=$data[1];
			$template=$this->renderView($template, "{{BASICO:CODIGO}}", $data[0]);
			$template=$this->renderView($template, "{{BASICO:EMAIL}}", $data[2]);			
			//horario//

			return $template;
		}

		public function registerAA($codigo, $email, $password, $horario){
			$name="holi";
			$semester=5;
			$avatar="Static/img/avatars/h1.png";
			$adminModel=new AdminDB();
			$data=false;
			//$data=$adminModel->getAmigo($codigo);
			if($data==false){
				$result=$adminModel->addAmigo($codigo,$password,$name,$semester,$email,$avatar,$horario);
				print_r("Exito");
			}else{
				//ALERTA ERROR, USUARIO YA REGISTRADO
				echo"error";
			}
			$this->showAA();
			
		}

		public function createCourse(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/registrar_curso.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function updateCourse(){
			
		}
	}
?>