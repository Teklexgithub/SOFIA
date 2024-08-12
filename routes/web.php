<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DailyWorkController;
use App\Http\Controllers\ReportController;

use App\Http\Middleware\CheckActiveStatus;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::middleware([
    'auth',
    CheckActiveStatus::class // Add your custom middleware here
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Define other routes within this group
});





Route::controller(PermissionsController::class)->group(function() {
    //    Route of Permission
    Route::get('/users/permission', 'view_permission')->name("permission.view_permission");
    Route::get('/users/permission/index', 'index')->name("permission.index");
    Route::get('/users/permission/create', 'create_permission')->name("permission.create_permission");
    Route::post('/users/permission/update', 'update_permission')->name("permission.update_permission");
    Route::get('/users/permission/delete/{id}/', 'delete_permission')->name("permission.delete_permission");
    Route::get('/users/permission/show/{id}/', 'show_permission')->name("permission.show_permission");
    Route::post('/users/permission/store', 'store_permission')->name("permission.store_permission");
    Route::get('/users/permission/edit/{id}/', 'edit_permission')->name("permission.edit_permission");
    //    Route of Role
    Route::get('/users/role', 'view_role')->name("role.view_role");
    Route::get('/users/role/create', 'create_role')->name("role.create_role");
    Route::post('/users/role/update', 'update_role')->name("role.update_role");
    Route::get('/users/role/delete/{id}/', 'delete_role')->name("role.delete_role");
    Route::get('/users/role/show/{id}/', 'show_role')->name("role.show_role");
    Route::post('/users/role/store', 'store_role')->name("role.store_role");
    Route::get('/users/role/edit/{id}/', 'edit_role')->name("role.edit_role");
    //      Route of User
    Route::get('/users/user', 'view_user')->name("user.view_user");
    Route::get('/users/user/create', 'create_user')->name("user.create_user");
    Route::post('/users/user/update', 'update_user')->name("user.update_user");
    Route::get('/users/user/delete/{id}/', 'delete_user')->name("user.delete_user");
    Route::get('/users/user/show/{id}/', 'show_user')->name("user.show_user");
    Route::post('/users/user/store', 'store_user')->name("user.store_user");
    Route::get('/users/user/edit/{id}/', 'edit_user')->name("user.edit_user");
    Route::post('/users/user/status', 'changeStatusUser')->name("user.changeStatusUser");

});


Route::controller(AddressController::class)->group(function() {
    //    Route of Region
    Route::get('/address/region', 'view_region')->name("region.view_region");
    Route::get('/address/region/index', 'index')->name("region.index");
    Route::get('/address/region/create', 'create_region')->name("region.create_region");
    Route::post('/address/region/update', 'update_region')->name("region.update_region");
    Route::get('/address/region/delete/{id}/', 'delete_region')->name("region.delete_region");
    Route::get('/address/region/show/{id}/', 'show_region')->name("region.show_region");
    Route::post('/address/region/store', 'store_region')->name("region.store_region");
    Route::get('/address/region/edit/{id}/', 'edit_region')->name("region.edit_region");
    //    Route of Zone
    Route::get('/address/zone', 'view_zone')->name("zone.view_zone");
    Route::get('/address/zone/create', 'create_zone')->name("zone.create_zone");
    Route::post('/address/zone/update', 'update_zone')->name("zone.update_zone");
    Route::get('/address/zone/delete/{id}/', 'delete_zone')->name("zone.delete_zone");
    Route::get('/address/zone/show/{id}/', 'show_zone')->name("zone.show_zone");
    Route::post('/address/zone/store', 'store_zone')->name("zone.store_zone");
    Route::get('/address/zone/edit/{id}/', 'edit_zone')->name("zone.edit_zone");
    //      Route of Woreda
    Route::get('/address/woreda', 'view_woreda')->name("woreda.view_woreda");
    Route::get('/address/woreda/create', 'create_woreda')->name("woreda.create_woreda");
    Route::post('/address/woreda/update', 'update_woreda')->name("woreda.update_woreda");
    Route::get('/address/woreda/delete/{id}/', 'delete_woreda')->name("woreda.delete_woreda");
    Route::get('/address/woreda/show/{id}/', 'show_woreda')->name("woreda.show_woreda");
    Route::post('/address/woreda/store', 'store_woreda')->name("woreda.store_woreda");
    Route::get('/address/woreda/edit/{id}/', 'edit_woreda')->name("woreda.edit_woreda");
     //      Route of Branch
    Route::get('/address/branch', 'view_branch')->name("branch.view_branch");
    Route::get('/address/branch/create', 'create_branch')->name("branch.create_branch");
    Route::post('/address/branch/update', 'update_branch')->name("branch.update_branch");
    Route::get('/address/branch/delete/{id}/', 'delete_branch')->name("branch.delete_branch");
    Route::get('/address/branch/show/{id}/', 'show_branch')->name("branch.show_branch");
    Route::post('/address/branch/store', 'store_branch')->name("branch.store_branch");
    Route::get('/address/branch/edit/{id}/', 'edit_branch')->name("branch.edit_branch");
    Route::post('/address/branch/status', 'changeStatusBranch')->name("branch.changeStatusBranch");
        // Address Dropdown Route
    Route::get('region-zone-woreda-kebele', 'index')->name("address.index");
    Route::post('get-zone-by-region', 'getZone')->name("address.getZone");
    Route::post('get-woreda-by-zone', 'getWoreda')->name("address.getWoreda");

});

