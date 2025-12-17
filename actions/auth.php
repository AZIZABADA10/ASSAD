    <?php
    session_start();
    require_once '../config/db.php';

    if (isset($_POST['connecter'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

       if ($user) {
        $is_valide = password_verify($password, $user['mot_de_passe']);
        if ($is_valide) {
            if ($user['statut_de_compet'] === 'active') {
                $_SESSION['user'] = $user;
                $user['role'];

                switch ($user['role']) {
                    case 'admin':
                        header('Location: ../pages/admin/dashboard.php');
                        break;
                    case 'visiteur':
                        header('Location: ../pages/visitor/dashboard.php');
                        break;
                    case 'guide':
                        header('Location: ../pages/guide/dashboard.php');
                        break;
                    default:
                        header('Location: ../pages/public/login.php');
                        break;
                }
                exit();
            }elseif ($user['statut_de_compet'] === 'en_attente') {
                $_SESSION['attend_activation'] = "Votre compte est en attente d'activation par l'administrateur.";
            }elseif($user['statut_de_compet'] === 'blocked'){
                $_SESSION['login_error'] = "Ce compte a été bloqué par l'administration.";
            }
        }else {
            $_SESSION['login_error'] = "Mot de passe incorrect.";
        }
       }else {
        $_SESSION['login_error'] = "Aucun compte avec ce email.";
        }
    $_SESSION['form_active'] = 'login-form';
    header('Location: ../pages/public/login.php');
    exit();

    }



    if (isset($_POST['inscrire'])) {
        $erreurs = [];
        $nom= $_POST['nom'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $role= $_POST['role'];


        $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";
        
        if (!preg_match($pattern_email,$email))
        {
            $erreurs['email_error'] = "L'adresse email n'est pas valide (format attendu: nom@exemple.com).";
        }
        if (strlen($password) < 6) 
        {
            $erreurs['password_error'] = "Le mot de passe doit faire au moins 6 caractères.";
        }

        $email_exist = $connexion -> prepare("SELECT * FROM utilisateurs where email = ?");
        $email_exist -> bind_param('s',$email);
        $email_exist -> execute();
        if ($email_exist->get_result()->num_rows > 0) {
            $erreurs['email_existe']='Email et déja existe';
        }


        if (empty($erreurs)) {
            $password_hache = password_hash($password,PASSWORD_DEFAULT);
            $stmt = $connexion -> prepare("INSERT INTO utilisateurs (nom_complet,mot_de_passe,email,`role`,statut_de_compet)
            VALUES (?,?,?,?,?)");
            $statut_de_compet = 'active';
            if ( $role === 'guide') {
                $statut_de_compet = 'en_attente';
 
            }
            $stmt -> bind_param('sssss',$nom,$password_hache,$email,$role,$statut_de_compet);
                $stmt->execute();
                $_SESSION['success'] = "Inscription réussie ! Connectez-vous.";
                $_SESSION['form_active'] = 'login-form'; 
                header('Location: ../pages/public/login.php');
                exit();
        }else{
            $_SESSION['register_errors'] = $erreurs;
            $_SESSION['form_active'] = 's-inscrire-form';
            header('Location: ../pages/public/login.php');
            exit();
        }

    }