<?php
// Health check endpoint untuk Railway
// Selalu mengembalikan HTTP 200
http_response_code(200);
header('Content-Type: text/plain');
echo 'OK';
