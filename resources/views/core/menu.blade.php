<ul class="sidebar-menu">
    <li{{$pageMenu == 'homepage' ? ' class=active' : ''}}><a href="{{route('admin_homepage')}}"><i class="fa fa-home"></i> <span>{{trans('admin.homepage.form.title')}}</span></a></li>
    <li{{$pageMenu == 'background' ? ' class=active' : ''}}><a href="{{route('admin_background')}}"><i class="fa fa-image"></i> <span>{{trans('admin.background.form.title')}}</span></a></li>
    <li{{$pageMenu == 'about' ? ' class=active' : ''}}><a href="{{route('admin_about')}}"><i class="fa fa-info-circle"></i> <span>{{trans('admin.about.form.title')}}</span></a></li>
    <li{{$pageMenu == 'guest' ? ' class=active' : ''}}><a href="{{route('admin_guest_table')}}"><i class="fa fa-user"></i> <span>{{trans('admin.guest.form.title')}}</span></a></li>
    <li{{$pageMenu == 'partner' ? ' class=active' : ''}}><a href="{{route('admin_partner_table')}}"><i class="fa fa-suitcase"></i> <span>{{trans('admin.partner.form.title')}}</span></a></li>
    <li{{$pageMenu == 'accommodation' ? ' class=active' : ''}}><a href="{{route('admin_accommodation_table')}}"><i class="fa fa-hotel"></i> <span>{{trans('admin.accommodation.form.title')}}</span></a></li>
    <li{{$pageMenu == 'reserved' ? ' class=active' : ''}}><a href="{{route('admin_reserved_table')}}"><i class="fa fa-lock"></i> <span>{{trans('admin.reserved.form.title')}}</span></a></li>
    <li{{$pageMenu == 'order' ? ' class=active' : ''}}><a href="{{route('admin_order_table')}}"><i class="fa fa-money"></i> <span>{{trans('admin.order.form.title')}}</span></a></li>
    <li class="treeview{{$pageMenu == 'offer' || $pageMenu == 'offer_text' || $pageMenu == 'offer_slider' ? ' active' : ''}}">
        <a href="#">
            <i class="fa fa-tags"></i> <span>{{trans('admin.offer.form.title')}}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li{{$pageMenu == 'offer_text' ? ' class=active' : ''}}><a href="{{route('admin_offer_text')}}"><i class="fa fa-file-text"></i> {{trans('admin.admin_menu.first_text')}}</a></li>
            <li{{$pageMenu == 'offer' ? ' class=active' : ''}}><a href="{{route('admin_offer_table')}}"><i class="fa fa-tags"></i> {{trans('admin.offer.form.title')}}</a></li>
            <li{{$pageMenu == 'offer_slider' ? ' class=active' : ''}}><a href="{{route('admin_offer_slider_table')}}"><i class="fa fa-image"></i> {{trans('admin.admin_menu.slider')}}</a></li>
        </ul>
    </li>
    <li class="treeview{{$pageMenu == 'facility' || $pageMenu == 'facility_slider' ? ' active' : ''}}">
        <a href="#">
            <i class="fa fa-tags"></i> <span>{{trans('admin.facility.form.title')}}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li{{$pageMenu == 'facility' ? ' class=active' : ''}}><a href="{{route('admin_facility_table')}}"><i class="fa fa-tags"></i> {{trans('admin.facility.form.title')}}</a></li>
            <li{{$pageMenu == 'facility_slider' ? ' class=active' : ''}}><a href="{{route('admin_facility_slider_table')}}"><i class="fa fa-image"></i> {{trans('admin.admin_menu.slider')}}</a></li>
        </ul>
    </li>
    <li class="treeview{{$pageMenu == 'event' || $pageMenu == 'event_text' || $pageMenu == 'event_slider' ? ' active' : ''}}">
        <a href="#">
            <i class="fa fa-tags"></i> <span>{{trans('admin.event.form.title')}}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li{{$pageMenu == 'event_text' ? ' class=active' : ''}}><a href="{{route('admin_event_text')}}"><i class="fa fa-file-text"></i> {{trans('admin.admin_menu.first_text')}}</a></li>
            <li{{$pageMenu == 'event' ? ' class=active' : ''}}><a href="{{route('admin_event_table')}}"><i class="fa fa-tags"></i> {{trans('admin.event.form.title')}}</a></li>
            <li{{$pageMenu == 'event_slider' ? ' class=active' : ''}}><a href="{{route('admin_event_slider_table')}}"><i class="fa fa-image"></i> {{trans('admin.admin_menu.slider')}}</a></li>
        </ul>
    </li>
    <li{{$pageMenu == 'vacancy' ? ' class=active' : ''}}><a href="{{route('admin_vacancy_table')}}"><i class="fa fa-cube"></i> <span>{{trans('admin.vacancy.form.title')}}</span></a></li>
    <li class="treeview{{$pageMenu == 'admin' || $pageMenu == 'language' || $pageMenu == 'dictionary' ? ' active' : ''}}">
        <a href="#">
            <i class="fa fa-wrench"></i> <span>{{trans('admin.admin_menu.system')}}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li{{$pageMenu == 'admin' ? ' class=active' : ''}}><a href="{{route('core_admin_table')}}"><i class="fa fa-user"></i> {{trans('admin.admin.form.title')}}</a></li>
            <li{{$pageMenu == 'language' ? ' class=active' : ''}}><a href="{{route('core_language_table')}}"><i class="fa fa-flag"></i> {{trans('admin.language.form.title')}}</a></li>
            <li{{$pageMenu == 'dictionary' ? ' class=active' : ''}}><a href="{{route('core_dictionary_table')}}"><i class="fa fa-book"></i> {{trans('admin.dictionary.form.title')}}</a></li>
        </ul>
    </li>
</ul>