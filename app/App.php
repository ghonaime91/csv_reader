<?php

declare(strict_types=1);

function getTransactionFiles(string $path):?array
{
    if(!is_dir($path))
        return null;

    $files = [];
    
    foreach(scandir($path) as $file)
    {
        if(is_dir($file))
            continue;

        $files[] = $path.$file; 
    }
    return $files;
}


function getTransactionsFromCSV(string $fileName):?array
{
    if (
        !file_exists($fileName) ||
        pathinfo($fileName, PATHINFO_EXTENSION) !== 'csv'
    )
    {
        return null;
    }

    $file = fopen($fileName, "r");
    if(!$file)
        return null;

    $transactions = [];

    # Skip file heading
    fgetcsv($file);

    while($line = fgetcsv($file))
        $transactions[] = $line; 

    fclose($file);
    return $transactions;
}

function parseAmount(string $amount): float {
    return (float)str_replace(['$', ','], '', $amount);
}


function getFormattedTransactions(array $transactions):array
{
    $formattedTransactions = [
        "records" => []
    ];
    $income = 0;
    $expense = 0;
    foreach($transactions as $transaction)
    {
        array_push($formattedTransactions["records"], [
            "date"        => date("M j,Y",strtotime($transaction[0])),
            "check"       => $transaction[1],
            "description" => $transaction[2],
            "amount"      => $transaction[3]
        ]);

        $amount = parseAmount($transaction[3]);        
        ($amount >= 0)?$income += $amount : $expense += abs($amount);       
    }
 

    $formattedTransactions['totals'] = [
        "totalIncome"  => "$".number_format($income,2),
        "totalExpense" => "$".number_format($expense,2),
        "netTotal"     => "$".number_format(($income - $expense),2)
    ];


    return $formattedTransactions;
}


