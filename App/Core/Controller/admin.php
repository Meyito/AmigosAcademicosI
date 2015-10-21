<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/adminDB.php";
	include_once "Core/Model/userDB.php";

	class Admin extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_admin.html");
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
			$courses=$this->getCursos2();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}",$courses);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			//gethorario, get cursos, get temas para renderizar la vista.
			$this->showView($index);
		}

		public function getCursos2(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos.html");
			$userModel=new UserDB();
			$data=$userModel->getCursos();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:AMIGO}}", "Denis Gonzales");
				$aux=$this->renderView($aux, "{{BASICO:TEMA}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA}}", $data[$i][4]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
				$list=$list.$aux;
			}
			return $list;
		}
		
		public function statistics(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function changeAvatar(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function help(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function topics(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function showAA(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/administrar_amigos.html");
			
			$aa=$this->getAA();
			$content=$this->renderView($content, "{{CICLO:AMIGOS}}", $aa);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
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
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/administrar_cursos.html");
			$courses=$this->getCursos();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $courses);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function getCursos(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_editable.html");
			$userModel=new UserDB();
			$data=$userModel->getCursos();

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
			$index=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/registrar_amigo_academico.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}

		public function aaUpdate($id){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getUpdate($id);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
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

			$i=0;
			while($i<count($data[1])){
				$template=$this->renderView($template, "{{CHECK".$data[1][$i][0]."".$data[1][$i][1]."}}", "checked");
				$i++;
			}
			
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
			}else{
				//ALERTA ERROR, USUARIO YA REGISTRADO
				echo"error";
			}

			$this->showAA();
		}

		public function createCourse(){
			$index=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/registrar_curso.html");

			$content=$this->listarMaterias($content, -1);			
			$content=$this->listarAmigos($content, -1);

			//Temas Provisional
			$content=$this->listarTemas($content, -1);
			
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}

		public function listarMaterias($content, $id){
			$adminModel=new AdminDB();
			$materias=$adminModel->getMaterias();
			$mat="";
			$template=$this->getTemplate("Core/View/assets/option.html");
			for($i=0; $i<count($materias); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{VALUE}}", $materias[$i][0]);
				$aux=$this->renderView($aux, "{{DATA}}", $materias[$i][1]);

				if($materias[$i][0]==$id){
					$aux=$this->renderView($aux, "{{SELECTED}}", "selected");
				}
				$mat=$mat.$aux;
			}
			$content=$this->renderView($content, "{{CICLO:MATERIAS}}", $mat);

			return $content;
		}

		//Temporal
		public function listarTemas($content, $id){
			$adminModel=new AdminDB();
			$template=$this->getTemplate("Core/View/assets/option.html");
			$temas=$adminModel->getTemas();
			$tm="";
			for($i=0; $i<count($temas); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{VALUE}}", $temas[$i][0]);
				$aux=$this->renderView($aux, "{{DATA}}", $temas[$i][1]);

				if($temas[$i][0]==$id){
					$aux=$this->renderView($aux, "{{SELECTED}}", "selected");
				}
				$tm=$tm.$aux;
			}
			$content=$this->renderView($content, "{{CICLO:TEMAS}}", $tm);

			return $content;
		}

		public function listarAmigos($content, $id){
			$adminModel=new AdminDB();
			$template=$this->getTemplate("Core/View/assets/option.html");
			$amigos=$adminModel->getAmigos();
			$am="";
			for($i=0; $i<count($amigos); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{VALUE}}", $amigos[$i][0]);
				$aux=$this->renderView($aux, "{{DATA}}", $amigos[$i][1]);

				if($amigos[$i][0]==$id){
					$aux=$this->renderView($aux, "{{SELECTED}}", "selected");
				}
				$am=$am.$aux;
			}
			$content=$this->renderView($content, "{{CICLO:AMIGOS}}", $am);

			return $content;
		}

		public function updateCourse($id){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/editar_curso.html");//cambiar

			$adminModel=new AdminDB();
			$data=$adminModel->getCurso($id);

			$content=$this->listarMaterias($content, $data[0][6]);			
			$content=$this->listarAmigos($content, $data[0][3]);
			$content=$this->listarTemas($content, $data[0][1]);

			$hora="03:30";
			$content=$this->renderView($content, "{{BASICO:HORA}}", $hora);
			$content=$this->renderView($content, "{{id}}", $id);
			//$content=$this->renderView($content, "{{BASICO:MATERIA}}", $data[0][6]);
			$content=$this->renderView($content, "{{BASICO:FECHA}}", $data[0][4]);
			//$content=$this->renderView($content, "{{BASICO:AMIGO}}", $data[0][3]);
			//$content=$this->renderView($content, "{{BASICO:TEMA}}", $data[0][1]);
			$content=$this->renderView($content, "{{BASICO:DESCRIPCION}}", $data[0][2]);

			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function updateC($id, $name,$description,$idAmigo,$fecha,$idMateria){
			$adminModel=new AdminDB();
			$rta=$adminModel->updateCurso($id, $name,$description,$idAmigo,$fecha,$idMateria);
			$this->courses();
		}

		public function updateAA($id, $password, $nombre, $semestre, $email, $horario){
			$adminModel=new AdminDB();
			$rta=$adminModel->updateAmigo($id, $password, $nombre, $semestre, $email, $horario);
			$this->showAA();	
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
			$this->courses();
		}
	}
?>