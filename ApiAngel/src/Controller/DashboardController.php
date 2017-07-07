<?php
namespace App\Controller;

use App\Controller\AppController;

class DashboardController extends AppController{

        public function index(){

		$userId = 0/*$this->Auth->user('Id')*/;

		// Vars
		$this->set('pageIcon', 'fa fa-5x fa-home');        
        $pageTitle = "Home Juego A.N.G.E.L.";
		$breadcrumbs = '<li>Juego A.N.G.E.L.</li>
        <li class="active">Home</li>';
		$this->set('pageTitle', $pageTitle);
		$this->set('_serialize', ['pageTitle']);
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('_serialize', ['breadcrumbs']);
		$this->set('userId', $userId);
        $this->set('_serialize', ['userId']);
                
	}
}
?>
