<?php

include __DIR__."/chekcookie.php";

if($IsGuide){
    header("Location: process_form.php");
}

    include __DIR__.'/phpmailer/config.php';
    require __DIR__.'/phpmailer/PHPMailer.php';
    require __DIR__.'/phpmailer/SMTP.php';
    require __DIR__.'/phpmailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

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
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $posada = $_POST['posada'];

try{
    $db = new PDO("mysql:servername=$servername;dbname=$dbname;port=$port;", $username, $password);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }

    $query = $db->prepare("SELECT COUNT(*) FROM stud_guide WHERE email_guide LIKE :email");
    $query->execute([":email" => $email]);
    $count = $query->fetchColumn();
    if($count>0){
        $message='Така пошта вже є в базі даних';
    } else {
   
    $query = $db->prepare("INSERT INTO stud_guide (email_guide, first_name_guide, last_name_guide, middle_name_guide, phone_guide, sex_guide, pass_guide, posada_guide) 
    VALUES (:email, :first_name, :last_name, :middle_name, :phone, :sex, :pass, :posada)");

    $query->execute([":email" => $email,":first_name" => $first_name,":last_name" => $last_name, ":middle_name" => $middle_name, ":pass" => $pass, ":phone" => $phone, ":sex" => $sex, ":posada" => $posada]);

    $body = "
    <!DOCTYPE html>
    <html lang=\"ru\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>LSGD</title>
            <style type=\"text/css\">
                
            </style>
        </head>
        <body>
            <p>Ім'я: $first_name</p>
            <p>Призвіще: $last_name</p>
            <p>Пошта: $middle_name</p>
            <p>Електрона пошта: $email</p>
            <p>Телефон: $phone</p>
            <p>Стать: $sex</p>
            <p>Бажана посада: $posada</p>
        </body>
    </html>
    ";

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->CharSet = "utf-8";
    $mail->ContentType = "text/html";
    $mail->Host = $emailHost;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = $emailSecure;
    $mail->Port = $emailPort;
    $mail->Username = $emailUser;
    $mail->Password = $emailPassword;
    $mail->Subject = 'Реєстрація на сайті';
    $mail->setFrom($emailUser);
    $mail->isHTML(true);
    $mail->Body = $body;
    $mail->addAddress('badrilika4@gmail.com');
    // $mail->addAddress($email);
    // $mail->SMTPDebug = 1;
    if($mail->Send()){
        $send = true;
    } else {
        $send = false;
    }
    $mail->smtpClose();

     header("Location: process_form.php");
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
        <h3>Реєстрація вчителів та інших працівників</h3>
        <form action="regist_guide.php" method="post">
            <div>
                <label for="first_name">Ім'я:</label><br>
                <input type="text" id="first_name" name="first_name" required><br>
            </div>
            <div>
                <label for="last_name">Прізвище:</label><br>
                <input type="text" id="last_name" name="last_name" required><br>
            </div>
            <div>
                <label for="middle_name">По батькові:</label><br>
                <input type="text" id="middle_name" name="middle_name" required><br>
            </div>
            <div>
                <label for="email">Електрона пошта:</label><br>
                <input type="email" id="email" name="email" placeholder="example@example.com" required><br>
            </div>
            <div>
                <label for="pass">Бажаний пароль:</label><br>
                <input type="text" id="pass" name="pass" required><br>
            </div>
            <div>
                <label for="phone">Номер телефону:</label><br>
                <input type="tel" id="phone" name="phone" required><br>
            </div>
            <div>
                <label for="sex">Стать:</label><br>
                <input type="text" id="sex" name="sex" required><br>
            </div>
            <div>
                <label for="posada">Посада:</label><br>
                <input type="text" id="posada" name="posada" placeholder="Окрім директора і спеціалісту по підтримці системи" required><br>
            </div>
    


    </select><br>
    </div>
    <!-- Добавьте другие поля, если необходимо -->
    <button type="submit" style="margin-left: 5% ;width: 15%; height: 50%;">Зареєструватися</button>
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
