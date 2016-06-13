<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;
	
	class LevelsGame extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>