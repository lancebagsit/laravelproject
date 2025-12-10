@extends('layouts.app')

@section('content')
<header id="header">
  <div class="intro">
    <div class="overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 intro-text">
            <h1>Diocesan Shrine and Parish of Saint Joseph<span></span></h1>
            <p>Welcome — join us for worship, community, and service.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </header>

<div id="announcements" class="text-center" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title" data-animate="animate__fadeInUp animate__delay-05s">
      <h2>Announcements</h2>
      <p>Stay updated with our latest news and events</p>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        @if($announcements->count())
          <div class="announcement-box" data-animate="animate__fadeInUp animate__delay-1s">
            <div class="announcement-nav">
              <button class="announcement-btn" data-ann-prev>&laquo; Prev</button>
              <span class="announcement-counter" data-ann-counter>1 of {{ $announcements->count() }}</span>
              <button class="announcement-btn" data-ann-next>Next &raquo;</button>
            </div>
            <div class="announcement-content" data-animate="animate__fadeIn animate__delay-2s">
              @foreach($announcements as $a)
              <div class="announcement-item" data-ann-index data-animate="animate__zoomIn animate__faster" style="display:none;">
                <h3>{{ $a->title }}</h3>
                <p class="author">Posted by: {{ $a->author ?? 'System Admin' }}</p>
                <p>{{ $a->content }}</p>
              </div>
              @endforeach
            </div>
          </div>
        @else
          <p>No announcements yet.</p>
        @endif
      </div>
    </div>
  </div>
</div>

