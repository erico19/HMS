<?php

function check_admin(){
    if (!@($_SESSION['adminid'])){
        header('location: login');
    }
}


function check_administrator(){
    if ($_SESSION['userid']=='1'){
        return true;
    }
}