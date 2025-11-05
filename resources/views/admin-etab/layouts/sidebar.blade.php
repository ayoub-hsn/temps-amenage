<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('admin-etab.dashboard')}}"> <img alt="image" src="{{asset('dashboard/img/uh1.ico')}}" class="header-logo" /> <span
            class="logo-name">UH1</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-etab.dashboard') ? 'active' : '' }}">
          <a href="{{route('admin-etab.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        {{-- <li class="dropdown {{ Route::currentRouteNamed('admin-etab.responsable.index') ? 'active' : '' }}">
          <a href="{{route('admin-etab.responsable.index')}}" class="nav-link"><i data-feather="users"></i><span>Responsables</span></a>
        </li> --}}
        <li class="dropdown {{ Route::currentRouteNamed('admin-etab.filiere.bachelier.index') ? 'active' : '' }}">
          <a href="{{route('admin-etab.filiere.bachelier.index')}}" class="nav-link"><i data-feather="log-in"></i><span>Bachelier</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-etab.filiere.licencexcellence.index') ? 'active' : '' }}">
          <a href="{{route('admin-etab.filiere.licencexcellence.index')}}" class="nav-link"><i data-feather="award"></i><span>Licence</span></a>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-etab.filiere.master.index') ? 'active' : '' }}">
          <a href="{{route('admin-etab.filiere.master.index')}}" class="nav-link"><i data-feather="book-open"></i><span>Master</span></a>
        </li>
        {{-- <li class="dropdown {{ (Route::currentRouteNamed('admin-etab.master.candidat.index') || Route::currentRouteNamed('admin-etab.passerelle.candidat.index')) ? 'active' : '' }}">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="user-check"></i><span>Candidats</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Route::currentRouteNamed('admin-etab.master.candidat.index') ? 'active' : '' }}"><a href="{{ route('admin-etab.master.candidat.index') }}">Master</a></li>
          </ul>
          <ul class="dropdown-menu">
            <li class="{{ Route::currentRouteNamed('admin-etab.passerelle.candidat.index') ? 'active' : '' }}"><a href="{{ route('admin-etab.passerelle.candidat.index') }}">Licence</a></li>
          </ul>
        </li> --}}
        {{-- <li class="dropdown {{ Route::currentRouteNamed('admin-etab.actualite.index') ? 'active' : '' }}">
          <a href="{{route('admin-etab.actualite.index')}}" class="nav-link"><i data-feather="book"></i><span>Actualités</span></a>
        </li> --}}
        <li class="dropdown {{ Route::currentRouteNamed('admin-etab.notification.create') ? 'active' : '' }}">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="message-circle"></i><span>Messages</span></a>
            <ul class="dropdown-menu">
              <li class="{{ Route::currentRouteNamed('admin-etab.notification.create') ? 'active' : '' }}"><a href="{{ route('admin-etab.notification.create') }}">Creer</a></li>
            </ul>
        </li>
        <li class="dropdown {{ Route::currentRouteNamed('admin-etab.etablissement.parametre.edit') ? 'active' : '' }}">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="settings"></i><span>Paramètres</span></a>
          <ul class="dropdown-menu">
            <li class="{{ Route::currentRouteNamed('admin-etab.etablissement.parametre.edit') ? 'active' : '' }}"><a href="{{ route('admin-etab.etablissement.parametre.edit') }}">Mon Etablissement</a></li>
          </ul>
        </li>



      </ul>
    </aside>
  </div>
