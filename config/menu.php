  <!-- @php
        $menus = [
            1 =>[
                (object)[
                    'title' => 'Dashboard',
                    'path' => 'dashboard',
                    'icon' => 'fas fa-fw fa-tachometer-alt'
],
                (object)[
                    'title' => 'Peduduk',
                    'path' => 'resident',
                    'icon' => 'fas fa-fw fa-table'
                ],
                    (object)[
                    'title' => 'Permintaan Akun',
                    'path' => 'account-request',
                    'icon' => 'fas fa-fw fa-user'
                ],
],
        2 =>[
                (object)[
                    'title' => 'Dashboard',
                    'path' => 'dashboard',
                    'icon' => 'fas fa-fw fa-tachometer-alt'
],

],
];
    @endphp -->

    <?php

return [

    1 => [ // Role admin
        [
            'title' => 'Dashboard',
            'path'  => 'dashboard',
            'icon'  => 'fas fa-fw fa-tachometer-alt',
        ],
        [
            'title' => 'Penduduk',
            'path'  => 'resident',
            'icon'  => 'fas fa-fw fa-table',
        ],
        [
            'title' => 'Permintaan Akun',
            'path'  => 'account-request',
            'icon'  => 'fas fa-fw fa-user',
        ],
    ],

    2 => [ // Role user
        [
            'title' => 'Dashboard',
            'path'  => 'dashboard',
            'icon'  => 'fas fa-fw fa-tachometer-alt',
        ],
    ],

];

