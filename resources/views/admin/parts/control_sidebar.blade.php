 <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      
        
           <a class="" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
    	    </a>
       
	    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	        @csrf
	    </form>
        <ul class="lang">
        <li>
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a> 
                
            @endforeach
        </li>
      </ul>
    </div>

  </aside>
  <!-- /.control-sidebar -->