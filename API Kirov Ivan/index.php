<?php 
include_once("functions.php");
include_once("find_token.php");
include_once("error_handler.php");

if(!isset($_GET['type'])){
    echo ajax_echo(
        "Ошибка!",
        "Вы не указали GET параметр type!",
        "ERROR",
        null
    );
    exit;
}

if(preg_match_all("/^add_client$/ui", $_GET['type'])){
    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "INSERT INTO `clients`(`name`) VALUES ('".$_GET['name']."')";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Клиент добавлен",
        false,
        "SUCCESS"
    );
    exit;
}
else if(preg_match_all("/^add_employee$/ui", $_GET['type'])){
    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр name!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['post_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр post_id!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['salary'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр salary!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "INSERT INTO `employees`(`post_id`, `salary`, `name`) VALUES (".$_GET['post_id'].", ".$_GET['salary'].",'".$_GET['name']."')";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Сотрудник добавлен",
        false,
        "SUCCESS"
    );
    exit;
}
else if(preg_match_all("/^add_room$/ui", $_GET['type'])){
    if(!isset($_GET['number'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр number!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['room_type_num'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр room_type_num!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['price'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр price!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['room_count'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр room_count!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "INSERT INTO `rooms`(`number`,`type`, `price`, `room_count`) VALUES (".$_GET['number'].", ".$_GET['room_type_num'].",".$_GET['price'].", ".$_GET['room_count'].")";
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Номер добавлен",
        false,
        "SUCCESS"
    );
    exit;
}
else if(preg_match_all("/^add_schedule$/ui", $_GET['type'])){
    if(!isset($_GET['employee_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр employee_id!",
            "ERROR",
            null
        );
        exit;
    }
    if(isset($_GET['day'])){
        $query = "INSERT INTO `schedule`(`employee_id`, `day`) VALUES (".$_GET['employee_id'].", '".$_GET['day']."')";
    }
    else{
        $query = "INSERT INTO `schedule`(`employee_id`) VALUES (".$_GET['employee_id'].")";
    }
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Расписание добавлено",
        false,
        "SUCCESS"
    );
    exit;
}
else if(preg_match_all("/^take_room$/ui", $_GET['type'])){
    if(!isset($_GET['room_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр room_id!",
            "ERROR",
            null
        );
        exit;
    }

    $query = "SELECT `date_out` < CURRENT_DATE as 'RESULT' FROM `busy_rooms` WHERE room_id=".$_GET['room_id'];
    $res_query = mysqli_query($connection, $query);
    $res = mysqli_fetch_assoc($res_query);
    if(isset($res['RESULT'])){
        if($res['RESULT'] == false){
            echo ajax_echo(
                "Ошибка!",
                "Номер занят!",
                "ERROR",
                null
            );
            exit;
        }
    }

    if(!isset($_GET['client_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр client_id!",
            "ERROR",
            null
        );
        exit;
    }
    if(!isset($_GET['date_out'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр date_out!",
            "ERROR",
            null
        );
        exit;
    }
    if(isset($_GET['date_in'])){
        $query = "INSERT INTO `busy_rooms`(`room_id`, `client_id`, `date_in`, `date_out`) VALUES (".$_GET['room_id'].", ".$_GET['client_id'].", '".$_GET['date_in']."', '".$_GET['date_out']."')";
    }
    else{
        $query = "INSERT INTO `busy_rooms`(`room_id`, `client_id`, `date_out`) VALUES (".$_GET['room_id'].", ".$_GET['client_id'].", '".$_GET['date_out']."')";
    }
    
    $res_query = mysqli_query($connection, $query);
    
    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            null
        );
        exit($query);
    }
    
    echo ajax_echo(
        "Успех!",
        "Номер забронирован",
        false,
        "SUCCESS"
    );
    exit;
}

else if(preg_match_all("/^list_client$/ui", $_GET['type'])){
    $id = "";
    if(isset($_GET["client_id"])){
        $id = " AND `id` = ".$_GET["client_id"];
    }

    $query = "SELECT * FROM `clients` WHERE `is_deleted`=false ".$id;
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список клиентов выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}
else if(preg_match_all("/^list_employee$/ui", $_GET['type'])){
    $id = "";
    if(isset($_GET["employee_id"])){
        $id = " AND `id` = ".$_GET["employee_id"];
    }

    $query = "SELECT * FROM `employees` WHERE `deleted`=false ".$id;
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список сотрудников выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}
else if(preg_match_all("/^list_rooms$/ui", $_GET['type'])){
    $id = "";
    if(isset($_GET["room_id"])){
        $id = " AND `id` = ".$_GET["room_id"];
    }

    $query = "SELECT * FROM `rooms` WHERE `is_deleted`=false ".$id;
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список номеров выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}
else if(preg_match_all("/^list_schedule$/ui", $_GET['type'])){
    $date = "";
    if(isset($_GET["date"])){
        $date = " AND `day` = ".$_GET["date"];
    }

    $query = "SELECT * FROM `schedule` WHERE `deleted`=false ".$date;
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Расписание сотрудников выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}
else if(preg_match_all("/^list_busy_rooms$/ui", $_GET['type'])){
    $id = "";
    if(isset($_GET["room_id"])){
        $id = " AND `room_id` = ".$_GET["room_id"];
    }

    $query = "SELECT * FROM `busy_rooms` WHERE `is_deleted`=false ".$id;
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++){
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }
    echo ajax_echo(
        "Успех!", 
        "Список занятых номеров выведен",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

else if(preg_match_all("/^update_client$/ui", $_GET['type'])){
    if(!isset($_GET['client_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр client_id!",
            "ERROR",
            null
        );
        exit;
    }
    $name = '';
    if(isset($_GET['name'])){
        $name = "`name` = '".$_GET['name']."',";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `clients` SET ".$name." `is_deleted`=".$deleted." WHERE `id`=".$_GET['client_id'];
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "Клиент updated",
        false,
        "SUCCESS"
    );
    exit();
}
else if(preg_match_all("/^update_employee$/ui", $_GET['type'])){
    if(!isset($_GET['employee_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр employee_id!",
            "ERROR",
            null
        );
        exit;
    }
    $name = '';
    if(isset($_GET['name'])){
        $name = "`name` = '".$_GET['name']."',";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }
    $post = '';
    if(isset($_GET['post_id'])){
        $post = "`post_id` = ".$_GET['post_id'].",";
    }
    $salary = '';
    if(isset($_GET['salary'])){
        $salary = "`salary` = ".$_GET['salary'].",";
    }

    $query = "UPDATE `employees` SET ".$name.$post.$salary." `deleted`=".$deleted." WHERE `id`=".$_GET['employee_id'];
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "Сотрудник updated",
        false,
        "SUCCESS"
    );
    exit();
}
else if(preg_match_all("/^update_post$/ui", $_GET['type'])){
    if(!isset($_GET['post_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр post_id!",
            "ERROR",
            null
        );
        exit;
    }
    $name = '';
    if(isset($_GET['post_name'])){
        $name = "`post_name` = '".$_GET['post_name']."',";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `posts` SET ".$name." `deleted`=".$deleted." WHERE `id`=".$_GET['post_id'];
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "post updated",
        false,
        "SUCCESS"
    );
    exit();
}
else if(preg_match_all("/^update_room$/ui", $_GET['type'])){
    if(!isset($_GET['room_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр room_id!",
            "ERROR",
            null
        );
        exit;
    }
    $number = '';
    if(isset($_GET['number'])){
        $number = "`number` = ".$_GET['number'].",";
    }
    $room_count = '';
    if(isset($_GET['room_count'])){
        $room_count = "`room_count` = ".$_GET['room_count'].",";
    }
    $room_type_num = '';
    if(isset($_GET['room_type_num'])){
        $room_type_num = "`room_type_num` = ".$_GET['room_type_num'].",";
    }
    $price = '';
    if(isset($_GET['price'])){
        $price = "`price` = ".$_GET['price'].",";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `rooms` SET ".$number.$room_count.$room_type_num.$price." `is_deleted`=".$deleted." WHERE `id`=".$_GET['room_id'];
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "room updated",
        false,
        "SUCCESS"
    );
    exit();
}
else if(preg_match_all("/^update_schedule$/ui", $_GET['type'])){
    if(!isset($_GET['schedule_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр schedule_id!",
            "ERROR",
            null
        );
        exit;
    }
    $employee_id = '';
    if(isset($_GET['employee_id'])){
        $employee_id = "`employee_id` = ".$_GET['employee_id'].",";
    }
    $day = '';
    if(isset($_GET['day'])){
        $day = "`day` = ".$_GET['day'].",";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `schedule` SET ".$employee_id.$day." `deleted`=".$deleted." WHERE `id`=".$_GET['schedule_id'];
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "schedule updated",
        false,
        "SUCCESS"
    );
    exit();
}
else if(preg_match_all("/^update_busy_rooms$/ui", $_GET['type'])){
    if(!isset($_GET['busy_rooms_id'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали GET параметр busy_rooms_id!",
            "ERROR",
            null
        );
        exit;
    }
    $room_id = '';
    if(isset($_GET['room_id'])){
        $room_id = "`room_id` = ".$_GET['room_id'].",";
    }
    $client_id = '';
    if(isset($_GET['client_id'])){
        $client_id = "`client_id` = ".$_GET['client_id'].",";
    }
    $date_in = '';
    if(isset($_GET['date_in'])){
        $date_in = "`date_in` = ".$_GET['date_in'].",";
    }
    $date_out = '';
    if(isset($_GET['date_out'])){
        $date_out = "`date_out` = ".$_GET['date_out'].",";
    }
    $deleted = 'false';
    if(isset($_GET['deleted'])){
        $deleted = $_GET['deleted'];
    }

    $query = "UPDATE `busy_rooms` SET ".$room_id.$client_id.$date_in.$date_out." `is_deleted`=".$deleted." WHERE `id`=".$_GET['busy_rooms_id'];
    $res_query = mysqli_query($connection,$query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", 
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    echo ajax_echo(
        "Успех!", 
        "busy_rooms updated",
        false,
        "SUCCESS"
    );
    exit();
}