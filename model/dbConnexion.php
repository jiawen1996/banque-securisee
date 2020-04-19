<?php

function getMySqliConnection() {
  $db_connection_array = parse_ini_file("../config/config.ini");
  return new mysqli($db_connection_array['DB_HOST'], $db_connection_array['DB_USER'], $db_connection_array['DB_PASSWD'], $db_connection_array['DB_NAME']);
}

?>