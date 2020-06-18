<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('css/login.css')}}">
    <link rel="stylesheet" href="{{url('css/message.css')}}">
    <link rel="stylesheet" href="{{url('css/icons/all.css')}}">
    <title>Login Remis 2020</title>
</head>
<body id="site">
    <header>
        <nav>
            <div>
                <img src="{{url('assets/logo.jpg')}}" alt="logo">
            </div>
        </nav>
    </header>
    <main>
        <section id="login">
            <div>
                <h1>Panel Remis v.2020</h1>
                <p>Ingresá tus credenciales para acceder.</p>
            </div>
            <div>
                <form action="{{route('auth.doLogin')}}" method="POST">
                    @csrf
                    <div>
                        <input type="email" name="email" placeholder="correo electrónico" required>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="contraseña" required>
                    </div>
                    <div>
                        <button>Ingresar</button>
                    </div>
                </form>
            </div>
            @if(Session::has('message'))
            <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
            </div>
            @endif
        </section>
        <div>
          
        </div>
    </main>
    <footer>
        <div>
            <p>TP Final DW 4to Cuatrimestre - Aplicaciones Enriquecidas</p> 
        </div>
    </footer>
    <script src="{{url('js/jquery.js')}}"></script>
    <script src="{{url('js/alerts.js')}}"></script>
</body>
</html>