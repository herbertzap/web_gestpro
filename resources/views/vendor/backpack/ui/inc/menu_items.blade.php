{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="usuarios" icon="la la-group">
    <x-backpack::menu-dropdown-item title="Users" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>


<x-backpack::menu-dropdown title="Productos" icon="la la-group">
    <x-backpack::menu-dropdown-item title="product" icon="la la-user" :link="backpack_url('product')" />
    <x-backpack::menu-dropdown-item title="Categories" icon="la la-group" :link="backpack_url('category')" />
    <x-backpack::menu-dropdown-item title="Crear Producto" icon="la la-plus" :link="backpack_url('product/create')" />
</x-backpack::menu-dropdown>