<!-- template_custom.php -->
<?php
echo ('
<div class="d-flex justify-content-center">
<div id="carouselExample" class="carousel slide " data-bs-ride="carousel">
  <div class="carousel-inner ">
    <div class="carousel-item active">
        <div class="card bg-light" style="width: 18rem;">
            <img src="' . $imagen1 . '" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">'.$title1.'</h5>
                <p class="card-text">' . $content1 . '</p>
                '.$other_content1.'
            </div>
        </div>
    </div>
    <div class="carousel-item">
        <div class="card bg-light" style="width: 18rem;">
            <img src="'.$imagen2.'" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">' . $title2 . '</h5>
                <p class="card-text">' . $content2 . '</p>
                ' . $other_content2 . '
            </div>
        </div>
    </div>
    <div class="carousel-item">
        <div class="card bg-light" style="width: 18rem;">
            <img src="' . $imagen3 . '" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">' . $title3 . '</h5>
                <p class="card-text">' . $content3 . '</p>
                ' . $other_content3 . '
            </div>
        </div>
    </div>
    <div class="carousel-item ">
        <div class="card bg-light" style="width: 18rem;">
            <img src="' . $imagen4 . '" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">' . $title4 . '</h5>
                <p class="card-text">' . $content4 . '</p>
                ' . $other_content4 . '
            </div>
        </div>
    </div>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
</div>');