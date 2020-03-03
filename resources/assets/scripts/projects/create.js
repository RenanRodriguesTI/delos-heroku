var DOMdocument  = $(document);
DOMdocument.ready(projectScripts);

function projectScripts() {
    //Variaves a serem usadas
    var taskModal    = $('#tasks_modal'),
        hoursPerTask = $('#hours-per-task'),
        alertTask    = $('.alert-tasks'),
        btnSubmit    = $('.btn-tasks-hours-modal'),
        inputHour    = $('.hour_task'),
        formProject  = $('#form-project');


    // Exibe a modal caso a requisição venha a seguir a tela de cadastro
    if ( hasToShowModal() ) {
        taskModal.modal('show');
    }

    // Executa o bind da modal haja formulário de projeto
    if ( formProject.length ) {
        modalTasks(hoursPerTask, taskModal, inputHour, alertTask, btnSubmit);
    }
}

function modalTasks(hoursPerTask, taskModal, inputHour, alertTask, btnSubmit) {

    initialSetup(btnSubmit, inputHour);

    if ( hoursPerTask.val() === 'created' ) {
        taskModal.modal('show');

        taskModal.on('hidden.bs.modal', function () {
            window.location.replace('/projects');
        });
    }

    if ( hoursPerTask.val() === 'edited' ) {
        bind('.bind-budget', (getBudget() - getValueTotalOfTheInputs(inputHour)));
    }

    inputHour.on('keyup', function () {
        bind('.bind-budget', (getBudget() - getValueTotalOfTheInputs(inputHour)));
    });

    DOMdocument.on('bind-budget', function () {

        if ( (getBudget() - getValueTotalOfTheInputs(inputHour)) < 0 ) {
            alertTask.show();
            btnSubmit.attr('disabled', true);
        } else if ( (getBudget() - getValueTotalOfTheInputs(inputHour)) === getBudget() ) {
            btnSubmit.attr('disabled', true);
        } else {
            alertTask.hide();
            btnSubmit.attr('disabled', false);
        }
    });

    btnSubmit.on('click', function () {
        $('#form-project-tasks').submit();
    });
}

function getValueTotalOfTheInputs(inputs) {
    var total = 0;
    inputs.each(function (key, item) {
        if ( !isNaN(parseInt(item.value)) ) {
            total = total + parseInt(item.value);
        }
    });
    return total;
}

function bind(el, val) {
    $(el).empty();
    $(el).html(val);
    $.event.trigger({
        type: "bind-budget",
        message: "Event Trigger when binded budget",
        time: new Date()
    });
}

function getBudget() {
    return parseInt($('#budget').val());
}

function hasToShowModal() {
    return window.location.href.includes('#edit_hours_per_tasks') && $('#cannot-add-hours-per-task').val() != 'true';
}

function initialSetup(btnSubmit, inputHour) {
    if ( (getBudget() - getValueTotalOfTheInputs(inputHour)) === getBudget() ) {
        btnSubmit.attr('disabled', true);
    }
}