Route::controller(EmployeeController::class)->group(function() {
    //    Route of Employee
    Route::get('/employees/employee', 'view_employee')->name("employee.view_employee");
    Route::get('/employees/employee/index', 'index')->name("employee.index");
    Route::get('/employees/employee/create', 'create_employee')->name("employee.create_employee");
    Route::post('/employees/employee/update', 'update_employee')->name("employee.update_employee");
    Route::get('/employees/employee/delete/{id}/', 'delete_employee')->name("employee.delete_employee");
    Route::get('/employees/employee/show/{id}/', 'show_employee')->name("employee.show_employee");
    Route::post('/employees/employee/store', 'store_employee')->name("employee.store_employee");
    Route::get('/employees/employee/edit/{id}/', 'edit_employee')->name("employee.edit_employee");
    //    Route of Salary
    Route::get('/employees/salary', 'view_salary')->name("salary.view_salary");
    Route::get('/employees/salary/create', 'create_salary')->name("salary.create_salary");
    Route::post('/employees/salary/update', 'update_salary')->name("salary.update_salary");
    Route::get('/employees/salary/delete/{id}/', 'delete_salary')->name("salary.delete_salary");
    Route::get('/employees/salary/show/{id}/', 'show_salary')->name("salary.show_salary");
    Route::post('/employees/salary/store', 'store_salary')->name("salary.store_salary");
    Route::get('/employees/salary/edit/{id}/', 'edit_salary')->name("salary.edit_salary");
    //    Route of Employee Credit
    Route::get('/employees/credit', 'view_credit')->name("credit.view_credit");
    Route::get('/employees/credit/create', 'create_credit')->name("credit.create_credit");
    Route::post('/employees/credit/update', 'update_credit')->name("credit.update_credit");
    Route::get('/employees/credit/delete/{id}/', 'delete_credit')->name("credit.delete_credit");
    Route::get('/employees/credit/show/{id}/', 'show_credit')->name("credit.show_credit");
    Route::post('/employees/credit/store', 'store_credit')->name("credit.store_credit");
    Route::get('/employees/credit/edit/{id}/', 'edit_credit')->name("credit.edit_credit");


});

