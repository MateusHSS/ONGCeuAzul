<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.css"
        media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- FONTE DA LOGO -->
    <link href="https://fonts.googleapis.com/css?family=Fauna+One&display=swap" rel="stylesheet">

    <!-- CSS DA PAGINA -->
    <link rel="stylesheet" href="../../css/cadastro.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="css/estilo.css">
  </head>

  <body class='valign-wrapper'>
    <div class="container center">
      <h4>Entrar</h4>
      <div class="row center">
        <div class="col m4 offset-m4 card grey-ligthen-4">
          <form class="col m12" action="php/controller/loga.php" method='POST'>
          <div class="row">
            <div class="input-field col m12">
              <input id="user" type="text" class="validate" name='user'>
              <label for="user">Usuário</label>
            </div>
            <div class="input-field col m12">
              <input id="pass" type="password" class="validate" name='pass'>
              <label for="pass">Senha</label>
            </div>
          </div>
          <button class="btn waves-effect waves-light" type="submit" name="action">Entrar
            <i class="material-icons right">send</i>
          </button>
          </form>
        </div>
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
  </body>
</html>