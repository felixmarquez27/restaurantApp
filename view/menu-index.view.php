<div class="row mt-3">
  <div class="column col-10 col-lg-5">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-su-amarillo dropdown-toggle fs-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorias</button>
                  <div class="dropdown-menu fs-2" id="dropdownMenu">
                  <?php $dataSeccion=0;?>
                  <?php foreach ($todosLosProductos as $key => $value):?>
                      <?php if (count($value)!=0):?>
                        <a class="dropdown-item text-capitalize btnsSecciones" href="#" data-seccion="<?php echo $dataSeccion?>"><?php echo $key;?></a>
                        <?php $dataSeccion++;?>
                      <?php endif;?>
                    <?php endforeach;?>
                  </div>
            </div>
            <input type="text" class="form-control fs-2" aria-label="Text input with dropdown button" placeholder="Escribe un producto" id="inputBuscador">
        </div>

  </div>
</div>


<div class="text-center text-su-amarillo oculto" id="loaderGeneralMenu">
  <div class="spinner-border" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>
<div id="divGeneralMenu">

<?php $posSeccion=0?>
<?php foreach ($todosLosProductos as $key => $value):?>
  <?php if (count($value)!=0):?>
      <div class="row mt-3 secciones" >
        <div class="column col-12" id="<?php echo 'seccion'.$posSeccion;?>">
        <?php $posSeccion++?>
          <h2 class="text-su-amarillo fs-5 text-capitalize"><?php echo $key;?></h2>
        </div>
      </div>


      <div class="row justify-content-center mb-5">
        <div class="column col-12 d-flex justify-content-around flex-wrap div-productos-seccion">
            <?php foreach ($value as $llave => $valor):?>
                <div class="div-producto d-flex justify-content-start mt-3 mb-2 col-12 col-md-10 col-lg-5  p-0" onclick="detalleProducto(<?php echo $valor['idproducto']?>);">
                  <div class="thumb-img-producto">
                    <img src="<?php echo "../assets/img/productos/".$valor['imgproducto'];?> " alt="Hamburguesa Hot-Mex">
                  </div>
                  <div class="thumb-text-producto ml-2 position-relative ">
                    <h3 class="text-su-amarillo fs-3 mb-1 mt-2 text-capitalize font-weight-bold"><?php echo $valor['nombreproducto'];?></h3>
                    <p class="text-white fs-2 text-justify mr-2  mb-0 text-capitalize text-truncado-2lineas"><?php echo $valor['descripcionproducto'];?></p>
                    <div class="thumb-precioProducto col-12 absolute-inf-der">
                      <h5 class="text-su-amarillo font-weight-bold text-right fs-3 "><?php echo '$'.str_replace(".", ",",$valor['pvpproducto']);?></h5>
                    </div>
                  </div>
                  
                </div>

            <?php endforeach;?>
        </div>
      </div>

  <?php endif;?>
<?php endforeach;?>

</div>



          
  </div>

 
</div>
