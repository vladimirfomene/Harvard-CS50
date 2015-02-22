<div class ="table container">
    <table class="table table-hover">
        <tr>
            <th>Transaction</th>
            <th>Date/Time</th>
            <th>Symbol</th>
            <th>Shares</th>
            <th>Price</th>
        </tr>
    <?php foreach ($transactions as $transaction) : ?>
        <tr>
            <td><?= $transaction["transactions"] ?></td>
            <td><?= $transaction["time"] ?></td>
            <td><?= $transaction["symbol"] ?></td>
            <td><?= $transaction["shares"] ?></td>
            <td><?= '$'.($transaction["price"]) ?></td>
        </tr>
    <? endforeach ?>
    </table>
</div>
