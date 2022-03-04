<?php

namespace App\Orchid\Layouts\Clients;

use App\Models\Client;
use App\Models\NormsList;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use phpDocumentor\Reflection\Types\String_;

class ClientListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'clients';
    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'ФИО')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Client $client) {
                    return Link::make($client->name)
                        ->route( ($client->inn) > 0 ? 'platform.client_ent.edit'  : 'platform.client_fiz.edit' , $client);
                }),
            TD::make('email', 'Email')->filter(TD::FILTER_TEXT),
            TD::make('phone', 'Телефон'),
            TD::make('birthdate', 'Дата рождения'),
            TD::make('dogDis', 'Договор дизайн')->filter(TD::FILTER_TEXT),
            TD::make('****', 'Смета')->defaultHidden(),
            TD::make('****', 'Договор подряда')->defaultHidden(),
            TD::make('****', 'Город')->defaultHidden(),
            TD::make('****', 'Менеджер')->defaultHidden(),
            TD::make('****', 'Дизайнер')->defaultHidden(),
            TD::make('****', 'Снабженец')->defaultHidden(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Client $client) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route(($client->inn) > 0 ? 'platform.client_ent.edit'  : 'platform.client_fiz.edit' , $client)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->method('remove')
                                ->confirm(__('Как только клиент будет удален, все его ресурсы и данные будут удалены безвозвратно. Перед удалением вашего клиента, пожалуйста, загрузите любые данные или информацию, которые вы хотите сохранить.'))
                                ->parameters([
                                    'id' => $client->id,
                                ]),
                        ]);
                }),


        ];
    }
}
