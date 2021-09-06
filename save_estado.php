<?PHP 

//include("../db.php");


IF (isset($_POST['save'])){
    $estado =$_POST['estado'];
    //echo $estado;

    //$query ="INSERT INTO cotizadorart.estado ( est_estado) VALUES ('$estado');";

    //$result = mysqli_query($conn,$query);

/*    
    If(!$result) {
        $_SESSION['message']= 'Error Guardando Estado';
        $_SESSION['message_type']= 'warning';

    }else{
        $_SESSION['message']= 'Guardado Satisfactoriamente';
        $_SESSION['message_type']= 'success';
    }
*/
    $_SESSION['message']= "Guardado Satisfactoriamente";
    $_SESSION['message_type']= "success";

    header("Location: ../estado.php");

}
?>
