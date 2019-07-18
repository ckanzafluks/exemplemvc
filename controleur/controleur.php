<?php



/**
*
*
*/
function displayHomePage($twig){
    
    //$article = new ManagerArticle();
    
    //$data = $article->getLastarticle();
    
    $data = array();

    echo $twig->render('home.twig',array('data'=>$data)); // WPCS: XSS OK
    
}

function callInscription($twig)
{   
       
    $nom = $_SESSION['Nom'] ?? 'Null';
    
    if ($nom != 'Null') {
        
        callHome($twig);
        
    } 
        echo $twig->render('inscription.twig'); // WPCS: XSS OK
    
}

function callConnect($twig)
{
    $nom =$_SESSION['Nom'] ?? 'Null';
    
    if ($nom != 'Null') {
        callHome($twig);
    } else {
        echo $twig->render('connection.twig');  // WPCS: XSS OK
    }
}

///////////////////////////////////////////////////////////////////////////////

function addarticle($namearticle, $categorie, $content, $chapo, $auteur, $twig)
{   
    $error = checkformArticle($namearticle, $content, $chapo, $auteur, $categorie);
   
    if ($error['namearticle']== 1 or $error['content']== 1 or $error['auteur']==1 or $error['chapo']==1){
        
        echo $twig->render('newArticle.twig', array('data'=>$error)); // WPCS: XSS OK
        
    }else{
    
    $user_iduser= $_SESSION['Id'];
    
        $data = [
            'NameArticle' =>$namearticle,
            'categorie' => $categorie,
            'Content' => $content,
            'user_iduser'=> $user_iduser,
            'chapo'=> $chapo,
            'Auteur'=> $auteur,
            
        ];

        $article = new Article($data);
        
        $idarticle ='0';
        
        
        
        $CheckFile = $article->checkDirphoto($_FILES,$idarticle);
        

        
        $manager = new ManagerArticle();

        $manager->addArticle($article);
        
        header('Location: index.php?action=article');
        
    }
    }


function getListArticle($twig)
{
    $listeArticle = new ManagerArticle();
    
    $data= $listeArticle->getListArticle();
        
    
// die(var_dump($data));
    
    
    echo   $twig->render('article.twig', array('data' =>$data));  // WPCS: XSS OK
}

function viewArticle($twig, $idarticle)
{
    $dataArticle = new ManagerArticle();
    
    $data=$dataArticle->get($idarticle);
    
    $commentaire = new ManagerCommentaire();
    
    $q = $commentaire->getListCommentaireByArticle($idarticle);
    
    
    
    echo $twig->render('viewarticle.twig', 
            array('data'=>$data,   // WPCS: XSS OK                 
            'commentaire'=>$q       // WPCS: XSS OK     
            ));
}

function dropArticle($idarticle, $redirection)
{
    $drop = new ManagerArticle();
    $requete = $drop->delete($idarticle);

    if ($redirection=='adminpost') {
        header('Location: index.php?action=listingPost');
        
    } else {
        header('Location: index.php?action=article');    
        
    }
}

function updateArticle($namearticle, $categorie, $content, $chapo, $auteur, $idarticle)
{
    $user_iduser= $_SESSION['Id'];
    $date = (date('Y-m-d'));

    $data = [
        'NameArticle' =>$namearticle,
        'Categorie' => $categorie,
        'Content' => $content,
        'user_iduser'=> $user_iduser,
        'chapo'=> $chapo,
        'Auteur'=> $auteur,
        'idArticle'=>$idarticle,
        'dateModificationArticle'=> $date
    ];
    
    
    
    $article = new Article($data);
    
    $article->checkDirphoto($_FILE,$idarticle);
    
    $uparticle= new ManagerArticle();
    
    
    $uparticle->update($article);
    
    header('Location: index.php?action=article');
}

function viewModifyArticle($twig, $id)
{
    $dataArticle = new ManagerArticle();
    
    $data=$dataArticle->get($id);
    

    
    
    
    echo $twig->render('modifyArticle.twig', array('data'=>$data));   // WPCS: XSS OK
}

function addinscription($name, $surename, $pseudo, $mail, $mdp, $twig)
{   
    $data = [
      'NameUser' => $name,
      'SurenameUser' => $surename,
      'Pseudo' => $pseudo,
      'EmailUser' => $mail,
      'MdpUser' => $mdp,
    ];
    
    $error = checkformaddinscription($name, $surename, $pseudo, $mail);
    
    

    if($error['name']== 1 or $error['surename']== 1 or $error['pseudo']== 1 or $error['mail']== 1 or $error['existmail']== 1 or $error['existpseudo']==1){
        
        echo $twig->render('inscription.twig',array('data'=>$error));
        
    }else{
    
    $inscription = new User($data);
        
  
    $addinscription = new ManagerUser();
    $requete=$addinscription->add($inscription);
    
    require './templates/mailnewuser.php';
    
    
    if($requete){
        
    
    mailcontact($contenu, $mail);
    
    header('Location:index.php?action=home');
    
    }else{
        
        echo 'error ajout inscription';
    }
    
    }
}

