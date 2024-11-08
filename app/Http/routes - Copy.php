<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
  
 */
Route::auth();

Route::get('clear_config', ['as' => 'utility.clear.cache', 'uses' => 'UtilityController@clear_cache']);

//EBINHI Survey    
    Route::post('ebinhi/survey/check_id', ['as' => 'ebinhi.survey.answer', 'uses' => 'PayMayaController@check_ph_id']);
    Route::post('ebinhi/survey', ['as' => 'ebinhi.survey', 'uses' => 'PayMayaController@check_code_survey']);
    Route::get('ebinhi/survey/questions/{api_key}', ['as' => 'ebinhi.survey.questions', 'uses' => 'PayMayaController@survey_question']);
    Route::post('ebinhi/survey/answer', ['as' => 'ebinhi.survey.answer', 'uses' => 'PayMayaController@survey_answer']);

  


/** SAMPLE QR CODES for EXTENSION **/
Route::get('qr_extension', ['as' => 'extension.qr.home', 'uses'=>'FarmerIDController@extension_qr']);

/* ROUTES FOR MOBILE APPLICATION FETCHING AND SENDING DATA */
Route::get('check-farmer-allocation/{distribution_id}', ['as' => 'releasing.check_farmer_allocation', 'uses' => 'ReleasingController@farmer_allocation']);
Route::get('get-csrf-token', ['as' => 'releasing.get_csrf_token', 'uses' => 'ReleasingController@get_csrf_token']);
Route::get('api/get-seedtag/{token}', ['as' => 'api.get_seedtag', 'uses' => 'APIController@get_seedtags']);
Route::get('api/get-seedtag_api/{season}/{year}/{token}', ['as' => 'api.get_seedtag', 'uses' => 'APIController@get_seedtags_api']);
Route::post('release-seeds', ['as' => 'releasing.release_seeds', 'uses' => 'ReleasingController@release_seeds']);
Route::get('release-seeds/{distribution_id}/{username}', ['as' => 'releasing.release_seeds2', 'uses' => 'ReleasingController@release_seeds2']);
Route::get('release-seeds-ws/{distribution_id}/{username}', ['as' => 'releasingws.release_seeds2', 'uses' => 'ReleasingWsController@release_seeds2']);
Route::get('write-dropoff/{prvCode}/{coopAccreditation}/{dropoffpoint}/{createdBy}', ['as' => 'releasing.write_dropoff', 'uses' => 'ReleasingController@write_dropoff']);
Route::post('connect/get_dropoffpoints', ['as' => 'connect.get_dropoffpoints', 'uses' => 'ConnectController@get_dropoffpoints']);
Route::post('connect/get_coops', ['as' => 'connect.get_coops', 'uses' => 'ConnectController@get_coops']);
Route::post('api/moet/receive/datasets', ['as' => 'api.moet.rceive_datasets', 'uses' => 'ConnectController@receive_moet_data']);

//sub-server to central syncing
Route::post('sync/sub_server/area_history', ['as' => 'sync.sub_server.area_history', 'uses' => 'SubServerController@sync_area_history']);
Route::post('sync/sub_server/farmer_profile', ['as' => 'sync.sub_server.farmer_profile', 'uses' => 'SubServerController@sync_farmer_profile']);
Route::post('sync/sub_server/other_info', ['as' => 'sync.sub_server.other_info', 'uses' => 'SubServerController@sync_other_info']);
Route::post('sync/sub_server/pending_release', ['as' => 'sync.sub_server.pending_release', 'uses' => 'SubServerController@sync_pending_release']);
Route::post('sync/sub_server/performance', ['as' => 'sync.sub_server.performance', 'uses' => 'SubServerController@sync_performance']);
Route::post('sync/sub_server/released', ['as' => 'sync.sub_server.released', 'uses' => 'SubServerController@sync_released']);

//transfer of distribution data
Route::post('transfer/dropoff', ['as' => 'transfer.dropoff', 'uses' => 'TransferController@central_transfer_dropoffs']);
Route::get('api/calendar/events/{api}/{type}', ['as' => 'api.calendar.events', 'uses' => 'websiteController@calendarEvents']);

//get photos tagged to rsbsa_control_no API
Route::post('farmer_profile/get_photo', ['as' => 'farmer.get_photo', 'uses' => 'APIController@get_farmer_photo']);
/**
 * ADD TO MIDNIGHT REPORTS
 */
Route::get('report/excel/scheduled/list', ['as' => 'rcef.report.excel.scheduled_list', 'uses'=>'ReportExportController@scheduled_list']);
Route::get('analytics/execute_report/variety', ['as' => 'analytics.execute_report.variety', 'uses' => 'AnalyticsController@execute_night_reports_variety']);
Route::get('analytics/variety/{prv_db}', ['as' => 'analytics.variety.prv', 'uses' => 'AnalyticsController@execute_reports_variety']);
/**
 * WS2021 new API List
 */
Route::post('api/transfer/insert', ['as' => 'api.transfer.insert', 'uses'=>'APIController@InsertTransferData']);
Route::get('api/far/{province}/{municipality}/{skip}/{take}', ['as' => 'api.far', 'uses'=>'APIController@getFARDetails']);
Route::get('api/far/prev/{province}/{municipality}/{brgy}/{skip}/{take}', ['as' => 'api.far.ps', 'uses'=>'APIController@getFARDetailsPS']);
Route::get('api/rcef_users/{api_key}', ['as' => 'api.rcef_users', 'uses'=>'APIController@load_rcef_users']);

Route::get('flsar/excel/{prv}', ['as' => 'pre_list.excel', 'uses' => 'FLSARController@generate_municipality_excel']);
Route::get('farmer/pre_list/all/{province}', ['as' => 'pre_list.all', 'uses' => 'FLSARController@generate_municipality_serverSide']);
Route::get('farmer/pre_list/all/{province}/{municipality}/{skip}/{take}', ['as' => 'pre_list.all.municipality', 'uses' => 'FLSARController@generate_Provincemunicipality_serverSide']);
Route::get('farmer/prv/{prv}', ['as' => 'pre_list.all.prv', 'uses' => 'FLSARController@generate_flsar_prv_id']);

// #newapi - all in one app & PhilRice IS
Route::post('api/get/commitment/regional', ['as' => 'api.commitment.regional', 'uses'=>'API@commitmentByRegion']);
Route::post('api/insert/dop', ['as' => 'api.insert.dop', 'uses'=>'API@insert_dropoff']);
Route::post('api/insert/delivery/schedule', ['as' => 'api.insert.delivery.schedule', 'uses'=>'API@insert_delivery_schedule']);
Route::get('api/municipality/yield', ['as' => 'api.municipality.yield', 'uses'=>'API@mun_farmers_yield']);
Route::get('api/bdd/sg_list/{api_key}', ['as' => 'api.bdd.sg_list', 'uses'=>'APIController@api_bdd_sgList']);
Route::get('api/municipality/yield', ['as' => 'api.municipality.yield', 'uses'=>'API@mun_farmers_yield']);
Route::get('api/dop/lib_prv', ['as' => 'api.dop.lib_prv', 'uses'=>'API@get_lib_prv']);
Route::get('api/dop/coopList', ['as' => 'api.dop.coopList', 'uses'=>'API@get_dop_coops']);

Route::post('api/all_in_one_login', ['as' => 'api.all_in_one.web', 'uses' => 'APIController@checkCredentials']);

//API for tblCommitment
Route::get('api/commitment/member/{api_key}', ['as' => 'api.commitment.member', 'uses'=>'APIController@commitment_member']);
//API FOR BREAKDOWN MOBILE APP
Route::post('api/buffer/login', ['as' => 'api.login', 'uses' => 'APIController@api_buffer_login']);
Route::get('api/fetch/buffer/batchListInfo/{api_key}/{username}', ['as' => 'api.fetch.buffer.coop', 'uses' => 'APIController@getBufferCoopBatchList']);
Route::post('api/insert/breakdown', ['as' => 'insert.breakdown.data', 'uses' => 'APIController@InsertBreakdown']);

/*VERIFIED*/
Route::get('verify/farmer/list/{region}/{province}', ['as' => 'verify.farmer.list', 'uses' => 'FarmerProfileController@farmerVerifiedList']);
//ADD RELEASED (NEW FARMER FROM OLD VERSION)
Route::get('verify/farmer/released/{region}/{province}/{municipality}', ['as' => 'verify.newfarmer.released', 'uses' => 'FarmerProfileController@releasedToVerified']);
Route::get('process/additionaldata/farmer/profile/{region}/{province}/{municipality}', ['as' => 'process.addition.profile', 'uses' => 'FarmerProfileController@farmerProfileDataPreparation']);
// for syncing offline data binhi e-padala
Route::POST('api/paymaya/fetch/data', ['as' => 'api.paymaya.fetch.data', 'uses' => 'API@fetch_sed_caller_updates' ]);
Route::POST('api/paymaya/fetch/editable', ['as' => 'api.paymaya.for.edit', 'uses' => 'API@fetch_paymaya_for_edit' ]);

//COUNT
Route::get('farmer/profile/contact/nationwide', ['as' => 'farmer_profile.with.contact.nationwide', 'uses' => 'FarmerProfileController@nationWideStat']);
Route::get('farmer/contact/nationwide/{region}', ['as' => 'farmer_profile.with.contact.region', 'uses' => 'FarmerProfileController@nationWideStatPerRegion']);

/**/
/*APP DEV API ROUTES*/
Route::get('app/api/regional/commitments/{api_key}/{coop_id}', ['as' => 'app.api.regional.commitment', 'uses' => 'app_dev_APIController@seedVarietyCommitments']);
Route::get('app/api/sg_account/{api_key}/{username}', ['as' => 'app.api.sg_account', 'uses' => 'app_dev_APIController@seedGrowerAccount']);
Route::post('app/api/login/', ['as' => 'app.api.login', 'uses' => 'app_dev_APIController@one_app_login']);
Route::post('app/api/rla_count', ['as' => 'app.api.rla_count', 'uses' => 'app_dev_APIController@rlaCount']);
// new route for SED API 08-14-2021
Route::post('sed/get/farmer/data', ['as' => 'sed.get.farmer.data', 'uses' => 'API@fetch_farmer_sed_caller']);
Route::post('sed/get/farmer/data/callback', ['as' => 'sed.get.farmer.data.callback', 'uses' => 'API@fetch_farmer_sed_caller_callback']);
// fix muncipality farmer id
Route::get('fix/farmer_id', ['as' => 'fix.farmer.id', 'uses' => 'SEDCAllerController@fix_farmer_id']);


/*APP DEV API ROUTES*/
/*MOET API*/

//MOET //
Route::post('moet_app/registration', ['as' => 'moet.web.register', 'uses' => 'moetController@user_create']);
Route::get('send/test/mail/{email}/{nameto}/{veri}', ['as' => 'send.test.mail', 'uses' => 'moetController@send_mail']);
Route::get('moet_app/view/farmer', ['as' => 'moet.web.view.farmer', 'uses' => 'moetController@viewFarmer']);
Route::post('moet_app/view/province_list', ['as' => 'moet.get.province_list', 'uses' => 'moetController@getProvinceList']);
Route::post('moet_app/view/muncipality_list', ['as' => 'moet.get.municipality_list', 'uses' => 'moetController@getMunicipalityList']);
Route::post('moet_app/view/seed_list', ['as' => 'moet.get.seed_list', 'uses' => 'moetController@getSeedList']);
Route::post('moet_app/view/loadTable', ['as' => 'moet.load_table', 'uses' => 'moetController@loadFarmerTable']);
Route::post('moet_app/update/farmer/info', ['as' => 'moet.update.farmer.info', 'uses' => 'moetController@updateFarmerInfo']);

Route::get('moet_app/map_view/farmer', ['as' => 'moet.web.map_view.farmer', 'uses' => 'moetController@map_view_ui']);
Route::post('moet_app/map_view/data', ['as' => 'moet.map_view.data', 'uses' => 'moetController@map_view_data']);
Route::post("moet_app/map_view/coordinates", ['as' => 'moet.map_view.coordinates', 'uses' => 'moetController@getCoordinates']);

Route::get('moet_app/check_db/{db}/{api}', ['as' => 'moet.check.db', 'uses' => 'moetController@view_db']);

Route::get('moet_dev', ['as' => 'moet.db.checker', 'uses' => 'moetController@viewDB']);
Route::post('getfield/moet_dev', ['as' => 'moet.get.field_column', 'uses' => 'moetController@getFields']);
Route::post('moet.db_table', ['as' => 'moet.load.db_table', 'uses' => 'moetController@dbTable']);


//EBINHI APP //
Route::get('ebinhi_app/coop_monitoring/{coop_number}/{date_from}/{date_to}', ['as' => 'ebinhi_app.monitoring_ui', 'uses' => 'API@ebinhi_coop_monitoring']);
Route::post('ebinhi_app/coop_inventory', ['as' => 'ebinhi_app.inventory', 'uses' => 'API@ebinhi_coop_inventory']);

Route::post('moet_app/login', ['as' => 'moet.web.login', 'uses' => 'moetController@user_login']);
Route::post('moet_app/data_request', ['as' => 'moet.web.data.request', 'uses' => 'moetController@dataRequest']);

//MNE_DB
Route::get('get_mne_excel', ['as' => 'mne.get_mne_excel', 'uses' => 'mne_collabController@get_mne_excel']);
Route::get('generate_mne_excel', ['as' => 'mne.generate', 'uses' => 'mne_collabController@run_on_server']);





