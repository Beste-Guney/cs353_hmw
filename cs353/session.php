<?php
include 'config.php';
session_start();
$current_user_name = $_SESSION['user_name'];
$current_user_id = $_SESSION['cid'];

if(!isset($_SESSION['user_name'])){
    header('location:login.php');
}