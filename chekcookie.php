<?php
    $IsAuth = false;
    $IsAdmin = false;
    $IsGuide = false;
    $IsStud = false;

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

    if(!empty($_COOKIE["AdminCookie"])){
        $data = json_decode($_COOKIE["AdminCookie"], true);
        $query = $db->prepare("SELECT pass_admin FROM stud_admin WHERE id_admin = :id");
        $query->execute([':id'=>$data["id_admin"]]);
        $result = $query->fetchColumn();

        if($result != $data["pass_admin"]){
            setcookie("AdminCookie", false, 0, "/");  /* срок действия 1 час */
        } else {
            $IsAuth = true;
            $IsAdmin = true;
        }

    } else if(!empty($_COOKIE["GuideCookie"])){
    
        $data = json_decode($_COOKIE["GuideCookie"], true);

        $query = $db->prepare("SELECT pass_guide FROM stud_guide WHERE id_guide = :id");
        $query->execute([':id'=>$data["id_guide"]]);
        $result = $query->fetchColumn();

        if($result != $data["pass_guide"]){
            setcookie("GuideCookie", false, 0, "/");  /* срок действия 1 час */
        } else {
            $IsAuth = true;
            $IsGuide = true;
        }

    } else if(!empty($_COOKIE["StudCookie"])){
    
        $data = json_decode($_COOKIE["StudCookie"], true);

        $query = $db->prepare("SELECT pass_stud FROM stud WHERE id_stud = :id");
        $query->execute([':id'=>$data["id_stud"]]);
        $result = $query->fetchColumn();

        if($result != $data["pass_stud"]){
            setcookie("StudCookie", false, 0, "/");  /* срок действия 1 час */
        } else {
            $IsAuth = true;
            $IsStud = true;
        }

        

    }
?>