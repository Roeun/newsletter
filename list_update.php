<?php include_once 'bootstrap.php' ?>

<h1><?=UPDATE ." ". LISTA?></h1>

<?php

$l = Lista::read($_GET['id']);

if (isset($_POST['submit'])) {
  if ( Lista::update($_GET['id'], $_POST['name']) ) {
    echo SUCCESS; // relativo solo alla lista, non agli utenti

    $list_id = $_GET['id'];

    include 'save_users_in_list.php';

  } else {
    echo FAIL . " La lista non e' stata aggiornata.";
  }
}

$l = Lista::read($_GET['id']);
include_once '_list_form.php';

include_once "back.php";
include_once "foot.php";
