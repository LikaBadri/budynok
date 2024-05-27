<?php

    if(empty($_COOKIE["GuideCookie"])){
        header("Location: Auto_guide.php");
    } else {
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

        $data = json_decode($_COOKIE["GuideCookie"], true);

        $query = $db->prepare("SELECT pass_guide FROM stud_guide WHERE id_guide = :id");
        $query->execute([':id'=>$data["id_guide"]]);
        $result = $query->fetchColumn();

        if($result != $data["pass_guide"]){
            setcookie("GuideCookie", false, 0, "/");  /* срок действия 1 час */
            header("Location: Home.php");
        }
    }
?>