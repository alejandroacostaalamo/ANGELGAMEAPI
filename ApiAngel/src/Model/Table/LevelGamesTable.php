<?php
	namespace App\Model\Table;

	use App\Model\Entity\LevelGame;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class LevelGamesTable extends Table{
		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('LevelGames');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //Relacion de m:1 con la tabla Levels
	        $this->belongsTo('Levels', [
	        	'foreignKey' => 'LevelId',
                    'joinType' => 'INNER',
        	]);
	        //Relacion de m:1 con la tabla Levels
	        $this->belongsTo('Games', [
	        	'foreignKey' => 'GameId',
                    'joinType' => 'INNER',
        	]);
	    }
	}
?>