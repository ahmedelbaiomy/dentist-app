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


Auth::routes();

/* Route::get('/newdesign', function () {
    return view('admin.schedule.newdesign');
}); */

Route::get('/home', function () {
    Auth::logout();
    return redirect('/login');
});

Route::prefix('backup')->group(function () {
    Route::prefix('data')->group(function () {
        Route::get('/import', [App\Http\Controllers\BackupController::class, 'import']);
        Route::get('/import/categories', [App\Http\Controllers\BackupController::class, 'importCategories']);
        Route::get('/import/services', [App\Http\Controllers\BackupController::class, 'importServices']);
        Route::get('/export', [App\Http\Controllers\BackupController::class, 'export']);
        Route::get('/clear', [App\Http\Controllers\BackupController::class, 'clear']);
    });
  });

Route::get('account_setting', [App\Http\Controllers\HomeController::class, 'account_setting'])->name('account_setting');
Route::post('changepassword', [App\Http\Controllers\HomeController::class, 'changepassword'])->name('changepassword');
/* NEW PROFILE */
Route::get('/profile/patient/{patient_id}', [App\Http\Controllers\AppController::class, 'patientProfile'])->name('patient_profile');
Route::get('/profile/form/note/{patient_id}/{note_id}', [App\Http\Controllers\AppController::class, 'formNote']);
Route::post('/profile/form/note', [App\Http\Controllers\AppController::class, 'storeFormNote']);
Route::delete('/profile/delete/note/{note_id}', [App\Http\Controllers\AppController::class, 'deleteNote']);
Route::delete('/profile/delete/storage/{patient_storage_id}', [App\Http\Controllers\AppController::class, 'deletePatientStorage']);
Route::post('/profile/sdt/notes/{patient_id}', [App\Http\Controllers\AppController::class, 'sdtNotes']);
Route::post('/profile/sdt/storages/{patient_id}', [App\Http\Controllers\AppController::class, 'sdtStorages']);
Route::post('/profile/form/storage', [App\Http\Controllers\AppController::class, 'storeFormStorage']);
Route::get('/profile/patient/storage/{id}/download', [App\Http\Controllers\AppController::class, 'downloadPatientFile']);
Route::get('/profile/get/procedures/tooths', [App\Http\Controllers\AppController::class, 'getProceduresTooths']);
Route::get('/profile/construct/{type}/{patient_id}', [App\Http\Controllers\AppController::class, 'profileConstruct']);
Route::post('/profile/sdt/invoices/{patient_id}', [App\Http\Controllers\AppController::class, 'sdtInvoices']);
Route::get('/profile/get/invoice/items/{invoice_id}', [App\Http\Controllers\AppController::class, 'getInvoiceItems']);
Route::get('/profile/form/invoice/{patient_id}/{invoice_id}', [App\Http\Controllers\AppController::class, 'formInvoice']);
Route::post('/profile/form/invoice', [App\Http\Controllers\AppController::class, 'storeFormInvoice']);
Route::get('/profile/form/discount/{invoice_id}', [App\Http\Controllers\AppController::class, 'formDiscount']);
Route::post('/profile/form/discount', [App\Http\Controllers\AppController::class, 'storeFormDiscount']);
Route::get('/profile/invoice/items/{invoice_id}', [App\Http\Controllers\AppController::class, 'formInvoiceItems']);
Route::post('/profile/invoice/items', [App\Http\Controllers\AppController::class, 'storeInvoiceItems']);
Route::post('/profile/sdt/services/to/invoice/{invoice_id}', [App\Http\Controllers\AppController::class, 'sdtServiceToInvoice']);
Route::get('/profile/form/payment/{payment_id}/{invoice_id}', [App\Http\Controllers\AppController::class, 'formPayment']);
Route::post('/profile/form/payment', [App\Http\Controllers\AppController::class, 'storeFormPayment']);
Route::get('/profile/stats/invoice/{patient_id}', [App\Http\Controllers\AppController::class, 'getPatientStatsInvoice']);
Route::get('/profile/form/refund/{refund_id}/{invoice_id}', [App\Http\Controllers\AppController::class, 'formRefund']);
Route::post('/profile/form/refund', [App\Http\Controllers\AppController::class, 'storeFormRefund']);
Route::get('/profile/invoice/{invoice_id}/{mode}', [App\Http\Controllers\AppController::class, 'previewInvoice']);
Route::get('/profile/pdf/invoice/{invoice_id}/{mode}', [App\Http\Controllers\AppController::class, 'generateInvoicePdf']);

