<?php

require 'UserModel.php';
require_once "produits/Database.php";
require 'ProduitModel.php';
require 'OrderModel.php';

$userModel= new UserModel();
$users=$userModel->all();
$produitModel = new ProduitModel();
$produits = $produitModel->all();
$orderModel = new OrderModel();
$orders = $orderModel->all();

  

