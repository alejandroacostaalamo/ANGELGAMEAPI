<?php
	namespace App\Model\Table;

	use App\Model\Entity\Level;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	//se esta validando la tabla LevelsTable

	class LevelsTable extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('Levels');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //Relacion de 1:m con la tabla LevelGames
	        $this->hasMany('UserScore', [
	        	
	        	'foreignKey' => 'LevelId'
        	]);

	    }
	}
?>