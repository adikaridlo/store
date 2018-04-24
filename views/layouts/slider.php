<div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox" id="area-slider">
    <div class="carousel-item active">
      <?php
        echo "<img id='img-slider' src='".Yii::getAlias('@web/template/')."img/slider/1.jpeg' width='300'/>";
      ?>

    </div>
    <div class="carousel-item">
      <!-- <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide"> -->
      <?php
        echo "<img id='img-slider' src='".Yii::getAlias('@web/template/')."img/slider/2.jpg' width='300' alt='Second slide'/>";
      ?>
    </div>
    <div class="carousel-item">
      <!-- <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide"> -->
      <?php
        echo "<img id='img-slider' src='".Yii::getAlias('@web/template/')."img/slider/8.jpg' width='300' alt='Third slide'/>";
      ?>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>