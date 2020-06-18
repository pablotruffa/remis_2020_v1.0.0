<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('css/layout.css')}}">
    <link rel="stylesheet" href="{{url('css/table.css')}}">
    <link rel="stylesheet" href="{{url('css/message.css')}}">
    <link rel="stylesheet" href="{{url('css/icons/all.css')}}">
    @stack('styles')
    <title>@yield('title')</title>
</head>
<body id="site">
    <header>
        <nav id="mobile-nav">
            <div>
                <a href="#"id="menu_icon">Menu</a>
                <ul id="mobile-nav-body">
                    @if( in_array(Session::get('level'),['Admin','Root']) )
                    <li><a href="{{route('reservations.index')}}">Reservas</a></li>
                    <li><a href="{{route('clients.index')}}">Clientes</a></li>
                    
                    <li><a href="{{route('drivers.index')}}">Choferes</a></li>
                    <li><a href="{{route('presenteeism.index')}}">Presentismo</a></li>
                    @if(Session::get('level') == 'Root')
                    <li><a href="{{route('users.index')}}">Usuarios</a></li>
                    <li><a href="{{route('audit.index')}}">Auditoría</a></li>
                    @endif
                    <li><a href="{{route('vehicles.index')}}">Vehículos</a> </li>
                    <li><a href="{{route('brands.index')}}">Marcas</a></li>
                    <li><a href="{{route('colors.index')}}">Colores</a></li>
                    @elseif(Session::get('level') == 'Driver')
                    <li><a href="{{route('profile')}}">Perfil</a></li>
                    <li><a href="{{route('trips')}}">Viajes</a></li>
                    <li><a href="{{route('wallet')}}">Billetera</a></li>
                    @endif
                    <li><a href="{{route('auth.logout')}}">Cerrar Sesión</a></li>
                </ul>
            </div>
            <div>
                <a href="{{url('/')}}"><img src="{{url('assets/logo.jpg')}}" alt="logo" id="logo"></a>
            </div>
        </nav>
    </header>
    <div id="sidebar">
        <ul>
            @if( in_array(Session::get('level'),['Admin','Root']) )
            <li><a href="{{route('reservations.index')}}"><span>Reservas</span><i class="gg-list"></i></a></li>
            <li><a href="{{route('clients.index')}}"><span>Clientes</span><i class="gg-user-list"></i></a></li>
            
            <li><a href="{{route('drivers.index')}}">Choferes<i class="gg-user"></i></a></li>
            <li><a href="{{route('presenteeism.index')}}"><span>Presentismo</span><i class="gg-play-list-check"></i></a></li>
            @if(Session::get('level') == 'Root')
            <li><a href="{{route('users.index')}}"><span>Usuarios</span><i class="gg-list-tree"></i></a></li>
            <li><a href="{{route('audit.index')}}"><span>Auditoría</span><i class="gg-play-list-search"></i></a></li>
            @endif
            <li><a href="{{route('vehicles.index')}}"><span>Vehículos</span><i class="gg-edit-mask"></i></a> </li>
            <li><a href="{{route('brands.index')}}"><span>Marcas</span><i class="gg-copyright"></i></a></li>
            <li><a href="{{route('colors.index')}}"><span>Colores</span><i class="gg-color-picker"></i></a></li>
            @elseif(Session::get('level') == 'Driver')
            <li><a href="{{route('profile')}}"><span>Perfil</span><i class="gg-profile"></i></a></li>
            <li><a href="{{route('trips')}}"><span>Viajes</span><i class="gg-list"></i></a></li>
            <li><a href="{{route('wallet')}}"><span>Billetera</span><i class="gg-credit-card"></i></a></li>
            @endif
            <li><a href="{{route('auth.logout')}}"><span>Cerrar Sesión</span><i class="gg-close"></i></a></li>
        </ul>
    </div>
    <main>
    @yield('main')
    </main>
    <footer>
        <div>
            <p>TP Final DW 4to Cuatrimestre - Aplicaciones Enriquecidas</p> 
        </div>
    </footer>
    <script src="{{url('js/jquery.js')}}"></script>
    <script src="{{url('js/layout.js')}}"></script>
    <script src="{{url('js/alerts.js')}}"></script>
</body>
</html>