<?php

    use Delos\Dgp\Entities\Module;
    use Delos\Dgp\Entities\Permission;
    use Illuminate\Database\Seeder;

    class ModulePermissionTableSeeder extends Seeder
    {
        public function run()
        {
            $module_permission = [
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Approve Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Create Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Destroy Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Download Report Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('External Works Report Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('hours Menu')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Index Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Index Missing Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Index Projects Gantt')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Index Resources Gantt')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('List Possible Hours Activity')],
                ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'permission_id' => $this->getPermissionId('Report External Activity')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Add Member Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Add Task Project Type')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Create Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Created Hours Per Task Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Destroy Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Edited Hours Per Task Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Emails Event')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Index Budgeted Vs Actual')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Index Event')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Index Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Manage Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Members Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Members To Add Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Owners Index Report')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Remove Member Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Report Menu')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Restore Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('See Proposal Value')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Show All Projects')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Show Details Hours Per Task')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Show Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Store Tasks Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Tasks Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Tasks To Add Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Update Extra Expenses Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Update Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Update Value User')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Users Index Report')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Approve Menu')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Check Period Hours Allocation ')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Create Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Create Task')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Destroy Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Destroy Task')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Gcalendar Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Gcalendar Callback Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Index Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Index Task')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Show All Activities')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Show Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Store Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Update Task')],
                ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'permission_id' => $this->getPermissionId('Report Allocation')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Add Task Project Type')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Create Project Type')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Destroy Project Type')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Index Project Type')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Remove Task Project Type')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Tasks Project Type')],
                ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'permission_id' => $this->getPermissionId('Update Project Type')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Create Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Destroy Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('expense menu')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Get Pairs By Date Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Get Pairs Descriptions Expense Type')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Get Pairs Requests By Date Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('get Requests By Project Id Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Get Users By Id Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Get Users By Request Id Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Index Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Report TXT Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Show All Expenses')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Update Expense')],
                ['module_id' => $this->getModuleId('Controle de Despesas'), 'permission_id' => $this->getPermissionId('Update Expense After Export')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('close debit memo')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('Destroy Alert Debit Memo')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('index debit memo')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('Options Debit Memo')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('show debit memo')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('Store Alert Debit Memo')],
                ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'permission_id' => $this->getPermissionId('Update Debit Memo')],
                ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'permission_id' => $this->getPermissionId('Create Group')],
                ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'permission_id' => $this->getPermissionId('Destroy Group')],
                ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'permission_id' => $this->getPermissionId('Index Group')],
                ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'permission_id' => $this->getPermissionId('Update Group')],
                ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'permission_id' => $this->getPermissionId('By Group Client')],
                ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'permission_id' => $this->getPermissionId('Create Client')],
                ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'permission_id' => $this->getPermissionId('Destroy Client')],
                ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'permission_id' => $this->getPermissionId('Index Client')],
                ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'permission_id' => $this->getPermissionId('Update Client')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Add Email Event')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Add Permission User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('add-user-permission')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Approve Bank Slip')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Cancellation Signature')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Change Avatar User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('change companies user')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Change Pass Edit User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Copy Last Values Coast User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Create Checkout')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Create User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Destroy Bank Slip')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Destroy User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Emails Event')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Bank Slip')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Checkout')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Coast User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Event')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Home')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Notification')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Select Plan Signature')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index Signature')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Index User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('List User Permissions')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Manager Menu')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Permissions User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Remove Email Event')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Remove Permission User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('remove-user-permission')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Restore User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Show All Users')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Show Rests User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Store Plan Signature')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Update Bank Slip')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Update Coast User')],
                ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'permission_id' => $this->getPermissionId('Update User')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Airports Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Approve Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('By State City')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Cancel Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Confirm Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Create Advance Money')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Create Car')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Create Lodging')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Create Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Create Ticket')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Index Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Members Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Refuse Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Show All Requests')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Show Request')],
                ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'permission_id' => $this->getPermissionId('Summary Request')],
                ['module_id' => $this->getModuleId('Gerenciamento Multi Empresas'), 'permission_id' => $this->getPermissionId('Create Company')],
                ['module_id' => $this->getModuleId('Gerenciamento Multi Empresas'), 'permission_id' => $this->getPermissionId('index-company')],
                ['module_id' => $this->getModuleId('Gerenciamento Multi Empresas'), 'permission_id' => $this->getPermissionId('update-company')],
                ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'permission_id' => $this->getPermissionId('Create Financial Rating')],
                ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'permission_id' => $this->getPermissionId('Destroy Financial Rating')],
                ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'permission_id' => $this->getPermissionId('Index Financial Rating')],
                ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'permission_id' => $this->getPermissionId('Settings Menu')],
                ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'permission_id' => $this->getPermissionId('Update Financial Rating')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Create Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Destroy Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Edit Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Index Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Store Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Update Project')],
                ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'permission_id' => $this->getPermissionId('Proposal Values Description Report Project')],

            ];

            foreach ( $module_permission as $index => $item ) {
                \DB::transaction(function () use ($item) {
                    \DB::table('module_permission')
                       ->insert($item);
                });
            }
        }

        private function getModuleId(string $name): int
        {
            return Module::where('name', $name)
                         ->first()->id;
        }

        private function getPermissionId(string $name): int
        {
            return Permission::where('name', $name)
                             ->first()->id;
        }
    }