<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = str_replace('/DIT2153WD/frontEnd/app/public', '', $requestUri); // Trim the base path

switch($requestUri) {
    case "/":
        require __DIR__ . '/../controllers/index.php';
        break;;

    default:
        handle404(); // Call the 404 function if no match found
}

function handle404() {
    http_response_code(404);
    echo '404 Not Found';
}
