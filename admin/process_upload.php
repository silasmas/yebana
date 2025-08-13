<?php
include('../db.php');
$error_sub_form = null;

if (isset($_POST['video_title'],$_POST['video_description'],$_POST['video_position']) AND !empty($_POST['video_title']) AND !empty($_POST['video_description'])  ) {
    
    
    $video_title = htmlspecialchars($_POST['video_title']);
    $video_description = htmlspecialchars($_POST['video_description']);
    $video_position = htmlspecialchars($_POST['video_position']);
    $reference = uniqid();

    
    $verification = $db->prepare('SELECT * FROM `videos_educatives` WHERE (titre = ?) and (destination = ?)');
    $verification->execute(array($video_title,$video_position));
    
    $nbr_verification = $verification->rowCount();

    if ($nbr_verification === 0) {
        
        $reference = uniqid();

        
        $enregistrement_videos_educatives = $db->prepare('INSERT INTO `videos_educatives`( `titre`, `url`, `destination`, `description`, reference) VALUES ( ?, ?, ?, ?, ?)');
        
        if ($enregistrement_videos_educatives->execute(array($video_title,' ',$video_position,$video_description,$reference))) {
            
           header('location:televers_video.php?ref='.$reference);
            
        } else {
            echo 'error 500';
        }
        
    } else {
        header('location:upload_lecons.php?message=licence ou telephone déjà enregister déjà ');
    }

}
else {
    header('location:upload_lecons.php?message=veuillez remplir toutes les champs du formulaire ');
}