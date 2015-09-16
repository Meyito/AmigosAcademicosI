<?php

	include_once "Core/Model/userDB.php";

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
			//$pass=$this->encryptPassword($password);

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
					//cargar vista Admin;
				}else if($data["tipo"]==2){
					$_SESSION["tipo"]="AmigoA";
					//cargar vista AA;
				}else{
					$_SESSION["tipo"]="Estudiante";
					//cargar vista Estudiante;
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

		public function base(){
			$template = $this->getTemplate("Core/View/base.html");
			$template = $this->renderView($template, "{{BASICO:NOMBRE}}", $_SESSION["nombre"]);
			$template = $this->renderView($template, "{{BASICO:TIPO_USUARIO}}", $_SESSION["tipo"]);
			return $template;
		}

		public function logout(){

		}

		public function updateProfile(){
			
		}
	}

?>