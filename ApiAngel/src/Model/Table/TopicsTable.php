<?php
	namespace App\Model\Table;

	use App\Model\Entity\Topic;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	// se esta validando la tabla Topics

	class TopicsTable extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('Topics');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //relacion 1:n con tabla UserScore

	        $this->hasMany('UserScore', [
	        	
	        	'foreignKey' => 'TopicId'
        	]);

	    }
	}
?>