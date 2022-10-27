<?php
header("Content-Type: application/json");
$httpMethod = $_SERVER['REQUEST_METHOD'];  //GET-POST-PUT-DELETE
$action = $_GET['accion'];
$id = $_GET['id'];
switch ($httpMethod) {
    case 'GET':
        if ($action == "clothes") {   // solo se ejecuta cuando la URL = localhost/REST/personal -GET
            try {
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=shop;charset=utf8",
                    "root",
                    ""
                );
            } catch(PDOException $e){
                echo $e->getMessage();
            }
            $pstm = $conexion->prepare('SELECT * FROM clothes');
            $pstm->execute();
            $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rs, JSON_PRETTY_PRINT);

        }elseif($action == "clothes") {   // solo se ejecuta cuando la URL = localhost/REST/personal -GET
            try {
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=shop;charset=utf8",
                    "root",
                    ""
                );
            } catch(PDOException $e){
                echo $e->getMessage();
            }
            if ($id == "id") {
                $pstm = $conexion->prepare('SELECT * FROM shop.clothes where id= 3;');
            $pstm->execute();
            $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rs, JSON_PRETTY_PRINT);

            }else{

            }
            
        }elseif ($action == "clothe_types") {
           try {
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=shop;charset=utf8",
                    "root",
                    ""
                );
            } catch(PDOException $e){
                echo $e->getMessage();
            }
            $pstm = $conexion->prepare('SELECT * FROM clothe_types');
            $pstm->execute();
            $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rs, JSON_PRETTY_PRINT);
        }
        elseif ($action == "categories") {
            try {
                 $conexion = new PDO(
                     "mysql:host=localhost;dbname=shop;charset=utf8",
                     "root",
                     ""
                 );
             } catch(PDOException $e){
                 echo $e->getMessage();
             }
             $pstm = $conexion->prepare('SELECT * FROM  categories');
             $pstm->execute();
             $rs = $pstm->fetchAll(PDO::FETCH_ASSOC);
             echo json_encode($rs, JSON_PRETTY_PRINT);
         }else {
            echo "don´t exists a correct action";
          }
        break;

        case 'POST':
        if ($action == "clothes") {  // URL= localhost/REST/personal  -POST
            $jsonData = json_decode(file_get_contents("php://input"));  //esto obtiene el BODY del request 
            try {
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=shop;charset=utf8",
                    "root",
                    ""
                );
            } catch(PDOException $e){
                echo $e->getMessage();
            }
            
           try{
            $pstm = $conexion->prepare('INSERT INTO `clothes` (`name`, `price`, `size`, `brand`, `stock`, `cloth_type`, `created_at`, `status`, `category_id`, `clothe_type_id`) VALUES (:a, :b, :c, :d, :e, :f, :g, :h, :i, :j);');
            $pstm->bindParam(":a",$jsonData->name);
            $pstm->bindParam(":b",$jsonData->price);
            $pstm->bindParam(":c",$jsonData->size);
            $pstm->bindParam(":d",$jsonData->brand);
            $pstm->bindParam(":e",$jsonData->stock);
            $pstm->bindParam(":f",$jsonData->cloth_type);
            $pstm->bindParam(":g",$jsonData->created_at);//yyyy-MM-DD
            $pstm->bindParam(":h",$jsonData->status);
            $pstm->bindParam(":i",$jsonData->category_id);
            $pstm->bindParam(":j",$jsonData->clothe_type_id);


            $rs = $pstm->execute();  //execute nos retorna un 1: se registró o 0 : no se registró
            if ($rs) {
                $_POST['error'] = false;
                $_POST['status'] = 200;
                $_POST['data'] = json_encode($jsonData);

            }else{
                $_POST['error'] = true;
                $_POST['status'] = 400;
                $_POST['data'] = null;
            }
            echo json_encode($_POST);

           }catch(Exception $e){
            echo $e->getMessage();
           }
        }
        case 'PUT':
            if ($action == "personal") {  // URL= localhost/REST/personal  -POST
                $jsonData = json_decode(file_get_contents("php://input"));  //esto obtiene el BODY del request 
                try {
                    $conexion = new PDO(
                        "mysql:host=localhost;dbname=utez;charset=utf8",
                        "root",
                        ""
                    );
                } catch(PDOException $e){
                    echo $e->getMessage();
                }
                //UPDATE `shop`.`clothes` SET `brand` = 'gfdfgfgfv' WHERE (`id` = '3');
                //UPDATE `shop`.`clothes` SET `name` = :a, `price` = :b, `size` = :c,`brand` = :d, `stock` = :e, `cloth_type` = :f, `created_at` = :g, `status` = :h, `category_id` = :i, `clothe_type_id` = :j WHERE (`id` = ?);

                $pstm = $conexion->prepare('UPDATE `shop`.`clothes` SET `name` = :a, `price` = :b, `size` = :c,`brand` = :d, `stock` = :e, `cloth_type` = :f, `created_at` = :g, `status` = :h, `category_id` = :i, `clothe_type_id` = :j WHERE (`id` = ?);');
                $pstm->bindParam(":a",$jsonData->name);
                $pstm->bindParam(":b",$jsonData->price);
                $pstm->bindParam(":c",$jsonData->size);
                $pstm->bindParam(":d",$jsonData->brand);
                $pstm->bindParam(":e",$jsonData->stock);
                $pstm->bindParam(":f",$jsonData->cloth_type);
                $pstm->bindParam(":g",$jsonData->created_at);//yyyy-MM-DD
                $pstm->bindParam(":h",$jsonData->status);
                $pstm->bindParam(":i",$jsonData->category_id);
                $pstm->bindParam(":j",$jsonData->clothe_type_id);
    
    
                $rs = $pstm->execute();  //execute nos retorna un 1: se registró o 0 : no se registró
                if ($rs) {
                    $_POST['error'] = false;
                    $_POST['status'] = 200;
                    $_POST['data'] = json_encode($jsonData);
    
                }else{
                    $_POST['error'] = true;
                    $_POST['status'] = 400;
                    $_POST['data'] = null;
                }
                echo json_encode($_POST);
    
            }
        
            break;

    default:
        echo "ERROR";
        break;
}
