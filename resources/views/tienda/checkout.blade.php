<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Finalizar compra | Tienda deportiva</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
</head>
<body>
  <header class="site-header">
    <div class="container-xl d-flex justify-content-between align-items-center header-inner">
      <a class="brand" href="{{ url('/') }}"><span class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></span><span>TIENDA <strong>DEPORTIVA</strong><small>MOVE YOUR WORLD</small></span></a>
      <div class="header-right"><span class="secure-chip"><i class="bi bi-shield-lock"></i> Proceso de compra</span><a href="{{ url('/carrito') }}" class="back-cart"><i class="bi bi-arrow-left"></i> Volver al carrito</a></div>
    </div>
  </header>
  <div class="promo-strip"> <i class="bi bi-truck"></i> ENVÍOS A HONDURAS <span>•</span> RETIRO EN TIENDA <span>•</span> PASARELA SIMULADA </div>
  <main class="container-xl py-4 py-lg-5">
    <nav aria-label="Ubicación" class="breadcrumb-trail"><a href="{{ url('/') }}">Inicio</a><i class="bi bi-chevron-right"></i><a href="{{ url('/carrito') }}">Carrito</a><i class="bi bi-chevron-right"></i><span>Finalizar compra</span></nav>
    <div class="heading-row"><div><div class="eyebrow"><i class="bi bi-stars"></i> ESTÁS A UN PASO DE TU META</div><h1>Finalizar compra<span class="lime-dot">.</span></h1><p>Completa tus datos para preparar tus pedidos por sucursal.</p></div><div class="demo-label"><i class="bi bi-bezier2"></i> DEMOSTRACIÓN ACADÉMICA</div></div>
    <div class="steps" aria-label="Pasos del checkout">
      <div class="step active" data-step-indicator="1"><span class="step-number">1</span><span class="step-copy"><strong>Entrega</strong><small>Envío o retiro</small></span></div>
      <div class="step-line"></div>
      <div class="step" data-step-indicator="2"><span class="step-number">2</span><span class="step-copy"><strong>Datos fiscales</strong><small>Información de factura</small></span></div>
      <div class="step-line"></div>
      <div class="step" data-step-indicator="3"><span class="step-number">3</span><span class="step-copy"><strong>Pago</strong><small>Simulación</small></span></div>
    </div>
    <div class="row g-4 align-items-start">
      <section class="col-lg-8" aria-label="Formulario de compra">
        <div class="main-card">
          <div class="card-head"><span class="section-icon"><i class="bi bi-geo-alt"></i></span><div><div class="minor-label">PASO <span id="current-step">01</span> DE 03</div><h2 id="step-title">¿Cómo quieres recibir tu compra?</h2><p id="step-intro">Escoge tu método de entrega y completa los datos necesarios.</p></div></div>
          <form id="checkout-form" novalidate>
            <section class="form-step" data-step="1" aria-label="Entrega">
              <div class="choice-grid">
                <label class="delivery-choice selected" for="delivery-home"><input type="radio" name="tipo_entrega" id="delivery-home" value="envio" checked><span class="choice-symbol"><i class="bi bi-truck"></i></span><strong>Envío a domicilio</strong><small>Recibe tu pedido en la dirección que indiques.</small><i class="bi bi-check-circle-fill choice-check"></i></label>
                <label class="delivery-choice" for="delivery-store"><input type="radio" name="tipo_entrega" id="delivery-store" value="retiro_tienda"><span class="choice-symbol"><i class="bi bi-shop"></i></span><strong>Retiro en tienda</strong><small>Recoge tus pedidos en cada sucursal correspondiente.</small><i class="bi bi-check-circle-fill choice-check"></i></label>
              </div>
              <div id="address-fields"><div class="section-divider"><span>DATOS PARA EL ENVÍO</span></div>
                <div class="row g-3"><div class="col-md-6"><label for="full-name" class="form-label">Nombre de quien recibe <span>*</span></label><input id="full-name" type="text" class="form-control" placeholder="Nombre completo" data-required-address maxlength="150"></div><div class="col-md-6"><label for="phone" class="form-label">Teléfono <span>*</span></label><input id="phone" type="tel" class="form-control" placeholder="Ej. 9999-9999" data-required-address maxlength="20"></div><div class="col-md-6"><label for="department" class="form-label">Departamento <span>*</span></label><select id="department" class="form-select" data-required-address><option value="">Seleccionar departamento</option><option>Francisco Morazán</option><option>Cortés</option><option>Atlántida</option><option>Comayagua</option><option>Otro departamento</option></select></div><div class="col-md-6"><label for="city" class="form-label">Ciudad / municipio <span>*</span></label><input id="city" class="form-control" placeholder="Ej. Tegucigalpa" data-required-address maxlength="100"></div><div class="col-12"><label for="street" class="form-label">Dirección completa <span>*</span></label><textarea id="street" rows="3" class="form-control" placeholder="Colonia, avenida, casa, referencias..." data-required-address maxlength="300"></textarea></div></div>
              </div>
              <div id="pickup-message" class="info-strip d-none"><i class="bi bi-info-circle"></i><span>Tu compra incluye dos sucursales. Cada pedido tendrá su propio punto de retiro, indicado en el resumen.</span></div>
            </section>
            <section class="form-step d-none" data-step="2" aria-label="Datos fiscales">
              <div class="info-strip"><i class="bi bi-receipt"></i><span>Los datos se utilizarán en la factura SAR simulada. La emisión real se implementará en una etapa posterior.</span></div>
              <div class="row g-3 mt-1"><div class="col-md-6"><label class="form-label" for="fiscal-name">Nombre para facturar <span>*</span></label><input class="form-control" id="fiscal-name" placeholder="Nombre o razón social" maxlength="150"></div><div class="col-md-6"><label class="form-label" for="fiscal-rtn">RTN <span class="optional">(opcional para esta demo)</span></label><input class="form-control" id="fiscal-rtn" placeholder="Ej. 08011999123456" inputmode="numeric" maxlength="20"></div><div class="col-12"><label class="form-label" for="fiscal-email">Correo para confirmación <span>*</span></label><input class="form-control" id="fiscal-email" type="email" placeholder="correo@ejemplo.com" maxlength="150"></div></div>
              <div class="fiscal-note"><i class="bi bi-shield-check"></i><div><strong>Facturación separada por sucursal</strong><p>Se prevé una factura por pedido, con su propio correlativo y CAI simulado, según las reglas del proyecto.</p></div></div>
            </section>
            <section class="form-step d-none" data-step="3" aria-label="Pago simulado">
              <div class="section-divider"><span>SELECCIONA UN MÉTODO DE PAGO</span></div>
              <div class="payment-list"><label class="payment-option selected" for="pay-card"><input type="radio" name="metodo_pago" id="pay-card" value="tarjeta" checked><span class="payment-icon"><i class="bi bi-credit-card-2-front"></i></span><span><strong>Tarjeta</strong><small>Pago de demostración, sin datos reales</small></span><i class="bi bi-check-circle-fill payment-check"></i></label><label class="payment-option" for="pay-transfer"><input type="radio" name="metodo_pago" id="pay-transfer" value="transferencia"><span class="payment-icon"><i class="bi bi-bank"></i></span><span><strong>Transferencia bancaria</strong><small>Se simula una referencia de pago</small></span><i class="bi bi-check-circle-fill payment-check"></i></label><label class="payment-option" for="pay-delivery"><input type="radio" name="metodo_pago" id="pay-delivery" value="contra_entrega"><span class="payment-icon"><i class="bi bi-cash-coin"></i></span><span><strong>Contra entrega</strong><small>El pago permanece pendiente hasta el cobro</small></span><i class="bi bi-check-circle-fill payment-check"></i></label></div>
              <div class="info-strip"><i class="bi bi-lock"></i><span>No ingreses números de tarjeta, contraseñas ni datos bancarios reales. Ningún pago se procesa o guarda.</span></div>
              <label class="form-check accept-line"><input id="demo-accept" type="checkbox" class="form-check-input"><span class="form-check-label">Entiendo que esta es una simulación académica y que no se realizará una compra real.</span></label>
            </section>
            <div id="form-alert" class="alert alert-warning mt-3 d-none" role="alert"></div>
            <div id="demo-result" class="result-panel d-none" role="status"><i class="bi bi-check2-circle"></i><div><strong>Simulación completada</strong><p id="demo-result-text">La interfaz recorrió los tres pasos. No se crearon pedidos ni pagos en MySQL.</p></div></div>
            <div class="actions"><button id="prev-btn" type="button" class="btn-back d-none"><i class="bi bi-arrow-left"></i> Anterior</button><button id="next-btn" type="button" class="btn-next">Continuar <i class="bi bi-arrow-right"></i></button></div>
          </form>
        </div>
        <div class="assurance-grid"><span><i class="bi bi-shield-check"></i> Diseño de compra segura</span><span><i class="bi bi-box-seam"></i> Pedidos por sucursal</span><span><i class="bi bi-headset"></i> Soporte al cliente</span></div>
      </section>
      <aside class="col-lg-4" aria-label="Resumen de compra">
        <div class="summary-card"><div class="summary-head"><i class="bi bi-bag-check"></i><h2>Tu pedido</h2><span>3 artículos</span></div><p class="summary-sub">La compra se dividirá por sucursal.</p>
          <div class="store-order"><div class="store-top"><i class="bi bi-geo-alt-fill"></i><strong>Tegucigalpa</strong><span>2 artículos</span></div><div class="summary-item"><div class="thumb thumb-shirt"><i class="bi bi-person-arms-up"></i></div><div><strong>Camiseta Training Pro</strong><small>M · Negro · 1 unidad</small></div><span>L 650</span></div><div class="summary-item"><div class="thumb thumb-short"><i class="bi bi-person-standing"></i></div><div><strong>Short Active Flex</strong><small>L · Gris · 1 unidad</small></div><span>L 420</span></div><div class="store-subtotal"><span>Subtotal sucursal</span><strong>L 1,070.00</strong></div></div>
          <div class="store-order"><div class="store-top"><i class="bi bi-geo-alt-fill"></i><strong>San Pedro Sula</strong><span>1 artículo</span></div><div class="summary-item"><div class="thumb thumb-shoe"><i class="bi bi-lightning-charge-fill"></i></div><div><strong>Tenis Velocity Run</strong><small>42 · Rojo · 1 unidad</small></div><span>L 1,450</span></div><div class="store-subtotal"><span>Subtotal sucursal</span><strong>L 1,450.00</strong></div></div>
          <div class="totals"><div><span>Subtotal productos</span><strong>L 2,520.00</strong></div><div><span>Costo de entrega</span><span>Por calcular</span></div><div><span>ISV</span><span>Por confirmar</span></div><div class="grand-total"><span>Total provisional</span><strong>L 2,520.00</strong></div></div><p class="total-note">Importe ilustrativo antes de confirmar impuestos y envío. No constituye cobro final.</p>
        </div>
        <div class="help-panel"><span><i class="bi bi-question-circle"></i></span><div><strong>¿Necesitas ayuda?</strong><p>Confirma tallas, existencia y punto de retiro antes de finalizar.</p></div></div>
      </aside>
    </div>
    <div class="bottom-demo"><i class="bi bi-info-circle"></i> Prototipo visual: productos, sucursales y montos ficticios. No consulta inventario, no guarda datos y no emite facturas.</div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/checkout-demo.js') }}"></script>
</body>
</html>
