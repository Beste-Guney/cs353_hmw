<?php

$sname= "dijkstra.ug.bcc.bilkent.edu.tr";

$unmae= "beste.guney";

$password = "mXGI4qVi";

$db_name = "beste_guney";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {

    echo "Connection failed!";

}
