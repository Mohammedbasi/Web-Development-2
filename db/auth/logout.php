<?php
require_once '../Database.php';
require_once 'Auth.php';

$auth = new Auth();

$auth->logout();
