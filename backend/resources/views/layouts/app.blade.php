<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Joseph Parish</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;600;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
@php($isAdmin = request()->is('admin*'))
<nav id="menu" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">ST. JOSEPH SHRINE{{ $isAdmin ? ' Admin' : '' }}</a>
            <button type="button" id="menuToggle" class="navbar-toggle" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if(!$isAdmin)
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/#announcements" class="page-scroll">Announcements</a></li>
                <li><a href="/#about" class="page-scroll">About</a></li>
                <li><a href="/#priests" class="page-scroll">Information</a></li>
                <li><a href="/#services" class="page-scroll">Services</a></li>
                <li><a href="/#portfolio" class="page-scroll">Gallery</a></li>
                <li><a href="/#contact" class="page-scroll">Contact</a></li>
                <li><a href="/donate" class="page-scroll"><strong>Donate</strong></a></li>
                <li><a href="/team" class="page-scroll">Dev Team</a></li>
                <li class="nav-login">
                  <a href="/admin/login" class="btn-login" data-animate="animate__fadeInDown animate__delay-05s">Login</a>
                </li>
            </ul>
            @else
            @if(session('admin_id'))
            <ul class="nav navbar-nav">
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/announcements">Announcements</a></li>
                <li><a href="/admin/priest">Priest</a></li>
                <li><a href="/admin/gallery">Gallery</a></li>
                <li><a href="/admin/donations">Donations</a></li>
                <li><a href="/admin/inquiries">Inquiries</a></li>
                <li>
                  <form method="POST" action="/admin/logout" style="display:inline-block; margin:0; padding:10px 15px;">
                    @csrf
                    <button type="submit" class="btn btn-link" style="padding:0;">Logout</button>
                  </form>
                </li>
            </ul>
            @else
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-login">
                  <a href="/" class="btn-login" data-animate="animate__fadeInDown animate__delay-05s">Back to Home</a>
                </li>
            </ul>
            @endif
            @endif
        </div>
    </div>
    </nav>

    <div class="content-wrapper" style="margin-top:80px;">
        @yield('content')
    </div>

    <footer id="footer">
        <div class="container">
            <div class="footer-social">
                <a href="https://facebook.com/" aria-label="Facebook" class="footer-icon"><i class="fa fa-facebook"></i></a>
                <a href="/admin/login" aria-label="Admin Login" class="footer-icon"><i class="fa fa-user"></i></a>
            </div>
        </div>
    </footer>
    <div class="footer-bottom">
        <div class="container text-center">
            <p>© {{ date('Y') }} Company Name. All Rights Reserved.</p>
            <p>965 Aurora Blvd, Project 3, Quezon City</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.lucide && typeof lucide.createIcons === 'function') { lucide.createIcons(); }
  var flashStatus = @json(session('status'));
  if (flashStatus) {
    Swal.fire({ title: 'Success!', text: flashStatus, icon: 'success', confirmButtonText: 'OK' });
  }
  var flashErrors = @json($errors->all());
  if (flashErrors && flashErrors.length) {
    Swal.fire({ title: 'Error!', text: flashErrors.join('\n'), icon: 'error', confirmButtonText: 'Try Again' });
  }
  var opts = { threshold: 0.1 };
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      var el = entry.target;
      if (entry.isIntersecting && !el.classList.contains('animate__animated')) {
        var anim = el.getAttribute('data-animate') || 'animate__fadeInUp';
        el.classList.add('animate__animated');
        anim.split(' ').forEach(function(c){ el.classList.add(c); });
      }
    });
  }, opts);

  document.querySelectorAll('[data-animate]').forEach(function(el){ observer.observe(el); });

  var containers = Array.prototype.slice.call(document.querySelectorAll('#header .container, #announcements .container, #about .container, #priests .container, #services .container, #portfolio .container, #contact .container, #team .container'));
  containers.forEach(function(el){ if (!el.hasAttribute('data-animate')) { el.classList.add('will-animate'); observer.observe(el); } });

  function setupCardAnimations(){
    var cards = Array.prototype.slice.call(document.querySelectorAll('.gallery-item'));
    cards.forEach(function(el, idx){
      var delay = (0.06 * (idx % 6)).toFixed(2) + 's';
      el.style.setProperty('--animate-delay', delay);
      var anim = idx % 2 === 0 ? 'animate__zoomIn' : 'animate__fadeInUp';
      el.setAttribute('data-animate', anim);
      observer.observe(el);
    });
    var thumbs = Array.prototype.slice.call(document.querySelectorAll('.gallery-item .thumbnail'));
    thumbs.forEach(function(el, idx){
      var delay = (0.05 * (idx % 6)).toFixed(2) + 's';
      el.style.setProperty('--animate-delay', delay);
      if (!el.getAttribute('data-animate')) el.setAttribute('data-animate', 'animate__fadeIn');
      observer.observe(el);
    });
    var formBoxes = Array.prototype.slice.call(document.querySelectorAll('.contact-form-box'));
    formBoxes.forEach(function(box, i){
      var delay = (0.1 * Math.min(i, 2)).toFixed(1) + 's';
      box.style.setProperty('--animate-delay', delay);
      if (!box.getAttribute('data-animate')) box.setAttribute('data-animate', 'animate__fadeInUp');
      observer.observe(box);
    });
  }
  setupCardAnimations();

  document.querySelectorAll('a.page-scroll').forEach(function(link){
    link.addEventListener('click', function(e){
      var href = link.getAttribute('href') || '';
      if (href.indexOf('#') !== -1) {
        var id = href.split('#')[1];
        var target = document.getElementById(id);
        if (target) {
          e.preventDefault();
          var rect = target.getBoundingClientRect();
          var start = window.scrollY || window.pageYOffset || 0;
          var offset = 80;
          var to = Math.max(0, rect.top + start - offset);
          var startTime = null;
          var duration = 800;
          function ease(t){ return t < 0.5 ? 2*t*t : -1 + (4 - 2*t) * t; }
          function step(ts){
            if (!startTime) startTime = ts;
            var p = Math.min((ts - startTime) / duration, 1);
            var e = ease(p);
            window.scrollTo(0, start + (to - start) * e);
            if (p < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
          history.pushState(null, '', '/#' + id);
        }
      }
    });
  });

  var sectionIds = ['announcements','about','priests','services','portfolio','contact'];
  function updateActiveNav(){
    var fromTop = window.scrollY + 100;
    var currentId = null;
    sectionIds.forEach(function(id){
      var el = document.getElementById(id);
      if (!el) return;
      var top = el.offsetTop;
      var height = el.offsetHeight;
      if (fromTop >= top && fromTop < top + height) currentId = id;
    });
    document.querySelectorAll('#menu .nav>li').forEach(function(li){ li.classList.remove('active'); });
    if (currentId) {
      var selector = '#menu .nav>li>a[href="/#' + currentId + '"]';
      var link = document.querySelector(selector);
      if (link && link.parentElement) link.parentElement.classList.add('active');
    }
  }
  window.addEventListener('scroll', updateActiveNav);
  updateActiveNav();

  var toggleBtn = document.getElementById('menuToggle');
  var collapse = document.getElementById('bs-example-navbar-collapse-1');
  if (toggleBtn && collapse) {
    function closeMenu(){ collapse.classList.remove('open'); document.body.classList.remove('menu-open'); }
    toggleBtn.addEventListener('click', function(){
      var isOpen = collapse.classList.toggle('open');
      document.body.classList.toggle('menu-open', isOpen);
    });
    Array.prototype.slice.call(collapse.querySelectorAll('a')).forEach(function(a){ a.addEventListener('click', closeMenu); });
  }

  var items = Array.prototype.slice.call(document.querySelectorAll('.announcement-item'));
  if (items.length) {
    var current = 0;
    function show(i){
      items.forEach(function(el, idx){ el.style.display = idx === i ? 'block' : 'none'; });
      var counter = document.querySelector('[data-ann-counter]');
      if (counter) counter.textContent = (i+1) + ' of ' + items.length;
    }
    show(0);
    var timer = setInterval(function(){ current = (current + 1) % items.length; show(current); }, 5000);
    var box = document.querySelector('.announcement-box');
    if (box) {
      box.addEventListener('mouseenter', function(){ clearInterval(timer); });
      box.addEventListener('mouseleave', function(){ timer = setInterval(function(){ current = (current + 1) % items.length; show(current); }, 5000); });
    }
    var prev = document.querySelector('[data-ann-prev]');
    var next = document.querySelector('[data-ann-next]');
    if (prev) prev.addEventListener('click', function(){ current = current === 0 ? items.length - 1 : current - 1; show(current); });
    if (next) next.addEventListener('click', function(){ current = (current + 1) % items.length; show(current); });
  }

  var galleryItems = Array.prototype.slice.call(document.querySelectorAll('.gallery-item'));
  if (galleryItems.length) {
    var perPage = 9;
    var gPage = 0;
    function renderGallery(){
      galleryItems.forEach(function(el, idx){
        var start = gPage * perPage;
        var end = start + perPage;
        el.style.display = (idx >= start && idx < end) ? '' : 'none';
      });
      var total = Math.ceil(galleryItems.length / perPage) || 1;
      var indicator = document.getElementById('gallery-page');
      if (indicator) indicator.textContent = (gPage + 1) + ' / ' + total;
    }
    renderGallery();
    var prevBtn = document.getElementById('gallery-prev');
    var nextBtn = document.getElementById('gallery-next');
    var gTimer = null;
    function stopGalleryAuto(){ if (gTimer) { clearInterval(gTimer); gTimer = null; } }
    function startGalleryAuto(){
      stopGalleryAuto();
      gTimer = setInterval(function(){
        var total = Math.ceil(galleryItems.length / perPage) || 1;
        gPage = (gPage + 1) % total;
        renderGallery();
      }, 5000);
    }
    if (prevBtn) prevBtn.addEventListener('click', function(){
      var total = Math.ceil(galleryItems.length / perPage) || 1;
      gPage = gPage === 0 ? total - 1 : gPage - 1;
      renderGallery();
      startGalleryAuto();
    });
    if (nextBtn) nextBtn.addEventListener('click', function(){
      var total = Math.ceil(galleryItems.length / perPage) || 1;
      gPage = (gPage + 1) % total;
      renderGallery();
      startGalleryAuto();
    });
    startGalleryAuto();
    var portfolio = document.getElementById('portfolio');
    if (portfolio) {
      portfolio.addEventListener('mouseenter', stopGalleryAuto);
      portfolio.addEventListener('mouseleave', startGalleryAuto);
    }
  }

  var sc = document.getElementById('servicesCarousel');
  if (sc) {
    if (sc.getAttribute('data-svc-init') === '1') { return; }
    sc.setAttribute('data-svc-init','1');
    var dataAttr = sc.getAttribute('data-services');
    var services = [];
    try { services = JSON.parse(dataAttr); } catch (e) { services = []; }
    var slides = Array.prototype.slice.call(sc.querySelectorAll('.svc-slide'));
    var dots = Array.prototype.slice.call(document.querySelectorAll('.svc-dot'));
    var prevBtn = document.getElementById('svc-prev');
    var nextBtn = document.getElementById('svc-next');
    var counter = document.getElementById('svc-counter');
    var current = 0;
    var timer = null;
    var lock = false;
    function render(index) {
      slides.forEach(function(el, i){ el.style.display = i === index ? 'block' : 'none'; });
      if (counter) counter.textContent = (index + 1) + ' / ' + slides.length;
      dots.forEach(function(d){ d.classList.remove('active'); });
      var d = document.querySelector('.svc-dot[data-svc-dot="' + index + '"]');
      if (d) d.classList.add('active');
      current = index;
    }
    function stopAuto(){ if (timer) { clearInterval(timer); timer = null; } }
    function startAuto(){ stopAuto(); timer = setInterval(function(){ if (lock) return; lock = true; render(current === slides.length - 1 ? 0 : current + 1); setTimeout(function(){ lock = false; }, 300); }, 5000); }
    function prev() { if (lock) return; lock = true; stopAuto(); render(current === 0 ? slides.length - 1 : current - 1); setTimeout(function(){ lock = false; startAuto(); }, 300); }
    function next() { if (lock) return; lock = true; stopAuto(); render(current === slides.length - 1 ? 0 : current + 1); setTimeout(function(){ lock = false; startAuto(); }, 300); }
    if (prevBtn) prevBtn.addEventListener('click', prev);
    if (nextBtn) nextBtn.addEventListener('click', next);
    dots.forEach(function(d){ d.addEventListener('click', function(){ var i = parseInt(d.getAttribute('data-svc-dot'), 10); if (!isNaN(i)) { if (lock) return; lock = true; stopAuto(); render(i); setTimeout(function(){ lock = false; startAuto(); }, 300); } }); });
    var svcImgs = Array.prototype.slice.call(sc.querySelectorAll('.svc-image img'));
    var overlay = null, overlayImg = null, overlayPrev = null, overlayNext = null, overlayClose = null, photoIndex = 0;
    function openOverlay(images, startIdx) {
      if (!images || !images.length) return;
      photoIndex = startIdx || 0;
      overlay = document.createElement('div'); overlay.className = 'lb-overlay';
      overlayImg = document.createElement('img'); overlayImg.className = 'lb-image';
      overlayClose = document.createElement('button'); overlayClose.className = 'lb-close'; overlayClose.textContent = '×';
      overlayPrev = document.createElement('button'); overlayPrev.className = 'lb-prev'; overlayPrev.textContent = '‹';
      overlayNext = document.createElement('button'); overlayNext.className = 'lb-next'; overlayNext.textContent = '›';
      function draw(){ overlayImg.src = images[photoIndex]; }
      overlayClose.addEventListener('click', function(){ overlay.classList.remove('open'); document.body.removeChild(overlay); overlay = null; startAuto(); });
      overlayPrev.addEventListener('click', function(){ photoIndex = photoIndex === 0 ? images.length - 1 : photoIndex - 1; draw(); });
      overlayNext.addEventListener('click', function(){ photoIndex = photoIndex === images.length - 1 ? 0 : photoIndex + 1; draw(); });
      overlay.appendChild(overlayImg); overlay.appendChild(overlayClose); overlay.appendChild(overlayPrev); overlay.appendChild(overlayNext);
      document.body.appendChild(overlay); overlay.classList.add('open'); draw(); stopAuto();
    }
    svcImgs.forEach(function(img){ img.addEventListener('click', function(){ var svc = services[current] || {}; var images = svc.images || []; openOverlay(images, 0); }); });
    render(0);
    startAuto();
    sc.addEventListener('mouseenter', function(){ stopAuto(); });
    sc.addEventListener('mouseleave', function(){ startAuto(); });
  }
});
</script>
</body>
</html>
