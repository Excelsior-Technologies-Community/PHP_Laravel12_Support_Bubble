<?php
// config/support-bubble.php

return [
    'mail' => [
        'to' => env('SUPPORT_EMAIL', 'admin@example.com'),
    ],
    'classes' => [
        'bubble' => 'fixed bottom-5 right-5 z-50 p-3 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-colors',
        'button' => 'w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium',
        'input' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
    ],
    'direction' => 'left-to-right',
    'form_action_route' => 'supportBubble.submit',
];