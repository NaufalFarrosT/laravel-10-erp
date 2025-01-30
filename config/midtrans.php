<?php
    return [
        'server_key' => env('MIDTRANS_SERVER_KEY'),
        'client_key' => env('MIDTRANS_CLIENT_KEY'),
        'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

        'is_production'=> env('MIDTRANS_IS_PRODUCTION'),
        'is_santizied'=>env('MIDTRANS_IS_SANITIZED'),
        'is_3ds'=>env('MIDTRANS_IS_3DS')
    ]
?>
