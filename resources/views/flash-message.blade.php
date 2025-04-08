@if(session()->has('success'))
  <p class="alert alert-success">{{ session('success') }}</p>
@endif
@if(session()->has('warning'))
  <p class="alert alert-warning">{{ session('warning') }}</p>
@endif
@if(session()->has('danger'))
  <p class="alert alert-danger">{{ session('danger') }}</p>
@endif          
  


