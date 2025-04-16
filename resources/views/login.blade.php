<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/login.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
      
          <!-- Icon -->
          <div class="fadeIn first">
            <img src="img/Logo.png" id="icon" alt="User Icon" />
            <h1>Farmacia DiagnoSalud</h1>
            @if (session('message'))
            <h4 class="text-{{session('type')}}">{{session('message')}}</h4>
            @endif
          </div>
      
          <!-- Login Form -->
          <form action="{{route('login')}}" method="POST">
            @csrf
            <input type="text" id="name" class="fadeIn second" name="name" placeholder="Usuario">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Contraseña">
            <input type="submit" class="fadeIn fourth" value="Ingresar">
        </form>
      
        </div>
    </div>
</body>
</html>