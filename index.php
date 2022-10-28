<?php  
header('Content-Type: application/json');
$metodo = $_SERVER['REQUEST_METHOD'];
switch($metodo){
    case 'GET':
        if($_GET['accion'] == 'kof'){
            try{
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=kof;charset=utf8","root","");
            }catch(PDOException $e){
                echo $e-> getMessage();
            }

            if(isset($_GET['id'])){
                $pstm = $conexion -> prepare('SELECT p.*,m.magiaespecial,lu.nombre_lucha FROM person p JOIN  tipo_magia m ON p.magia=m.id JOIN tipo_lucha lu ON  p.tipolucha=lu.id WHERE p.id=:n;');
                $pstm->bindParam(':n', $_GET['id']);
                $pstm -> execute();
                $rs = $pstm -> fetchAll(PDO::FETCH_ASSOC);
                if($rs != null){
                    echo json_encode($rs[0],JSON_PRETTY_PRINT);
                }else{
                    echo "No se encontro la base :(";
                }
            }else{
                //$pstm = $conexion -> prepare('SELECT p.*,m.magiaespecial,lu.nombre_lucha FROM person p INNER JOIN tipo_magia m,tipo_lucha lu ON p.magia=m.id  p.tipolucha=lu.id;');
                $pstm = $conexion -> prepare('SELECT * FROM person');
                // $pstm = $conexion -> prepare('SELECT p.*,m.magiaespecial,lu.nombre_lucha FROM person p INNER JOIN tipo_magia m,tipo_lucha lu ON p.magia=m.id AND p.tipolucha=lu.id;');
                // $pstm = $conexion -> prepare('SELECT p.*,lu.nombre_lucha FROM person p INNER JOIN tipo_lucha lu ON p.tipolucha=lu.id;');
                
                $pstm -> execute();
                $rs = $pstm -> fetchAll(PDO::FETCH_ASSOC);
                if($rs != null){
                    echo json_encode($rs,JSON_PRETTY_PRINT);
                }else{
                    echo "No se encontro la base :(";
                }
            }


        }

        if($_GET['accion'] == 'lucha'){
            try{
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=kof;charset=utf8","root","");
            }catch(PDOException $e){
                echo $e-> getMessage();
            }

            if(isset($_GET['id'])){
                $pstm = $conexion -> prepare('SELECT * FROM tipo_lucha WHERE id=:n');
                $pstm->bindParam(':n', $_GET['id']);
                $pstm -> execute();
                $rs = $pstm -> fetchAll(PDO::FETCH_ASSOC);
                if($rs != null){
                    echo json_encode($rs[0],JSON_PRETTY_PRINT);
                }else{
                    echo "No se encontro la base :(";
                }
            }else{
                $pstm = $conexion -> prepare('SELECT * FROM tipo_lucha');
                $pstm -> execute();
                $rs = $pstm -> fetchAll(PDO::FETCH_ASSOC);
                if($rs != null){
                    echo json_encode($rs,JSON_PRETTY_PRINT);
                }else{
                    echo "No se encontro la base :(";
                }
            }

        }

        if($_GET['accion'] == 'magia'){
            try{
                $conexion = new PDO(
                    "mysql:host=localhost;dbname=kof;charset=utf8","root","");
            }catch(PDOException $e){
                echo $e-> getMessage();
            }

            if(isset($_GET['id'])){
                $pstm = $conexion -> prepare('SELECT * FROM tipo_magia WHERE id=:n');
                $pstm->bindParam(':n', $_GET['id']);
                $pstm -> execute();
                $rs = $pstm -> fetchAll(PDO::FETCH_ASSOC);
                if($rs != null){
                    echo json_encode($rs[0],JSON_PRETTY_PRINT);
                }else{
                    echo "No se encontro la base :(";
                }
            }else{
                $pstm = $conexion -> prepare('SELECT * FROM tipo_magia');
                $pstm -> execute();
                $rs = $pstm -> fetchAll(PDO::FETCH_ASSOC);
                if($rs != null){
                    echo json_encode($rs,JSON_PRETTY_PRINT);
                }else{
                    echo "No se encontro la base :(";
                }
            }

        }
        break;
    case 'POST':
        if ($_GET['accion'] == 'kof') {
            $jsonData = json_decode(file_get_contents("php://input"));
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $query = $conn->prepare ("INSERT INTO `person`(`nombre`,`apellido`,`tipolucha`,`magia`,`estatura`,`peso`,`equipo`) 
            VALUES(:nombre,:apellido,:tipolucha,:magia,:estatura,:peso,:equipo);");
            $query -> bindParam(":nombre",$jsonData->nombre);
            $query -> bindParam(":apellido",$jsonData->apellido);
            $query -> bindParam(":tipolucha",$jsonData->tipolucha);
            $query -> bindParam(":magia",$jsonData->magia);
            $query -> bindParam(":estatura",$jsonData->estatura);
            $query -> bindParam(":peso",$jsonData->peso);
            $query -> bindParam(":equipo",$jsonData->equipo);
            $result = $query->execute();

            if($result){
                echo("Exito en registrar .Code $result");
            }else{
                echo ("Error al registrar .Code $result");
                echo json_encode($jsonData);
            }


        }


        break;
    case 'PUT':
        if ($_GET['accion'] == 'kof') {
            $jsonData = json_decode(file_get_contents("php://input"));
            try {
                $conn = new PDO("mysql:host=localhost;dbname=kof;charset=utf8", "root", "");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $query = $conn->prepare ("UPDATE `person`SET `nombre`= :nombre,`apellido` = :apellido,`tipolucha` = :tipolucha,`magia` = :magia,`estatura` = :estatura,`peso`= :peso ,`equipo`= :equipo WHERE `id` = :id;");
            $query -> bindParam(":nombre",$jsonData->nombre);
            $query -> bindParam(":apellido",$jsonData->apellido);
            $query -> bindParam(":tipolucha",$jsonData->tipolucha);
            $query -> bindParam(":magia",$jsonData->magia);
            $query -> bindParam(":estatura",$jsonData->estatura);
            $query -> bindParam(":peso",$jsonData->peso);
            $query -> bindParam(":equipo",$jsonData->equipo);
            $query -> bindParam(":id",$jsonData->id);
            $result = $query->execute();
            if($result){
                echo("Exito en Actulizar .Code $result");
            }else{
                echo ("Error al Actualizar .Code $result");
                echo json_encode($jsonData);
            }
        }
        break;
        default:
        echo "Método no soportado.";
        break;
}


?>