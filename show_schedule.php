<?php
// Подключаем файл для проверки авторизации
include __DIR__."/chekcookie.php";

// Проверяем, была ли отправлена форма с выбором группы
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["group"])) {
    $selected_group = $_POST["group"];

    // Подключаемся к базе данных
    $servername = "127.0.0.1"; // Ваш сервер базы данных
    $username = "root"; // Ваше имя пользователя для доступа к базе данных
    $password = ""; // Ваш пароль для доступа к базе данных
    $dbname = "budynok"; // Имя вашей базы данных
    $port = 3307;

    try {
        $db = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Включаем режим обработки ошибок
    } catch (PDOException $exception) {
        die("Ошибка подключения к базе данных: " . $exception->getMessage());
    }

    // Запрос на получение расписания выбранной группы
    $query = "SELECT day_subject, name_subject, stud_guide.first_name_guide, stud_guide.last_name_guide, stud_guide.middle_name_guide 
              FROM stud_subject
              INNER JOIN stud_guide ON stud_subject.id_guide = stud_guide.id_guide
              INNER JOIN stud_group ON stud_subject.id_group = stud_group.id_group
              WHERE stud_group.name_group = :group_name
              ORDER BY 
              CASE day_subject
                  WHEN 'Понеділок' THEN 1
                  WHEN 'Вівторок' THEN 2
                  WHEN 'Середа' THEN 3
                  WHEN 'Четвер' THEN 4
                  WHEN 'П''ятниця' THEN 5
                END";

    try {
        // Подготавливаем запрос
        $stmt = $db->prepare($query);
        // Подставляем значение выбранной группы в запрос
        $stmt->bindParam(":group_name", $selected_group);
        // Выполняем запрос
        $stmt->execute();
        // Получаем результат
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        die("Ошибка выполнения запроса: " . $exception->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Будинок творчості №675</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            border: 0;
            box-sising: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-image: url(163310-priroda-korichnevyj_cvet-okruzhayushchaya_sreda-peyzash-list-3840x2160.jpg);
            background-size: cover;
            color: #8B0000;
            display: flex;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }
        .logo {
            flex: 1; /* Растягиваем логотип, чтобы он занимал доступное пространство */
        }
        .logo img {
            max-width: 50%; /* Максимальная ширина изображения логотипа */
            height: 100%; /* Автоматическая высота для сохранения пропорций */
            padding-left: 40%;
        }
        .title {
            flex: 2; /* Размер текста */
        }
        .title h1 {
            font-size: 250%; /* Размер текста */
            text-align: left;
            padding-left: 15%;
            color: #8B0000;
        }
        .title h2 {
            font-size: 120%; /* Размер текста */
            color: #8B0000;
            text-align: left;
            padding-left: 15%;
        }
        nav {
            background-image: url('151124-desert-art-eolovogorelefa-illustracia-noch-3840x2160.png'); 
            background-size: cover;
            background-repeat: no-repeat;
            color: #8B0000;
            height: 5rem;
            display: block;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            height: 100%;
        }
        nav ul li {
            margin: 0 0.5%;
            height: 100%;
            transition: background-color 0.5s ease;
        }
        nav ul li a {
            display: flex;
            align-items: center;
            color: #8B0000;
            text-decoration: none;
            height: 100%;
            padding: 0 2rem;
            font-size: 120%;
        }
        nav ul li:hover {
            background-color: #FA8072;
        }
        section {
            background-image: url('151124-desert-art-eolovogorelefa-illustracia-noch-3840x2160.jpg'); /* Задаем фоновое изображение для шапки */
            background-size: cover; /* Растягиваем изображение на всю ширину и высоту страницы */
            background-repeat: no-repeat; /* Отключаем повторение изображения */
            background-position: center top;
            background-attachment: fixed;
            width: 98%;
            padding: 1%;
            padding-bottom: 15%;
            color: #8B0000;
            font-size: 250%;
        }
        section h3{
            text-align: left;
            padding-left: 5%;
        }
        footer {
            background-size: cover; /* Растягиваем изображение на всю ширину шапки */
            background-image: url(1675206856_top-fon-com-p-uyutnii-fon-dlya-prezentatsii-1389.png);
            color: #4B0082;
            padding: 1% 8%;
            text-align: center;
            position: fixed;
            bottom: 0%;
            width: 100%;
        }
        footer p {
            margin-right: 20%; /* Устанавливаем отступ справа */
        }
        section p {
            font-size: 100%;
            text-indent: 5%; /* Для отступа первой строки */
                /* Дополнительные стили, если нужно */
        }
        table{
            margin-left: 5%; /* Задаем отступ слева для таблицы */
        }
        label{
            margin-left: 5%;
        }
        select{
            font-size: 55%;
            padding: 1% 0%;
        }
        th {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-top: 1px solid #ddd;
            text-align: center;
        }
        
        /* Стили для ячеек таблицы */
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-left: 1px solid #ddd;
            border-top: 1px solid #ddd;
            text-align: center;
        }
        button[type="submit"] {
            font-size: 55%;
            padding: 1% 1%;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="480z480_front_33_0_0_0_9f55f8ce2ef22fad777f7883ffc3.png" alt="Логотип школы"> <!-- Вставляем изображение логотипа -->
        </div>
        <div class="title">
            <h1>БУДИНОК ТВОРЧОСТІ №675</h1>
            <h2>Заклад в якому зібрані різні напрямки творчого розвитку дітей та юнацства та їх відпочинку.</h2>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="Home.php">Головна</a></li>
            <li><a href="Info.php">Про нас</a></li>
            <li><a href="Kontakty.php">Контакти</a></li>
            <?php  
            if(!$IsAuth) {
                echo '<li><a href="Registr.php">Реєстрація учню</a></li>'."\n".'<li><a href="regist_guide.php">Реєстрація працівників</a></li>'."\n".'<li><a href="regist_admin.php">Реєстрація адміну</a></li>'."\n".'<li><a href="Auto.php">Авторизація учня</a></li>'."\n".'<li><a href="Auto_guide.php">Авторизація вчителю</a></li>'."\n".'<li><a href="Auto_admin.php">Авторизація адміну</a></li>';
            } else if($IsStud) {
                echo '<li><a href="Group.php">Розклад</a></li>'."\n".'<li><a href="profile.php">Профіль</a></li>'."\n".'<li><a href="clearcookie.php">Вийти</a></li>';
            } else if($IsGuide) {
                echo '<li><a href="Group.php">Розклад</a></li>'."\n".'<li><a href="profile_guide.php">Профіль</a></li>'."\n".'<li><a href="clearcookie.php">Вийти</a></li>';
            } else if($IsAdmin){
                    echo "\n".'<li><a href="regist_group.php">Реєстрація груп</a></li>'."\n".'<li><a href="regist_subject.php">Реєстрація розкладу</a></li>'."\n".'<li><a href="delete_stud.php">Видалення даних учнів</a></li>'."\n".'<li><a href="delete_guide.php">Видалення даних працівників</a></li>'."\n".'<li><a href="delete_group.php">Видалення даних груп</a></li>'."\n".'<li><a href="delete_subject.php">Видалення даних про предмети в розкладі</a></li>'."\n".'<li><a href="profile_admin.php">Профіль</a></li>'."\n".'<li><a href="clearcookie.php">Вийти</a></li>';
            }
            ?>

        </ul>
    </nav>


    <section>
        <h3>Розклад для групи "<?php echo $selected_group; ?>"</h3>
        <?php if (isset($rows) && !empty($rows)): ?>
            <table border="1">
                <tr>
                    <th>День</th>
                    <th>Предмет</th>
                    <th>Ім'я вчителя</th>
                    <th>Прізвище вчителя</th>
                    <th>По батькові вчителя</th>
                </tr>
                <?php 
                $current_day = null;
                foreach ($rows as $row) {
                    if ($row['day_subject'] != $current_day) {
                        $current_day = $row['day_subject'];
                ?>
                <tr>
                    <td rowspan="<?php echo count(array_filter($rows, function($r) use ($current_day) { return $r['day_subject'] == $current_day; })); ?>">
                        <?php echo $current_day; ?>
                    </td>
                    <td><?php echo $row['name_subject']; ?></td>
                    <td><?php echo $row['first_name_guide']; ?></td>
                    <td><?php echo $row['last_name_guide']; ?></td>
                    <td><?php echo $row['middle_name_guide']; ?></td>
                </tr>
                <?php } else { ?>
                    <tr>
                        <td><?php echo $row['name_subject']; ?></td>
                        <td><?php echo $row['first_name_guide']; ?></td>
                        <td><?php echo $row['last_name_guide']; ?></td>
                        <td><?php echo $row['middle_name_guide']; ?></td>
                    </tr>
                <?php }} ?>
            </table>
        <?php else: ?>
            <p>Розклад для даної групи відсутній.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>БУДИНОК ТВОРЧОСТІ №675 &copy; 2024</p>
    </footer>

</body>
</html>