@layout('layout.logged')

@section('content')
<div class="content-wrapper hasleft">
	@yield('left')

    @yield('right')
</div>
@endsection