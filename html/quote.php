c<?php

 /*******************
 *  vladimir fomene
 *  vladimirfomene@gmail.com
 *
 *  Help users search for stocks prices
 *  using stock symbols.
 ********************/
 
      //configuration
    require("../includes/config.php");
    
    //if form was submitted 
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //validate form input
        if(empty($_POST["symbol"]))
        {
            apologize("Enter a Stock Symbol or Quote");
        }
        else if(!(is_string($_POST["symbol"])))
        {
            apologize("Enter a valid Stock symbol");
        }
        
        //Get stock price from Yahoo
        $stock = lookup($_POST["symbol"]);
        
        //sanity check for yahoo data
        if($stock === false)
            apologize("Enter correct Stock symbol");
        
        //reformat the price
        $price = number_format($stock["price"], $decimals = 2 , $dec_point = "." , $thousands_sep = ",");
        
        //render the price 
        render("stock_price.php", ['title' => 'Quote','price' => $price, 'symbol' => $stock["symbol"], 'name' => $stock["name"]]);
        
        exit;
    }
    else
    {
        //else render form
        render("quote_form.php",["title" => "Get Quote"]);
    }


?>
