<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('admin-filiere.dashboard')}}"> <img alt="image" src="{{asset('dashboard/img/uh1.ico')}}" class="header-logo" /> <span
            class="logo-name">UH1</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.dashboard') ? 'active' : '' }}">
          <a href="{{route('admin-filiere.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.filiere.licencexcellence.index') ? 'active' : '' }}">
          <a href="{{route('admin-filiere.filiere.licencexcellence.index')}}" class="nav-link"><i data-feather="award"></i><span>Licence</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.filiere.master.index') ? 'active' : '' }}">
          <a href="{{route('admin-filiere.filiere.master.index')}}" class="nav-link"><i data-feather="book-open"></i><span>Master</span></a>
        </li>
        {{-- <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.filiere.licence.index') ? 'active' : '' }}">
          <a href="{{route('admin-filiere.filiere.licence.index')}}" class="nav-link"><i data-feather="file-text"></i><span>Licence</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.filiere.licencexcellence.index') ? 'active' : '' }}">
          <a href="{{route('admin-filiere.filiere.licencexcellence.index')}}" class="nav-link"><i data-feather="award"></i><span>Licence</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.filiere.master.index') ? 'active' : '' }}">
          <a href="{{route('admin-filiere.filiere.master.index')}}" class="nav-link"><i data-feather="book-open"></i><span>Master</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-filiere.etablissement.parametre.edit') ? 'active' : '' }}">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="settings"></i><span>Paramètres</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Route::currentRouteNamed('admin-filiere.etablissement.parametre.edit') ? 'active' : '' }}"><a href="{{ route('admin-filiere.etablissement.parametre.edit') }}">Mon Etablissement</a></li>
          </ul>
        </li> --}}



      </ul>
    </aside>
  </div>
