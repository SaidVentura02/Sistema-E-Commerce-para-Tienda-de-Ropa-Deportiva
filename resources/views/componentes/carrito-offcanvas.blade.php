{{-- Vista de demostracion. No conecta con MySQL ni procesa pedidos. --}}
<div class="offcanvas offcanvas-end carrito-drawer" tabindex="-1" id="carritoOffcanvas" aria-labelledby="carritoOffcanvasTitulo">
  <div class="offcanvas-header carrito-drawer-header">
    <div>
      <span class="carrito-kicker">TU EQUIPO, TU META</span>
      <h2 class="offcanvas-title" id="carritoOffcanvasTitulo">Mi carrito <span class="carrito-acento">.</span></h2>
      <p class="carrito-subtitulo" id="drawer-articulos-label">3 articulos en tu compra</p>
    </div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar carrito"></button>
  </div>
  <div class="carrito-envio"><i class="bi bi-truck"></i><span>Entrega a domicilio o retiro en sucursal</span></div>
  <div class="offcanvas-body carrito-drawer-body">
    <div id="drawer-list" aria-live="polite"></div>
    <div id="drawer-empty" class="carrito-drawer-empty d-none"><i class="bi bi-bag-x"></i><h3>Tu carrito esta vacio</h3><p>Agrega articulos para comenzar tu compra.</p></div>
    <div class="carrito-sucursales" id="drawer-sucursales"><i class="bi bi-shop"></i><span>Tu compra puede dividirse en pedidos por sucursal.</span></div>
  </div>
  <div class="carrito-drawer-footer">
    <div class="carrito-drawer-total"><span>Subtotal de productos</span><strong id="drawer-subtotal">L 2,520.00</strong></div>
    <p>Impuestos y costos de envio se confirman en checkout.</p>
    <a href="{{ url('/carrito') }}" class="carrito-drawer-btn carrito-drawer-btn-primary"><i class="bi bi-bag-check"></i> Ver carrito completo <i class="bi bi-arrow-right"></i></a>
    <a href="{{ url('/checkout') }}" id="drawer-checkout" class="carrito-drawer-btn carrito-drawer-btn-dark">Continuar al checkout <i class="bi bi-arrow-right"></i></a>
    <div class="carrito-demo-leyenda"><i class="bi bi-info-circle"></i> Interfaz de demostracion. No registra pagos ni pedidos.</div>
  </div>
</div>
