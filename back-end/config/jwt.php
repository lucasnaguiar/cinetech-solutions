<?php
return [
    'secret' => $_ENV['JWT_SECRET'],
    'algorithm' => 'HS256',
    'expiration' => 3600, // Tempo em segundos
];
