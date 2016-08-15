<?php
	namespace App\Model\Table;

	use App\Model\Entity\TermsAndCondition;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	// se esta validando la tabla TermsAndConditions 

	class TermsAndConditions extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('TermsAndConditions');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //Relacion de 1:m con la tabla TermsAndConditions
	        $this->hasMany('Users', [
	        	'foreignKey' => 'TermId'
        	]);
	    }
	}
?>