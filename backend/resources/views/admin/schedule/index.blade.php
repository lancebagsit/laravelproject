@extends('layouts.app')

@section('content')
<div class="container" id="admin-schedule" data-animate="animate__fadeInUp animate__delay-05s">
  <div class="admin-shell">
    <aside class="admin-sidebar" data-animate="animate__fadeInLeft">
      <div class="admin-brand">St. Joseph Admin</div>
      <nav class="admin-nav">
        <a href="/admin" class="admin-nav-item"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="/admin/announcements" class="admin-nav-item"><i class="fa fa-bullhorn"></i><span>Announcements</span></a>
        <a href="/admin/priest" class="admin-nav-item"><i class="fa fa-user"></i><span>Priests</span></a>
        <a href="/admin/gallery" class="admin-nav-item"><i class="fa fa-picture-o"></i><span>Gallery</span></a>
        <a href="/admin/services" class="admin-nav-item"><i class="fa fa-cogs"></i><span>Services</span></a>
        <a href="/admin/donations" class="admin-nav-item"><i class="fa fa-gift"></i><span>Donations</span></a>
        <a href="/admin/inquiries" class="admin-nav-item"><i class="fa fa-envelope"></i><span>Inquiries</span></a>
        <a href="/admin/schedule" class="admin-nav-item active"><i class="fa fa-calendar"></i><span>Parish Schedule</span></a>
      </nav>
    </aside>

    <main class="admin-content">
      <div class="admin-topbar">
        <div class="admin-title">Parish Schedule</div>
        <div class="admin-actions">
          <div class="admin-user">{{ session('admin_name') }}</div>
        </div>
      </div>

@php($map = [])
@foreach(($monthItems ?? collect()) as $it)
  @php($d = \Carbon\Carbon::parse($it->start_at)->toDateString())
  @php($map[$d] = array_merge(($map[$d] ?? []), [[
    'id' => $it->id,
    'time' => \Carbon\Carbon::parse($it->start_at)->format('g:i A'),
    'time24' => \Carbon\Carbon::parse($it->start_at)->format('H:i'),
    'priest_id' => $it->priest_id,
    'priest' => [ 'id' => $it->priest_id, 'name' => optional($it->priest)->name, 'image' => optional($it->priest)->image ],
  ]]))
