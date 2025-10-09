<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('etudiant.dashboard')}}"> <img alt="image" src="{{asset('dashboard/img/uh1.ico')}}" class="header-logo" /> <span
            class="logo-name">UH1</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown {{ Route::currentRouteNamed('etudiant.dashboard') ? 'active' : '' }}">
          <a href="{{route('etudiant.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('etudiant.candidatures.index') ? 'active' : '' }}">
          <a href="{{route('etudiant.candidatures.index')}}" class="nav-link"><i data-feather="folder"></i><span>Mes candidatures</span></a>
        </li>
    
        
      </ul>
    </aside>
  </div>
