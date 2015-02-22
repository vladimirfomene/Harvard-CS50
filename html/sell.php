<?php

/********************
*   Sell.php
*   Allows users to sell stocks
*   @author vladimirfomene@gmail.com
*
*********************/
    //configuration
    require("../includes/config.php");
    
    //if form submittted
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
    
        //Get user id
        $id = $_SESSION["id"];
        
        //Get Price of stock symbol
        $result = lookup($_POST["symbol"]);
        $price = $result["price"];
        $symbol = strtoupper($_POST["symbol"]);
        
        //Get Shares owned by user
        $row = query("SELECT shares FROM portfolio WHERE symbol = ? AND id = ?", $symbol, $id);
        
        //sanity check on result
        if($row === false)
        {
            apologize("Access to Database failed");
            exit;
        }
        
        if($row == false)
        {
            apologize("You don't own a share of this company");
            exit;
        }
        
        $shares = $row[0]["shares"];
        
        //Compute user cash
        $cash = ($price * $shares);
        
        //Delete stock using query
        if(query("DELETE FROM portfolio WHERE id = ? AND symbol = ?", $id, $symbol ) === false)
        {
            //call apologize and pass a message
            apologize("Could not sell your Stock");
            exit;
        }
        
        //Update users cash balance
        if(query("UPDATE users SET cash = cash + ? WHERE id = ?", $cash, $id) === false)
        {
            apologize("Access to database failed");   
            exit; 
        }
        
        date_default_timezone_set('Africa/Accra');
        $date = date('d/m/Y, g:i A',time());
        
        if(query("INSERT INTO transactions (id, transactions, time, symbol, shares, price) VALUES(?, 'SELL', ?, ?, ?, ?)", $id, $date, $symbol, $shares, $price) === false)
        {
            apologize("Could not record transaction");
        }
        
        //Redirect user to portfolio 
        redirect("/");
    }
    else
    {
        //Display sales form
        render("sell_stock.php",["title" => "Sell"]);
    }


?>
