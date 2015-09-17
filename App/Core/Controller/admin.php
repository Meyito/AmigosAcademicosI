<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/adminDB.php";
	include_once "Core/Model/userDB.php";

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
			$userModel=new UserDB();
			$data=$userModel->getAmigos();

			/*prueba
			$data=array();
			$aa=[12, "Denis", "activo"];
			array_push($data, $aa);
			$aa=[24, "Yurley", "inactivo"];
			array_push($data, $aa);
			*/

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
			$courses=$this->getCourses();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $courses);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function getCourses(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_editable.html");
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
			$adminModel=new AdminDB();
			$data=$adminModel->getAmigo($id);

			$_POST["id"]=$id;
			$_POST["password"]=$data[0][2];
			$template=$this->renderView($template, "{{BASICO:CODIGO}}", $data[0][0]);
			$template=$this->renderView($template, "{{BASICO:EMAIL}}", $data[0][3]);
			$template=$this->renderView($template, "{{BASICO:NOMBRE}}", $data[0][1]);
			$template=$this->renderView($template, "{{BASICO:SEMESTRE}}", $data[0][4]);			
			//horario $data [1]// 
			
			return $template;
		}

		public function registerAA($codigo, $password, $nombre, $sem, $email, $horario){
			$avatar="Static/img/avatars/h1.png";
			$password=$this->encryptPassword($password);
			$adminModel=new AdminDB();
			$data=false;
			
			//$data=$adminModel->getAmigo($codigo);
			if($data==false){
				$result=$adminModel->addAmigo($codigo,$password,$nombre,$sem,$email,$avatar,$horario);
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

		public function updateCourse($id){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/editar_curso.html");//cambiar

			$adminModel=new AdminDB();
			$data=$adminModel->getCourse($id);

			$hora="03:30";
			$content=$this->renderView($content, "{{BASICO:HORA}}", $hora);
			$content=$this->renderView($content, "{{id}}", $id);
			$content=$this->renderView($content, "{{BASICO:MATERIA}}", $data[0][6]);
			$content=$this->renderView($content, "{{BASICO:FECHA}}", $data[0][4]);
			$content=$this->renderView($content, "{{BASICO:AMIGO}}", $data[0][3]);
			$content=$this->renderView($content, "{{BASICO:TEMA}}", $data[0][1]);
			$content=$this->renderView($content, "{{BASICO:DESCRIPCION}}", $data[0][2]);

			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function updateC($id, $name,$description,$idAmigo,$fecha,$idMateria){
			$adminModel=new AdminDB();
			$rta=$adminModel->updateCourse($id, $name,$description,$idAmigo,$fecha,$idMateria);
			$this->courses();
		}

		public function deleteCourse($id){
			$adminModel=new AdminDB();
			$rta=$adminModel->deleteCourse($id);
			$this->courses();
		}

		public function courseRegister($name,$description,$idAmigo,$fecha,$idMateria){
			$adminModel=new AdminDB();
			$rta=$adminModel->addCurso($name,$description,$idAmigo,$fecha,$idMateria);
			if($rta==false){
				//alerta de error
			}else{
				//alerta de exito
			}
			$this->createCourse();
		}
	}
?>