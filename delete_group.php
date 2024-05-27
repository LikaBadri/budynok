<?php

include __DIR__."/chekcookie.php";

error_reporting(0);
if(!empty($_POST)){

    $servername = "127.0.0.1"; // Имя сервера базы данных
    $username = "root"; // Имя пользователя базы данных
    $password = ""; // Пароль пользователя базы данных
    $dbname = "budynok"; // Имя базы данных
    $port = 3307;

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $name_group = $_POST['name_group'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $birth = $_POST['birth'];

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname;port=$port;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query = $db->prepare("DELETE FROM stud_group WHERE name_group = :name_group");
        

        $query->execute(array('name_group' => $name_group));

        header("Location: process_delete.php");
        exit();
    } catch (PDOException $exception) {
        echo "Ошибка при выполнении запроса: " . $exception->getMessage();
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
            overflow: hidden;
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
        div {
            padding-left: 5%;
        }
        button[type="submit"] {
            font-size: 55%;
            padding: 1% 0%;
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
    <h3>Видалення даних груп</h3>
    <!-- Выводим сообщение об успехе или ошибке, если оно есть -->
    <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
    
    <form action="delete_group.php" method="post">
        <div>
            <label for="name_group">Введіть назву групи для видалення:</label><br>
            <input type="text" id="name_group" name="name_group" required><br>
        </div>
        <button type="submit" name="submit" style="margin-left: 5% ;width: 15%; height: 50%;">Видалити дані групи</button>
    </form>
</section>
        
    
</body>
</html>

    </section>

    <footer>
        <p>БУДИНОК ТВОРЧОСТІ №675 &copy; 2024</p>
    </footer>

</body>
</html>
