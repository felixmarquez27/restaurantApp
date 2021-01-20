<div class="mt-4">
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
            <tbody id="bodyTablaCarritoArea" class="text-white">
            
               <!-----------JAVASCRIPT--------------->
            </tbody>
            </table>
          </div>
            <!-------------------------->
          <div class="text-center text-su-amarillo oculto" id="loaderCarritoArea">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="column col-10 mt-2 mr-4">
                <h3 class="text-right fs-3 text-su-amarillo">TOTAL <span id="totalCarritoArea" class="text-white"></span></h3>
            </div>
         </div>
</div>




<div class="row justify-content-center mt-5 mb-5">
    <div class="column col-12 col-sm-8">
    <h3 class="text-su-amarillo fs-3">Confirma tu Pedido</h3>
        <form id="formCarrito">
        <div class="form-group">
            <label for="form-nombre" class="text-white">Nombre</label>
            <input type="text" class="form-control" id="form-nombre"  required>
        </div>
        <div class="form-group">
            <label for="form-direccion" class="text-white">Dirección</label>
            <input type="text" class="form-control" id="form-direccion"  required>
        </div>
        <div class="form-group">
            <label for="form-telefono" class="text-white">Teléfono</label>
            <input type="tel" class="form-control" id="form-telefono"  required>
        </div>
        <div class="form-group">
            <label for="form-email" class="text-white">Email</label>
            <input type="email" class="form-control" id="form-email" required >
        </div>
        
        <div class="form-group">
            <label for="form-comentario" class="text-white">Comentario Adicional</label>
            <textarea class="form-control" id="form-comentario"></textarea>
        </div>
        <div class="form-group">
        <h3 class="text-su-amarillo fs-3">Tipo de entrega</h3>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipoDeEntrega" id="takeaway" value="Take Away" checked>
                <label class="form-check-label text-white" for="takeaway">Take Away</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipoDeEntrega" id="delivery" value="Delivery">
                <label class="form-check-label text-white" for="delivery">Delivery</label>
            </div>
        </div>
        <div class="form-group">
        <h3 class="text-su-amarillo fs-3">Forma de Pago</h3>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="formadePago" id="efectivo" value="efectivo" checked>
                <label class="form-check-label text-white" for="efectivo">Efectivo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="formadePago" id="mercadopago" value="mercadopago">
                <label class="form-check-label text-white" for="mercadopago">Mercadopago</label>
            </div>
        </div>
        <button type="submit" class="btn btn-amarillo btn-lg btn-block">
        <span class="spinner-border spinner-border-sm mr-1 oculto " role="status" aria-hidden="true" id="spinnerConfirmarPedido"></span>
        Hacer Pedido
        </button>
        
        </form>
        <div class="alert alert-danger mt-3 oculto" role="alert" id="mensajeError">
        
        </div>
    </div>
</div>

<script src="../assets/js/carrito.js"></script>