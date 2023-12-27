<html>
  <head>
    <style>
      form{
        display: flex; flex-direction: column;
        text-align: center;
        width: 50%;
        position: relative; left: 25%;
        border: 2px solid black; border-radius: 20px;
        padding-top: 20px; padding-bottom: 20px;
        margin-top: 70px;
        background-color: white;
        box-shadow: 5px 5px 10px #f5aeb5;
      }
      form > div > label { text-align: right; }
      form > div > input, form > div > select { width: 80%; }
      form > div {
        display: grid; grid-template-columns: 35% 60%; grid-column-gap: 20px;
        grid-row-gap: 10px;
        margin-bottom: 10px;
      }
      .mai { grid-template-columns: 20px 60%; margin-left: 40%; width: 100%; }
      .mai > label { text-align: left; }
      select{ font-size: 16pt; }
      body { font-size: 15pt; font-family: sans-serif; background-color: #fff0f5; }
      button { background-color: #fadcdf; width: 50%; position: relative; left: 25%; border-radius: 10px; font-size: 14pt; font-family: sans-serif; height: 40px; }
      button:hover, .but:hover { background-color: #f5aeb5 }
      p { font-size: 22pt; text-align: center; margin-bottom: 10px; }
      legend { color: #ed808b; margin-bottom: 10px; margin-top: 30px; font-size: 18pt;}
      #admin { position: fixed; left: 60%; top: 2%; width: 30%; }
      .but {
        border-radius: 10px; font-size: 20pt; font-family: sans-serif; width: 50%; margin-bottom: 20px;
        position: relative; left: 25%; background-color: #fadcdf;
      }
    </style>
  </head>
  <body>
    <?php
    session_start();

    $dbname = 'yana35';
    $username = 'yana35';
    $password = 'NZB7y2xk';

    $host = 'localhost';

    $dbo = new PDO(
      "mysql:host=$host;dbname=$dbname",
      $username,
      $password
    );

    if (isset($_POST['new'])){
      $_SESSION['form'] = False;
    }

    if (isset($_POST['firstName'])){
      session_regenerate_id(true);

      if (!isset($_POST['mails'])) $_POST['mails'] = 0;
      else $_POST['mails'] = 1;

      $sql = $dbo->prepare( "INSERT INTO `participants` (`name`, `lastName`, `email`, `tel`, `subject_id`, `payment_id`, `mailing`, `created_at`, `updated_at`) VALUES (:N, :lastN, :em, :t, :si, :payi, :mai, NOW(), NOW());" );
      var_dump($_POST);
      $sql->execute(
        [':N' => $_POST["name"], ':lastN' => $_POST["firstName"], ':em' => $_POST["email"], ':t' => $_POST["number"],
        ':si' => $_POST["topic"], ':payi' => $_POST["pay"], ':mai' => $_POST["mails"] ]
      );
      $_SESSION['form'] = True;
      header('Location: index.php');
    }


    if (isset($_SESSION['form']) and $_SESSION['form'] == True){
      echo '<form action="#" method="post">';
      echo "<p>Форма была отправлена!</p>";
      $href = '"../admin.php"';
      echo "<button type='submit' value='' name='new' class='but'>Новая форма</button>";
      echo "<input type='button' onclick='window.location.href=$href' value='Страница администратора' class='but'/></form>";
    }
		else {
      $href = '"./admin.php"';
      echo "<button onclick='window.location.href=$href' id='admin'>Страница администратора</button>";

      echo '<form action="#" method="post">';
      echo '<p>Форма регистрации на конференцию</p>';
      echo '<legend>Персональные данные:</legend>';
      echo "<div><label for='firstName'>Фамилия:</label><input type='text' name='firstName' placeholder='Иванов' required>";
      echo "<label for='name'>Имя:</label><input type='text' name='name' placeholder='Иван' required></div>";

      echo '<legend>Контактные данные:</legend>';
      echo "<div><label for='email'>E-mail:</label><input type='email' name='email' placeholder='ivanov@gmail.com' required>";
      echo "<label for='number'>Телефон:</label><input type='tel' name='number' placeholder='+7 000 000-00-00' maxlength='21' required>";

      echo "<label>Интересующая тематика:</label><select name='topic''>";
      echo '<option value=1>Бизнес и коммуникации</option>';
      echo '<option value=2>Технологии</option>';
      echo '<option value=3>Реклама</option>';
      echo '<option value=4>Маркетинг</option>';
      echo '<option value=5>Проектирование</option>';
      echo "</select>";

      echo "<label>Способ оплаты:</label><select name='pay'>";
      echo '<option value=1>WebMoney</option>';
      echo '<option value=2>Яндекс.Деньги</option>';
      echo '<option value=3>PayPal</option>';
      echo '<option value=4>Кредитная карта</option>';
      echo '<option value=5>Робокасса</option>';
      echo "</select></div>";

      echo "<div class='mai'><input style='width: 20px; height: 20px;' type='checkbox' name='mails' checked><label for='mails'>Я хочу получать рассылку</label></div>";

      echo '<button type="submit">Отправить</button>';
      echo '</form>';
    }


    ?>
  </body>
</html>
