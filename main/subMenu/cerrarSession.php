<?php

/*
 * @Autor: Juan Diego Ninco Collazos
 *
 * @fecha:  julio 19 de 2017
 *
 * @Objetivo: cerar sesión del usuario logueado
 *
 */

include '../../rsc/session.php';

$session = new session;

$session->logout();
