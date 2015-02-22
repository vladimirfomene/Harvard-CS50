<?php
/********************
* 
*   Display history of trading transactions
*
* @author vladimirfomene@gmail.com
*********************/

    // configuration
    require("../includes/config.php"); 

    
    $transactions = [];
    
    $records = query("SELECT transactions, time, symbol, shares, price FROM transactions");
    
    if($records === false)
    {
    
        apologize("Could not connect Database");
    }
    
    foreach($records as $record)
    {
        $transactions[] = [
            "transactions" => $record["transactions"],
            "time" => $record["time"],
            "symbol" => $record["symbol"],
            "shares" => $record["shares"],
            "price" => $record["price"]
        ];
    }
    
    //Renders history of records
    render("display_history.php", ["title" => "history", "transactions" => $transactions]);
?>
