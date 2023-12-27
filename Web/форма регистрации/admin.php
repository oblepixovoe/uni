<html>
  <head>
    <style>
      body { display: flex; flex-direction: column; font-size: 24pt; font-family: sans-serif; background-color: #fff0f5; }
      #adm, #open, #dela {
        display: flex; flex-direction: column;
        text-align: center; width: 60%;
        border: 2px solid black; border-radius: 20px;
        position: relative; left: 20%; top: 90px;
        background-color: white;
        box-shadow: 5px 5px 10px #f5aeb5;
      }
      div {
        display: grid; grid-template-columns: 5% 45% 25% 15%; grid-row-gap: 20px;
        font-size: 13pt; text-align: left;
        margin-left: 20px; margin-bottom: 20px;
      }
      .back { position: absolute; width: 25%;}
      button, .back { background-color: #fadcdf; height: 40px; border-radius: 20px; font-size: 14pt; }
      button { width: 50%; margin-left: 25%; }
      button:hover, .back:hover { background-color: #f5aeb5; }
      legend { font-size: 22pt; }
      #adm > p, #dela > p { margin-bottom: 10px; }
      #adm > div > label, #dela > div > label { box-shadow: 0px 2px 0px #f5aeb5; }
      #open { padding-top: 20px; padding-bottom: 20px; }
      #open > div { display: grid; grid-template-columns: 35% 60%; grid-gap: 20px; font-size: 20pt; margin-top: 30px; }
      #open > div > label { text-align: right; font-size: 18pt; }
      #open > div > input { width: 70%; }
      #open > p {color: red; font-size: 14pt;}
    </style>
  </head>
  <body>
  <?php
    session_start();

    $subjects = [
      1 => 'Бизнес и коммуникации',
      2 => 'Технологии',
      3 => 'Реклама',
      4 => 'Маркетинг',
      5 => 'Проектирование',
    ];

    $dbname = 'yana35';
    $username = 'yana35';
    $password = 'NZB7y2xk';

    $host = 'localhost';

    $dbo = new PDO(
      "mysql:host=$host;dbname=$dbname",
      $username,
      $password
    );

    $admin_login = 'root';
    $admin_password = 'root';

    if (isset($_POST['exit'])) {
      session_regenerate_id(true);
      session_destroy();
      header('Location: admin.php');
    }

    if (isset($_POST['enter'])) {
      foreach ($_POST as $del) if ($del != ''){
        $sql = $dbo->prepare( "UPDATE `participants` SET `deleted_at` = NOW(), `updated_at` = NOW() WHERE `id` = $del;" );
        $sql->execute();
      }
    }
    if (isset($_POST['enter']) or isset($_POST['back'])) header('Location: admin.php');

    if (isset($_POST['login']) and isset($_POST['password'])){
      if ($_POST['login'] == 'root' and $_POST['password'] == 'root'){
        session_regenerate_id(true);
        $_SESSION['session'] = strtotime(date('d.m.Y H:i:s'));
        $_SESSION['error'] = False;
        header('Location: admin.php');
      }
      else {
        $_SESSION['error'] = True;
      }
    }

    $href = '"../"';
    if (isset($_SESSION['session'])) echo "<form action='#' method='post'><button style='left: 5%; margin-left: 0;' name='exit' value='0' class='back'>Выйти</button></form>";
    echo "<input type='button' style='left: 70%;' onclick='window.location.href=$href' value='Назад' class='back'/>";

    if (isset($_SESSION['session'])){
      if (isset($_POST['del'])){
        echo '<form action="#" method="post" id="dela">';
        echo "<p>Подтвердите удаление</p>";
        echo '<button style="margin-top: 20px; margin-bottom: 20px;" type="submit" name="back">Отменить</button>';
        echo '<button style="margin-top: 20px; margin-bottom: 20px; margin-top: -10px; " type="submit" name="enter">Удалить отмеченное</button><div>';

        $sql = "SELECT * FROM `participants` WHERE `id` = ''";
        foreach ($_POST as $dt) if ($dt != '') $sql .= " OR `id` = $dt";

        $sql = $dbo->prepare( $sql );
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        if ($sql->rowCount() != 0){
          $headers = array_keys($data[0]);
          foreach ($data as $dt) {
            if ($dt['deleted_at'] == NULL){
              echo "<input style='width: 20px; height: 20px; margin-top: 2%;' type='checkbox' name='{$dt["id"]}' value='{$dt["id"]}' checked><label for='{$dt["id"]}'>{$dt[$headers[1]]} {$dt[$headers[2]]}</label>";
              echo "<label for='{$dt["id"]}'>{$dt[$headers[3]]}</label><label for='{$dt["id"]}'>{$subjects[$dt[$headers[5]]]}</label>";
            }
          }
        }
        echo "</div></form>";
      }
      else{
        echo '<form action="#" method="post" id="adm">';
        echo "<p>Страница администратора</p>";
        echo '<button style="margin-top: 20px; margin-bottom: 20px;" type="submit" name="del">Удалить</button>';
        echo "<div>";

        $sql = $dbo->prepare( "SELECT * FROM `participants`;" );
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $headers = array_keys($data[0]);

        foreach ($data as $dt) {
          if ($dt['deleted_at'] == NULL){
            echo "<input style='width: 20px; height: 20px; margin-top: 2%;' type='checkbox' name='{$dt["id"]}' value='{$dt["id"]}'><label for='{$dt["id"]}'>{$dt[$headers[1]]} {$dt[$headers[2]]}</label>";
            echo "<label for='{$dt["id"]}'>{$subjects[$dt[$headers[5]]]}</label><label for='{$dt["id"]}'>{$dt[$headers[3]]}</label>";
          }
        }
        echo '</div></form>';
      }
    }
    else{
      echo '<form action="#" method="post" id="open">';
      echo '<legend>Войти как администратор:</legend>';
      if (isset($_SESSION['error']) and $_SESSION['error'] == True){
        echo '<p>Неправильно введены логин или пароль!</p>';
      }
      echo '<div><label for="login">Логин:</label><input type="text" name="login" placeholder="" required>';
      echo '<label for="password">Пароль:</label><input type="password" name="password" id="pass" required></div>';
      echo '<button type="submit">Войти</button></form>';
    }

    if (isset($_SESSION['session']) and strtotime(date('d.m.Y H:i:s')) - $_SESSION['session'] >= 1800){
      session_regenerate_id(true);
      session_destroy();
    }
  ?>
  </body>
</html>
