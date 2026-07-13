<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>directorio cientifico — delfin 2026</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',Arial,sans-serif;overflow:hidden;background:#071A2B;height:100vh}

.fondo{position:fixed;inset:0;z-index:0;
    background:radial-gradient(ellipse 70% 50% at 50% 0%,#1a3a5c 0%,#0E2740 35%,#071A2B 70%)}
.fondo::before{content:'';position:absolute;top:-80px;left:50%;transform:translateX(-50%);
    width:700px;height:360px;
    background:radial-gradient(ellipse,rgba(56,198,255,0.06) 0%,transparent 70%);pointer-events:none}
.fondo::after{content:'';position:absolute;inset:0;
    background-image:radial-gradient(circle,rgba(56,198,255,0.05) 1px,transparent 1px);
    background-size:55px 55px;pointer-events:none}

canvas{position:fixed;inset:0;z-index:1;pointer-events:all}

.topbar{position:fixed;top:0;left:0;right:0;z-index:20;
    display:flex;align-items:center;justify-content:space-between;padding:16px 24px;pointer-events:none}
.topbar>*{pointer-events:auto}
.marca{display:flex;align-items:center;gap:10px;text-decoration:none}
.marca-cuadro{width:30px;height:30px;background:rgba(56,198,255,0.12);
    border:1px solid rgba(56,198,255,0.25);border-radius:6px}
.marca-txt{font-size:13px;font-weight:400;color:rgba(255,255,255,.6);letter-spacing:.3px}
.icono-usuario{color:rgba(56,198,255,0.55);cursor:pointer;text-decoration:none;transition:.2s;
    width:34px;height:34px;display:flex;align-items:center;justify-content:center;
    border-radius:50%;border:1px solid rgba(56,198,255,0.18)}
.icono-usuario:hover{color:#38C6FF;border-color:rgba(56,198,255,0.45)}

.page{position:fixed;inset:0;z-index:10;display:flex;flex-direction:column;
    align-items:center;justify-content:center;text-align:center;
    padding:20px;pointer-events:none}
.page>*{pointer-events:auto}

.titulo{margin-bottom:6px}
.titulo h1{font-size:clamp(2rem,4.5vw,3.2rem);font-weight:300;letter-spacing:-.5px;line-height:1.1}
.blanco{color:#fff;text-shadow:0 0 40px rgba(255,255,255,0.1)}
.cian{color:#38C6FF;text-shadow:0 0 30px rgba(56,198,255,0.2)}

.linea-sep{display:flex;align-items:center;justify-content:center;
    margin:10px auto 12px;width:240px}
.linea-sep::before,.linea-sep::after{content:'';flex:1;height:1px;
    background:linear-gradient(to right,transparent,rgba(255,255,255,.12))}
.linea-sep::after{background:linear-gradient(to left,transparent,rgba(255,255,255,.12))}
.punto-naranja{width:5px;height:5px;border-radius:50%;background:#FF8A1E;margin:0 8px;
    box-shadow:0 0 8px rgba(255,138,30,.8),0 0 20px rgba(255,138,30,.3)}

.subtitulo{font-size:clamp(.8rem,1.4vw,.95rem);font-weight:300;
    color:rgba(255,255,255,.55);letter-spacing:.8px;margin-bottom:28px}
.subtitulo .naranja{color:#FF8A1E;font-weight:400}

.tarjetas{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-bottom:22px}
.card-vista{width:250px;background:rgba(255,255,255,.04);border-radius:14px;
    padding:20px;backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);
    cursor:pointer;text-decoration:none;transition:transform .2s,box-shadow .2s;
    display:flex;align-items:flex-start;gap:12px}
.card-vista:hover{transform:translateY(-3px)}
.card-avanzada{border:1px solid rgba(235,116,23,.4);box-shadow:0 2px 20px rgba(235,116,23,.05)}
.card-avanzada:hover{box-shadow:0 8px 28px rgba(235,116,23,.13)}
.card-simple{border:1px solid rgba(56,198,255,.3)}
.card-simple:hover{box-shadow:0 8px 28px rgba(56,198,255,.1)}
.card-icono{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;
    justify-content:center;font-size:18px;flex-shrink:0}
.icono-avanzada{background:rgba(235,116,23,.18);color:#FF8A1E}
.icono-simple{background:rgba(56,198,255,.13);color:#38C6FF}
.card-tit{font-size:13px;font-weight:500;color:#fff;margin-bottom:4px}
.card-desc{font-size:11px;color:rgba(255,255,255,.4);line-height:1.5}

.btn-contacto{display:inline-flex;align-items:center;gap:7px;
    border:1px solid #FF8A1E;color:#FF8A1E;background:transparent;
    border-radius:22px;padding:9px 24px;font-size:12px;font-weight:400;
    cursor:pointer;text-decoration:none;transition:all .2s;font-family:inherit}
.btn-contacto:hover{background:rgba(255,138,30,.1);color:#FF8A1E;
    box-shadow:0 0 18px rgba(255,138,30,.18)}

.hint{position:fixed;bottom:13px;left:50%;transform:translateX(-50%);
    font-size:10px;color:rgba(255,255,255,.16);z-index:20;
    white-space:nowrap;pointer-events:none;letter-spacing:.3px}

/* pop */
.pop-ring{position:fixed;border-radius:50%;pointer-events:none;z-index:15;
    border:1px solid rgba(56,198,255,.7);animation:pop .55s ease-out forwards}
@keyframes pop{0%{opacity:.85;transform:scale(1)}50%{opacity:.35;transform:scale(1.9)}100%{opacity:0;transform:scale(3)}}
.micro{position:fixed;border-radius:50%;pointer-events:none;z-index:15;
    animation:micro .45s ease-out forwards}
@keyframes micro{0%{opacity:.7;transform:scale(1) translate(0,0)}100%{opacity:0;transform:scale(0) translate(var(--dx),var(--dy))}}
</style>
</head>
<body>
<div class="fondo"></div>
<canvas id="cv"></canvas>

<div class="topbar">
    <a href="#" class="marca">
        <div class="marca-cuadro"></div>
        <span class="marca-txt">directorio cientifico</span>
    </a>
    <a href="admin/index.php" class="icono-usuario" title="solo usuarios autorizados">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="17" height="17">
            <circle cx="12" cy="7" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
    </a>
</div>

<div class="page">
    <div class="titulo">
        <h1><span class="blanco">directorio </span><span class="cian">cientifico</span></h1>
    </div>
    <div class="linea-sep"><div class="punto-naranja"></div></div>
    <p class="subtitulo">explora. <span class="naranja">descubre.</span> investiga.</p>

    <div class="tarjetas">
        <a href="directorio-revistas/index.php" class="card-vista card-avanzada">
            <div class="card-icono icono-avanzada">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="19" height="19">
                    <circle cx="10" cy="10" r="6"/><path d="m14.5 14.5 4 4M7 10h6M8 13h4"/>
                </svg>
            </div>
            <div>
                <div class="card-tit">vista avanzada</div>
                <div class="card-desc">directorio completo con filtros, cuartiles e indexaciones</div>
            </div>
        </a>
        <a href="client/index.html" class="card-vista card-simple">
            <div class="card-icono icono-simple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="19" height="19">
                    <path d="M9 6h11M9 12h11M9 18h11M4 6h1M4 12h1M4 18h1"/>
                </svg>
            </div>
            <div>
                <div class="card-tit">vista simplificada</div>
                <div class="card-desc">consulta rapida y sencilla de revistas</div>
            </div>
        </a>
    </div>

    <a href="directorio-revistas/index.php?ruta=/ayuda" class="btn-contacto">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="14" height="14">
            <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/>
        </svg>
        contactanos
    </a>
</div>

<div class="hint">arrastra las burbujas &bull; doble clic para visitar el portal</div>

<script>
var logos = [
    {src:'img/logo_uan.png',              url:'https://www.uan.edu.mx'},
    {src:'img/logo_unidad_economica.png', url:'https://www.uan.edu.mx'},
    {src:'img/logo_delfin.png',           url:'http://www.delfin.edu.mx'},
    {src:'img/logo_upa.png',              url:'https://www.upatlacomulco.edu.mx'},
    {src:'img/logo_udenar.png',           url:'https://www.udenar.edu.co'},
    {src:'img/logo_teccol.png',           url:'https://www.itc.edu.co'},
    {src:'img/TESSFP.png',               url:'https://tessfp.edomex.gob.mx'},
];

var cv=document.getElementById('cv'), ctx=cv.getContext('2d');
var W,H,burbujas=[],imgs=[],cargadas=0,frameN=0;
var mouse={x:0,y:0};
var drag={on:false,b:null,offX:0,offY:0,hx:[],hy:[]};
var presTimer=null, ultClick={idx:-1,t:0};

logos.forEach(function(l,i){
    var img=new Image();
    img.onload=function(){imgs[i]=img;cargadas++;if(cargadas===logos.length)iniciar();};
    img.onerror=function(){imgs[i]=null;cargadas++;if(cargadas===logos.length)iniciar();};
    img.src=l.src;
});

function resize(){W=cv.width=window.innerWidth;H=cv.height=window.innerHeight;}
window.addEventListener('resize',resize);resize();

// zona central libre
var ZX=.5,ZY=.48,ZRX=.25,ZRY=.44;
function enCentro(x,y,r){
    var dx=(x-W*ZX)/(W*ZRX+r), dy=(y-H*ZY)/(H*ZRY+r);
    return dx*dx+dy*dy<1;
}

function posLibre(r){
    for(var i=0;i<40;i++){
        var x=r+Math.random()*(W-r*2), y=r+Math.random()*(H-r*2);
        if(!enCentro(x,y,r)) return {x,y};
    }
    // fallback esquinas
    var esquinas=[{x:r+40,y:r+40},{x:W-r-40,y:r+40},{x:r+40,y:H-r-40},{x:W-r-40,y:H-r-40}];
    return esquinas[Math.floor(Math.random()*4)];
}

function crearBurbuja(logoIdx){
    var r = logoIdx>=0 ? 38+Math.random()*55 : 14+Math.random()*28; // vacias mas pequeñas
    var pos=posLibre(r);
    var ang=Math.random()*Math.PI*2, spd=0.18+Math.random()*0.25;
    return {
        x:pos.x, y:pos.y, r:r,
        vx:Math.cos(ang)*spd, vy:Math.sin(ang)*spd,
        logoIdx: logoIdx,
        fase: Math.random()*Math.PI*2,
        faseVel: 0.006+Math.random()*.006,
        faseAmp: 0.018+Math.random()*.012,
        op:0, arrastrada:false,
        dx:0, dy:0,  // deformacion por colision
    };
}

function iniciar(){
    logos.forEach(function(_,i){
        burbujas.push(crearBurbuja(i));
        burbujas.push(crearBurbuja(i));
    });
    // vacias extras de relleno
    var n=Math.max(8,Math.floor(W*H/70000));
    for(var k=0;k<n;k++) burbujas.push(crearBurbuja(-1));
    loop();
}

function contarLogos(){
    var c={};logos.forEach(function(_,i){c[i]=0;});
    burbujas.forEach(function(b){if(b.logoIdx>=0)c[b.logoIdx]=(c[b.logoIdx]||0)+1;});
    return c;
}
function rellenar(){
    var c=contarLogos();
    logos.forEach(function(_,i){
        if(c[i]===0){
            var b=crearBurbuja(i);
            var lado=Math.floor(Math.random()*4), s=0.35;
            if(lado===0){b.x=-b.r;b.y=Math.random()*H;b.vx=s;b.vy=(Math.random()-.5)*.2;}
            else if(lado===1){b.x=W+b.r;b.y=Math.random()*H;b.vx=-s;b.vy=(Math.random()-.5)*.2;}
            else if(lado===2){b.x=Math.random()*W;b.y=-b.r;b.vx=(Math.random()-.5)*.2;b.vy=s;}
            else{b.x=Math.random()*W;b.y=H+b.r;b.vx=(Math.random()-.5)*.2;b.vy=-s;}
            burbujas.push(b);
        }
    });
}

function loop(){
    ctx.clearRect(0,0,W,H);
    frameN++;
    if(frameN%200===0) rellenar();

    burbujas.forEach(function(b){
        if(!b.arrastrada){
            b.x+=b.vx; b.y+=b.vy;
            b.fase+=b.faseVel;
            if(b.x-b.r<0){b.x=b.r;b.vx=Math.abs(b.vx)*.82;}
            if(b.x+b.r>W){b.x=W-b.r;b.vx=-Math.abs(b.vx)*.82;}
            if(b.y-b.r<0){b.y=b.r;b.vy=Math.abs(b.vy)*.82;}
            if(b.y+b.r>H){b.y=H-b.r;b.vy=-Math.abs(b.vy)*.82;}
            // alejar del centro
            var cx=W*ZX,cy=H*ZY,ddx=b.x-cx,ddy=b.y-cy;
            var nx=ddx/(W*ZRX),ny=ddy/(H*ZRY),d2=nx*nx+ny*ny;
            if(d2<1.05){
                var f=(1.05-d2)*0.01, dd=Math.sqrt(ddx*ddx+ddy*ddy)||1;
                b.vx+=ddx/dd*f; b.vy+=ddy/dd*f;
            }
            var v=Math.sqrt(b.vx*b.vx+b.vy*b.vy);
            if(v<.1){var a=Math.atan2(b.vy,b.vx);b.vx=Math.cos(a)*.15;b.vy=Math.sin(a)*.15;}
            if(v>2){b.vx=b.vx/v*2;b.vy=b.vy/v*2;}
        }
        if(b.op<1) b.op=Math.min(1,b.op+.009);
        b.dx*=.85; b.dy*=.85;
    });

    // atraccion suave al mouse
    if(mouse.x>0) burbujas.forEach(function(b){
        if(b.arrastrada) return;
        var ddx=mouse.x-b.x,ddy=mouse.y-b.y,d=Math.sqrt(ddx*ddx+ddy*ddy);
        if(d<160&&d>0){var f=(160-d)/160*.0025;b.vx+=ddx/d*f;b.vy+=ddy/d*f;}
    });

    // colisiones suaves con deformacion
    for(var i=0;i<burbujas.length;i++) for(var j=i+1;j<burbujas.length;j++){
        var a=burbujas[i],b=burbujas[j];
        var ddx=b.x-a.x,ddy=b.y-a.y,d=Math.sqrt(ddx*ddx+ddy*ddy);
        if(d<a.r+b.r&&d>0){
            var nx=ddx/d,ny=ddy/d,f=(a.r+b.r-d)/(a.r+b.r);
            a.dx-=nx*f*.12; a.dy-=ny*f*.12;
            b.dx+=nx*f*.12; b.dy+=ny*f*.12;
            if(!a.arrastrada){a.vx-=nx*.03;a.vy-=ny*.03;}
            if(!b.arrastrada){b.vx+=nx*.03;b.vy+=ny*.03;}
        }
    }

    // dibujar
    burbujas.forEach(function(b){
        var r=b.r*(1+Math.sin(b.fase)*b.faseAmp);
        var op=b.logoIdx>=0 ? b.op*0.22 : b.op*0.14; // vacias mas tenues
        var bx=b.x+b.dx*b.r, by=b.y+b.dy*b.r;

        ctx.save();
        ctx.globalAlpha=op;

        // forma ligeramente deformada
        ctx.beginPath();
        ctx.ellipse(bx,by,
            r*(1+Math.abs(b.dy)*.06),
            r*(1+Math.abs(b.dx)*.06),
            0,0,Math.PI*2);
        ctx.clip();

        // gradiente interior cristal — multiple capas
        var gr=ctx.createRadialGradient(bx-r*.32,by-r*.38,r*.04,bx,by,r);
        gr.addColorStop(0,  'rgba(200,235,255,0.18)');
        gr.addColorStop(.25,'rgba(100,180,255,0.08)');
        gr.addColorStop(.6, 'rgba(30,90,160,0.04)');
        gr.addColorStop(1,  'rgba(7,26,43,0.28)');
        ctx.fillStyle=gr; ctx.fill();

        // refraccion: zona inferior mas oscura
        var gr2=ctx.createRadialGradient(bx+r*.2,by+r*.3,0,bx,by,r);
        gr2.addColorStop(0,'rgba(0,30,70,0.14)');
        gr2.addColorStop(1,'transparent');
        ctx.fillStyle=gr2; ctx.fill();

        // logo
        if(b.logoIdx>=0&&imgs[b.logoIdx]){
            ctx.globalAlpha=op*3.2;
            var pad=r*.2,d=(r-pad)*2;
            ctx.drawImage(imgs[b.logoIdx],bx-r+pad,by-r+pad,d,d);
        }
        ctx.restore();

        // borde exterior — dos capas para efecto cristal
        ctx.save();
        ctx.globalAlpha=op*2.2;
        ctx.beginPath();
        ctx.ellipse(bx,by,r*(1+Math.abs(b.dy)*.06),r*(1+Math.abs(b.dx)*.06),0,0,Math.PI*2);
        // borde exterior tenue
        ctx.strokeStyle='rgba(120,200,255,0.3)';
        ctx.lineWidth=.8; ctx.stroke();
        ctx.restore();

        // borde interior luminoso
        ctx.save();
        ctx.globalAlpha=op*1.4;
        ctx.beginPath();
        ctx.arc(bx,by,r*.94,0,Math.PI*2);
        ctx.strokeStyle='rgba(180,230,255,0.18)';
        ctx.lineWidth=.5; ctx.stroke();
        ctx.restore();

        // brillo superior izquierdo
        ctx.save();
        ctx.globalAlpha=op*2.8;
        var gr3=ctx.createRadialGradient(bx-r*.28,by-r*.32,0,bx-r*.28,by-r*.32,r*.22);
        gr3.addColorStop(0,'rgba(220,245,255,0.55)');
        gr3.addColorStop(1,'transparent');
        ctx.fillStyle=gr3;
        ctx.beginPath(); ctx.arc(bx-r*.28,by-r*.32,r*.22,0,Math.PI*2); ctx.fill();
        ctx.restore();

        // reflejo secundario inferior derecho (mas sutil)
        ctx.save();
        ctx.globalAlpha=op*1.2;
        var gr4=ctx.createRadialGradient(bx+r*.3,by+r*.35,0,bx+r*.3,by+r*.35,r*.12);
        gr4.addColorStop(0,'rgba(100,180,255,0.2)');
        gr4.addColorStop(1,'transparent');
        ctx.fillStyle=gr4;
        ctx.beginPath(); ctx.arc(bx+r*.3,by+r*.35,r*.12,0,Math.PI*2); ctx.fill();
        ctx.restore();
    });
    requestAnimationFrame(loop);
}

// interaccion
function pxCv(e){
    var r=cv.getBoundingClientRect();
    return{x:(e.touches?e.touches[0].clientX:e.clientX)-r.left,
           y:(e.touches?e.touches[0].clientY:e.clientY)-r.top};
}
function burbujaEn(cx,cy){
    for(var i=burbujas.length-1;i>=0;i--){
        var b=burbujas[i],dx=cx-b.x,dy=cy-b.y;
        if(dx*dx+dy*dy<=b.r*b.r) return i;
    }
    return -1;
}

cv.addEventListener('mousemove',function(e){
    var p=pxCv(e);mouse.x=p.x;mouse.y=p.y;
    if(!drag.on) return;
    drag.b.x=p.x-drag.offX; drag.b.y=p.y-drag.offY;
    drag.hx.push(p.x);drag.hy.push(p.y);
    if(drag.hx.length>8){drag.hx.shift();drag.hy.shift();}
});
cv.addEventListener('mouseleave',function(){mouse.x=0;mouse.y=0;});
cv.addEventListener('mousedown',function(e){
    var p=pxCv(e),idx=burbujaEn(p.x,p.y);
    if(idx<0) return;
    presTimer=setTimeout(function(){
        var b=burbujas[idx];drag.on=true;drag.b=b;
        drag.offX=p.x-b.x;drag.offY=p.y-b.y;
        drag.hx=[p.x];drag.hy=[p.y];
        b.arrastrada=true;b.vx=0;b.vy=0;
        burbujas.splice(idx,1);burbujas.push(b);
    },120);
    e.preventDefault();
});
cv.addEventListener('mouseup',function(){
    clearTimeout(presTimer);
    if(!drag.on) return;
    var b=drag.b,n=drag.hx.length;
    if(n>=2){b.vx=(drag.hx[n-1]-drag.hx[0])*.09;b.vy=(drag.hy[n-1]-drag.hy[0])*.09;
        var v=Math.sqrt(b.vx*b.vx+b.vy*b.vy);if(v>5){b.vx=b.vx/v*5;b.vy=b.vy/v*5;}}
    b.arrastrada=false;drag.on=false;drag.b=null;
});
cv.addEventListener('click',function(e){
    clearTimeout(presTimer);
    var p=pxCv(e),idx=burbujaEn(p.x,p.y);
    if(idx<0) return;
    var ahora=Date.now();
    if(ultClick.idx===idx&&ahora-ultClick.t<380){
        var b=burbujas[idx];
        if(b.logoIdx<0){ultClick.idx=-1;return;}
        // pop
        var ring=document.createElement('div');ring.className='pop-ring';
        ring.style.cssText='width:'+(b.r*2)+'px;height:'+(b.r*2)+'px;left:'+(b.x-b.r)+'px;top:'+(b.y-b.r)+'px';
        document.body.appendChild(ring);setTimeout(function(){ring.remove();},600);
        // microburbujas
        for(var k=0;k<8;k++){(function(){
            var ang=Math.random()*Math.PI*2,dist=b.r*(.5+Math.random()*.8),sz=2+Math.random()*5;
            var m=document.createElement('div');m.className='micro';
            m.style.cssText='width:'+sz+'px;height:'+sz+'px;background:rgba(56,198,255,.55);'
                +'left:'+(b.x-sz/2)+'px;top:'+(b.y-sz/2)+'px;'
                +'--dx:'+(Math.cos(ang)*dist)+'px;--dy:'+(Math.sin(ang)*dist)+'px';
            document.body.appendChild(m);setTimeout(function(){m.remove();},480);
        })();}
        // empujar cercanas
        burbujas.forEach(function(o,oi){
            if(oi===idx) return;
            var dx=o.x-b.x,dy=o.y-b.y,d=Math.sqrt(dx*dx+dy*dy);
            if(d<b.r*3&&d>0){var f=(b.r*3-d)/(b.r*3)*1.5;o.vx+=dx/d*f;o.vy+=dy/d*f;}
        });
        burbujas.splice(idx,1);
        var url=logos[b.logoIdx].url;
        if(url&&url!=='#') setTimeout(function(){window.open(url,'_blank');},90);
        ultClick.idx=-1;
    } else{ultClick.idx=idx;ultClick.t=ahora;}
});
cv.addEventListener('touchstart',function(e){
    var p=pxCv(e),idx=burbujaEn(p.x,p.y);if(idx<0) return;
    presTimer=setTimeout(function(){
        var b=burbujas[idx];drag.on=true;drag.b=b;
        drag.offX=p.x-b.x;drag.offY=p.y-b.y;drag.hx=[p.x];drag.hy=[p.y];
        b.arrastrada=true;b.vx=0;b.vy=0;burbujas.splice(idx,1);burbujas.push(b);
    },120);e.preventDefault();
},{passive:false});
cv.addEventListener('touchmove',function(e){
    clearTimeout(presTimer);if(!drag.on) return;
    var p=pxCv(e);drag.b.x=p.x-drag.offX;drag.b.y=p.y-drag.offY;
    drag.hx.push(p.x);drag.hy.push(p.y);
    if(drag.hx.length>8){drag.hx.shift();drag.hy.shift();}
    e.preventDefault();
},{passive:false});
cv.addEventListener('touchend',function(){
    clearTimeout(presTimer);if(!drag.on) return;
    var b=drag.b,n=drag.hx.length;
    if(n>=2){b.vx=(drag.hx[n-1]-drag.hx[0])*.09;b.vy=(drag.hy[n-1]-drag.hy[0])*.09;
        var v=Math.sqrt(b.vx*b.vx+b.vy*b.vy);if(v>5){b.vx=b.vx/v*5;b.vy=b.vy/v*5;}}
    b.arrastrada=false;drag.on=false;drag.b=null;
});
</script>
</body>
</html>
