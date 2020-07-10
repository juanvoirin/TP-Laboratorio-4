<?php 
 include('header.php');
 include('nav-user.php');
 require_once("validate-session.php");
?>
<div class="pt-5 pb-1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="display-2">Movies to Add<br></h1>
      </div>
    </div>
  </div>
</div>
<div class="py-5">
  <div class="container">
    <div class="row">
    <?php foreach($movieList as $movie) { ?> <!-- Comienzo de tarjeta -->
      <div class="col-md-4 mb-5" style="">
        <div class="card">
          <img class="card-img-top" src="<?php echo $movie->getImage(); ?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
            <p class="card-text"><?php echo $movie->getDescription(); ?></p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Género: <?php echo $movie->genresToString(); ?> </li>
          </ul>
          <div class="card-body mx-auto">
            <a href="<?php echo  FRONT_ROOT."Movie/add?id=".$movie->getId()."&page=".$page; ?>"> 
              <button class="btn btn-primary">Add</button> 
            </a>
          </div>
        </div>
      </div>
      <?php } ?> <!-- Final de la tarjeta -->

<!-- Navegador de paginas -->
</div>
<div class="mb-5">
  <div class="container">
    <div class="row">
    <div class="mx-auto col-md-5">
        <ul class="mx-auto pagination pagination-lg px-2">
          <li class="page-item active"> <a class="page-link" href="<?php echo  FRONT_ROOT."Movie/showAddView?page=1";?>">1</a> </li>
          <li class="page-item"> <a class="page-link" href="<?php echo  FRONT_ROOT."Movie/showAddView?page=2";?>">2</a> </li>
        </ul>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
