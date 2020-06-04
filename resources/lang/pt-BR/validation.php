<?php

    return [
        /*
        |--------------------------------------------------------------------------
        | Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines contain the default error messages used by
        | the validator class. Some of these rules have multiple versions such
        | as the size rules. Feel free to tweak each of these messages here.
        |
        */
        'accepted'                       => ':attribute deve ser aceito.',
        'active_url'                     => ':attribute não é uma URL válida.',
        'after'                          => ':attribute deve ser uma data depois de :date.',
        'alpha'                          => ':attribute deve conter somente letras.',
        'alpha_dash'                     => ':attribute deve conter letras, números e traços.',
        'alpha_num'                      => ':attribute deve conter somente letras e números.',
        'array'                          => ':attribute deve ser um array.',
        'before'                         => ':attribute deve ser uma data antes de :date.',
        'between'                        => [
            'numeric' => ':attribute deve estar entre :min e :max.',
            'file'    => ':attribute deve estar entre :min e :max kilobytes.',
            'string'  => ':attribute deve estar entre :min e :max caracteres.',
            'array'   => ':attribute deve ter entre :min e :max itens.',
        ],
        'boolean'                        => ':attribute deve ser verdadeiro ou falso.',
        'confirmed'                      => 'A confirmação de :attribute não confere.',
        'date'                           => ':attribute não é uma data válida.',
        'date_format'                    => ':attribute não confere com o formato :format.',
        'different'                      => ':attribute e :other devem ser diferentes.',
        'digits'                         => ':attribute deve ter :digits dígitos.',
        'digits_between'                 => ':attribute deve ter entre :min e :max dígitos.',
        'email'                          => ':attribute deve ser um endereço de e-mail válido.',
        'exists'                         => 'O(s) :attribute selecionado(s) é(são) inválido(s).',
        'filled'                         => ':attribute é um campo obrigatório.',
        'image'                          => ':attribute deve ser uma imagem.',
        'in'                             => ':attribute é inválido.',
        'integer'                        => ':attribute deve ser um inteiro.',
        'ip'                             => ':attribute deve ser um endereço IP válido.',
        'json'                           => ':attribute deve ser um JSON válido.',
        'max'                            => [
            'numeric' => ':attribute não deve ser maior que :max.',
            'file'    => ':attribute não deve ter mais que :max kilobytes.',
            'string'  => ':attribute não deve ter mais que :max caracteres.',
            'array'   => ':attribute não pode ter mais que :max itens.',
        ],
        'mimes'                          => ':attribute deve ser um arquivo do tipo: :values.',
        'min'                            => [
            'numeric' => ':attribute deve ser no mínimo :min.',
            'file'    => ':attribute deve ter no mínimo :min kilobytes.',
            'string'  => ':attribute deve ter no mínimo :min caracteres.',
            'array'   => ':attribute deve ter no mínimo :min itens.',
        ],
        'not_in'                         => 'O :attribute selecionado é inválido.',
        'numeric'                        => ':attribute deve ser um número.',
        'regex'                          => 'O formato de :attribute é inválido.',
        'required'                       => 'O campo :attribute é obrigatório.',
        'required_if'                    => 'O campo :attribute é obrigatório quando :other é :value.',
        'required_with'                  => 'O campo :attribute é obrigatório quando :values está presente.',
        'required_with_all'              => 'O campo :attribute é obrigatório quando :values estão presentes.',
        'required_without'               => 'O campo :attribute é obrigatório quando :values não está presente.',
        'required_without_all'           => 'O campo :attribute é obrigatório quando nenhum destes estão presentes: :values.',
        'same'                           => ':attribute e :other devem ser iguais.',
        'size'                           => [
            'numeric' => ':attribute deve ser :size.',
            'file'    => ':attribute deve ter :size kilobytes.',
            'string'  => ':attribute deve ter :size caracteres.',
            'array'   => ':attribute deve conter :size itens.',
        ],
        'string'                         => ':attribute deve ser uma string',
        'timezone'                       => ':attribute deve ser uma timezone válida.',
        'unique'                         => ':attribute já está em uso.',
        'url'                            => 'O formato de :attribute é inválido.',
        'after_or_equal'                 => ':attribute deve ser uma data depois ou igual de :date.',
        'before_or_equal'                => ':attribute deve ser uma data antes ou igual a :date.',
        'debit_memo_is_finish'           => 'A Nota de Débito associada à solicitação foi finalizada.',
        'reported_external_activities'   => 'Relatório Atividades Externas já foi exportado este mês.',
        'not_more'                       => 'A quantidade de horas por tarefa deve ser menor ou igual à orçada.',
        'register_date_limit_to_weekend' => 'Há atividades de final de semana anteriores a 7 dias',
        /*
        |--------------------------------------------------------------------------
        | Custom Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | Here you may specify custom validation messages for attributes using the
        | convention "attribute.rule" to name the lines. This makes it quick to
        | specify a specific custom language line for a given attribute rule.
        |
        */
        'custom'                         => [
            'attribute-name' => [
                'rule-name' => 'custom-message',
            ],
        ],
        /*
        |--------------------------------------------------------------------------
        | Custom Validation Attributes
        |--------------------------------------------------------------------------
        |
        | The following language lines are used to swap attribute place-holders
        | with something more reader friendly such as E-Mail Address instead
        | of "email". This simply helps us make messages a little cleaner.
        |
        */
        'attributes'                     => [
            'issue_date'         => 'data de emissão',
            'number'             => 'ND',
            'period'             => 'período',
            'projects.*'         => 'projeto(s)',
            'supplier_number'    => 'N. Fornecedor',
            'co_owner_id'        => 'co-líder',
            'owner_id'           => 'líder',
            'notes'              => 'Descrição',
            'name'               => 'Nome',
            'return_date'        => 'Devolução',
            'withdrawal_date'    => 'Retirada',
            'state_id'           => 'Estado',
            'start_date'         => 'Data de Início',
            'address.postal'     => 'CEP',
            'document.type'      => 'CPF/CNPJ',
            'document.number'    => 'CPF/CNPJ',
            'address.street'     => 'Logradouro',
            'address.district'   => 'Bairro',
            'address.city'       => 'Cidade',
            'address.state'      => 'Estado',
            'proposal_value'     => 'Valor da Proposta',
            'cod'                => 'Código',
            'password'           => 'Senha',
            'invoice_file'       => 'Arquivo',
            'back_arrival_date'  => 'Data e hora da ida',
            'going_arrival_date' => 'Data e hora da volta',
            'second_driver_id'   => 'Segundo condutor',
            'first_driver_id'    => 'Primeiro condutor',
            'withdrawal_place'   => 'Local retirada',
            'return_place'       => 'Local devolução',
            'description'        => 'Descrição',
            'task'               => 'Tarefa',
            'value'              => 'Valor',
            'start'              => 'Data de início',
            'finish'             => 'Data de término',
            'hours'              => 'Quantidade de horas',
            'client_id'          => 'Cliente(s)',
            'end' => 'Data de encerramento',
            'startfilter' =>'Inicio',
            'endfilter' =>'Fim',
            'projects' =>'Projeto',
            'telephone' =>'Telefone',
            'establishment_id' =>'Estabelecimento',
            'payment_type_provider_id' => 'Tipo de Pagamento',
            'description_id' => 'Descrição',
            'provider_id' =>'Fornecedor',
            'voucher_type_id' => 'Tipo de Comprovante',
            'version'=>'Versão'
        ],
    ];