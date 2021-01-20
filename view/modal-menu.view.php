<!-- Modal -->
<div class="modal fade " id="modalProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-su-negro-fondo">
      <div class="modal-header">
        <h5 class="modal-title text-su-amarillo text-capitalize" id="modalProductoLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-su-amarillo">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row justify-content-center">
            <div class="column col-8">
              <img src=".." alt="" style="width:100%;" id="imgModal">
            </div>

          </div>
          <div class="row justify-content-center my-3">
            <div class="column col-8">
              <p class="text-white text-justify text-capitalize" id="modalDescripcion"></p>
                <h5 class="text-su-amarillo text-center">Precio: <span class="text-white" id="modalPrecio">$600</span></h5>
            </div>
          </div>
          <div class="row justify-content-center mt-3">
                <div class="column col-6 col-sm-5 col-md-4 col-xl-2">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <button class="btn bg-su-amarillo text-white" onclick="restarCantidad();">-</button>
                        </div>
                        <input type="text" class="form-control text-center" disabled value=1 id="inputCantidad">
                        <div class="input-group-append">
                        <button class="btn bg-su-amarillo text-white" onclick="sumarCantidad();">+</button>
                        </div>
                      </div>
                </div>
                
          </div>


          <div class="row mt-4">
            <div class="column col-12">
                <form id=formModalProducto>
                <!----------javascript-------------->
                </form>
            </div>
          </div>
          <div class="row mt-2 justify-content-center">
            <div class="column col-8">
                  <h4 class="text-su-amarillo fs-3 text-capitalize">Aclaraciones al restaurante</h4>
                  <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" id="textAreaComentario"></textarea>
                  </div>
              </div>
          
          
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Seguir Viendo</button>
        <button type="button" class="btn btn-amarillo d-flex align-items-center" id="btnAgregarAlCarrito" data-id="">
        <span class="spinner-border spinner-border-sm mr-1 oculto" role="status" aria-hidden="true" id="spinnerAgregarAlCarrito"></span>
        Agregar
        </button>
      </div>
    </div>
  </div>
</div>




<!-- Modal CARRITO -->
<div class="modal fade" id="modalCarrito" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalCarritoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-su-negro-fondo">
      <div class="modal-header">
        <h5 class="modal-title text-su-amarillo" id="modalCarritoLabel">Carrito de Compras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-su-amarillo">&times;</span>
        </button>
      </div>
       
      <div class="modal-body">
          <!-------------------------->
          <div class="table-responsive-sm">
            <table class="table table-sm tabla-carrito-modal fs-3 table-borderless">
            <thead class="bg-verde">
                <tr class="text-su-amarillo">
                <th scope="col" class="text-center align-middle">Cant</th>
                <th scope="col" class="text-left align-middle">Producto</th>
                <th scope="col" class="text-right align-middle">Subtotal</th>
                <th scope="col" class="text-center align-middle">Eliminar</th>
                </tr>
            </thead>
            <tbody id="bodyTablaCarritoModal" class="text-white">
            
               <!-----------JAVASCRIPT--------------->
            </tbody>
            </table>
          </div>
            <!-------------------------->
          <div class="text-center text-su-amarillo oculto" id="loaderModalCarrito">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
      </div>
      <div class="row justify-content-end">
        <div class="column col-10 mt-2 mr-4">
            <h3 class="text-right fs-3 text-su-amarillo">TOTAL <span id="totalModal" class="text-white"></span></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary text-white fs-small fs-2" data-dismiss="modal">Seguir Comprando</button>
        <button class="btn bg-su-amarillo text-white fs-small fs-2" onclick="irA(PestaniaMenu[2])" data-dismiss="modal">Ir a Caja</button>
      </div>
    </div>
  </div>
</div>
 