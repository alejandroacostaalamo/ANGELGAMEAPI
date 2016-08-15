<?php
	namespace App\Model\Table;

	use App\Model\Entity\Game;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class GamesTable extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('Games');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //Relacion de 1:m con la tabla UserScore
	        $this->hasMany('UserScore', [
	        	'foreignKey' => 'GameId',
        	]);

	    }
	}
?>