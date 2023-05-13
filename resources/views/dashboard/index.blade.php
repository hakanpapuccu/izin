@include('dashboard.header')

  

@include('dashboard.sidebar')
		
		<!--**********************************
            Content body start
        ***********************************-->
         @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->
		
		
@include('dashboard.footer')