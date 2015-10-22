<?php

	include_once "Core/Model/userDB.php";
	include_once "Core/Model/studentDB.php";

	class Controller{

		/**
		* Metodo que toma el archivo estatico de la pagina inicial y lo carga en pantalla
		*/
		public function index(){
			$index = $this->getTemplate("Core/View/index.html");
			$this->showView($index);
		}

		/**
		* Metodo que carga un archivo de la vista
		* @param $route - Ruta del archivo a cargar
		* @return string con el valor html que debe ser mostrado
		*/
		public function getTemplate($route){
			return file_get_contents($route);
		}
		
		/**
		*	Toma una vista y la muestra en pantalla en el cliente
		* 	@param $vista - vista preconstruida para mostrar en el navegador
		*/
		public function showView($view){
			echo $view;
		}

		/**
		*	Reemplaza un valor por otro en una cadena de texto. Utilizado para formatear las vistas
		* 	@param $ubicacion - String donde se reemplazará el valor
		* 	@param $cadenaReemplazar - Cadena que será buscada en la $ubicación
		*	@param $reemplazo - Cadena con la que se reemplazará $cadenaReemplazar
		*	@return cadena sobreescrita
		*/
		public function renderView($ubicacion, $cadenaReemplazar, $reemplazo){
			return str_replace($cadenaReemplazar, $reemplazo, $ubicacion);
		}

		public function login($name, $password){
			$password=$this->encryptPassword($password);

			$userModel=new UserDB();
			//$data=$userModel->login($name, $pass);
			$data=$userModel->login($name, $password);

			//print_r($data);
			if($data!=false){
				//cargar los datos de sesion y de acuerdo al usuario cargar la vista asociada.
				$this->setSession($data);
				if($data["tipo"]==1){
					$_SESSION["tipo"]="Administrador";
					header('Location: index.php');
				}else if($data["tipo"]==2){
					$_SESSION["tipo"]="Amigo Académico";
					header('Location: index.php');
				}else{
					$_SESSION["tipo"]="Estudiante";
					header('Location: index.php');
				}
			}else{
				//ENVIAR ALERTA DE ERROR
				$this->index();
			}

		}

		public function encryptPassword($pass){
			return sha1($pass);
		}

		public function setSession($data){
			$_SESSION["codigo"]=$data["id"];
			$_SESSION["nombre"]=$data["nombre"];
			$_SESSION["avatar"]=$data["avatar"];
		}

		public function base($route){
			$template = $this->getTemplate("Core/View/base.html");
			$template = $this->renderView($template, "{{BASICO:NOMBRE}}", $_SESSION["nombre"]);
			$template = $this->renderView($template, "{{BASICO:TIPO_USUARIO}}", $_SESSION["tipo"]);
			$template = $this->renderView($template, "{{BASICO:AVATAR}}", $_SESSION["avatar"]);
			$menu=$this->getTemplate($route);
			$template = $this->renderView($template, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			return $template;
		}

		public function logout(){
			$_SESSION["nombre"] = false;
			$_SESSION["tipo"] = false;
			session_destroy();
			header('location:index.php');
		}

		public function studentRegister($codigo, $nombre, $correo, $semestre, $password){
			$password=$this->encryptPassword($password);
			$studentModel=new StudentDB();
			$avatar="Static/img/avatars/h1.png";
			$rta=$studentModel->addEstudiante($codigo,$password,$nombre,$semestre,$correo,$avatar);
			$this->login($codigo, $password);
		}

		public function indexP($index){
			$content=$this->getTemplate("Core/View/contenedores/inicio_amigo_academico.html");
			$content=$this->getHorario($content);
			$temas=$this->getTemas();
			$content=$this->renderView($content, "{{CICLO:TEMAS_SEMANA}}",$temas);
			$courses=$this->getCursos2();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}",$courses);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
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
				$aux=$this->renderView($aux, "{{BASICO:AMIGO}}", $data[$i]["nombre"]);
				$aux=$this->renderView($aux, "{{BASICO:TEMA}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA}}", $data[$i]["fecha"]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i]["id"]);
				$list=$list.$aux;
			}
		    return $list;
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

		public function getTemas(){
			$template=$this->getTemplate("Core/View/assets/temas_semana.html");
			$userModel=new UserDB();
			$data=$userModel->getTemasActivos();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:MATERIA}}", $data[$i][2]);
				$aux=$this->renderView($aux, "{{BASICO:TEMA}}", $data[$i][1]);
				$list=$list.$aux;
			}
			return $list;
		}

		public function getHorario($content){
			$adminModel=new AdminDB();
			$dias=array(
				array("", "", "", "", "", ""),
				array("", "", "", "", "", ""),
				array("", "", "", "", "", ""),
				array("", "", "", "", "", ""),
				array("", "", "", "", "", "")
			);

			$data=$adminModel->getAgenda();
			$nombre="";

			for($i=0; $i<count($data); $i++){
				$nombre=$data[$i][1];
				for($j=0; $j<count($data[$i][2]); $j++){
					$x=$data[$i][2][$j][0]-1;
					$y=$data[$i][2][$j][1]-2;
					$aux=$dias[$x][$y];
					$dias[$x][$y]=$aux.$nombre." - ";
				}
			}			

			for($j=0; $j<6; $j++){
				$aux="";
				for($i=0; $i<5; $i++){
					$aux=$aux."<td>".$dias[$i][$j]."</td>";
				}
				$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA".($j+2)."}}",$aux);
			}

			return $content;
		}

	}

?>