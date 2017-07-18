<?=$this->Html->docType();?>
<html>
<head>
<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
    <title>
        A.N.G.E.L. - the network game
    </title>
    <?= $this->Html->meta(
		'favicon.ico',
		'/favicon.ico',
		['type' => 'icon']
	); ?>

    <?= $this->Html->css('bootstrap-switch.css') ?>
    <?= $this->Html->css('bootstrap-table.css') ?>
    <?= $this->Html->css('glyphicon-regular.min.css') ?>
    <?= $this->Html->css('bootstrap.css') ?>
    <?= $this->Html->css('simple-sidebar.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') ?>
    <?= $this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') ?>

    <?= $this->Html->script('jquery-1.11.3.min.js'); ?>
    <?= $this->Html->script('bootstrap.min.js'); ?>
    <?= $this->Html->script('bootstrap.js'); ?>
    <?= $this->Html->script('bootstrap-switch.js'); ?>
    <?= $this->Html->script('bootstrap-table.js'); ?>
    <?= $this->Html->script('//code.jquery.com/ui/1.11.4/jquery-ui.js'); ?>

    <?= $this->Html->script('bootstrap-table-export.js'); ?>
    <?= $this->Html->script('tableExport.js'); ?>
    <?= $this->Html->script('jquery.base64.js'); ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <!-- Collapse Menu Icon -->
            <div class="collapse-icon">
                <a href="javascript:void(0)" id="toggle-btn" onclick="collapseMenu()"><i class="glyphicon glyphicon-chevron-left"></i></a>
            </div>
            <!-- /Collapse Menu Icon -->
            <!-- Logo -->
            <?= 
                $this->Html->image("/ApiAngel/img/logo.png", [
                    "id" => "logo",
                    "class" => "img-responsive logo",
                    'url' => ['controller' => 'Dashboard', 'action' => 'index']
                ]);
            ?>
            <!-- /Logo -->
            <!-- Menu -->  
			<ul id="menu" class="menu">
				<li>
					<?=
					//El Dashboard 
					$this->Html->link(
					   '<i class="fa fa-2x fa-home" aria-hidden="true"></i> Home',
							['controller' => 'Dashboard', 
							 'action' => 'index'
							],
							['data-original-title'=>'Dashboard',
							 'escape'=>false
							]
					);
					?>
				</li>

				<li>
					<a href="/ApiAngel/Reports/Crossword" name="menuLinks" id="m1">
						<i class="fa fa-2x fa-table" aria-hidden="true"></i>  Crucigrama
					</a>

				<li>
					<a href="/ApiAngel/Reports/Disks" name="menuLinks" id="m1">
						<i class="fa fa-2x fa-circle-o" aria-hidden="true"></i>  Discos
					</a>
				</li>
				<li>
					<a href="/ApiAngel/Reports/Drag" name="menuLinks" id="m1">
						<i class="fa fa-2x fa-hand-pointer-o" aria-hidden="true"></i>  Drag
					</a>
				</li>
				<li>
					<a href="/ApiAngel/Reports/Memory" name="menuLinks" id="m1">
						<i class="fa fa-2x fa-clone" aria-hidden="true"></i>  Memoria
					</a>
				</li>
				<li>
					<a href="/ApiAngel/Reports/Trivia" name="menuLinks" id="m1">
						<i class="fa fa-2x fa-sign-out" aria-hidden="true"></i>  Output interpreter
					</a>
				</li>
			</ul>
            <!-- /Menu -->
        </div>
        <!-- /Sidebar -->
                <div class="web-header">
                    <div class="row">
                        <!-- Icon Section -->
                        <div class="col-sm-1">
                            <i class="fa <?= $pageIcon ?>" aria-hidden="true" style="margin-top: 50%; margin-left: 25%;"></i></h1>
                        </div>
                        <!-- /Icon Section -->
                        <div class="col-sm-6">
                            <!-- Title Section -->
                            <div class="section-sitemap-div">
                                <h1 class="section-title"> <?= $pageTitle ?></h1>
                                <ol class="breadcrumb page-navigation">
                                    <?= $breadcrumbs; ?>
                                </ol>
                            </div>
                            <!-- /Title Section -->                           
                        </div>
                        <div class="col-sm-5">                            
                            <div class="float-right">
                                <div class="user-login">                                    

                                    Bienvenid@
                                    
                                </div>
                                <div class="logout text-right">
                                       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- Content -->
        <div id="page-content-wrapper">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>
        </div>
        <footer>
            
            <!-- /Wrapper -->
        </footer>
    </div>
    <script type="text/javascript">

        $(document).ready(function(){
            var menu = window.localStorage.getItem("menu");
            
            if(menu == null){
                menu = "open";
            }

            if(menu == "open"){
                $("#wrapper").addClass("toggled");
                $("#sidebar-wrapper").addClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(180deg)");
                $("#logo").attr("src","/ApiAngel/img/logo-collapsed.png");
                $("#logo").addClass("open");
                $("#menu").addClass("open");
                $(".submenu").hide(500);
            }
            else if(menu == "close"){
                $("#wrapper").removeClass("toggled");
                $("#sidebar-wrapper").removeClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(0deg)");
                $("#logo").attr("src","/ApiAngel/img/logo.png");
                $("#logo").removeClass("open");
                $("#menu").removeClass("open");
                $(".submenu").show(500);
            }
        });

        function collapseMenu(){

            if($("#wrapper").hasClass("toggled")){
                $("#wrapper").removeClass("toggled");
                $("#sidebar-wrapper").removeClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(0deg)");
                $("#logo").attr("src","/ApiAngel/img/logo.png");
                $("#logo").removeClass("open");
                $("#menu").removeClass("open");
                $(".submenu").show(500);
                window.localStorage.removeItem("menu");
                window.localStorage.setItem("menu", "close");
            }
            else{
                $("#wrapper").addClass("toggled");
                $("#sidebar-wrapper").addClass("open");
                $(".glyphicon-chevron-left").css("transform","rotate(180deg)");
                $("#logo").attr("src","/ApiAngel/img/logo-collapsed.png");
                $("#logo").addClass("open");
                $("#menu").addClass("open");
                $(".submenu").hide(500);
                window.localStorage.removeItem("menu");
                window.localStorage.setItem("menu", "open");
            }

        }
		
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

    </script>

</body>
</html>
