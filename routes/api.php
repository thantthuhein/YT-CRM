<?php

use App\Http\Controllers\Api\V1\Admin\EnquiriesApiController;

   Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
      //check company and project are same
      Route::get('checkCompanyAndProject', 'CompanyApiController@checkCompanyAndProject');

       Route::get('searchCustomer', 'CustomerApiController@searchCustomer');

       Route::get('searchCompany','CompanyApiController@searchCompany');
    //    Route::get('searchEnquiry','EnquiriesApiController@searchEnquiry');
       Route::get('getCustomerPhone','CustomerPhoneApiController@getCustomerPhone');
    //    Route::get('getEnquiriesBasedOnType','EnquiriesApiController@getEnquiries');

    Route::post('/hand-over-checklist/{hand_over_checklist}/toggle-necessary', 'HandOverChecklistApiController@toggleNecessary');

    /**
     * Get customer related sale contracts
     */
    Route::post('/customers/{customer}/sale-contracts', 'CustomerApiController@saleContracts');

    // Customers
    Route::apiResource('customers', 'CustomerApiController');
   });


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Enquiries Types
    Route::apiResource('enquiries-types', 'EnquiriesTypeApiController');

    // Companies
    Route::apiResource('companies', 'CompanyApiController');

    // Customer Emails
    Route::apiResource('customer-emails', 'CustomerEmailApiController');

    // Customer Phones
    Route::apiResource('customer-phones', 'CustomerPhoneApiController');

    // Type Of Sales
    Route::apiResource('type-of-sales', 'TypeOfSalesApiController');

    // Staff
    Route::apiResource('staff', 'StaffApiController');

    // Projects
    Route::apiResource('projects', 'ProjectApiController');

    // Enquiries
    Route::apiResource('enquiries', 'EnquiriesApiController');

    // Aircon Types
    Route::apiResource('aircon-types', 'AirconTypeApiController');

    // Aircon Type Connectors
    Route::apiResource('aircon-type-connectors', 'AirconTypeConnectorApiController');

    // Quotations
    Route::apiResource('quotations', 'QuotationApiController');

    // Quotation Revisions
    Route::post('quotation-revisions/media', 'QuotationRevisionApiController@storeMedia')->name('quotation-revisions.storeMedia');
    Route::apiResource('quotation-revisions', 'QuotationRevisionApiController');

    // Follow Ups
    Route::apiResource('follow-ups', 'FollowUpApiController');

   //Overview Get Data
   Route::get('overall-data/{months}', 'HomeApiController@getData');

    //Our Growth 
    Route::get('get-our-growth-by-month-data', 'HomeApiController@getOurGrowthByMonthData');
    Route::get('get-our-growth-by-year-data', 'HomeApiController@getOurGrowthByYearData');


    // Sale Contracts
    Route::get('completed-sale-contracts-by-month', 'SaleContractApiController@getCompletedSaleContractsByMonth');
    Route::apiResource('sale-contracts', 'SaleContractApiController');

    // Sale Contract Pdfs
    Route::post('sale-contract-pdfs/media', 'SaleContractPdfApiController@storeMedia')->name('sale-contract-pdfs.storeMedia');
    Route::apiResource('sale-contract-pdfs', 'SaleContractPdfApiController');

    // Payment Histories
    Route::apiResource('payment-histories', 'PaymentHistoryApiController');

    // Equipment Delivery Schedules
    Route::apiResource('equipment-delivery-schedules', 'EquipmentDeliveryScheduleApiController');

    // Sub Com Installations
    Route::apiResource('sub-com-installations', 'SubComInstallationApiController');

    // Sub Companies
    Route::apiResource('sub-companies', 'SubCompanyApiController');

    // Sub Com Connectors
    Route::apiResource('sub-com-connectors', 'SubComConnectorApiController');

    // In House Installations
    Route::post('in-house-installations/media', 'InHouseInstallationApiController@storeMedia')->name('in-house-installations.storeMedia');
    Route::apiResource('in-house-installations', 'InHouseInstallationApiController');

    // Installation Progresses
    Route::apiResource('installation-progresses', 'InstallationProgressApiController');

    // Material Delivery Progresses
    Route::apiResource('material-delivery-progresses', 'MaterialDeliveryProgressApiController');

    // Hand Over Pdfs
    Route::post('hand-over-pdfs/media', 'HandOverPdfApiController@storeMedia')->name('hand-over-pdfs.storeMedia');
    Route::apiResource('hand-over-pdfs', 'HandOverPdfApiController');

    // Servicing Teams
    Route::apiResource('servicing-teams', 'ServicingTeamApiController');

    // Inhouse Installation Teams
    Route::apiResource('inhouse-installation-teams', 'InhouseInstallationTeamApiController');

    // On Calls
    Route::apiResource('on-calls', 'OnCallApiController');

    // Service Types
    Route::apiResource('service-types', 'ServiceTypeApiController');

    // Servicing Setups
    Route::post('servicing-setups/media', 'ServicingSetupApiController@storeMedia')->name('servicing-setups.storeMedia');
    Route::apiResource('servicing-setups', 'ServicingSetupApiController');

    // Servicing Complementaries
    Route::apiResource('servicing-complementaries', 'ServicingComplementaryApiController');

    // Servicing Contracts
    Route::apiResource('servicing-contracts', 'ServicingContractApiController');

    // Servicing Team Connectors
    Route::apiResource('servicing-team-connectors', 'ServicingTeamConnectorApiController');

    // Warranty Claim Actions
    Route::post('warranty-claim-actions/media', 'WarrantyClaimActionApiController@storeMedia')->name('warranty-claim-actions.storeMedia');
    Route::apiResource('warranty-claim-actions', 'WarrantyClaimActionApiController');

    // Repair Teams
    Route::apiResource('repair-teams', 'RepairTeamApiController');

    // Warranty Claim Validations
    Route::apiResource('warranty-claim-validations', 'WarrantyClaimValidationApiController');

    // Warranty Claims
    Route::post('warranty-claims/media', 'WarrantyClaimApiController@storeMedia')->name('warranty-claims.storeMedia');
    Route::apiResource('warranty-claims', 'WarrantyClaimApiController');

    // Warrantyaction Team Connectors
    Route::apiResource('warrantyaction-team-connectors', 'WarrantyactionTeamConnectorApiController');

    // Repairs
    Route::post('repairs/media', 'RepairApiController@storeMedia')->name('repairs.storeMedia');
    Route::apiResource('repairs', 'RepairApiController');

    // Repair Team Connectors
    Route::apiResource('repair-team-connectors', 'RepairTeamConnectorApiController');

    // Branches
    Route::apiResource('branches', 'BranchApiController');

    // User Branch Connectors
    Route::apiResource('user-branch-connectors', 'UserBranchConnectorApiController');

    // Reminders
    Route::apiResource('reminders', 'ReminderApiController');

    // Reminder Trashes
    Route::apiResource('reminder-trashes', 'ReminderTrashApiController');

    // Servicing Setup Remarks
    Route::apiResource('servicing-setup-remarks', 'ServicingSetupRemarkApiController');

    // Warranty Claim Remarks
    Route::apiResource('warranty-claim-remarks', 'WarrantyClaimRemarkApiController');

    // Repair Remarks
    Route::apiResource('repair-remarks', 'RepairRemarkApiController');

    // Statuses
    Route::apiResource('statuses', 'StatusApiController');
});
