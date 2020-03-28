<?php
namespace App\Stubs;

class Taxies {
    const aid = 1;
    static $stubObjects = [Taxies::aid => '{
        "name": "Tesla model S",
        "type": "Стандартное такси",
        "sits": "До 3",
        "luggage": "До 3",
        "meeting": true,
        "service": "TK Milia",
        "price": 500
    }'];
}