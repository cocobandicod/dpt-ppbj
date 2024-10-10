<?php
require_once('../config/koneksi.php');
session_start();
session_destroy();
echo "<script>document.location='" . $url . "operator'</script>";
