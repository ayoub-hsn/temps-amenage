<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('sup-admin.dashboard')}}"> <img alt="image" src="{{asset('dashboard/img/uh1.ico')}}" class="header-logo" /> <span
            class="logo-name">UH1</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown {{ Route::currentRouteNamed('sup-admin.dashboard') ? 'active' : '' }}">
          <a href="{{route('sup-admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('sup-admin.etablissement.index') ? 'active' : '' }}">
          <a href="{{route('sup-admin.etablissement.index')}}" class="nav-link"><i data-feather="home"></i><span>Etablissements</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('sup-admin.user.index') ? 'active' : '' }}">
          <a href="{{route('sup-admin.user.index')}}" class="nav-link"><i data-feather="users"></i><span>Utilisateurs</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('sup-admin.actualite.index') ? 'active' : '' }}">
          <a href="{{route('sup-admin.actualite.index')}}" class="nav-link"><i data-feather="book"></i><span>Actualités</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('sup-admin.serie_bac.index') ? 'active' : '' }}">
          <a href="{{route('sup-admin.serie_bac.index')}}" class="nav-link"><i data-feather="layers"></i><span>Diplomes du baccalaureat</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('sup-admin.diplomebacplusdeux.index') ? 'active' : '' }}">
          <a href="{{route('sup-admin.diplomebacplusdeux.index')}}" class="nav-link"><i data-feather="layers"></i><span>Diplomes du Bac+2</span></a>
        </li>

      </ul>
    </aside>
  </div>
