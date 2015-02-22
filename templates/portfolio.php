<div class = "nav" >
    <a href="logout.php" class="btn btn-primary">LOG OUT</a>
    <a href="quote.php" class="btn btn-primary">QUOTE</a>
    <a href="sell.php" class="btn btn-primary">SELL</a>
    <a href="buy.php" class="btn btn-primary">BUY</a>
    <a href="history.php" class="btn btn-primary">HISTORY</a>
</div>
<div class ="table container">
    <table class="table table-hover">
        <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>TOTAL</th>
        </tr>
    <?php foreach ($positions as $position) : ?>
        <tr>
            <td><?= $position["symbol"] ?></td>
            <td><?= $position["name"] ?></td>
            <td><?= $position["shares"] ?></td>
            <td><?= '$'.$position["price"] ?></td>
            <td><?= '$'.number_format(($position["shares"] * $position["price"]), 2, ".", ",") ?></td>
        </tr>
    <? endforeach ?>
        <tr>
            <td>CASH</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= '$'.number_format($balance, 2, ".",",") ?></td>
        </tr>
    </table>
</div>

