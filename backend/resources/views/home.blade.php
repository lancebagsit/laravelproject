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
    @php($priests = \App\Models\Priest::latest()->get())
    @php($schedules = \App\Models\Schedule::latest()->get())
    @php($rows = min($priests->count(), $schedules->count()))
    <div class="table-wrapper">
      <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="3" class="text-center">Parish Priests</th>
            <th colspan="2" class="text-center">Weekly Mass Schedule</th>
          </tr>
          <tr>
            <th>Photo</th>
            <th>Priest</th>
            <th>Role</th>
            <th>Time</th>
            <th>Language</th>
          </tr>
        </thead>
        <tbody>
          @for($i = 0; $i < $rows; $i++)
            @php($p = $priests[$i] ?? null)
            @php($s = $schedules[$i] ?? null)
            <tr data-animate="animate__zoomIn animate__faster">
              <td style="width:80px;">
                @if($p && $p->image)
                  <img src="{{ $p->image }}" data-full="{{ $p->image }}" alt="{{ $p->name }}" class="img-responsive priest-photo" style="max-height:60px; border-radius:6px; cursor:pointer;" />
                @elseif($p)
                  <img src="https://via.placeholder.com/60x60?text=No+Image" alt="{{ $p->name }}" class="img-responsive" style="border-radius:6px;" />
                @endif
              </td>
              <td>@if($p)<strong>{{ $p->name }}</strong>@endif</td>
              <td>@if($p){{ $p->description }}@endif</td>
              <td>@if($s){{ $s->time }}@endif</td>
              <td>@if($s){{ $s->language }}@endif</td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>
</div>

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
