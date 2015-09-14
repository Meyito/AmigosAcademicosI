<?php

	include_once "Core/Model/userBD.php";

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
			$pass=$this->encryptPassword($password);

			$userModel=new UserBD();
			$data=$userModel->login($name, $pass);

			print_r($data);
			if($data!=false){
				//cargar los datos de sesion y de acuerdo al usuario cargar la vista asociada.

			}else{
				//ENVIAR ALERTA DE ERROR
				$this->index();
			}

		}

		public function encryptPassword($pass){
			return sha1($pass);
		}
	}

?>