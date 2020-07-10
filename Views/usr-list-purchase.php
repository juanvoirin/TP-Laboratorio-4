<?php 
 include_once('header.php');
 include_once('nav-user.php');
 require_once("validate-session.php");
?>
<div class="pt-5 pb-1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Tickets History<br></h1>
        <h5 class="">Sort by</h5>
        <div class="btn-group">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Date</button>
          <div class="dropdown-menu"> 
            <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Purchase/showListNewest";?>">Newest</a>
            <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Purchase/showListOldest";?>">Oldest<br></a>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Genre</button>
          <div class="dropdown-menu"> 
            <?php foreach($genreList as $genre) { ?>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT."Purchase/showListByGenre?idGenre=".$genre->getId();?>"><?php echo $genre->getName(); ?><br></a>
            <?php } ?>
          </div>
        </div>
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
                <th>Screening</th>
                <th>Sites</th>
                <th>Ticket Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $count = 0;
              foreach($purchaseList as $purchase) { 
                $count++;
              ?>
              <tr>
                <th style="vertical-align: middle"><?php echo $count; ?></th>
                <td style="vertical-align: middle"><?php echo $purchase->getScreening()->getCinema()->getName(); ?></td>
                <td style="vertical-align: middle"><?php echo $purchase->getScreening()->getMovie()->getTitle(); ?></td>
                <td style="vertical-align: middle"><?php echo $purchase->getScreening()->getDate(); ?></td>
                <td style="vertical-align: middle"><?php echo $purchase->getScreening()->getTime(); ?></td>
                <td style="vertical-align: middle"><?php echo $purchase->getQuantity(); ?></td>
                <td style="vertical-align: middle"><?php echo ($purchase->getPrice() / $purchase->getQuantity()); ?></td>
                <td style="vertical-align: middle"><?php echo $purchase->getPrice(); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>