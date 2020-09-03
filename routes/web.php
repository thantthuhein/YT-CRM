<?php

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/search', 'HomeController@search')->name('search');
    Route::get('/enquiries/search','EnquiriesController@search')->name('enquiries.search');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Enquiries Types
    Route::delete('enquiries-types/destroy', 'EnquiriesTypeController@massDestroy')->name('enquiries-types.massDestroy');
    Route::resource('enquiries-types', 'EnquiriesTypeController');

    // Companies
    Route::delete('companies/destroy', 'CompanyController@massDestroy')->name('companies.massDestroy');
    Route::resource('companies', 'CompanyController');

    // Customers
    Route::delete('customers/destroy', 'CustomerController@massDestroy')->name('customers.massDestroy');

    Route::get('customers/{customer}/note/create', 'CustomerController@createNote')->name('customers.createNote');
    Route::post('customers/{customer}/note/store', 'CustomerController@storeNote')->name('customers.storeNote');
    Route::resource('customers', 'CustomerController');

    // Customer Emails
    Route::delete('customer-emails/destroy', 'CustomerEmailController@massDestroy')->name('customer-emails.massDestroy');
    Route::resource('customer-emails', 'CustomerEmailController');

    // Customer Phones
    Route::delete('customer-phones/destroy', 'CustomerPhoneController@massDestroy')->name('customer-phones.massDestroy');
    Route::resource('customer-phones', 'CustomerPhoneController');

    // Type Of Sales
    Route::delete('type-of-sales/destroy', 'TypeOfSalesController@massDestroy')->name('type-of-sales.massDestroy');
    Route::resource('type-of-sales', 'TypeOfSalesController');

    // Staff
    Route::delete('staff/destroy', 'StaffController@massDestroy')->name('staff.massDestroy');
    Route::resource('staff', 'StaffController');

    // Projects
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::resource('projects', 'ProjectController');

    // Enquiries
    Route::delete('enquiries/destroy', 'EnquiriesController@massDestroy')->name('enquiries.massDestroy');
    Route::resource('enquiries', 'EnquiriesController');


    // Aircon Types
    Route::delete('aircon-types/destroy', 'AirconTypeController@massDestroy')->name('aircon-types.massDestroy');
    Route::resource('aircon-types', 'AirconTypeController');

    // Aircon Type Connectors
    Route::delete('aircon-type-connectors/destroy', 'AirconTypeConnectorController@massDestroy')->name('aircon-type-connectors.massDestroy');
    Route::resource('aircon-type-connectors', 'AirconTypeConnectorController');

    // Quotations
    Route::delete('quotations/destroy', 'QuotationController@massDestroy')->name('quotations.massDestroy');
    Route::resource('quotations', 'QuotationController');
    // Quotation Status Search
    Route::get('quotations/status/search', 'QuotationController@search');
    
    Route::get('/quotations/{quotation_id}/quotation-revisions/create', 'QuotationRevisionController@create');
    

    // Quotation Revisions
    Route::delete('quotation-revisions/destroy', 'QuotationRevisionController@massDestroy')->name('quotation-revisions.massDestroy');
    Route::post('quotation-revisions/media', 'QuotationRevisionController@storeMedia')->name('quotation-revisions.storeMedia');
    Route::resource('quotation-revisions', 'QuotationRevisionController');
    Route::get('quotation-revisions/view_pdf/{id}', "QuotationRevisionController@view_pdf");
    Route::get('quotation-revisions/download_pdf/{id}', "QuotationRevisionController@download_pdf");
    
    // Follow Ups
    Route::get('/quotations/{quotation_id}/follow-ups/create', 'FollowUpController@create')->name('quotations.follow-ups.create');
    Route::delete('follow-ups/destroy', 'FollowUpController@massDestroy')->name('follow-ups.massDestroy');
    Route::get('quotations/{quotation_id}/follow-ups/create/quotation-revision/{quotation_revision_id}', "QuotationRevisionController@create");
    Route::resource('follow-ups', 'FollowUpController');

    // Sale Contracts
    Route::get('sale-contracts/{sale_contract}/equipment-delivery-schedule/create', 'SaleContractController@createEquipmentDeliverySchedule')->name('sale-contracts.createEquipmentDeliverySchedule');
    Route::post('sale-contracts/{sale_contract}/equipment-delivery-schedule/store', 'SaleContractController@storeEquipmentDeliverySchedule')->name('sale-contracts.storeEquipmentDeliverySchedule');

    Route::get('sale-contracts/{sale_contract}/document-pdf/create', 'SaleContractController@createDocumentPdf')->name('sale-contracts.createDocumentPdf');
    Route::post('sale-contracts/{sale_contract}/document-pdf/store', 'SaleContractController@storeDocumentPdf')->name('sale-contracts.storeDocumentPdf');
    

    Route::delete('sale-contracts/destroy', 'SaleContractController@massDestroy')->name('sale-contracts.massDestroy');
    Route::resource('sale-contracts', 'SaleContractController');

    /**
     * Create Sale contract from enquiry
     */
    Route::get('/enquiries/{enquiry}/sale-contracts/create', 'SaleContractController@createFromEnquiry')->name("enquiries.sale-contracts.create");
    Route::post('/enquiries/{enquiry}/sale-contracts/create', 'SaleContractController@storeFromEnquiry')->name("enquiries.sale-contracts.store");

    /**
     * Create Sale contract from quotation
     */
    Route::get('/quotations/{quotation}/sale-contracts/create', 'SaleContractController@createFromQuotation')->name("quotations.sale-contracts.create");
    Route::post('/quotations/{quotation}/sale-contracts/create', 'SaleContractController@storeFromQuotation')->name("quotations.sale-contracts.store");

    Route::get("sale-contracts/choose/quotation-enquiry", 'SaleContractController@choose')->name('sale-contracts.choose-quotation-enquiry');
    Route::get('sale-contracts/{sale_contract}/upload-other-documents', 'SaleContractController@uploadOtherDocuments')->name("sale-contracts.upload-other-documents");
    Route::post('sale-contracts/{sale_contract}/upload-other-documents', 'SaleContractController@storeOtherDocuments')->name("sale-contracts.upload-other-documents");

    Route::get('sale-contracts/{sale_contract}/make-payment', 'SaleContractController@makePayment')->name("sale-contracts.make-payment");
    // Route::post('sale-contracts/{sale_contract}/make-payment', 'SaleContractController@updatePayment')->name("sale-contracts.make-payment");

    Route::get('sale-contracts/{sale_contract}/assign-subcom-teams', 'SaleContractController@assignSubcomTeamsForm')->name("sale-contracts.assign-subcom-teams");
    Route::post('sale-contracts/{sale_contract}/assign-subcom-teams', 'SaleContractController@assignSubcomTeams')->name("sale-contracts.assign-subcom-teams");


    Route::get('sale-contracts/{sale_contract}/teams', 'SaleContractController@viewTeams')->name('sale-contracts.teams');
    Route::post('sale-contracts/{sale_contract}/inhouse-installations/{in_house_installation}/update-delivery-progress', 'SaleContractController@updateMaterialDeliveryProgress')->name('sale-contracts.inhouse-installations.material-delivery-progress');
    Route::post('sale-contracts/{sale_contract}/inhouse-installations/{in_house_installation}/update-installation-progress', 'SaleContractController@updateInstallationProgress')->name('sale-contracts.installation-progress');
    Route::post('sale-contracts/{sale_contract}/inhouse-installations/{in_house_installation}/add-installation-team', 'SaleContractController@addInstallationTeams')->name('sale-contracts.add-installation-teams');

    /**
     * approve project
     */
    Route::post('sale-contracts/{sale_contract}/inhouse-installations/{in_house_installation}/approve-project', 'SaleContractController@approveProject')->name('sale-contracts.inhouseInstallation.approve-project');

    Route::get('sale-contracts/{sale_contract}/inhouse-installations/{in_house_installation}/add-completed-data', 'SaleContractController@addCompletedData')->name('sale-contracts.inhouseInstallation.addCompletedData');
    Route::post('sale-contracts/{sale_contract}/inhouse-installations/{in_house_installation}/add-completed-data', 'SaleContractController@storeCompletedData')->name('sale-contracts.inhouseInstallation.addCompletedData');

    Route::get('sale-contracts/{sale_contract}/editPaymentTerms', 'SaleContractController@editPaymentTerms')->name('sale-contracts.editPaymentTerms');
    Route::post('sale-contracts/{sale_contract}/updatePaymentTerms', 'SaleContractController@updatePaymentTerms')->name('sale-contracts.updatePaymentTerms');

    Route::get('/inhouse-installations/{in_house_installation}/upload-actual-installation-report', 'SaleContractController@uploadActualInstallationReportPdf')->name('inhouseInstallation.uploadActualInstallationReport');
    Route::post('/inhouse-installations/{in_house_installation}/upload-actual-installation-report', 'SaleContractController@storeActualInstallationReportPdf')->name('inhouseInstallation.uploadActualInstallationReport');

    /**
     * All Uploaded Files
     */
    Route::get('sale-contracts/{sale_contract}/all-uploaded-files/index', 'SaleContractController@allUploadedFiles')->name('sale-contracts.allUploadedFiles');
    // Route::get('sale-contracts/{sale_contract}/assign-inhouse-teams', 'SaleContractController@assignInhouseTeamsForm')->name("sale-contracts.assign-inhouse-teams");
    // Route::post('sale-contracts/{sale_contract}/assign-inhouse-teams', 'SaleContractController@assignInhouseTeams')->name("sale-contracts.assign-inhouse-teams");

    // Sale Contract Pdfs
    Route::delete('sale-contract-pdfs/destroy', 'SaleContractPdfController@massDestroy')->name('sale-contract-pdfs.massDestroy');
    Route::post('sale-contract-pdfs/media', 'SaleContractPdfController@storeMedia')->name('sale-contract-pdfs.storeMedia');
    Route::resource('sale-contract-pdfs', 'SaleContractPdfController');

    // Payment Steps
    Route::post('sale-contracts/make-payment/payment-steps/store', "PaymentStepController@store")->name('sale-contracts.storePaymentStep');
    Route::post('sale-contracts/payment-steps/complete', "PaymentStepController@completePaymentStep")->name('sale-contracts.paymentSteps.complete');
    Route::post('sale-contracts/payment-steps/unComplete', "PaymentStepController@unCompletePaymentStep")->name('sale-contracts.paymentSteps.unComplete');
    Route::get('sale-contracts/{sale_contract}/payment-steps/{payment_step}/editTitle', "PaymentStepController@editTitle")->name('sale-contracts.paymentSteps.editTitle');
    Route::post('sale-contracts/payment-steps/{payment_step}/updateTitle', "PaymentStepController@updateTitle")->name('sale-contracts.paymentSteps.updateTitle');

    //Invoices
    Route::post('sale-contracts/make-payment/invoices/store', "InvoiceController@store")->name('sale-contracts.storeInvoice');


    // Payment Histories
    Route::delete('payment-histories/destroy', 'PaymentHistoryController@massDestroy')->name('payment-histories.massDestroy');
    Route::resource('payment-histories', 'PaymentHistoryController');

    // Equipment Delivery Schedules
    Route::delete('equipment-delivery-schedules/destroy', 'EquipmentDeliveryScheduleController@massDestroy')->name('equipment-delivery-schedules.massDestroy');
    Route::resource('equipment-delivery-schedules', 'EquipmentDeliveryScheduleController');

    // Sub Com Installations
    Route::delete('sub-com-installations/destroy', 'SubComInstallationController@massDestroy')->name('sub-com-installations.massDestroy');
    Route::resource('sub-com-installations', 'SubComInstallationController');

    // Sub Companies
    Route::delete('sub-companies/destroy', 'SubCompanyController@massDestroy')->name('sub-companies.massDestroy');
    Route::resource('sub-companies', 'SubCompanyController');

    // Sub Com Connectors
    Route::delete('sub-com-connectors/destroy', 'SubComConnectorController@massDestroy')->name('sub-com-connectors.massDestroy');
    Route::resource('sub-com-connectors', 'SubComConnectorController');

    // In House Installations
    Route::get('in-house-installations/current-projects', 'InHouseInstallationController@currentProjects')->name('in-house-installations.current-projects');
    Route::delete('in-house-installations/destroy', 'InHouseInstallationController@massDestroy')->name('in-house-installations.massDestroy');
    Route::post('in-house-installations/media', 'InHouseInstallationController@storeMedia')->name('in-house-installations.storeMedia');
    Route::resource('in-house-installations', 'InHouseInstallationController');

    Route::get('/sale-contracts/{sale_contract}/in-house-installations/{in_house_installation}/docs/index', 'InHouseInstallationController@viewDocs')->name('sale-contracts.in-house-installation.docs.index');

    // Installation Progresses
    Route::delete('installation-progresses/destroy', 'InstallationProgressController@massDestroy')->name('installation-progresses.massDestroy');
    Route::resource('installation-progresses', 'InstallationProgressController');

    // Material Delivery Progresses
    Route::delete('material-delivery-progresses/destroy', 'MaterialDeliveryProgressController@massDestroy')->name('material-delivery-progresses.massDestroy');
    Route::resource('material-delivery-progresses', 'MaterialDeliveryProgressController');

    // Hand Over Pdfs
    // Route::delete('hand-over-pdfs/destroy', 'HandOverPdfController@massDestroy')->name('hand-over-pdfs.massDestroy');
    // Route::post('hand-over-pdfs/media', 'HandOverPdfController@storeMedia')->name('hand-over-pdfs.storeMedia');
    // Route::resource('hand-over-pdfs', 'HandOverPdfController');
    Route::get('/in-house-installations/{in_house_installation}/hand-over-pdfs/create', 'HandOverPdfController@create')->name('in-house-installations.hand-over-pdfs.create');
    Route::post('/in-house-installations/{in_house_installation}/hand-over-pdfs/create', 'HandOverPdfController@store')->name('in-house-installations.hand-over-pdfs.store');

    // Servicing Teams
    Route::delete('servicing-teams/destroy', 'ServicingTeamController@massDestroy')->name('servicing-teams.massDestroy');
    Route::resource('servicing-teams', 'ServicingTeamController');

    // Inhouse Installation Teams
    Route::delete('inhouse-installation-teams/destroy', 'InhouseInstallationTeamController@massDestroy')->name('inhouse-installation-teams.massDestroy');
    Route::resource('inhouse-installation-teams', 'InhouseInstallationTeamController');

    // On Calls
    Route::delete('on-calls/destroy', 'OnCallController@massDestroy')->name('on-calls.massDestroy');
    Route::resource('on-calls', 'OnCallController');
    Route::get('select-sale-contract', 'OnCallController@selectSaleContract');

    // Service Types
    Route::delete('service-types/destroy', 'ServiceTypeController@massDestroy')->name('service-types.massDestroy');
    Route::resource('service-types', 'ServiceTypeController');

    // Servicings
    // Route::get('servicing', 'ServicingController@index')->name('servicing.index');

    // Servicing Setups
    Route::delete('servicing-setups/destroy', 'ServicingSetupController@massDestroy')->name('servicing-setups.massDestroy');
    Route::post('servicing-setups/media', 'ServicingSetupController@storeMedia')->name('servicing-setups.storeMedia');
    Route::get('servicing-setups/{servicing_setup}/maintenance/start', 'ServicingSetupController@startMaintenance')->name('servicing-setups.startMaintenance');
    Route::resource('servicing-setups', 'ServicingSetupController');

    // Servicing Complementaries
    Route::delete('servicing-complementaries/destroy', 'ServicingComplementaryController@massDestroy')->name('servicing-complementaries.massDestroy');
    Route::get('servicing-complementaries/servicing-setups', 'ServicingComplementaryController@showServicingSetup')->name('servicingComplementaries.showServicingSetup');
    Route::resource('servicing-complementaries', 'ServicingComplementaryController');

    // Servicing Contracts
    Route::delete('servicing-contracts/destroy', 'ServicingContractController@massDestroy')->name('servicing-contracts.massDestroy');
    Route::get('servicing-contracts/servicing-setups', 'ServicingContractController@showServicingSetup')->name('servicingContracts.showServicingSetup');
    Route::resource('servicing-contracts', 'ServicingContractController');

    //Service Calls
    Route::get('service-calls', 'ServiceCallController@index')->name('serviceCalls.index');

    // Servicing Team Connectors
    Route::delete('servicing-team-connectors/destroy', 'ServicingTeamConnectorController@massDestroy')->name('servicing-team-connectors.massDestroy');
    Route::resource('servicing-team-connectors', 'ServicingTeamConnectorController');

    // Warranty Claim Actions
    Route::delete('warranty-claim-actions/destroy', 'WarrantyClaimActionController@massDestroy')->name('warranty-claim-actions.massDestroy');
    Route::post('warranty-claim-actions/media', 'WarrantyClaimActionController@storeMedia')->name('warranty-claim-actions.storeMedia');
    Route::resource('warranty-claim-actions', 'WarrantyClaimActionController');

    Route::get('/warranty-claim-actions/{warranty_claim_action}/pdfs/create', 'WarrantyClaimActionController@createPdfs')->name('warranty-claim-actions.pdfs.create');
    Route::post('/warranty-claim-actions/{warranty_claim_action}/pdfs', 'WarrantyClaimActionController@storePdfs')->name('warranty-claim-actions.pdfs.store');

    // Repair Teams
    Route::delete('repair-teams/destroy', 'RepairTeamController@massDestroy')->name('repair-teams.massDestroy');
    Route::resource('repair-teams', 'RepairTeamController');

    // Warranty Claim Validations
    Route::delete('warranty-claim-validations/destroy', 'WarrantyClaimValidationController@massDestroy')->name('warranty-claim-validations.massDestroy');
    Route::resource('warranty-claim-validations', 'WarrantyClaimValidationController');

    Route::post('/warranty-claims/{warranty_claim}/warranty-claim-validations/create', 'WarrantyClaimValidationController@store')->name('warranty-claims.warranty-claim-validations.store');

    // Warranty Claims
    Route::delete('warranty-claims/destroy', 'WarrantyClaimController@massDestroy')->name('warranty-claims.massDestroy');
    Route::post('warranty-claims/media', 'WarrantyClaimController@storeMedia')->name('warranty-claims.storeMedia');
    Route::get('warranty-claims/{warranty_claim}/replace-pdf', 'WarrantyClaimController@pdfEdit')->name('warranty-claims.editPdf');
    Route::resource('warranty-claims', 'WarrantyClaimController');

    Route::get('/warranty-claims/{warranty_claim}/warranty-claim-actions/create', 'WarrantyClaimActionController@create')->name('warranty-claims.warranty-claim-actions.create');
    Route::post('/warranty-claims/{warranty_claim}/warranty-claim-actions', 'WarrantyClaimActionController@store')->name('warranty-claims.warranty-claim-actions.store');

    /**
     * upload warranty claim pdf
     */
    Route::post('/warranty-claims/{warranty_claim}/warranty-claim-pdf/update', 'WarrantyClaimController@uploadPdf')->name('warranty-claims.upload-pdf');

    // Warrantyaction Team Connectors
    Route::delete('warrantyaction-team-connectors/destroy', 'WarrantyactionTeamConnectorController@massDestroy')->name('warrantyaction-team-connectors.massDestroy');
    Route::resource('warrantyaction-team-connectors', 'WarrantyactionTeamConnectorController');

    // Repairs
    Route::delete('repairs/destroy', 'RepairController@massDestroy')->name('repairs.massDestroy');
    Route::post('repairs/media', 'RepairController@storeMedia')->name('repairs.storeMedia');
    Route::resource('repairs', 'RepairController');

    /**
     * Actual Action
     */
    Route::get('/repairs/{repair}/actual-action/create', 'RepairController@createActualActionData')->name('repairs.actual-action');
    Route::post('/repairs/{repair}/actual-action/create', 'RepairController@storeActualActionData')->name('repairs.actual-action');

    Route::get('/servicing-setups/{servicing_setup}/actual-action/create', 'ServicingSetupController@createActualActionData')->name('servicing-setups.actual-action');
    Route::post('/servicing-setups/{servicing_setup}/actual-action/create', 'ServicingSetupController@storeActualActionData')->name('servicing-setups.actual-action');

    Route::post('/servicing-setups/{servicing_setup}/remarks/store', 'ServicingSetupController@storeRemark')->name('servicing-setups-remarks.store');
    Route::post('/repairs/{repair}/remarks/create', 'RepairController@storeRemark')->name('repairs.remarks.create');

    // Repair Team Connectors
    Route::delete('repair-team-connectors/destroy', 'RepairTeamConnectorController@massDestroy')->name('repair-team-connectors.massDestroy');
    Route::resource('repair-team-connectors', 'RepairTeamConnectorController');

    // Branches
    Route::delete('branches/destroy', 'BranchController@massDestroy')->name('branches.massDestroy');
    Route::resource('branches', 'BranchController');

    // User Branch Connectors
    Route::delete('user-branch-connectors/destroy', 'UserBranchConnectorController@massDestroy')->name('user-branch-connectors.massDestroy');
    Route::resource('user-branch-connectors', 'UserBranchConnectorController');

    // Reminders
    Route::delete('reminders/destroy', 'ReminderController@massDestroy')->name('reminders.massDestroy');
    Route::resource('reminders', 'ReminderController');

    // Reminder Trashes
    Route::delete('reminder-trashes/destroy', 'ReminderTrashController@massDestroy')->name('reminder-trashes.massDestroy');
    Route::resource('reminder-trashes', 'ReminderTrashController');

    // Servicing Setup Remarks
    Route::delete('servicing-setup-remarks/destroy', 'ServicingSetupRemarkController@massDestroy')->name('servicing-setup-remarks.massDestroy');
    Route::resource('servicing-setup-remarks', 'ServicingSetupRemarkController');

    // Warranty Claim Remarks
    Route::delete('warranty-claim-remarks/destroy', 'WarrantyClaimRemarkController@massDestroy')->name('warranty-claim-remarks.massDestroy');
    Route::resource('warranty-claim-remarks', 'WarrantyClaimRemarkController');

    // Repair Remarks
    Route::delete('repair-remarks/destroy', 'RepairRemarkController@massDestroy')->name('repair-remarks.massDestroy');
    Route::resource('repair-remarks', 'RepairRemarkController');

    // Statuses
    Route::delete('statuses/destroy', 'StatusController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusController');


    //reminder types
    Route::resource('reminder-types', 'ReminderTypeController');

    //remaining jobs
    Route::resource('remaining-jobs', 'RemainingJobController');

    //reminder types
    Route::resource('who-to-reminds', 'WhoToRemindController');

    // Excel Export
    Route::get('/excel-exports', 'ExcelExportController@index')->name('excel-exports');
    Route::get('/excel-exports/sale-contracts', 'ExcelExportController@saleContracts')->name('excel-exports.sale-contracts');
    Route::get('/excel-exports/remaining-jobs', 'ExcelExportController@remainingJobs')->name('excel-exports.remaining-jobs');

});
