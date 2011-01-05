<?php
if(file_exists('./index.html')) {
  die(require_once('./index.html'));
}
require_once('base/lib/main.php');