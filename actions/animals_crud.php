<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'],$_POST['habitat'],$_POST['type_alimentaire'])) {
    
    $nom = $_POST['nom'];
    $type_alimentaire = $_POST['type_alimentaire'];
    $habitat = $_POST['habitat'];

    $imageName = null;
    if (!empty($_FILES['image']['tmp_name'])) {
        $ext =pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION)  ; 
        $imageName =uniqid() . '.'. $ext ;
        move_uploaded_file($_FILES['image']['tmp_name'],'uploads/'.$imageName );
    } 

    $requet_sql = "INSERT INTO animal (nom,type_alimentaire,image_animal,id_habitat) VALUES 
    ('$nom','$type_alimentaire','$imageName',$habitat)"; 

        $connexion ->query($requet_sql);
        header("Location: index.php");
        exit();

}


?>