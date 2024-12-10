
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\style.css">  
</head>
<body>
    <table>
        <thead>
            <tr>
                <td class="wider">Date</td>
                <td>Check #</td>
                <td>Description</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody> 
            <?php if($error)echo"<h2 style='text-align:center;'>$errorMsg</h2>";?>
            <?php if($formattedTransactions):?>
            <?php foreach($formattedTransactions["records"] as $transaction):?>
            <tr>
                <td><?= $transaction["date"] ?></td>
                <td><?= $transaction["check"] ?></td>
                <td><?= $transaction["description"] ?></td>

                <?php if($transaction["amount"][0] == "-"):?>
                <td style="color:red" ><?= $transaction["amount"] ?></td>
                <?php else :?>
                <td style="color:green" ><?= $transaction["amount"] ?></td>
                <?php endif?>

            </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="3">Total Income:</td>
                <td><?= $formattedTransactions["totals"]["totalIncome"]?></td>
            </tr>
            
            <tr>
                <td colspan="3">Total Expense:</td>
                <td><?= $formattedTransactions["totals"]["totalExpense"]?></td>
            </tr>
            
            <tr>
                <td colspan="3">Nat Total:</td>
                <td><?= $formattedTransactions["totals"]["netTotal"]?></td>
            </tr>

            <?php endif ?>
        </tbody>
    </table>
</body>
</html>