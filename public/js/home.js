/* Home 3D: carga un tenis GLB de referencia con Three.js. Si falla, usa el modelo conceptual como respaldo. */
const el = (selector) => document.querySelector(selector);
const pantalla = el('#visorTenis');
const mensaje = el('#mensajeVisor');
const botonDespiece = el('#btnDespiece');
const botonGiro = el('#btnGiro');
const botonReiniciar = el('#btnReiniciar');
const botonesPartes = document.querySelectorAll('[data-parte]');
const descripciones = {
  todo: ['Explora cada capa', 'Gira el modelo y activa el despiece para conocer los componentes del calzado.'],
  suela: ['Suela exterior', 'Capa de contacto con el suelo. En un producto real, el material y relieve dependen de su ficha tecnica.'],
  media: ['Entresuela', 'Capa intermedia representada con un material flexible. Esta escena es solo una demostracion conceptual.'],
  corte: ['Corte superior', 'Parte que envuelve el pie y conecta el resto de los componentes del calzado.'],
  cordones: ['Cordones y lengueta', 'Piezas superiores que permiten ajustar el calzado. Los materiales mostrados son ilustrativos.']
};
let THREE, controles, renderizador, escena, camara, zapato, piezas = {}, objetos = [], desarmado = false, giroAutomatico = true;
let tiempoAnterior = 0;
let mallasGLB = []; // Cada malla conserva su posicion original.
let modoGLB = false;
let escalaSeparacion = 0.25;
const URL_MODELO_LOCAL = '/models/tenis-realista.glb';
const URL_MODELO_PUBLICO = 'https://raw.githubusercontent.com/KhronosGroup/glTF-Sample-Assets/main/Models/MaterialsVariantsShoe/glTF-Binary/MaterialsVariantsShoe.glb';

