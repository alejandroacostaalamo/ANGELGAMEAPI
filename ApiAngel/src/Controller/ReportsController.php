<?php

namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Controller\AppController;

class ReportsController extends AppController {
   public function crossword(){
        $userId = 0;//$this->Auth->user('Id');

        $pageTitle = "Crucigrama";

        $breadcrumbs = '<li>Juego A.N.G.E.L.</li><li>Ranking</li>
                        <li class="active">Crucigrama</li>';

        $this->set('pageIcon', 'fa fa-5x fa-table');        
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }
	
	 public function memory(){
        $userId = 0;//$this->Auth->user('Id');

        $pageTitle = "Memory";

        $breadcrumbs = '<li>Juego A.N.G.E.L.</li><li>Ranking</li>
                        <li class="active">Memory</li>';

		$this->set('pageIcon', 'fa fa-5x fa-clone');        
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }
	
	 public function disks(){
        $userId = 0;//$this->Auth->user('Id');

        $pageTitle = "Discos";

        $breadcrumbs = '<li>Juego A.N.G.E.L.</li><li>Ranking</li>
                        <li class="active">Discos</li>';

        $this->set('pageIcon', 'fa fa-5x fa-circle-o');        
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }
	
	public function trivia(){
        $userId = 0;//$this->Auth->user('Id');

        $pageTitle = "Output Interpreter";

        $breadcrumbs = '<li>Juego A.N.G.E.L.</li><li>Ranking</li>
                        <li class="active">Output Interpreter</li>';

        $this->set('pageIcon', 'fa fa-5x fa-sign-out');        
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }
	
	public function drag(){
        $userId = 0;//$this->Auth->user('Id');

        $pageTitle = "Drag";

        $breadcrumbs = '<li>Juego A.N.G.E.L.</li><li>Ranking</li>
                        <li class="active">Drag</li>';

        $this->set('pageIcon', 'fa fa-5x fa-hand-pointer-o');        
        $this->set('pageTitle', $pageTitle);
        $this->set('_serialize', ['pageTitle']);
        $this->set('breadcrumbs', $breadcrumbs);
        $this->set('_serialize', ['breadcrumbs']);
        $this->set('userId', $userId);
        $this->set('_serialize', ['userId']); 
    }
	
	public function getranking($report){
        if($this->request->is('GET')){
			$this->loadModel('Pubs');
			
			// Crossword
			if ($report==1){
						$qr="SELECT concat(U.Name,' ', U.LastName) as Name, `Score`, `Created`, G.Name as Game, Level FROM `UserScores` S left join Users U on U.Id = S.`UserId` inner join Games G on G.Id = GameId LEFT join Levels L on L.Id = LevelId where G.Id=1 order by Score desc";
						//echo '<br>'.$qr;		
						$connection = ConnectionManager::get('default');		
						$this->set('Pubs', $connection->execute($qr)->fetchAll('assoc')); 
			}else if ($report==4){ // Memoria
						$qr="SELECT concat(U.Name,' ', U.LastName) as Name, `Score`, `Created`, G.Name as Game, Level FROM `UserScores` S left join Users U on U.Id = S.`UserId` inner join Games G on G.Id = GameId LEFT join Levels L on L.Id = LevelId where G.Id=4 order by Score desc";
						//echo '<br>'.$qr;		
						$connection = ConnectionManager::get('default');		
						$this->set('Pubs', $connection->execute($qr)->fetchAll('assoc')); 
			}
			else if ($report==2){ // Discos
						$qr="SELECT concat(U.Name,' ', U.LastName) as Name, `Score`, `Created`, G.Name as Game, Level FROM `UserScores` S left join Users U on U.Id = S.`UserId` inner join Games G on G.Id = GameId LEFT join Levels L on L.Id = LevelId where G.Id=2 order by Score desc";
						//echo '<br>'.$qr;		
						$connection = ConnectionManager::get('default');		
						$this->set('Pubs', $connection->execute($qr)->fetchAll('assoc')); 
			}
			else if ($report==3){ // Drag
						$qr="SELECT concat(U.Name,' ', U.LastName) as Name, `Score`, `Created`, G.Name as Game, Level FROM `UserScores` S left join Users U on U.Id = S.`UserId` inner join Games G on G.Id = GameId LEFT join Levels L on L.Id = LevelId where G.Id=3 order by Score desc";
						//echo '<br>'.$qr;		
						$connection = ConnectionManager::get('default');		
						$this->set('Pubs', $connection->execute($qr)->fetchAll('assoc')); 
			}
			else { // trivia
						$qr="SELECT concat(U.Name,' ', U.LastName) as Name, `Score`, `Created`, G.Name as Game, Level FROM `UserScores` S left join Users U on U.Id = S.`UserId` inner join Games G on G.Id = GameId LEFT join Levels L on L.Id = LevelId where G.Id=5 order by Score desc";
						//echo '<br>'.$qr;		
						$connection = ConnectionManager::get('default');		
						$this->set('Pubs', $connection->execute($qr)->fetchAll('assoc')); 
			}
			$this->set('_serialize', ['Pubs']);
        }        
    }
}
?>
