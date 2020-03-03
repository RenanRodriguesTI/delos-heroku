<?php

return [
    'receiver' => [
        //People who need to receive an email when a project is completed
        'complete-project' => [
            ['email' => 'martin@delosconsultoria.com.br', 'name' => 'Martin Salvati'],
            ['email' => 'inacio@delosconsultoria.com.br', 'name' => 'Inacio Werner Pires'],
            ['email' => 'administracao@delosservicos.com.br', 'name' => 'Administração'],
            ['email' => 'rh.delos@delosservicos.com.br', 'name' => 'Roseli Amorim'],
            ['email' => 'dhales@delosconsultoria.com.br', 'name' => 'Dhales Ribeiro'],
            ['email' => 'operacional@delosconsultoria.com.br', 'name' => 'Jessica Santos'],
        ],

        //People who need to receive an email when there are activities to be approved
        'approve-activities' => [
            ['email' => 'martin@delosconsultoria.com.br', 'name' => 'Martin Salvati'],
        ],
        //People who need to receive an email when there are rests to be approved
        'approve-rests' => [
            ['email' => 'ana@delosconsultoria.com.br', 'name' => 'Ana Carolina Calveti'],
        ],

        //Person responsible for approving requests
        'approve-request' => ['email' => 'ana@delosconsultoria.com.br', 'name' => 'Ana Carolina Calveti'],

        //People who need to receive an email when a rest is approved
        'approved-rest' => [
            ['email' => 'ana@delosconsultoria.com.br', 'name' => 'Ana Carolina Calveti'],
            ['email' => 'rh.delos@delosservicos.com.br', 'name' => 'Roseli Amorim'],
        ],
        //People who need to receive an email when a project is created

        'created-project' => [
            ['email' => 'martin@delosconsultoria.com.br', 'name' => 'Martin Salvati'],
            ['email' => 'inacio@delosconsultoria.com.br', 'name' => 'Inacio Werner Pires'],
            ['email' => 'administracao@delosservicos.com.br', 'name' => 'Administração'],
            ['email' => 'rh.delos@delosservicos.com.br', 'name' => 'Roseli Amorim'],
            ['email' => 'dhales@delosconsultoria.com.br', 'name' => 'Dhales Ribeiro'],
            ['email' => 'operacional@delosconsultoria.com.br', 'name' => 'Jessica Santos'],
        ],

        'edited-project' => [
            ['email' => 'martin@delosconsultoria.com.br', 'name' => 'Martin Salvati'],
            ['email' => 'inacio@delosconsultoria.com.br', 'name' => 'Inacio Werner Pires'],
            ['email' => 'administracao@delosservicos.com.br', 'name' => 'Administração'],
            ['email' => 'rh.delos@delosservicos.com.br', 'name' => 'Roseli Amorim'],
            ['email' => 'operacional@delosconsultoria.com.br', 'name' => 'Jessica Santos'],
        ],

        'created-request' => [
            ['email' => 'veronica.salvati@delosservicos.com.br', 'name' => 'Veronica Salvati'],
            ['email' => 'rh.delos@delosservicos.com.br', 'name' => 'Roseli Amorim'],
            ['email' => 'adm@delosservicos.com.br', 'name' => 'Hellen Haddad'],
        ],

        'created-request-add-hours-per-task' => [
            ['email' => 'martin@delosconsultoria.com.br', 'name' => 'Martin Salvati'],
        ],
        'request-summary' => [
            ['email' => 'veronica.salvati@delosservicos.com.br', 'name' => 'Veronica Salvati']
        ],
        'absences' => [
            ['email' => 'rh.delos@delosservicos.com.br', 'name' => 'Hellen Bertacco'],
        ],
    ],
    'manager' => ['email' => 'inacio@delosconsultoria.com.br', 'name' => 'Inacio Werner Pires']

];
