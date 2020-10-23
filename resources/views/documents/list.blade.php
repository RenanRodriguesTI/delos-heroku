@extends('layouts.app')
@section('content')
<div class="container">
  <ul class="nav nav-tabs">
    <li id='link-epis' class="active"><a data-toggle="tab" href="#epis">EPIs</a></li>
    <li id='link-curses'><a data-toggle="tab" href="#curses">Cursos</a></li>
  </ul>

  <div class="tab-content">
    @include("documents.curses.curses")
    @include("documents.epis.epis")
  </div>


  @include("documents.epis.form")
  @include("documents.curses.form")
</div>



@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    var url = new URL(window.location.href);
    var param = url.search.replace("?", "");
    if (param) {
      var paramsBusca = new URLSearchParams(param);
      if (paramsBusca.get('curses')) {
        $('#epis').removeClass("active in");
        $('#curses').addClass("active in");

        $('#link-epis').removeClass('active');
        $('#link-curses').addClass('active');
      } else {
        $('#epis').addClass("active in");
        $('#curses').removeClass("active in");
        $('#link-epis').addClass('active');
        $('#link-curse').removeClass('active');
      }
    }


  });

  $('a[data-toggle="tab"]').click(function() {
    console.log($(this).attr('href'))
    if ($(this).attr('href') == "#epis") {
      $('#tab-epis').val('1')
      var params = window.location.search.replace("?", "");

      if (params.indexOf('curses') > -1) {
        $(this).attr('data-redirect', window.location.pathname + '?epis=1');
        $('a[href="#curses"]').attr('data-redirect', null);
      }
    } else {
      $('#tab-curses').val('1')
      $(this).attr('data-redirect', window.location.pathname + '?curses=1');
      $('a[href="#epis"]').attr('data-redirect', null);
    }
  });
</script>
@endpush