const posicionBase = {};
function mostrarParte(nombre){
  const detalle = descripciones[nombre];
  el('#tituloParte').textContent = detalle[0];
  el('#descripcionParte').textContent = detalle[1];
  botonesPartes.forEach(b => {
    const activo = b.dataset.parte === nombre;
    b.classList.toggle('active', activo);
    b.setAttribute('aria-pressed', String(activo));
  });
  if (!THREE) return;
  if (modoGLB) {
    // Destacar un grupo de mallas: es una agrupacion visual orientativa.
    for (const registro of mallasGLB) {
      const activo = nombre === 'todo' || registro.parte === nombre;
      for (const material of registro.materiales) {
        material.transparent = !activo;
        material.opacity = activo ? 1 : 0.25;
        material.needsUpdate = true;
      }
    }
    return;
  }
  for(const [clave, grupo] of Object.entries(piezas)){
    grupo.traverse(obj => {
      if(obj.isMesh && obj.material && obj.material.emissive){
        obj.material.emissive.setHex(nombre === clave ? 0x31461e : 0x000000);
        obj.material.emissiveIntensity = nombre === clave ? 0.38 : 0;
      }
    });
  }
}
function crearMaterial(color, rugosidad=.65){return new THREE.MeshStandardMaterial({color,roughness:rugosidad,metalness:.09});}
function crearContorno(anchoExtra=0){
  const s = new THREE.Shape();
  s.moveTo(-2.05,-.49-anchoExtra);
  s.bezierCurveTo(-2.45,-.39-anchoExtra,-2.46,.35+anchoExtra,-2.02,.49+anchoExtra);
  s.bezierCurveTo(-1.34,.61+anchoExtra,-.18,.53+anchoExtra,.58,.58+anchoExtra);
  s.bezierCurveTo(1.52,.64+anchoExtra,2.26,.51+anchoExtra,2.29,.12);
  s.bezierCurveTo(2.31,-.55-anchoExtra,1.62,-.67-anchoExtra,.45,-.59-anchoExtra);
  s.bezierCurveTo(-.47,-.53-anchoExtra,-1.5,-.62-anchoExtra,-2.05,-.49-anchoExtra);
  return s;
}
function crearCapa(material, grosor, altura, escala=1, anchoExtra=0){
  const geo = new THREE.ExtrudeGeometry(crearContorno(anchoExtra),{depth:grosor,bevelEnabled:true,bevelSegments:2,steps:1,bevelSize:.035,bevelThickness:.035,curveSegments:16});
  geo.rotateX(Math.PI/2); // El plano original XY se convierte en XZ.
  const m = new THREE.Mesh(geo,material);
  m.scale.set(escala,1,escala);
  m.position.y=altura+grosor;
  m.castShadow=true;m.receiveShadow=true;
  return m;
}
function esfera(grupo,material,x,y,z,sx,sy,sz){
  const m=new THREE.Mesh(new THREE.SphereGeometry(1,28,18),material);
  m.position.set(x,y,z);m.scale.set(sx,sy,sz);m.castShadow=true;grupo.add(m);return m;
}
function cilindroEntre(grupo, material, desde, hasta, radio=.035){
  const a=new THREE.Vector3(...desde),b=new THREE.Vector3(...hasta);
  const d=new THREE.Vector3().subVectors(b,a);
  const m=new THREE.Mesh(new THREE.CylinderGeometry(radio,radio,d.length(),9),material);
  m.position.copy(a).add(b).multiplyScalar(.5);
  m.quaternion.setFromUnitVectors(new THREE.Vector3(0,1,0),d.normalize());m.castShadow=true;grupo.add(m);
}
function crearModelo(){
  zapato=new THREE.Group();escena.add(zapato);
  const goma=crearMaterial('#101c2d'), verde=crearMaterial('#bff269'), espuma=crearMaterial('#f1f3ed'), tela=crearMaterial('#273b56'), panel=crearMaterial('#3c5975'), oscuro=crearMaterial('#172538'), cordon=crearMaterial('#edf4df');
  piezas.suela=new THREE.Group();piezas.media=new THREE.Group();piezas.corte=new THREE.Group();piezas.cordones=new THREE.Group();
  zapato.add(piezas.suela,piezas.media,piezas.corte,piezas.cordones);
  piezas.suela.add(crearCapa(goma,.19,.04,1.01,.05));
  piezas.suela.add(crearCapa(verde,.045,.21,1.005,.025));
  piezas.media.add(crearCapa(espuma,.35,.25,.985,.01));
  const banda=crearCapa(verde,.07,.60,.91,0);piezas.media.add(banda);
  // Forma simplificada del corte superior de un tenis.
  esfera(piezas.corte,tela,-.63,.90,0,1.49,.57,.48);
  esfera(piezas.corte,tela,.80,.83,0,1.30,.43,.45);
  esfera(piezas.corte,oscuro,-1.64,1.09,0,.57,.70,.44);
  esfera(piezas.corte,panel,.72,1.03,-.26,1.11,.25,.16);
  esfera(piezas.corte,panel,.72,1.03,.26,1.11,.25,.16);
  esfera(piezas.corte,verde,1.66,.74,-.19,.44,.12,.10);
  esfera(piezas.corte,verde,-1.72,1.33,-.08,.12,.19,.12);
  // Lengueta y seis cordones hechos con cilindros sencillos.
  esfera(piezas.cordones,oscuro,-.18,1.41,0,.75,.19,.29);
  for(let i=0;i<6;i++){
    const x=.43-i*.22;
    cilindroEntre(piezas.cordones,cordon,[x,1.48,-.265],[x-.07,1.51,.265],.030);
  }
  cilindroEntre(piezas.cordones,verde,[-.86,1.50,-.08],[-.96,1.85,-.05],.045);
  Object.keys(piezas).forEach(k=>posicionBase[k]=piezas[k].position.y);
}
async function cargarModeloRealista(){
  const { GLTFLoader } = await import('three/addons/loaders/GLTFLoader.js');
  const cargador = new GLTFLoader();
  const intentar = (url) => new Promise((resolver,rechazar) => cargador.load(url,resolver,undefined,rechazar));
  let gltf;
  try { gltf = await intentar(URL_MODELO_LOCAL); }
  catch (errorLocal) { gltf = await intentar(URL_MODELO_PUBLICO); }
  const modelo = gltf.scene;
  modelo.updateWorldMatrix(true,true);
  const limites = new THREE.Box3().setFromObject(modelo);
  if (limites.isEmpty()) throw new Error('El GLB no contiene mallas visibles');
  const medida = limites.getSize(new THREE.Vector3());
  const centro = limites.getCenter(new THREE.Vector3());
  const mayor = Math.max(medida.x,medida.y,medida.z);
  if (mayor <= 0) throw new Error('Dimensiones del GLB invalidas');
  escalaSeparacion = mayor * .16;
  const centroY = centro.y;
  // Trasladamos al centro y ajustamos escala para que el producto quepa en la camara.
  modelo.position.sub(centro);
  zapato = new THREE.Group();
  zapato.scale.setScalar(4.4/mayor);
  zapato.add(modelo);
  escena.add(zapato);
  const nombres = [
    {parte:'cordones', patron:/lace|shoelace|tongue|eyelet|cordon|lengueta/i},
    {parte:'suela', patron:/outsole|rubber|bottom|sole[_\s-]*outer|suela/i},
    {parte:'media', patron:/midsole|foam|cushion|entresuela/i},
    {parte:'corte', patron:/upper|mesh|fabric|leather|shoe|corte/i}
  ];
  const meshes = [];
  modelo.traverse((objeto) => { if(objeto.isMesh) meshes.push(objeto); });
  for (const malla of meshes) {
    const caja = new THREE.Box3().setFromObject(malla);
    const elevacion = (caja.getCenter(new THREE.Vector3()).y - centroY) / Math.max(medida.y, .001);
    // Priorizar nombres descriptivos; en otros GLB aproximar por posicion vertical.
    let parte = nombres.find(item => item.patron.test(malla.name) && malla.name.trim().length>2)?.parte;
    if (!parte) parte = elevacion < -.23 ? 'suela' : elevacion < -.04 ? 'media' : elevacion > .27 ? 'cordones' : 'corte';
    const materialesOriginales = Array.isArray(malla.material) ? malla.material : [malla.material];
    const materiales = materialesOriginales.map(m => m.clone());
    malla.material = Array.isArray(malla.material) ? materiales : materiales[0];
    malla.castShadow = true;
    malla.receiveShadow = true;
    mallasGLB.push({malla,parte,original:malla.position.clone(),materiales});
  }
  if(!mallasGLB.length) throw new Error('El GLB no tiene mallas');
  modoGLB = true;
  el('#origenModelo').textContent = 'Modelo GLB realista de referencia · Shopify / Khronos (CC BY 4.0).';
  el('#etiquetaTecnica').textContent = 'MODELO GLB · THREE.JS';
  el('#advertenciaCapas').textContent = 'Separación visual aproximada por mallas; no es un despiece anatómico certificado.';
}
function iniciarLuz(){
  escena.add(new THREE.HemisphereLight('#dce9ff','#192638',2.1));
  const luz1=new THREE.DirectionalLight('#ffffff',3.3);luz1.position.set(2,7,5);escena.add(luz1);
  const luz2=new THREE.DirectionalLight('#b6ff69',2.1);luz2.position.set(-3,3,-5);escena.add(luz2);
  const geometria = new THREE.TorusGeometry(2.8,.008,6,120);
  const anillo=new THREE.Mesh(geometria,new THREE.MeshBasicMaterial({color:'#7fa365',transparent:true,opacity:.32}));
  anillo.rotation.x=Math.PI/2;anillo.position.y=-.25;escena.add(anillo);
  const anillo2=anillo.clone();anillo2.scale.setScalar(.74);anillo2.position.y=-.26;escena.add(anillo2);
}
function ajustarTamano(){
  if(!renderizador)return;
  const w=Math.max(1,pantalla.clientWidth),h=Math.max(1,pantalla.clientHeight);
  renderizador.setSize(w,h,false);camara.aspect=w/h;
  camara.position.set(w<500?6.5:5.4,3.25,w<500?8.6:7.1);
  camara.updateProjectionMatrix();
}
function activarDespiece(){
  desarmado=!desarmado;
  botonDespiece.textContent=desarmado?'Volver a ensamblar':'Separar componentes';
  botonDespiece.classList.toggle('active',desarmado);
  botonDespiece.setAttribute('aria-pressed',String(desarmado));
}
function reiniciar(){
  desarmado=false;botonDespiece.textContent='Separar componentes';botonDespiece.classList.remove('active');botonDespiece.setAttribute('aria-pressed','false');
  giroAutomatico=true;botonGiro.textContent='Pausar rotación';botonGiro.setAttribute('aria-pressed','true');
  if(zapato){zapato.rotation.set(-.12,-.32,.03);controles.target.set(0,0,0);controles.update();}mostrarParte('todo');
}
async function iniciar(){
  try{
    // Importaciones dinamicas: permiten mostrar un mensaje si no hay conexion al CDN.
    THREE=await import('three');
    const modulo=await import('three/addons/controls/OrbitControls.js');
    escena=new THREE.Scene();
    camara=new THREE.PerspectiveCamera(38,1,.1,100);
    renderizador=new THREE.WebGLRenderer({antialias:true,alpha:true});
    renderizador.setPixelRatio(Math.min(window.devicePixelRatio||1,2));
    renderizador.outputColorSpace=THREE.SRGBColorSpace;
    pantalla.appendChild(renderizador.domElement);
    controles=new modulo.OrbitControls(camara,renderizador.domElement);
    controles.enableDamping=true;controles.dampingFactor=.065;controles.enablePan=false;
    controles.minDistance=5.5;controles.maxDistance=13;
    controles.minPolarAngle=Math.PI*.18;controles.maxPolarAngle=Math.PI*.80;
    controles.target.set(0,0,0);
    iniciarLuz();
    mensaje.textContent='Cargando modelo GLB...';
    try { await cargarModeloRealista(); }
    catch (errorModelo) {
      console.warn('No se pudo cargar el GLB; usando modelo conceptual de respaldo:', errorModelo);
      if(zapato) escena.remove(zapato);
      mallasGLB=[];modoGLB=false;crearModelo();
      el('#origenModelo').textContent='Modelo conceptual de respaldo: no se pudo cargar el GLB. Revisa tu conexion o descarga el modelo local.';
      el('#etiquetaTecnica').textContent='MODO RESPALDO · THREE.JS';
      el('#advertenciaCapas').textContent='El modelo conceptual tiene cuatro partes independientes.';
    }
    ajustarTamano();
    zapato.rotation.set(-.12,-.32,.03);
    mensaje.hidden=true;
    const observer=new ResizeObserver(ajustarTamano);observer.observe(pantalla);
    renderizador.setAnimationLoop((t)=>{
      const dt=Math.min((t-tiempoAnterior)/1000,.06)||.016;tiempoAnterior=t;
      const metas=desarmado?{suela:-.60,media:.25,corte:1.30,cordones:2.04}:{suela:0,media:0,corte:0,cordones:0};
      if(modoGLB){
        const alturas={suela:-1.05,media:-.25,corte:.45,cordones:1.15};
        for(const registro of mallasGLB){
          const offset = desarmado ? alturas[registro.parte]*escalaSeparacion : 0;
          const destino=registro.original.y+offset;
          registro.malla.position.y+=(destino-registro.malla.position.y)*Math.min(1,dt*4.3);
        }
      } else {
        for(const [clave,grupo] of Object.entries(piezas)){
          const destino=posicionBase[clave]+metas[clave];
          grupo.position.y+=(destino-grupo.position.y)*Math.min(1,dt*4.3);
        }
      }
      if(giroAutomatico && !controles._isPointerDown) zapato.rotation.y+=dt*.16;
      controles.update();renderizador.render(escena,camara);
    });
  }catch(error){
    mensaje.textContent='No se pudo cargar Three.js. Abre la demostracion con internet y un servidor local (no con doble clic al archivo).';
    mensaje.hidden=false;
    console.error('Error de Three.js:',error);
  }
}
// Eventos de la interfaz: cada boton tiene una accion clara.
botonDespiece.addEventListener('click',activarDespiece);
botonGiro.addEventListener('click',()=>{
  giroAutomatico=!giroAutomatico;
  botonGiro.textContent=giroAutomatico?'Pausar rotación':'Activar rotación';
  botonGiro.setAttribute('aria-pressed',String(giroAutomatico));
});
botonReiniciar.addEventListener('click',reiniciar);
botonesPartes.forEach(b=>b.addEventListener('click',()=>mostrarParte(b.dataset.parte)));
const abrir=()=>{el('#carritoDemo').classList.add('open');el('#carritoDemo').setAttribute('aria-hidden','false');};
const cerrar=()=>{el('#carritoDemo').classList.remove('open');el('#carritoDemo').setAttribute('aria-hidden','true');};
el('#abrirCarrito').addEventListener('click',abrir);
el('#cerrarCarrito').addEventListener('click',cerrar);
el('#carritoDemo').addEventListener('click',e=>{if(e.target.id==='carritoDemo')cerrar();});
document.addEventListener('keydown',e=>{if(e.key==='Escape')cerrar();});
iniciar();
