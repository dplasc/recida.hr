<?php


use App\Http\Controllers\Admin\CustomFieldController;
use App\Http\Controllers\Agent\AgentCustomFieldController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;



Route::prefix('admin')->middleware(['auth', 'anyAuth'])->group(function () {
  Route::get('custom-field/create/{type}/{listing_id}', [CustomFieldController::class, 'customField_Create'])->name('admin.custom-field.create'); 
  Route::Post('custom-field/store', [CustomFieldController::class, 'customField_store'])->name('admin.custom-field.store'); 
  Route::get('custom-field/delete/{field_id}/{item_id}', [CustomFieldController::class, 'customFieldDelete'])->name('admin.custom-field.delete');

  Route::get('custom-field/edit/{field_id}/{item_id}', [CustomFieldController::class, 'customFieldEdit'])->name('admin.custom-field.edit');
  Route::Post('custom-field/update/{field_id}/{item_id}', [CustomFieldController::class, 'customFieldUpdate'])->name('admin.custom-field.update');

   Route::get('custom-section/{id}', [CustomFieldController::class, 'customSectionEdit'])->name('admin.custom-section.edit');
   
   Route::post('custom-section/{id}', [CustomFieldController::class, 'customSectionUpdate'])->name('admin.custom-section.update');

   Route::get('custom-section/delete/{id}', [CustomFieldController::class, 'customSectionDelete'])->name('admin.custom-section.delete');

   Route::get('section-sorting/{type}/{listing_id}', [CustomFieldController::class, 'sectionSorting'])->name('admin.section.sorting');

   Route::post('section-sort/update', [CustomFieldController::class, 'SectionSortUpdate'])->name('admin.section.sort.update');


});

Route::prefix('agent')->middleware(['auth', 'anyAuth'])->group(function () {

  Route::get('custom-field/create/{type}/{listing_id}', [AgentCustomFieldController::class, 'customField_Create'])->name('agent.custom-field.create'); 
  Route::Post('custom-field/store', [AgentCustomFieldController::class, 'customField_store'])->name('agent.custom-field.store'); 
  Route::get('custom-field/delete/{field_id}/{item_id}', [AgentCustomFieldController::class, 'customFieldDelete'])->name('agent.custom-field.delete');

  Route::get('custom-field/edit/{field_id}/{item_id}', [AgentCustomFieldController::class, 'customFieldEdit'])->name('agent.custom-field.edit');
  Route::Post('custom-field/update/{field_id}/{item_id}', [AgentCustomFieldController::class, 'customFieldUpdate'])->name('agent.custom-field.update');

   Route::get('custom-section/{id}', [AgentCustomFieldController::class, 'customSectionEdit'])->name('agent.custom-section.edit');
   
   Route::post('custom-section/{id}', [AgentCustomFieldController::class, 'customSectionUpdate'])->name('agent.custom-section.update');

   Route::get('custom-section/delete/{id}', [AgentCustomFieldController::class, 'customSectionDelete'])->name('agent.custom-section.delete');

   Route::get('section-sorting/{type}/{listing_id}', [AgentCustomFieldController::class, 'sectionSorting'])->name('agent.section.sorting');

   Route::post('section-sort/update', [AgentCustomFieldController::class, 'SectionSortUpdate'])->name('agent.section.sort.update');


});
