<?php
@session_start();
include_once '../rsc/session.php';
echo session::getAttribute('URL');
