<?php
include 'db.php';
include 'header.php';
pageBeginning();
mainBeginning();

setTitle("Εγγραφή");


echo "<div><p>Ένα email σας έχει σταλεί στο οποίο πρέπει να επιβεβαιώσετε την εγγραφή σας.</p></div>";							

mainEnd();
leftMenu($connect);
rightMenu($connect);
pageEnd();
?>		