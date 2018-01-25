<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Hash;
use Input;

class EmployeeController extends AdminController
{
    use RegistersUsers;

    protected $redirectTo = '/authority/dashboard';

    public function __construct()
    {
        $this->section = 'Employees';
        parent::__construct();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admin_users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function initContentCreate($id = null)
    {
        $admin_user = $this->context->admin_user;
        if ($id) {
          $admin_user = $this->context->admin_user->find($id);
        }

        $this->page['action_links'][] = [
          'text' => 'Employees',
          'slug' => 'employee/list',
          'icon' => '<i class="la la-mail-reply"></i>',
        ];

        $this->page['head'] = 'Employee Create';

        $this->assign = [
          'id' => $id,
          'admin_user' => $admin_user
        ];

        return $this->template('employee/create');
    }

    protected function create(array $data)
    {
        return $this->context->admin_user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->context->core->validateFields();
        $password = Hash::make(Input::get('password'));

        $admin_user = $this->context->admin_user;
        if ($id) {
          $admin_user = $this->context->admin_user->find($id);

          if (Input::get('password')) {
            $password = Hash::make(Input::get('password'));
          } else {
            $password = $admin_user->password;
          }
        }

        $au = $this->context->admin_user
        ->where('email', $data->email)
        ->first();

        if (count($au)) {
          return json('error', 'Email id is already register');
        }

        $admin_user->fill([
          'name' => $data->name,
          'email' => $data->email,
          'mobile' => ps($data->mobile),
          'password' => $password,
        ]);
        $admin_user->save();

        if ($id) {
          return json('success', 'Employee updated');
        }
        return json('redirect', AdminURL('employee/edit/' . $admin_user->id));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function initListing()
    {
        $this->page['head'] = 'Employee List';

        $this->page['action_links'][] = [
          'text' => 'Add Employee',
          'slug' => 'employee/create',
          'icon' => '<i class="la la-plus"></i>'
        ];

        $employees = $this->context->getAdminUser()->paginate(15);

        $data = [
          'employees' => $employees
        ];

        return $this->template('employee/list', $data);
    }
}
