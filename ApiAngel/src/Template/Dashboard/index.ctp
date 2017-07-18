<div class="div-container">
	<?php echo $this->Form->create(null); ?>
		<div class="container">
			  <h2>Juegos </h2>
			  <div id="myCarousel" class="carousel slide" data-ride="carousel">

				<!-- Wrapper for slides -->
				<div class="carousel-inner">
				  <div class="item active">
					  <div class="row">
						<div class="col-md-6"><img src="/ApiAngel/img/slide/1.png" alt="New York" style="width:58%;    margin-left: 40%;"></div>
						<div class="col-md-6"><img src="/ApiAngel/img/slide/2.png" alt="New York" style="width:58%;margin:auto"></div>
					  </div>
				  </div>

				  <div class="item">
					  <div class="row">
						<div class="col-md-6"><img src="/ApiAngel/img/slide/3.png" alt="New York" style="width:58%;    margin-left: 40%;"></div>
						<div class="col-md-6"><img src="/ApiAngel/img/slide/4.png" alt="New York" style="width:58%;margin:auto"></div>
					  </div>
				  </div>

				  <div class="item">
					  <div class="row">
						<div class="col-md-6"><img src="/ApiAngel/img/slide/5.png" alt="New York" style="width:58%;    margin-left: 40%;"></div>
						<div class="col-md-6"><img src="/ApiAngel/img/slide/6.png" alt="New York" style="width:58%;margin:auto"></div>
					  </div>
				  </div>

				  

				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				  <span class="glyphicon glyphicon-chevron-left"></span>
				  <span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">
				  <span class="glyphicon glyphicon-chevron-right"></span>
				  <span class="sr-only">Next</span>
				</a>
			  </div>
			</div>
	<?php echo $this->Form->end(); ?>
</div>