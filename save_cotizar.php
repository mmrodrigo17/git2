<?PHP 
include("../db.php");
IF (isset($_POST['save_cotizar'])){
    $CUIT =$_POST['CUIT'];
    $RSocial =$_POST['RazonSocial'];
    $CIIU =$_POST['CIIU'];
    $Actividad =$_POST['Actividad'];
    $Gestor =$_POST['inputGestor'];
    $Especialista =$_POST['inputEspecialista'];
    $Capita =$_POST['inputCapita'];
    $MSalaria =$_POST['inputMSalaria'];
    $AVigente =$_POST['inputAVigente'];
    $FRM931 =$_POST['inputFRM931'];
    $VFRM931 =$_POST['inputVFRM931'];
    $LTR =$_POST['inputLTR'];
    $Sector =$_POST['inputSector'];
    $Localidad =$_POST['localidad'];
    $Provincia =$_POST['Provincia'];
    $Prestadormedico = $_POST['PrestadorMedico'];
    $Compania =$_POST['inputCompania'];
    //$Fecha =date('Y-m-d') ;
    $Fecha = date("Y-m-d H:i:s");     
//control de cuit existente   
    $control='SELECT fn_ExisteCuit('.$CUIT.') as ExisteCuit ;';
    $result_select1 = mysqli_query($conn,$control);    
    $row1 = mysqli_fetch_assoc($result_select1);
    if ($row1["ExisteCuit"] == 0 ){
        //inserto cabecera
        $query ="INSERT INTO cotizadorart.cotizar (cot_id,cot_fecha,cot_riesgo,cot_cuit,cot_rsocial,cot_actividad,ges_id,esp_id,cot_ciiu,cot_capita,cot_msalarial,cot_alicvigente,cot_frm931,cot_vig931,cot_lrt, ";
        $query .= "cot_sectorprivado,cot_localidad,cot_provincia,cot_prestadormedico,com_id,est_id,cot_fechaestado)VALUES ";    
        $query .= "(0,'$Fecha','ART','$CUIT','$RSocial','$Actividad','$Gestor','$Especialista','$CIIU',$Capita,$MSalaria,$AVigente,$FRM931,'$VFRM931',$LTR,'$Sector','$Localidad','$Provincia', ";
        $query .= "$Prestadormedico,$Compania,'1','$Fecha') ";
        if (!mysqli_query($conn,$query)) {
            echo("Error description: " . mysqli_error($conn));
        }
        $query ="SELECT Max(cot_id) Max FROM cotizadorart.cotizar";
        $result_select = mysqli_query($conn, $query);    
        $row = mysqli_fetch_array($result_select);
        $Max_Id = $row['Max'];
        $query ="SELECT com_id FROM cotizadorart.compania where com_cotiza = 1 and com_estado=1 ";
        $result_select = mysqli_query($conn, $query);    
    //inserto detalle de cotizaciones
        while($row = mysqli_fetch_array($result_select)){ 
            if($row['com_id'] <> $Compania ) {      
                $Compania_II = $row['com_id'];
                $query = "INSERT INTO cotizadorart.det_cotizar (detc_id,cot_id,com_id,detc_alicuota,det_nrosolicitud,est_id,det_observaciones,det_fechaestado)VALUES (0,";
                $query .= "$Max_Id,'$Compania_II',0,0,1,'','$Fecha');";
                if (!mysqli_query($conn,$query)) {
                    $_SESSION['message']= 'Error Guardando Datos';
                    $_SESSION['message_type']= 'danger';
                }else {
                    $_SESSION['message']= 'Guardado Satisfactoriamente. CUIT: ' .$CUIT;
                    $_SESSION['message_type']= "success";
                }
            }
        }
    } 
    else 
        {
            $_SESSION['message']= 'Error - El CUIT: '.$CUIT.' fue cargado con anterioridad.';
            $_SESSION['message_type']= 'danger';
        }
    //mysqli_free_result($result_select);
header("Location: ../cotizarII.php");
}
?>