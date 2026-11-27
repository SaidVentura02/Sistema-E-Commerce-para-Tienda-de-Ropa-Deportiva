// Interacciones de demostración. No se realizan peticiones a la base de datos.
document.addEventListener('DOMContentLoaded', function () {
  var list = document.getElementById('cart-list');
  var formatter = new Intl.NumberFormat('es-HN', {minimumFractionDigits:2, maximumFractionDigits:2});
  function money(value) { return 'L ' + formatter.format(value); }
  function items() { return Array.from(list.querySelectorAll('.cart-item')); }
  function update() {
    var subtotal = 0, units = 0;
    items().forEach(function(item) {
      var qty = Number(item.querySelector('output').textContent);
      var amount = Number(item.dataset.price) * qty;
      item.querySelector('.item-total').textContent = money(amount);
      subtotal += amount; units += qty;
    });
    document.getElementById('subtotal').textContent = money(subtotal);
    document.getElementById('total').textContent = money(subtotal);
    document.getElementById('units').textContent = units;
    document.getElementById('mini-count').textContent = units;
    document.getElementById('item-label').textContent = items().length + (items().length === 1 ? ' artículo' : ' artículos');
    document.getElementById('empty-cart').classList.toggle('d-none', items().length !== 0);
    document.getElementById('checkout-btn').disabled = items().length === 0;
  }
  list.addEventListener('click', function(event) {
    var button = event.target.closest('button'); if (!button) return;
    var item = button.closest('.cart-item'); if (!item) return;
    var count = item.querySelector('output');
    if (button.classList.contains('plus')) count.textContent = Number(count.textContent) + 1;
    if (button.classList.contains('minus')) count.textContent = Math.max(1, Number(count.textContent) - 1);
    if (button.classList.contains('remove-item')) item.remove();
    update();
  });
  document.getElementById('clear-cart').addEventListener('click', function(){ list.innerHTML = ''; update(); });
  document.querySelectorAll('input[name="delivery"]').forEach(function(input) {
    input.addEventListener('change', function () { document.getElementById('shipping-text').textContent = input.value === 'retiro' ? 'Sin envío' : 'Por calcular'; });
  });
  document.getElementById('checkout-btn').addEventListener('click', function () {
    var stores = [...new Set(items().map(function(i){return i.dataset.store;}))];
    document.getElementById('toastText').textContent = 'Demo: la compra se dividiría en ' + stores.length + (stores.length === 1 ? ' pedido' : ' pedidos') + ' según la sucursal. El checkout se implementará después.';
    bootstrap.Toast.getOrCreateInstance(document.getElementById('demoToast')).show();
  });
  update();
});
<script src="{{ asset('js/carrito-offcanvas-demo.js') }}"></script>