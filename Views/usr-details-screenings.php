<?php 
 include_once('header.php');
 include_once('nav-user.php');
 require_once("validate-session.php");
?>
<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-6" style="">
        <h1 class="display-2"><?php echo $movie->getTitle(); ?></h1>
        <form action="<?php echo FRONT_ROOT."Purchase/showPurchaseConfirmation"; ?>" method="post">
          <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Screening</button>
            <div class="dropdown-menu"> 
              <?php foreach($screeningList as $screening) { ?>
              <a class="dropdown-item" href="<?php echo FRONT_ROOT."Screening/showScreeningDetails?idMovie=".$movie->getID()."&idScreening=".$screening->getId();?>"><?php echo $screening->getInfo(); ?></a>
              <?php } ?>
            </div>
          </div>
          <br><br>
          <div class="form-group"> <label>Tickets</label> <input required <?php if($actualScreening==null) echo "disabled"; ?> type="quantity" class="form-control" name="quantity" placeholder="Nº Tickets" id="tickets" min="1" max="<?php echo $remainingSeats; ?>"> </div>
          <button <?php if($actualScreening==null) echo "disabled"; ?> name="idScreening" value="<?php if($actualScreening!=null) echo $actualScreening->getId(); ?>" type="submit" class="btn btn-primary">Buy Tickets</button>
        </form>
      </div>
      <div class="col-md-6" style=""><img class="img-fluid d-block" src="<?php echo $movie->getImage(); ?>" style=""></div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</div>