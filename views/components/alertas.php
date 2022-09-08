<?php
if ($alertas) {
    if (!$clase) $clase = 'error';
    echo "<p class='alerta $clase'>$alertas</p>";
}
