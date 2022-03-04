<?php

declare(strict_types=1);
//Экраны редактирования клиента
use App\Orchid\Screens\Clients\ClientEditScreen;
use App\Orchid\Screens\Clients\ClientEntityEditScreen;
use App\Orchid\Screens\Clients\ClientFizEditScreen;
use App\Orchid\Screens\Clients\ClientListScreen;

//Экраны дизайна
use App\Orchid\Screens\Design\DesingListScreen;
use App\Orchid\Screens\Design\DesingScreen;

//Экраны прайсов
use App\Orchid\Screens\DocumentsTemplateEditScreen;
use App\Orchid\Screens\DocumentsTemplateListScreen;
use App\Orchid\Screens\EstimateEditScreen;
use App\Orchid\Screens\EstimateListScreen;
use App\Orchid\Screens\LCabout;
use App\Orchid\Screens\LCprojectsScreen;
use App\Orchid\Screens\NormsEditScreen;
use App\Orchid\Screens\NormsListScreen;
use App\Orchid\Screens\PriceListScreen;
use App\Orchid\Screens\PriselistItemEditScreen;

//Экраны секции ремонта
use App\Orchid\Screens\Repair\RepairListScreen;
use App\Orchid\Screens\Repair\RepairScreen;

use App\Orchid\Screens\DocumentsListScreen;
use App\Orchid\Screens\DocumentsEditScreen;

use App\Orchid\Screens\CashboxListScreen;
use App\Orchid\Screens\CashboxEditScreen;

use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\RepairPriseEditScreen;
use App\Orchid\Screens\RepairPriseListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\SuppliersEditScreen;
use App\Orchid\Screens\SuppliersListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/


// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{users}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Edit'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

Route::screen('supplier/{supplier?}', SuppliersEditScreen::class)->name('platform.suppliers.edit');
Route::screen('suppliers', SuppliersListScreen::class)->name('platform.suppliers.list');

Route::screen('client/ent/{client?}', ClientEntityEditScreen::class)->name('platform.client_ent.edit');
Route::screen('client/fiz/{client?}', ClientFizEditScreen::class)->name('platform.client_fiz.edit');
Route::screen('client/{client?}', ClientEditScreen::class)->name('platform.client.edit');
Route::screen('clients', ClientListScreen::class)->name('platform.client.list');

Route::screen('perPrice-item/{item?}', RepairPriseEditScreen::class)->name('platform.repPrice.edit');
Route::screen('repPrice-list', RepairPriseListScreen::class)->name('platform.repPrice.list');

Route::screen('estimate-item/{item?}', EstimateEditScreen::class)->name('platform.estimate.edit');
Route::screen('estimate-list', EstimateListScreen::class)->name('platform.estimate.list');

Route::screen('price-item/{item?}', PriselistItemEditScreen::class)->name('platform.price.edit');
Route::screen('price-list', PriceListScreen::class)->name('platform.price.list');

Route::screen('norms-item/{item?}', NormsEditScreen::class)->name('platform.norms.edit');
Route::screen('norms-list', NormsListScreen::class)->name('platform.norms.list');

Route::screen('design-item/{design?}', DesingScreen::class)->name('platform.design.edit');
Route::screen('design-list', DesingListScreen::class)->name('platform.design.list');

Route::screen('repair-item/{design?}', RepairScreen::class)->name('platform.repair.edit');
Route::screen('repair-list', RepairListScreen::class)->name('platform.repair.list');

Route::screen('documentsTemplate-item/{item?}', DocumentsTemplateEditScreen::class)->name('platform.documentsTemplate.edit');
Route::screen('documentsTemplate-list', DocumentsTemplateListScreen::class)->name('platform.documentsTemplate.list');


Route::screen('documents-item/{item?}', DocumentsEditScreen::class)->name('platform.documents.edit');
Route::screen('documents-list', DocumentsListScreen::class)->name('platform.documents.list');

Route::screen('cashbox-item/{item?}', CashboxEditScreen::class)->name('platform.cashbox.edit');
Route::screen('cashbox-list', CashboxListScreen::class)->name('platform.cashbox.list');

Route::screen('lc-projects', LCprojectsScreen::class)->name('platform.lc.projects');
Route::screen('lc-about', LCabout::class)->name('platform.lc.about');

Route::get('download/pdf', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('pdf');
