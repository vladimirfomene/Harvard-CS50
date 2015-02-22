<?php

    // configuration
    require("../includes/config.php"); 

    //Get current user id
    $id = $_SESSION["id"];
    
    //Query database
    $rows = query("SELECT symbol, shares FROM portfolio WHERE id = ?", $id);
    
    //arrange user portfolio in positions array
    $positions = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if( $stock !== false)
        {
            $positions[] = [
            "name" => $stock["name"],
            "price" => $stock["price"],
            "shares" => $row["shares"],
            "symbol" => $row["symbol"]
            ];
        }
    
    }
    
    //Get user's cash balance
    $balances = query("SELECT cash FROM users WHERE id = ?",$id);
    $balance = $balances[0]["cash"];
    
    // render portfolio
    render("portfolio.php", ["title" => "Portfolio", "positions" => $positions, "balance" => $balance]);
    
    
?>
