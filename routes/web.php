<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
return view('welcome');
});*/
Route::get('/', 'UserController@login');

Route::get('login', 'UserController@login')->name('login');

Route::post('login', 'UserController@authenticate')->name('login');


Route::middleware(['auth'])->group(function (){

Route::get('dashboard', 'UserController@dashboard')->withoutMiddleware('CheckRole');


Route::get('/sales/chart-data', 'UserController@salesChartData')->name('sales.chart-data');



Route::get('logout', 'UserController@logout')->name('logout')->withoutMiddleware('CheckRole');



Route::get('/employees', 'EmployeeController@index');//->middleware('CheckRole:3');
Route::get('/employee-Enrollment', 'EmployeeController@create');
Route::post('save-employee', 'EmployeeController@store');
Route::get('/employee/edit/{id}/{name}', 'EmployeeController@edit');
Route::post('/update-employee', 'EmployeeController@update');
Route::get('/class/delete/{id}', 'EmployeeController@destroy');

Route::get('/import-attendance', 'attendanceController@import_attendance');
Route::post('/import-attendance', 'attendanceController@save_attendance_file');
Route::get('/employee/attendance', 'attendanceController@index');
Route::get('employee/search-attendance', 'attendanceController@search_attendance');
Route::get('/edit/employee/attendance/{employee}/{date}', 'attendanceController@edit_attendance');
Route::post('/edit/employee/attendance/{employee}/{date}', 'attendanceController@update_attendance');

Route::get('/employees/attendance', 'attendanceController@employees_attendance');

Route::get('employees/monthly-attendance', 'attendanceController@employee_monthly_attendance');
Route::post('save/employee/monthly-attendance', 'attendanceController@save_employee_monthly_attendance');

Route::get('employees/monthly-attendance/report', 'attendanceController@employee_monthly_attendance_report');


Route::post('employees/mark-attendance', 'attendanceController@mark_attendance');

Route::get('/employee/attendance/register-search' ,  'attendanceController@emp_att_register');
Route::get('/employee/attendance/register' ,  'attendanceController@emp_att_register1');

Route::post('save-daily-attendances', 'attendanceController@save_daily_attendances');

Route::get('/attendance/register', 'attendanceController@attendance_register');
Route::get('/attendance/edit/{attendance}', 'attendanceController@edit');
Route::post('/attendance/update/{attendance}', 'attendanceController@update');
Route::get('/attendance/delete/{attendance}', 'attendanceController@destroy');

Route::get('/leave/adjustment/', 'LeaveController@leave_adjustment');
Route::post('/leave/adjustment/', 'LeaveController@save_leave_adjustment');


Route::get('/employee/profile/', 'EmployeeController@profile');
Route::get('/employee/profile1/', 'EmployeeController@getProfile');

Route::get('/generate-salary', 'salaryController@generate_salary');
Route::get('/generate/salary', 'salaryController@generate_salaries');

Route::get('/HR-Penality', 'penalityController@index');
Route::post('save-penality', 'penalityController@store');

Route::get('configuration/allowances', 'AllowanceController@index');
Route::post('configuration/allowances/save', 'AllowanceController@store');
Route::post('employee/allowance/save', 'AllowanceController@store_employee_allowance');
Route::post('employee/allowance/delete', 'AllowanceController@delete_employee_allowance');

Route::get('/inventory', 'InventoryController@index');
Route::get('/get/item/code', 'InventoryController@get_item_code');
Route::get('/get/sub-category/code', 'InventoryController@get_sub_category_code');
Route::get('/inventory/Add', 'InventoryController@create');
Route::post('save-inventory', 'InventoryController@store');
Route::get('edit/inventory/{inventory}', 'InventoryController@edit');
Route::post('/update-inventory/{inventory}', 'InventoryController@update');
Route::get('/inventory/delete/{id}', 'InventoryController@destroy');

Route::get('/inventory/item', 'InventoryController@item');
Route::get('get/item/current/grn_no', 'InventoryController@get_item_current_grn_no');

Route::get('/get/vendor/', 'VendorController@get_vendor');

Route::get('/department/demands/{department_id}', 'PurchaseController@get_department_demands');

Route::get('/department/inventory', 'InventoryController@department_inventory');

Route::get('configuration/inventory/department', 'ConfigurationController@inventory_department');
Route::post('configuration/inventory/department/save', 'ConfigurationController@save_inventory_department');
Route::get('configuration/inventory/department/edit/{department}', 'ConfigurationController@inventory_department_edit');
Route::post('configuration/inventory/department/update', 'ConfigurationController@update_inventory_department');

Route::get('configuration/inventory/type', 'ConfigurationController@inventory_type');
Route::get('configuration/inventory/category', 'ConfigurationController@inventory_category');
Route::get('configuration/origin', 'ConfigurationController@inventory_origin');
Route::get('configuration/inventory/size', 'ConfigurationController@inventory_size');
Route::get('configuration/inventory/color', 'ConfigurationController@inventory_color');
Route::get('configuration/unit', 'ConfigurationController@inventory_unit');


Route::post('configuration/inventory/type/save', 'ConfigurationController@save_inventory_type');
Route::post('configuration/inventory/category/save', 'ConfigurationController@save_inventory_category');
Route::post('configuration/origin/save', 'ConfigurationController@save_inventory_origin');
Route::post('configuration/inventory/size/save', 'ConfigurationController@save_inventory_size');
Route::post('configuration/inventory/color/save', 'ConfigurationController@save_inventory_color');
Route::post('configuration/unit/save', 'ConfigurationController@save_inventory_unit');

Route::get('/gtin/create', 'GtinController@create');
Route::post('gtin/save', 'GtinController@store');
Route::get('gtin/list', 'GtinController@index');
Route::get('edit/gtin/{gtin}', 'GtinController@edit');
Route::post('gtin/update/{gtin}', 'GtinController@update');


Route::resource('purchase-bookings', BookingController::class);
Route::get('purchase-bookings/report/{booking}', 'BookingController@booking_report');
Route::get('get-vendor-pending-bookings', 'BookingController@get_vendor_pending_bookings');


Route::get('/purchase/order', 'PurchaseController@purchase_order');
Route::post('/purchase/order/save', 'PurchaseController@purchase_order_save');
Route::get('/purchase/order/history', 'PurchaseController@purchase_orders_history');
Route::get('edit/purchase/order/{id}', 'PurchaseController@edit_purchase_order');
Route::post('/purchase/order/update', 'PurchaseController@purchase_order_update');
Route::post('/purchase/order/delete/{order}', 'PurchaseController@purchase_order_delete');
Route::get('purchase/order/report/{order}', 'PurchaseController@order_report');
Route::get('purchase/order/report1/{order}', 'PurchaseController@order_report1');


Route::get('/purchase/demand', 'PurchaseController@purchase_demand');
Route::post('/purchase/demand/save', 'PurchaseController@purchase_demand_save');
Route::get('/purchase/demand/history', 'PurchaseController@purchase_demands_history');
Route::get('edit/purchase/demand/{id}', 'PurchaseController@edit_purchase_demand');
Route::post('/purchase/demand/update', 'PurchaseController@purchase_demand_update');
Route::post('/purchase/demand/delete/{demand}', 'PurchaseController@purchase_demand_delete');
Route::get('/purchase/demand/report/{id}', 'PurchaseController@purchase_demand_report');

Route::get('/get/demand/', 'PurchaseController@get_demand');

Route::get('purchase/goods-receiving-note', 'PurchaseController@goods_receiving_note');
Route::post('purchase/grn/save', 'PurchaseController@grn_save');
Route::get('/get/po/', 'PurchaseController@get_po');
Route::get('/purchase/grn/history', 'PurchaseController@purchase_grn_history');
Route::get('edit/purchase/grn/{grn_no}', 'PurchaseController@edit_purchase_grn');
Route::post('update/purchase/grn', 'PurchaseController@update_purchase_grn');
Route::post('/purchase/grn/delete/{grn}', 'PurchaseController@purchase_grn_delete');
Route::get('/grn/inward-gatepass/{grn_no}', 'PurchaseController@grn_gatepas');

Route::get('get/purchase/code', 'PurchaseController@get_purchase_code');

Route::get('purchase/', 'PurchaseController@add_purchase');
Route::post('purchase/save', 'PurchaseController@purchase_save');
Route::get('/get/grn/', 'PurchaseController@get_grn');
Route::get('/purchase/history', 'PurchaseController@purchase_history');
Route::get('edit/purchase/{purchase}', 'PurchaseController@edit_purchase');
Route::post('update/purchase/', 'PurchaseController@purchase_update');
Route::post('/purchase/delete/{purchase}', 'PurchaseController@purchase_delete');
Route::get('/purchase/report/{purchase}', 'PurchaseController@purchase_report');


Route::get('purchase/return', 'PurchaseController@add_purchase_return');
Route::get('/get/purchase/', 'PurchaseController@get_purchase');
Route::post('purchase/return/save', 'PurchaseController@purchase_return_save');
Route::get('/purchase/return/history', 'PurchaseController@purchase_return_history');
Route::get('edit/purchase/return/{return}', 'PurchaseController@edit_purchase_return');
Route::post('update/purchase/return', 'PurchaseController@purchase_return_update');
Route::post('/purchase/return/delete/{return}', 'PurchaseController@purchase_return_delete');
Route::get('/purchase/return/report/{return}', 'PurchaseController@purchase_return_report');

Route::get('/shifts', 'ShiftController@index');
Route::get('/define/shift', 'ShiftController@define_shift');
Route::post('/define/shift', 'ShiftController@store');
Route::get('/edit/shift/{shift}', 'ShiftController@edit');
Route::post('/update/shift/{shift}', 'ShiftController@update');

Route::get('/configuration/leave', 'LeaveController@configure_leave');
Route::post('/configuration/leave/save', 'LeaveController@store');

Route::get('/configuration/attendance-status', 'AttendanceStatusController@create');
Route::post('/configuration/attendance/status/save', 'AttendanceStatusController@store');


Route::get('/configuration/vendors', 'VendorController@index');
Route::get('/configuration/vendor/create', 'VendorController@create');
Route::post('/configuration/vendor/save', 'VendorController@store');
Route::get('/configuration/edit/vendor/{vendor}', 'VendorController@edit');
Route::post('/configuration/vendor/update/{vendor}', 'VendorController@update');
Route::get('/configuration/vendor/type/', 'VendorController@vendor_type');
Route::post('/configuration/vendor/type/save', 'VendorController@vendor_type_save');

Route::get('/configuration/vendor/type/edit/{type_id}', 'VendorController@vendor_type_edit');
Route::post('/configuration/vendor/type/update', 'VendorController@vendor_type_update');

Route::get('/leaves', 'LeaveController@index');
Route::get('/mark/leave', 'LeaveController@mark_leave');
Route::post('/mark/leave/', 'LeaveController@save_mark_leave');
Route::get('/edit/leave/{leave}', 'LeaveController@edit');
Route::post('/update/leave/{leave}', 'LeaveController@update');

Route::get('/configuration/countries', 'CountryController@index');
Route::post('/configuration/country/save', 'CountryController@store');
Route::get('/get/country/detail/', 'CountryController@getCountryDetail');

Route::get('/configuration/states', 'ProvinceController@index');
Route::post('/configuration/state/save', 'ProvinceController@store');
Route::get('/get/states', 'ProvinceController@getStates');
Route::get('/get/state/detail/', 'ProvinceController@getStateDetail');

Route::get('/configuration/regions', 'RegionController@index');
Route::post('/configuration/region/save', 'RegionController@store');
Route::get('/get/regions', 'RegionController@getRegions');
Route::get('/get/country-regions', 'RegionController@getCountryRegions');

Route::get('/get/region/detail/', 'RegionController@getRegionDetail');

Route::get('/get/state/regions', 'RegionController@getStateRegions');

Route::get('/configuration/districts', 'DistrictController@index');
Route::post('/configuration/district/save', 'DistrictController@store');
Route::get('/get/districts', 'DistrictController@getDistricts');
Route::get('/get/country-districts', 'DistrictController@getCountryRegions');

Route::get('/get/district/detail/', 'DistrictController@getDistrictDetail');

Route::get('/configuration/cities', 'CityController@index');
Route::post('/configuration/city/save', 'CityController@store');

Route::get('/configuration/territories', 'TerritoryController@index');
Route::post('/configuration/territory/save', 'TerritoryController@store');

Route::get('/test', 'LeaveController@test');

Route::get('production-demand', 'ProdDemandController@create');
Route::post('production-demand/save', 'ProdDemandController@store');
Route::get('production-demand/history', 'ProdDemandController@index');
Route::get('edit/production-demand/{demand}', 'ProdDemandController@edit');
Route::post('production-demand/update', 'ProdDemandController@update');
Route::get('print/production-demand/{demand}', 'ProdDemandController@demand_print');
Route::post('delete/production-demand/{demand}', 'ProdDemandController@destroy');

Route::get('/finish-goods-production-standard', 'ProductionController@finish_goods_production_standard');
Route::post('save/production-standard', 'ProductionController@save_production_standard');
Route::get('/get/production/std', 'ProductionController@get_production_std');
Route::get('/finish-goods-production-standard/history', 'ProductionController@finish_goods_production_standard_history');
Route::get('/finish-goods-production-standard/edit/{std_no}', 'ProductionController@edit_fg_std');
Route::post('update/production-standard', 'ProductionController@update_fg_std');

Route::get('standard/stage/{std_id}/{process_id}', 'ProductionController@standard_stage');
Route::post('standard/process/save', 'ProductionController@save_std_parameters');
Route::get('standard/stage/table/{std_id}/{super_id}/{table_id}', 'ProductionController@standard_table');

Route::post('save/standard/stage/table/', 'ProductionController@save_standard_table');

Route::get('ticket/stage/table/{ticket_id}/{super_id}/{table_id}', 'ProductionController@ticket_table');
Route::post('save/ticket/stage/table/', 'ProductionController@update_ticket_table');

Route::get('/get/product/standard', 'ProductionController@get_product_std');



Route::get('/production-plan', 'ProductionPlanController@create');
Route::post('/production/plan/save', 'ProductionPlanController@store');
Route::get('/get/plan/items', 'ProductionController@get_plan_items');
Route::get('/production/plan/history', 'ProductionPlanController@index');
Route::get('/production-plan/edit/{plan_no}', 'ProductionPlanController@edit');
Route::post('/production/plan/update', 'ProductionPlanController@update');
Route::get('/print/plan/{plan}', 'ProductionPlanController@print_plan');
Route::get('/print/plan/bmr/{plan}', 'ProductionPlanController@print_plan_bmr');

Route::post('delete/production-plan/{plan}', 'ProductionPlanController@destroy');

Route::get('select/plan/stage', 'ProductionPlanController@select_batch_stage');


Route::get('/plan-ticket', 'ProductionController@create_plan_ticket');
Route::post('/plan-ticket/save', 'ProductionController@save_plan_ticket');
Route::get('/get/ticket/esitmated-material', 'ProductionController@get_estimated_material');
Route::get('plan/ticket/history', 'ProductionController@plan_ticket_history');
Route::get('edit/plan/ticket/{ticket_no}', 'ProductionController@edit_plan_ticket');
Route::post('/plan-ticket/update', 'ProductionController@update_plan_ticket');

Route::get('ticket/costing/{ticket_id}', 'ProductionController@ticket_costing');

Route::get('configuration/departments', 'ConfigurationController@organization_department');
Route::post('save/configuration/departments', 'ConfigurationController@save_organization_department');

Route::get('configuration/production/process', 'ProductionController@production_process');
Route::post('save/configuration/production/process', 'ProductionController@save_production_process');
Route::get('configuration/production/process/history', 'ProductionController@production_process_history');

Route::get('configuration/production/process/edit/{id}', 'ProductionController@edit_production_process');
Route::post('update/configuration/production/process', 'ProductionController@update_production_process');

Route::get('configuration/production/process/parameters', 'ProductionController@process_parameters');
Route::post('save/configuration/production/process/parameters', 'ProductionController@save_process_parameters');
Route::get('configuration/production/process/parameter/edit/{parameter_id}', 'ProductionController@process_parameter_edit');
Route::post('update/configuration/production/process/parameter', 'ProductionController@update_process_parameters');
Route::post('configuration/production/process/parameter/delete/{parameter}', 'ProductionController@delete_parameter');

Route::get('configuration/table/list', 'TableController@index');
Route::get('configuration/table', 'TableController@create');
Route::post('save/configuration/table', 'TableController@store');
Route::get('configuration/table/edit/{table}', 'TableController@edit');
Route::post('update/configuration/table', 'TableController@update');



Route::get('configuration/product/procedure', 'ProductionController@product_process');
Route::post('save/configuration/product/procedure', 'ProductionController@save_product_procedure');
Route::get('get/product/procedure', 'ProductionController@get_product_procedure');

Route::get('request-material/{ticket_id}', 'RequisitionController@requisition_request');
Route::get('request-material', 'RequisitionController@requisition_request');

Route::post('/requisition/save', 'RequisitionController@requisition_save');
Route::get('requisition/requests', 'RequisitionController@requisition_requests');
Route::get('/store-issuance/{request_id?}', 'InventoryController@store_issuance');
Route::get('issue/items/{requisition_no}', 'RequisitionController@issue_items');
Route::post('/issuance/save', 'RequisitionController@issuance_save');
Route::get('issuance/history', 'RequisitionController@issuance_history');
Route::get('edit/issuance/{issuance_no}', 'RequisitionController@edit_issuance');
Route::post('/issuance/update', 'RequisitionController@issuance_update');
Route::post('delete/issuance/{issuance}', 'RequisitionController@delete_issuance');
Route::get('/issuance/print/{issue}', 'RequisitionController@print_issuance');

Route::get('create/issuance-return/{issue_id?}', 'IssuanceReturnController@create');
Route::post('/issuance-return/save', 'IssuanceReturnController@store');
Route::get('issuance-return/history', 'IssuanceReturnController@index');
Route::get('edit/issuance-return/{return}', 'IssuanceReturnController@edit');
Route::post('/issuance-return/update', 'IssuanceReturnController@update');
Route::post('delete/issuance-return/{return}', 'IssuanceReturnController@destroy');
Route::get('/issuance-return/print/{return}', 'IssuanceReturnController@print');

Route::get('item/history', 'InventoryController@item_history');
Route::get('search/item/history', 'InventoryController@search_item_history');

Route::get('item-sales-report', 'InventoryController@item_sales_report');
Route::get('item-purchase-report', 'InventoryController@item_purchase_report');

Route::get('plan-ticket/stage/{ticket_id}/{stage_id}', 'ProductionController@ticket_stage');
Route::post('ticket/stage/save', 'ProductionController@ticket_stage_save');

Route::get('/ticket/master-formulation/report/{ticket_id}', 'ProductionReportController@master');
Route::get('plan-ticket/stage/report/{ticket_id}/{stage_id}/{process_identity}', 'ProductionReportController@ticket_stage_report');





Route::get('/configuration/add-new-user', 'UserController@create_user');
Route::post('/configuration/user/save', 'UserController@save_user');
Route::get('/configuration/users', 'UserController@index');
Route::get('/configuration/edit-user/{user}', 'UserController@edit_user');
Route::post('/configuration/user/update', 'UserController@update_user');

Route::get('/configuration/roles', 'UserController@create_role');
Route::post('/configuration/role/save', 'UserController@save_role');
Route::get('/config/rights', 'RightController@create');
Route::post('/assign/right/save', 'RightController@save_assign_right');

Route::get('/configuration/menu', 'MenuController@menu');
Route::post('/configuration/menu/save', 'MenuController@save_menu');

Route::get('/requisition/request/create', 'RequisitionController@requisition_request');
Route::post('/requisition/request/save', 'RequisitionController@requisition_request_save');
Route::get('/requisition/request/edit/{requisition_id}', 'RequisitionController@edit_requisition_request');
Route::post('/requisition/request/update', 'RequisitionController@requisition_request_update');
Route::get('/requisition/print/{request}', 'RequisitionController@print_requisition');
Route::post('/delete/requisition/{request}', 'RequisitionController@delete_requisition');


Route::get('/return-note-list', 'ReturnNoteController@index');
Route::get('create/return-note/{stock_id}', 'ReturnNoteController@create_return_note');
Route::post('save/return/note', 'ReturnNoteController@store');
Route::get('edit/return-note/{return_note}', 'ReturnNoteController@edit');
Route::post('update/return/note', 'ReturnNoteController@update');


Route::get('stock/edit/{stock_id}', 'stockController@edit_stock');
Route::post('/update/stock/', 'stockController@update_stock');


Route::get('sampling/pending', 'QcController@pending_requests');
Route::get('sampling/list/', 'QcController@all_qc_requests');


Route::get('/sampling/create', 'samplingController@create');



Route::post('save/sampling','samplingController@store');

Route::get('sampling/{sampling_id}','samplingController@edit');
Route::post('update/qa/sampling','QcController@update_qc_request');
Route::get('print/sampling/{sampling_id}','QcController@print_sampling');

Route::get('qc/result/{request_id}','QcController@edit_qc_result');
Route::post('update/qc/report','QcController@save_qc_result');

Route::get('stocks-under-qc', 'stockController@stocks_under_qc');

Route::get('lab-test-request', 'QcController@lab_test_request');
Route::get('lab-test/{req_no}', 'QcController@lab_test');
Route::get('QC/test/result', 'QcController@qc_result');


Route::get('lab-test-results','QcController@qc_results');
Route::get('edit/qc/result/{result_id}','QcController@view_qc_result');
Route::get('/qc/result/report/{result_id}','QcController@view_qc_result_report');
Route::get('stock/qc-results','QcController@new_qc_results');



Route::get('configuration/inventory/parameters', 'QcController@product_parameters');
Route::post('save/configuration/inventory/parameters', 'QcController@save_product_parameters');
Route::get('configuration/inventory/parameter/edit/{parameter_id}', 'QcController@process_parameter_edit');
Route::post('update/configuration/inventory/parameter', 'QcController@update_process_parameters');


Route::get('get/grn_no/', 'stockController@get_grn_no');

Route::get('stock-list', 'stockController@items_stock_list');
Route::get('items-stock', 'stockController@items_stock');
Route::get('print/items-stock', 'stockController@items_stock_print');
Route::get('items-stock-batch-wise', 'stockController@items_stock_batch_wise');
Route::get('get/item/current/stocks', 'stockController@get_item_current_stocks');

Route::get('items-rackwise', 'stockController@items_rackwise');

Route::get('get-item-qty-rackwise', 'InventoryController@getItemWithRackQty');

//Route::get('all-stock-list', 'stockController@all_stock_list');
Route::get('item-stock-detail', 'stockController@item_stock_detail');
Route::get('item-stock-current', 'stockController@items_stock_list');

Route::get('production-entry', 'ProductionController@production_entry');
Route::get('production-entry/{ticket_id}', 'ProductionController@production_entry');
Route::get('/production/list/{ticket_id}', 'ProductionController@production_entry_list');
Route::get('edit/production-entry/{production_id}', 'ProductionController@edit_production_entry');
Route::post('production-entry/save', 'ProductionController@save_production_entry');
Route::get('production/history', 'ProductionController@production_history');



Route::get('/item/exist', 'InventoryController@item_exist');

Route::get('/quotation/create', 'QuotationController@create');
Route::post('/quotation/save', 'QuotationController@store');
Route::post('get/quotation/code', 'QuotationController@get_doc_no');
Route::get('get/customer/new/quotations', 'QuotationController@new_quotations');
Route::get('/get/quotation', 'QuotationController@get_quotation');
Route::get('quotation/history', 'QuotationController@index');
Route::get('edit/quotation/{quotation}', 'QuotationController@edit');
Route::post('/quotation/update', 'QuotationController@update');
Route::get('/quotation/report/{quotation}/{report_type}', 'QuotationController@report');
Route::get('/export-quotation/report/{quotation}', 'QuotationController@export_report');
Route::post('quotation/delete/{quotation}', 'QuotationController@destroy');
Route::get('/get/rate', 'CustomerController@get_rate');




Route::get('/order/create', 'OrderController@create');
Route::post('/order/save', 'OrderController@store');
Route::get('/order/history', 'OrderController@index');
Route::get('/orders/pending', 'OrderController@pending');
Route::get('/orders/pending-approval', 'OrderController@pending_approval_orders');
Route::post('/orders/update-status/{id}', 'OrderController@updateStatus')->name('orders.updateStatus');
Route::get('/edit/order/{order}', 'OrderController@edit');
Route::post('/order/update', 'OrderController@update');
Route::get('get/customer/new/orders','OrderController@getCustomerNewOrders');
Route::get('get/sale/order','OrderController@getSaleOrder');
Route::get('/order/report/{order}', 'OrderController@order_report');
Route::get('/order/report1/{order}', 'OrderController@order_report1');
Route::get('/order/form/{order}', 'OrderController@order_form');
Route::post('/order/delete/{order}', 'OrderController@destroy');

Route::get('/delivery-challan/create', 'DeliverychallanController@create');
Route::post('/delivery-challan/save', 'DeliverychallanController@store');
Route::get('/delivery-challan/history', 'DeliverychallanController@index');
Route::get('/edit/delivery-challan/{deliverychallan}', 'DeliverychallanController@edit');
Route::post('/delivery-challan/update', 'DeliverychallanController@update');
Route::post('/challan/delete/{challan}', 'DeliverychallanController@destroy');


Route::get('/delivery-challan/report/{deliverychallan}/{report_type?}', 'DeliverychallanController@challan_report');
Route::get('/delivery-challan/report1/{deliverychallan}', 'DeliverychallanController@challan_report1');
Route::get('/delivery-challan/form/{deliverychallan}', 'DeliverychallanController@challan_form');
Route::get('/warranty-invoice/{item_by}/{deliverychallan}', 'DeliverychallanController@warranty_invoice');

Route::get('get/customer/new/challans','DeliverychallanController@new_customer_challan');
Route::get('get/delivery/challan', 'DeliverychallanController@get_challan');

Route::post('/get/sale/code', 'SaleController@get_doc_no');
Route::get('/sale/create', 'SaleController@create');
Route::post('/sale/save', 'SaleController@store');
Route::get('/sale/history', 'SaleController@index');
Route::get('edit/sale/{sale}', 'SaleController@edit');
Route::post('/sale/update', 'SaleController@update');
Route::get('/estimated-invoice/report/{sale}/{invoice_type}', 'SaleController@estimated_invoice');
Route::get('/export-invoice/report/{sale}', 'SaleController@export_invoice');
Route::post('/sale/delete/{sale}', 'SaleController@destroy');


Route::get('get/sale/invoice', 'SaleController@get_invoice');
Route::get('get/customer/product/invoices', 'SaleController@get_customer_product_invoices');

Route::get('get/invoice/item', 'SaleController@get_invoice_item');
Route::get('get/transfer/item/', 'DeliverychallanController@get_transfer_item');

Route::get('/sale/return', 'SalereturnController@create');
Route::post('/sale/return/save', 'SalereturnController@store');
Route::get('/sale/return/history', 'SalereturnController@index');
Route::get('edit/sale/return/{return}', 'SalereturnController@edit');
Route::post('/sale/return/update', 'SalereturnController@update');
Route::post('/sale/return/delete/{return}', 'SalereturnController@destroy');
Route::get('/return/report/{return}/{type}', 'SalereturnController@return_report');

Route::get('/stock/transfer', 'StockTransferController@create');
Route::post('/stock/transfer/save', 'StockTransferController@store');
Route::get('/stock/transfer/history', 'StockTransferController@index');
Route::get('edit/stock/transfer/{transfer}', 'StockTransferController@edit');
Route::post('stock/transfer/update', 'StockTransferController@update');
Route::post('/stock/transfer/delete/{transfer}', 'StockTransferController@destroy');


Route::get('/customer/create', 'CustomerController@create');
Route::post('/customer/save', 'CustomerController@store');
Route::get('/customers/list', 'CustomerController@index');
Route::get('/print/customers/list', 'CustomerController@print_list');
Route::get('/edit/customer/{customer}', 'CustomerController@edit');
Route::post('/customer/update', 'CustomerController@update');


Route::get('/customers/receivable', 'CustomerController@receivable_list');
Route::get('/print/customers/receivable', 'CustomerController@print_receivable_list');

Route::get('/vendors/payable', 'VendorController@payable_list');
Route::get('/print/vendors/payable', 'VendorController@print_payable_list');

Route::get('/configure/rate', 'CustomerController@config_rate');
Route::post('/configure/rate/save', 'CustomerController@config_rate_save');
Route::get('/configure/rates', 'CustomerController@config_rate_list');
Route::get('/configure/rate/type/edit/{type}', 'CustomerController@config_rate_type_edit');
Route::post('/configure/rate/type/update', 'CustomerController@config_rate_type_update');

Route::get('/make-salary', 'salaryController@make_salary');
Route::get('/make-month-salary', 'salaryController@make_month_salary');
Route::post('save-month-salary', 'salaryController@save_month_salary');
Route::get('/salary/history', 'salaryController@salary_history');
Route::get('edit/salary/{salary_doc}', 'salaryController@salary_edit');
Route::post('update-month-salary', 'salaryController@salary_update');
Route::get('/salary/report/{salary_doc}', 'salaryController@salary_report');
Route::get('/make', 'salaryController@test');

Route::get('/overtime/create', 'OvertimeController@create');
Route::post('/overtime/save', 'OvertimeController@store');
Route::get('/overtime/edit/{overtime}', 'OvertimeController@edit');
Route::post('/overtime/update', 'OvertimeController@update');
Route::get('/overtime/list/', 'OvertimeController@index');

Route::get('/department', 'EmployeeController@create_department');
Route::post('save/department', 'EmployeeController@save_department');
Route::get('/designation', 'EmployeeController@create_designation');
Route::post('save/designation', 'EmployeeController@save_designation');

Route::get('/main/accounts', 'AccountController@main_accounts');
Route::post('/main/account/save', 'AccountController@main_account_save');
Route::get('edit/main/account/{account}', 'AccountController@edit_main_account');
Route::post('/main/account/update', 'AccountController@main_account_update');
Route::post('delete/main/account/{account}', 'AccountController@delete_main_account');

Route::get('/sub/accounts', 'AccountController@sub_accounts');
Route::post('/sub/account/save', 'AccountController@sub_account_save');
Route::get('edit/sub/account/{account}', 'AccountController@edit_sub_account');
Route::post('/sub/account/update', 'AccountController@sub_account_update');
Route::post('delete/sub/account/{account}', 'AccountController@delete_sub_account');


Route::get('sub-sub-account/types', 'ConfigurationController@account_types');
Route::post('sub-sub-account/type/save', 'ConfigurationController@account_type_save');

Route::get('sub/sub/accounts', 'AccountController@sub_sub_accounts');
Route::post('sub/sub/account/save', 'AccountController@sub_sub_account_save');
Route::get('edit/sub/sub/account/{account}', 'AccountController@edit_sub_sub_account');
Route::post('sub/sub/account/update', 'AccountController@sub_sub_account_update');
Route::post('delete/sub/sub/account/{account}', 'AccountController@delete_sub_sub_account');

Route::get('/get/account/code', 'AccountController@get_account_code');

Route::get('/get/sub-sub/detail-accounts', 'AccountController@get_detail_accounts');
Route::get('/get/account', 'AccountController@get_account');

Route::get('detail/accounts', 'AccountController@detail_accounts');
Route::post('detail/account/save', 'AccountController@detail_account_save');
Route::get('edit/detail/account/{account}', 'AccountController@edit_detail_account');
Route::post('detail/account/update', 'AccountController@detail_account_update');
Route::post('delete/detail/account/{account}', 'AccountController@delete_detail_account');

Route::get('voucher/types', 'VoucherController@voucher_types');
Route::post('voucher/type/save', 'VoucherController@voucher_type_save');
Route::get('edit/voucher/type/{id}', 'VoucherController@edit_voucher_type');
Route::post('voucher/type/update', 'VoucherController@voucher_type_update');


Route::get('voucher/{type}/list', 'VoucherController@index_new');
Route::get('voucher/{type}/create', 'VoucherController@create_new');
Route::get('voucher/{type}/{voucher}/edit', 'VoucherController@create_new');
Route::post('voucher_new/save', 'VoucherController@store_new');
Route::post('voucher_new/update/{id}', 'VoucherController@update_new');
Route::get('voucher/{type}/{voucher}/view', 'VoucherController@show_new');
Route::post('delete_new/voucher/{voucher}', 'VoucherController@destroy_new');


Route::get('get/voucher/no', 'VoucherController@get_voucher_no');
Route::get('voucher/create', 'VoucherController@create');
Route::post('voucher/save', 'VoucherController@store');
Route::get('voucher/history', 'VoucherController@index');
Route::get('edit/voucher/{voucher}', 'VoucherController@edit');
Route::post('voucher/update', 'VoucherController@update');
Route::get('voucher/report/{voucher}', 'VoucherController@print_voucher');
Route::get('voucher/report1/{voucher}', 'VoucherController@print_voucher1');
Route::get('voucher/report2/{voucher}', 'VoucherController@print_voucher2');

Route::post('delete/voucher/{voucher}', 'VoucherController@destroy');

Route::get('expense/create', 'VoucherController@create_expense');
Route::post('expense/save', 'VoucherController@store_expense');
Route::get('expense/history', 'VoucherController@index_expense');
Route::get('edit/expense/{voucher}', 'VoucherController@edit_expense');
Route::post('expense/update', 'VoucherController@update_expense');
Route::post('delete/expense/{voucher}', 'VoucherController@destroy');

Route::get('payment/create', 'VoucherController@create_payment');
Route::post('payment/save', 'VoucherController@store_payment');
Route::get('payment/history', 'VoucherController@index_payment');
Route::get('edit/payment/{voucher}', 'VoucherController@edit_payment');
Route::post('payment/update', 'VoucherController@update_payment');
Route::post('delete/payment/{voucher}', 'VoucherController@destroy');

Route::get('receipt/create', 'VoucherController@create_receipt');
Route::post('receipt/save', 'VoucherController@store_receipt');
Route::get('receipt/history', 'VoucherController@index_receipt');
Route::get('edit/receipt/{voucher}', 'VoucherController@edit_receipt');
Route::post('receipt/update', 'VoucherController@update_receipt');
Route::post('delete/receipt/{voucher}', 'VoucherController@destroy');


Route::get('/customers/info', 'CustomerController@getCustomerInfo')->name('customers.info');

Route::get('customer/store', 'CustomerController@customer_store');
Route::get('customer/store/stock', 'CustomerController@customer_stock');
Route::get('print/customer/store/stock', 'CustomerController@print_customer_stock');
Route::get('customer/store/detail', 'CustomerController@customer_store_detail');
Route::get('customer/store/summary', 'CustomerController@customer_store_summary');
Route::get('customer/receivable', 'CustomerController@customer_receivable');
Route::get('print/customer/receivable', 'CustomerController@print_customer_receivable');

Route::get('sale/ledger', 'SaleController@sale_history');
Route::get('print/sale/ledger', 'SaleController@sale_history_print');

Route::get('chart-of-accounts', 'AccountController@chart_of_accounts');
Route::get('chart-of-accounts/report', 'AccountController@chart_of_accounts_report');

Route::get('trail/balance', 'AccountController@trail_balance');
Route::get('trail/balance/report', 'AccountController@trail_balance_report');

Route::get('customer/aging', 'AccountController@customer_aging');

Route::get('account/ledger', 'AccountController@account_ledger');
Route::get('account/ledger/report', 'AccountController@account_ledger_report');

Route::get('stock-adjustment', 'stockController@stock_adjustment');
Route::post('stock-adjustment/save', 'stockController@stock_adjustment_save');
Route::get('stock-adjustment/history', 'stockController@stock_adjustment_history');
Route::get('stock-adjustment/edit/{adjustment}', 'stockController@stock_adjustment_edit');
Route::post('stock-adjustment/update', 'stockController@stock_adjustment_update');
Route::post('stock-adjustment/delete/{adjustment}', 'stockController@stock_adjustment_delete');

Route::get('/get/process/parameters','ProductionController@get_process_parameters');
Route::get('configuration/product/procedure/list','ProductionController@list_product_process');
Route::get('configuration/product/procedure/edit/{procedure}','ProductionController@edit_product_process');
Route::post('update/configuration/product/procedure','ProductionController@update_product_process');


Route::prefix('account')->group(function () {
Route::resource('cheques', ChequeController::class);
Route::resource('rates', RateController::class);
});



Route::get('configuration/expenses', 'ExpenseController@create');
Route::post('configuration/expenses/save', 'ExpenseController@store');

Route::get('configuration/transport-methods', 'TransportationController@index');
Route::post('configuration/transport-method/save', 'TransportationController@store');
Route::get('configuration/transport-method/edit/{transport}', 'TransportationController@edit');
Route::post('configuration/transport-method/update', 'TransportationController@update');

Route::get('configuration/packing-types', 'PackingTypeController@index');
Route::post('configuration/packing-type/save', 'PackingTypeController@store');
Route::get('configuration/packing-type/edit/{type}', 'PackingTypeController@edit');
Route::post('configuration/packing-type/update', 'PackingTypeController@update');

Route::get('configuration/freight-types', 'FreightTypeController@index');
Route::post('configuration/freight-type/save', 'FreightTypeController@store');
Route::get('configuration/freight-type/edit/{type}', 'FreightTypeController@edit');
Route::post('configuration/freight-type/update', 'FreightTypeController@update');

Route::get('configuration/ports', 'PortController@index');
Route::post('configuration/port/save', 'PortController@store');
Route::get('configuration/port/edit/{port}', 'PortController@edit');
Route::post('configuration/port/update', 'PortController@update');


Route::get('configuration/currency', 'CurrencyController@index');
Route::post('configuration/currency/save', 'CurrencyController@store');
Route::get('configuration/currency/edit/{currency}', 'CurrencyController@edit');
Route::post('configuration/currency/update', 'CurrencyController@update');

Route::get('company/config/', 'ConfigurationController@company_config');
Route::post('company/config/update', 'ConfigurationController@company_config_update');

Route::get('select/batch/stage', 'ProductionController@select_batch_stage');
Route::post('select/batch/stage', 'ProductionController@selected_batch_stage');
Route::get('get/ticket/stages', 'ProductionController@get_ticket_stages');
Route::post('initiate/batch/stage/save', 'ProductionController@save_initiate_stage');

Route::get('purchase/ledger', 'PurchaseController@purchase_ledger');
Route::get('sale/ledger/summary', 'SaleController@sale_ledger_summary');

Route::get('loan/request', 'LoanController@create');
Route::post('save/loan/request', 'LoanController@store');
Route::get('loan/request/history', 'LoanController@index');
Route::get('edit/loan/request/{doc_no}', 'LoanController@edit');
Route::post('update/loan/request', 'LoanController@update');

Route::get('inventory/stock-wise', 'InventoryController@stock_wise_inventory');

Route::get('inventory/near-expiry', 'InventoryController@near_expiry_inventory');
Route::get('print/near-expiry', 'InventoryController@print_near_expiry_inventory');
Route::get('inventory/expired', 'InventoryController@expired_inventory');
Route::get('print/expired', 'InventoryController@print_expired_inventory');

Route::get('point/create', 'PointController@create');
Route::post('point/save', 'PointController@store');
Route::get('point/list', 'PointController@index');
Route::get('edit/point/{point}', 'PointController@edit');
Route::post('point/update', 'PointController@update');

Route::get('doctor/create', 'DoctorController@create');
Route::post('save/doctor', 'DoctorController@store');
Route::get('doctor/list', 'DoctorController@index');
Route::get('edit/doctor/{doctor}', 'DoctorController@edit');
Route::post('update/doctor', 'DoctorController@update');

Route::get('investment/create', 'InvestmentController@create');
Route::post('save/investment/', 'InvestmentController@store');
Route::get('investment/history', 'InvestmentController@index');
Route::get('edit/investment/{investment}', 'InvestmentController@edit');
Route::post('investment/update', 'InvestmentController@update');

Route::get('point/sale/create', 'PointSaleController@create');
Route::post('save/point/sale', 'PointSaleController@store');
Route::get('point/sale/history', 'PointSaleController@index');
Route::get('edit/point/sale/{sale}', 'PointSaleController@edit');
Route::post('update/point/sale', 'PointSaleController@update');

Route::get('target/create', 'TargetController@create');
Route::post('save/target', 'TargetController@store');
Route::get('target/history', 'TargetController@index');
Route::get('edit/target/{target}', 'TargetController@edit');
Route::post('update/target', 'TargetController@update');

Route::get('doctor/sales/', 'PointSaleController@doctor_sales');
Route::get('doctor/sales/target-wise', 'PointSaleController@doctor_sales_target_wise');
Route::get('doctor/sales/target-wise1', 'PointSaleController@doctor_sales_target_wise1');
Route::get('print/doctors/sale', 'PointSaleController@print_doctor_sales');

Route::get('/gate-pass/create', 'GatepassController@create');
Route::post('/gate-pass/save', 'GatepassController@store');
Route::get('/get/gatepass/docno', 'GatepassController@get_pass_no');
Route::get('/gate-pass/history', 'GatepassController@index');
Route::get('/edit/gate-pass/{pass}', 'GatepassController@edit');
Route::post('/gate-pass/update', 'GatepassController@update');
Route::get('/gate-pass/report/{pass}', 'GatepassController@print_gatepass');

Route::get('asset/create', 'AssetController@create');
Route::post('asset/save', 'AssetController@store');

Route::get('import/sale', 'SaleController@import_sale');
Route::post('import/sale', 'SaleController@save_import_sale');

Route::get('salesman/sale', 'SalemanController@salesman_sales');
Route::get('salesman/sale/report', 'SalemanController@salesman_sales_report');

Route::get('config/commission/general', 'SalemanController@config_commission');
Route::get('config/commission/customer-wise/', 'SalemanController@config_commission_customer_wise');
Route::get('/get/so/customers/', 'SalemanController@so_customers');

Route::get('config/commission/area-wise/', 'CommissionController@create');
Route::post('save/config/commission/area-wise/', 'CommissionController@store');
Route::get('config/commission/history/', 'CommissionController@index');
Route::get('config/commission/area-wise/{commission}', 'CommissionController@edit');
Route::post('update/config/commission/area-wise/', 'CommissionController@update');

Route::get('sale-demand', 'SaledemandController@create');
Route::post('sale-demand/save', 'SaledemandController@store');
Route::get('sale-demand/history', 'SaledemandController@index');
Route::get('edit/sale-demand/{demand}', 'SaledemandController@edit');
Route::post('sale-demand/update', 'SaledemandController@update');
Route::get('print/sale-demand/{demand}', 'SaledemandController@demand_print');

Route::get('transfer-note', 'GoodsYieldController@create');
Route::post('transfer-note/save', 'GoodsYieldController@store');
Route::get('transfer-note/history', 'GoodsYieldController@index');
Route::get('edit/transfer-note/{yield}', 'GoodsYieldController@edit');
Route::post('transfer-note/update', 'GoodsYieldController@update');
Route::post('transfer-note/delete/{yield}', 'GoodsYieldController@destroy');
Route::get('print/transfer-note/{yield}', 'GoodsYieldController@print');

Route::get('dispensing', 'DispensingController@create');
Route::post('dispensing/save', 'DispensingController@store');
Route::get('dispensing/history', 'DispensingController@index');
Route::get('edit/dispensing/{dispensing}', 'DispensingController@edit');
Route::get('print/dispensing/{dispensing}', 'DispensingController@print');

Route::get('granulation', 'GranulationController@create');
Route::post('granulation/save', 'GranulationController@store');
Route::get('granulation/history', 'GranulationController@index');
Route::get('edit/granulation/{granulation}', 'GranulationController@edit');
Route::post('granulation/update', 'GranulationController@update');
Route::get('print/granulation/{granulation}', 'GranulationController@print');

Route::get('compression' , 'CompressionController@create');
Route::post('compression/save' , 'CompressionController@store');
Route::get('compression/history' , 'CompressionController@index');
Route::get('edit/compression/{compression}' , 'CompressionController@edit');
Route::post('compression/update' , 'CompressionController@update');
Route::get('print/compression/{compression}' , 'CompressionController@print');

Route::get('coating' , 'CoatingController@create');
Route::post('coating/save' , 'CoatingController@store');
Route::get('coating/history' , 'CoatingController@index');
Route::get('edit/coating/{coating}' , 'CoatingController@edit');
Route::post('coating/update' , 'CoatingController@update');
Route::get('print/coating/{coating}' , 'CoatingController@print');

Route::get('blistering' , 'BlisteringController@create');
Route::post('blistering/save' , 'BlisteringController@store');
Route::get('blistering/history' , 'BlisteringController@index');
Route::get('edit/blistering/{blistering}' , 'BlisteringController@edit');
Route::post('blistering/update' , 'BlisteringController@update');
Route::get('print/blistering/{blistering}' , 'BlisteringController@print');


Route::get('capsule-filling' , 'FillingController@create');

Route::get('/test1', 'ProductionController@index');
Route::get('/down', 'EmployeeController@test');
Route::get('/test2', 'SaleController@setRate');



} ); //end route group