Route::controller(MaterialController::class)->group(function() {
    //    Route of Khat
    Route::get('/material/khat', 'view_khat')->name("khat.view_khat");
    Route::get('/material/khat/index', 'index')->name("khat.index");
    Route::get('/material/khat/create', 'create_khat')->name("khat.create_khat");
    Route::post('/material/khat/update', 'update_khat')->name("khat.update_khat");
    Route::get('/material/khat/delete/{id}/', 'delete_khat')->name("khat.delete_khat");
    Route::get('/material/khat/show/{id}/', 'show_khat')->name("khat.show_khat");
    Route::post('/material/khat/store', 'store_khat')->name("khat.store_khat");
    Route::get('/material/khat/edit/{id}/', 'edit_khat')->name("khat.edit_khat");
    Route::post('/material/khat/status', 'changeStatusKhat')->name("khat.changeStatusKhat");
    //    Route of Soft drink
    Route::get('/material/soft_drink', 'view_soft_drink')->name("soft_drink.view_soft_drink");
    Route::get('/material/soft_drink/create', 'create_soft_drink')->name("soft_drink.create_soft_drink");
    Route::post('/material/soft_drink/update', 'update_soft_drink')->name("soft_drink.update_soft_drink");
    Route::get('/material/soft_drink/delete/{id}/', 'delete_soft_drink')->name("soft_drink.delete_soft_drink");
    Route::get('/material/soft_drink/show/{id}/', 'show_soft_drink')->name("soft_drink.show_soft_drink");
    Route::post('/material/soft_drink/store', 'store_soft_drink')->name("soft_drink.store_soft_drink");
    Route::get('/material/soft_drink/edit/{id}/', 'edit_soft_drink')->name("soft_drink.edit_soft_drink");
    Route::post('/material/soft_drink/status', 'changeStatusSoftdrink')->name("soft_drink.changeStatusSoftdrink");
    //    Route of Cigarates
    Route::get('/material/cigarate', 'view_cigarate')->name("cigarate.view_cigarate");
    Route::get('/material/cigarate/create', 'create_cigarate')->name("cigarate.create_cigarate");
    Route::post('/material/cigarate/update', 'update_cigarate')->name("cigarate.update_cigarate");
    Route::get('/material/cigarate/delete/{id}/', 'delete_cigarate')->name("cigarate.delete_cigarate");
    Route::get('/material/cigarate/show/{id}/', 'show_cigarate')->name("cigarate.show_cigarate");
    Route::post('/material/cigarate/store', 'store_cigarate')->name("cigarate.store_cigarate");
    Route::get('/material/cigarate/edit/{id}/', 'edit_cigarate')->name("cigarate.edit_cigarate");
    Route::post('/material/cigarate/status', 'changeStatusCigarate')->name("cigarate.changeStatusCigarate");
    //    Route of Lozi
    Route::get('/material/lozi', 'view_lozi')->name("lozi.view_lozi");
    Route::get('/material/lozi/create', 'create_lozi')->name("lozi.create_lozi");
    Route::post('/material/lozi/update', 'update_lozi')->name("lozi.update_lozi");
    Route::get('/material/lozi/delete/{id}/', 'delete_lozi')->name("lozi.delete_lozi");
    Route::get('/material/lozi/show/{id}/', 'show_lozi')->name("lozi.show_lozi");
    Route::post('/material/lozi/store', 'store_lozi')->name("lozi.store_lozi");
    Route::get('/material/lozi/edit/{id}/', 'edit_lozi')->name("lozi.edit_lozi");
    Route::post('/material/lozi/status', 'changeStatusLozi')->name("lozi.changeStatusLozi");
    //    Route of Store
    Route::get('/material/store', 'view_store')->name("store.view_store");
    Route::get('/material/store/create', 'create_store')->name("store.create_store");
    Route::post('/material/store/update', 'update_store')->name("store.update_store");
    Route::get('/material/store/delete/{id}/', 'delete_store')->name("store.delete_store");
    Route::get('/material/store/show/{id}/', 'show_store')->name("store.show_store");
    Route::post('/material/store/store', 'store_store')->name("store.store_store");
    Route::get('/material/store/edit/{id}/', 'edit_store')->name("store.edit_store");
    
    


});


