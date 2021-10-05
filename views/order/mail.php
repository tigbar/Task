<?php

//echo dirname(dirname(__DIR__)); die;
include_once __DIR__ . '/../header.php';

//echo '<pre>';print_r($products);
//echo '<pre>';print_r($params);die;


$subject = 'Test market approove mail';

$veryTotalPrice = 0;
$message = '<!doctype html>
                    <html>
                    <br/>
                        Dear <b>' . $params['firstName'] . ' ' . $params['lastName'] . '</b> You have bout following product(s): <br/><br/>';
$veryTotalPrice = 0;
foreach($prods as $prod){
    $veryTotalPrice += $prod[1] * $prod[2];
    $message .= '<table border="1px">
                                                <tr>
                                                    <td><b>Name</b></td><td><b>Count</b></td><td><b>Price</b></td><td><b>Description</b></td><td><b>Total price</b></td></tr>
                                                <tr><td>' . $prod[0] . '</td>
                                                <td>' . $prod[1] . '</td>
                                                <td>' . $prod[2] . '</td>
                                                <td>' . $prod[3] . '</td>
                                                <td>' . $prod[1] * $prod[2] . '</td>
                                                </tr>
                                            </table><br/>';

}
echo $message;


echo '<br/><b>The price of shopping:</b> ' . $veryTotalPrice;

