<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;
	
	class AuthenticationMethod extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>