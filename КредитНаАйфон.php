<?php

mb_internal_encoding('utf-8');
error_reporting(-1);

$productCost = 40000;    //цена товара
$firstComission = 0;    //комиссия за оформление кредита
$credit = $productCost + $firstComission;
$percentInput = 3;
$comission = 1000;    //ежемесячная комиссия
$payout = 5000;    //ежемесячная выплата
$payed = 0;

$giantPercent = "Этот процент огромен. Не надо так!\n";

if ($percentInput >= 200) {
	echo $giantPercent;
	exit();
}

echo "Цена товара: $productCost\nСумма кредита: $credit\n\n";

$regexp = '/[0-9]+/u';

/* Дальше идет замена процента с "1" на "1.01" и т.д. для удобного умножения */

if ($percentInput < 10) {
    $percent = preg_replace($regexp, '1.0$0', $percentInput);
} elseif ($percentInput >= 10 && $percentInput < 100) {
    $percent = preg_replace($regexp, '1.$0', $percentInput);
} elseif ($percentInput >=100 && $percentInput < 200) {
    $regexp2 = '/^([0-9])([0-9]*)/u';
    $percent = preg_replace($regexp2, '2.$2', $percentInput);
} else {
	echo "Ошибка";
	exit();
}

for ($months = 1; $credit >= 0; $months++) {
	$credit *= $percent;
	$credit += $comission;
	if ($credit >= $payout) {
	    $credit -= $payout;
	    $credit = ceil($credit);
	    $payed += $payout;
	    echo "$months-й месяц.\nОсталось выплатить: $credit рублей\nЗаплачено: $payed рублей\n\n";
    } else {
    	$credit -=$payout;
    	$credit = ceil($credit);
	    $payed += $payout;
	    $payed += $credit;
	    echo "$months-й месяц.\nКредит выплачен! Поздравляю!\nЗаплачено: $payed рублей\n\n";
    }
    if ($credit > ($productCost * 5) or $payed > ($productCost * 5)) {
    	echo "Такой кредит лучше не брать\n";
    	break;
    }
}

?>