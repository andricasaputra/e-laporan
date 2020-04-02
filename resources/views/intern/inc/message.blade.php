@if (session()->has('success'))
   <div class="alert alert-success">{{ session()->get('success') }}</div>
@elseif (session()->has('warning'))
    <div class="alert alert-danger">{{ session()->get('warning') }}</div>
@endif

@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif

 <div id="message"></div>

