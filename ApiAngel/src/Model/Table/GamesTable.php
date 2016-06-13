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

	        //Relacion de 1:m con la tabla LevelGames
	        $this->hasMany('LevelGames', [
	        	'foreignKey' => 'LevelId'
        	]);

	        //Relacion de 1:m con la tabla UserScore
	        $this->hasMany('UserScore', [
	        	'foreignKey' => 'GameId',
        	]);

	        //Relacion de m:1 con la tabla Topics
	        $this->belongsTo('Topics', [
	        	'foreignKey' => 'TopicId',
                    'joinType' => 'INNER',
        	]);
	    }
	}
?>