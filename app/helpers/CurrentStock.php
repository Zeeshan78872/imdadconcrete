<?php

use App\Models\stockProduct;
use App\Models\Dispatch;
use App\Models\currentStock;

// FOR STOCK PLANT NAMES
function getPlantName()
{
    return [
        'Saeed',
        'Alahdita',
        'Saeed Bau',
        'Zafar',
        'Sohail'
    ];
}
// FOR BANK
function getAccountCategory()
{
    return [
        'Business',
        'Freelancer',
        'Current Account'
    ];
}
function getAccountStatus()
{
    return [
        'Active',
        'etc'
    ];
}
//  FOR Gravel and Sand

function getSellerNames()
{
    return [
        'rashid',
        'iqbal'
    ];
}

function getMaterialTypes()
{
    return [
        'red sand',
        'white sand',
        'gravel'
    ];
}
// FOR PAYMENT
function getDepositBank()
{
    return [
        'Allied Bank',
        'Mezan Bank'
    ];
}
//  FOR Invoice
function calculateTotalAmount($dispatches)
{
    $totalAmount = 0;
    foreach ($dispatches as $key => $value) {
        foreach ($value->products as $key => $value) {
            $totalAmount += $value->total_price;
        }
    }
    return $totalAmount;
}
// FOR CYRRENT STOCK

function UpdateCurrentStock($Dispatch)
{
}
function SelectCurrentStock()
{
}