
<!DOCTYPE html>
<html lang="es">
<?php require 'head.view.php'?>
<body>
<button class=" btn position-fixed bg-su-amarillo text-white oculto" id="btnSubir" style="bottom:2%;right:2%;z-index:50;"><i class="fas fa-arrow-up"></i></button>
<?php require 'modal-menu.view.php'?>
    <header>
        <?php require 'carousel.view.php'?>
        <?php require 'perfil-data.view.php'?>
        <?php require '../assets/loaders/small-loader.html';?>
    </header>
    <section id="seccionGeneral">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="column col-12 col-sm-11">

                <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link PestaniaMenu text-white pestania-activa fs-2" data-area="0" href="">Menú</a>
                    <a class="nav-link PestaniaMenu text-white fs-2" data-area="1" href="">Información</a>
                    <a class="nav-link PestaniaMenu text-white fs-2" data-area="2" href="">Carrito</a>
                </div>
                </nav>
                <div class="tab-content">

                
                    <div class="areas " data-area="0"><?php require 'menu-index.view.php'?></div>
                    <div class="areas oculto col-10" data-area="1"><?php require 'informacion.view.php'?></div>
                    <div class="areas col-10 oculto " data-area="2"><?php require 'carrito.view.php'?></div>
                </div>



                </div>
            </div>
        </div>
    </section>

    <button type="button" class="btn bg-su-amarillo text-white position-fixed m-auto <?php if (count($_SESSION['carrito'])==0) {echo 'oculto';}?>" style="z-idex:50;left:0px;right:0px; bottom:5%;width: calc(25% + 200px);" onclick="consultarCarrito()" id="btnConsultarCarrito">
        <div class="row justify-content-between align-items-center ">
            <div class="column col-8 d-flex justify-content-start align-items-center">
                <i class="fas fa-shopping-cart mr-1"></i>
                <p class="text-white Tu pedido mb-0 mr-1 ml-1">Tu pedido</p> 
                <span class=" badge badge-light ml-1" id="cantidadDeitems"><?php echo count($_SESSION['carrito']); ?></span>
            </div>
            <div class="column col-4 d-flex justify-content-end align-items-center">
                <h6 class="mb-0 font-weight-bold" id="totalCarritoBtn"><?php echo '$'.str_replace('.', ',', $totalCarrito);?></h6>
            </div>
        
        </div>
        
    </button>
    <?php require 'footer.view.php'?>
</body>
<script src="../assets/js/functions.js"></script>
<script src="../assets/js/menu.js"></script>

</html>