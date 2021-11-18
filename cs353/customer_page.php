<?php
include "config.php"; 
include 'session.php';
$statement = 'select cname, cid, wallet from customer where cid=' .'\'' .$current_user_id. '\'';
$resultedQuery = $conn->query($statement);
$currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM);
echo '<div ><h2>'.$currentTuple[0].'</h2><h3>Now you have:' .$currentTuple[2]. '</h3>
<form style="text-align:center" name=\'wallet-form\' action="wallet.php" method="post">
                <input type="text" name="amount" value="'.$currentTuple[2].'" placeholder="Amount">
            <button type="submit">Save New Amount</button>
        </form></div>
       <div> <h4 style="text-align:center">Choose something to return</H4>
        <form style="text-align:center" name=\'buy-form\' action="returnProcess.php" method="post">
        <label>Return Amount</label><br>
                <input type="number" name="amount" value="0" id="amount" placeholder="Amount" ><br>
                <label>Product Id</label><br>
                <input type="text" name="pid" value=""><br>
            <button type="submit">Return</button>
        </form></div>';

$statement = 'select product.pid, pname, sum(quantity) from buy,product where buy.pid=product.pid and buy.cid=' .'\'' .$current_user_id. '\' group by product.pid, product.pname having sum(buy.quantity) > 0';
$resultedQuery = $conn->query($statement);
echo '<table class=\'productTable\'>
        <thead>
        <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>';
while ($currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM)){
    echo '<tr>
    <td>' . $currentTuple[0] . '</td>
    <td>' . $currentTuple[1] . '</td>
    <td>' . $currentTuple[2] . '</td>
    </tr>';
}
echo '</tbody></table>';
mysqli_close($conn);