@endforeach
<div class="panel panel-default" id="admin-calendar" data-month-schedules='@json($map)' data-priests='@json($priests->map(fn($p)=>["id"=>$p->id,"name"=>$p->name]))'>
  @php($base = \Carbon\Carbon::createFromFormat('Y-m', ($month ?? now()->format('Y-m'))))
  @php($startOfMonth = $base->copy()->startOfMonth())
  @php($endOfMonth = $base->copy()->endOfMonth())
  @php($firstWeekday = (int)$startOfMonth->format('w'))
  @php($daysInMonth = (int)$endOfMonth->format('j'))
  <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
    <a class="btn btn-login-secondary" href="/admin/schedule?month={{ $base->copy()->subMonth()->format('Y-m') }}">&laquo; {{ $base->copy()->subMonth()->format('F') }}</a>
    <strong>{{ $base->format('F Y') }}</strong>
    <a class="btn btn-login-secondary" href="/admin/schedule?month={{ $base->copy()->addMonth()->format('Y-m') }}">{{ $base->copy()->addMonth()->format('F') }} &raquo;</a>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center">Sun</th>
          <th class="text-center">Mon</th>
          <th class="text-center">Tue</th>
          <th class="text-center">Wed</th>
          <th class="text-center">Thu</th>
          <th class="text-center">Fri</th>
          <th class="text-center">Sat</th>
        </tr>
      </thead>
      <tbody>
        @php($day = 1)
        @for($week = 0; $week < 6; $week++)
          <tr>
            @for($dow = 0; $dow < 7; $dow++)
              @php($cellDate = null)
              @if($week === 0 && $dow < $firstWeekday)
                <td style="background:#fafafa;"></td>
              @elseif($day > $daysInMonth)
                <td style="background:#fafafa;"></td>
              @else
                @php($cellDate = $base->copy()->day($day)->toDateString())
                @php($has = isset($map[$cellDate]))
                @php($isWeekend = in_array((int)\Carbon\Carbon::parse($cellDate)->format('w'), [0,6]))
                @if($isWeekend)
                  <td class="text-center" style="cursor:pointer; background:#fffbe6; {{ $has ? 'box-shadow: inset 0 0 0 2px #ffd966;' : '' }}" data-date="{{ $cellDate }}">
                    <div><strong>{{ $day }}</strong></div>
                    @if($has)
                      <div><span class="label label-primary">{{ count($map[$cellDate]) }} scheduled</span></div>
                    @endif
                  </td>
                @else
                  <td class="text-center" style="color:#aaa; background:#fafafa; position:relative;">
                    <div><strong>{{ $day }}</strong></div>
                    <div style="position:absolute; right:6px; top:6px; color:#d9534f; font-weight:bold;">×</div>
                  </td>
                @endif
                @php($day++)
              @endif
            @endfor
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>

  <!-- Modal for Create & Scheduled -->
  <div class="modal fade" id="adminScheduleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="adminModalTitle"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="/admin/schedule" id="adminCreateForm">
            @csrf
            <input type="hidden" name="date" id="adminCreateDate" />
            <div class="row">
              <div class="col-md-6">
                <h4>Morning (7:00 AM – 10:00 AM)</h4>
                <div id="modalMorningSlots"></div>
                <button type="button" class="btn btn-login-secondary" id="modalAddMorning">+ Add Morning Mass</button>
              </div>
              <div class="col-md-6">
                <h4>Evening (5:00 PM – 8:00 PM)</h4>
                <div id="modalEveningSlots"></div>
                <button type="button" class="btn btn-login-secondary" id="modalAddEvening">+ Add Evening Mass</button>
              </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Save Schedule</button>
          </form>
          <hr>
          <div class="table-responsive">
            <table class="table" id="adminScheduledTable">
              <thead><tr><th>Time</th><th>Priest</th><th>Actions</th></tr></thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    </main>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var calendar = document.getElementById('admin-calendar');
  var monthMap = {};
  var priestList = [];
  try { monthMap = JSON.parse(calendar.getAttribute('data-month-schedules') || '{}'); } catch (e) {}
  try { priestList = JSON.parse(calendar.getAttribute('data-priests') || '[]'); } catch (e) {}

  function buildOptions(selectedId){
    return priestList.map(function(p){ return '<option value="'+p.id+'"'+(String(selectedId)===String(p.id)?' selected':'')+'>'+p.name+'</option>'; }).join('');
  }

  function addSlot(containerEl, min, max){
    var count = containerEl.querySelectorAll('[data-slot-time]').length;
    if (count >= 3) return;
    var row = document.createElement('div');
    row.className = 'form-inline';
    row.style.cssText = 'margin-bottom:8px; gap:8px;';
    row.innerHTML = '<input type="time" class="form-control" value="'+min+'" min="'+min+'" max="'+max+'" step="900" data-slot-time />\n<select class="form-control" data-slot-priest>'+buildOptions(null)+'</select>\n<button type="button" class="btn btn-danger" data-remove-slot>&times;</button>';
    containerEl.appendChild(row);
    row.querySelector('[data-remove-slot]').addEventListener('click', function(){ row.remove(); });
  }

  function openModalForDate(dateStr){
    var title = new Date(dateStr+'T00:00:00').toLocaleDateString(undefined, { weekday:'long', year:'numeric', month:'long', day:'numeric' });
    var mt = document.getElementById('adminModalTitle'); if (mt) mt.textContent = 'Create & Manage — '+title;
    var hd = document.getElementById('adminCreateDate'); if (hd) hd.value = dateStr;
    var ms = document.getElementById('modalMorningSlots'); var es = document.getElementById('modalEveningSlots');
    if (ms && es) { ms.innerHTML=''; es.innerHTML=''; }
    addSlot(ms, '07:00', '10:00'); addSlot(ms, '08:30', '10:00');
    addSlot(es, '17:00', '20:00'); addSlot(es, '18:30', '20:00');
    var addMorning = document.getElementById('modalAddMorning'); if (addMorning) addMorning.onclick = function(){ addSlot(ms, '07:00', '10:00'); };
    var addEvening = document.getElementById('modalAddEvening'); if (addEvening) addEvening.onclick = function(){ addSlot(es, '17:00', '20:00'); };

    var tbody = document.querySelector('#adminScheduledTable tbody'); if (tbody) { tbody.innerHTML = ''; }
    var items = monthMap[dateStr] || [];
    var csrf = document.querySelector('meta[name="csrf-token"]'); csrf = csrf ? csrf.content : '';
    items.forEach(function(it){
      var tr = document.createElement('tr');
      var img = (it.priest && it.priest.image) ? '<img src="'+it.priest.image+'" alt="'+(it.priest.name||'Priest')+'" style="height:28px; width:28px; border-radius:50%; object-fit:cover; margin-right:8px;" />' : '<img src="https://via.placeholder.com/28x28?text=No+Img" alt="Priest" style="height:28px; width:28px; border-radius:50%; object-fit:cover; margin-right:8px;" />';
      tr.innerHTML = '<td style="display:flex; align-items:center;">'+ img + (it.time || '') +'</td>'+
        '<td>'+ (it.priest && it.priest.name ? it.priest.name : '') +'</td>'+
        '<td>'+
        '<form method="POST" action="/admin/schedule/'+it.id+'" style="display:inline-block;">\n<input type="hidden" name="_token" value="'+csrf+'" />\n<input type="time" name="time" value="'+(it.time24 || '')+'" style="width:120px;" />\n<select name="priest_id" style="width:200px;">'+buildOptions(it.priest_id)+'</select>\n<button type="submit" class="btn btn-primary">Update</button>\n</form>'+
        '<form method="POST" action="/admin/schedule/'+it.id+'/delete" style="display:inline-block; margin-left:8px;">\n<input type="hidden" name="_token" value="'+csrf+'" />\n<button type="submit" class="btn btn-danger">Delete</button>\n</form>'+
        '</td>';
      tbody.appendChild(tr);
    });

    var form = document.getElementById('adminCreateForm');
    if (form) {
      form.addEventListener('submit', function(e){
        var slots = [];
        function collect(containerEl){
          containerEl.querySelectorAll('.form-inline').forEach(function(row){
            var t = row.querySelector('[data-slot-time]');
            var p = row.querySelector('[data-slot-priest]');
            if (t && t.value && p && p.value) { slots.push({ time: t.value, priest_id: p.value }); }
          });
        }
        collect(ms); collect(es);
        var input = document.createElement('input'); input.type = 'hidden'; input.name = 'slots'; input.value = JSON.stringify(slots);
        form.appendChild(input);
      }, { once: true });
    }
    if (window.jQuery) { jQuery('#adminScheduleModal').modal({ backdrop: false }); }
  }

  document.querySelectorAll('#admin-calendar td[data-date]').forEach(function(cell){
    cell.addEventListener('click', function(){ var d = cell.getAttribute('data-date'); if (d) openModalForDate(d); });
  });
});
</script>
@endsection
