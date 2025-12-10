@extends('layouts.app')

@section('content')
@php($base = \Carbon\Carbon::createFromFormat('Y-m', $month ?? now()->format('Y-m')))
@php($startOfMonth = $base->copy()->startOfMonth())
@php($endOfMonth = $base->copy()->endOfMonth())
@php($firstWeekday = (int)$startOfMonth->format('w'))
@php($daysInMonth = (int)$endOfMonth->format('j'))
@php($byDate = $schedules->groupBy(function($s){ return \Carbon\Carbon::parse($s->start_at)->toDateString(); }))
@php($map = [])
@foreach($byDate as $date => $items)
  @php($map[$date] = $items->map(function($it){ return [
    'id' => $it->id,
    'date' => \Carbon\Carbon::parse($it->start_at)->toDateString(),
    'time' => \Carbon\Carbon::parse($it->start_at)->format('g:i A'),
    'language' => $it->language,
    'priest' => optional($it->priest)->name,
    'priestImage' => optional($it->priest)->image,
  ]; }))
@endforeach

<div class="container" id="user-calendar" data-animate="animate__fadeInUp animate__delay-05s" data-schedules='@json($map)'>
  <div class="section-title text-center"><h2>Mass Calendar</h2></div>
  <div class="panel panel-default">
    <div class="panel-heading" style="display:flex; justify-content:space-between; align-items:center;">
      <a class="btn btn-login-secondary" href="/user/calendar?month={{ $base->copy()->subMonth()->format('Y-m') }}">&laquo; {{ $base->copy()->subMonth()->format('F') }}</a>
      <strong>{{ $base->format('F Y') }}</strong>
      <a class="btn btn-login-secondary" href="/user/calendar?month={{ $base->copy()->addMonth()->format('Y-m') }}">{{ $base->copy()->addMonth()->format('F') }} &raquo;</a>
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
                  <td class="text-center" style="cursor:{{ $has ? 'pointer' : 'default' }}; {{ $has ? 'background:#f7fbff;' : '' }}" data-date="{{ $cellDate }}">
                    <div><strong>{{ $day }}</strong></div>
                    @if($has)
                      <div><span class="label label-primary">{{ count($map[$cellDate]) }} scheduled</span></div>
                    @endif
                  </td>
                  @php($day++)
                @endif
              @endfor
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modalTitle"></h4>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var root = document.getElementById('user-calendar');
  if (!root) return;
  var dataAttr = root.getAttribute('data-schedules');
  var scheduleMap = {};
  try { scheduleMap = JSON.parse(dataAttr || '{}'); } catch (e) { scheduleMap = {}; }
  document.querySelectorAll('#user-calendar td[data-date]').forEach(function(cell){
    var date = cell.getAttribute('data-date');
    cell.addEventListener('click', function(){
      var items = scheduleMap[date] || [];
      if (!items.length) return;
      var title = new Date(date+'T00:00:00').toLocaleDateString(undefined, { weekday:'long', year:'numeric', month:'long', day:'numeric' });
      var body = items.map(function(it){
        var parts = [];
        if (it.time) parts.push(it.time);
        if (it.language) parts.push(it.language);
        if (it.priest) parts.push('with '+it.priest);
        var img = it.priestImage ? '<img src="'+it.priestImage+'" alt="'+(it.priest||'Priest')+'" style="height:28px; width:28px; border-radius:50%; object-fit:cover; margin-right:8px;" />' : '<img src="https://via.placeholder.com/28x28?text=No+Img" alt="Priest" style="height:28px; width:28px; border-radius:50%; object-fit:cover; margin-right:8px;" />';
        var row = '<div style="padding:6px 0; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between;">'
          + '<span style="display:flex; align-items:center;">'+img+parts.join(' — ')+'</span>'
          + '<button type="button" class="btn btn-login-secondary" data-remind data-sid="'+it.id+'">Remind me</button>'
          + '</div>';
        return row;
      }).join('');
      var mt = document.getElementById('modalTitle'); if (mt) mt.textContent = title;
      var mb = document.getElementById('modalBody'); if (mb) mb.innerHTML = body || '<p>No details.</p>';
      jQuery('#calendarModal').modal({ backdrop: false, keyboard: true });
      setTimeout(function(){
        document.querySelectorAll('#modalBody [data-remind]').forEach(function(btn){
          btn.addEventListener('click', function(){
            var sid = btn.getAttribute('data-sid');
            if (!sid) return;
            jQuery.post('/user/reminders', { schedule_id: sid })
              .done(function(){
                var ok = document.createElement('div');
                ok.className = 'alert alert-success';
                ok.textContent = 'Reminder scheduled';
                mb.insertBefore(ok, mb.firstChild);
              })
              .fail(function(xhr){
                var err = document.createElement('div');
                err.className = 'alert alert-danger';
                err.textContent = (xhr && xhr.responseText) ? 'Failed to schedule reminder' : 'Failed to schedule reminder';
                mb.insertBefore(err, mb.firstChild);
              });
          });
        });
      }, 0);
    });
  });
});
</script>
@endsection
