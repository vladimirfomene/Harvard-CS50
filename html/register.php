<?php 

    /********************
    * Registers New Users
    *
    * vladimir fomene
    * vladimirfomene@gmail.com
    ********************/

    //configuration
    require("../includes/config.php");
    
    //if form was submitted 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //validate input
        if(empty($_POST["username"]) || empty($_POST["password"]))
        {
            apologize("Enter a Username or Password");
        }
        elseif($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Password don't Match");
        }
         
        //Insert new record into database
        $result = query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"]));
        
        //check whether insertion succeeded
        if($result === false)
        {
            apologize('Unable to create Account. User'." ". $_POST["username"]." ". 'already exists');  
        }
        else
        {
            //Get the last inserted ID
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            
            //remember that user is login 
            $_SESSION["id"] = $id;
            
            //redirect user to portfolio
            redirect("/");
            
        }
    }
    else
    {
        //else render form
        render("register_form.php",["title" => "Register"]);
    }


?>
