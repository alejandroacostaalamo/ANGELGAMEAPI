<?php
	namespace App\Model\Table;

	use App\Model\Entity\User;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class UsersTable extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('Users');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //Relacion de 1:m con la tabla UserScores
	        $this->hasMany('UserScores', [
	        	'foreignKey' => 'UserId'
        	]);
        	//Relacion de m:1 con la tabla TermAndConditions
	        $this->belongsTo('TermAndConditions', [
	        	'foreignKey' => 'TermId',
	        		'joinType' => 'INNER',
        	]);
        	//Relacion de m:1 con la tabla AuthenticationMethods  
	        $this->belongsTo('AuthenticationMethods', [
	        	'foreignKey' => 'AuthenticationMethodId',
	        		'joinType' => 'INNER',
        	]);
	    }
	}
?>