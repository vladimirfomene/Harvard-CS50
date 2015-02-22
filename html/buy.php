<?php

/***********************
*   @author vladimirfomene@gmail.com
*   Help users to buy stock
*
*
*
************************/
    
    //configuration
    require("../includes/config.php");
    
    //Get user's id 
    $id = $_SESSION["id"];
    
    //if form submitted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //lookup price for stock
        $_POST["symbol"] = strtoupper($_POST["symbol"]);
        $result = lookup($_POST["symbol"]);
        
        //sanity check for yahoo data
        if($result === "false")
            apologize("Could not connect to Yahoo");
            
        $price = $result["price"];
        
        //Sanity check on shares 
        if(!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("Enter a Whole number of shares");
        }
        
        $sharesValue = ($price * $_POST["shares"]);
        $balance = query("SELECT cash FROM users WHERE id = ?", $id);
        
        if($balance === false)
            apologize("Could not access database");
        
        //check whether user has enough cash
        if($balance < $sharesValue)
        {
            apologize("Not enough cash to buy stocks");
        }
        else
        {
            //buy shares
            if(query("INSERT INTO portfolio (id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $id, $_POST["symbol"], $_POST["shares"]) === false)
                apologize("Could not buy Stock");
            
            //Update user's balance
            if(query("UPDATE users SET cash = cash - ? WHERE id = ?", $sharesValue, $id) === false)
                apologize("Access to database failed");
        }
        
        //Record into transactions
        date_default_timezone_set('Africa/Accra');
        $date = date('d/m/Y, g:i A',time());
        
        if(query("INSERT INTO transactions (id, transactions, time, symbol, shares, price) VALUES(?, 'BUY', ?, ?, ?, ?)", $id, $date, $_POST["symbol"], $_POST["shares"], $price) === false)
        {
            apologize("Could not record transaction");
        }
        
        
        //redirect user to portfolio page
        redirect("/");
    }
    else
    {
        //Render form that allows users to buy stocks
        render("buy_stock.php", ["title" => "Buy"]);
    }


?>
