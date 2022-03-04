<?php

namespace App\Orchid;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemMenu;
use Orchid\Screen\Actions\Menu;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return ItemMenu[]
     */
    public function registerMainMenu(): array
    {
        return [

            Menu::make('Дизайн')
                ->icon('brush')
                ->title('Disign')
                //->canSee(Auth::user()->hasAccess('platform.design.list'))
                ->route('platform.design.list'),

            Menu::make('Ремонт')
                ->icon('wrench')
                ->canSee(Auth::user()->hasAccess('platform.repair.list'))
                ->route('platform.repair.list'),

            Menu::make('Сметы')
                ->icon('drawer')
                ->canSee(Auth::user()->hasAccess('platform.estimate.list'))
                ->route('platform.estimate.list'),


            Menu::make('Пользователи')
                ->slug('user-menu')
                ->icon('user')
                ->canSee(Auth::user()->hasAccess('platform.clients.list') OR Auth::user()->hasAccess('platform.users.list'))
                ->list([
                    Menu::make('Пользователи системы')
                        ->route('platform.systems.users')
                        ->canSee(Auth::user()->hasAccess('platform.users.list'))
                        ->icon('bag'),
                    Menu::make('Клиенты')
                        ->route('platform.client.list')
                        ->canSee(Auth::user()->hasAccess('platform.clients.list'))
                        ->icon('heart'),
                ]),

            Menu::make('Материалы')
                ->slug('materials-menu')
                ->icon('user')
                ->canSee(Auth::user()->hasAccess('platform.norms.list') OR Auth::user()->hasAccess('platform.suppliers.list'))
                ->list([
                    Menu::make('Поставщики')
                        ->route('platform.suppliers.list')
                        ->canSee(Auth::user()->hasAccess('platform.norms.list'))
                        ->icon('bag'),
                    Menu::make('Нормы списания')
                        ->route('platform.norms.list')
                        ->canSee(Auth::user()->hasAccess('platform.suppliers.list'))
                        ->icon('heart'),
                ]),

            Menu::make('Документы')
                ->slug('docs-menu')
                ->canSee(Auth::user()->hasAccess('platform.templates.list') OR Auth::user()->hasAccess('platform.docs.list'))
                ->icon('new-doc')
                ->list([
                    Menu::make('Шаблоны документов')
                        ->route('platform.documentsTemplate.list')
                        ->canSee(Auth::user()->hasAccess('platform.templates.list'))
                        ->icon('doc'),
                    Menu::make('Документы')
                        ->route('platform.documents.list')
                        ->icon('doc')
                        ->canSee(Auth::user()->hasAccess('platform.docs.list'))
                        ->badge(function () {
                            $docs = Document::where('status', 'created')->count();
                            return $docs;
                        }),
                ]),

            Menu::make('Прайс-листы')
                ->slug('price-menu')
                ->canSee(Auth::user()->hasAccess('platform.price_list.list') OR Auth::user()->hasAccess('platform.repair_price_list.list'))
                ->icon('money')
                ->list([
                    Menu::make('Прайс-листы')
                        ->route('platform.price.list')
                        ->canSee(Auth::user()->hasAccess('platform.price_list.list'))
                        ->icon('bag'),
                    Menu::make('Прайс-лист Ремонт')
                        ->route('platform.repPrice.list')
                        ->canSee(Auth::user()->hasAccess('platform.repair_price_list.list'))
                        ->icon('heart'),
                ]),

            Menu::make('Личный кабинет')
                ->slug('lc-menu')
                ->canSee(Auth::user()->hasAccess('platform.price_list.list') OR Auth::user()->hasAccess('platform.repair_price_list.list'))
                ->icon('number-list')
                ->list([
                    Menu::make('Обо мне')
                        ->route('platform.lc.about')
                        ->canSee(Auth::user()->hasAccess('platform.price_list.list'))
                        ->icon('bag'),
                    Menu::make('Документы на подпись')
                        ->route('platform.lc.projects')
                        ->canSee(Auth::user()->hasAccess('platform.price_list.list'))
                        ->icon('bag'),
                ]),


        ];
    }


    /**
     * @return ItemMenu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemMenu[]
     */
    public function registerSystemMenu(): array
    {
        return [
            Menu::make(__('Access rights'))
                ->icon('lock')
                ->slug('Auth')
                ->active('platform.systems.*')
                ->permission('platform.systems.index')
                ->sort(2),

            Menu::make(__('Users'))
                ->place('Auth')
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->sort(2)
                ->title(__('All registered users')),

            Menu::make(__('Roles'))
                ->place('Auth')
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->sort(2)
                ->title(__('A Role defines a set of tasks a user assigned the role is allowed to perform.')),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('Systems'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('Design'))
                ->addPermission('platform.design.list', __('Дизайн список'))
                ->addPermission('platform.design.edit', __('Дизайн редактирование')),
            ItemPermission::group(__('Repair'))
                ->addPermission('platform.repair.list', __('Ремонт список'))
                ->addPermission('platform.repair.edit', __('Ремонт редактирование')),
            ItemPermission::group(__('Estimate'))
                ->addPermission('platform.estimate.list', __('Сметы список'))
                ->addPermission('platform.estimate.edit', __('Сметы редактирование')),
            ItemPermission::group(__('Users'))
                ->addPermission('platform.users.list', __('Пользователи список'))
                ->addPermission('platform.users.edit', __('Пользователи редактоирвание'))
                ->addPermission('platform.clients.list', __('Клиенты список'))
                ->addPermission('platform.clients.edit', __('Клиенты редактирование')),
            ItemPermission::group(__('Materials'))
                ->addPermission('platform.norms.list', __('Нормы списания список'))
                ->addPermission('platform.norms.edit', __('Нормы списания редактирование'))
                ->addPermission('platform.suppliers.list', __('Поставщики список'))
                ->addPermission('platform.suppliers.edit', __('Поставщики редактирование')),
            ItemPermission::group(__('Docs'))
                ->addPermission('platform.templates.list', __('Шаблоны список'))
                ->addPermission('platform.templates.edit', __('Шаблоны редактирование'))
                ->addPermission('platform.docs.list', __('Документы список'))
                ->addPermission('platform.docs.edit', __('Документы редактирование')),
            ItemPermission::group(__('Prices'))
                ->addPermission('platform.price_list.list', __('Прайс-листы список'))
                ->addPermission('platform.price_list.edit', __('Прайс-листы редактирование'))
                ->addPermission('platform.repair_price_list.list', __('Прайс-лист ремонт список'))
                ->addPermission('platform.repair_price_list.edit', __('Прайс-лист ремонт редактирование')),
        ];
    }

    /**
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [
//             \App\Models\User::class
        ];
    }
}
