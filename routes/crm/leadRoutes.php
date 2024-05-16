<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Lead\LeadController;
use App\Http\Controllers\Lead\LeadSourceController;
use App\Http\Controllers\Lead\LeadStatusController;

Route::group(['middleware'=>['auth']], function(){
    Route::get('/lead/list', [LeadController::class, 'index'])->middleware(['can:view-lead']);
    Route::get('/lead/super',[LeadController::class, 'wonLeads'])->middleware(['can:view-lead']);
    Route::get('/lead/dead', [LeadController::class, 'deadLeads'])->middleware(['can:view-lead']);
    Route::get('/lead/hot', [LeadController::class, 'poorfitLeads'])->middleware(['can:view-lead']);
    
     Route::get('/lead/lost', [LeadController::class, 'lost_Leads'])->middleware(['can:view-lead']);
       Route::get('/lead/booking', [LeadController::class, 'book_Leads'])->middleware(['can:view-lead']);
    Route::get('/lead/won_lead', [LeadController::class, 'won_Leads'])->middleware(['can:view-lead']);
       Route::get('/lead/totallead', [LeadController::class, 'totallead'])->middleware(['can:view-lead']);
    Route::get('/lead/cold_lead', [LeadController::class, 'cold_Leads'])->middleware(['can:view-lead']);
    Route::get('/lead/create', [LeadController::class, 'create'])->middleware(['can:create-lead']);
    Route::post('/lead/add', [LeadController::class, 'store'])->middleware(['can:create-lead']);
    Route::post('/lead/sort', [LeadController::class, 'sort'])->middleware(['can:view-lead']);
    Route::get('/lead/show/{lead}', [LeadController::class, 'show'])->middleware(['can:view-lead']);
    Route::put('/lead/{lead}', [LeadController::class, 'update'])->middleware(['can:update-lead']);
    Route::delete('/lead/destroy/{lead}', [LeadController::class, 'destroy'])->middleware(['can:delete-lead']);

    Route::put('/lead/markAsDead/{lead}', [LeadController::class, 'markAsDead'])->middleware(['can:update-lead']);
    Route::put('/lead/markAsPoorfit/{lead}', [LeadController::class, 'markAsPoorfit'])->middleware(['can:update-lead']);
    Route::put('/lead/normalize/{lead}', [LeadController::class, 'normalizeLead'])->middleware(['can:update-lead']);

    Route::get('/lead/{lead}/proposals/', [LeadController::class, 'getProposals'])->middleware(['can:view-lead'])->name('lead_proposals');

    Route::get('/lead/{lead}/tasks/', [LeadController::class, 'getTasks'])->middleware(['can:view-lead'])->name('lead_tasks');

    Route::get('/lead/{lead}/media/', [LeadController::class, 'getMedia'])->middleware(['can:view-lead'])->name('lead_media');

    Route::get('/lead/{lead}/reminders/', [LeadController::class, 'getReminders'])->middleware(['can:view-lead'])->name('lead_reminders');

    // lead Source Routes
    Route::get('/lead/source', [LeadSourceController::class, 'index'])->middleware(['can:view-lead']);
    Route::post('/lead/source', [LeadSourceController::class, 'store'])->middleware(['can:create-lead']);
    Route::post('/lead/source/{leadSource}', [LeadSourceController::class, 'update'])->middleware(['can:update-lead']);
    Route::delete('/lead/source/destroy/{leadSource}', [LeadSourceController::class, 'destroy'])->middleware(['can:delete-lead']);

    // lead Status Routes
    Route::get('/lead/status', [LeadStatusController::class, 'index'])->middleware(['can:view-lead']);
    Route::post('/lead/status', [LeadStatusController::class, 'store'])->middleware(['can:create-lead']);
    Route::post('/lead/status/{leadStatus}', [LeadStatusController::class, 'update'])->middleware(['can:update-lead']);
    Route::delete('/lead/status/destroy/{leadStatus}', [LeadStatusController::class, 'destroy'])->middleware(['can:delete-lead']);

    // Bulk Excel Import 
    Route::get('lead/import', [ LeadController::class, 'import'])->middleware(['can:create-lead']);
    
    
     Route::get('/lead/interest', [LeadController::class, 'interest']);

    Route::post('lead/import', [ LeadController::class, 'importStore'])->middleware(['can:create-lead']);
    
    
      Route::post('/lead/interest/store', [LeadController::class, 'leadstatus1']);
      
       Route::get('/lead/tracking', [LeadController::class, 'leadtracking']);
        Route::get('/lead/pickup', [LeadController::class, 'pickupstatus']);
        
         Route::post('/lead/interest/store2', [LeadController::class, 'leadstatus2']);
         Route::get('/lead/follow', [LeadController::class, 'follow']);
                Route::get('/lead/googlelead', [LeadController::class, 'googlesheet']);
         
         
          Route::post('/lead/interest/store4', [LeadController::class, 'leadstatus4']);
          
          Route::post('/lead/lead_status', [LeadController::class, 'statusupdate']);
           Route::get('/lead/assgin_lead', [LeadController::class, 'lead_assign']);
           
            Route::post('/lead/lead/assign', [LeadController::class, 'statusassign']);
              Route::get('/lead/update', [LeadController::class, 'updatestatus']);
              
             
               Route::get('/lead/remarks', [LeadController::class, 'remarkupdate']);
                Route::post('/lead/remarksupdate', [LeadController::class, 'remarks_update']);
                Route::get('lead/leadfollow',[LeadController::class, 'follow_lead']);
});


// NOTE API Routes

Route::group(['prefix'=>'api', 'middleware'=>'auth:sanctum'], function(){

    // NOTE API lead TITLE ROUTES
    Route::get('lead/getTitles', [LeadController::class, 'getTitles']);

    // NOTE API lead Source ROUTES
    Route::get('lead/getSources', [LeadSourceController::class, 'getleadSources']);
    Route::post('lead/storeSource', [LeadSourceController::class, 'storeSource']);

    // NOTE API lead Status ROUTES
    Route::get('lead/getStatuses', [LeadStatusController::class, 'getleadStatuses']);
    Route::post('lead/storeStatus', [LeadStatusController::class, 'storeStatus']);

    // NOTE API LEAD check_email_availability
    Route::post('lead/check_email_availability', [LeadController::class, 'check_email_availability']);

    Route::get('/getCountries',     [LocationController::class, 'getCountries']);
    Route::get('/getStates/{id}',   [LocationController::class, 'getStates'])->name('location.states');
    Route::get('/getCities/{id}',   [LocationController::class, 'getCities'])->name('location.cities');
});
?>
