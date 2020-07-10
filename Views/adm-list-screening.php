<?php 
 include_once('header.php');
 include_once('nav-user.php');
 require_once("validate-session.php");
 require_once("DAO\ScreeningDAO.php");
?>
<div class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Screenings details</h1>
      </div>
    </div>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered ">
            <thead class="thead-dark">
              <tr>
                <th>#</th>
                <th>Cinema</th>
                <th>Movie</th>
                <th>Date</th>
                <th>Time</th>
                <th>Sales</th>
                <th>Revenue</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 0;
              foreach($screeningList as $row){
                $count++;
              ?>
              <tr>
                <th style="vertical-align: middle"><?php echo $count; ?></th> <?php ?>
                <td style="vertical-align: middle"><?php echo $row->getCinema()->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $row->getMovie()->getTitle(); ?></td>
                <td style="vertical-align: middle"><?php echo $row->getDate(); ?></td>
                <td style="vertical-align: middle"><?php echo $row->getTime(); ?></td>
                <td style="vertical-align: middle"><?php echo $purchasesList[$count-1] ?></td>
                <td style="vertical-align: middle"><?php echo "$"; echo ($purchasesList[$count-1] * $row->getCinema()->getPrice()); ?> </td> <!-- CANTIDAD RECAUDADA -->
              <?php } ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="display-2">Add screening</h1>
    </div>
  </div>
</div>
<div class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-2"> Cinema</div>
      <div class="col-md-2"> Movie</div>
      <div class="col-md-2"> Date </div>
      <div class="col-md-2"> Screening time</div>
    </div>
  </div>
</div>
<form action="<?php echo FRONT_ROOT."Screening/add " ?>" method="post">
<div class="mb-5">
  <div class="container">
    <div class="row">
        <div class="col-md-2 form-group">  
          <select name="cinema" class="form-control">
            <?php foreach($cinemaList as $row){ ?>
            <option value="<?php echo $row->getName()?>"><?php echo $row->getName()?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-2 form-group">  
          <select name="movie" class="form-control">
            <?php foreach($movieList as $row){ ?>
            <option value="<?php echo $row->getTitle()?>"><?php echo $row->getTitle()?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-2"> <input type="date" name="date" class="form-control" placeholder="date" id="date"> </div>
        <div class="col-md-2"> <input type="time" name="time" class="form-control" placeholder="time" id="time"> </div>
        <div class="col-md-2"> <button type="submit" class="btn btn-primary">Agregar</button></div>
    </div>
  </div>
</div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>