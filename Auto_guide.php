<?php

    include __DIR__."/chekcookie.php";

$servername = "127.0.0.1"; // Ваш сервер базы данных
$username = "root"; // Ваше имя пользователя для доступа к базе данных
$password = ""; // Ваш пароль для доступа к базе данных
$dbname = "budynok"; // Имя вашей базы данных
$port = 3307;

try{
    $db = new PDO("mysql:servername=$servername;dbname=$dbname;port=$port;", $username, $password);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }

if(!empty($_COOKIE["GuideCookie"])){
    $data = json_decode($_COOKIE["GuideCookie"], true);

        $query = $db->prepare("SELECT pass_guide FROM stud_guide WHERE id_guide = :id");
        $query->execute([':id'=>$data["id_guide"]]);
        $result = $query->fetchColumn();

        if($result != $data["pass_guide"]){
            setcookie("GuideCookie", false, 0, "/");  /* срок действия 1 час */
            header("Location: Auto_guide.php");
        } else {
            header("Location: Home.php");
        }
}

error_reporting(E_ALL);
if(!empty($_POST)){

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Подключение к базе данных
    
    
    
    // Получаем введенные пользователем данные из формы
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    
    $query = $db->prepare("SELECT pass_guide, id_guide FROM stud_guide WHERE email_guide = :email");
    $query->execute([':email'=>$email]);
    $result = $query->fetch();
    
    if($pass == $result["pass_guide"]){
        $data = json_encode(["id_guide"=>$result["id_guide"], "pass_guide"=>$result["pass_guide"]]);
        setcookie("GuideCookie", $data, time()+86400, "/");  /* срок действия 1 час */
    } else {
        header("Location: Auto_guide.php");
    }
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
        button[type="submit"] {
            font-size: 55%;
            padding: 1% 1%;
        }
        form div {
            margin-bottom: 1%;
        }
        label, select {
            display: inline-block;
            vertical-align: top;
            padding-left: 5%;
        }
        input, select {
            max-width: 100%;
        }
        [input type="email"]{
            margin left: 5%;
        }
        [input type="password"] {
            margin left: 50%;
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
    <h3>Авторизація вчителя</h3>
    
    <?php if(!empty($_POST)){
            echo '<p style="margin-left: 0%;">Ви успішно авторизувалися!</p>';
        } else {
            ?>
            <form action="Auto_guide.php" method="post">
        <label for="email">Електрона пошта:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="pass">Пароль:</label>
        <input type="password" id="pass" name="pass" required>
        <br>
        <button type="submit" style="margin-left: 5%;">Увійти</button>
    </form>
            <?php
    } 
?>

</section>


    <footer>
        <p>БУДИНОК ТВОРЧОСТІ №675 &copy; 2024</p>
    </footer>

</body>
</html>