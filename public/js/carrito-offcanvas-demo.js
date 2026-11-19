// Demostracion del carrito lateral. Sin Fetch API ni conexiones con MySQL.
document.addEventListener('DOMContentLoaded', function () {
  var panel = document.getElementById('carritoOffcanvas');
  if (!panel) return;
  var formatter = new Intl.NumberFormat('es-HN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  var list = document.getElementById('drawer-list');
  var origin = document.getElementById('cart-list');
  var sample = [
    { name: 'Camiseta Training Pro', category:'Futbol', detail:'Talla M · Negro', store:'Tegucigalpa', price:650, qty:1, image:'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=240&q=80' },
    { name: 'Tenis Velocity Run', category:'Running', detail:'Talla 42 · Rojo', store:'San Pedro Sula', price:1450, qty:1, image:'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=240&q=80' },
    { name: 'Short Active Flex', category:'Gimnasio', detail:'Talla L · Gris', store:'Tegucigalpa', price:420, qty:1, image:'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=240&q=80' }
  ];
  function money(n) { return 'L ' + formatter.format(n); }
  function productData() {
    if (!origin) return sample;
    return Array.from(origin.querySelectorAll('.cart-item')).map(function (node) {
      return {
        source:node,
        name:node.querySelector('.item-info h3')?.textContent.trim() || 'Producto',
        category:node.querySelector('.item-category')?.textContent.trim() || 'Deportivo',
        detail:node.querySelector('.item-info p')?.textContent.trim() || '',
        store:node.dataset.store || '',
        price:Number(node.dataset.price) || 0,
        qty:Number(node.querySelector('output')?.textContent) || 1,
        image:node.querySelector('.item-img img')?.getAttribute('src') || ''
      };
    });
  }
  // Construimos las tarjetas con DOM, no insertamos datos de usuarios como HTML.
  function render() {
    var data = productData();
    list.replaceChildren();
    data.forEach(function (item, index) {
      var card = document.createElement('article'); card.className='drawer-product';
      var imageBox=document.createElement('div'); imageBox.className='drawer-product-img';
      var img=document.createElement('img'); img.src=item.image; img.alt=item.name;
      img.addEventListener('error',function(){imageBox.replaceChildren();var fallback=document.createElement('i');fallback.className='bi bi-bag';imageBox.appendChild(fallback);});
      imageBox.appendChild(img); card.appendChild(imageBox);
      var info=document.createElement('div');
      var cat=document.createElement('span'); cat.className='drawer-product-category';cat.textContent=item.category;info.appendChild(cat);
      var title=document.createElement('h3');title.textContent=item.name;info.appendChild(title);
      var meta=document.createElement('p');meta.className='drawer-product-meta';meta.textContent=item.detail+' · '+item.store;info.appendChild(meta);
      var price=document.createElement('div');price.className='drawer-product-price';price.textContent=money(item.price*item.qty);info.appendChild(price);
      var actions=document.createElement('div');actions.className='drawer-product-actions';
      var qty=document.createElement('div');qty.className='drawer-qty';
      var minus=document.createElement('button'); minus.type='button';minus.textContent='−';minus.setAttribute('aria-label','Reducir '+item.name);minus.disabled=item.qty<=1;
      minus.addEventListener('click',function(){change(index,-1);});
      var count=document.createElement('output');count.textContent=item.qty;
      var plus=document.createElement('button');plus.type='button';plus.textContent='+';plus.setAttribute('aria-label','Aumentar '+item.name);
      plus.addEventListener('click',function(){change(index,1);});
      qty.append(minus,count,plus);
      var remove=document.createElement('button');remove.type='button';remove.className='drawer-remove bi bi-trash3';remove.setAttribute('aria-label','Eliminar '+item.name);remove.addEventListener('click',function(){change(index,0);});
      actions.append(qty,remove);info.appendChild(actions);card.appendChild(info);list.appendChild(card);
    });
    var units=data.reduce(function(acc,item){return acc+item.qty;},0);
    var total=data.reduce(function(acc,item){return acc+item.qty*item.price;},0);
    document.getElementById('drawer-articulos-label').textContent=units+' '+(units===1?'articulo':'articulos')+' en tu compra';
    document.getElementById('drawer-subtotal').textContent=money(total);
    document.getElementById('drawer-empty').classList.toggle('d-none',data.length!==0);
    document.getElementById('drawer-sucursales').classList.toggle('d-none',new Set(data.map(function(i){return i.store;})).size<=1);
    var checkout=document.getElementById('drawer-checkout');checkout.setAttribute('aria-disabled',data.length===0?'true':'false');checkout.tabIndex=data.length===0?-1:0;
    document.querySelectorAll('[data-cart-count]').forEach(function(b){b.textContent=units;});
  }
  function change(index, delta) {
    if (origin) {
      var source=productData()[index]?.source;
      if (!source) return;
      var selector=delta===0?'.remove-item':delta>0?'.plus':'.minus';
      source.querySelector(selector)?.click();
    } else {
      if (delta===0) sample.splice(index,1);
      else sample[index].qty=Math.max(1,sample[index].qty+delta);
    }
    render();
  }
  panel.addEventListener('show.bs.offcanvas',render);
  if (origin) {
    // Se actualiza cuando el carrito completo cambia sin abrir el offcanvas.
    var observer=new MutationObserver(function(){render();});
    observer.observe(origin,{childList:true,subtree:true,characterData:true});
  }
  render();
});