/*WEBSITE API*/ 
Route::group(['middleware' => ['auth']], function() {
	
	Route::get('insp_monitoring', ['as' => 'monitoring_insp.index', 'uses' => 'InspmonitoringController@index']);
    Route::get('insp_monitoring/get_muni/{province}', ['as' => 'monitoring_insp.get_muni', 'uses' => 'InspmonitoringController@get_muni']);
    Route::get('insp_monitoring/get_dropoff/{province}/{municipality}', ['as' => 'monitoring_insp.get_muni', 'uses' => 'InspmonitoringController@get_dropoff_points']);
    Route::post('insp_monitoring/table_data', ['as' => 'rcef.insp_monitoring.table_data', 'uses' => 'InspmonitoringController@table_data']);
    Route::post('insp_monitoring/details', ['as' => 'inspector.monitoring.details', 'uses' => 'InspmonitoringController@get_batch_details_forMonitoring']);
    Route::post('insp_monitoring/samples', ['as' => 'inspector.monitoring.samples_tbl', 'uses' => 'InspmonitoringController@get_sample_details_forMonitoring']);
    Route::post('insp_monitoring/actual_delivery', ['as' => 'inspector.monitoring.actual_delivery', 'uses' => 'InspmonitoringController@get_actual_delivery_forMonitoring']);
    Route::post('insp_monitoring/iar/upload', ['as' => 'inspector.iar.upload', 'uses' => 'InspmonitoringController@upload_signed_iar']);
    Route::post('insp_monitoring/iar/re_upload', ['as' => 'inspector.iar.re_upload', 'uses' => 'InspmonitoringController@reupload_signed_iar']);
    Route::post('insp_monitoring/inspection_data', ['as' => 'inspector.excel.data', 'uses' => 'InspmonitoringController@inspection_data']);
	
    Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index'])->middleware('techno');
    Route::get('upcoming_harvest_10days', ['as' => 'dashboard.upcoming_harvest_10days', 'uses' => 'DashboardController@upcoming_harvest_10days']);
    Route::get('upcoming_harvest_30days', ['as' => 'dashboard.upcoming_harvest_30days', 'uses' => 'DashboardController@upcoming_harvest_30days']);
    Route::get('upcoming_harvest_weekly', ['as' => 'dashboard.upcoming_harvest_weekly', 'uses' => 'DashboardController@upcoming_harvest_weekly']);
    Route::get('upcoming_harvest_weekly_excel_all', ['as' => 'dashboard.upcoming_harvest_weekly_excel_all', 'uses' => 'DashboardController@upcoming_harvest_weekly_excel_all']);
    Route::get('upcoming_harvest_weekly_excel', ['as' => 'dashboard.upcoming_harvest_weekly_excel', 'uses' => 'DashboardController@upcoming_harvest_weekly_excel']);
    Route::post('harvest_seed_growers', ['as' => 'dashboard.harvest_seed_growers', 'uses' => 'DashboardController@harvest_seed_growers']);
    Route::get('seed_cooperatives', ['as' => 'dashboard.seed_cooperatives', 'uses' => 'DashboardController@seed_cooperatives']);
    Route::post('cooperative_municipalities', ['as' => 'dashboard.cooperative_municipalities', 'uses' => 'DashboardController@cooperative_municipalities']);
    Route::get('seed_growers', ['as' => 'dashboard.seed_growers', 'uses' => 'DashboardController@seed_growers']);
    Route::post('seed_grower_details', ['as' => 'dashboard.seed_grower_details', 'uses' => 'DashboardController@seed_grower_details']);
    Route::post('seed_grower_profile', ['as' => 'dashboard.seed_grower_profile', 'uses' => 'DashboardController@seed_grower_profile']);

	Route::get('dashboard/delivery_summary', ['as' => 'dashboard.delivery_summary', 'uses' => 'DashboardController@show_delivery_summary']);
	Route::post('dashboard/delivery_schedule', ['as' => 'dashboard.delivery_schedule', 'uses' => 'DashboardController@dashboard_delivery_schedule']);
    Route::post('dashboard/delivery_schedule/custom', ['as' => 'dashboard.delivery_schedule.custom', 'uses' => 'DashboardController@dashboard_delivery_schedule_custome']);
    Route::post('dashboard/delivery_schedule/regions', ['as' => 'dashboard.delivery_schedule.search_regions', 'uses' => 'DashboardController@dashboard_delivery_schedule_searchRegions']);
	
	/**
     * DELIVERY DASHBOARD NEW ROUTES
     */
	 
	 
	//NEW ROUTES FOR DELIVERY DASHBOARD TRANSFER 
	Route::post('DeliveryDashboard/transfer/list', ['as' => 'delivery_dashboard.batch.transfer.list', 'uses' => 'DeliveryDashboardController@getTransferList']);


    Route::post('delivery/dashboard/region', ['as' => 'delivery_dashboard.coop.region', 'uses' => 'DeliveryDashboardController@getCoop_in_region']);
    Route::post('delivery/dashboard/coop_name', ['as' => 'delivery_dashboard.coop.name', 'uses' => 'DeliveryDashboardController@get_coop_name']);
    Route::post('delivery/dashboard/batch_list', ['as' => 'delivery_dashboard.batch.list', 'uses' => 'DeliveryDashboardController@get_delivery_list']);
	Route::post('delivery/export/batches', ['as' => 'delivery_dashboard.export_deliveries', 'uses' => 'DeliveryDashboardController@export_coop_deliveries']);
	Route::post('delivery/export/indexofpayment', ['as' => 'delivery_dashboard.export_deliveries.iop', 'uses' => 'DeliveryDashboardController@export_index_of_payment']);
    


    /** REGISTRY CONTROLLER */
    Route::get('registry', ['as' => 'rcef.registry', 'uses' => 'RegistryController@index']);
    Route::get('registry/list', ['as' => 'rcef.registry.list', 'uses' => 'RegistryController@RegisteredFarmers']);
    Route::post('registry/save', ['as' => 'rcef.registry.save', 'uses' => 'RegistryController@SaveRegistry2']);
    /** REGISTRY CONTROLLER */
	
    /* INSPECTION ROUTES */
    Route::get('inspection', ['as' => 'rcef.inspection', 'uses' => 'InspectionController@index']);
    Route::get('inspector/profile', ['as' => 'rcef.inspector.profile', 'uses' => 'InspectionController@InspectorProfile']);
    Route::post('inspection/delivery', ['as' => 'api.confirmed.delivery', 'uses' => 'APIController@ConfirmedDeliveries']);

    Route::get('inspection/profile/{idNumber}', ['as' => 'inspector.details', 'uses' => 'InspectionController@getInspectorDetails']);
    Route::get('inspection/profile/{idNumber}/{batchID}', ['as' => 'inspector.details.batch', 'uses' => 'InspectionController@getBatchDetails']);

    Route::get('inspection/registration', ['as' => 'rcef.inspection.registration', 'uses' => 'InspectionController@InspectorRegistrationForm']);
    Route::post('inspection/registration/save', ['as' => 'rcef.registry.registration.save', 'uses' => 'InspectionController@InspectorRegistrationSave']);
    Route::get('inspection/verification', ['as' => 'rcef.inspection.verification', 'uses' => 'InspectionController@InspectorVerification']);
    Route::post('inspectors/submitted', ['as' => 'rcef.inspectors.submitted', 'uses' => 'InspectionController@SubmittedInspectors']);
    
	Route::get('inspector/schedule', ['as' => 'rcef.inspector.schedule', 'uses' => 'InspectionController@InspectorScheduleView']);
    Route::post('inspector/schedule/table', ['as' => 'rcef.inspector.table', 'uses' => 'InspectionController@InspectorDeliveryTable']);
    Route::post('inspector/list', ['as' => 'rcef.inspector.list', 'uses' => 'InspectionController@InspectorList']);
    Route::post('inspector/replace', ['as' => 'rcef.inspector.replace', 'uses' => 'InspectionController@replaceInspector']);

	Route::post('inspector/province', ['as' => 'rcef.inspector.province', 'uses' => 'APIController@getProvinceUpdateInspector']);
    Route::post('inspector/municipality', ['as' => 'rcef.inspector.municipality', 'uses' => 'APIController@getMunicipalityUpdateInspector']);
    Route::post('inspector/batch/details', ['as' => 'inspector.batch.fetch_details', 'uses' => 'InspectionController@getaBatchDelivery_InspectorDetails']);
    Route::post('inspector/schedule/update', ['as' => 'inspector.schedule.update', 'uses' => 'InspectionController@updateAssignedInspector']);
		
    Route::post('inspectors/approve', ['as' => 'rcef.inspector.approve', 'uses' => 'InspectionController@ApproveInspectorProfile']);
    Route::post('inspectors/reject', ['as' => 'rcef.inspector.reject', 'uses' => 'InspectionController@RejectInspectorProfile']);

    Route::get('inspection/designation/{ticketNumber}', ['as' => 'rcef.inspection.designation', 'uses' => 'InspectionController@DesignateInspector']);
    Route::get('inspection/designation', ['as' => 'rcef.inspection.designation2', 'uses' => 'InspectionController@DesignateInspector2']);
    Route::post('inspection/designation/save', ['as' => 'rcef.inspector.save', 'uses' => 'InspectionController@saveInspectorDetails']);
    Route::post('inspection/employees', ['as' => 'api.employee.details', 'uses' => 'APIController@SelectedEmployeeProfile']);
    Route::post('inspection/provinces/dropoff', ['as' => 'api.provinces.dropoff', 'uses' => 'APIController@getProvinceDropoffDetails']);
    Route::post('inspection/municipalities/dropoff', ['as' => 'api.municipalities.dropoff', 'uses' => 'APIController@getMunicipalitiesDropoffDetails']);

    Route::post('inspection/dropoff/search', ['as' => 'api.dropoff.search', 'uses' => 'APIController@searchDropOffDelivery']);
    Route::post('inspection/tickets', ['as' => 'api.dropoff.details', 'uses' => 'APIController@SelectedDropOffDetails']);

    Route::post('inspection/profile', ['as' => 'api.inspector.profile', 'uses' => 'APIController@getInspectorProfiles']);
    Route::post('inspector/tickets', ['as' => 'api.inspector.tickets', 'uses' => 'APIController@getInspectorTickets']);
    Route::post('inspector/tikcet/duration', ['as' => 'api.ticket.duration', 'uses' => 'APIController@getTicketDuration']);
    Route::post('inspector/ticket/duration/save', ['as' => 'inspector.duration.save', 'uses' => 'InspectionController@updateTicketDuration']);
    /* INSPECTION ROUTES */

	//NEW report routes
	Route::post('report/excel/function', ['as' => 'rcef.report.excel', 'uses'=>'ReportController@convert_to_excel']);
	Route::post('report/excel/check_volume', ['as' => 'rcef.report.excel_check_volume', 'uses'=>'ReportController@check_prv_data_for_excel']);
	Route::get('report/excel/region/{region}', ['as' => 'rcef.report.excel.region', 'uses'=>'ReportController@convert_to_excel_region']);
	//Route::get('report/excel/{province}', ['as' => 'rcef.report.excel.province', 'uses'=>'ReportController@convert_to_excel_province']);
    //Route::get('report/excel/{province}/all', ['as' => 'rcef.report.excel.province_2', 'uses'=>'ReportController@convert_to_excel_province2']);
	//Route::get('report/excel/{province}/new', ['as' => 'rcef.report.excel.province_new', 'uses'=>'ReportController@convert_to_excel_province_newVersion']);
	//Route::get('report/excel/{province}/{municipality}', ['as' => 'rcef.report.excel.municipality', 'uses'=>'ReportController@convert_to_excel_municipality']);
	/**NEW ROTUES - 09-26-2020 */
	Route::get('report/excel/{province}/no_update', ['as' => 'rcef.report.excel.province_noUpdate', 'uses'=>'ReportExportController@export_province_noUPdate']);
    Route::get('report/excel/{province}/with_update', ['as' => 'rcef.report.excel.province_withUpdate', 'uses'=>'ReportExportController@export_province_withUPdate']);
    Route::get('report/excel/{province}/{municipality}/no_update', ['as' => 'rcef.report.excel.municipality_noUpdate', 'uses'=>'ReportExportController@export_municipality_noUPdate']);
    Route::get('report/excel/{province}/{municipality}/with_update', ['as' => 'rcef.report.excel.municipality_withUpdate', 'uses'=>'ReportExportController@export_municipality_withUPdate']);

    //FOR EBINHI
    Route::get('report/excel_ebinhi/{province}/{municipality}/no_update', ['as' => 'rcef.report.excel.province_noUpdate', 'uses'=>'PayMayaController@export_ebinhi_municipality']);


    //ROUTE FOR EXPORT VARIETY REPORT
     Route::get('report/excel/variety_list/{region_name}', ['as' => 'rcef.report.excel.variety.region', 'uses'=>'ReportExportController@reportExportVariety']);
     Route::get('report/export/municipal/statistics/{date_from}/{date_to}', ['as' => 'report.export.statistics.municipal', 'uses'=>'ReportExportController@exportMunicipalStatistics']);
	Route::get('report/scheduled', ['as' => 'rcef.report.scheduled', 'uses'=>'ReportController@Home_scheduled']);
	Route::post('report/scheduled/post', ['as' => 'rcef.report.scheduled.post', 'uses'=>'ReportController@Home_scheduled_Submit']);
	Route::post('report/scheduled/provincial', ['as' => 'rcef.report.scheduled.post.provincial', 'uses'=>'ReportController@Home_scheduled_Provincial_Submit']);
	Route::post('report/total', ['as' => 'rcep.report.total', 'uses'=>'ReportController@TotalValues']);	
	Route::get('report/home', ['as' => 'rcep.report2.home', 'uses'=>'ReportController@Home_Report2']);
	Route::get('report/home/province', ['as' => 'rcep.report2.province', 'uses'=>'ReportController@Home_Report2_provincial']);
	Route::get('report/home/municipalities', ['as' => 'rcep.report2.municipality', 'uses'=>'ReportController@Home_Report2_municipal']);
	Route::get('report/home/national', ['as' => 'rcep.report2.national', 'uses'=>'ReportController@Home_Report2_national']);
	Route::get('report/beneficiaries', ['as' => 'rcef.report.beneficiaries', 'uses'=>'ReportController@Home']);
	Route::post('report/beneficiaries/result', ['as' => 'rcef.report.beneficiaries.result', 'uses' => 'ReportController@SeedBeneficiaries']);
	Route::post('report/beneficiaries/varieties', ['as' => 'rcef.report.beneficiaries.variety', 'uses' => 'ReportController@SeedBeneficiariesVarieties']);
	Route::post('report/beneficiaries/varieties/provincial', ['as' => 'rcef.report.beneficiaries.variety.provincial', 'uses' => 'ReportController@SeedBeneficiariesVarietiesProvincial']);
	Route::post('generate/report/provincial', ['as' => 'generate.province.report', 'uses'=>'ReportController@generateProvincialReportData']);
	Route::post('generate/report/municipal', ['as' => 'generate.municipal.report', 'uses'=>'ReportController@generateMunicipalReportData']);
	
    /*     * REPORT ROUTES */
    Route::get('report/beneficiaries', ['as' => 'rcef.report.beneficiaries', 'uses' => 'ReportController@Home']);
    Route::post('report/beneficiaries/result', ['as' => 'rcef.report.beneficiaries.result', 'uses' => 'ReportController@SeedBeneficiaries']);

    Route::get('report/distriution/summary', ['as' => 'rcef.report.distribution', 'uses' => 'ReportController@DistSummaryHome']);
    //provincial
    Route::get('report/beneficiaries2', ['as' => 'rcef.report.beneficiaries2', 'uses' => 'ReportController@Home_Provincial']);
    Route::post('report/beneficiaries/result2', ['as' => 'rcef.report.beneficiaries.result2', 'uses' => 'ReportController@SeedBeneficiariesProvincial2']);
    Route::post('report/beneficiaries/varieties', ['as' => 'rcef.report.beneficiaries.variety', 'uses' => 'ReportController@SeedBeneficiariesVarieties']);
    //regional
    Route::get('report/beneficiaries3', ['as' => 'rcef.report.beneficiaries3', 'uses' => 'ReportController@Home_Regional']);
    Route::post('report/beneficiaries/result3', ['as' => 'rcef.report.beneficiaries.result3', 'uses' => 'ReportController@SeedBeneficiariesRegional']);
	//distribution summary
	Route::get('report/distribution/summary', ['as' => 'rcef.report.distribution', 'uses'=>'ReportController@DistSummaryHome']);
    /*     * REPORT ROUTES */

	/**SEED VARIETY REPORT PER DROPOFF */
	Route::get('report/variety/per_dop', ['as' => 'report.variety.dop', 'uses' => 'SeedReportController@report_dop_home']);
	Route::get('report/variety/overall', ['as' => 'report.variety.overall', 'uses' => 'SeedReportController@seed_report_overall']);
	Route::post('report/variety/per_dop/result', ['as' => 'report.variety.dop_result', 'uses' => 'SeedReportController@report_dop_resultTable']);
	Route::post('report/excel/varities', ['as' => 'rcef.report.variety_excel', 'uses'=>'ReportController@download_variety_report']);
	
	Route::post('report/variety/chart_data', ['as' => 'report.variety.chart', 'uses' => 'SeedReportController@get_seed_data']);
    Route::post('report/variety/chart_filter', ['as' => 'report.variety.chart_filter', 'uses' => 'SeedReportController@filter_seed_data']);
    Route::post('report/variety/provinces', ['as' => 'report.variety.provinces', 'uses' => 'SeedReportController@get_provinces']);
    Route::post('report/variety/provinces_data', ['as' => 'report.variety.provinces_data', 'uses' => 'SeedReportController@get_provinces_data']);
    Route::post('report/variety/municipalities', ['as' => 'report.variety.municipalities', 'uses' => 'SeedReportController@get_municipalities']);

    Route::post('report/variety/table', ['as' => 'report.variety.table', 'uses' => 'SeedReportController@filter_table']);
	/**SEED VARIETY REPORT PER DROPOFF */
	
	/** STATION REPORT ROUTES */
    Route::get('station_report/home', ['as' => 'station_report.home', 'uses' => 'StationReportController@home']);
    Route::post('station_report/load/values', ['as' => 'station_report.load_total_values', 'uses' => 'StationReportController@load_regional_report_values']);
    Route::post('station_report/load/cooperatives', ['as' => 'station_report.coop_list', 'uses' => 'StationReportController@load_seed_coopList']);
    Route::post('station_report/load/cooperatives/details', ['as' => 'station_report.selected_coop.details', 'uses' => 'StationReportController@load_coop_details']);
    Route::post('station_report/load/region/varieties', ['as' => 'station_report.region.varieties', 'uses' => 'StationReportController@load_region_varieties']);
    Route::post('station_report/load/seeed/chart_data', ['as' => 'station_report.seed.chart', 'uses' => 'StationReportController@load_region_seeed_chartData']);
    
	Route::post('station_report/load/progress_all', ['as' => 'station_report.load.progress_all', 'uses' => 'StationReportController@load_station_progress_all']);
	Route::post('station_report/load/progress', ['as' => 'station_report.load.progress', 'uses' => 'StationReportController@load_station_progress']);
    Route::post('station_report/load/area_covered', ['as' => 'station_report.load_area_cover', 'uses' => 'StationReportController@load_station_areas']);    
    Route::post('station_report/load/station_data', ['as' => 'station_report.load_station_data', 'uses' => 'StationReportController@load_station_data']);
	/** STATION REPORT ROUTES */
	
    //Checking routes
    Route::get('checking', ['as' => 'rcef.checking', 'uses' => 'CheckingController@Index']);
    Route::post('checking/search', ['as' => 'rcef.checking.search', 'uses' => 'CheckingController@Search']);
    Route::post('checking/showunreleased', ['as' => 'rcef.checking.showunreleased', 'uses' => 'CheckingController@ShowUnreleased']);
    Route::post('checking/table', ['as' => 'rcef.checking.table', 'uses' => 'CheckingController@Table']);
    Route::post('checking/deleteFarmer', ['as' => 'rcef.checking.deleteFarmer', 'uses' => 'CheckingController@DeleteFarmer']);
    Route::post('checking/delete_farmer_data', ['as' => 'rcef.checking.delete_farmer_data', 'uses' => 'CheckingController@Delete_farmer_data']);
    //new
    Route::post('checking/farmer_data', ['as' => 'rcef.checking.farmer_data', 'uses' => 'CheckingController@get_farmer_data_forEdit']);
    Route::post('checking/farmer_edit', ['as' => 'rcef.checking.farmer_edit', 'uses' => 'CheckingController@update_farmer_data_forEdit']);
    Route::post('checking/farmer_edit/old', ['as' => 'rcef.checking.old_farmer_edit', 'uses' => 'CheckingController@update_farmer_data_forEdit_old']);
    Route::post('checking/rsbsa_check', ['as' => 'rcef.checking.check_rsbsa_status', 'uses' => 'CheckingController@check_rsbsa_if_exist']);

    /* SEED COOP ROUTES */
	Route::post('cooperatives/coop/id', ['as' => 'coop.id', 'uses'=>'CoopController@getCoopID']);
	Route::get('cooperatives/commitment', ['as' => 'coop.commitment', 'uses'=>'CoopController@index']);
	Route::post('cooperatives/list', ['as' => 'coop.list', 'uses'=>'CoopController@coopList']);
	Route::post('cooperatives/commitment/total', ['as' => 'coop.commitment.total', 'uses'=>'CoopController@totalCommitment']);
	Route::post('cooperatives/commitment/sub_total', ['as' => 'coop.commitment.sub_total', 'uses'=>'CoopController@SubtotalCommitment']);
	Route::post('cooperatives/commitment/cancel', ['as' => 'coop.commitment.cancel', 'uses'=>'CoopController@CoopCommitmentCancel']);

	/**
     * SEED COOP DASHBOARD
     */
    Route::get('cooperatives/dashboard', ['as' => 'coop.dashboard', 'uses'=>'CoopController@coop_dashboard_home']);
    Route::post('cooperatives/dashboard/confirmed_delivery', ['as' => 'load.coop.deliveries', 'uses'=>'CoopController@confirmed_delivery_tbl']);
    Route::post('cooperatives/dashboard/seeds', ['as' => 'load.coop.seeds', 'uses'=>'CoopController@coop_seeds_tbl']);
	
    Route::post('cooperatives/dashboard/regional', ['as' => 'load.coop.regional', 'uses'=>'CoopController@coop_regional_tbl']);


	/**
     * SEED COOP DASHBOARD
     */ 
	Route::get('cooperatives/rla/edit', ['as' => 'coop.rla.edit', 'uses'=>'CoopController@coop_rla_edit']);
    Route::post('cooperatives/rla/edit/tbl', ['as' => 'coop.rla.edit_tbl', 'uses'=>'CoopController@coop_rla_edit_tbl']);
    Route::get('cooperatives/rla/edit/{id}', ['as' => 'coop.rla.edit.form', 'uses'=>'CoopController@coop_rla_edit_form']);
    Route::post('cooperatives/rla/edit/confirm', ['as' => 'coop.rla.confirm_edit', 'uses'=>'CoopController@confirm_edit_rla']);
	
	Route::get('cooperatives/rla/bpi', ['as' => 'coop.rla.bpi', 'uses'=>'CoopController@coop_rla_bpi']);
    Route::post('cooperatives/rla/bpi/save_request', ['as' => 'coop.rla.bpi_save_request', 'uses'=>'CoopController@save_request_bpi']); 
	 
	Route::get('cooperatives/rla/pmo', ['as' => 'coop.rla.pmo', 'uses'=>'CoopController@coop_rla_pmo']);
    Route::post('cooperatives/rla/pmo/get_coop', ['as' => 'coop.rla.pmo_get_coop', 'uses'=>'CoopController@coop_rla_pmo_getCoop']);
    Route::post('cooperatives/rla/pmo/table', ['as' => 'coop.rla.pmo_tbl', 'uses'=>'CoopController@coop_rla_pmo_loadTbl']);
	
	Route::get('cooperatives/rla/manual', ['as' => 'coop.rla.manual', 'uses'=>'CoopController@coop_rla_manual_home']);
    Route::post('cooperatives/rla/manual/sg_list', ['as' => 'coop.rla.manual_sgList', 'uses'=>'CoopController@coop_rla_manual_sgList']);
    Route::post('cooperatives/rla/manual/save_request', ['as' => 'coop.rla.save_request', 'uses'=>'CoopController@save_request']);

    Route::get('cooperatives/rla/approval', ['as' => 'coop.rla.approve_home', 'uses'=>'CoopController@rla_request_list']);
    Route::post('cooperatives/rla/approval_table', ['as' => 'coop.rla.approve_table', 'uses'=>'CoopController@rla_request_table']);
    Route::post('cooperatives/rla/approve_requsetDetails', ['as' => 'coop.rla.approve_requsetDetails', 'uses'=>'CoopController@rla_request_details']);
    Route::post('cooperatives/rla/approve_confirm', ['as' => 'coop.rla.approve_confirm', 'uses'=>'CoopController@rla_request_confirm']);
    Route::post('cooperatives/rla/approve_reject', ['as' => 'coop.rla.approve_reject', 'uses'=>'CoopController@rla_request_reject']);
	 
    Route::get('cooperatives/dashboard', ['as' => 'coop.dashboard', 'uses'=>'CoopController@coop_dashboard_home']);
    Route::post('cooperatives/dashboard/confirmed_delivery', ['as' => 'load.coop.deliveries', 'uses'=>'CoopController@confirmed_delivery_tbl']);
    Route::post('cooperatives/deliveries/region', ['as' => 'load.deliveries.region', 'uses'=>'CoopController@coop_deliveries_per_region']);
    Route::post('cooperatives/dashboard/seeds', ['as' => 'load.coop.seeds', 'uses'=>'CoopController@coop_seeds_tbl']);
    Route::get('cooperatives/rla', ['as' => 'coop.rla', 'uses'=>'CoopController@coop_rla']);
    Route::post('cooperatives/rla/upload', ['as' => 'coop.rla.upload', 'uses'=>'CoopController@coop_rla_upload']);
    Route::post('cooperatives/rla/table', ['as' => 'coop.rla.table', 'uses'=>'CoopController@coop_rla_table']);
    Route::get('cooperatives/members/home', ['as' => 'coop.members.home', 'uses'=>'CoopController@coop_members_home']);
    Route::post('cooperatives/members', ['as' => 'load.coop.members', 'uses'=>'CoopController@load_coop_members']);
    Route::post('cooperatives/members/blacklist', ['as' => 'coop.member.blacklist', 'uses'=>'CoopController@set_sg_blacklist']);
    //profiling routes
    Route::get('cooperatives/sg_pofiling_function', ['as' => 'coop.sg.profiles', 'uses'=>'CoopController@sg_pofiling_function']);
    //new
    Route::post('cooperatives/schedule', ['as' => 'load.coop.schedule', 'uses'=>'CoopController@load_coop_schedule']);
    Route::post('cooperatives/schedule/details', ['as' => 'load.coop.schedule_details', 'uses'=>'CoopController@load_coop_schedule_details']);
    Route::post('cooperatives/sg/details', ['as' => 'load.sg.details', 'uses'=>'CoopController@load_sg_details']);
    Route::post('cooperatives/sg/tags', ['as' => 'load.sg.tags', 'uses'=>'CoopController@load_sg_tags']);

    Route::post('cooperatives/list/upload', ['as' => 'farmers.list.upload', 'uses'=>'CoopController@farmer_list_upload']);
    Route::post('cooperatives/list/table', ['as' => 'farmers.list.table', 'uses'=>'CoopController@farmer_list_table']);
    Route::post('farmer/profile/ds2019', ['as' => 'farmer.profile.ds2019', 'uses'=>'CoopController@farmer_profile_2019']);
    Route::post('farmer/profile/ws2020', ['as' => 'farmer.profile.ws2020', 'uses'=>'FarmerProfileController@farmer_profile_2020']);
    Route::get('farmer/profile/home', ['as' => 'farmer_profile.home', 'uses' => 'FarmerProfileController@index']);
    Route::post('farmer/profile/udpated', ['as' => 'farmer_profile.update', 'uses' => 'FarmerProfileController@ds2019_update_farmer_profile']);
	
	Route::get('farmer/profile/list', ['as' => 'farmer_profile.home.list', 'uses' => 'FarmerProfileController@list_index']);
    Route::post('farmer/profile/municipality', ['as' => 'farmer_profile.home.list_municipality', 'uses' => 'FarmerProfileController@get_municipality']);
    Route::post('farmer/profile/list/load', ['as' => 'farmer_profile.load.list', 'uses' => 'FarmerProfileController@load_list']);

    // #newroute cross checking 3 seasons
    Route::get('farmer/profile/cross/check', ['as' => 'farmer_profile.cross.check', 'uses' => 'FarmerProfileController@farmer_benificiaries_cross_check']);
    Route::post('farmer/profile/cross/check/list', ['as' => 'farmer_profile.cross.check.list', 'uses' => 'FarmerProfileController@cross_check_list']);
    /** END  */
  Route::get('farmer/profile/consolidate/{province}/{municipality}', ['as' => 'farmer_profile.consolidate.last_season', 'uses' => 'FarmerProfileController@consolidate_LS']);
    
  Route::get('cross_match/lgu_data/{prv}/{process_type}', ['as' => 'cross_match.consolidate.lgu_data', 'uses' => 'UtilityController@cross_match_lgu_prv']);

/* create pre reg account */

  Route::get('create-pre-reg', ['as' => 'prereg', 'uses' => 'UtilityController@createPreRegAccount']);
    



    /* END FARMER PROFILE WITH CONTACT NUMBER*/
    Route::get('farmer/profile/contact/statinfo', ['as' => 'farmer_profile.contact.statinfo', 'uses' => 'FarmerProfileController@profileStatInfo']);
    Route::post('farmer/profile/contact/municipality', ['as' => 'farmer_profile.contact.municipality', 'uses' => 'FarmerProfileController@profileStatMunicipality']);
    Route::post('farmer/profile/contact/gentable', ['as' => 'farmer_profile.contact.gentable', 'uses' => 'FarmerProfileController@generateTbl']);
    Route::post('farmer/profile/contact/export', ['as' => 'farmer_profile.with.contact.export', 'uses' => 'FarmerProfileController@exportToExcel']);
 
    /* END FARMER PROFILE WITH CONTACT NUMBER*/

	
  

	Route::post('cooperatives/table', ['as' => 'coop.commitment.table', 'uses'=>'CoopController@coop_tbl']);
	Route::post('cooperatives/varities', ['as' => 'coop.varities', 'uses'=>'CoopController@coopVarities']);
	
	Route::post('cooperatives/varities/delete', ['as' => 'coop.varities.delete', 'uses'=>'CoopController@coopVaritiesDelete']);
	Route::post('cooperatives/varities/delete/details', ['as' => 'coop.varities.delete.details', 'uses'=>'CoopController@coopVaritiesDeleteDetails']);
	Route::post('cooperatives/varities/add', ['as' => 'coop.varities.details.add', 'uses'=>'CoopController@coopVaritiesADD']);
	Route::post('cooperatives/varities/add/submit', ['as' => 'coop.add_more.submit', 'uses'=>'CoopController@coopVaritiesADDSubmit']);
	Route::post('cooperatives/details/table', ['as' => 'coop.details.table', 'uses'=>'CoopController@coop_details_tbl']);
	
	Route::post('cooperatives/commitment/save', ['as' => 'coop.commitment.save', 'uses'=>'CoopController@saveCoopCommitment']);
	Route::post('cooperatives/commitment/save/table', ['as' => 'coop.commitment.save.total', 'uses'=>'CoopController@saveTotalCoopCommitment']);
	Route::post('cooperatives/save/table', ['as' => 'coop.save.table', 'uses'=>'CoopController@coopSaveTable']);
	Route::post('cooperatives/commitment/updated', ['as' => 'coop.commitment.update', 'uses'=>'CoopController@updateCoopCommitment']);
	Route::post('cooperatives/commitment/moa', ['as' => 'coop.commitment.moa', 'uses'=>'CoopController@updateCoopMOA']);
    // new as of 03-11-2021 #newroute
    Route::post('cooperatives/commitment/efficiency', ['as' => 'coop.commitment.efficiency', 'uses'=>'CoopController@updateCoopTargetEfficiency']);
    //end 
	
	Route::get('coop/operator/deliveries', ['as' => 'coop_operator.deliveries', 'uses'=>'CoopOperatorController@coop_delivery_home']);
    Route::post('coop/operator/list', ['as' => 'coop_operator.delivery_list', 'uses'=>'CoopOperatorController@coop_delivery_list2']);
    Route::post('coop/operator/cancel', ['as' => 'coop_operator.cancel_delivery', 'uses'=>'CoopOperatorController@cancel_delivery']);
    Route::post('coop/operator/values', ['as' => 'load.coop_operator.total_values', 'uses'=>'CoopOperatorController@coop_total_values']);
    Route::post('coop/operator/values_province', ['as' => 'load.coop_operator.total_values_province', 'uses'=>'CoopOperatorController@coop_total_values_province']);
    Route::post('coop/operator/list/province', ['as' => 'coop_operator.delivery_list_province', 'uses'=>'CoopOperatorController@coop_delivery_list_province']);

    // new as of 03-11-2021 #newroute
    Route::post('coop/operator/table/commitment/variety', ['as' => 'table.coop_operator.coop_commitment_variety', 'uses'=>'CoopOperatorController@coop_commitment_variety']);
    Route::post('coop/operator/html/commitment/sg/variety', ['as' => 'table.coop_operator.sg_commitment_variety_html', 'uses'=>'CoopOperatorController@sg_commitment_variety_html']);
    Route::post('coop/operator/table/commitment/sg/variety', ['as' => 'table.coop_operator.sg_commitment_variety_table', 'uses'=>'CoopOperatorController@sg_commitment_variety_table']);
    Route::post('coop/operator/table/dop', ['as' => 'table.coop_operator.coop_dop_delivery', 'uses'=>'CoopOperatorController@dropoff_table']);
    Route::post('coop/operator/html/delivery/dop', ['as' => 'table.coop_operator.delivery_dop_html', 'uses'=>'CoopOperatorController@confirmed_dop_html']);
    Route::post('coop/operator/table/delivery/dop', ['as' => 'table.coop_operator.delivery_dop_table', 'uses'=>'CoopOperatorController@confirmed_dop_table']);
    Route::post('coop/operator/html/delivery/batch', ['as' => 'table.coop_operator.delivery_batch_html', 'uses'=>'CoopOperatorController@confirmed_batch_html']);
    Route::post('coop/operator/table/delivery/batch', ['as' => 'table.coop_operator.delivery_batch_table', 'uses'=>'CoopOperatorController@confirmed_batch_table']);
    // end
	/* SEED COOP ROUTES */
	
	  /** SEED GROWER ROUTES */
    Route::get('sg/list', ['as' => 'sg.list', 'uses' => 'SGController@display_sg_list']);
    Route::post('sg/table', ['as' => 'sg.table', 'uses' => 'SGController@display_sg_table']);
    /** SEED GROWER ROUTES */
	
	/**CANCEL DELIVERY - WEB */
    Route::get('delivery/web/cancel/home', ['as' => 'delivery_web.cancel.home', 'uses' => 'CancelDeliveryController@cancel_home']);
    Route::post('delivery/web/cancel/batch_details', ['as' => 'deliver_cancel.batch.details', 'uses' => 'CancelDeliveryController@cancel_batch_details']);
    Route::post('delivery/web/cancel/check_batch', ['as' => 'deliver_cancel.batch.check', 'uses' => 'CancelDeliveryController@check_batch_details']);
	Route::post('delivery/web/cancel/update', ['as' => 'cancel_delivery.update.flags', 'uses' => 'CancelDeliveryController@cancel_batch_update_flags']);
    /**CANCEL DELIVERY - WEB */

    //transfers routes
    Route::get('transfers', ['as' => 'rcef.transfers', 'uses' => 'TransferController@Index']);
    Route::post('transfers/loadscript', ['as' => 'rcef.transfers.loadscript', 'uses' => 'TransferController@Loadscript']);
    Route::post('transfers/transfer_proceed', ['as' => 'rcef.transfers.transfer_proceed', 'uses' => 'TransferController@Transfer_proceed']);
    
	
	//NEW ROUTES TRANSFER WS2021
		Route::post('transfers/load_deliveries/oldseason', ['as' => 'transfers.oldseason.deliveries', 'uses' => 'TransferController@getBatchOldSeason']);
		Route::post('transfers/pstocs/check_seedtag', ['as' => 'transfers.check_seedtag.oldseason', 'uses' => 'TransferController@check_seedtag_oldseason']);
        Route::post('transfers/pstocs/seed_tag/details', ['as' => 'transfers.seed_tag.details.oldseason', 'uses' => 'TransferController@get_seedTag_details_oldseason']);
        Route::post('transfers/pstocs/confirm', ['as' => 'confirm.transfer.pstocs', 'uses' => 'TransferController@confirm_transfer_oldseason']);
		Route::get('transfers/pstocs/{batch_number}/{coop_acre}', ['as' => 'transfers.dataPreparation.pstocs', 'uses' => 'TransferController@dataPreparation']);
		Route::post('transfers/dropoff/pstocs', ['as' => 'transfers.dropoff.pstocs', 'uses' => 'TransferController@transfer_dropoffList_PSTOCS']);
	
	/**
     * NEW TRANFER ROUTES (WS 2020)
     */
    Route::post('transfers/municipalities', ['as' => 'transfers.municipalities', 'uses' => 'TransferController@transfer_municipalities']); 
    Route::get('transfers/ws2020', ['as' => 'rcef.transfers.ws2020', 'uses' => 'TransferController@ws_index']);
    Route::post('transfers/dropoff', ['as' => 'transfers.dropoff', 'uses' => 'TransferController@transfer_dropoffList']);
    Route::post('transfers/ws2020/deliveries', ['as' => 'transfers.ws2020.deliveries', 'uses' => 'TransferController@transfer_delivery_tbl']);
    Route::get('transfers/ws2020/{batch_number}/whole_transfer', ['as' => 'transfers.ws2020.whole', 'uses' => 'TransferController@transfer_whole_home']);
    Route::post('transfers/ws2020/whole_transfer/confrim', ['as' => 'confirm.transfer.whole', 'uses' => 'TransferController@confirm_transfer_whole']);
    Route::get('transfers/ws2020/{batch_number}/partial_transfer', ['as' => 'transfers.ws2020.partial', 'uses' => 'TransferController@transfer_partial_home']);
    Route::post('transfers/ws2020/check_seedtag', ['as' => 'transfers.check_seedtag', 'uses' => 'TransferController@check_seedtag']);
    Route::post('transfers/ws2020/seed_tag/details', ['as' => 'transfers.seed_tag.details', 'uses' => 'TransferController@get_seedTag_details']);
    Route::post('transfers/ws2020/partial_transfer/confrim', ['as' => 'confirm.transfer.partial', 'uses' => 'TransferController@confirm_transfer_partial']);
    /** END */
	
	/* QR GENERATOR ROUTES */
    Route::get('farmerID/code', ['as' => 'farmer.id.code', 'uses' => 'FarmerIDController@QRCode']);
    Route::get('farmerID/coop', ['as' => 'farmer.id.coop', 'uses' => 'FarmerIDController@QRCodeCoop']);
    Route::get('farmerID/excel', ['as' => 'farmer.id.excel', 'uses' => 'FarmerIDController@generateDocx']);
    Route::get('list', ['as' => 'farmer.list', 'uses' => 'FarmerIDController@FarmerList']);
    Route::post('farmerID/generate', ['as' => 'farmer.qr.generate', 'uses' => 'FarmerIDController@generateQR']);
    Route::get('farmerID/home', ['as' => 'farmer.id.home', 'uses' => 'FarmerIDController@Home']);
    Route::get('farmerID/generate/{id}', ['as' => 'area.qr.generate', 'uses' => 'FarmerIDController@areaGenerateQR']);
	  Route::post('farmerID/logs', ['as' => 'farmer.qr.logs', 'uses' => 'FarmerIDController@get_QRlogs']);
    Route::post('farmerID/chart', ['as' => 'farmer.qr.chart', 'uses' => 'FarmerIDController@get_QRChart']);


    // Route::get('farmerID/code', ['as' => 'farmer.id.code', 'uses' => 'farGenerationController@pageClose']);
    // Route::get('farmerID/coop', ['as' => 'farmer.id.coop', 'uses' => 'farGenerationController@pageClose']);
    // Route::get('farmerID/excel', ['as' => 'farmer.id.excel', 'uses' => 'farGenerationController@pageClose']);
    // Route::get('list', ['as' => 'farmer.list', 'uses' => 'farGenerationController@pageClose']);
    // Route::post('farmerID/generate', ['as' => 'farmer.qr.generate', 'uses' => 'farGenerationController@pageClose']);
    // Route::get('farmerID/home', ['as' => 'farmer.id.home', 'uses' => 'farGenerationController@pageClose']);
    // Route::get('farmerID/generate/{id}', ['as' => 'area.qr.generate', 'uses' => 'farGenerationController@pageClose']);
	//   Route::post('farmerID/logs', ['as' => 'farmer.qr.logs', 'uses' => 'farGenerationController@pageClose']);
    // Route::post('farmerID/chart', ['as' => 'farmer.qr.chart', 'uses' => 'farGenerationController@pageClose']);

    
    /* QR GENERATOR ROUTES */
	
    /* Releasing WS*/
     Route::get('releasing_ws', ['as' => 'releasingws.index', 'uses' => 'ReleasingWsController@pageClose']);
    Route::get('releasing_ws/formula', ['as' => 'releasingws.formula', 'uses' => 'ReleasingWsController@formula']);
    Route::get('releasing_ws/search_farmer', ['as' => 'releasingws.search_farmer', 'uses' => 'ReleasingWsController@search_farmer']);
    Route::post('releasing_ws/store', ['as' => 'releasingws.store', 'uses' => 'ReleasingWsController@store']);
    Route::post('releasing_ws/search_rsbsa_no', ['as' => 'releasingws.search_rsbsa_no', 'uses' => 'ReleasingWsController@search_rsbsa_no']);
    Route::post('releasing_ws/confirm-store', ['as' => 'releasingws.confirm_store', 'uses' => 'ReleasingWsController@confirm_store']);
    Route::get('releasing_ws/search_address/{farmer_id}', ['as' => 'releasingws.search_address', 'uses' => 'ReleasingWsController@search_address']);
    Route::get('releasing_ws/search_municipalities/{municipality}', ['as' => 'releasingws.search_municipalities', 'uses' => 'ReleasingWsController@search_municipalities']);
    // Route::post('releasing/insert-address', ['as' => 'releasing.insert_address', 'uses' => 'ReleasingWsController@insert_address']);
    Route::post('releasing_ws/farm_performance', ['as' => 'releasingws.insert_farm_performance', 'uses' => 'ReleasingWsController@insert_farm_performance']);
    Route::post('releasing_ws/select_distribution_location', ['as' => 'releasingws.select_distribution_location', 'uses' => 'ReleasingWsController@select_distribution_location']);
    Route::get('releasing_ws/get_municipalities/{province}', ['as' => 'releasingws.get_municipalities', 'uses' => 'ReleasingWsController@get_municipalities']);
    Route::get('releasing_ws/get_dropoff_points/{province}/{municipality}', ['as' => 'releasingws.get_dropoff_points', 'uses' => 'ReleasingWsController@get_dropoff_points']); 
	
    Route::get('releasing/formula', ['as' => 'releasing.formula', 'uses' => 'ReleasingController@formula']);
    Route::get('releasing', ['as' => 'releasing.index', 'uses' => 'ReleasingController@index']);
    Route::get('releasing/search_farmer', ['as' => 'releasing.search_farmer', 'uses' => 'ReleasingController@search_farmer']);
    Route::post('releasing/store', ['as' => 'releasing.store', 'uses' => 'ReleasingController@store']);
    Route::post('releasing/search_rsbsa_no', ['as' => 'releasing.search_rsbsa_no', 'uses' => 'ReleasingController@search_rsbsa_no']);
    Route::post('releasing/confirm-store', ['as' => 'releasing.confirm_store', 'uses' => 'ReleasingController@confirm_store']);
    Route::get('releasing/search_address/{farmer_id}', ['as' => 'releasing.search_address', 'uses' => 'ReleasingController@search_address']);
    Route::get('releasing/search_municipalities/{municipality}', ['as' => 'releasing.search_municipalities', 'uses' => 'ReleasingController@search_municipalities']);
    // Route::post('releasing/insert-address', ['as' => 'releasing.insert_address', 'uses' => 'ReleasingController@insert_address']);
    Route::post('releasing/farm_performance', ['as' => 'releasing.insert_farm_performance', 'uses' => 'ReleasingController@insert_farm_performance']);
    Route::post('releasing/select_distribution_location', ['as' => 'releasing.select_distribution_location', 'uses' => 'ReleasingController@select_distribution_location']);
    Route::get('releasing/get_municipalities/{province}', ['as' => 'releasing.get_municipalities', 'uses' => 'ReleasingController@get_municipalities']);
    Route::get('releasing/get_dropoff_points/{province}/{municipality}', ['as' => 'releasing.get_dropoff_points', 'uses' => 'ReleasingController@get_dropoff_points']);

    Route::get('check_rsbsa_requirement', ['as' => 'releasing.check_rsbsa_requirement', 'uses' => 'ReleasingController@rsbsa_requirement']);
    Route::get('check_farmer_rsbsa/{farmer_id}', ['as' => 'releasing.check_farmer_rsbsa', 'uses' => 'ReleasingController@farmer_rsbsa']);
    Route::post('update_farmer_rsbsa', ['as' => 'releasing.update_farmer_rsbsa', 'uses' => 'ReleasingController@update_farmer_rsbsa']);
    Route::post('add_farmer_rsbsa', ['as' => 'releasing.add_farmer_rsbsa', 'uses' => 'ReleasingController@add_farmer_rsbsa']);

    /* FARMER REGISTRATION ROUTES */
    Route::get('farmer_registration', ['as' => 'farmer_registration.index', 'uses' => 'FarmerRegistrationController@index']);
    Route::get('farmer_registration/search_farmer', ['as' => 'farmer_registration.search_farmer', 'uses' => 'FarmerRegistrationController@search_farmer']);
    Route::get('farmer_registration/search_municipalities/{province}', ['as' => 'farmer_registration.search_municipalities', 'uses' => 'FarmerRegistrationController@search_municipalities']);
    Route::post('farmer_registration/update_farmer', ['as' => 'farmer_registration.update_farmer', 'uses' => 'FarmerRegistrationController@update_farmer']);

    /* SYNCING ROUTES */
    Route::get('syncing', ['as' => 'syncing.index', 'uses' => 'SyncingController@index']);
    Route::get('syncing/send_pending_release', ['as' => 'syncing.send_pending_release', 'uses' => 'SyncingController@send_pending_release']);
    Route::get('syncing/send_released', ['as' => 'syncing.send_released', 'uses' => 'SyncingController@send_released']);
    Route::get('syncing/send_distribution_list_new', ['as' => 'syncing.send_distribution_list_new', 'uses' => 'SyncingController@send_distribution_list_new']);
    Route::get('syncing/send_distribution_list_updates', ['as' => 'syncing.send_distribution_list_updates', 'uses' => 'SyncingController@send_distribution_list_updates']);
    Route::get('syncing/download_distribution_list', ['as' => 'syncing.download_distribution_list', 'uses' => 'SyncingController@download_distribution_list']);
    Route::get('syncing/send_actual_delivery', ['as' => 'syncing.send_actual_delivery', 'uses' => 'SyncingController@send_actual_delivery']);

    /* DELIVERY DASHBOARD */
    Route::get('/DeliveryDashboard', ['as' => 'deliverydashboard.index', 'uses' => 'DeliveryDashboardController@index']);
    Route::get('/cooperatives', ['as' => 'deliverydashboard.cooperatives', 'uses' => 'DeliveryDashboardController@cooperatives']);
    Route::post('/sg_delivery_status', ['as' => 'deliverydashboard.seed_growers_delivery', 'uses' => 'DeliveryDashboardController@seed_growers_delivery']);
    Route::post('/batch_status', ['as' => 'deliverydashboard.batch_delivery', 'uses' => 'DeliveryDashboardController@batch_delivery']);
    Route::post('/coop_data', ['as' => 'deliverydashboard.coop_data', 'uses' => 'DeliveryDashboardController@coop_data']);
    Route::post('/iar_list', ['as' => 'deliverydashboard.iar_list', 'uses' => 'DeliveryDashboardController@iar_list']);
    Route::get('/InspectionReport', ['as' => 'deliverydashboard.iar_table', 'uses' => 'DeliveryDashboardController@iar_table']);
    Route::get('/iar_pdf/{id}', ['as' => 'deliverydashboard.gen_iar_pdf', 'uses' => 'DeliveryDashboardController@gen_iar_pdf']);
    Route::get('/delivery_schedule/{id}', ['as' => 'deliverydashboard.delivery_schedule', 'uses' => 'DeliveryDashboardController@delivery_schedule']);
     //Route::get('/blank/iar_pdf', ['as' => 'deliverydashboard.blank.gen_iar_pdf', 'uses' => 'DeliveryDashboardController@gen_blank_iar_pdf']);
	//Route::get('/InspectionReport', ['as' => 'deliverydashboard.iar_table', 'uses' => 'DeliveryDashboardController@iar_table']);
	
	//IAR NEW ROUTES
	Route::post('iar/get_municipalities', ['as' => 'iar.municipalities', 'uses' => 'DeliveryDashboardController@get_municipalities']);
	Route::post('iar/get_dropoff_points', ['as' => 'iar.dropoff', 'uses' => 'DeliveryDashboardController@get_dropoff_points']);
	
    Route::get('/AccountantIAR', ['as' => 'deliverydashboard.acc_iar_table', 'uses' => 'DeliveryDashboardController@acc_iar_table']);
	Route::post('/accountant_iar_list', ['as' => 'deliverydashboard.accountant_iar_list', 'uses' => 'DeliveryDashboardController@accountant_iar_list']);
	Route::get('/accountant_iar_pdf/{id}', ['as' => 'deliverydashboard.accountant_iar_pdf', 'uses' => 'DeliveryDashboardController@accountant_iar_pdf']);

    /* COOP SUMMARY */
    Route::get('/coop_summary', ['as' => 'ReportController.coop_sg_count', 'uses' => 'ReportController@coop_sg_count']);
    Route::get('/coop_summary_total', ['as' => 'ReportController.coop_sg_count_total', 'uses' => 'ReportController@coop_sg_count_total']);
    
    Route::get('/coop_summary_excel', ['as' => 'ReportController.coop_sg_count_excel', 'uses' => 'ReportController@coop_sg_count_excel']);
    Route::get('/coop_summary_view', ['as' => 'ReportController.coop_summary_view', 'uses' => 'ReportController@coop_summary_view']);

    /* USER MANAGEMENT ROUTES */
    Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@index', 'middleware' => ['permission:user-list|user-create|user-edit|user-delete']]);
    Route::get('/users/datatable', ['as' => 'users.datatable', 'uses' => 'UserController@datatable', 'middleware' => ['permission:user-list']]);
    Route::get('users/create', ['as' => 'users.create', 'uses' => 'UserController@create', 'middleware' => ['permission:user-create']]);
    Route::post('users/create', ['as' => 'users.store', 'uses' => 'UserController@store', 'middleware' => ['permission:user-create']]);
    Route::get('users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show', 'middleware' => ['permission:user-list']]);
    Route::get('users/edit/{id}', ['as' => 'users.edit', 'uses' => 'UserController@edit', 'middleware' => ['permission:user-edit']]);
    Route::patch('users/{id}', ['as' => 'users.update', 'uses' => 'UserController@update', 'middleware' => ['permission:user-edit']]);
    Route::delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);
    Route::post('users/province', ['as' => 'users.province', 'uses' => 'UserController@province']);
    Route::post('users/region', ['as' => 'users.region', 'uses' => 'UserController@region']);
    Route::post('users/edit/province', ['as' => 'users.province', 'uses' => 'UserController@province']);
    Route::post('users/edit/region', ['as' => 'users.region', 'uses' => 'UserController@region']);

    //PROVINCELIST
    Route::post('users/branch_it/province/', ['as' => 'user.province.list', 'uses'=>'UserController@provinceData']);
    Route::post('users/update/province', ['as' => 'users.update.province', 'uses' => 'UserController@updateProvince']);

    Route::post('users/update/role', ['as' => 'users.update.role', 'uses' => 'UserController@updateRole']);


    
    //USER REQUEST
    Route::get('request/user', ['as' => 'users.create.request', 'uses' => 'UserController@create_request', 'middleware' => ['permission:user-list']]);
    Route::post('request/user', ['as' => 'users.store.request', 'uses' => 'UserController@store_request', 'middleware' => ['permission:user-list']]);
    Route::post('request/province', ['as' => 'users.province', 'uses' => 'UserController@province']);
    Route::post('request/region', ['as' => 'users.region', 'uses' => 'UserController@region']);

    Route::get('request/approval', ['as' => 'users.approval', 'uses' => 'UserController@request_approval', 'middleware' => ['permission:user-list|user-create|user-edit|user-delete']]);
    
    Route::post('request/datatable', ['as' => 'users.datatable.request', 'uses' => 'UserController@datatable_request', 'middleware' => ['permission:user-list']]);
    Route::post('request/approved', ['as' => 'request.approve', 'uses' => 'UserController@approve_request', 'middleware' => ['permission:user-list']]);
    

    

    Route::get('roles', ['as' => 'roles.index', 'uses' => 'RoleController@index', 'middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
    Route::get('/roles/datatable', ['as' => 'roles.datatable', 'uses' => 'RoleController@datatable', 'middleware' => ['permission:role-list']]);
    Route::get('roles/create', ['as' => 'roles.create', 'uses' => 'RoleController@create', 'middleware' => ['permission:role-create']]);
    Route::post('roles/create', ['as' => 'roles.store', 'uses' => 'RoleController@store', 'middleware' => ['permission:role-create']]);
    Route::get('roles/{id}', ['as' => 'roles.show', 'uses' => 'RoleController@show', 'middleware' => ['permission:role-list']]);
    Route::get('roles/{id}/edit', ['as' => 'roles.edit', 'uses' => 'RoleController@edit', 'middleware' => ['permission:role-edit']]);
    Route::patch('roles/{id}', ['as' => 'roles.update', 'uses' => 'RoleController@update', 'middleware' => ['permission:role-edit']]);
    Route::delete('roles/{id}', ['as' => 'roles.destroy', 'uses' => 'RoleController@destroy', 'middleware' => ['permission:role-delete']]);

    Route::get('permissions', ['as' => 'permissions.index', 'uses' => 'PermissionController@index', 'middleware' => ['permission:permission-list|permission-create|permission-edit|permission-delete']]);
    Route::get('/permisions/datatable', ['as' => 'permissions.datatable', 'uses' => 'PermissionController@datatable', 'middleware' => ['permission:permission-list']]);
    Route::get('permissions/create', ['as' => 'permissions.create', 'uses' => 'PermissionController@create', 'middleware' => ['permission:permission-create']]);
    Route::post('permissions/create', ['as' => 'permissions.store', 'uses' => 'PermissionController@store', 'middleware' => ['permission:permission-create']]);
    Route::get('permissions/{id}', ['as' => 'permissions.show', 'uses' => 'PermissionController@show', 'middleware' => ['permission:permission-list']]);
    Route::get('permissions/{id}/edit', ['as' => 'permissions.edit', 'uses' => 'PermissionController@edit', 'middleware' => ['permission:permission-edit']]);
    Route::patch('permissions/{id}', ['as' => 'permissions.update', 'uses' => 'PermissionController@update', 'middleware' => ['permission:permission-edit']]);
	
	/* SUMMARY ROUTES */
    Route::get('delivery_summary', ['uses' => 'SummaryController@index']);
    Route::post('delivery_summary/datatable', ['as' => 'delivery_summary.datatable', 'uses' => 'Summarycontroller@datatable']);
    Route::post('delivery_summary/provinces', ['as' => 'delivery_summary.provinces', 'uses' => 'Summarycontroller@get_delivery_provinces']);
    Route::post('delivery_summary/municipalities', ['as' => 'delivery_summary.municipalities', 'uses' => 'Summarycontroller@get_delivery_municipalities']);

    Route::post('api/municipalities/report', ['as' => 'api.municipality.dropoff', 'uses' => 'ReportController@municipalityDropOff']);
    Route::post('api/dropoff/name', ['as' => 'api.dropoff.name', 'uses' => 'ReportController@dropOffName']);

    /* USER MANAGEMENT ROUTES - SG ACCREDITATION NUMBER */
    Route::post('users/assign', ['as' => 'users.assign.coopID', 'uses' => 'UserController@assignCoopID']);
    Route::post('users/assign/update', ['as' => 'users.update.coopID', 'uses' => 'UserController@updateCoopID']);

    /* SYSTEM SETTINGS ROUTES */
    //archive
    Route::get('settings/archive', ['as' => 'system.settings.archive', 'uses' => 'SettingsController@index']);
    Route::post('settings/archive/update', ['as' => 'system.settings.archive.update', 'uses' => 'SettingsController@updateActiveSeason']);
    //QR Code
    Route::get('settings/qr', ['as' => 'system.settings.qrcode', 'uses' => 'SettingsController@qr_home']);
    Route::post('settings/qr/update', ['as' => 'system.settings.qrcode.update', 'uses' => 'SettingsController@qr_update']);
    //Distribution per dropoff
    Route::get('settings/distribution', ['as' => 'system.settings.distribution', 'uses' => 'SettingsController@distribution_home']);
    Route::post('settings/distribution/table', ['as' => 'system.settings.distribution.table', 'uses' => 'SettingsController@distribution_tbl']);
    Route::post('settings/distribution/add', ['as' => 'system.settings.distribution.add', 'uses' => 'SettingsController@distribution_add_variables']);
    Route::post('settings/distribution/update', ['as' => 'system.settings.distribution.update', 'uses' => 'SettingsController@distribution_update_variables']);

    /*     * NEW INSPECTOR ROUTES */
    Route::get('inspector/registration', ['as' => 'rcef.inspection.registration', 'uses' => 'InspectionController@InspectorRegistrationForm']);
	Route::post('inspection/registration/save', ['as' => 'rcef.registry.registration.save', 'uses' => 'InspectionController@InspectorRegistrationSave']);
	Route::post('inspector/details', ['as' => 'rcef.inspector.details', 'uses' => 'InspectionController@InspectorDetails']);


    Route::post('api/municipalities/report', ['as' => 'api.municipality.dropoff', 'uses' => 'ReportController@municipalityDropOff']);
    Route::post('api/dropoff/name', ['as' => 'api.dropoff.name', 'uses' => 'ReportController@dropOffName']);
	
	Route::post('users/change_pass', ['as' => 'users.change_password', 'uses' => 'UserController@user_changePassword']);
	
	/**
     * EDIT DELIVERY
     */
    Route::get('delivery/edit/home', ['as' => 'edit_delivery.home', 'uses' => 'EditDeliveryController@home']);
    Route::post('delivery/edit/check_batch', ['as' => 'edit_delivery.check_batch', 'uses' => 'EditDeliveryController@check_batch']);
    Route::post('delivery/edit/seedtag_info', ['as' => 'edit_delivery.seedtag_info', 'uses' => 'EditDeliveryController@get_seedtag_info']);
    Route::post('delivery/edit/update_seedtag', ['as' => 'edit_delivery.update_seedtag', 'uses' => 'EditDeliveryController@update_seedtag_info']);
    Route::post('delivery/edit/update_dop', ['as' => 'edit_delivery.update_dop', 'uses' => 'EditDeliveryController@update_batch_dop']);
	
	/**
     * FLSAR export
     */
    Route::get('farmer/pre_list/{code}', ['as' => 'pre_list.home', 'uses' => 'FLSARController@generate_municipality']);
    Route::post('farmer/pre_list/municipalities', ['as' => 'pre_list.municipalities', 'uses' => 'FLSARController@get_municipalities']);
	Route::get('farmer/pre_list/blank/{page_count}', ['as' => 'pre_list.home.blank', 'uses' => 'FLSARController@generate_blank']);

	/**
     * DISTRIBUTION APP MONITORING | WEB
     */
    Route::post('distribution/app/municipalities', ['as' => 'distribution.app.get_stock_municipalities', 'uses' => 'DistMonitoringController@get_stock_municipalities']);
    Route::get('distribution/app/stocks', ['as' => 'distribution.app.stocks_home', 'uses' => 'DistMonitoringController@stocks_home']);
    Route::get('distribution/app/stocks/public', ['as' => 'distribution.app.stocks_home_public', 'uses' => 'DistMonitoringController@stocks_public_home']);
    Route::post('distribution/app/stocks/tbl', ['as' => 'distribution.app.stocks_tbl', 'uses' => 'DistMonitoringController@stocks_tbl']);
    Route::post('distribution/app/stocks/tbl_public', ['as' => 'distribution.app.stocks_tbl_public', 'uses' => 'DistMonitoringController@stocks_tbl_public']);
    Route::post('distribution/app/stocks/confirm_release', ['as' => 'distribution.app.confirm_release', 'uses' => 'DistMonitoringController@confirm_releaseOfStocks']);

	/**PAYMAYA ROUTES */
    Route::get('paymaya/inspector/ui', ['as' => 'paymaya.inspector_ui', 'uses' => 'PayMayaController@inspector_ui_home']);
    Route::get('paymaya/distribution', ['as' => 'paymaya.seed_distribution', 'uses' => 'PayMayaController@seed_distribution_home']);
    Route::get('paymaya/seedtags', ['as' => 'paymaya.list.seedTags.search', 'uses' => 'PayMayaController@search_seedtags']);
    Route::post('paymaya/seedtags/flag', ['as' => 'paymaya.seedTags.flag', 'uses' => 'PayMayaController@flag_seedtag_unusable']);
    //10-09-2020 (-PAYMAYA ROUTES)
    Route::post('paymaya/distribution/tbl/municipal', ['as' => 'paymaya.seed_distribution.tbl_municipal', 'uses' => 'PayMayaController@seed_distribution_tblMunicipal']);
    Route::post('paymaya/distribution/municipal/totals', ['as' => 'paymaya.seed_distribution.municipal_totals', 'uses' => 'PayMayaController@seed_distribution_municipal_totals']);
    Route::post('paymaya/distribution/municipal/list', ['as' => 'paymaya.seed_distribution.municipal_list', 'uses' => 'PayMayaController@seed_distribution_municipal_list']);
    //10-13-2020 (-PAYMAYA ROUTES)
    //Route::get('paymaya/report/provincial/daterange', ['as' => 'paymaya.report.provincial.daterange', 'uses' => 'PayMayaController@generate_provincial_report_with_date']);
    
    Route::get('paymaya/report/provincial/{province}/{from}/{to}', ['as' => 'paymaya.report.provincial', 'uses' => 'PayMayaController@generate_provincial_report']);
    Route::get('paymaya/report/municipal/{province}/{municipality}', ['as' => 'paymaya.report.municipal', 'uses' => 'PayMayaController@generate_municipal_report']);
    Route::get('paymaya/report/variety', ['as' => 'paymaya.variety_report', 'uses' => 'PayMayaController@variety_report_ui']);
    //10-14-2020 (-PAYMAYA ROUTES)
    Route::get('paymaya/report/beeneficiary', ['as' => 'paymaya.beneficiary_report', 'uses' => 'PayMayaController@beneficiary_report_home']);
    Route::post('paymaya/report/beeneficiary/province', ['as' => 'paymaya.beneficiary_report.province', 'uses' => 'PayMayaController@beneficiary_report_provincial_tbl']);
	
    Route::get('paymaya/report/beneficiary/codes', ['as' => 'paymaya.beneficiary.codes', 'uses' => 'PayMayaController@beneficiary_with_code']);
    Route::post('paymaya/report/beneficiary/gentable', ['as' => 'paymaya.beneficiary.gentable', 'uses' => 'PayMayaController@genTable_with_code']);
    Route::get('paymaya/unclaimed/codes/{province}/{municipality}/{week_uploaded}/{sched_start}/{sched_end}', ['as' => 'paymaya.unclaimed.codes', 'uses' => 'PayMayaController@exportUnclaimedCodes']);
	Route::post('paymaya/utility/update/area', ['as' => 'paymaya.utility.update_area', 'uses' => 'PayMayaController@update_area']);
    Route::post('paymaya/utility/cancel/distri', ['as' => 'paymaya.utility.cancel.delivery', 'uses' => 'PayMayaController@paymaya_cancel_delivery']);
    


	/**RCEF REPORT - GOOGLE SHEETS */
    Route::post('report/google_sheet/dashboard/chart', ['as' => 'rcep.google_sheet.dashboard_chart', 'uses' => 'ReportGoogleSheetController@generate_dashboard_chart']);
    Route::get('report/google_sheet/dashboard/', ['as' => 'rcep.google_sheet.dashboard', 'uses' => 'ReportGoogleSheetController@dashboard']);
    Route::post('report/google_sheet/weekly/tbl', ['as' => 'rcep.google_sheet.weekly.tbl', 'uses' => 'ReportGoogleSheetController@weekly_report_tbl']);
    Route::get('report/google_sheet/weekly/home', ['as' => 'rcep.google_sheet.weekly_home', 'uses' => 'ReportGoogleSheetController@view_weekly_ui_home']);
    Route::get('report/google_sheet/weekly/', ['as' => 'rcep.google_sheet.weekly', 'uses' => 'ReportGoogleSheetController@view_weekly_ui']);
    Route::post('report/google_sheet/weekly/provinces', ['as' => 'rcep.google_sheet.weekly.provinces', 'uses' => 'ReportGoogleSheetController@get_weeklyReport_provinces']);
    Route::post('report/google_sheet/weekly/municipalities', ['as' => 'rcep.google_sheet.weekly.municipalities', 'uses' => 'ReportGoogleSheetController@get_weeklyReport_municipalities']);
    Route::post('report/google_sheet/weekly/dop_municipalities', ['as' => 'rcep.google_sheet.weekly.dop_municipalities', 'uses' => 'ReportGoogleSheetController@get_weeklyReport_DOPmunicipalities']);
	Route::post('report/google_sheet/weekly/save', ['as' => 'rcep.google_sheet.weeklySave', 'uses' => 'ReportGSheetSavingController@save_weekly_data']);
    Route::post('report/google_sheet/weekly/update', ['as' => 'rcep.google_sheet.weeklyUpdate', 'uses' => 'ReportGSheetSavingController@update_weekly_data']);
    Route::get('report/google_sheet/weekly/edit/{id}', ['as' => 'rcep.google_sheet.weekly.edit', 'uses' => 'ReportGoogleSheetController@weekly_report_edit']);
    Route::get('report/google_sheet/schedule/home', ['as' => 'rcep.google_sheet.schedule_home', 'uses' => 'ReportGoogleSheetController@shedule_home']);
    Route::get('report/google_sheet/schedule/form', ['as' => 'rcep.google_sheet.schedule_form', 'uses' => 'ReportGoogleSheetController@shedule_form']);
    Route::post('report/google_sheet/municipalities', ['as' => 'rcep.google_sheet.municipalities', 'uses' => 'ReportGoogleSheetController@get_municipalities']);
    Route::post('report/google_sheet/pc_list', ['as' => 'rcep.google_sheet.pc_list', 'uses' => 'ReportGoogleSheetController@get_PCList']);
    Route::post('report/google_sheet/tbl', ['as' => 'rcep.google_sheet.tbl', 'uses' => 'ReportGoogleSheetController@schedule_tbl']);
    Route::post('report/google_sheet/tbl/transaction_details/save', ['as' => 'rcep.google_sheet.transaction_details.save', 'uses' => 'ReportGoogleSheetController@update_transaction_status']);
    Route::post('report/google_sheet/tbl/transaction_details', ['as' => 'rcep.google_sheet.transaction_details', 'uses' => 'ReportGoogleSheetController@get_transaction_details']);
    Route::post('report/google_sheet/tbl/filter/transaction_code', ['as' => 'rcep.google_sheet.tbl_filter_transaction_code', 'uses' => 'ReportGoogleSheetController@schedule_tbl_filter_transactionCode']);
    Route::get('report/google_sheet/view/{transaction_id}', ['as' => 'rcep.google_sheet.view', 'uses' => 'ReportGoogleSheetController@get_schedule_view']);
    Route::get('report/google_sheet/actual/{transaction_id}', ['as' => 'rcep.google_sheet.actual', 'uses' => 'ReportGoogleSheetController@get_schedule_actual']);
    Route::post('report/google_sheet/seeds', ['as' => 'rcep.google_sheet.seeds', 'uses' => 'ReportGoogleSheetController@refresh_seedList']);
    Route::post('report/google_sheet/save/variety_id', ['as' => 'rcep.google_sheet.variety_id', 'uses' => 'ReportGSheetSavingController@get_variety_id']);
    Route::post('report/google_sheet/save/variety_details', ['as' => 'rcep.google_sheet.variety_details', 'uses' => 'ReportGSheetSavingController@get_variety_details']);
    Route::post('report/google_sheet/save/new_ds2021', ['as' => 'rcep.google_sheet.saveNewDS2021', 'uses' => 'ReportGSheetSavingController@saveNewDS2021']);
    Route::post('report/google_sheet/save/inventory/warehouse', ['as' => 'rcep.google_sheet.saveInventory_warehouse', 'uses' => 'ReportGSheetSavingController@saveInventory_warehouse']);
    Route::post('report/google_sheet/save/inventory/lgu', ['as' => 'rcep.google_sheet.saveInventory_lgu', 'uses' => 'ReportGSheetSavingController@saveInventory_lgu']);
    Route::post('report/google_sheet/save/inventory/transferred', ['as' => 'rcep.google_sheet.saveInventory_transferred', 'uses' => 'ReportGSheetSavingController@saveInventory_transferred']);
    Route::post('report/google_sheet/edit/new_ds2021', ['as' => 'rcep.google_sheet.editNewDS2021', 'uses' => 'ReportGSheetSavingController@editNewDS2021']);
    Route::post('report/google_sheet/edit/inventory_warehouse', ['as' => 'rcep.google_sheet.editInventoryWarehouse', 'uses' => 'ReportGSheetSavingController@editInventoryWarehouse']);
    Route::post('report/google_sheet/edit/inventory_lgu', ['as' => 'rcep.google_sheet.editInventoryLgu', 'uses' => 'ReportGSheetSavingController@editInventoryLgu']);
    Route::post('report/google_sheet/edit/inventory_transferred', ['as' => 'rcep.google_sheet.editInventoryTransferred', 'uses' => 'ReportGSheetSavingController@editInventoryTransferred']);
    Route::post('report/google_sheet/actual/new_ds2021', ['as' => 'rcep.google_sheet.actualNewDS2021', 'uses' => 'ReportGSheetSavingController@actualNewDS2021']);
    Route::post('report/google_sheet/actual/inventory_warehouse', ['as' => 'rcep.google_sheet.actualInventoryWarehouse', 'uses' => 'ReportGSheetSavingController@actualInventoryWarehouse']);
    Route::post('report/google_sheet/actual/inventory_lgu', ['as' => 'rcep.google_sheet.actualInventoryLgu', 'uses' => 'ReportGSheetSavingController@actualInventoryLgu']);
    Route::post('report/google_sheet/actual/inventory_transferred', ['as' => 'rcep.google_sheet.actualInventoryTransferred', 'uses' => 'ReportGSheetSavingController@actualInventoryTransferred']);
	// 10-15-2020 (-GOOGLE SHEET ROUTES)
    Route::get('report/google_sheet/save/save_as_final/{transaction_code}', ['as' => 'rcep.google_sheet.save_as_final', 'uses' => 'ReportGSheetSavingController@schedule_saveAsFinal']);
    Route::get('report/weekly/generate', ['as' => 'report.generate.weekly', 'uses' => 'ReportGSheetSavingController@generate_weekly_data']);
    Route::post('report/google_sheet/dashboard/filter', ['as' => 'rcep.google_sheet.dashboard_filter', 'uses' => 'ReportGoogleSheetController@dashboard_filtered']);
    Route::post('report/google_sheet/category/filter', ['as' => 'rcep.google_sheet.category_filter', 'uses' => 'ReportGoogleSheetController@category_filtered']);
    Route::get('report/google_sheet/export/schedule/{month}/{week}/{category}', ['as' => 'rcep.google_sheet.export_schedule', 'uses' => 'ReportGoogleSheetController@export_schedule']);
	// 10-21-2020 (-GOOGLE SHEET ROUTES)
    Route::get('report/google_sheet/summary', ['as' => 'rcep.google_sheet.summary', 'uses' => 'ReportGoogleSheetController@view_summary']);
    Route::post('report/google_sheet/show_more', ['as' => 'rcep.google_sheet.show_more', 'uses' => 'ReportGoogleSheetController@show_more_function']);
	// 11-04-2020
    Route::get('report/google_sheet/summary/export', ['as' => 'rcep.google_sheet.summary_export', 'uses' => 'ReportGoogleSheetController@export_google_summary']);
	// 11-15-2020
    Route::get('report/google_sheet/schedule/export', ['as' => 'rcep.google_sheet.export_schedule', 'uses' => 'ReportGoogleSheetController@export_google_schedule']);
    Route::post('report/google_sheet/schedule/more', ['as' => 'rcep.google_sheet.schedule_more', 'uses' => 'ReportGoogleSheetController@schedule_show_more']);
	
	/**
     * DISTRIBUTION DASHBOARD ROUTES
     */
    //Route::get('distribution/dashboard', ['as' => 'rcep.distribution.dashboard', 'uses' => 'DistributionDashboardController@index']);
    Route::get('distribution/dashboard', ['as' => 'rcep.distribution.dashboard', 'uses' => 'DistributionDashboardController@pageClose']);
    Route::post('distribution/dashboard/tbl', ['as' => 'rcep.distribution.dashboard_tbl', 'uses' => 'DistributionDashboardController@distribution_main_tbl']);

	/**
     * NRP ROUTES
     */
    Route::post('nrp/provinces', ['as' => 'nrp.provinces', 'uses' => 'ReportController@nrp_provinces']);    
    Route::get('nrp/export/{province}', ['as' => 'nrp.provinces.export', 'uses' => 'reportExportController@export_nrp_function']);

	/**
     * 11-05-2020 REPORT ROUTES (AREA RANGE)
     */
    Route::get('report/area_range', ['as' => 'report.area_range', 'uses' => 'ReportController@areaRange_home']);
    Route::post('report/area_range/municipal', ['as' => 'report.area_range.municipal', 'uses' => 'ReportController@areaRange_municipalTBL']);
	
	/**
     * 11-06-2020 ANALYTICS ROUTES
     */
    Route::get('analytics/home', ['as' => 'analytics.home', 'uses' => 'AnalyticsController@home_ui']);
    Route::post('analytics/top5', ['as' => 'analytics.top5', 'uses' => 'AnalyticsController@top5_data']);
    Route::post('analytics/area_range', ['as' => 'analytics.area_range', 'uses' => 'AnalyticsController@area_range_data']);
    Route::post('analytics/top_provinces', ['as' => 'analytics.top_provinces', 'uses' => 'AnalyticsController@top_province_data']);
	//11-16-2020 ROUTES
    Route::post('analytics/summary_per_variety', ['as' => 'analytics.summary.per_variety', 'uses' => 'AnalyticsController@summary_per_variety_data']);
    Route::post('analytics/summary_per_variety/chart', ['as' => 'analytics.summary.per_variety_chart', 'uses' => 'AnalyticsController@summary_per_variety_data_chart']);
	
	//01-06-2021
    Route::post('cooperatives/commitment/download', ['as' => 'coop.commitment.download', 'uses' => 'CoopController@download_commitment_of_coops']);
    Route::get('cooperatives/commitment/regional/{coop_id}', ['as' => 'coop.regional_commitment', 'uses' => 'CoopController@regional_commitments']);
    Route::post('cooperatives/commitment/regional/save', ['as' => 'coop.regional_commitment.save', 'uses' => 'CoopController@regional_commitments_save']);
    Route::get('cooperatives/commitment/regional/delete/{regional_commitment_ID}', ['as' => 'coop.regional_commitment.delete', 'uses' => 'CoopController@regional_commitments_delete']);
    Route::post('cooperatives/commitment/regional/check_seeds', ['as' => 'coop.regional_commitment.check_seeds', 'uses' => 'CoopController@regional_check_seeds']);
    Route::post('cooperatives/commitment/regional/search_allocations', ['as' => 'coop.regional_commitment.search_allocations', 'uses' => 'CoopController@regional_search_allocations']);

	//01-29-2021
    Route::post('cooperatives/adjustment/varities', ['as' => 'coop.adjustment.varities', 'uses'=>'CoopController@coopAdjustmentVarities']);
    Route::post('cooperatives/adjustment/regions', ['as' => 'coop.adjustment.regions', 'uses'=>'CoopController@coopAdjustmentRegions']);
    Route::post('cooperatives/adjustment/add_allocation', ['as' => 'coop.adjustment.add', 'uses'=>'CoopController@coopAdjustmentAddAllocation']);
    Route::post('cooperatives/adjustment/deduct_allocation', ['as' => 'coop.adjustment.deduct', 'uses'=>'CoopController@coopAdjustmentDeductAllocation']);
    Route::post('cooperatives/adjustment/logs', ['as' => 'coop.adjustment.logs', 'uses'=>'CoopController@coopAdjustmentLogs']);
	
	//02-09-2021
	Route::get('coop/operator/report', ['as' => 'coop_operator.report', 'uses'=>'CoopOperatorController@coop_report_home']);
	Route::post('coop/operator/report/sg', ['as' => 'coop_operator.report.sg', 'uses'=>'CoopOperatorController@coop_report_sgList']);
	
	//02-19-2021
	Route::get('coop/operator/enrollment', ['as' => 'coop_operator.sg_enrollment', 'uses'=>'CoopOperatorController@SGEnrollment']);
	Route::post('coop/operator/enrollment/save', ['as' => 'coop_operator.sg_enrollment.save', 'uses'=>'CoopOperatorController@SGEnrollmentConfirm']);
	Route::post('coop/operator/enrollment/tbl', ['as' => 'coop_operator.sg_enrollment.tbl', 'uses'=>'CoopOperatorController@SGEnrollmentTable']);
	Route::post('coop/operator/enrollment/summary', ['as' => 'coop_operator.sg_enrollment.summary', 'uses'=>'CoopOperatorController@SGEnrollmentSUmmary']);
	Route::post('coop/operator/enrollment/delete', ['as' => 'coop_operator.sg_enrollment.delete', 'uses'=>'CoopOperatorController@SGEnrollmentDelete']);
	Route::post('coop/operator/enrollment/edit_show', ['as' => 'coop_operator.sg_enrollment.edit_show', 'uses'=>'CoopOperatorController@SGEnrollmentEditDetails']);
    Route::post('coop/operator/enrollment/edit', ['as' => 'coop_operator.sg_enrollment.edit_confirm', 'uses'=>'CoopOperatorController@SGEnrollmentEditConfirm']);
   
	Route::get('coop/operator/matrix', ['as' => 'coop_operator.sg_matrix', 'uses'=>'CoopOperatorController@SGMatrix']);
    Route::post('coop/operator/matrix/varieties', ['as' => 'coop_operator.sg_matrix.varieties', 'uses'=>'CoopOperatorController@SGMatrixVarieties']);
    
    Route::post('/coop/operator/matrix/tbl', ['as' => 'coop_operator.sg_matrix.tbl', 'uses' => 'CoopOperatorController@SGMatrixTable']);
    Route::post('/coop/operator/matrix/commitment', ['as' => 'coop_operator.sg_matrix.commitment', 'uses' => 'CoopOperatorController@SGGetVariety']);
    Route::post('/coop/operator/matrix/confirm', ['as' => 'coop_operator.sg_matrix.confirm', 'uses' => 'CoopOperatorController@SGconfirm']);
    Route::post('/coop/operator/matrix/remove', ['as' => 'coop_operator.sg_matrix.remove', 'uses' => 'CoopOperatorController@SGremove']);

    //payment routes #newroutes-payment
    Route::get('payment_dashboard/home', ['as' => 'payment_dashboard.home', 'uses' => 'PaymentDashboardController@index']);
    Route::post('payment_dashboard/iar_tbl/home', ['as' => 'payment_dashboard.iar_tbl.home', 'uses' => 'PaymentDashboardController@iar_tbl_home']);
    Route::post('payment_dashboard/iar_tbl/particulars', ['as' => 'payment_dashboard.particulars', 'uses' => 'PaymentDashboardController@particularsPreview']);
    Route::get('payment/get/api', ['as' => 'view.get.api.fmis', 'uses' => 'PaymentDashboardController@getFmisApi']);

     //import routes #newroutes-import
    Route::get('import/seed_growers', ['as' => 'import.seed_growers', 'uses' => 'ImportController@seed_growers']);
    Route::get('import/RLA', ['as' => 'import.rla', 'uses' => 'ImportController@rla']);
    Route::get('import/ebinhi', ['as' => 'import.ebinhi', 'uses' => 'ImportController@ebinhi']);
    Route::get('import/ebinhi/update/status', ['as' => 'import.ebinhi.update.status', 'uses' => 'ImportController@ebinhi_update_status']);
    Route::post('import/json', ['as' => 'import.file.json', 'uses' => 'ImportController@import_file']);
    Route::post('util/import_data_rla', ['as' => 'util.import_csv.rla', 'uses' => 'ImportController@import_data_rla']);
    
    Route::post('import/table/seed_growers', ['as' => 'import.table.seed_growers', 'uses' => 'ImportController@sg_commitment_table']);
    Route::post('import/table/rla', ['as' => 'import.table.rla', 'uses' => 'ImportController@rla_table']);
    Route::post('import/table/ebinhi', ['as' => 'import.table.ebinhi', 'uses' => 'ImportController@ebinhi_table']);
    Route::post('import/table/ebinhi/update/status', ['as' => 'import.table.ebinhi.update.status', 'uses' => 'ImportController@ebinhi_update_status_table']);

         // palaysikatan routes #newroutes-palaysikatan
    Route::get('palaysikatan/farmers', ['as' => 'palaysikatan.farmers', 'uses' => 'PalaysikatanController@farmers_view']);
    Route::get('palaysikatan/farmers/datatable', ['as' => 'palaysikatan.farmers.datatable', 'uses' => 'PalaysikatanController@farmers_datatable']);
    Route::post('palaysikatan/province', ['as' => 'palaysikatan.province', 'uses' => 'PalaysikatanController@province']);
    Route::post('palaysikatan/municipality', ['as' => 'palaysikatan.municipality', 'uses' => 'PalaysikatanController@municipality']);
    Route::get('palaysikatan/form/farmer', ['as' => 'palaysikatan.form.farmer', 'uses' => 'PalaysikatanController@farmer_form']);
    Route::post('palaysikatan/add/farmer', ['as' => 'palaysikatan.add.farmer', 'uses' => 'PalaysikatanController@new_farmer']);
    Route::get('palaysikatan/form/planting/{id}', ['as' => 'palaysikatan.form.planting', 'uses' => 'PalaysikatanController@planting_form']);
    Route::post('palaysikatan/add/planting', ['as' => 'palaysikatan.add.planting', 'uses' => 'PalaysikatanController@new_planting']);
    Route::post('palaysikatan/insert/planting', ['as' => 'palaysikatan.insert.planting', 'uses' => 'PalaysikatanController@insert_planting']);
    Route::get('palaysikatan/farmer/edit/{id}', ['as' => 'palaysikatan.farmer.edit', 'uses' => 'PalaysikatanController@edit_farmer']);
    Route::post('palaysikatan/update/farmer', ['as' => 'palaysikatan.update.farmer', 'uses' => 'PalaysikatanController@update_farmer']);
     Route::get('palaysikatan/farmer/material/{id}', ['as' => 'palaysikatan.farmer.material', 'uses' => 'PalaysikatanController@material_form']);
    Route::post('palaysikatan/insert/material', ['as' => 'palaysikatan.insert.material', 'uses' => 'PalaysikatanController@insert_material']);
    Route::post('palaysikatan/update/date', ['as' => 'palaysikatan.save_date', 'uses' => 'PalaysikatanController@save_date']);
    Route::get('palaysikatan/export/report/{station}', ['as' => 'palaysikatan.export.report', 'uses' => 'PalaysikatanController@exportExcel']);

    Route::post('palaysikatan/farmers/get-station-province', ['as' => 'palaysikatan.farmers.get-station-province', 'uses' => 'PalaysikatanController@get_station_province']);
    Route::post('palaysikatan/farmers/datatable-filter', ['as' => 'palaysikatan.farmers.datatable-filter', 'uses' => 'PalaysikatanController@farmers_datatable_filter']);

    
    //PALAYSIKATAN DASHBOARD
    /* Route::get('palaysikatan/dashboard', ['as' => 'palaysikatan.dashboard.index', 'uses' => 'PalaysikatanDashboardController@index']);
    Route::post('palaysikatan/dashboard/sitetbl', ['as' => 'palaysikatan.dashboard.sitetbl', 'uses' => 'PalaysikatanDashboardController@load_site_tbl']);
    Route::post('palaysikatan/dashboard/province_list', ['as' => 'palaysikatan.dashboard.province_list', 'uses' => 'PalaysikatanDashboardController@province_list']); */
    Route::get('palaysikatan/dashboard', ['as' => 'palaysikatan.dashboard.index', 'uses' => 'PalaysikatanDashboardController@index']);
    Route::post('palaysikatan/dashboard/sitetbl', ['as' => 'palaysikatan.dashboard.sitetbl', 'uses' => 'PalaysikatanDashboardController@load_site_tbl']);
    Route::post('palaysikatan/dashboard/province_list', ['as' => 'palaysikatan.dashboard.province_list', 'uses' => 'PalaysikatanDashboardController@province_list']);
    Route::post('palaysikatan/dashboard/municipal_list', ['as' => 'palaysikatan.dashboard.municipal_list', 'uses' => 'PalaysikatanDashboardController@municipal_list']);
    Route::post('palaysikatan/dashboard/fca_list_tbl', ['as' => 'palaysikatan.dashboard.fca_list_tbl', 'uses' => 'PalaysikatanDashboardController@fca_list_tbl']);
    Route::get('palaysikatan/dashboard/export', ['as' => 'palaysikatan.dashboard.export', 'uses' => 'PalaysikatanDashboardController@exportPalaysikatanTable']);
    Route::post('palaysikatan/dashboard/municipal_list2', ['as' => 'palaysikatan.dashboard.municipal_list2', 'uses' => 'PalaysikatanDashboardController@municipal_list2']);
    Route::post('palaysikatan/dashboard/coveredHa', ['as' => 'palaysikatan.dashboard.coveredHa', 'uses' => 'PalaysikatanDashboardController@coveredHa']);
    Route::get('palaysikatan/dashboard/crop-stage', ['as' => 'palaysikatan.dashboard.crop-stage', 'uses' => 'PalaysikatanDashboardController@cropStages']);
    Route::post('palaysikatan/encoderInfo', ['as' => 'palaysikatan.encoderInfo', 'uses' => 'PalaysikatanDashboardController@encoderData']);
    Route::post('palaysikatan/station-status', ['as' => 'palaysikatan.station-status', 'uses' => 'PalaysikatanDashboardController@station_status']);
    Route::post('palaysikatan/selectVariety', ['as' => 'palaysikatan.selectVariety', 'uses' => 'PalaysikatanController@seedVariety']);
    Route::get('palaysikatan/export/report_matrix/{station}', ['as' => 'palaysikatan.export.report', 'uses' => 'PalaysikatanController@matrix']);
    Route::post('palaysikatan/farmers/delete', ['as' => 'palaysikatan.farmers.delete', 'uses' => 'PalaysikatanController@farmers_delete']);
    Route::get('palaysikatan/tdo-data', ['as' => 'palaysikatan.tdo-data', 'uses' => 'PalaysikatanController@tdoList']);
    Route::post('palaysikatan/station-status-list', ['as' => 'palaysikatan.station-status-list', 'uses' => 'PalaysikatanController@station_status_list']);
    Route::post('palaysikatan/tdoNtEncode', ['as' => 'palaysikatan.tdoNtEncode', 'uses' => 'PalaysikatanController@tdoNtEncode']);
    Route::post('palaysikatan/tdoNtEncode_get_one', ['as' => 'palaysikatan.tdoNtEncode_get_one', 'uses' => 'PalaysikatanController@tdoNtEncode_get_one']);
	// Farmer validation routes
    Route::get('caller/farmers', ['as' => 'sed.farmers', 'uses' => 'SEDCallerController@index', 'middleware' => ['role:sed-caller']]);
    Route::get('enumarators', ['as' => 'sed.enumarators', 'uses' => 'SEDCallerController@enumarators', 'middleware' => ['role:sed-caller']]);
    Route::get('sed/datatable/farmers', ['as' => 'sed.farmers.datatable', 'uses' => 'SEDCallerController@farmers_datatable']);
    Route::post('sed/callers/dashboard', ['as' => 'sed.callers.dashboard', 'uses' => 'SEDCallerController@callers_dashboard']);
    Route::post('sed/verification/form/first', ['as' => 'sed.verification.form.first', 'uses' => 'SEDCallerController@first_form_modal']);
    Route::post('sed/verification/form/failed', ['as' => 'sed.verification.form.failed', 'uses' => 'SEDCallerController@failedCall']);
    Route::post('sed/season/weeks', ['as' => 'sed.season.weeks', 'uses' => 'SEDCallerController@season_weeks']);
    Route::post('sed/verification/form', ['as' => 'sed.verification.form', 'uses' => 'SEDCallerController@verifyModal']);
    Route::post('sed/verification/form/save', ['as' => 'sed.verification.form.save', 'uses' => 'SEDCallerController@save_verified_data']);
    Route::post('sed/verification/form/cancel', ['as' => 'sed.verification.form.cancel', 'uses' => 'SEDCallerController@cancel_verified_data']);
    Route::post('sed/verification/form/no', ['as' => 'sed.verification.form.no', 'uses' => 'SEDCallerController@verifyModalNo']);
    Route::post('sed/verification/form/save/no', ['as' => 'sed.verification.form.save.no', 'uses' => 'SEDCallerController@save_verified_data_no']);
    // SED Management
    Route::get('sed/dashboard', ['as' => 'sed.dashboard', 'uses' => 'SEDCallerController@dashboard', 'middleware' => ['role:sed-caller-manager']]);
    Route::get('sed/manage', ['as' => 'sed.manage', 'uses' => 'SEDCallerController@callers_management', 'middleware' => ['role:sed-caller-manager']]);
    Route::get('sed/manage/farmer', ['as' => 'sed.manage.farmer', 'uses' => 'SEDCallerController@manage_farmer', 'middleware' => ['role:sed-caller-manager']]);
    Route::get('sed/users/datatable', ['as' => 'sed.users.datatable', 'uses' => 'SEDCallerController@datatable', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/users/form', ['as' => 'sed.users.form', 'uses' => 'SEDCallerController@user_form', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/users/form/save', ['as' => 'sed.users.form.save', 'uses' => 'SEDCallerController@save_user', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/users/delete', ['as' => 'sed.users.delete', 'uses' => 'SEDCallerController@delete_user', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/users/assign/municipality', ['as' => 'sed.assign.municipality', 'uses' => 'SEDCallerController@assign_municipality', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/users/assign/municipality/save', ['as' => 'sed.assign.municipality.save', 'uses' => 'SEDCallerController@edit_municipality', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/farmers/manage/datatable', ['as' => 'sed.farmers.manage.datatable', 'uses' => 'SEDCallerController@manage_farmers_datatable', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/farmers/manage/summary', ['as' => 'sed.farmers.manage.summary', 'uses' => 'SEDCallerController@manage_farmers_summary', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/dashboard/datatable', ['as' => 'sed.dashboard.datatable', 'uses' => 'SEDCallerController@dashboard_datatable', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/dashboard/municipality/data', ['as' => 'sed.dashboard.municipality.data', 'uses' => 'SEDCallerController@load_data_municipalities', 'middleware' => ['role:sed-caller-manager']]);

    Route::get('sed/farmers', ['as' => 'sed.farmers', 'uses' => 'SEDCallerController@edit_farmer', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/verified/farmers', ['as' => 'sed.verified.datatable', 'uses' => 'SEDCallerController@verified_farmers_datatable']);
    Route::post('sed/verified/municipality/data', ['as' => 'sed.verified.municipality.data', 'uses' => 'SEDCallerController@load_verified_municipalities', 'middleware' => ['role:sed-caller-manager']]);
    Route::post('sed/verified/municipalities', ['as' => 'sed.verified.municipalities', 'uses' => 'SEDCallerController@load_verified_municipalities_list', 'middleware' => ['role:sed-caller-manager']]);

    Route::post('sed/verified/verification/form/first', ['as' => 'sed.verified.verification.form.first', 'uses' => 'SEDCallerController@verified_first_form_modal']);
    Route::post('sed/verification/push/verified', ['as' => 'sed.verification.push.verified', 'uses' => 'SEDCallerController@push_verified_data']);
    
    Route::post('sed/municipality', ['as' => 'sed.municipality', 'uses' => 'SEDCallerController@municipality']);
    Route::post('sed/enable/edit', ['as' => 'sed.enable.edit', 'uses' => 'SEDCallerController@enable_edit']);
    Route::post('sed/enable/edit/view', ['as' => 'sed.enable.edit.view', 'uses' => 'SEDCallerController@enable_edit_view']);

    Route::post('sed/load/allocation/details', ['as' => 'sed.load.allocation.details', 'uses' => 'SEDCallerController@assign_allocation_details']);

    Route::get('sed/excel/verified/{prv}', ['as' => 'sed.excel.verified', 'uses' => 'SEDCallerController@excel_verified_farmers', 'middleware' => ['role:sed-caller-manager']]);
    Route::get('sed/excel/verified/sra/{prv}', ['as' => 'sed.excel.verified.sra', 'uses' => 'SEDCallerController@excel_verified_farmers_sra', 'middleware' => ['role:sed-caller-manager']]);
    Route::get('sed/excel/summary/{prv}/{muni}/{status}/{user}/{datefrom}/{dateto}', ['as' => 'sed.excel.summary', 'uses' => 'SEDCallerController@excel_detaailed_summary', 'middleware' => ['role:sed-caller-manager']]);


    // SRA DAshboard
    Route::get('sra/paymaya/dashboard', ['as' => 'sra.paymaya.dashboard', 'uses' => 'SRADashboardController@index' ]);
    Route::post('paymaya/graph/dashboard', ['as' => 'paymaya.graph.dashboard', 'uses' => 'SRADashboardController@graphLoad']);

    // SRA Troubleshooting
    Route::get('sra/paymaya/troubleshooting', ['as' => 'sra.paymaya.troubleshooting', 'uses' => 'SRADashboardController@troubleshooting' ]);
    Route::post('sra/troubleshooting/paymaya/datatable', ['as' => 'sra.troubleshooting.paymaya.datatable', 'uses' => 'SRADashboardController@troubleshooting_datatable']);
    Route::post('sra/load/baranggay', ['as' => 'sra.load.baranggay', 'uses' => 'SRADashboardController@load_paymaya_baranggay']);
    Route::post('sra/load/varieties', ['as' => 'sra.load.varieties', 'uses' => 'SRADashboardController@load_paymaya_varieties']);

    // E-binhi routes for municipality editing
    Route::get('paymaya/municipalities/list', ['as' => 'paymaya.municipalities.list', 'uses' => 'SEDCallerController@ebinhi_municipalities']);
    Route::get('ebinhi/municipality/datatable', ['as' => 'ebinhi.municipality.datatable', 'uses' => 'SEDCallerController@municipality_datatable']);
    Route::post('ebinhi/municipality/edit', ['as' => 'ebinhi.municipality.edit', 'uses' => 'SEDCallerController@municipality_edit']);



    // for farmer id incrementaion
    // Route::get('paymaya/increment/farmer_id', ['as' => 'paymaya.increment.farmer_id', 'uses' => 'SEDCallerController@increment_farmerid']);

    // SRA DAshboard revised dashboard 
    Route::get('sra/paymaya/', ['as' => 'sra.paymaya', 'uses' => 'SRADashboardController@sra_dashboard' ]);
    Route::get('sra/dop/', ['as' => 'sra.paymaya', 'uses' => 'SRADashboardController@dop_view' ]);
    Route::post('sra/paymaya/load/municipality', ['as' => 'sra.paymaya.load.municipality', 'uses' => 'SRADashboardController@load_municipalities_list' ]);
    Route::post('sra/paymaya/load/barangay', ['as' => 'sra.paymaya.load.barangay', 'uses' => 'SRADashboardController@load_baranggay_list' ]);
    Route::post('sra/paymaya/load/farmers', ['as' => 'sra.paymaya.load.farmers', 'uses' => 'SRADashboardController@load_farmer_list' ]);
    Route::post('sra/paymaya/load/farmers/datatable', ['as' => 'sra.paymaya.load.farmers.datatable', 'uses' => 'SRADashboardController@load_farmer_datatable' ]);
    Route::get('sra/paymaya/dop/datatable', ['as' => 'sra.paymaya.dop.datatable', 'uses' => 'SRADashboardController@load_dop_datatable' ]);
    Route::post('sra/paymaya/dop/save', ['as' => 'sra.paymaya.dop.save', 'uses' => 'SRADashboardController@save_dop' ]);
    Route::post('sra/dop/view/edit', ['as' => 'sra.dop.view.edit', 'uses' => 'SRADashboardController@edit_view_dop' ]);
    Route::post('sed/dop/form/edit', ['as' => 'sra.dop.form.edit', 'uses' => 'SRADashboardController@edit_form_dop' ]);
    Route::post('sed/dop/form/edit/farmers', ['as' => 'sra.dop.form.edit.farmers', 'uses' => 'SRADashboardController@edit_form_dop_farmers' ]);
    Route::post('sra/paymaya/load/selected/farmers/datatable', ['as' => 'sra.paymaya.load.selected.farmers.datatable', 'uses' => 'SRADashboardController@load_selected_farmer_datatable' ]);
    Route::post('ebinhi/scheduler/exclude', ['as' => 'ebinhi.scheduler.exclude', 'uses' => 'SRADashboardController@exclude_farmer' ]);
    Route::post('sra/scheduling/save', ['as' => 'sra.scheduling.save', 'uses' => 'SRADashboardController@save_scheduling' ]);

    Route::get('sra/utility/', ['as' => 'sra.utility', 'uses' => 'SRADashboardController@utility' ]);
    Route::POST('sra/utility/untagged/count', ['as' => 'sra.utility.untagged.count', 'uses' => 'SRADashboardController@getUntaggedCount' ]);
    Route::POST('sra/utility/tag', ['as' => 'sra.utility.tag', 'uses' => 'SRADashboardController@tagUntagged' ]);

  

    // scheduled farmers routes
    Route::get('sra/scheduled/farmers', ['as' => 'sra.scheduled.farmers', 'uses' => 'SRADashboardController@scheduled_farmers' ]);
    Route::post('sra/paymaya/load/scheduled/batch', ['as' => 'sra.paymaya.load.scheduled.batch', 'uses' => 'SRADashboardController@load_scheduled_batch' ]);
    Route::post('sra/paymaya/load/scheduled/farmers', ['as' => 'sra.paymaya.load.scheduled.farmers', 'uses' => 'SRADashboardController@load_scheduled_farmer_list' ]);
    Route::post('sra/paymaya/load/scheduled/farmers/datatable', ['as' => 'sra.paymaya.load.scheduled.farmers.datatable', 'uses' => 'SRADashboardController@load_scheduled_farmer_datatable' ]);
    Route::post('sra/paymaya/get/sms/farmers', ['as' => 'sra.paymaya.get.sms.farmers', 'uses' => 'SRADashboardController@getBatchDetails' ]);
    Route::post('sra/paymaya/delete/scheduled/farmers', ['as' => 'sra.paymaya.get.sms.farmers', 'uses' => 'SRADashboardController@deleteBatch' ]);
    Route::post('sra/paymaya/update/sent/status', ['as' => 'sra.paymaya.update.sent.status', 'uses' => 'SRADashboardController@update_sent_status' ]);

    Route::post('sra/dop/view/edited/farmers', ['as' => 'sra.dop.view.edited.farmers', 'uses' => 'SRADashboardController@view_scheduled_farmers' ]);
    Route::post('sra/dop/view/edited/farmers/datatable', ['as' => 'sra.dop.view.edited.farmers.datatable', 'uses' => 'SRADashboardController@view_scheduled_farmers_datatable' ]);
    Route::post('sra/paymaya/get/sms/edited/dop/farmers', ['as' => 'sra.paymaya.get.sms.farmers', 'uses' => 'SRADashboardController@getFarmersDOPDetails' ]);
    Route::post('sra/paymaya/update/sent/dop/status', ['as' => 'sra.paymaya.update.sent.dop.status', 'uses' => 'SRADashboardController@update_sent_dop_status' ]);

    Route::post('sra/paymaya/municipality', ['as' => 'sra.paymaya.municipality', 'uses' => 'SRADashboardController@municipality']);

    Route::get('sra/explode/barangay', ['as' => 'sra.explode.barangay', 'uses' => 'SRADashboardController@extract_baranggay_code' ]);
    // Route::get('sra/get/sed/id', ['as' => 'sra.get.sed.id', 'uses' => 'SRADashboardController@get_sed_id' ]);



    // RCEF Extension | Modules
    Route::get('extension/home', ['as' => 'rcef.extension.home', 'uses' => 'extensionController@home_page' ]);
    Route::post('extension/dbconnect', ['as' => 'rcef.extension.connect.db', 'uses' => 'extensionController@connectDatabase' ]);
    Route::post('extension/municipality_list', ['as' => 'rcef.extension.municipality', 'uses' => 'extensionController@municipality_list' ]);
    
    Route::post('extension/load_card', ['as' => 'rcef.extension.load_card', 'uses' => 'extensionController@load_card' ]);
    Route::post('extension/load_search', ['as' => 'rcef.extension.load_search', 'uses' => 'extensionController@load_search' ]);
        


    Route::post('extension/gen_table', ['as' => 'rcef.extension.gen_table', 'uses' => 'extensionController@genTable' ]);
    Route::post('extension/insert/data', ['as' => 'rcef.extension.insert.data', 'uses' => 'extensionController@insertData' ]);




});




/** USER MANAGEMENT - RESET PASSWORD */
Route::post('users/reset', ['as' => 'users.reset', 'uses' => 'UserController@resetPassword']);

//route for scheduled reports
Route::get('report_lib', ['as' => 'rcef.report', 'uses' => 'ReportController@scheduledReport']);

Route::get('report', ['as' => 'rcef.report_yield', 'uses' => 'ReportController@process_yield']);
Route::post('report_national_refresh', ['as' => 'rcef.national_refresh', 'uses' => 'ReportController@national_refresh']);
Route::get('report_statistics', ['as' => 'rcef.report', 'uses' => 'ReportController@generate_statistics']);
Route::get('force/report/variety', ['as' => 'rcef.force.variety.report', 'uses' => 'ReportController@forceUpdateVarities']);
Route::get('station_report/compute/station_data', ['as' => 'station_report.compute_station_data', 'uses' => 'StationReportController@compute_station_data']);
Route::get('delivery_mirror_execution', ['as' => 'rcef.delivery.mirror_exec', 'uses' => 'ReportController@execute_mirror_db']);
Route::get('report/generate_excel_list', ['as' => 'rcef.report.excel_list', 'uses' => 'ReportController@generate_excel_server_list']);
Route::post('api/registered/farmers', ['as' => 'api.rcef.registered.farmers', 'uses' => 'APIController@APIRegisteredFarmers']);
Route::post('api/province', ['as' => 'api.province', 'uses' => 'APIController@provinceList']);
Route::post('api/municipalities', ['as' => 'api.municipality', 'uses' => 'APIController@MunicipalityList']);
Route::post('api/registered/farmers/details', ['as' => 'api.farmer.details', 'uses' => 'APIController@RegisteredFarmerDetails']);
Route::post('api/summary/regions', ['as' => 'api.summary.regions', 'uses' => 'APIController@RegionSummary']);
Route::get('api/fetch/other_info/{code}', ['as' => 'api.fetch.other_info', 'uses' => 'APIController@API_fetch_otherInfo']);
Route::get('api/fetch/farmer_profile/{code}', ['as' => 'api.fetch.farmer_profile', 'uses' => 'APIController@API_fetch_farmerProfile']);
Route::get('api/fetch/preList/{code}', ['as' => 'api.fetch.preList', 'uses' => 'APIController@API_fetch_preList']);


//API FOR PRE_REG
Route::get('api/pre_reg/fetch/farmer_profile/{code}', ['as' => 'api.fetch.farmer_profile', 'uses' => 'APIController@API_fetch_farmerProfile_with_PreReg']);


//BETA
Route::get('ws2021/api/fetch/farmer_profile/{code}', ['as' => 'api.fetch.farmer_profile', 'uses' => 'APIController@API_fetch_farmerProfileZeroArea']);
Route::get('ws2021/api/fetch/other_info/{code}', ['as' => 'api.fetch.other_info', 'uses' => 'APIController@API_fetch_otherInfoWs2021']);
//FAR GENERATION
Route::get('fargeneration', ['as' => 'FarGeneration.index', 'uses' => 'FarGenerationController@index'])->middleware('auth');
//Route::get('fargeneration', ['as' => 'FarGeneration.index', 'uses' => 'FarGenerationController@pageClose'])->middleware('auth');
Route::get('fargeneration/get_municipalities/{province}', ['as' => 'FarGeneration.get_municipalities', 'uses' => 'FarGenerationController@get_municipalities']);
Route::get('fargeneration/get_region/{province}', ['as' => 'FarGeneration.get_region', 'uses' => 'FarGenerationController@get_region']);
  Route::get('fargeneration/get_report_beneficiary/{region}/{province}/{municipality}/{checkbox}', ['as' => 'FarGeneration.get_report_beneficiary', 'uses' => 'FarGenerationController@get_report_beneficiary']);
  Route::get('fargeneration/pre_list/all/{region}/{province}/{municipality}/{rowFrom}/{rowTo}/{maxRow}/{checkbox}', ['as' => 'pre_list.all.beneficiary', 'uses' => 'FarGenerationController@generate_Provincemunicipality_serverSide'])->middleware('auth');

// Route::get('fargeneration/get_report_beneficiary/{region}/{province}/{municipality}/{checkbox}', ['as' => 'FarGeneration.get_report_beneficiary', 'uses' => 'FarGenerationController@pageClose']);
// Route::get('fargeneration/pre_list/all/{region}/{province}/{municipality}/{rowFrom}/{rowTo}/{maxRow}/{checkbox}', ['as' => 'pre_list.all.beneficiary', 'uses' => 'FarGenerationController@pageClose'])->middleware('auth');

//PRE_REGISTRATION FAR
Route::get('fargeneration/pre_reg', ['as' => 'FarGenerationPreReg.index', 'uses' => 'FarGenerationController@indexPreReg'])->middleware('auth');
Route::get('fargeneration/pre_reg/get_municipalities/{province}', ['as' => 'FarGenerationPreReg.get_municipalities', 'uses' => 'FarGenerationController@get_municipalitiesPreReg']);
Route::get('fargeneration/pre_reg/get_brgy/{municipality}', ['as' => 'FarGenerationPreReg.get_brgy', 'uses' => 'FarGenerationController@get_brgy_preReg']);
Route::get('fargeneration/pre_reg/get_report_beneficiary/{province}/{municipality}/{brgy}', ['as' => 'FarGenerationPreReg.get_report_beneficiary', 'uses' => 'FarGenerationController@get_report_beneficiaryPreReg']);
Route::get('fargeneration/pre_reg/pdf/{province}/{municipality}/{brgy}/{rowFrom}/{rowTo}/{size}', ['as' => 'api.far.pdf.pre_reg', 'uses'=>'FarGenerationController@makePdfFAR_pre_reg']);


//PREVIOUS SEASON FAR
Route::get('fargeneration/ps', ['as' => 'FarGenerationPs.index', 'uses' => 'FarGenerationController@indexPs'])->middleware('auth');
 
Route::get('fargeneration/ps/get_brgy/{municipality}', ['as' => 'FarGenerationPs.get_brgy', 'uses' => 'FarGenerationController@get_brgy']);
Route::get('fargeneration/ps/get_municipalities/{province}', ['as' => 'FarGenerationPs.get_municipalities', 'uses' => 'FarGenerationController@get_municipalitiesPs']);
Route::get('fargeneration/ps/get_region/{province}', ['as' => 'FarGenerationPs.get_region', 'uses' => 'FarGenerationController@get_regionPs']);
Route::get('fargeneration/ps/get_report_beneficiary/{province}/{municipality}/{brgy}', ['as' => 'FarGenerationPs.get_report_beneficiary', 'uses' => 'FarGenerationController@get_report_beneficiaryPs']);


Route::get('fargeneration/prev/pdf/{province}/{municipality}/{brgy}/{rowFrom}/{rowTo}/{size}', ['as' => 'api.far.pdf.ps', 'uses'=>'FarGenerationController@makePdfFAR']);
Route::get('fargeneration/new/blank/pdf/{size}/{page_count}', ['as' => 'api.far.pdf.ps', 'uses'=>'FarGenerationController@makePdfFAR_blank']);
Route::get('fargeneration/prev/excel/{province}/{municipality}/{rowFrom}/{rowTo}', ['as' => 'api.far.excel.ps', 'uses'=>'FarGenerationController@makeExcelFAR']);



// Route::get('fargeneration/ps/get_brgy/{municipality}', ['as' => 'FarGenerationPs.get_brgy', 'uses' => 'FarGenerationController@pageClose']);
// Route::get('fargeneration/ps/get_municipalities/{province}', ['as' => 'FarGenerationPs.get_municipalities', 'uses' => 'FarGenerationController@pageClose']);
// Route::get('fargeneration/ps/get_region/{province}', ['as' => 'FarGenerationPs.get_region', 'uses' => 'FarGenerationController@pageClose']);
// Route::get('fargeneration/ps/get_report_beneficiary/{province}/{municipality}/{brgy}', ['as' => 'FarGenerationPs.get_report_beneficiary', 'uses' => 'FarGenerationController@pageClose']);

// Route::get('fargeneration/ps', ['as' => 'FarGenerationPs.index', 'uses' => 'FarGenerationController@pageClose'])->middleware('auth');

//  Route::get('fargeneration/prev/pdf/{province}/{municipality}/{brgy}/{rowFrom}/{rowTo}/{size}', ['as' => 'api.far.pdf.ps', 'uses'=>'FarGenerationController@pageClose']);
//  Route::get('fargeneration/new/blank/pdf/{size}/{page_count}', ['as' => 'api.far.pdf.ps', 'uses'=>'FarGenerationController@pageClose']);
//  Route::get('fargeneration/prev/excel/{province}/{municipality}/{rowFrom}/{rowTo}', ['as' => 'api.far.excel.ps', 'uses'=>'FarGenerationController@pageClose']);


//FAR for Ebinhi
Route::get('fargeneration/ebinhi/', ['as' => 'far.ebinhi.ui', 'uses'=>'FarGenerationController@ebinhiIndex']);
Route::get('fargeneration/ebinhi/pdf/{province}/{municipality}/{brgy}/{dop}/{skip}/{take}/{size}', ['as' => 'far.ebinhi.pdf', 'uses'=>'FarGenerationController@makeEBinhiFAR']);
Route::post('fargeneration/ebinhi/get_municipalities', ['as' => 'FarGeneration.ebinhi.get_municipalities', 'uses' => 'FarGenerationController@ebinhi_get_municipalities']);
Route::post('fargeneration/ebinhi/get_brgy', ['as' => 'FarGeneration.ebinhi.get_brgy', 'uses' => 'FarGenerationController@ebinhi_get_brgy']);
Route::post('fargeneration/ebinhi/get_dop', ['as' => 'FarGeneration.ebinhi.get_dop', 'uses' => 'FarGenerationController@ebinhi_get_dop']);



//HISTORING MONITORING
Route::get('HistoryMonitoring', ['as' => 'HistoryMonitoring.index', 'uses' => 'HistoryMonitoringController@index'])->middleware('auth');
Route::get('HistoryMonitoring/get_municipalities/cstocs/{province}/{transfer}', ['as' => 'HistoryMonitoring.get_municipalities', 'uses' => 'HistoryMonitoringController@get_municipalities']);
Route::get('HistoryMonitoring/get_municipalities/pstocs/{province}', ['as' => 'HistoryMonitoring.get_municipalities', 'uses' => 'HistoryMonitoringController@get_municipalities2']);
Route::get('HistoryMonitoring/get_province/{type}', ['as' => 'HistoryMonitoring.get_province', 'uses' => 'HistoryMonitoringController@get_province']);

Route::get('HistoryMonitoring/get_region/{province}', ['as' => 'HistoryMonitoring.get_region', 'uses' => 'HistoryMonitoringController@get_region']);

Route::post('HistoryMonitoring/generate/cstocs', ['as' => 'generate.history.list.cstocs', 'uses'=>'HistoryMonitoringController@generateHistoryData']);
Route::post('HistoryMonitoring/generate/pstocs', ['as' => 'generate.history.list.pstocs', 'uses'=>'HistoryMonitoringController@generateHistoryData2']);

Route::post('HistoryMonitoring/process/del/cstocs/all', ['as' => 'process.history.cancel.cstocs.all', 'uses'=>'HistoryMonitoringController@processHistory']); //DELETE CSTOCS ALL
Route::post('HistoryMonitoring/process/del/cstocs/partial', ['as' => 'process.history.cancel.cstocs.partial', 'uses'=>'HistoryMonitoringController@processHistory2']); //DELETE CSTOCS PARTIAL
Route::post('HistoryMonitoring/process/del/pstocs', ['as' => 'process.history.cancel.pstocs', 'uses'=>'HistoryMonitoringController@processHistory3']); //DELETE PSTOCS
//UTILITY CANCEL DELIVERY
Route::post('utility/getBatchNumber', ['as' => 'pre_list.batchNumber', 'uses' => 'UtilDelTransactionController@get_batchNumber']);
Route::get('utility/pullDelInfo/{batchNumber}', ['as' => 'utility.pullDelInfo', 'uses' => 'UtilDelTransactionController@pullDelInfo']);
Route::get('utility/pullDopInfo/{batchNumber}/{moa_number}', ['as' => 'utility.pullDopInfo', 'uses' => 'UtilDelTransactionController@pullDopInfo']);
Route::get('utility/cancel_delivery/process/{batchID}', ['as' => 'utility.canceldelivery', 'uses' => 'UtilDelTransactionController@cancelDelivery']);

//UTILITY REPRINT IAR
Route::post('utility/getPrintedIar', ['as' => 'pre_list.iar_list', 'uses' => 'UtilityController@printedIarList']);
Route::get('utility/pullIarInfo/{batchNumber}', ['as' => 'utility.pullIarInfo', 'uses' => 'UtilityController@pullIarInfo']);
Route::get('utility/reprint_iar/{batchNumber}', ['as' => 'utility.reprintIar.process', 'uses' => 'UtilityController@iarReprint']);


//UTILITY RESET DELIVERY TO INSPECTION
Route::get('utility/reset_delivery/{batchTicketNumber}', ['as' => 'utility.resettoispection', 'uses' => 'UtilityController@resetdeliveryToInspection']);

//BPI API
Route::get('api/bpi/rla', ['as' => 'api.bpi.rla', 'uses' => 'APIController@bpiApiFetch']);
//UPLOAD PAYMAYA CSV
Route::get('utility/paymaya/process', ['as' => 'upload.paymaya.process.index', 'uses' => 'UtilityController@processPaymayaCode']);
Route::get('utility/paymaya/upload/beneficiary', ['as' => 'upload.paymaya.index', 'uses' => 'UtilityController@paymaya_upload']);
Route::post('utility/paymaya/upload/import_parse', ['as' => 'upload.paymaya.import_parse', 'uses' => 'UtilityController@import_parse']);
Route::post('utility/paymaya/upload/import_process', ['as' => 'upload.paymaya.import_process', 'uses' => 'UtilityController@import_process']);
//BREAKDOWN
Route::get('report/breakdown/', ['as' => 'view.report.break_down.index', 'uses' => 'rptBreakDownController@index'])->middleware('auth');
Route::get('report/breakdown/municipality/{prov}', ['as' => 'view.report.break_down.municipality', 'uses' => 'rptBreakDownController@getMunicipalities']);
Route::get('report/breakdown/dop/{prov}/{muni}', ['as' => 'view.report.break_down.municipality', 'uses' => 'rptBreakDownController@getDop']);

Route::post('report/breakdown/genTable', ['as' => 'genTable.report.break_down', 'uses' => 'rptBreakDownController@genTable']);
Route::post('second/inspection/change/result', ['as' => 'second.inspection.change', 'uses' => 'rptBreakDownController@changeResult']);
Route::post('report/breakdown/modal/table', ['as' => 'genTable.report.break_down.modal', 'uses' => 'ReportController@genTableModal']);
Route::post('report/breakdown/save', ['as' => 'rptbreakdown.save', 'uses' => 'rptBreakDownController@save']);
Route::get('report/breakdown/seedtag/{batch}/{code}', ['as' => 'genTable.report.break_down.seedtag', 'uses' => 'rptBreakDownController@getseedtag']);
Route::get('report/breakdown/throw/{temp}', ['as' => 'genTable.report.break_down.temp', 'uses' => 'rptBreakDownController@throwTemp']);
Route::get('report/breakdown/rla/{batch}/{seedtag}', ['as' => 'genTable.report.break_down.rla', 'uses' => 'rptBreakDownController@getAvailableRLA']);
Route::post('report/breakdown/replacement/save', ['as' => 'rptbreakdown.replacement.save', 'uses' => 'rptBreakDownController@replacementSave']);
Route::post('report/replacement/info/inspection', ['as' => 'replacement.info.inspection', 'uses' => 'rptBreakDownController@replacementInfo']);



Route::post('second/inspection/distri/seeds/result', ['as' => 'second.inspection.dseeds.change', 'uses' => 'rptBreakDownController@changeResult_distribution_seeds']);
Route::get('report/export/replacement/excel', ['as' => 'report.export.replacement.excel', 'uses' => 'reportExportController@exportReplacementDeliveries']);
 //PENDING
Route::get('pendingBatch', ['as' => 'pendingBatch.index', 'uses' => 'pendingBatchController@index'])->middleware('auth');
Route::get('pendingBatch/get_municipalities/{province}', ['as' => 'pendingBatch.get_municipalities', 'uses' => 'pendingBatchController@get_municipalities']);
Route::get('pendingBatch/get_dop/{province}/{municipality}', ['as' => 'pendingBatch.get_dop', 'uses' => 'pendingBatchController@get_dop']);
Route::post('pendingBatch/generate/province/', ['as' => 'generate.list.pending.province', 'uses'=>'pendingBatchController@generatePendingData']);
Route::post('pendingBatch/generate/province/municipality', ['as' => 'generate.list.pending.province.municipality', 'uses'=>'pendingBatchController@generatePendingData2']);
Route::post('pendingBatch/generate/province/municipality/dop', ['as' => 'generate.list.pending.province.municipality.dop', 'uses'=>'pendingBatchController@generatePendingData3']);
Route::get('pendingBatch/report/excel/{province}/{municipality}/{dop}', ['as' => 'rcef.report.excel.pendingBatch', 'uses'=>'pendingBatchController@export_transfer_history']);

//CANCELLED BATCH LIST
Route::get('cancelledBatch', ['as' => 'cancelledBatch.index', 'uses' => 'cancelledBatchController@index'])->middleware('auth');
Route::post('cancelledBatch/generate', ['as' => 'generate.cancelled.list', 'uses'=>'cancelledBatchController@generateHistoryData']);
Route::post('cancelledBatch/process/redo', ['as' => 'process.cancelled.redo', 'uses'=>'cancelledBatchController@processRedo']); //REDO
Route::get('cancelledBatch/report/excel/{from}/{to}', ['as' => 'rcef.report.excel.cancelledBatch', 'uses'=>'cancelledBatchController@export_transfer_history']);
Route::get( 'cancelledBatch/relog', ['as'=> 'rcef.input.relog', 'uses'=>'cancelledBatchController@reAuditLog']);
//REPORT REPROCESS UTILITY
Route::get('utility', ['as' => 'process.report.index', 'uses' => 'UtilityController@index']);
Route::get('utility/getProvince/{region}', ['as' => 'util.get.province', 'uses' => 'UtilityController@getProvince']);
Route::post('utility/getMunicipality', ['as' => 'util.get.municipality', 'uses' => 'UtilityController@getMunicipalities']);
Route::post('utility/process/report', ['as' => 'utility.process.report', 'uses'=>'UtilityController@ReportReprocess']);
Route::post('utility/process/provincial/report', ['as' => 'utility.process.provincial.report', 'uses'=>'UtilityController@ReportReprocessProvicial_Level']);
Route::get('utility/relog/ps', ['as' => 'utility.relog.previous', 'uses'=>'UtilityController@reLogPS']);
Route::get('utility/force/process/{prv_database}/{province_database}/{municipality_database}/{municipality_name}/{province_name}', ['as' => 'utility.force.process.report', 'uses'=>'UtilityController@ForceReportReprocess']);
Route::post('utility/process/statistics/report', ['as' => 'utility.process.statistics.report', 'uses'=>'UtilityController@statisticReprocess']);
Route::get('distribution/app/stocks/seedType', ['as' => 'distribution.app.stocks_seedType', 'uses' => 'DistMonitoringController@stocks_seedType']);
Route::post('distribution/app/actual/municipalities', ['as' => 'distribution.app.get_actual_municipalities', 'uses' => 'DistMonitoringController@get_actual_municipalities']);
Route::post('distribution/app/stocks/actual/tbl', ['as' => 'distribution.app.stocks_actual_tbl', 'uses' => 'DistMonitoringController@stocks_actual_tbl']);
Route::post('distribution/app/stocks/actual/confirm', ['as' => 'distribution.app.confirm_changeOfStockType', 'uses' => 'DistMonitoringController@confirm_changeOfStockType']);
//STOCKS MONITORING
Route::get('stocks/monitoring', ['as' => 'stocks.monitoring.index', 'uses' => 'StocksMonitoringController@index']);
Route::post('stocks/monitoring/location', ['as'=>'stocks.monitoring.location', 'uses' => 'StocksMonitoringController@getLocation']);
Route::post('stocks/monitoring/genTable', ['as'=>'stocks.monitoring.genTable', 'uses' => 'StocksMonitoringController@generateData']);
//ownprocedure for immidiate needs
Route::get('utility/for_all/immidiate/procedure/{data1}/{data2}/{data3}', ['as' => 'utility.immediate.procedure', 'uses' => 'UtilityController@utilityFunction']);
Route::get('utility/area/index', ['as' => 'upload.area.index', 'uses' => 'UtilityController@viewUploadingArea']);
Route::post('utility/area/import_parse', ['as' => 'upload.area.import_parse', 'uses' => 'UtilityController@import_check_area']);
Route::get('utility/clean/rla', ['as' => 'process.rla.clean', 'uses' => 'UtilityController@cleanRla']);
Route::get('utility/clean/rla/accreditation/{pass}', ['as' => 'process.rla.accreditation', 'uses' => 'UtilityController@recopyOLDaccre']);
Route::get('utility/farmer/data/puller', ['as' => 'farmer.profile.puller.index', 'uses' => 'UtilityController@farmerProfilePullIndex']);
Route::post('utility/farmer/data/process', ['as' => 'utility.process.pull', 'uses' => 'UtilityController@farmerProfileProcess']);
Route::get('utility/coops/temp_accreditation', ['as' => 'utility.coops.generate_codes', 'uses' => 'UtilityController@generate_temp_codes']);

Route::get('utility/released/data/reset', ['as' => 'released.data.index', 'uses' => 'UtilityController@released_data_index']);
Route::post('utility/released/data/tbl', ['as' => 'released.data.tbl.util', 'uses' => 'UtilityController@genReleasedTbl']);
Route::post('utility/farmer/released_data/reset', ['as' => 'farmer.distridata.released', 'uses' => 'UtilityController@farmer_distri_reset']);

Route::post('utility/farmer/distriution/updateinfo', ['as' => 'farmer.distributed.update', 'uses' => 'UtilityController@farmer_distributed_update']);

Route::get('utility/insert/cross/check/data/{file}', ['as' => 'utility.cross.check.insert', 'uses' => 'FarmerProfileController@insert_cross_check_xls']);



//UTILITY BACKUP DATABASE
Route::get('utility/backup/database', ['as' => 'database.backup.procedure', 'uses' => 'UtilityController@databaseBackup']);
//key 6ffa1a65a2db
Route::get('report_s/force/{api_key}', ['as' => 'database.force.report', 'uses' => 'UtilityController@forceBatFile']);
Route::get('forceServerSide/{api_key}', ['as' => 'database.force.report', 'uses' => 'UtilityController@forceServerSide']);

Route::get('rpt/remove_duplicates/{api_key}', ['as' => 'rpt.duplicates.report', 'uses' => 'UtilityController@removeRptDuplicates']);
Route::get('utility/claimable/process/{api_key}/{prv}', ['as' => 'utility.claimable.process', 'uses' => 'UtilityController@recompute_claimable']);

Route::get('prv/replicate/{api_key}', ['as' => 'prv.replicate.report', 'uses' => 'UtilityController@replicateprvs']);
Route::get('backup/prv', ['as' => 'prv.backup', 'uses' => 'UtilityController@backuprv']);


    //DA-ICTD
    Route::get('da/dashboard/index', ['as' => 'da.dashboard.index', 'uses' => 'daDashboardController@index'])->middleware('auth');
    Route::post('da/dashboard/province/list', ['as' => 'da.dashboard.province.list', 'uses' => 'daDashboardController@loadProvince']);
    Route::post('da/dashboard/municipality/list', ['as' => 'da.dashboard.municipality.list', 'uses' => 'daDashboardController@loadMunicipality']);

     /* INSPECTION ASSIGNMENT FOR BUFFER */
    Route::get('buffer/inspection/designation', ['as' => 'rcef.inspection.buffer.designation', 'uses' => 'InspectionBufferController@index']);
    Route::post('buffer/inspection/provinces/dropoff', ['as' => 'api.provinces.buffer.dropoff', 'uses' => 'InspectionBufferController@getProvinceDropoffDetails']);
    Route::post('buffer/inspection/municipalities/dropoff', ['as' => 'api.municipalities.buffer.dropoff', 'uses' => 'InspectionBufferController@getMunicipalitiesDropoffDetails']);
    Route::post('buffer/inspection/dropoff/search', ['as' => 'api.dropoff.buffer.search', 'uses' => 'InspectionBufferController@searchDropOffDelivery']);
    Route::post('buffer/inspection/tickets', ['as' => 'api.dropoff.buffer.details', 'uses' => 'InspectionBufferController@SelectedDropOffDetails']);
    Route::post('buffer/inspection/designation/save', ['as' => 'rcef.inspector.buffer.save', 'uses' => 'InspectionBufferController@saveInspectorDetails']);

    //CHANGE INSPECTOR
    Route::get('buffer/inspector/schedule', ['as' => 'rcef.buffer.inspector.schedule', 'uses' => 'InspectionBufferController@InspectorScheduleView']);
    Route::post('buffer/inspection/loadTagged', ['as' => 'rcef.buffer.inspector.table', 'uses' => 'InspectionBufferController@LoadTaggedInspector']);
    Route::post('buffer/inspection/update/inspector', ['as' => 'inspector.buffer.schedule.update', 'uses' => 'InspectionBufferController@UpdateInspectorTagged']);

    

    /* INSPECTION ASSIGNMENT FOR BUFFER */

    /* DROP OFF ASSIGNMENT FOR REPLACEMET */
    Route::get('dropOffMaker/replacement', ['as' => 'web.dop.maker.replacement.index', 'uses' => 'dropOffMakerController@index']);
    Route::post('dropOffMaker/replacement/province', ['as' => 'web.dop.maker.replacement.province', 'uses' => 'dropOffMakerController@provinceList']);
    Route::post('dropOffMaker/replacement/municipality', ['as' => 'web.dop.maker.replacement.municipality', 'uses' => 'dropOffMakerController@municipalList']);
    Route::post('dropOffMaker/replacement/gentable', ['as' => 'web.dop.maker.replacement.gentable', 'uses' => 'dropOffMakerController@genTable']);
    Route::post('dropOffMaker/replacement/gentableList', ['as' => 'web.dop.maker.replacement.gentableList', 'uses' => 'dropOffMakerController@gentableList']);
    Route::post('dropOffMaker/replacement/insert', ['as' => 'web.dop.maker.replacement.insert', 'uses' => 'dropOffMakerController@insertNewDOP']);
    Route::post('dropOffMaker/replacement/delivery/insert', ['as' => 'web.dop.maker.delivery.insert', 'uses' => 'dropOffMakerController@insert_delivery_schedule']);

    Route::post('dropOffMaker/replacement/list', ['as' => 'web.dop.maker.replacement.list', 'uses' => 'dropOffMakerController@replacementList']);

    /* DROP OFF ASSIGNMENT FOR REPLACEMET */    
     /* GAD REPORT*/
    Route::get('dashboard/gad', ['as' => 'dashboard.gad.view', 'uses' => 'reportGadController@index']);
    Route::get('report/gad/farmer/process/now', ['as' => 'rcef.report.gad.process', 'uses' => 'reportGadController@processGadData']);
    Route::get('report/export/excel/gad/{process_type}', ['as' => 'rcef.report.gad.export', 'uses' => 'reportGadController@exportGadReportExcel']);
    Route::post('dashboard/gad/gentable', ['as' => 'gad.monitoring.genTable', 'uses' => 'reportGadController@dashboardtbl']);   
    Route::post('dashboard/gad/data', ['as' => 'gad.dashboard.data', 'uses' => 'reportGadController@gadData']);      
    Route::post('dashboard/gad/graphLoad', ['as' => 'gad.dashboard.graphLoad', 'uses' => 'reportGadController@graphLoad']);
    /* GAD REPORT*/
    /*AllocationVsDelivery */
    Route::get('allocation/delivery/view/{level}', ['as' => 'delivery.allocation.view', 'uses' => 'deliveryAllocationController@viewAllocation']);
    Route::post('allocation/delivery/municipality', ['as' => 'delivery.allocation.muncipality', 'uses' => 'deliveryAllocationController@municipalityList']);
    Route::post('allocation/delivery/provincial', ['as' => 'delivery.allocation.provincial', 'uses' => 'deliveryAllocationController@provinceList']);
    Route::post('allocation/delivery/genTable', ['as' => 'delivery.allocation.gentable', 'uses' => 'deliveryAllocationController@load_table']);
    Route::post('allocation/delivery/chart/', ['as' => 'delivery.allocation.chart', 'uses' => 'deliveryAllocationController@loadChart']);
    /*AllocationVsDelivery*/
   /*YIELD ENCODER*/
    Route::get('encoder/yield/home', ['as' => 'encoder.yield.home', 'uses' => 'encoderYieldController@home']);
    Route::post('encoder/yield/municipality', ['as' => 'encoder.yield.muncipality', 'uses' => 'encoderYieldController@municipalityList']);
    Route::post('encoder/yield/load_table', ['as' => 'encoder.yield.load_table', 'uses' => 'encoderYieldController@load_table']);
    Route::post('encoder/yield/history', ['as' => 'encoder.yield.history', 'uses' => 'encoderYieldController@historyData']);
    Route::get('encoder/yield/export/excel/{province}/{municipality}', ['as' => 'encoder.yield.export.excel', 'uses' => 'encoderYieldController@exportExcelData']);
    Route::post('encoder/yield/lib/', ['as' => 'encoder.yield.lib.inputs', 'uses' => 'encoderYieldController@getLibInputs']);
    Route::post('encoder/yield/update', ['as' => 'encoder.yield.update', 'uses' => 'encoderYieldController@updateData']);     
    Route::post('encoder/yield/username', ['as' => 'encoder.yield.username', 'uses' => 'encoderYieldController@usernameList']);
    Route::get('encoder/yield/export/history/{province}/{municipality}/{date_from}/{date_to}/{user_name}/{farmer_id}', ['as' => 'encoder.yield.export.history', 'uses' => 'encoderYieldController@exportExcelHistory']);     
    /*YIELD ENCODER*/
    /*YIELD DATA*/
    Route::get('data/yield/home', ['as' => 'data.yield.home', 'uses' => 'dataYieldController@index']);
    Route::post('data/yield/province', ['as' => 'data.yield.province', 'uses' => 'dataYieldController@provinceList']);
    Route::post('data/yield/table', ['as' => 'data.yield.table', 'uses' => 'dataYieldController@load_table']);
    Route::post('data/yield/chart', ['as' => 'data.yield.chart', 'uses' => 'dataYieldController@load_chart']);
    Route::get('data/yield/export/excel/{province}/{municipality}', ['as' => 'data.yield.export', 'uses' => 'dataYieldController@export_excel']);
    /*YIELD DATA*/
    /* RLA MONITORING */
    Route::get('rla_monitoring/home', ['as' => 'rla.monitoring.home', 'uses' => 'rlaMonitoring@home'])->middleware('auth');
    Route::post('rla_monitoring/table', ['as' => 'rla.monitoring.table', 'uses' => 'rlaMonitoring@table_data']);
    Route::post('rla_monitoring/data/graph', ['as' => 'rla.monitoring.graph', 'uses' => 'rlaMonitoring@graphData']);    
    /* RLA MONITORING */
    /*OPS PLANNING*/
    Route::get('ops/Planning/home', ['as' => 'ops.planning.home', 'uses' => 'opsPlanningController@index'])->middleware('auth');
    Route::post('ops/Planning/loadTable', ['as' => 'ops.planning.loadTable', 'uses' => 'opsPlanningController@load_table']);
    Route::post('ops/Planning/modal_data', ['as' => 'ops.planning.modal_data', 'uses' => 'opsPlanningController@modal_data']);
    Route::post('ops/Planning/addSchedule', ['as' => 'ops.planning.addSchedule', 'uses' => 'opsPlanningController@addSchedule']);
    Route::post('ops/Planning/updateSchedule', ['as' => 'ops.planning.updateSchedule', 'uses' => 'opsPlanningController@updateSchedule']);
    Route::post('ops/Planning/delSchedule', ['as' => 'ops.planning.delSchedule', 'uses' => 'opsPlanningController@deleteThis']); 
    Route::post('ops/Planning/province', ['as' => 'ops.planning.province', 'uses' => 'opsPlanningController@provinceList']);
    Route::post('ops/Planning/municipality', ['as' => 'ops.planning.municipality', 'uses' => 'opsPlanningController@municipalityList']);
    Route::post('ops/Planning/dop', ['as' => 'ops.planning.dop', 'uses' => 'opsPlanningController@dopList']);
    Route::get('ops/Planning/exportToExcel/{status}/{region}/{province}/{municipality}/{dop}', ['as' => 'ops.planning.exportToExcel', 'uses' => 'opsPlanningController@exportToExcel']);
    /*OPS PLANNING*/
    Route::get('yield_ui/home', ['as' => 'yield_ui.home', 'uses' => 'yieldController@home']);
    Route::post('yield_ui/municipalities', ['as' => 'yield_ui.provinces', 'uses' => 'yieldController@load_municipalities']);
    Route::post('yield_ui/data_table', ['as' => 'yield_ui.data_table', 'uses' => 'yieldController@load_municipalities_data_table']);
    Route::post('yield_ui/standard_dev', ['as' => 'yield_ui.standard_dev', 'uses' => 'yieldController@load_municipalities_standard_dev']);
    
    Route::get("yield_ui/get_count/per/{season}/{level}/{name}", ['as' => 'yield.count.province', 'uses' => 'yieldController@yieldCounter_graph']);
    Route::get("yield_ui/get_count/perDataTable/{season}/{level}/{name}", ['as' => 'yield.count.province', 'uses' => 'yieldController@yieldCounter_datatable']);


 // for paymaya fixing
 Route::get('fix/area', ['as' => 'fix.area', 'uses' => 'OfflineFixController@fix_area' ]);
//  DOWNLOAD EXCEL NO CLAIM
 Route::get('export/paymaya/noclaim/{tag}/{province}/{municipality}', ['as' => 'export.no.data', 'uses' => 'PaymayaController@export_ebinhi_no_claim' ]);
 

 //joe RCEF Buffer inventory replacement oct 10, 2021
Route::get('bufferInventoryformview', ['as' => 'bufferInventoryformview', 'uses' => 'bufferInventoryController@index']);
Route::post('provinceBufferData', ['as' => 'provinceBufferData', 'uses' => 'bufferInventoryController@provincelist']);
Route::post('MunicipalitybufferData', ['as' => 'MunicipalitybufferData', 'uses' => 'bufferInventoryController@MunicipalitybufferData']);
Route::post('bufferInventoryInspectionResult', ['as' => 'bufferInventoryInspectionResult', 'uses' => 'bufferInventoryController@bufferInventoryInspectionResult']);
Route::post('BufferIRDatatable', ['as' => 'BufferIRDatatable', 'uses' => 'bufferInventoryController@BufferIRDatatable']);
Route::get('bufferInventory/{region}/{provincebuffer}/{Municipalitybuffer}/{replacement}', ['as' => 'bufferInventory', 'uses' => 'bufferInventoryController@bufferInverntory']);


 /*encoder extension joe*/
    Route::get('Statistic', ['as' => 'Statistic', 'uses' => 'EncoderStatisticController@index']);
    Route::post('StatisticDatLoad', ['as' => 'StatisticDatLoad', 'uses' => 'EncoderStatisticController@StatisticDatLoad']);
	Route::post('StatisticDatLoadChart', ['as' => 'StatisticDatLoadChart', 'uses' => 'EncoderStatisticController@StatisticDatLoadChart']);
    Route::post('encoderData', ['as' => 'encoderData', 'uses' => 'EncoderStatisticController@encoderData']);
    Route::post('statisticConnectionDB', ['as' => 'statisticConnectionDB', 'uses' => 'extensionController@statisticConnectionDB' ]);
	Route::post('getWeek', ['as' => 'getWeek', 'uses' => 'EncoderStatisticController@getWeek']);
    Route::get('Statistic-export/{station}/{username}/{seasonActive}/{month}/{week}/{year}', ['as' => 'Statistic-export', 'uses' => 'EncoderStatisticController@Statistic_excel']);
	
	//paymaya payment irwin
    Route::get('paymaya/report/payments', ['as' => 'paymaya.reports.payments', 'uses' => 'PaymayaPaymentController@index']);
    Route::post('paymaya/report/payments/coop', ['as' => 'paymaya.reports.payments.coop', 'uses' => 'PaymayaPaymentController@coop_table']);
    Route::post('paymaya/report/payments/coop_dl', ['as' => 'paymaya.reports.payments.coop_dl', 'uses' => 'PaymayaPaymentController@coop_table_dl']);
    Route::get('paymaya/report/payments/{date1}/{date2}/{date3}', ['as' => 'paymaya.reports.payments.pdf', 'uses' => 'PaymayaPaymentController@payment_frm_other']);
    Route::get('paymaya/report/payments/dbp/{date1}/{date2}/{date3}', ['as' => 'paymaya.reports.payments.dbp.pdf', 'uses' => 'PaymayaPaymentController@payment_frm_dpb']);
    
    // Route::post('paymaya/report/payments/dl/', ['as' => 'paymaya.report.dl', 'uses' => 'PaymayaPaymentController@generate_report']);
    Route::get('paymaya/report/dl/{from}/{to}', ['as' => 'paymaya.report.dl', 'uses' => 'PaymayaPaymentController@generate_report']);

    //PAYMENT REPORT RJ
    Route::get('paymaya/payment/report/excel', ['as' => 'paymaya.payment.reports.excel', 'uses' => 'PayMayaController@paymaya_batches']);

    /* joe api */
    Route::get('finance/api/rla_details', ['as' => 'finance.api.rla_details', 'uses' => 'APIController@finance']);

     //DRO irwin
    Route::get('dro/home', ['as' => 'dro.home', 'uses' => 'DroController@index']);
    Route::post('dro/home/for_assesment', ['as' => 'dro.home.for_assesment', 'uses' => 'DroController@get_for_assesment']);
    Route::post('dro/home/storeMedia', ['as' => 'dro.storeMedia', 'uses' => 'DroController@storeMedia']);
    Route::post('dro/home/update', ['as' => 'dro.update.status', 'uses' => 'DroController@update_status']);
    Route::post('dro/home/filter', ['as' => 'load.batch.filter', 'uses'=>'DroController@filter']);
    Route::post('dro/attachements', ['as' => 'load.attachements', 'uses'=>'DroController@get_attachements']);
    Route::post('dro/attachements/batch', ['as' => 'load.attachements.batch', 'uses'=>'DroController@get_attachements_batch']);
    Route::post('dro/home/update/overall', ['as' => 'dro.update.status.overall', 'uses' => 'DroController@update_status_overall']);
    Route::post('dro/home/get-rla', ['as' => 'get-rla', 'uses' => 'DroController@getRla']);
    Route::post('dro/home/seedtag-search', ['as' => 'seedtag-search', 'uses' => 'DroController@seedtagSearch']);

    //accountant irwin
    Route::get('accountant/home', ['as' => 'accountant.home', 'uses' => 'AccountantController@index']);
    Route::post('accountant/home/deliveries', ['as' => 'load.sg.deliveries', 'uses'=>'AccountantController@load_sg_deliveries']);
    Route::post('accountant/home/filter', ['as' => 'load.sg.filter', 'uses'=>'AccountantController@filter']);
    Route::post('accountant/home/for_assesment', ['as' => 'load.for_assesment', 'uses'=>'AccountantController@for_assesment']);

     //processor irwin
     Route::get('processor/home', ['as' => 'processor.home', 'uses' => 'ProcessorController@index']);
     Route::post('processor/home/deliveries', ['as' => 'processor.load.sg.deliveries', 'uses'=>'ProcessorController@load_sg_deliveries']);
     Route::post('processor/home/filter', ['as' => 'processor.load.sg.filter', 'uses'=>'ProcessorController@filter']);
     Route::post('processor/home/for_assesment', ['as' => 'processor.load.for_assesment', 'uses'=>'ProcessorController@for_assesment']);
     Route::post('processor/home/update_status', ['as' => 'processor.update_status', 'uses'=>'ProcessorController@update_status']);
     Route::post('processor/attachements/batch', ['as' => 'processor.attachements.batch', 'uses'=>'ProcessorController@get_attachements_batch']);
     Route::post('processor/home/update/batch', ['as' => 'processor.update.batch', 'uses'=>'ProcessorController@update_status_overall']);
     Route::get('processor/download/{batchticket}', ['as' => 'processor.download', 'uses'=>'ProcessorController@downloadByBatch']);


     //coop's Report commitment RJ 01102022
     Route::get('report/download_commitment/coop', ['as' => 'report.download_commitment_delivery.coop', 'uses' => 'ReportController@download_commitment_delivery_of_coop']);

    // yield count
    Route::get('yieldCount/home', ['as' => 'yieldCount.home', 'uses' => 'YieldCountController@index']);
    Route::post('yieldCount/regional', ['as' => 'yieldCount.rergionlCount', 'uses' => 'YieldCountController@regionalCount']);

    Route::get('yieldCount/export/{season}', ['as' => 'yieldCount.yieldCount.export', 'uses' => 'yieldController@yield_report_excel']);

    //PRE REG
    Route::get('api/pre_reg/check_name/{rsbsa}/{fname}/{lname}/{api_key}', ['as' => 'api.pre_reg.check_name', 'uses' => 'pre_regController@check_name']);
    Route::post('api/pre_reg/insert_data', ['as' => 'api.pre_reg.insert_data', 'uses' => 'pre_regController@insert_registration']);
    Route::post('api/pre_reg/get_qrCode', ['as' => 'api.pre_reg.insert_data', 'uses' => 'pre_regController@generate_qr_code']);
    Route::post('api/pre_reg/new_farmer/', ['as' => 'api.pre_reg.new_farmer', 'uses' => 'pre_regController@newFarmerEntry']);
    
    Route::get('api/pre_reg/trail/{api_key}/{prv_db}/{rsbsa}', ['as' => 'api.pre_reg.trail', 'uses' => 'pre_regController@genQRImageTrail']);
    
    
    Route::get('pre_reg/view_farmer', ['as' => 'pre_reg.view_farmer', 'uses' => 'pre_regController@view_farmer']);
    Route::get('pre_reg/getMunicipality/{province}', ['as' => 'pre_reg.view_farmer.province', 'uses' => 'pre_regController@getMunicipality']);
    Route::post('pre_reg/load/farmer', ['as' => 'pre_reg.load.farmer', 'uses' => 'pre_regController@loadFarmer']);
    Route::post('pre_reg/update/farmer', ['as' => 'pre_reg.update.farmer', 'uses' => 'pre_regController@update_farmer']);
    
   
    // DOP maker
    Route::get('DOPMaker/', ['as' => 'web.dop.maker.regular', 'uses' => 'DopRegularMakerController@index']);
    Route::post('DOPMaker/province', ['as' => 'web.dop.maker.regular.province', 'uses' => 'DopRegularMakerController@provinceList']);
    Route::post('DOPMaker/municipality', ['as' => 'web.dop.maker.regular.municipality', 'uses' => 'DopRegularMakerController@municipalList']);
    Route::post('DOPMaker/gentable', ['as' => 'web.dop.maker.regular.gentable', 'uses' => 'DopRegularMakerController@genTable']);
    Route::post('DOPMaker/gentableList', ['as' => 'web.dop.maker.regular.gentableList', 'uses' => 'DopRegularMakerController@gentableList']);
    Route::post('DOPMaker/insert', ['as' => 'web.dop.maker.regular.insert', 'uses' => 'DopRegularMakerController@insertNewDOP']);
    Route::post('DOPMaker/delivery/insert', ['as' => 'dop.maker.delivery.insert', 'uses' => 'DopRegularMakerController@insert_delivery_schedule']);
    // DOP maker

    //ebinhi signatories
    Route::get('paymaya/signatories', ['as' => 'paymaya.signatories', 'uses' => 'PaymayaPaymentSignatoriesController@index']);
    Route::post('paymaya/signatories/tbl', ['as' => 'paymaya.signatories_tbl', 'uses' => 'PaymayaPaymentSignatoriesController@signatories_tbl']);
    Route::post('paymaya/signatories/update', ['as' => 'paymaya.signatories.update', 'uses' => 'PaymayaPaymentSignatoriesController@update']);
    Route::post('paymaya/signatories/get', ['as' => 'paymaya.signatories.get', 'uses' => 'PaymayaPaymentSignatoriesController@get']);
    //ebinhi signatories

    // Create processor account
    Route::get('create-payment-processor-account', ['as' => 'prereg', 'uses' => 'UtilityController@createProcessorAccount']);

    // replacement seeds 
    Route::get('distribution/replacement', ['as' => 'distribution.replacement', 'uses' => 'ReplacementSeedController@home']);
    Route::post('distribution/replacement/provinces', ['as' => 'distribution.replacement.provinces', 'uses' => 'ReplacementSeedController@get_provinces']);
    Route::post('distribution/replacement/municipalities', ['as' => 'distribution.replacement.get_municipalities', 'uses' => 'ReplacementSeedController@get_municipalities']);

    Route::get('coop/rla-report', ['as' => 'coop.rla-report', 'uses' => 'CoopRlaController@home']);

    //wishlist
    Route::get('wishListGeneration/{request}', ['as' => 'wishListGeneration', 'uses' => 'wishListController@wishListController_data']);

    Route::get('generatorView', ['as' => 'generatorView', 'uses' => 'utilitycontrollertmp@generatorView']);
    Route::get('generatorProcess', ['as' => 'generatorProcess', 'uses' => 'utilitycontrollertmp@generatorProcess']);


