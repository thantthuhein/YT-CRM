<aside class="main-sidebar sidebar-dark-primary elevation-4 main-font" style="height:auto;">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <span class="logo-container">
        <img src="/images/image/logo_mono.png" alt="home" width="50px" height="100%">
        <span class="logo-font-container">
            <span class="logo-font">Ywar Taw</span>
            <span class="logo-small-font">International Trading Co.,Ltd</span>
        </span>
        </span>
        <!-- <span class="">International Trading Co.,Ltd</span> -->
        <!-- <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar scrollbar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" 
                    class="nav-link {{ request()->is('admin') ? 'parent-link' : '' }}"
                    >
                    <i class="fas fa-fw fa fa-desktop">

                    </i>
                    <p>

                        <span>{{ trans('global.dashboard') }}</span>
                    </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route("admin.excel-exports") }}" 
                    class="nav-link {{ request()->is('admin/excel-exports') ? 'parent-link' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <p>

                        <span>Excel Export</span>
                    </p>
                    </a>
                </li>


                
                <li class="nav-item has-treeview {{ request()->is('admin/enquiries') || request()->is('admin/enquiries/*') || request()->is('admin/on-calls') || request()->is('admin/on-calls/*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fas fa-fw  fa-phone-volume">

                            </i>
                            <p>
                                <span>{{ trans('cruds.enquiry.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('enquiry_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.enquiries.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/enquiries') || request()->is('admin/enquiries/*') ? 'active' : '' }}">
                                        <i class="fa fa-caret-right">

                                        </i>
                                        <p>
                                            <span>Sales {{ trans('cruds.enquiry.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('on_call_access')
                                <li class="nav_item">
                                    <a href="{{ route("admin.on-calls.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/on-calls') || request()->is('admin/on-calls/*') ? 'active' : '' }}">
                                    <i class="fa fa-caret-right">

                                    </i>
                                    <p>
                                        <span>Service {{ trans('cruds.enquiry.title') }}</span>

                                    </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                </li>
                @can('quotation_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.quotations.index") }}" 
                        class="nav-link {{ request()->is('admin/quotations') || request()->is('admin/quotations/*') ? 'parent-link' : '' }}"
                        >
                            <i class="fa-fw far fa-file fa-rotate-180">

                            </i>
                            <p>
                                <span>{{ trans('cruds.quotation.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('sale_contract_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sale-contracts.index") }}" class="nav-link {{ request()->is('admin/sale-contracts') || request()->is('admin/sale-contracts/*') ? 'parent-link' : '' }}">
                            <i class="fas fa-fw fa fa-edit">

                            </i>
                            <p>
                                <span>{{ trans('cruds.saleContract.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('in_house_installation_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.in-house-installations.index") }}" class="nav-link {{ request()->is('admin/in-house-installations') || request()->is('admin/in-house-installations/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw fas fa-wrench">

                            </i>
                            <p>
                                <span>{{ trans('cruds.inHouseInstallation.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('repair_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.repairs.index") }}" class="nav-link {{ request()->is('admin/repairs') || request()->is('admin/repairs/*') ? 'parent-link' : '' }}">
                            <i class="fas fa-fw  fa-sliders-h">

                            </i>
                            <p>
                                <span>{{ trans('cruds.repair.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('servicing_complementary_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/servicing-complementaries') || request()->is('admin/servicing-complementaries/*') || request()->is('admin/servicing-contracts') || request()->is('admin/servicing-contracts/*') || request()->is('admin/service-calls') || request()->is('admin/service-calls/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fa-fw fas fa-cog">

                            </i>
                            <p>
                                <span>{{ trans('cruds.servicingComplementary.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route("admin.servicing-complementaries.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/servicing-complementaries') || request()->is('admin/servicing-complementaries/*') ? 'active' : '' }}">
                                    <i class="fa fa-caret-right">

                                    </i>
                                    <p>
                                        Complementaries
                                    </p>
                                </a>
                            </li>
                            <li class="nav_item">
                                <a href="{{ route("admin.servicing-contracts.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/servicing-contracts') || request()->is('admin/servicing-contracts/*') ? 'active' : '' }}">
                                <i class="fa fa-caret-right">

                                </i>
                                <p>
                                    Contracts
                                </p>
                                </a>
                            </li>
                            <li class="nav_item">
                                <a href="{{ route('admin.serviceCalls.index') }}" 
                                class="menu-link second-nav nav-link {{ request()->is('admin/service-calls') || request()->is('admin/service-calls/*') ? 'active' : '' }}">
                                <i class="fa fa-caret-right">

                                </i>
                                <p>
                                    Service Calls
                                </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('servicing_setup_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.servicing-setups.index") }}" class="nav-link {{ request()->is('admin/servicing-setups') || request()->is('admin/servicing-setups/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw fas fa-cog">

                            </i>
                            <p>
                                <span>Maintenance</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('warranty_claim_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.warranty-claims.index") }}" class="nav-link {{ request()->is('admin/warranty-claims') || request()->is('admin/warranty-claims/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.warrantyClaim.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                {{-- @can('reminder_type_access') --}}
                    <li class="nav-item">
                        <a href="{{ route("admin.reminder-types.index") }}" class="nav-link {{ request()->is('admin/reminder-types') || request()->is('admin/reminder-types/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>Reminder Types</span>
                            </p>
                        </a>
                    </li>
                {{-- @endcan --}}

                 {{-- @can('reminder_type_access') --}}
                    <li class="nav-item">
                        <a href="{{ route("admin.remaining-jobs.index") }}" class="nav-link {{ request()->is('admin/remaining-jobs') || request()->is('admin/remaining-jobs/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>Remaining Jobs</span>
                            </p>
                        </a>
                    </li>
                {{-- @endcan --}}

                {{-- @can('warranty_claim_action_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.warranty-claim-actions.index") }}" class="nav-link {{ request()->is('admin/warranty-claim-actions') || request()->is('admin/warranty-claim-actions/*') ? 'active' : '' }}">
                            <i class="fa-fw far fa-check-circle">

                            </i>
                            <p>
                                <span>{{ trans('cruds.warrantyClaimAction.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan --}}

                @can('customer_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.customers.index") }}" class="nav-link {{ request()->is('admin/customers') || request()->is('admin/customers/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw far fa-user">

                            </i>
                            <p>
                                <span>{{ trans('cruds.customer.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item has-treeview 
                {{ request()->is('admin/sub-companies') || request()->is('admin/inhouse-installation-teams') || request()->is('admin/repair-teams') || request()->is('admin/sub-companies/*') || request()->is('admin/inhouse-installation-teams/*') || request()->is('admin/repair-teams/*') || request()->is('admin/servicing-teams') || request()->is('admin/servicing-teams/*') ? 'menu-open' : '' }}
                "
                >
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-share-alt">

                            </i>
                            <p>
                                <span>{{ trans('cruds.servicingTeam.team') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">                            
                        @can('servicing_team_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.servicing-teams.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/servicing-teams') || request()->is('admin/servicing-teams/*') ? 'active' : '' }}">
                                    <i class="fa fa-caret-right">

                                    </i>
                                    <p>
                                        <span>{{ trans('cruds.servicingTeam.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        {{-- @can('inhouse_installation_team_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.inhouse-installation-teams.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/inhouse-installation-teams') || request()->is('admin/inhouse-installation-teams/*') ? 'active' : '' }}">
                                    <i class="fa fa-caret-right">

                                    </i>
                                    <p>
                                        <span>{{ trans('cruds.inhouseInstallationTeam.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan --}}
                        @can('sub_company_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.sub-companies.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/sub-companies') || request()->is('admin/sub-companies/*') ? 'active' : '' }}">
                                    <i class="fa fa-caret-right">

                                    </i>
                                    <p>
                                        <span>{{ trans('cruds.subCompany.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('repair_team_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.repair-teams.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/repair-teams') || request()->is('admin/repair-teams/*') ? 'active' : '' }}">
                                    <i class="fa fa-caret-right">

                                    </i>
                                    <p>
                                        <span>{{ trans('cruds.repairTeam.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        </ul>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-folder-open">

                            </i>
                            <p>
                                <span>{{ trans('cruds.userManagement.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.permission.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-briefcase">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.role.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="menu-link second-nav nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.user.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
         
                {{-- @can('company_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.companies.index") }}" class="nav-link {{ request()->is('admin/companies') || request()->is('admin/companies/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.company.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
 
                @can('customer_email_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.customer-emails.index") }}" class="nav-link {{ request()->is('admin/customer-emails') || request()->is('admin/customer-emails/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.customerEmail.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('customer_phone_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.customer-phones.index") }}" class="nav-link {{ request()->is('admin/customer-phones') || request()->is('admin/customer-phones/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.customerPhone.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('enquiries_type_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.enquiries-types.index") }}" class="nav-link {{ request()->is('admin/enquiries-types') || request()->is('admin/enquiries-types/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.enquiriesType.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('type_of_sale_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.type-of-sales.index") }}" class="nav-link {{ request()->is('admin/type-of-sales') || request()->is('admin/type-of-sales/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.typeOfSale.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('staff_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.staff.index") }}" class="nav-link {{ request()->is('admin/staff') || request()->is('admin/staff/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.staff.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('project_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.projects.index") }}" class="nav-link {{ request()->is('admin/projects') || request()->is('admin/projects/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.project.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('aircon_type_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.aircon-types.index") }}" class="nav-link {{ request()->is('admin/aircon-types') || request()->is('admin/aircon-types/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.airconType.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('quotation_revision_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.quotation-revisions.index") }}" class="nav-link {{ request()->is('admin/quotation-revisions') || request()->is('admin/quotation-revisions/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.quotationRevision.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('follow_up_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.follow-ups.index") }}" class="nav-link {{ request()->is('admin/follow-ups') || request()->is('admin/follow-ups/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.followUp.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('sale_contract_pdf_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.sale-contract-pdfs.index") }}" class="nav-link {{ request()->is('admin/sale-contract-pdfs') || request()->is('admin/sale-contract-pdfs/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.saleContractPdf.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('payment_history_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.payment-histories.index") }}" class="nav-link {{ request()->is('admin/payment-histories') || request()->is('admin/payment-histories/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.paymentHistory.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('equipment_delivery_schedule_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.equipment-delivery-schedules.index") }}" class="nav-link {{ request()->is('admin/equipment-delivery-schedules') || request()->is('admin/equipment-delivery-schedules/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.equipmentDeliverySchedule.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan --}}                                                
                
                {{-- @can('installation_progress_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.installation-progresses.index") }}" class="nav-link {{ request()->is('admin/installation-progresses') || request()->is('admin/installation-progresses/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.installationProgress.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('material_delivery_progress_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.material-delivery-progresses.index") }}" class="nav-link {{ request()->is('admin/material-delivery-progresses') || request()->is('admin/material-delivery-progresses/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.materialDeliveryProgress.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('hand_over_pdf_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.hand-over-pdfs.index") }}" class="nav-link {{ request()->is('admin/hand-over-pdfs') || request()->is('admin/hand-over-pdfs/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.handOverPdf.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan --}}
               
                {{-- @can('service_type_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.service-types.index") }}" class="nav-link {{ request()->is('admin/service-types') || request()->is('admin/service-types/*') ? 'parent-link' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.serviceType.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan --}}
                
                {{-- @can('servicing_setup_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.servicing-setups.index") }}" class="nav-link {{ request()->is('admin/servicing-setups') || request()->is('admin/servicing-setups/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.servicingSetup.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

                @can('servicing_contract_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.servicing-contracts.index") }}" class="nav-link {{ request()->is('admin/servicing-contracts') || request()->is('admin/servicing-contracts/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.servicingContract.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan

               
                @can('warranty_claim_validation_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.warranty-claim-validations.index") }}" class="nav-link {{ request()->is('admin/warranty-claim-validations') || request()->is('admin/warranty-claim-validations/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.warrantyClaimValidation.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan--}}
                {{--@can('dashboard_site_configuration_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/repairs*') ? 'menu-open' : '' }} {{ request()->is('admin/branches*') ? 'menu-open' : '' }} {{ request()->is('admin/reminders*') ? 'menu-open' : '' }} {{ request()->is('admin/reminder-trashes*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.dashboardSiteConfiguration.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            
                            @can('branch_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.branches.index") }}" class="nav-link {{ request()->is('admin/branches') || request()->is('admin/branches/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.branch.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('reminder_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.reminders.index") }}" class="nav-link {{ request()->is('admin/reminders') || request()->is('admin/reminders/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.reminder.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('reminder_trash_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.reminder-trashes.index") }}" class="nav-link {{ request()->is('admin/reminder-trashes') || request()->is('admin/reminder-trashes/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.reminderTrash.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('dashboard_connector_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/aircon-type-connectors*') ? 'menu-open' : '' }} {{ request()->is('admin/sub-com-connectors*') ? 'menu-open' : '' }} {{ request()->is('admin/servicing-team-connectors*') ? 'menu-open' : '' }} {{ request()->is('admin/warrantyaction-team-connectors*') ? 'menu-open' : '' }} {{ request()->is('admin/repair-team-connectors*') ? 'menu-open' : '' }} {{ request()->is('admin/user-branch-connectors*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.dashboardConnector.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('aircon_type_connector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.aircon-type-connectors.index") }}" class="nav-link {{ request()->is('admin/aircon-type-connectors') || request()->is('admin/aircon-type-connectors/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.airconTypeConnector.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('sub_com_connector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.sub-com-connectors.index") }}" class="nav-link {{ request()->is('admin/sub-com-connectors') || request()->is('admin/sub-com-connectors/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.subComConnector.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('servicing_team_connector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.servicing-team-connectors.index") }}" class="nav-link {{ request()->is('admin/servicing-team-connectors') || request()->is('admin/servicing-team-connectors/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.servicingTeamConnector.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('warrantyaction_team_connector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.warrantyaction-team-connectors.index") }}" class="nav-link {{ request()->is('admin/warrantyaction-team-connectors') || request()->is('admin/warrantyaction-team-connectors/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.warrantyactionTeamConnector.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('repair_team_connector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.repair-team-connectors.index") }}" class="nav-link {{ request()->is('admin/repair-team-connectors') || request()->is('admin/repair-team-connectors/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.repairTeamConnector.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_branch_connector_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.user-branch-connectors.index") }}" class="nav-link {{ request()->is('admin/user-branch-connectors') || request()->is('admin/user-branch-connectors/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.userBranchConnector.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('status_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.statuses.index") }}" class="nav-link {{ request()->is('admin/statuses') || request()->is('admin/statuses/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.status.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('dashboard_remark_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/servicing-setup-remarks*') ? 'menu-open' : '' }} {{ request()->is('admin/warranty-claim-remarks*') ? 'menu-open' : '' }} {{ request()->is('admin/repair-remarks*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.dashboardRemark.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('servicing_setup_remark_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.servicing-setup-remarks.index") }}" class="nav-link {{ request()->is('admin/servicing-setup-remarks') || request()->is('admin/servicing-setup-remarks/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.servicingSetupRemark.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('warranty_claim_remark_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.warranty-claim-remarks.index") }}" class="nav-link {{ request()->is('admin/warranty-claim-remarks') || request()->is('admin/warranty-claim-remarks/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.warrantyClaimRemark.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('repair_remark_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.repair-remarks.index") }}" class="nav-link {{ request()->is('admin/repair-remarks') || request()->is('admin/repair-remarks/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-cogs">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.repairRemark.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan --}}
                <li class="nav-item mb-5">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="fas fa-fw fa-sign-out-alt">

                        </i>
                        <p>

                            <span>{{ trans('global.logout') }}</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>