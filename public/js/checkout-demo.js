// Checkout de demostracion: no guarda datos ni procesa pagos.
document.addEventListener('DOMContentLoaded', function () {
  let paso = 1;
  const titulos = [
    ['¿Cómo quieres recibir tu compra?', 'Escoge tu método de entrega y completa los datos necesarios.'],
    ['Tus datos de facturación', 'Confirma la información que aparecería en tus facturas.'],
    ['Elige cómo pagar', 'Selecciona un método de pago simulado para finalizar el recorrido.']
  ];
  const pasos = document.querySelectorAll('.form-step');
  const indicadores = document.querySelectorAll('[data-step-indicator]');
  const anterior = document.getElementById('prev-btn');
  const siguiente = document.getElementById('next-btn');
  const aviso = document.getElementById('form-alert');
  const resultado = document.getElementById('demo-result');

  function mostrarAviso(mensaje) {
    aviso.textContent = mensaje;
    aviso.classList.remove('d-none');
  }
  function limpiarAviso() { aviso.classList.add('d-none'); }
  function actualizarOpciones() {
    document.querySelectorAll('.delivery-choice, .payment-option').forEach(function (tarjeta) {
      tarjeta.classList.toggle('selected', tarjeta.querySelector('input').checked);
    });
    const envio = document.getElementById('delivery-home').checked;
    document.getElementById('address-fields').classList.toggle('d-none', !envio);
    document.getElementById('pickup-message').classList.toggle('d-none', envio);
  }
  function mostrarPaso() {
    limpiarAviso();
    pasos.forEach(function (elemento) { elemento.classList.toggle('d-none', Number(elemento.dataset.step) !== paso); });
    indicadores.forEach(function (item) {
      const n = Number(item.dataset.stepIndicator);
      item.classList.toggle('active', n === paso);
      item.classList.toggle('complete', n < paso);
    });
    document.getElementById('current-step').textContent = String(paso).padStart(2, '0');
    document.getElementById('step-title').textContent = titulos[paso - 1][0];
    document.getElementById('step-intro').textContent = titulos[paso - 1][1];
    anterior.classList.toggle('d-none', paso === 1);
    siguiente.innerHTML = paso === 3 ? 'Simular confirmación <i class="bi bi-check2-circle"></i>' : 'Continuar <i class="bi bi-arrow-right"></i>';
  }
  function validarPaso() {
    if (paso === 1 && document.getElementById('delivery-home').checked) {
      const campos = document.querySelectorAll('[data-required-address]');
      for (const campo of campos) {
        if (!campo.value.trim()) { mostrarAviso('Completa los datos obligatorios de entrega para continuar.'); campo.focus(); return false; }
      }
    }
    if (paso === 2) {
      const nombre = document.getElementById('fiscal-name');
      const correo = document.getElementById('fiscal-email');
      if (!nombre.value.trim()) { mostrarAviso('Indica el nombre para la facturación.'); nombre.focus(); return false; }
      if (!correo.value.trim() || !correo.checkValidity()) { mostrarAviso('Escribe una dirección de correo válida.'); correo.focus(); return false; }
    }
    if (paso === 3 && !document.getElementById('demo-accept').checked) { mostrarAviso('Confirma que comprendes que la operación es solo una simulación.'); return false; }
    return true;
  }
  document.querySelectorAll('input[name="tipo_entrega"], input[name="metodo_pago"]').forEach(function (radio) { radio.addEventListener('change', actualizarOpciones); });
  anterior.addEventListener('click', function () { if (paso > 1) { paso -= 1; resultado.classList.add('d-none'); mostrarPaso(); } });
  siguiente.addEventListener('click', function () {
    if (!validarPaso()) return;
    if (paso < 3) { paso += 1; mostrarPaso(); document.querySelector('.steps').scrollIntoView({ behavior:'smooth', block:'start' }); return; }
    const metodo = document.querySelector('input[name="metodo_pago"]:checked').value;
    const estado = metodo === 'contra_entrega' ? 'pendiente de cobro' : 'simulado, sin autorización bancaria';
    document.getElementById('demo-result-text').textContent = 'Se representaron dos pedidos, uno por sucursal. Método seleccionado: ' + metodo.replace('_', ' ') + ' (' + estado + '). No se creó ningún pedido, factura o pago real.';
    resultado.classList.remove('d-none');
    limpiarAviso();
  });
  actualizarOpciones(); mostrarPaso();
});
