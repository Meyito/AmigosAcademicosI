<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/adminDB.php";
	include_once "Core/Model/userDB.php";

	class Admin extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_admin.html");
			$this->indexP($index);
		}

		public function statistics(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/estadisticas_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$js=$this->getTemplate("Core/View/assets/estadisticas.html");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $js);
			$this->showView($view);
		}

		public function estadistica3(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/estadisticaPorAmigo.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$js=$this->getTemplate("Core/View/assets/estadisticaPorAmigo.html");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $js);
			$this->showView($view);
		}

		public function estadistica2(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/estadisticaMateriaTema.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$js=$this->getTemplate("Core/View/assets/estadisticaMateriaTema.html");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $js);
			$this->showView($view);
		}


		public function historic(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			$content=$this->getTemplate("Core/View/contenedores/historicos.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$js=$this->getTemplate("Core/View/assets/historicos.html");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $js);
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
			$content=$this->getTemplate("Core/View/contenedores/administrar_temas.html");
			$temas=$this->getTopics();
			$content=$this->renderView($content, "{{CICLO:TEMAS}}", $temas);
			$content=$this->listarMaterias($content, -1);	
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$aux=$this->getTemplate("Static/js/ninjaScripts/dtTemas.js");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $aux);
			$this->showView($view);
		}

		public function agregarTema($tema, $idMateria){
			$userModel=new UserDB();
			$userModel->agregarTemas($tema, $idMateria);
			$this->topics();
		}

		public function desactivarTema($idTema){
			$userModel=new UserDB();
			$userModel->desactivarTema($idTema);
			$this->topics();
		}

		public function activarTema($idTema){
			$userModel=new UserDB();
			$userModel->activarTema($idTema);
			$this->topics();
		}

		public function eliminarTema($idTema){
			$userModel=new UserDB();
			$userModel->eliminarTema($idTema);
			$this->topics();
		}

		public function getTopics(){
			$template=$this->getTemplate("Core/View/assets/temas_admin.html");
			$active=$this->getTemplate("Core/View/assets/temas_activado.html");
			$nactive=$this->getTemplate("Core/View/assets/temas_desactivado.html");
			$userModel=new UserDB();
			$data=$userModel->getTemasAll();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:MATERIA}}", $data[$i][2]);
				$aux=$this->renderView($aux, "{{BASICO:TEMA}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:ID_ELIMINAR}}", $data[$i][0]);

				
				$x=$active;
				if($data[$i][3]!=1){
					$x=$nactive;	
				}

				$x=$this->renderView($x, "{{BASICO:ID_ACTIVAR}}", $data[$i][0]);

				$aux=$this->renderView($aux, "{{COMPUESTO:TEMAS_ACTIVADO}}", $x);
				$list=$list.$aux;
			}
			return $list;
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
			
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);

			$aux=$this->getTemplate("Static/js/ninjaScripts/AjaxTemas-Cursos.js");
			$index=$this->renderView($index, "{{COMPUESTO:LIBRERIAS_JS}}", $aux);
			$this->showView($index);
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
			$content=$this->listarTemas($content, $data[0][1], $data[0][6]);

			$hora="03:30";
			$content=$this->renderView($content, "{{BASICO:HORA}}", $hora);
			$content=$this->renderView($content, "{{id}}", $id);
			//$content=$this->renderView($content, "{{BASICO:MATERIA}}", $data[0][6]);
			$content=$this->renderView($content, "{{BASICO:FECHA}}", $data[0][4]);
			//$content=$this->renderView($content, "{{BASICO:AMIGO}}", $data[0][3]);
			//$content=$this->renderView($content, "{{BASICO:TEMA}}", $data[0][1]);
			$content=$this->renderView($content, "{{BASICO:DESCRIPCION}}", $data[0][2]);

			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$aux=$this->getTemplate("Static/js/ninjaScripts/AjaxTemas-Cursos.js");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", $aux);
			$this->showView($view);
		}

		public function updateC($id,$description,$idAmigo,$fecha,$idMateria, $idTema){
			$adminModel=new AdminDB();
			$rta=$adminModel->updateCurso($id,$description,$idAmigo,$fecha,$idMateria, $idTema);
			$this->courses();
		}

		public function updateAA($id, $password, $nombre, $semestre, $email, $horario){
			$password=$this->encryptPassword($password);
			$adminModel=new AdminDB();
			$rta=$adminModel->updateAmigo($id, $password, $nombre, $semestre, $email, $horario);
			$this->showAA();	
		}

		public function deleteCourse($id){
			$adminModel=new AdminDB();
			$rta=$adminModel->deleteCurso($id);
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

		public function vistaReiniciarSistema(){
			$view=$this->base("Core/View/assets/menu_admin.html");
			//$content=$this->getTemplate("Core/View/contenedores/estadisticas_admin.html");
			$view=$this->renderView($view, "{{COMPUESTO:LIBRERIAS_JS}}", "");
			$this->showView($view);
		}

		public function reiniciar($nombreSem, $cante){
			$adminModel=new AdminDB();
			$adminModel->reiniciarSistema($nombreSem, $cante);
			$this->index();
		}
	}
?>