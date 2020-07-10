<?php 
 include_once('header.php');
 include_once('nav-user.php');
 require_once("validate-session.php");
?>
<div class="py-5 text-center">
    <div class="container">
      <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white p-5">
          <h1 class="mb-4">Resume</h1>
          <form action="<?php echo FRONT_ROOT."Purchase/showQRPurchase";?>" method="post">
            <h5 class="font-weight-bold text-xl-left">Movie:</h5>
            <p class="text-xl-left"><?php echo $purchase->getScreening()->getMovie()->getTitle(); ?></p>
            <h5 class="font-weight-bold text-xl-left">Projection:</h5>
            <p class="text-xl-left"><?php echo $purchase->getScreening()->getInfo(); ?></p>
            <h5 class="font-weight-bold text-xl-left">Locations:</h5>
            <p class="text-xl-left"><?php echo $purchase->getQuantity(); ?></p>
            <h5 class="font-weight-bold text-xl-left">Total:</h5>
            <p class="text-xl-left"><?php echo $purchase->getPrice(); ?></p>
            <br>

            <input type="hidden" name="quantity" value="<?php echo $purchase->getQuantity(); ?>">
            <input type="hidden" name="price" value="<?php echo $purchase->getPrice(); ?>">
            <input type="hidden" name="idScreening" value="<?php echo $purchase->getScreening()->getId(); ?>">
            <input type="hidden" name="qr" value="<?php echo $purchase->getQrInfo(); ?>">

            <div class="form-group">  
              <label>Card Type</label> <br>
              <select name="cardType" class="form-control">
                <option value="VISA">Visa</option>
                <option value="MASTERCARD">Mastercard</option>
                <!--  <option value="AMEX">American Express</option> -->
              </select>
            </div>

            <div class="form-group"> 
              <label>Card Number</label> 
              <input required type="text" pattern="[0-9]*" class="form-control" name="cardNumber" placeholder="Card Number (You must enter 16 digits)" size="16" id="cardnumber">
              <br>
              <div class="form-group"> 
                <label>Due date</label> 
                <input required type="date" class="form-control" name="dueDate" min="<?php date("Y/m/d")?>" placeholder="Due Date (The date cannot be expired)" id="duedate"> 
              </div>
              <br>
              <div class="form-group"> 
                <label>Security Code</label> 
                <input required type="number" class="form-control" name="securityCode" placeholder="Security Code (You must enter a valid cvv)" minlength="3" maxlength="4" id="securitycode"> 
              </div>

            </div>
            <br>
            <button type="submit" name="ok" value="1" class="btn btn-primary">Pay and confirm</button>
            <button type="submit" name="ok" value="0" class="btn btn-primary">Cancel</button>
          </form>
			</div>
    </div>
  </div>
</div>
</div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</div>