Route::group(['middleware' => ['auth', 'is_admin']], function () {

	Route::get('/', function () {
    	return redirect('admin/home');
	});

    Route::get('admin/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::post('/admin/dashboard/stats', [App\Http\Controllers\Admin\HomeController::class, 'dashboardStats']);
    //Reports
    Route::get('admin/reports', [App\Http\Controllers\AppController::class, 'reports'])->name('admin.reports');
    Route::post('/admin/reports/stats', [App\Http\Controllers\AppController::class, 'reportsStats']);
    //getJsonFinancesApexChart
    Route::post('/admin/reports/json/finances/stats/{type_data}', [App\Http\Controllers\AppController::class, 'getJsonFinancesApexChart']);
    Route::post('/admin/reports/json/appointments/stats/{type_data}', [App\Http\Controllers\AppController::class, 'getJsonAppointmentsApexChart']);
    
    Route::prefix('admin/settings')->group(function () {
        Route::get('/general', [App\Http\Controllers\AppController::class, 'settingsGeneral'])->name('admin.settings.general');
        Route::post('/general', [App\Http\Controllers\AppController::class, 'storeGeneralSetting']);
    });

    Route::prefix('admin/sdt')->group(function () {
        Route::post('/doctors/stats', [App\Http\Controllers\Admin\HomeController::class, 'sdtDoctorStats']);
        Route::post('/services/{category_id}', [App\Http\Controllers\Admin\ServicesController::class, 'sdtServices']);
        Route::post('/procedures/{patient_id}', [App\Http\Controllers\Admin\ServicesController::class, 'sdtProcedures']);
    });
    Route::get('/admin/form/service/{service_id}', [App\Http\Controllers\Admin\ServicesController::class, 'formService']);
    Route::post('/admin/form/service', [App\Http\Controllers\Admin\ServicesController::class, 'storeFormService']);
    
    
    Route::prefix('admin/form')->group(function () {
        Route::get('/service/{service_id}', [App\Http\Controllers\Admin\ServicesController::class, 'formService']);
        Route::post('/service', [App\Http\Controllers\Admin\ServicesController::class, 'storeFormService']);
        Route::get('/category/{category_id}', [App\Http\Controllers\Admin\ServicesController::class, 'formCategory']);
        Route::post('/category', [App\Http\Controllers\Admin\ServicesController::class, 'storeFormCategory']);

        Route::get('/procedure/service/item/{procedure_service_item_id}/{teeth_id}/{patient_id}/{doctor_id}', [App\Http\Controllers\Admin\ServicesController::class, 'formProcedureServiceItem']);
        Route::post('/procedure/service/item', [App\Http\Controllers\Admin\ServicesController::class, 'storeFormProcedureServiceItem']);
    });

    Route::prefix('admin/select')->group(function () {
        Route::get('/json/categories', [App\Http\Controllers\Admin\ServicesController::class, 'selectCategoriesOptions']);
        Route::get('/json/services/{category_id}', [App\Http\Controllers\Admin\ServicesController::class, 'selectServicesOptions']);
        Route::get('/json/doctors/{doctor_id}', [App\Http\Controllers\Admin\ServicesController::class, 'selectDoctorsOptions']);
    });
    Route::prefix('admin/delete')->group(function () {
        Route::delete('/service/{service_id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteService']);
        Route::delete('/category/{category_id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteCategory']);
    });
    Route::get('/admin/category/list', [App\Http\Controllers\Admin\ServicesController::class, 'listCategories']);
    Route::get('/admin/get/price/service/{service_id}', [App\Http\Controllers\Admin\ServicesController::class, 'getPriceService']);
    

    Route::get('admin/services', [App\Http\Controllers\Admin\ServicesController::class, 'index'])->name('admin.services');
    Route::post('admin/services', [App\Http\Controllers\Admin\ServicesController::class, 'store'])->name('admin.services');
    Route::post('admin/services/rootcatstore', [App\Http\Controllers\Admin\ServicesController::class, 'root_category_store'])->name('admin.services.rootcatstore');
    Route::post('admin/services/category', [App\Http\Controllers\Admin\ServicesController::class, 'category_store'])->name('admin.services.category');
    Route::put('admin/services/category', [App\Http\Controllers\Admin\ServicesController::class, 'category_update'])->name('admin.services.category');
    Route::put('admin/services/category/delete', [App\Http\Controllers\Admin\ServicesController::class, 'category_delete'])->name('admin.services.category.delete');
    Route::put('admin/services', [App\Http\Controllers\Admin\ServicesController::class, 'store'])->name('admin.services');
    Route::delete('admin/services/{service_id}', [App\Http\Controllers\Admin\ServicesController::class, 'destroy'])->name('admin.services.destroy');

    Route::get('admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::put('admin/users/{user_id}/{key}', [App\Http\Controllers\Admin\UserController::class, 'setstate'])->name('admin.users.setstate');
    Route::put('admin/users/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'resetpass'])->name('admin.users.resetpass');
    Route::put('admin/users', [App\Http\Controllers\Admin\UserController::class, 'settype'])->name('admin.users.settype');
    Route::delete('admin/users/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('admin/doctor', [App\Http\Controllers\Admin\DoctorController::class, 'index'])->name('admin.doctor');
    Route::post('admin/doctor/settarget', [App\Http\Controllers\Admin\DoctorController::class, 'settarget'])->name('admin.doctor.settarget');
    Route::post('admin/doctor/search', [App\Http\Controllers\Admin\DoctorController::class, 'search'])->name('admin.doctor.search');
    Route::get('admin/schedules', [App\Http\Controllers\Admin\DoctorController::class, 'schedules'])->name('admin.schedules');
    Route::get('admin/json/doctors', [App\Http\Controllers\Admin\DoctorController::class, 'jsonDoctorsForSelect']);
    Route::get('admin/get/schedules/{doctor_id}/{day}', [App\Http\Controllers\Admin\DoctorController::class, 'getSchedules']);
    Route::get('admin/form/slot/{doctor_id}/{day}', [App\Http\Controllers\Admin\DoctorController::class, 'formSlot']);
    Route::post('admin/form/slot', [App\Http\Controllers\Admin\DoctorController::class, 'storeFormSlot']);
    Route::delete('admin/delete/slot/{id}', [App\Http\Controllers\Admin\DoctorController::class, 'deleteSchedule']);


    Route::get('admin/patient', [App\Http\Controllers\Admin\PatientController::class, 'index'])->name('admin.patient');
    Route::get('admin/patient/{patient_id}', [App\Http\Controllers\Admin\PatientController::class, 'patient_profile']);
    Route::post('admin/patient/patient_profile', [App\Http\Controllers\Admin\PatientController::class, 'profilestore'])->name('admin.patient.profilestore');
    Route::post('admin/patient', [App\Http\Controllers\Admin\PatientController::class, 'store'])->name('admin.patient.store');
    Route::put('admin/patient', [App\Http\Controllers\Admin\PatientController::class, 'store'])->name('admin.patient.store');
    Route::delete('admin/patient/{patient_id}', [App\Http\Controllers\Admin\PatientController::class, 'destroy'])->name('admin.patient.destroy');
    Route::delete('admin/patient/patient_profile/{patient_id}', [App\Http\Controllers\Admin\PatientController::class, 'profile_destroy'])->name('admin.patient_profile.destroy');


    Route::get('admin/appointment', [App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('admin.appointment');

    Route::get('admin/officetime', [App\Http\Controllers\Admin\OfficetimeController::class, 'index'])->name('admin.officetime');
    Route::post('admin/officetime', [App\Http\Controllers\Admin\OfficetimeController::class, 'store'])->name('admin.officetime.store');
    Route::put('admin/officetime', [App\Http\Controllers\Admin\OfficetimeController::class, 'store'])->name('admin.officetime.store');
    Route::delete('admin/officetime/{officetime_id}', [App\Http\Controllers\Admin\OfficetimeController::class, 'destroy'])->name('admin.officetime.destroy');


    Route::get('admin/clinic', [App\Http\Controllers\Admin\ClinicController::class, 'index'])->name('admin.clinic');
    Route::post('admin/clinic', [App\Http\Controllers\Admin\ClinicController::class, 'store'])->name('admin.clinic.store');
    Route::post('admin/clinic/update', [App\Http\Controllers\Admin\ClinicController::class, 'update'])->name('admin.clinic.update');
   Route::delete('admin/clinic/{clinic_id}', [App\Http\Controllers\Admin\ClinicController::class, 'destroy'])->name('admin.clinic.destroy');
});




Route::group(['middleware' => ['auth', 'is_doctor']], function () {
    Route::get('/', function () {
    	return redirect('doctor/home');
	});

    Route::get('doctor/home', [App\Http\Controllers\Doctor\HomeController::class, 'index'])->name('doctor.home');
    Route::get('doctor/appointment', [App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('doctor.appointment');

    Route::get('doctor/service/note', [App\Http\Controllers\Doctor\NoteController::class, 'index'])->name('doctor.service.note');
    Route::get('doctor/service/patient/{patient_id}', [App\Http\Controllers\Doctor\ProfileController::class, 'index'])->name('doctor.service.patient');
    
    Route::post('doctor/patient/patient_profile', [App\Http\Controllers\Doctor\ProfileController::class, 'profilestore'])->name('doctor.patient.profilestore');
    Route::post('doctor/patient/BillingStore', [App\Http\Controllers\Doctor\ProfileController::class, 'BillingStore'])->name('doctor.patient.BillingStore');
    Route::post('doctor/patient/BillingPaid', [App\Http\Controllers\Doctor\ProfileController::class, 'BillingPaid'])->name('doctor.patient.BillingPaid');
    Route::get('doctor/invoice/print/{id}', [App\Http\Controllers\Doctor\ProfileController::class, 'generatepdf'])->name('doctor.invoice.generatepdf');

    Route::post('doctor/patient/notes', [App\Http\Controllers\Doctor\ProfileController::class, 'notestore'])->name('doctor.note.store');
    Route::delete('doctor/patient/notes/destroy/{id}', [App\Http\Controllers\Doctor\ProfileController::class, 'notedestroy'])->name('doctor.note.destroy');


    Route::get('doctor/service/plan', [App\Http\Controllers\Doctor\PlanController::class, 'index'])->name('doctor.service.plan');
    Route::get('doctor/service/plan/patient/{patient_id}', [App\Http\Controllers\Doctor\PlanController::class, 'patient'])->name('doctor.service.plan.patient');
    Route::post('doctor/service/plan/{plan_id}', [App\Http\Controllers\Doctor\PlanController::class, 'complete'])->name('doctor.service.plan.complete');
    
    Route::post('doctor/file-upload', [App\Http\Controllers\Doctor\PlanController::class, 'fileUploadPost'])->name('file.doctoreupload.post');
    Route::get('storage/{id}/download', [App\Http\Controllers\Doctor\PlanController::class, 'download'])->name('storage.download');
    Route::delete('doctor/file-upload/{storage_id}/{patient_id}', [App\Http\Controllers\Doctor\PlanController::class, 'destroy'])->name('doctor.storage.destroy');

    Route::post('doctor/invoice', [App\Http\Controllers\Doctor\InvoiceController::class, 'store'])->name('doctor.invoice.store');
    

});





Route::group(['middleware' => ['auth', 'is_patient']], function () {
    Route::get('patient/home', [HomeController::class, 'handleAdmin'])->name('patient.home');
});




Route::group(['middleware' => ['auth', 'is_reception']], function () {
    Route::get('/', function () {
    	return redirect('reception/home');
	});

    Route::get('reception/recorder', [App\Http\Controllers\Reception\HomeController::class, 'recorder'])->name('reception.recorder');
    Route::post('reception/upload/recorde', [App\Http\Controllers\Reception\HomeController::class, 'storeRecorde']);

    Route::get('reception/home', [App\Http\Controllers\Reception\HomeController::class, 'index'])->name('reception.home');
    Route::get('reception/home/get_patient_profile/{patient_id}', [App\Http\Controllers\Reception\HomeController::class, 'getProfile']);

    
    Route::get('reception/appointment', [App\Http\Controllers\Reception\AppointmentController::class, 'index'])->name('reception.appointment');
    Route::post('reception/appointment', [App\Http\Controllers\Reception\AppointmentController::class, 'store'])->name('reception.appointment.store');
    Route::put('reception/appointment', [App\Http\Controllers\Reception\AppointmentController::class, 'store'])->name('reception.appointment.store');
    Route::delete('reception/appointment/{appointment_id}', [App\Http\Controllers\Reception\AppointmentController::class, 'destroy'])->name('reception.appointment.destroy');
    Route::get('reception/appointment/{duration}/{doctor}/{starttime}/{endtime}', [App\Http\Controllers\Reception\AppointmentController::class, 'checkstate']);

    Route::get('reception/patient', [App\Http\Controllers\Reception\PatientController::class, 'index'])->name('reception.patient');
    Route::get('reception/patient/{id}', [App\Http\Controllers\Reception\PatientController::class, 'show'])->name('reception.patient.profile');
    Route::post('reception/patient', [App\Http\Controllers\Reception\PatientController::class, 'store'])->name('reception.patient.store');
    Route::put('reception/patient', [App\Http\Controllers\Reception\PatientController::class, 'store'])->name('reception.patient.store');
    Route::delete('reception/patient/{patient_id}', [App\Http\Controllers\Reception\PatientController::class, 'destroy'])->name('reception.patient.destroy');
    //Route::post('reception/patient/BillingPaid', [App\Http\Controllers\Reception\PatientController::class, 'BillingPaid'])->name('reception.patient.BillingPaid');

    Route::get('reception/patientprofile/{patient_id}/{doctor_id}', [App\Http\Controllers\Reception\PatientprofileController::class, 'index'])->name('reception.patientprofile');
    Route::post('reception/file-upload', [App\Http\Controllers\Reception\PatientprofileController::class, 'fileUploadPost'])->name('file.upload.post');
    Route::get('reception/{id}/download', [App\Http\Controllers\Reception\PatientprofileController::class, 'download'])->name('reception.storage.download');
    Route::delete('reception/file-upload/{storage_id}/{patient_id}/{doctor_id}', [App\Http\Controllers\Reception\PatientprofileController::class, 'destroy'])->name('reception.storage.destroy');

    Route::post('reception/patient/BillingStore', [App\Http\Controllers\Reception\PatientprofileController::class, 'BillingStore'])->name('reception.patient.BillingStore');
    Route::post('reception/patient/BillingPaid', [App\Http\Controllers\Reception\PatientprofileController::class, 'BillingPaid'])->name('reception.patient.BillingPaid');
    Route::get('reception/invoice/print/{id}', [App\Http\Controllers\Reception\PatientprofileController::class, 'generatepdf'])->name('reception.invoice.generatepdf');
    Route::post('reception/patient/notes', [App\Http\Controllers\Reception\PatientprofileController::class, 'notestore'])->name('reception.note.store');
    Route::delete('reception/patient/notes/destroy/{id}', [App\Http\Controllers\Reception\PatientprofileController::class, 'notedestroy'])->name('reception.note.destroy');

    Route::get('reception/invoice', [App\Http\Controllers\Reception\InvoiceController::class, 'index'])->name('reception.invoice');
    //Route::post('reception/invoice', [App\Http\Controllers\Reception\InvoiceController::class, 'store'])->name('reception.invoice.store');
    Route::post('reception/invoice/liststore', [App\Http\Controllers\Reception\InvoiceController::class, 'liststore'])->name('reception.invoice.liststore');
    Route::get('reception/invoice/{patient_id}/{doctor_id}', [App\Http\Controllers\Reception\InvoiceController::class, 'service_list']);
    Route::post('reception/invoice/plan/{plan_id}/{patient_id}/{doctor_id}', [App\Http\Controllers\Reception\InvoiceController::class, 'complete'])->name('reception.invoice.plan.complete');

    Route::post('reception/invoice/invoicestore', [App\Http\Controllers\Reception\InvoiceController::class, 'store'])->name('reception.invoice.store');
    
    Route::post('reception/getDoctorappointmentCalender', [App\Http\Controllers\Reception\HomeController::class, 'getDoctorappointmentCalender'])->name('reception.getDoctorappointmentCalender');
    Route::get('reception/get/time/slots/{doctor_id}/{start_date}', [App\Http\Controllers\Reception\HomeController::class, 'getDoctorTimeSlots']);
    Route::get('reception/get/nearst/time/{doctor_id}/{start_date}', [App\Http\Controllers\Reception\HomeController::class, 'getDoctorNearstTime']);

    Route::get('reception/form/appointment/{appointment_id}', [App\Http\Controllers\Reception\HomeController::class, 'formAppointment']);
    Route::post('reception/form/appointment', [App\Http\Controllers\Reception\HomeController::class, 'storeFormAppointment']);

});
//custom register store
Route::post('custom/register', [App\Http\Controllers\Auth\RegisterController::class, 'customRegisterUser'])->name('custom.register');