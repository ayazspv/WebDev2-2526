<?php

namespace App\Models;

enum MaterialStatus: string {
    case IN_STOCK = 'In Stock';
    case OUT_OF_STOCK = 'Out of Stock';
}
