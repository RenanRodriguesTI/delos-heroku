<?php

    namespace Delos\Dgp\Providers;

    use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

    /**
     * Class EventServiceProvider
     * @package Delos\Dgp\Providers
     */
    class EventServiceProvider extends ServiceProvider
    {
        /**
         * The event listener mappings for the application.
         *
         * @var array
         */
        protected $listen = [
            'Delos\Dgp\Events\DeleteProjectEvent'      => [
                'Delos\Dgp\Listeners\SendEmailWhenProjectIsRemoved'
            ],
            'Delos\Dgp\Events\CreatedUserEvent'        => [
                'Delos\Dgp\Listeners\SendEmailWhenUserIsCreated'
            ],
            'Delos\Dgp\Events\CreatedProjectEvent'     => [
                'Delos\Dgp\Listeners\SendEmailWhenProjectIsCreatedListener',
                'Delos\Dgp\Listeners\AddHoursPerTaskEmail'
            ],
            'Delos\Dgp\Events\CreatedRequestEvent'     => [
                'Delos\Dgp\Listeners\ApproveRequestEmail'
            ],
            'Delos\Dgp\Events\AddedMemberEvent'        => [
                'Delos\Dgp\Listeners\SendEmailWhenMemberIsCreatedListener'
            ],
            'Delos\Dgp\Events\DeletedMemberEvent'      => [
                'Delos\Dgp\Listeners\SendEmailWhenMemberIsDeletedListener'
            ],
            'Delos\Dgp\Events\DeleteActivityEvent'     => [
                'Delos\Dgp\Listeners\RefusedActivityEmail'
            ],
            'Delos\Dgp\Events\ApprovedRequestEvent'    => [
                'Delos\Dgp\Listeners\SendEmailWhenRequestIsCreatedListener'
            ],
            'Delos\Dgp\Events\EditedProjectEvent'      => [
                'Delos\Dgp\Listeners\EditedProjectEmail',
                \Delos\Dgp\Listeners\UpdateProjectTasks::class
            ],
            'Delos\Dgp\Events\RefusedRequestEvent'     => [
                'Delos\Dgp\Listeners\RefusedRequestEmail'
            ],
            'Delos\Dgp\Events\SavedExpense'            => [
                'Delos\Dgp\Listeners\InvoiceFileUpload',
                'Delos\Dgp\Listeners\AttachDebitMemoListener'
            ],
            'Delos\Dgp\Events\BillingToDo'             => [
                'Delos\Dgp\Listeners\SendEmailForGenerateBankSlip'
            ],
            'Delos\Dgp\Events\BankSlipGenerated'       => [
                'Delos\Dgp\Listeners\NotifyBankSlipGenerated'
            ],
            'Delos\Dgp\Events\BankSlipApproved'        => [
                'Delos\Dgp\Listeners\NotifyBankSlipApproved'
            ],
            'Delos\Dgp\Events\AddedTasksProjectType'   => [
                'Delos\Dgp\Listeners\AttachTasksInProjects'
            ],
            'Delos\Dgp\Events\RemovedTasksProjectType' => [
                'Delos\Dgp\Listeners\DetachTasksInProjects'
            ],
            'Delos\Dgp\Events\SavedAllocation' => [
                'Delos\Dgp\Listeners\SendEmailWhenAllocationIsCreated'
            ],
            'Delos\Dgp\Events\DeletedAllocation' => [
                'Delos\Dgp\Listeners\SendEmailWhenAllocationIsDeleted'
            ],
            'Delos\Dgp\Events\SavedSupplierExpense' =>[
                'Delos\Dgp\Listeners\InvoiceFileProviderUpload',
                'Delos\Dgp\Listeners\AttachDebitMemoListener'
            ],
            'Delos\Dgp\Events\SavedSupplierExpenseImport' =>[
                'Delos\Dgp\Listeners\AttachDebitMemoListener'
            ],
            'Delos\Dgp\Events\NotifyToPaPAllocations' =>[
                'Delos\Dgp\Listeners\SendEmailAlocationsToPap'
            ],
            'Delos\Dgp\Events\SavedOffice' =>[
                'Delos\Dgp\Listeners\SavedOfficeListener'
            ],
            'Delos\Dgp\Events\UpdatedOffice' =>[
                'Delos\Dgp\Listeners\UpdatedOfficeListener'
            ],
            'Delos\Dgp\Events\UpdateUser' =>[
                'Delos\Dgp\Listeners\UpdateUserListener'
            ],
            'Delos\Dgp\Events\ImportedRevenues' =>[
                'Delos\Dgp\Listeners\ImportedRevenuesListener'
            ],
            'Delos\Dgp\Events\UpdateOwnerProject' =>[
                'Delos\Dgp\Listeners\UpdateOwnerProjectListener'
            ],
            'Delos\Dgp\Events\DispatchAutoAllocation' =>[
                'Delos\Dgp\Listeners\AutoAllocationUpdateListener'
            ],
            'Delos\Dgp\Events\UpdatedAllocation' => [
                'Delos\Dgp\Listeners\SendEmailWhenAllocationIsUpdated'
            ],
            'Delos\Dgp\Events\AddTaskAllocation' =>[
                'Delos\Dgp\Listeners\SendEmailWhenAddTaskAllocation'
            ],
            'Delos\Dgp\Events\UpdateTaskAllocation' =>[
                'Delos\Dgp\Listeners\SendEmailWhenUpdateTaskAllocation'
            ],
            'Delos\Dgp\Events\AproveExpense'=>[
                'Delos\Dgp\Listeners\AproveExpenseListener'
            ],
            'Delos\Dgp\Events\ReproveExpense'=>[
                'Delos\Dgp\Listeners\ReproveExpenseListener'
            ],
            'Delos\Dgp\Events\ActivityReproved' =>[
                'Delos\Dgp\Listeners\ActivityReprovedListener'
            ],
            'Delos\Dgp\Events\ActivityApproved' =>[
                'Delos\Dgp\Listeners\ActivityApprovedListener'
            ],
            'Delos\Dgp\Events\EpisUploadedFile' =>[
                'Delos\Dgp\Listeners\EpisUploadedFileListener'
            ],
            'Delos\Dgp\Events\CurseUploadedFile'=>[
                'Delos\Dgp\Listeners\CurseUploadedFileListener'
            ],
            'Delos\Dgp\Events\ResourceTaskAdded' =>[
                'Delos\Dgp\Listeners\ResourceTaskAddedListener'
            ]
        ];

        /**
         * @var array
         */
        protected $subscribe = [
            \Delos\Dgp\Listeners\DeleteMissingActivityListener::class,
            \Delos\Dgp\Listeners\CreateMissingActivityListener::class
        ];
    }
