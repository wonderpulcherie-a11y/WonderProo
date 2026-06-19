<?php

class DeconnexionController
{
    public function logout()
    {
        session_start();

        session_destroy();

        header(
            "Location: Views/Auth/connexion.php"
        );

        exit;
    }
    
}