Route::controller(DailyWorkController::class)->group(function() {
    //    Route of Yemeta Khat
    Route::get('/dailywork/yemetakhat', 'view_yemetakhat')->name("yemetakhat.view_yemetakhat");
    Route::get('/dailywork/yemetakhat/index', 'index')->name("yemetakhat.index");
    Route::get('/dailywork/yemetakhat/create', 'create_yemetakhat')->name("yemetakhat.create_yemetakhat");
    Route::post('/dailywork/yemetakhat/update', 'update_yemetakhat')->name("yemetakhat.update_yemetakhat");
    Route::get('/dailywork/yemetakhat/delete/{id}/', 'delete_yemetakhat')->name("yemetakhat.delete_yemetakhat");
    Route::get('/dailywork/yemetakhat/show/{id}/', 'show_yemetakhat')->name("yemetakhat.show_yemetakhat");
    Route::post('/dailywork/yemetakhat/store', 'store_yemetakhat')->name("yemetakhat.store_yemetakhat");
    Route::get('/dailywork/yemetakhat/edit/{id}/', 'edit_yemetakhat')->name("yemetakhat.edit_yemetakhat");
    //    Route of  Khat Hisabi
    Route::get('/dailywork/dailyworkkhat', 'view_dailyworkkhat')->name("dailyworkkhat.view_dailyworkkhat");
    Route::get('/dailywork/dailyworkkhat/create', 'create_dailyworkkhat')->name("dailyworkkhat.create_dailyworkkhat");
    Route::post('/dailywork/dailyworkkhat/update', 'update_dailyworkkhat')->name("dailyworkkhat.update_dailyworkkhat");
    Route::get('/dailywork/dailyworkkhat/delete/{id}/', 'delete_dailyworkkhat')->name("dailyworkkhat.delete_dailyworkkhat");
    Route::get('/dailywork/dailyworkkhat/show/{id}/', 'show_dailyworkkhat')->name("dailyworkkhat.show_dailyworkkhat");
    Route::post('/dailywork/dailyworkkhat/store', 'store_dailyworkkhat')->name("dailyworkkhat.store_dailyworkkhat");
    Route::get('/dailywork/dailyworkkhat/edit/{id}/', 'edit_dailyworkkhat')->name("dailyworkkhat.edit_dailyworkkhat");
    //    Route of  Soft Drink Hisabi
    Route::get('/dailywork/dailyworksoftdrink', 'view_dailyworksoftdrink')->name("dailyworksoftdrink.view_dailyworksoftdrink");
    Route::get('/dailywork/dailyworksoftdrink/create', 'create_dailyworksoftdrink')->name("dailyworksoftdrink.create_dailyworksoftdrink");
    Route::post('/dailywork/dailyworksoftdrink/update', 'update_dailyworksoftdrink')->name("dailyworksoftdrink.update_dailyworksoftdrink");
    Route::get('/dailywork/dailyworksoftdrink/delete/{id}/', 'delete_dailyworksoftdrink')->name("dailyworksoftdrink.delete_dailyworksoftdrink");
    Route::get('/dailywork/dailyworksoftdrink/show/{id}/', 'show_dailyworksoftdrink')->name("dailyworksoftdrink.show_dailyworksoftdrink");
    Route::post('/dailywork/dailyworksoftdrink/store', 'store_dailyworksoftdrink')->name("dailyworksoftdrink.store_dailyworksoftdrink");
    Route::get('/dailywork/dailyworksoftdrink/edit/{id}/', 'edit_dailyworksoftdrink')->name("dailyworksoftdrink.edit_dailyworksoftdrink");
    //    Route of  Lozi Hisabi
    Route::get('/dailywork/dailyworklozi', 'view_dailyworklozi')->name("dailyworklozi.view_dailyworklozi");
    Route::get('/dailywork/dailyworklozi/create', 'create_dailyworklozi')->name("dailyworklozi.create_dailyworklozi");
    Route::post('/dailywork/dailyworklozi/update', 'update_dailyworklozi')->name("dailyworklozi.update_dailyworklozi");
    Route::get('/dailywork/dailyworklozi/delete/{id}/', 'delete_dailyworklozi')->name("dailyworklozi.delete_dailyworklozi");
    Route::get('/dailywork/dailyworklozi/show/{id}/', 'show_dailyworklozi')->name("dailyworklozi.show_dailyworklozi");
    Route::post('/dailywork/dailyworklozi/store', 'store_dailyworklozi')->name("dailyworklozi.store_dailyworklozi");
    Route::get('/dailywork/dailyworklozi/edit/{id}/', 'edit_dailyworklozi')->name("dailyworklozi.edit_dailyworklozi");
    //    Route of  Cigarates Hisabi
    Route::get('/dailywork/dailyworkcigarates', 'view_dailyworkcigarates')->name("dailyworkcigarates.view_dailyworkcigarates");
    Route::get('/dailywork/dailyworkcigarates/create', 'create_dailyworkcigarates')->name("dailyworkcigarates.create_dailyworkcigarates");
    Route::post('/dailywork/dailyworkcigarates/update', 'update_dailyworkcigarates')->name("dailyworkcigarates.update_dailyworkcigarates");
    Route::get('/dailywork/dailyworkcigarates/delete/{id}/', 'delete_dailyworkcigarates')->name("dailyworkcigarates.delete_dailyworkcigarates");
    Route::get('/dailywork/dailyworkcigarates/show/{id}/', 'show_dailyworkcigarates')->name("dailyworkcigarates.show_dailyworkcigarates");
    Route::post('/dailywork/dailyworkcigarates/store', 'store_dailyworkcigarates')->name("dailyworkcigarates.store_dailyworkcigarates");
    Route::get('/dailywork/dailyworkcigarates/edit/{id}/', 'edit_dailyworkcigarates')->name("dailyworkcigarates.edit_dailyworkcigarates");
    //    Route of  Account Hisabi
    Route::get('/dailywork/dailyworkaccount', 'view_dailyworkaccount')->name("dailyworkaccount.view_dailyworkaccount");
    Route::get('/dailywork/dailyworkaccount/create', 'create_dailyworkaccount')->name("dailyworkaccount.create_dailyworkaccount");
    Route::post('/dailywork/dailyworkaccount/update', 'update_dailyworkaccount')->name("dailyworkaccount.update_dailyworkaccount");
    Route::get('/dailywork/dailyworkaccount/delete/{id}/', 'delete_dailyworkaccount')->name("dailyworkaccount.delete_dailyworkaccount");
    Route::get('/dailywork/dailyworkaccount/show/{id}/', 'show_dailyworkaccount')->name("dailyworkaccount.show_dailyworkaccount");
    Route::post('/dailywork/dailyworkaccount/store', 'store_dailyworkaccount')->name("dailyworkaccount.store_dailyworkaccount");
    Route::get('/dailywork/dailyworkaccount/edit/{id}/', 'edit_dailyworkaccount')->name("dailyworkaccount.edit_dailyworkaccount");
    //    Route of  Credit Hisabi
    Route::get('/dailywork/dailyworkcredit', 'view_dailyworkcredit')->name("dailyworkcredit.view_dailyworkcredit");
    Route::get('/dailywork/dailyworkcredit/create', 'create_dailyworkcredit')->name("dailyworkcredit.create_dailyworkcredit");
    Route::post('/dailywork/dailyworkcredit/update', 'update_dailyworkcredit')->name("dailyworkcredit.update_dailyworkcredit");
    Route::get('/dailywork/dailyworkcredit/delete/{id}/', 'delete_dailyworkcredit')->name("dailyworkcredit.delete_dailyworkcredit");
    Route::get('/dailywork/dailyworkcredit/show/{id}/', 'show_dailyworkcredit')->name("dailyworkcredit.show_dailyworkcredit");
    Route::post('/dailywork/dailyworkcredit/store', 'store_dailyworkcredit')->name("dailyworkcredit.store_dailyworkcredit");
    Route::get('/dailywork/dailyworkcredit/edit/{id}/', 'edit_dailyworkcredit')->name("dailyworkcredit.edit_dailyworkcredit");
    // Route::post('/dailywork/dailyworkcredit/status', 'changeStatusPaid')->name("dailyworkcredit.changeStatusPaid");
    //    Route of  Yetekefele Hisabi
    Route::get('/dailywork/dailyworkyetekefele', 'view_dailyworkyetekefele')->name("dailyworkyetekefele.view_dailyworkyetekefele");
    Route::get('/dailywork/dailyworkyetekefele/create', 'create_dailyworkyetekefele')->name("dailyworkyetekefele.create_dailyworkyetekefele");
    Route::post('/dailywork/dailyworkyetekefele/update', 'update_dailyworkyetekefele')->name("dailyworkyetekefele.update_dailyworkyetekefele");
    Route::get('/dailywork/dailyworkyetekefele/delete/{id}/', 'delete_dailyworkyetekefele')->name("dailyworkyetekefele.delete_dailyworkyetekefele");
    Route::get('/dailywork/dailyworkyetekefele/show/{id}/', 'show_dailyworkyetekefele')->name("dailyworkyetekefele.show_dailyworkyetekefele");
    Route::post('/dailywork/dailyworkyetekefele/store', 'store_dailyworkyetekefele')->name("dailyworkyetekefele.store_dailyworkyetekefele");
    Route::get('/dailywork/dailyworkyetekefele/edit/{id}/', 'edit_dailyworkyetekefele')->name("dailyworkyetekefele.edit_dailyworkyetekefele");
    //    Route of  Birr Daily
    Route::get('/dailywork/dailyworkbirr', 'view_dailyworkbirr')->name("dailyworkbirr.view_dailyworkbirr");
    Route::get('/dailywork/dailyworkbirr/create', 'create_dailyworkbirr')->name("dailyworkbirr.create_dailyworkbirr");
    Route::post('/dailywork/dailyworkbirr/update', 'update_dailyworkbirr')->name("dailyworkbirr.update_dailyworkbirr");
    Route::get('/dailywork/dailyworkbirr/delete/{id}/', 'delete_dailyworkbirr')->name("dailyworkbirr.delete_dailyworkbirr");
    Route::get('/dailywork/dailyworkbirr/show/{id}/', 'show_dailyworkbirr')->name("dailyworkbirr.show_dailyworkbirr");
    Route::post('/dailywork/dailyworkbirr/store', 'store_dailyworkbirr')->name("dailyworkbirr.store_dailyworkbirr");
    Route::get('/dailywork/dailyworkbirr/edit/{id}/', 'edit_dailyworkbirr')->name("dailyworkbirr.edit_dailyworkbirr");
    //    Route of  Woci Daily
    Route::get('/dailywork/dailyworkwoci', 'view_dailyworkwoci')->name("dailyworkwoci.view_dailyworkwoci");
    Route::get('/dailywork/dailyworkwoci/create', 'create_dailyworkwoci')->name("dailyworkwoci.create_dailyworkwoci");
    Route::post('/dailywork/dailyworkwoci/update', 'update_dailyworkwoci')->name("dailyworkwoci.update_dailyworkwoci");
    Route::get('/dailywork/dailyworkwoci/delete/{id}/', 'delete_dailyworkwoci')->name("dailyworkwoci.delete_dailyworkwoci");
    Route::get('/dailywork/dailyworkwoci/show/{id}/', 'show_dailyworkwoci')->name("dailyworkwoci.show_dailyworkwoci");
    Route::post('/dailywork/dailyworkwoci/store', 'store_dailyworkwoci')->name("dailyworkwoci.store_dailyworkwoci");
    Route::get('/dailywork/dailyworkwoci/edit/{id}/', 'edit_dailyworkwoci')->name("dailyworkwoci.edit_dailyworkwoci");
    //    Route of  Gudilet Daily
    Route::get('/dailywork/dailyworkgudilet', 'view_dailyworkgudilet')->name("dailyworkgudilet.view_dailyworkgudilet");
    Route::get('/dailywork/dailyworkgudilet/create', 'create_dailyworkgudilet')->name("dailyworkgudilet.create_dailyworkgudilet");
    Route::post('/dailywork/dailyworkgudilet/update', 'update_dailyworkgudilet')->name("dailyworkgudilet.update_dailyworkgudilet");
    Route::get('/dailywork/dailyworkgudilet/delete/{id}/', 'delete_dailyworkgudilet')->name("dailyworkgudilet.delete_dailyworkgudilet");
    Route::get('/dailywork/dailyworkgudilet/show/{id}/', 'show_dailyworkgudilet')->name("dailyworkgudilet.show_dailyworkgudilet");
    Route::post('/dailywork/dailyworkgudilet/store', 'store_dailyworkgudilet')->name("dailyworkgudilet.store_dailyworkgudilet");
    Route::get('/dailywork/dailyworkgudilet/edit/{id}/', 'edit_dailyworkgudilet')->name("dailyworkgudilet.edit_dailyworkgudilet");




});


Route::controller(ReportController::class)->group(function() {
    //    Route of Branch Report
    Route::get('/report/branchreport', 'view_branchreport')->name("branchreport.view_branchreport");
    Route::post('/report/branchreport/create', 'create_branchreport')->name("branchreport.create_branchreport");

    //    Route of Exporter Report
    Route::get('/report/exportereport', 'view_exportereport')->name("exportereport.view_exportereport");
    Route::post('/report/exportereport/create', 'create_exportereport')->name("exportereport.create_exportereport");
    
   
    

});


