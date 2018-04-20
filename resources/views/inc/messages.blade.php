@if(count($errors) > 0)
  @foreach($errors->all() as $error)
    <script>
      Materialize.toast("{{ $error }}")
    </script>
  @endforeach
@endif

@if(session('success'))
  <script>
    Materialize.toast("{{ @session('success') }}");
  </script>
@endif

@if(session('error'))
  <script>
      Materialize.toast("{{ @session('error') }}");
  </script>
@endif
