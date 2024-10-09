<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field('name')->validationRules('required|min:5');
        CRUD::field('email')->validationRules('required|email|unique:users,email');
        CRUD::field('password')->validationRules('required');
       // if you are using Laravel 10+ your User model should already include the password hashing in the model casts.
        // if that's the case, you can skip this step. You can check your model $casts property or `casts()` method.
        \App\Models\User::creating(function ($entry) {
            $entry->password = \Hash::make($entry->password);
        });
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::field('name')->validationRules('required|min:5');
        CRUD::field('email')->validationRules('required|email|unique:users,email,'.CRUD::getCurrentEntryId());
        CRUD::field('password')->hint('Type a password to change it.');

        // if you are using Laravel 10+ your User model should already include the password hashing in the model casts.
                      // if that's the case, you just need to keep the old password unchanged when the user is updated.
                      \App\Models\User::updating(function ($entry) {
                          if (request('password') == null) {
                            $entry->password = $entry->getOriginal('password');
                          }
                      });

                      // in case you are using an older version of Laravel, or you are not casting your password in the model, you need
                      // to manually hash the password when it's updated by the user
                      \App\Models\User::updating(function ($entry) {
                        if (request('password') == null) {
                            $entry->password = $entry->getOriginal('password');
                        } else {
                            $entry->password = \Hash::make(request('password'));
                        }
        });
    }
}
