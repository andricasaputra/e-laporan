@if (Session::has('success'))
   <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('warning'))
    <div class="alert alert-danger">{{ Session::get('warning') }}</div>
@endif

@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{$error}}</div>
  @endforeach
@endif