Route::get('/clear-cache', function() {
Artisan::call('cache:clear');
return "Cache is cleared";
});

//net discount and tax in double in purchase and purchase_item

//remove tax col in s i (yad ni)

//buton in customer store that remove 0 value


//attendance , late_deduction in shift

//type col adjust in allowance

//employee_id in user

//salry , salry allowance tabel add



//std_id, super_id in std_table_rows

//add contact, contact2, mobile2 in customer

//deliver_via, bilty_no, bilty_type in dc;
//pack_size in inventory
//generic = hash code in inventory
//loan & loan instalment table

//name & specification & value (null) in qc_parameter , remove parameter_id
//change 5 to 1 in stock_status
//stock adjust item (grn_no , batch_no)
//issue item item (grn_no , batch_no)
//purchase_return (net_tax , net_discount) to double
//account_id in employee
//request_by, approved_by in request and remarks varchar to text
//issued_by, received_by , receiving_by in issue
//change remarks var char to text
//remove 6 & 7 (advance & Tax ) from employee_allowance
//del 6 & 7 (advance & Tax ) from allowance
//remove 6 & 7 (advance & Tax ) from salary_allowance
//salary tabel
//salesman_id in sale
//super_employee in emp
//city etc in customer
//comision & loan tabel

//new---
//sale_stock_id <=>challan_id in sale return stock 
//remove stock_status from grn_inventory
//is_sampled in replace of qc_required in grn_item
//mrp in grn_inventory

//migarte change table change for rate = customer_type

//quotation_id in order
//rate_type_id in customer 

//quotation_item_id in order_item
//order_item_id in delivery_item

//gtin_id in invetory & gtin table
//-----
//production demand
//pack_size_qty in inventory
