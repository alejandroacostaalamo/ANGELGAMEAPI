<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;

/**
 * Este es mi primer comentario - Jauregui DocComment.
 */
class ApiController extends AppController {


	public function index(){

	}

	//Metodo para la consulta del perfil del usuario
	public function profile($token=null){

		if ($this->request->is(['post'])) {

			// echo 'Entro al post';
			//cargar modelo
			$this->loadModel('Users');
			//Consulta de usuario
			$this->set('user',$this->Users
								->find('all')
								->where(['Token'=>$token]));
		}

		$this->set('_serialize', ['user']);
	}

	//Metodo para la consulta del Score
	public function userscore(){

		if ($this->request->is(['post'])) {
			//cargar modelo
			$this->loadModel('User_Scores');
			//Consulta de usuario
			$userscore = $this->User_Scores
								->find('all')
								->select(['Score' => 'User_Scores.Score'])
								->contain(['Users'])
								->first();
			echo $userscore;
		}

		//$this->set('_serialize', ['userscore']);
	}

	//Funcion para registrar Score
	public function score($scores = null, $gameId = null, $levelId = null, $userId = null){
		if ($this->request->is(['post'])) {
			//Registar Puntuacion
			$scoreTable = TableRegistry::get('UserScores');
			$score = $scoreTable->newEntity();
			$score->Score  = $scores;
			$score->GameId = $gameId;
			$score->LevelId = $levelId;
			$score->UserId = $userId;
			$score->Created = date("Y-m-d H:i:s");
;

			//Guardamos los datos
            if ($scoreTable->save($score)) {
                $status = 'The info has been saved.';
            } else {
                $status = 'The event could not be saved. Please, try again.';
            }

            $response = array("Status" => $status);

            $this->set(compact('response'));
            $this->set('_serialize', ["response"]);
        }

	}

	//Funcion para registrar Usuarios
	public function register($name = null, $lastname = null, $token = null, $email = null, $username = null, $image = null, $methodId = null){
		if ($this->request->is(['POST'])) {
			$userTable = TableRegistry::get('Users');
			
			//Auth. por Facebook
			if ($methodId==1) {
				$exists = $userTable->exists(['Token' => $token]);
					if (!$exists) {
						//Registar
						$user = $userTable->newEntity();
						$user->Name  = $name;
						$user->LastName = $lastname;
						$user->Email = $email;
						$user->Username = $username;
						$user->Token = $token;
						$user->Image = $image;
						$user->AuthenticationMethodId = 1;//$methodId;
						$user->StatusId = 1;
						$user->TermId = 1;

						//Guardamos los datos
						if ($userTable->save($user)) {
			                $status = 'The user has been saved.';
			            } else {
			            	$status = 'Error in register.';
			            }
					}else {
						$this->loadModel('Users');
						$this->set('user',$this->Users
										->find('all')
										/*->select(['Id'=>'Users.Id'
															,'Token'=>'Users.Token'
															,'Name'=>'Users.Name'
															,'LastName'=>'User.LastName'
															,'Email'=>'Users.Email'])*/
										->where(['Users.StatusId' => 1, 'Users.Token' => $token])
										->first());
						$status = 'The user has been updated.';
					}
			}elseif ($methodId==2) {
				$exists = $userTable->exists(['Token' => $token]);
					if (!$exists) {
						//Registar
						$user = $userTable->newEntity();
						$user->Name  = $name;
						$user->LastName = $lastname;
						$user->Email = $email;
						$user->Username = $username;
						$user->Token = $token;
						$user->Image = $image;
						$user->AuthenticationMethodId = 2;//$methodId;
						$user->StatusId = 1;
						$user->TermId = 1;
						
						//Guardamos los datos
						if ($userTable->save($user)) {
								$status = 'The user has been saved.';
						} else {
							$status = 'Error in register.';
						} 
					}else {
						$this->loadModel('Users');
						$this->set('user',$this->Users
										->find('all')
										->select(['Id'=>'Users.Id'
															,'Token'=>'Users.Token'
															,'Name'=>'Users.Name'
															,'LastName'=>'User.LastName'
															,'Email'=>'Users.Email'])
										->where(['Users.StatusId' => 1, 'Users.Token' => $token])
										->first());
						$status = 'The user has been updated.';
					}
			} 

			//$response = ["Status" => $status, "User" => $user];

            //$this->set(compact('user'));
            $this->set('_serialize', ["user"]);
        }

	}
}

?>
