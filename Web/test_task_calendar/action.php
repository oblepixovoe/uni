<html>
  <head>
  <style>
    body { background-image: url("img/kotik-v-metallicheskoj-miske-gorshok-s-zelenyu.jpg"); background-size: 120%; font-family: sans-serif; font-size: 14pt; background-attachment: fixed;}
    form {
      display: flex; flex-direction: column; width: 80%; margin-left: 7%;
      padding: 40px;
    }
    #exit {
      display: grid; grid-template-columns: 60% 35%; grid-column-gap: 20px;
      border-radius: 20px; border: 2px solid brown;
      padding: 20px; width: 20%; background-color: white;
      position: absolute; left: 75%; top: 2%; margin-left: 0;
    }
    #sort {
      display: flex; border-radius: 20px; border: 2px solid brown; background-color: white;
      width: 60%; margin-left: 17%; margin-top: 7%;
    }
    #sort > div:first-of-type { display: grid; grid-template-columns: 20px 20% 20px 20% 20px 20% 20px 30%; grid-gap: 5px;}
    #sort > div:nth-child(2) { display: grid; grid-template-columns: 20px 13% 20px 13% 20px 20% 20px 30% 20px 30%; grid-gap: 5px;}
    #sort > div:first-of-type > label, #sort > div:nth-child(2) > label { text-align: left; }
    #empty { width: 40%; margin-left: 28%; }
    #empty > button { height: 50px; margin-top: -5%; margin-bottom: -20%;}
    form > div { display: grid; grid-template-columns: 35% 60%; grid-gap: 20px; margin-bottom: 40px;}
    form > div > label { text-align: right;}
    #affair { background-color: white; border: 2px solid brown; border-radius: 20px; margin-top: 10%; }
    #affair > p {color: red; text-align: center;}
    #affair > div > input { width: 50%; }
    #affair > div > button { margin-bottom: -100px; }

    table { border-spacing: 1px; border-collapse: collapse; }
    th, td { border: 2px solid brown; background-color: white; }
    th { background-color: #f2ba9b; }
    input { font-size: 14pt; }
    .txt { border: 0; background: none; text-decoration: underline; font-size: 12pt; }
    button { border-radius: 20px; height: 30px; font-size: 14pt; }
    button:hover { background-color: #f2ba9b; }
    .txt:hover { background: none; color: #e38440; }
  </style>
  </head>
  <body>
    <?php
      session_start();
      $_SESSION['error'] = False;

      if (!isset($_SESSION['session'])) header('Location: index.php');
      if (isset($_POST['update'])) {
        $_SESSION['regim'] = 'update';
        $_SESSION['post_id'] = $_POST['update'];
      }
      if (isset($_POST['create'])) $_SESSION['regim'] = 'create';
      if (isset($_POST['back'])) $_SESSION['regim'] = 'show';

      $dbname = 'supercalendar27';
      $username = 'supercalendar27';
      $password = 'I5enZb2A';
      $host = 'localhost';
      $dbo = new PDO(
        "mysql:host=$host;dbname=$dbname",
        $username,
        $password
      );

      if (isset($_POST['enter'])) foreach ($_POST as $ps) if ($ps == '') $_SESSION['error'] = True;
      if ($_SESSION['error'] == False and isset($_POST['enter'])){
        if ($_POST['enter'] == 'update'){
          $sql = $dbo->prepare( "UPDATE `affairs` SET `description` = :desk, `type` = :type, `place` = :place, `end_date` = :dt WHERE `id` = {$_SESSION['post_id']} LIMIT 1;");
          $sql->execute( [':desk' => $_POST['description'], ':type' => $_POST['type'], ':place' => $_POST['place'], ':dt' => $_POST['end_date']]);
          $_SESSION['regim'] = 'show';
          header('Location: action.php');
        }
        elseif ($_POST['enter'] == 'create'){
          $sql = $dbo->prepare( "INSERT INTO `affairs` (`user_id`, `description`, `type`, `place`, `end_date`) VALUES (:id, :desk, :type, :place, :dt);");
          $sql->execute( [':id' => $_SESSION['user_id'], ':desk' => $_POST['description'], ':type' => $_POST['type'], ':place' => $_POST['place'], ':dt' => $_POST['end_date']]);
          $_SESSION['regim'] = 'show';
          header('Location: action.php');
        }
      }
      if (isset($_POST['end'])){
        $sql = $dbo->prepare( "SELECT `done` FROM `affairs` WHERE `id` = {$_POST['end']} LIMIT 1;");
        $sql->execute();
        $done = $sql->fetch();
        if ($done['done'] == '0') $done = '1';
        else $done = '0';
        $sql = $dbo->prepare( "UPDATE `affairs` SET `done` = :done WHERE `id` = {$_POST['end']} LIMIT 1;");
        $sql->execute( [':done' => $done]);
        header('Location: action.php');
      }

      if (isset($_POST['exit'])) {
        session_regenerate_id(true);
        session_destroy();
        header('Location: index.php');
      }

      if (isset($_POST['delete'])){
        $sql = $dbo->prepare( "DELETE FROM `affairs` WHERE `id` = {$_POST['delete']};" );
        $sql->execute();
      }

      echo "<form action='#' method='post' id='exit'>";
      echo "<a>{$_SESSION['login']}</a>";
      echo "<button type='submit' name='exit'>Выйти</button>";
      echo "</form>";

      if (!isset($_SESSION['regim']) or $_SESSION['regim'] == 'show'){
        echo "<form action='#' method='post' id='sort'><div>";
        if (isset($_POST['how_sort']) and $_POST['how_sort'] == 'now') echo '<input type="radio" id="now" name="how_sort" value="now" checked><label for="now">Текущие</label>';
        else echo '<input type="radio" id="now" name="how_sort" value="now"><label for="now">Текущие</label>';
        if (isset($_POST['how_sort']) and $_POST['how_sort'] == 'last') echo '<input type="radio" id="last" name="how_sort" value="last" checked><label for="last">Просроченные</label>';
        else echo '<input type="radio" id="last" name="how_sort" value="last"><label for="last">Просроченные</label>';
        if (isset($_POST['how_sort']) and $_POST['how_sort'] == 'done') echo '<input type="radio" id="done" name="how_sort" value="done" checked><label for="done">Выполненные</label>';
        else echo '<input type="radio" id="done" name="how_sort" value="done"><label for="done">Выполненные</label>';
        if (!isset($_POST['how_sort']) or $_POST['how_sort'] == 'all') echo '<input type="radio" id="all" name="how_sort" value="all" checked><label for="all">Все</label>';
        else echo '<input type="radio" id="all" name="how_sort" value="all"><label for="all">Все</label>';
        echo "</div><div>";
        if (!isset($_POST['week']) or $_POST['week'] == 'today') echo '<input type="radio" id="today" name="week" value="today" checked><label for="today">Сегодня</label>';
        else echo '<input type="radio" id="today" name="week" value="today"><label for="today">Сегодня</label>';
        if (isset($_POST['week']) and $_POST['week'] == 'tomorrow') echo '<input type="radio" id="tomorrow" name="week" value="tomorrow" checked><label for="tomorrow">Завтра</label>';
        else echo '<input type="radio" id="tomorrow" name="week" value="tomorrow"><label for="tomorrow">Завтра</label>';
        if (isset($_POST['week']) and $_POST['week'] == 'thisweek') echo '<input type="radio" id="thisweek" name="week" value="thisweek" checked><label for="thisweek">На эту неделю</label>';
        else echo '<input type="radio" id="thisweek" name="week" value="thisweek"><label for="thisweek">На эту неделю</label>';
        if (isset($_POST['week']) and $_POST['week'] == 'nextweek') echo '<input type="radio" id="nextweek" name="week" value="nextweek" checked><label for="nextweek">На следующую неделю</label>';
        else echo '<input type="radio" id="nextweek" name="week" value="nextweek"><label for="nextweek">На следующую неделю</label>';
        if (isset($_POST['week']) and $_POST['week'] == 'alltime') echo '<input type="radio" id="alltime" name="week" value="alltime" checked><label for="alltime">Все</label>';
        else echo '<input type="radio" id="alltime" name="week" value="alltime"><label for="alltime">Все</label>';
        echo '</div><div><label for="date">Определенная дата</label><input type="date" name="date"></div>';
        echo "<button type='submit' name='sort'>сортировать</button>";
        echo "</form>";

        echo "<form action='#' method='post' id='empty'><button type='submit' name='create' >Создать запись</button></form>";

        echo "<form action='#' method='post'><table>";
        echo "<tr><th style='width: 97px;'>Выполнено</th><th style='width: 140px;'>Тип</th><th>Задача</th><th style='width: 120px;'>Место</th><th style='width: 120px;'>Дата завершения</th><th style='width: 86px;'></th><th style='width: 76px;'></th><th style='width: 98px;'></th></tr>";
        $sql = "SELECT * FROM `affairs` WHERE `user_id` = {$_SESSION['user_id']}";

        if (isset($_POST['date']) and $_POST['date'] != '') $sql .= " AND `end_date` = :dt";
        elseif (isset($_POST['how_sort']) and $_POST['how_sort'] == 'done') $sql .= " AND `done` = 1";
        elseif (isset($_POST['how_sort']) and $_POST['how_sort'] == 'now') $sql .= " AND `done` = 0 AND `end_date` >= :dt";
        elseif (isset($_POST['how_sort']) and $_POST['how_sort'] == 'last') $sql .= " AND `done` = 0 AND `end_date` < :dt";
        if (!isset($_POST['date']) or $_POST['date'] == '') {
          if (isset($_POST['week']) and $_POST['week'] == 'tomorrow') $sql .= " AND `end_date` = curdate() + 1";
          elseif (isset($_POST['week']) and $_POST['week'] == 'thisweek') $sql .= " AND `end_date` BETWEEN curdate() - INTERVAL DAYOFWEEK(curdate()) + 6 DAY AND curdate() - INTERVAL DAYOFWEEK(curdate()) - 1 DAY";
          elseif (isset($_POST['week']) and $_POST['week'] == 'nextweek') $sql .= " AND `end_date` BETWEEN curdate() - INTERVAL DAYOFWEEK(curdate()) - 2 DAY AND curdate() - INTERVAL DAYOFWEEK(curdate()) - 8 DAY";
          elseif (!isset($_POST['week']) or $_POST['week'] == 'today') $sql .= " AND `end_date` = curdate()";
        }
        $sql = $dbo->prepare( $sql.";" );
        if (isset($_POST['date']) and $_POST['date'] != '') $date = $_POST['date'];
        else $date = date('Y-m-d');
        if ((isset($_POST['how_sort']) and ($_POST['how_sort'] == 'now' or $_POST['how_sort'] == 'last')) or (isset($_POST['date']) and $_POST['date'] != '')) $sql->execute( [':dt' => $date] );
        else $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        if ($sql->rowCount() != 0){
          $headers = array_keys($data[0]);
          foreach ($data as $dt) {
            echo "<tr>";
            if ( $dt[$headers[5]] == 1 ) echo "<td style='color: green'>Завершено</td>";
            elseif ($dt[$headers[5]] == 0 and $dt[$headers[6]] < date('Y-m-d')) {
              echo "<td style='color: red'>Просрочено</td>";
            }
            else echo "<td>В процессе</td>";
            echo "<td style='text-align: center;'>{$dt[$headers[3]]}</td><td>{$dt[$headers[2]]}</td><td style='text-align: center;'>{$dt[$headers[4]]}</td><td>{$dt[$headers[6]]}</td>";
            echo "<td><button type='submit' name='update' class='txt' value='{$dt['id']}'>изменить</button></td><td><button type='submit' name='delete' class='txt' value='{$dt['id']}'>удалить</button></td>";
            if ($dt[$headers[5]] == 0) echo "<td><button type='submit' name='end' class='txt' value='{$dt['id']}'>Завершить</button></td></tr>";
            else echo "<td><button type='submit' style='font-size: 10pt;' name='end' class='txt' value='{$dt['id']}'>Отменить завершение</button></td></tr>";
          }
        }
        echo "</table>";
        echo "</form>";
      }
      else {
        if ($_SESSION['regim'] == 'update' AND !isset($_POST['description'])){
          $sql = $dbo->prepare( "SELECT * FROM `affairs` WHERE `id` = {$_SESSION['post_id']} LIMIT 1;");
          $sql->execute();
          if ($sql->rowCount() != 0) $date = $sql->fetch();
          $_POST = $date;
        }
        echo "<form action='#' method='post' id='affair'>";
        if (isset($_SESSION['error']) and $_SESSION['error'] == 'true') echo '<p>Ошибка заполнения полей</p>';
        if (isset($_POST['description'])) echo "<div><label for='description'>Задача:</label><input type='text' name='description' value='{$_POST['description']}'>";
        else echo "<div><label for='description'>Задача:</label><input type='text' name='description'>";
        if (isset($_POST['type'])) echo "<label for='type'>Тип:</label><input type='text' name='type' value='{$_POST['type']}'>";
        else echo "<label for='type'>Тип:</label><input type='text' name='type'>";
        if (isset($_POST['place'])) echo "<label for='place'>Место:</label><input type='text' name='place' value='{$_POST['place']}'>";
        else echo "<label for='place'>Место:</label><input type='text' name='place'>";
        if (isset($_POST['end_date'])) echo "<label for='end_date'>дата</label><input type='date' name='end_date' value='{$_POST['end_date']}'></div>";
        else echo "<label for='end_date'>дата</label><input type='date' name='end_date'></div>";
        echo "<div><button type='submit' name='back'>Отменить</button>";
        if ($_SESSION['regim'] == 'update') echo "<button type='submit' name='enter' value='update'>Применить</button>";
        if ($_SESSION['regim'] == 'create') echo "<button type='submit' name='enter' value='create'>Создать</button>";
        echo "</div></form>";
      }

      if (isset($_SESSION['session']) and strtotime(date('d.m.Y H:i:s')) - $_SESSION['session'] >= 1800){
        session_regenerate_id(true);
        session_destroy();
        header('Location: index.php');
      }
    ?>
  </body>
</html>