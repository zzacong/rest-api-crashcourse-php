
<?php

function html_decode($str) {
  return html_entity_decode($str);
}

function html($str) {
  return htmlspecialchars($str);
}

?>