<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('visiteur.dashboard')}}"> <img alt="image" src="{{asset('dashboard/img/uh1.ico')}}" class="header-logo" /> <span
            class="logo-name">UH1</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown {{ Route::currentRouteNamed('visiteur.dashboard') ? 'active' : '' }}">
          <a href="{{route('visiteur.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        {{-- <li class="dropdown {{ Route::currentRouteNamed('visiteur.etablissement.index') ? 'active' : '' }}">
          <a href="{{route('visiteur.etablissement.index')}}" class="nav-link"><i data-feather="home"></i><span>Etablissements</span></a>
        </li> --}}
        
       
     
        
      </ul>
    </aside>
  </div>
