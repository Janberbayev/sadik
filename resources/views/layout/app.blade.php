<!DOCTYPE html>
<html lang="{{ public_locale() }}">

{{--Head--}}
@include('layout.header')

<body>
<!-- NAVBAR -->
@include('layout.navbar')

{{--Main Content--}}
@yield('content')

<!-- FOOTER -->
@include('layout.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function(){
        function drawAlmaLogo(cv) {
            const ctx = cv.getContext('2d');
            const W = 120, H = 120;
            ctx.clearRect(0, 0, W, H);

            // RIGHT ARM — up-right, thumb up
            ctx.strokeStyle='#777'; ctx.lineWidth=9; ctx.lineCap='round';
            ctx.beginPath(); ctx.moveTo(68,56); ctx.bezierCurveTo(76,46,82,36,84,26); ctx.stroke();

            // Right glove
            ctx.fillStyle='white'; ctx.strokeStyle='#bbb'; ctx.lineWidth=1.4;
            ctx.beginPath(); ctx.ellipse(87,20,11,10,0.1,0,Math.PI*2); ctx.fill(); ctx.stroke();
            // 4 fingers curled (small bumps top)
            for(let i=0;i<4;i++){
                const fx=80+i*5, fy=13;
                ctx.beginPath(); ctx.ellipse(fx,fy,3,5,0,0,Math.PI*2);
                ctx.fillStyle='white'; ctx.fill();
                ctx.strokeStyle='#bbb'; ctx.lineWidth=1; ctx.stroke();
                ctx.beginPath(); ctx.moveTo(fx-2,fy+3); ctx.lineTo(fx+2,fy+3);
                ctx.strokeStyle='#ccc'; ctx.lineWidth=0.8; ctx.stroke();
            }
            // thumb pointing up (left side of glove)
            ctx.beginPath();
            ctx.moveTo(78,22);
            ctx.bezierCurveTo(74,16,72,9,74,5);
            ctx.bezierCurveTo(76,1,80,2,81,6);
            ctx.bezierCurveTo(83,11,81,18,79,22);
            ctx.closePath();
            ctx.fillStyle='white'; ctx.fill();
            ctx.strokeStyle='#bbb'; ctx.lineWidth=1.2; ctx.stroke();
            ctx.beginPath(); ctx.moveTo(75,12); ctx.lineTo(81,12);
            ctx.strokeStyle='#ccc'; ctx.lineWidth=0.9; ctx.stroke();
            // cuff
            ctx.beginPath(); ctx.moveTo(77,28); ctx.bezierCurveTo(83,32,93,31,98,28);
            ctx.strokeStyle='#ccc'; ctx.lineWidth=1.2; ctx.stroke();

            // LEFT ARM — down-left
            ctx.strokeStyle='#777'; ctx.lineWidth=9; ctx.lineCap='round';
            ctx.beginPath(); ctx.moveTo(36,66); ctx.bezierCurveTo(28,76,22,86,20,96); ctx.stroke();

            // Left glove — index finger pointing right
            ctx.fillStyle='white'; ctx.strokeStyle='#bbb'; ctx.lineWidth=1.4;
            ctx.beginPath(); ctx.ellipse(22,103,11,10,0,0,Math.PI*2); ctx.fill(); ctx.stroke();
            // index finger
            ctx.beginPath();
            ctx.moveTo(30,99);
            ctx.bezierCurveTo(36,97,43,99,44,104);
            ctx.bezierCurveTo(45,109,41,112,37,111);
            ctx.bezierCurveTo(33,110,30,106,30,99);
            ctx.closePath();
            ctx.fillStyle='white'; ctx.fill();
            ctx.strokeStyle='#bbb'; ctx.lineWidth=1.2; ctx.stroke();
            ctx.beginPath(); ctx.moveTo(31,102); ctx.bezierCurveTo(36,100,41,102,43,105);
            ctx.strokeStyle='#ccc'; ctx.lineWidth=0.9; ctx.stroke();
            // 3 curled fingers (bumps bottom)
            for(let i=0;i<3;i++){
                const fx=13+i*6, fy=112;
                ctx.beginPath(); ctx.ellipse(fx,fy,3,4.5,0.1,0,Math.PI*2);
                ctx.fillStyle='white'; ctx.fill();
                ctx.strokeStyle='#bbb'; ctx.lineWidth=1; ctx.stroke();
            }
            ctx.beginPath(); ctx.moveTo(11,107); ctx.bezierCurveTo(18,112,28,112,34,108);
            ctx.strokeStyle='#ccc'; ctx.lineWidth=1.2; ctx.stroke();

            // APPLE BODY
            const appleG = ctx.createRadialGradient(44,48,3,52,62,48);
            appleG.addColorStop(0,'#FF6B6B');
            appleG.addColorStop(0.42,'#E52228');
            appleG.addColorStop(1,'#9A1020');
            ctx.beginPath(); ctx.ellipse(52,63,38,40,0,0,Math.PI*2);
            ctx.fillStyle=appleG; ctx.fill();
            ctx.strokeStyle='#B51822'; ctx.lineWidth=1.5; ctx.stroke();

            // Shine
            const shG=ctx.createRadialGradient(40,46,1,40,48,16);
            shG.addColorStop(0,'rgba(255,255,255,0.68)');
            shG.addColorStop(1,'rgba(255,255,255,0)');
            ctx.save(); ctx.translate(40,48); ctx.rotate(-0.25);
            ctx.beginPath(); ctx.ellipse(0,0,10,14,0,0,Math.PI*2);
            ctx.fillStyle=shG; ctx.fill(); ctx.restore();

            // Leaf
            ctx.beginPath();
            ctx.moveTo(57,24); ctx.bezierCurveTo(50,10,36,7,34,16); ctx.bezierCurveTo(32,24,48,26,57,24);
            ctx.closePath();
            ctx.fillStyle='#55C97A'; ctx.fill();
            ctx.strokeStyle='#33A85A'; ctx.lineWidth=1.2; ctx.stroke();
            ctx.beginPath(); ctx.moveTo(57,24); ctx.bezierCurveTo(46,19,38,11,39,16);
            ctx.strokeStyle='#33A85A'; ctx.lineWidth=1; ctx.stroke();
            // Stem
            ctx.beginPath(); ctx.moveTo(56,24); ctx.bezierCurveTo(58,17,60,10,61,5);
            ctx.strokeStyle='#7B4A2B'; ctx.lineWidth=3; ctx.lineCap='round'; ctx.stroke();

            // FACE — eyes
            ctx.fillStyle='white';
            ctx.beginPath(); ctx.ellipse(47,58,5,6,0,0,Math.PI*2); ctx.fill();
            ctx.beginPath(); ctx.ellipse(61,56,4.8,5.5,0,0,Math.PI*2); ctx.fill();
            ctx.fillStyle='#2C1106';
            ctx.beginPath(); ctx.ellipse(48.5,60,3,3.5,0,0,Math.PI*2); ctx.fill();
            ctx.beginPath(); ctx.ellipse(62.5,58,2.8,3.2,0,0,Math.PI*2); ctx.fill();
            ctx.fillStyle='white';
            ctx.beginPath(); ctx.ellipse(49.5,59,1.1,1.1,0,0,Math.PI*2); ctx.fill();
            ctx.beginPath(); ctx.ellipse(63.5,57,1,1,0,0,Math.PI*2); ctx.fill();

            // Eyelashes
            ctx.strokeStyle='#1a1a2e'; ctx.lineWidth=1; ctx.lineCap='round';
            [[43,53,41,50],[47,52,46,49],[51,53,51,50],[58,52,57,49],[62,51,63,48],[66,52,68,50]].forEach(([x1,y1,x2,y2])=>{
                ctx.beginPath(); ctx.moveTo(x1,y1); ctx.lineTo(x2,y2); ctx.stroke();
            });

            // Smile
            ctx.beginPath(); ctx.moveTo(43,72); ctx.bezierCurveTo(48,80,62,80,67,73);
            ctx.strokeStyle='#1a1a2e'; ctx.lineWidth=1.8; ctx.lineCap='round'; ctx.stroke();

            // Cheeks
            ctx.fillStyle='rgba(255,130,130,0.38)';
            ctx.beginPath(); ctx.ellipse(38,70,7,4,0,0,Math.PI*2); ctx.fill();
            ctx.beginPath(); ctx.ellipse(66,68,6,3.5,0,0,Math.PI*2); ctx.fill();
        }

        document.querySelectorAll('canvas.alma-logo-canvas').forEach(drawAlmaLogo);
    })();
</script>
<script>
    // Smooth scroll (href="#" alone is invalid for querySelector — skip it)
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const hash = (a.getAttribute('href') || '').trim();
            if (hash.length <= 1) return;
            let target = null;
            try {
                target = document.querySelector(hash);
            } catch (_) {
                return;
            }
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Animate elements on scroll
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.opacity = '1';
                e.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    // Закрыть мобильное меню после перехода по ссылке меню
    const navMenuEl = document.getElementById('navMenu');
    if (navMenuEl && typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
        navMenuEl.querySelectorAll('a.nav-link, a.btn-enroll, a.navbar-lang-link').forEach(function (a) {
            a.addEventListener('click', function () {
                if (!navMenuEl.classList.contains('show')) return;
                bootstrap.Collapse.getOrCreateInstance(navMenuEl).hide();
            });
        });
    }

    document.querySelectorAll('.feature-card, .program-card, .testimonial-card, .teacher-card, .stat-pill').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(24px)';
        el.style.transition = 'opacity .5s ease, transform .5s ease';
        observer.observe(el);
    });
</script>
</body>
</html>