@php($upcoming = \App\Models\Schedule::with('priest')->whereNotNull('start_at')->where('start_at','>=', now())->orderBy('start_at')->take(6)->get())
@if($upcoming->count())
<div id="upcoming" class="text-center" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="section-title">
      <h2>Upcoming Masses</h2>
      <p>Weekend masses scheduled by the parish</p>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <ul class="list-unstyled" style="text-align:left;">
              @foreach($upcoming as $m)
                @php($pr = optional($m->priest))
                <li style="padding:8px 0; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:10px;">
                  @if($pr && $pr->image)
                    <img src="{{ $pr->image }}" alt="{{ $pr->name }}" style="height:32px; width:32px; border-radius:50%; object-fit:cover;" />
                  @else
                    <img src="https://via.placeholder.com/32x32?text=No+Img" alt="Priest" style="height:32px; width:32px; border-radius:50%; object-fit:cover;" />
                  @endif
                  <span>
                    <strong>{{ \Carbon\Carbon::parse($m->start_at)->format('F j, Y') }}</strong>
                    — {{ \Carbon\Carbon::parse($m->start_at)->format('g:i A') }}
                    @if($pr && $pr->name)
                      <span style="color:#777;">with {{ $pr->name }}</span>
                    @endif
                  </span>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<div id="about" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6" data-animate="animate__fadeInLeft animate__delay-05s">
        <img src="/img/altar.jpg" class="img-responsive about-image" alt="Altar">
      </div>
      <div class="col-xs-12 col-md-6" data-animate="animate__fadeInRight animate__delay-05s">
        <div class="about-text">
          <h2 class="about-title">About Us</h2>
          <p>Welcome to the Diocesan Shrine and Parish of Saint Joseph — a spiritual sanctuary nestled in the heart of Quezon City, under the care of the Diocese of Cubao.</p>
          <p>Established on November 23, 1951, our parish began as a humble mission to serve the growing faith community in the newly developed government housing projects of Project 3. Over the decades, it has blossomed into a vibrant center of worship, formation, and community outreach.</p>
          <p>In 1999, the church was honored with the title of Archdiocesan Shrine by Cardinal Jaime Sin, and later became part of the Diocese of Cubao when it was formally established in 2003.</p>
          <p>Our shrine is dedicated to Saint Joseph, Husband of Mary, the silent yet steadfast protector of the Holy Family. His feast day is joyfully celebrated every March 19, drawing parishioners and pilgrims alike. A revered image of Saint Joseph — lovingly crafted by renowned sculptor Maximo Vicente — stands at the heart of our sanctuary, symbolizing our devotion and trust in his intercession.</p>
          <p>Come and be part of our growing parish family.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="priests" class="parish-info-container" data-animate="animate__fadeInUp animate__delay-1s">
  <div class="container">
    <h2 class="parish-info-title">Parish Schedule</h2>
    @php($now = \Carbon\Carbon::now())
    @php($sat = $now->copy()->next(\Carbon\Carbon::SATURDAY))
    @php($sun = $now->copy()->next(\Carbon\Carbon::SUNDAY))
    @php($satMasses = \App\Models\Schedule::with('priest')->whereDate('start_at', $sat->toDateString())->orderBy('start_at')->get())
    @php($sunMasses = \App\Models\Schedule::with('priest')->whereDate('start_at', $sun->toDateString())->orderBy('start_at')->get())
    <div class="panel panel-default" style="margin-bottom:16px;">
      <div class="panel-heading" style="display:flex; gap:8px; align-items:center;">
        <strong>Upcoming Weekend</strong>
        <div style="margin-left:auto; display:flex; gap:8px;">
          <button type="button" class="btn btn-login-secondary" id="btn-saturday">Saturday ({{ $sat->format('F j') }})</button>
          <button type="button" class="btn btn-login-secondary" id="btn-sunday">Sunday ({{ $sun->format('F j') }})</button>
        </div>
      </div>
      <div class="panel-body">
        <div id="list-saturday" style="display:{{ $satMasses->count() ? 'block' : 'none' }};">
          @if($satMasses->count())
            <ul class="list-unstyled">
              @foreach($satMasses as $m)
                <li style="padding:6px 0; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:10px;">
                  @php($pr = optional($m->priest))
                  @if($pr && $pr->image)
                    <img src="{{ $pr->image }}" alt="{{ $pr->name }}" style="height:28px; width:28px; border-radius:50%; object-fit:cover;" />
                  @else
                    <img src="https://via.placeholder.com/28x28?text=No+Img" alt="Priest" style="height:28px; width:28px; border-radius:50%; object-fit:cover;" />
                  @endif
                  <span>
                    <strong>{{ \Carbon\Carbon::parse($m->start_at)->format('g:i A') }}</strong>
                    @if($m->language) <span style="color:#777;">{{ $m->language }}</span> @endif
                    @if($pr && $pr->name) <span style="color:#777;">with {{ $pr->name }}</span> @endif
                  </span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="text-center" style="margin:0;">No masses scheduled for Saturday.</p>
          @endif
        </div>
        <div id="list-sunday" style="display:{{ !$satMasses->count() && $sunMasses->count() ? 'block' : 'none' }};">
          @if($sunMasses->count())
            <ul class="list-unstyled">
              @foreach($sunMasses as $m)
                <li style="padding:6px 0; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:10px;">
                  @php($pr = optional($m->priest))
                  @if($pr && $pr->image)
                    <img src="{{ $pr->image }}" alt="{{ $pr->name }}" style="height:28px; width:28px; border-radius:50%; object-fit:cover;" />
                  @else
                    <img src="https://via.placeholder.com/28x28?text=No+Img" alt="Priest" style="height:28px; width:28px; border-radius:50%; object-fit:cover;" />
                  @endif
                  <span>
                    <strong>{{ \Carbon\Carbon::parse($m->start_at)->format('g:i A') }}</strong>
                    @if($m->language) <span style="color:#777;">{{ $m->language }}</span> @endif
                    @if($pr && $pr->name) <span style="color:#777;">with {{ $pr->name }}</span> @endif
                  </span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="text-center" style="margin:0;">No masses scheduled for Sunday.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var bs = document.getElementById('btn-saturday');
  var bu = document.getElementById('btn-sunday');
  var ls = document.getElementById('list-saturday');
  var lu = document.getElementById('list-sunday');
  function show(which){
    if (which === 'sat') { if (ls) ls.style.display = 'block'; if (lu) lu.style.display = 'none'; }
    if (which === 'sun') { if (ls) ls.style.display = 'none'; if (lu) lu.style.display = 'block'; }
  }
  if (bs) bs.addEventListener('click', function(){ show('sat'); });
  if (bu) bu.addEventListener('click', function(){ show('sun'); });
});
</script>

