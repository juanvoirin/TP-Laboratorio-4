<?php 
 include('header.php');
 include('nav-user.php');
?>
<div class="py-5 text-center">
    <div class="container">
      <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white p-5">
          <h1 class="mb-4 text-xl-center col-md-5">Revenue</h1>

          <h5 class="font-weight-bold text-xl-left">By Cinema</h5>
          <div class="btn-group" style="float: left">
            <button class="btn btn-primary dropdown-toggle text-xl-left" data-toggle="dropdown">Cinemas</button>
            <div class="dropdown-menu">
            <?php foreach($cinemaList as $cinema) { ?>
	        		<a class="dropdown-item" href="<?php echo FRONT_ROOT."Home/showRevenueCinema?idCinema=".$cinema->getID();?>"><?php echo $cinema->getName() ?>;<br></a>
            <?php } ?>
            </div>
          </div> <br> <br> <br>

          <h5 class="font-weight-bold text-xl-left">By Movie</h5>
          <div class="btn-group" style="float: left">
            <button class="btn btn-primary dropdown-toggle text-xl-left " data-toggle="dropdown">Movies</button>
            <div class="dropdown-menu">
            <?php foreach($movieList as $movie) { ?>
	        		<a class="dropdown-item" href="<?php echo FRONT_ROOT."Home/showRevenueMovie?idMovie=".$movie->getID();?>"><?php echo $movie->getTitle(); ?><br></a>
            <?php } ?>
            </div>
          </div> <br> <br> <br>

          <h5 class="font-weight-bold text-xl-left">By Genre</h5>
          <div class="btn-group" style="float: left">
            <button class="btn btn-primary dropdown-toggle text-xl-left" data-toggle="dropdown">Genres</button>
            <div class="dropdown-menu">
            <?php foreach($genreList as $genre) { ?>
	        		<a class="dropdown-item" href="<?php echo FRONT_ROOT."Home/showRevenueGenre?idGenre=".$genre->getID();?>"><?php echo $genre->getName(); ?><br></a>
            <?php } ?>
            </div>
          </div> <br> <br> <br>

          <h5 class="font-weight-bold text-xl-left">By Date</h5>  
          <form action="<?php echo FRONT_ROOT."Home/showRevenueDate"; ?>" method="post">
          <!--<div class="col-md-5"> Date <input type="date" class="form-control" placeholder="Date" id="Date"> </div>-->
          <input type="date" name="date" class="form-control">
          <br>
	        <button type="submit" class="btn btn-primary float-left col-md-5">Revenue on date</button>
          </form>  <br>  <br> <br> <br> <br>
  
          <a href="<?php echo FRONT_ROOT."Home/index";?>"> <button type="submit" class="btn btn-primary float-left col-md-5">Back to Home</button> </a>
			</div>
	
        
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


