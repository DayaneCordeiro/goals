<?php
	require_once dirname(__DIR__). '/Controller/UserController.php';
	
	class UserClass extends UserController{

		public static function listarCadastrados() {
			return UsuarioController::read();
		}

		public static function registerUser($parameters) {
            require_once dirname(__DIR__). '/config.php';

        // echo "<pre>";
        // print_r($parameters);
        // echo "</pre>";
        // die();
            
			$queryEmail['conditions'] = ' WHERE email = "'.$parameters['user']['email'].'"';
			$searchEmail = UserController::read($queryEmail);

			$queryUsername['conditions'] = ' WHERE username = "'.$parameters['user']['username'].'"';
            $searchUsername = UserController::read($queryUsername);
            
            // echo "<pre>";
            // print_r($queryEmail);
            // echo "</pre>";
            // die();

		    if (!empty($searchEmail)) {
			    return 'This E-mail has already been registered previously.';
		    }
		    elseif (!empty($searchUsername)) {
		    	return 'This Username is not available.';
		    }
		    else {
                $insertion = 'DEFAULT, "'.$parameters['user']['email'].'", "'.$parameters['user']['username'].'", "'.$parameters['user']['password'].'"';
                UserController::create($insertion);

                
                
		    	return 'User successfully registered!';
		    }
		}

		public static function removerUsuario($id) {
			UserController::delete($id);
			return 'Usuário removido com sucesso';
		}

		public static function loginUsuario($parametros) {
			$query['select'] 		= ' usuario.id, usuario.nome, usuario.sobrenome, usuario.administrador, usuario.email, usuario.situacao ';
			$query['conditions'] 	= ' WHERE usuario.email = "'.$parametros['data']['usuario']['email'].'" AND usuario.senha = "'. $parametros['data']['usuario']['senha'].'"';

			$result = UsuarioController::read($query);

			if (!empty($result)) {
				if ($result[0]['situacao'] == 'PENDENTE') {
					return 'PENDENTE';
				} else if ($result[0]['situacao'] == 'INATIVO') {
					return 'INATIVO';
				}
				$administrador = ($result[0]['administrador'] == 'NÃO') ? 'NAO' : 'SIM';

				setcookie('id', $result[0]['id']);
				setcookie('nome', $result[0]['nome']);
				setcookie('sobrenome', $result[0]['sobrenome']);
				setcookie('administrador', $administrador);
				setcookie('email',  $result[0]['email']);

				return 'Dados válidos.';
			}
			
			return 'Dados inválidos, tente novamente.';
		}

		public static function logoffUsuario() {
			setcookie('id');
			setcookie('nome');
			setcookie('sobrenome');
			setcookie('administrador');
			setcookie('email');
		}

		public static function procurarUsuario($id) {
			$dados['conditions'] = ' WHERE id = '.$id;
			$result = UsuarioController::read($dados);
			return $result;
		}

		public static function listarAnalistas() {
			$parametros['select'] = ' nome, sobrenome, id ';
			$parametros['conditions'] = ' WHERE situacao = "ATIVO"';
			return UsuarioController::read($parametros);
		}

		public static function atualizarUsuario($parametros) {
			require 'C:/xampp/htdocs/TIS_III/SANF-MPMG-TIS-III/config.php';

			//VERIFICA SE O EMAIL JÁ ESTÁ CADASTRADO PARA ALGUM USUÁRIO ALÉM DO QUE SE ESPERA EDITAR
			$queryEmail['conditions'] = ' WHERE email = "'.$parametros['usuario']['email'].'" AND id <> '.$parametros['usuario']['id'];
			$consultaEmail = UsuarioController::read($queryEmail);

			if (empty($consultaEmail)) {
				//VERIFICA SE O CPF JÁ ESTÁ CADASTRADO PARA ALGUM USUÁRIO ALÉM DO QUE SE ESPERA EDITAR
				$queryCpf['conditions'] = ' WHERE cpf = "'.$parametros['usuario']['cpf'].'" AND id <> '.$parametros['usuario']['id'];
				$consultaCpf = UsuarioController::read($queryCpf);

				if (empty($consultaCpf)) {
					$query['conditions'] = 'id = "'.$parametros['usuario']['id'].'"';
					$query['dados'] = 'nome = "'.$parametros['usuario']['nome'].'"'.
									', sobrenome = "'.$parametros['usuario']['sobrenome'].'"'.
									', cpf = "'.$parametros['usuario']['cpf'].'"'.
									', email = "'.$parametros['usuario']['email'].'"'.
									', telefone = "'.$parametros['usuario']['telefone'].'"'.
									', cargo = "'.$parametros['usuario']['cargo'].'"'.
									', matricula = "'.$parametros['usuario']['matricula'].'"';

					$result = UsuarioController::update($query);
					
					return $result;
				} else {
					return 'CPF existente';
				}
			} else {
				return 'Email existente';
			}
		}
	}
?>