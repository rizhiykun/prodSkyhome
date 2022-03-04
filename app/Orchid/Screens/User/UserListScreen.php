<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\User;
use App\Orchid\Layouts\CreateOrUpdateUser;
use App\Orchid\Layouts\User\UserFiltersLayout;
use App\Orchid\Layouts\User\UserListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;


class UserListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Пользователи';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Все зарегистрированные пользователи';

    /**
     * @var string
     */
    public $permission = ['platform.systems.users', 'platform.users.list'];

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Client $client): array
    {
        $this->exists = $client->exists;
        if($this->exists){
            $this->name = 'Редактировать';
        }
        return [
            'client' => $client,
            'users' => User::with('roles')
                ->filters()
                ->filtersApplySelection(UserFiltersLayout::class)
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            ModalToggle::make(__('Создать пользователя'))
                ->icon('user-follow')
                ->modal('newUser')
                ->method('createOrUpdateClient'),

        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [


            UserFiltersLayout::class,
            UserListLayout::class,

            Layout::modal('newUser', CreateOrUpdateUser::class)->title('Создать пользователя')->applyButton('Создать'),
        ];
    }

    /**
     * @param User $user
     *
     * @return array
     */


    public function createOrUpdateClient(User $user, Request $request)
{
    $user->fill($request->get('user'))->save();

    Toast::info(__('Пользователь создан
    '));
    return redirect()->route('platform.systems.users');
}
    /**
     * @param User    $user
     * @param Request $request
     */


    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        User::findOrFail($request->get('id'))
            ->delete();
        Toast::info(__('User was removed'));
    }
}