function login($email, $mdp, $twig)
{
    
    $error = checkfromlogin($email, $mdp);
    
    if ($error['mdp'] == 1 or $error['mdp'] == 1){
        
        echo $twig->render('connection.twig', array('data'=> $error));  // WPCS: XSS OK

    }
    
  
    
    $requete = new ManagerUser();
    
    $requete->checklogin($email, $mdp);

    header('Location:index.php?action=home');

    exit();
}
    


function addcommentaire($commentaire, $idarticle)
{
    $date = date('d-m-Y H:m');
    $user = $_SESSION['Id'];
    
    $data=[
        'ContentCommentaire' => $commentaire,
        'ArticleidArticle' => $idarticle,
        'CreateDate' => $date,
        'Useriduser' => $user
    ];
    
    $commentaires = new Commentaire($data);

    
    $requete = new ManagerCommentaire();
    
    $requete->add($commentaires);
    
    header('location: ./index.php?action=viewarticle&idarticle='.$idarticle);

    exit();
}

function destroy()
{
    session_destroy();
    
    header('Location:index.php?action=home');

    exit();
}

function validationCommentaire($idCommentaire, $idarticle, $redirection)
{
    $requete= new ManagerCommentaire();
    
    $requete->validationCommentaire($idCommentaire);
    
        if ($redirection === 'listingcom'){
        
        header('location: ./index.php?action=listingCom');
    
        
    } else {
        
        header('location: ./index.php?action=viewarticle&idarticle='.$idarticle);

    }
    
}

function deleteCommentaire($idCommentaire, $idarticle, $redirection)
{
    $drop = new ManagerCommentaire();
    
    $drop->delete($idCommentaire);
    
    
    
    if ($redirection === 'listingcom'){
        
    header('location: ./index.php?action=listingCom');
    
        
    }else{
    
    header('location: ./index.php?action=viewarticle&idarticle='.$idarticle);
}

}

function modifyCommentaire($twig, $idCommentaire, $idarticle)
{
    $requete = new ManagerCommentaire();
    
    $modifcommentaire = $requete->get($idCommentaire);
    
     
    $dataArticle = new ManagerArticle();
    
    $data=$dataArticle->get($idarticle);
    
    $commentaire = new ManagerCommentaire();
    
    $q = $commentaire->getListCommentaireByArticle($idarticle);
    
    
       
    echo $twig->render('viewarticleModifyCommentaire.twig', array(  // WPCS: XSS OK
        'data'=>$data,
        'commentaire'=>$q,
        'modifCommentaire'=>$modifcommentaire
    ));
}


function updateCommentaire($commentaire, $idCommentaire, $idarticle)
{
    $data = new ManagerCommentaire;
    
    $data->updateCommentaire($commentaire, $idCommentaire);
    
    header('location: ./index.php?action=viewarticle&idarticle='.$idarticle);
}

function checkfromlogin($mail, $mdp)
{   
    
    
    if($mail){
        $error ['mail'] = 0;
    }else{
        $error ['mail'] = 1;
    }
    
    if($mdp){
        $error ['mdp'] = 0;
    }else{
        $error ['mdp'] = 1;
    }
    
    
    
    return $error;
}

function checkformaddinscription ($name, $surename, $pseudo, $mail){
    
    
    if (empty($name)){
        
        $error['name'] = 1;
    }else{
        
        $error['name'] = 0;
    }
    
    if (empty($surename)){
        
        $error['surename'] = 1;
    }else{
        
        $error['surename'] = 0;
    }
    
    if (empty($pseudo)){
        
        $error['pseudo'] = 1;
    }else{
        
        $error['pseudo'] = 0;
    }
    
    if (empty($mail)){
        
        $error['mail'] = 1;
    }else{
        
        $error['mail'] = 0;
    }
    
    $checkexistmail = new ManagerUser(); 
    $error['existmail'] = $checkexistmail->checkemailexist($mail); 
    
    $checkpseudoexist = new ManagerUser();
    
    $error['existpseudo']= $checkpseudoexist->checkpseudolexist($pseudo);
    

    return $error;
    
}

function checkformArticle($namearticle, $content, $chapo, $auteur, $categorie){
    
    
    if(empty($namearticle)){
        $error ['namearticle'] = 1; 
    }else{
        $error ['namearticle'] = 0;
    }

    if(empty($content)){
        $error ['content'] = 1;
    }else{
        $error ['content'] = 0;
    }

    if(empty($chapo)){
        $error ['chapo'] = 1;
    }else{
        $error ['chapo'] = 0;
    }
    
    if(empty($auteur)){
        $error ['auteur'] = 1;
    }else{
        $error ['auteur'] = 0;
    }
    
        if(empty($categorie)){
        $error ['categorie'] = 1;
    }else{
        $error ['categorie'] = 0;
    }
    
    return $error;
}
