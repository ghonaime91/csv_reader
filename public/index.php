<?php

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
define("APP_PATH", $root."app".DIRECTORY_SEPARATOR);
define("FILES_PATH", $root."files".DIRECTORY_SEPARATOR);
define("VIEWS_PATH", $root."views".DIRECTORY_SEPARATOR);

require_once APP_PATH."App.php";

$fullFilesNames = getTransactionFiles(FILES_PATH);    
$transactions = [];
$error = false;
$errorMsg = "";

if(!$fullFilesNames)
{
    $error = true;
    $errorMsg = "No files found in the specified directory.";
}
else 
{
    foreach($fullFilesNames as $fullFileName)
    {
        $transactions = array_merge(
            $transactions,
            getTransactionsFromCSV($fullFileName)
        );
    }
}

$formattedTransactions = getFormattedTransactions($transactions);
require_once VIEWS_PATH."transactions_view.php";