@php($services = \App\Models\Service::latest()->get())

<div id="services" class="services-wrapper" data-animate="animate__fadeInUp animate__delay-1s">
  <div class="container">
    <div class="services-header text-center">
      <h2>Community Services</h2>
      <p>Outreach and parish programs serving our community</p>
    </div>
    <div class="services-carousel" id="servicesCarousel" data-services='@json($services)'>
      @foreach($services as $i => $svc)
        @php($img = $svc->image1)
        <div class="svc-slide" data-svc-index="{{ $i }}" style="display:none;">
          <div class="svc-content">
            <div class="svc-image">
              @if($img)
                <img src="{{ $img }}" alt="{{ $svc->name }}">
              @else
                <img src="https://via.placeholder.com/400x300?text=Service+Image" alt="{{ $svc->name }}">
              @endif
            </div>
            <div class="svc-text">
              <p class="svc-desc">{{ $svc->text }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="services-controls text-center">
      <button class="btn btn-primary" id="svc-prev"><i data-lucide="chevron-left"></i></button>
      <span id="svc-counter">1 / {{ count($services) }}</span>
      <button class="btn btn-primary" id="svc-next"><i data-lucide="chevron-right"></i></button>
    </div>
    <div class="services-dots text-center">
      @foreach($services as $i => $svc)
        <button class="svc-dot" data-svc-dot="{{ $i }}"></button>
      @endforeach
    </div>
  </div>
</div>

<div id="portfolio" class="text-center" data-animate="animate__fadeInUp animate__delay-1s">
  <div class="container">
    <div class="section-title">
      <h2>Gallery</h2>
      <p>Moments from our parish life</p>
    </div>
        <div class="row">
          @php($items = \App\Models\GalleryItem::latest()->get())
          @forelse($items as $item)
            <div class="col-sm-6 col-md-3 col-lg-3 gallery-item" data-animate="animate__fadeInUp" style="display:none; --animate-delay: {{ ($loop->index % 3) * 0.15 }}s;">
              <div class="thumbnail">
                <img src="{{ $item->url }}" alt="{{ $item->title }}" style="width:100%; height:250px; object-fit:cover;" loading="lazy">
                <div class="caption"><h4>{{ $item->title }}</h4></div>
              </div>
            </div>
          @empty
            <div class="col-md-12">No images yet.</div>
          @endforelse
        </div>
    <div class="row" style="margin-top:20px; margin-bottom:20px;">
      <div class="col-md-12 text-center">
        <button class="btn btn-primary" id="gallery-prev">&laquo;</button>
        <span id="gallery-page" style="margin:0 10px;">1 / 1</span>
        <button class="btn btn-primary" id="gallery-next">&raquo;</button>
      </div>
    </div>
  </div>
</div>

<div id="contact" data-animate="animate__fadeInUp animate__delay-1s">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="section-title" data-animate="animate__fadeInUp animate__delay-05s"><h2>Contact us Now!</h2></div>
        <div class="contact-form-box">
          <form method="POST" action="/contact">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="name" name="name" class="form-control" placeholder="Name" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" id="email" name="email" class="form-control" placeholder="Email" required />
                </div>
              </div>
            </div>
            <div class="form-group">
              <textarea name="message" id="message" class="form-control" rows="5" placeholder="Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom btn-lg">Send Message</button>
          </form>
        </div>
      </div>
      <div class="col-md-3 col-md-offset-1 contact-info">
        <div class="contact-item">
          <h3>Contact Info</h3>
          <p><span><i class="fa fa-map-marker"></i> Address</span> Quezon City</p>
        </div>
        <div class="contact-item">
          <p><span><i class="fa fa-phone"></i> Phone</span> (000) 000-0000</p>
        </div>
        <div class="contact-item">
          <p><span><i class="fa fa-envelope-o"></i> Email</span> parish@example.com</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="priestModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body" style="padding:0;">
        <img id="priestModalImg" src="" alt="Priest" class="img-responsive" style="width:100%;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
