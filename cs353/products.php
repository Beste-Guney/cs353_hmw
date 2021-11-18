<?php
include "config.php"; 
$statement = 'select pid, pname, price from product where stock > 0';
$resultedQuery = $conn->query($statement);

echo '<div class="container">
<div class="table-part table-header"><table class=\'productTable\'>
<h2>Welcome To Product Screen</h2>
<h3>All Available Products Are Here</h3> 

        <thead>
        <tr>
            <th class="header__item filter__link ">Product Id</th>
            <th class="header__item filter__link ">Product Name</th>
            <th class="header__item filter__link ">Price</th>
            <th class="header__item filter__link ">Enter Amount</th>
        </tr>
        </thead>
        <tbody>';
while ($currentTuple = $resultedQuery->fetch_array(MYSQLI_NUM)){
    echo '<tr>
    <td>' . $currentTuple[0] . '</td>
    <td>' . $currentTuple[1] . '</td>
    <td>' . $currentTuple[2] . '</td>
    <td>
    <form name=\'buy-form\' action="buyProcess.php" method="post">
                <input type="number" name="amount" value="0" placeholder="Amount">
                <input type="hidden" name="pid" value=\'' . $currentTuple[0] .'\'>
            <button type="submit">Buy</button>
        </form>
    
    </td>
    </tr>';
}
echo '</tbody></table></div></div>';


