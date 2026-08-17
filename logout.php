<?php

require_once __DIR__ . "/php/auth.php";

logoutUser();

header("Location: index.php");

exit;