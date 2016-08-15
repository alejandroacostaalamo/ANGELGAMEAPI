<?php
	namespace App\Model\Table;

	use App\Model\Entity\UserScore;
	use Cake\ORM\Query;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Table;
	use Cake\Validation\Validator;

// se esta validando las tabla UserScore 

	class UserScoresTable extends Table{

		public function initialize(array $config){
                    
	        parent::initialize($config);

	        //Nombre de la tabla
	        $this->table('UserScores');

	        //Clave primaria
	        $this->primaryKey('Id');

	        //Relacion de m:1 con la tabla Games
	        $this->belongsTo('Games', [
	        	'foreignKey' => 'GameId',
                        'joinType' => 'INNER',
        	]);

	        //Relacion de m:1 con la tabla Users
	        $this->belongsTo('Users', [
	        	'foreignKey' => 'UserId',
                        'joinType' => 'INNER',
        	]);
	        //Relacion de m:1 con la tabla Levels
	        $this->belongsTo('Levels', [
	        	'foreignKey' => 'LevelId',
                        'joinType' => 'INNER',
        	]);
	        //Relacion de m:1 con la tabla Levels
        	$this->belongsTo('Topics', [
	        	'foreignKey' => 'TopicId',
                        'joinType' => 'INNER',
        	]);
	    }
	}
?>