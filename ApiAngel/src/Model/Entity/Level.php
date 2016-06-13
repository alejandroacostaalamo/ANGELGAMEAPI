<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;
	
	class Level extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>