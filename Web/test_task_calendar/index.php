<html>
  <head>
  <style>
    body { background-image: url("img/kotik-v-metallicheskoj-miske-gorshok-s-zelenyu.jpg"); background-size: 120%; font-family: sans-serif; font-size: 14pt; background-attachment: fixed;}
    #open {
      display: flex; flex-direction: column; width: 50%; margin-left: 24%;
      padding: 40px; margin-top: 10%; text-align: center;
      background-color: white; border: 2px solid brown; border-radius: 20px;
    }
    #open > div { display: grid; grid-template-columns: 30% 60%; grid-gap: 20px; margin-bottom: 40px;}
    #open > div > label { text-align: right; }
    #open > a { color: red; margin-bottom: 10px; }
    input { font-size: 14pt; }
    button[name="rrg"], button[name="open"] { border: 0; background: none; text-decoration: underline; font-size: 12pt; }
    button { border-radius: 20px; height: 30px; font-size: 14pt; }
    button:hover { background-color: #f2ba9b; }
    button[name="rrg"]:hover, button[name="open"]:hover { background: none; color: #e38440; }
  </style>
  </head>
  <body>
    <?php
      session_start();
      $_SESSION ["error"] = False;

      $dbname = 'supercalendar27';
      $username = 'supercalendar27';
      $password = 'I5enZb2A';
      $host = 'localhost';
      $dbo = new PDO(
        "mysql:host=$host;dbname=$dbname",
        $username,
        $password
      );

      if (isset($_POST['open'])) $_SESSION['regim'] = 'open';
      if (isset($_POST['rrg'])) $_SESSION['regim'] = 'rrg';

      if (isset($_POST['enter'])){
        session_regenerate_id(true);
        $_POST['enter'] = '0';
        foreach ($_POST as $ps) if ($ps == '') $_SESSION ["error"] = True;
        if ($_SESSION["error"] !== True){
          if (isset($_SESSION['regim']) and $_SESSION['regim'] == 'rrg'){
            $sql = $dbo->prepare( "INSERT INTO `users` (`login`, `email`, `password`) VALUES (:login, :email, :password);");
            $sql->execute( [':login' => $_POST["login"], ':email' => $_POST["email"], ':password' => $_POST["password"]] );
          }
          $sql = $dbo->prepare( "SELECT * FROM `users` WHERE (`login` = :login or `email` = :login) and `password` = :password LIMIT 1;" );
          $sql->execute([':login' => $_POST["login"], ':password' => $_POST["password"]]);
          $user = $sql->fetch();
          if ($sql->rowCount() == 0 ) $_SESSION ["error"] = True;
          else{
            unset($_SESSION['regim']);
            unset($_SESSION['error']);
            $_SESSION['session'] = strtotime(date('d.m.Y H:i:s'));
            $_SESSION['login'] = $user['login'];
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
          }
        }
      }

      if (!isset($_SESSION['session'])){
        echo "<form action='#' method='post' id='open'>";
        if (isset($_SESSION['regim']) and $_SESSION['regim'] == 'rrg'){
          if (isset($_SESSION['error']) and $_SESSION ["error"] == True) echo "<a>Все поля должны быть заполнены!</a>";
          if (isset($_POST['email'])) echo "<div><label for='email'>E-mail:</label><input type='email' name='email' placeholder='ivanov@gmail.com' value='{$_POST["email"]}'>";
          else echo "<div><label for='email'>E-mail:</label><input type='email' name='email' placeholder='ivanov@gmail.com'>";
          if (isset($_POST['login'])) echo "<label for='login'>Логин:</label><input type='text' name='login' value='{$_POST["login"]}'>";
          else echo "<label for='login'>Логин:</label><input type='text' name='login'>";
          echo '<label for="password">Пароль:</label><input type="password" name="password"></div>';
          echo '<button type="submit" name="enter">Зарегестрироваться</button>';
          echo '<button type="submit" name="open">войти</button>';
        }
        else{
          if ($_SESSION ["error"] == True) echo "<a>Логин или пароль введены неверно!</a>";
          if (isset($_POST['login'])) echo "<div><label for='login'>Логин/E-mail:</label><input type='text' name='login' value='{$_POST["login"]}'>";
          else echo "<div><label for='login'>Логин/E-mail:</label><input type='text' name='login'>";
          echo '<label for="password">Пароль:</label><input type="password" name="password"></div>';
          echo '<button type="submit" name="enter">Войти</button>';
          echo '<button type="submit" name="rrg">Регистрация</button>';
        }
        echo "</form>";
      }
      else header('Location: action.php');
    ?>
  </body>
</html>
