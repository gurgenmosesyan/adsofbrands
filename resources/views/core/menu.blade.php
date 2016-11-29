<?php

$isAdmin = false;
$isSuperAdmin = false;
if (Auth::guard('admin')->check()) {
    $isAdmin = true;
    $admin = Auth::guard('admin')->user();
    $isSuperAdmin = $admin->isSuperAdmin();
    $permissions = $admin->permissions;
} else if (Auth::guard('creative')->check()) {
    $permissions = [
        'profile' => 1,
        'commercial' => 1,
        'award' => 1
    ];
} else {
    $permissions = [
        'profile' => 1,
        'commercial' => 1,
        'creative' => 1,
        'award' => 1,
        'vacancy' => 1,
        'branch' => 1

    ];
}

$menu = require resource_path('admin_menu/app.php');
$coreMenu = require resource_path('admin_menu/core.php');

$menu = array_merge($menu, $coreMenu);

echo '<ul class="sidebar-menu">';

if (Auth::guard('admin')->guest()) {
    if (Auth::guard('brand')->check()) {
        $brand = Auth::guard('brand')->user();
        $profileLink = route('admin_brand_edit', $brand->id);
        $class = $pageMenu == 'brand' ? ' class="active"' : '';
    } else if (Auth::guard('agency')->check()) {
        $agency = Auth::guard('agency')->user();
        $profileLink = route('admin_agency_edit', $agency->id);
        $class = $pageMenu == 'agency' ? ' class="active"' : '';
    } else {
        $creative = Auth::guard('creative')->user();
        $profileLink = route('admin_creative_edit', $creative->id);
        $class = $pageMenu == 'creative' ? ' class="active"' : '';
    }
    echo '<li'.$class.'><a href="'.$profileLink.'"><i class="fa fa-user"></i> <span>'.trans('admin.profile.form.title').'</span></a></li>';
}

foreach($menu as $value) {
    if (empty($value['sub_menu'])) {
        if ($isSuperAdmin || isset($permissions[$value['key']])) {
            $class = $pageMenu == $value['key'] ? ' class="active"' : '';
            echo '<li'.$class.'><a href="'.$value['path'].'"><i class="fa '.$value['icon'].'"></i> <span>'.trans('admin.'.$value['key'].'.form.title').'</span></a></li>';
        }
    } else {
        $class = '';
        $show = false;
        foreach ($value['sub_menu'] as $sub) {
            if ($pageMenu == $sub['key']) {
                $class = ' active';
            }
            if ($isSuperAdmin || isset($permissions[$sub['key']])) {
                $show = true;
            }
        }
        if ($show) {
            echo '<li class="treeview'.$class.'">';
            echo '<a href="#"><i class="fa '.$value['icon'].'"></i> <span>'.trans('admin.'.$value['key'].'.form.title').'</span> <i class="fa fa-angle-left pull-right"></i></a>';
            echo '<ul class="treeview-menu">';
            foreach ($value['sub_menu'] as $sub) {
                if ($isSuperAdmin || isset($permissions[$sub['key']])) {
                    $class = $pageMenu == $sub['key'] ? ' class="active"' : '';
                    echo '<li'.$class.'><a href="'.$sub['path'].'"><i class="fa '.$sub['icon'].'"></i> '.trans('admin.'.$sub['key'].'.form.title').'</a></li>';
                }
            }
            echo '</ul>';
            echo '</li>';
        }
    }
}

echo '</ul>';