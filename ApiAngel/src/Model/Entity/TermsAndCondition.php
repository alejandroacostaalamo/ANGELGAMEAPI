<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;
	
	class TermsAndCondition extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>