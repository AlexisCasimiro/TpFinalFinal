<?php
include_once "../../configuracion.php";
include_once "../Estructura/nav.php";
$abmProducto= new AbmProducto();
$colProductos= $abmProducto->buscar(null);

if (count($colProductos)>0){
    for ($i=0; $i < 3; $i++) { 
        $unProducto = $colProductos[$i];
        $destacadosP[$i]['pronombre'] = $unProducto->getNombre();
        $destacadosP[$i]['prodetalle'] = $unProducto->getDetalle();
        $destacadosP[$i]['proprecio'] = $unProducto->getPrecio();
        $destacadosP[$i]['proimagen'] = $unProducto->getImagen();
    }
}
?>
<div class="min-vh-100 d-flex justify-content-center">
<div class="col-12 col-md-12 col-lg-10 bg-body-tertiary h-100 min-vh-100">
    <!-- <Banner> --->
    <div class="d-flex justify-content-center pt-5">
    <div class="d-flex col-10 rounded-3 h-25 bg-body-secondary justify-content-center p-5">
      <div class="align-items-center text-center">
        <h1>Tech Store</h1>
        <p class="fs-5">Transformando casas en hogares, con nuestros electrodomésticos de calidad</p>
      </div>
    </div>
    </div>
    <!-- </Banner> --->
    <div class="border-top w-75 mx-auto my-5">  
    </div>
    <!-- <Catálogo de opciones recomendadas> --->
    <div class="col-10 mt-5 p-5 bg-body-secondary mx-auto">
    <div class="text-center mb-4">
        <h3>Productos destacados</h3>
    </div>
    <div class="d-flex gap-1 row row-cols-2 justify-content-around">
        <!-- <1erItem> --->
        <?php  
        for ($i=0; $i < 3; $i++) { 
            echo '<div class="card text-center" style="width: 18rem;">
            <img src="../imagenes/'.$destacadosP[$i]['proimagen'].'" class="mt-3 card-img-top align-self-center" alt="'.$destacadosP[$i]['pronombre'].'" style="max-height: 300px; max-width: 215px;">
            <h5 class="card-title px-2 pt-2">'.$destacadosP[$i]['pronombre'].'</h5>
            <div class="my-3 px-2 text-center h-25 overflow-y-auto">
                <p class="card-text">'.$destacadosP[$i]['prodetalle'].'</p>
            </div>
            <a href="#" class="btn btn-primary mb-3">Ir a producto</a>
            </div>';
        }
          
        ?>
        <!-- </1erItem> --->
    </div>
    </div>
    <!-- </Catálogo de opciones recomendadas> --->
</div>
</div>
<?php
include_once "../Estructura/footer.php";
?>