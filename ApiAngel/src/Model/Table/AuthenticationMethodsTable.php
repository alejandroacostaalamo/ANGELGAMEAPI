<?php
	namespace App\Model\Table;

	use App\Model\Entity\AuthenticationMethod;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class AuthenticationMethods extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('AuthenticationMethods');

	        //Relacion de 1:m con la tabla User
	        $this->hasMany('Users', [
	        	'foreignKey' => 'AuthenticationMethodId',
        	]);
	    }
	}
?>