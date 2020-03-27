<?php
namespace App\Stubs;

class Taxi {
    const aid = 1;
    static $stubObjects = [Taxi::aid => '{
        "name": "Tesla model S",
        "type": "Стандартное такси",
        "sits": "До 3",
        "luggage": "До 3",
        "meeting": true,
        "service": "TK Milia",
        "price": 500
    }'];
}