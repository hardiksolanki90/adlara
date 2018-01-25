<!DOCTYPE html>
<!--
   Template Name: Itinnovator - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
   Version: 1.0
   Author: Hardiksolanki
   Website: https://www.itinnovator.co/
   -->
<html lang="{{ config('app.locale') }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" href="{{ url('storage/media/favicon.ico') }}">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ $page_title }} - Admin</title>
      <meta name="description" content="Latest updates and statistic charts">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!--begin::Web font -->
      <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
      <script>
         var CSRF = '{{ csrf_token() }}';
         var csrfToke = '{{ csrf_token() }}';
         WebFont.load({
             google: {
                 "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
             },
             active: function() {
                 sessionStorage.fonts = true;
             }
         });
      </script>
      <!--end::Web font -->
      <!--begin::Base Styles -->
      <!--begin::Page Vendors -->
      <!-- Styles -->
      @foreach ($css_files as $css)
        <link href="{{ $css }}" rel="stylesheet">
      @endforeach
      <!--end::Base Styles -->
      <link rel="shortcut icon" href="assets/demo/default/media/img/logo/favicon.ico" />
   </head>
   @include('templates/media/modal-library')
   @include('templates/media/modal-media')
   <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
      <!-- begin:: Page -->
      <div class="m-grid m-grid--hor m-grid--root m-page">
         <!-- BEGIN: Header -->
         <header class="m-grid__item    m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
            <div class="m-container m-container--fluid m-container--full-height">
               <div class="m-stack m-stack--ver m-stack--desktop">
                  <!-- BEGIN: Brand -->
                  <div class="m-stack__item m-brand  m-brand--skin-dark ">
                     <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                           <a href="{{ AdminURL('dashboard') }}" class="m-brand__logo-wrapper">
                           <img alt="" src="{{ url('storage/media/image/logo_default_dark.png') }}" />
                           </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                           <!-- BEGIN: Left Aside Minimize Toggle -->
                           <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block
                              ">
                           <span></span>
                           </a>
                           <!-- END -->
                           <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                           <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                           <span></span>
                           </a>
                           <!-- END -->
                           <!-- BEGIN: Topbar Toggler -->
                           <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                           <i class="flaticon-more"></i>
                           </a>
                           <!-- BEGIN: Topbar Toggler -->
                        </div>
                     </div>
                  </div>
                  <!-- END: Brand -->
                  <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                     <!-- BEGIN: Horizontal Menu -->
                     <div id="m_header_menu" class="m-header-menu m-header-menu--skin-light m-header-menu--submenu-skin-light ">
                       <div class=" m-portlet__head-title">
                          <h2 class="h-portlet__head-text">{{ $section }}</h2>
                       </div>
                     </div>
                     <!-- END: Horizontal Menu -->
                     <!-- BEGIN: Topbar -->
                     <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                           <ul class="m-topbar__nav m-nav m-nav--inline">
                              <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" data-dropdown-toggle="click" data-dropdown-persistent="true">
                                 <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                 <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                                 <span class="m-nav__link-icon">
                                 <i class="flaticon-music-2"></i>
                                 </span>
                                 </a>
                                 <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center _hNotify"></span>
                                    <div class="m-dropdown__inner">
                                       <div class="m-dropdown__header m--align-center" style="background: url(../../storage/media/image/notification_bg.jpg); background-size: cover;">
                                          <span class="m-dropdown__header-title">
                                          9 New
                                          </span>
                                          <span class="m-dropdown__header-subtitle">
                                          User Notifications
                                          </span>
                                       </div>
                                       <div class="m-dropdown__body">
                                          <div class="m-dropdown__content">
                                             <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                   <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                                   Alerts
                                                   </a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                   <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab">
                                                   Events
                                                   </a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                   <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
                                                   Logs
                                                   </a>
                                                </li>
                                             </ul>
                                             <div class="tab-content">
                                                <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                                   <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                      <div class="m-list-timeline m-list-timeline--skin-light">
                                                         <div class="m-list-timeline__items">
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                               <span class="m-list-timeline__text">
                                                               12 new users registered
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               Just now
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span class="m-list-timeline__text">
                                                               System shutdown
                                                               <span class="m-badge m-badge--success m-badge--wide">
                                                               pending
                                                               </span>
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               14 mins
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span class="m-list-timeline__text">
                                                               New invoice received
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               20 mins
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span class="m-list-timeline__text">
                                                               DB overloaded 80%
                                                               <span class="m-badge m-badge--info m-badge--wide">
                                                               settled
                                                               </span>
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               1 hr
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span class="m-list-timeline__text">
                                                               System error -
                                                               <a href="#" class="m-link">
                                                               Check
                                                               </a>
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               2 hrs
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item m-list-timeline__item--read">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span href="" class="m-list-timeline__text">
                                                               New order received
                                                               <span class="m-badge m-badge--danger m-badge--wide">
                                                               urgent
                                                               </span>
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               7 hrs
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item m-list-timeline__item--read">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span class="m-list-timeline__text">
                                                               Production server down
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               3 hrs
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge"></span>
                                                               <span class="m-list-timeline__text">
                                                               Production server up
                                                               </span>
                                                               <span class="m-list-timeline__time">
                                                               5 hrs
                                                               </span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
                                                   <div class="m-scrollable" m-scrollabledata-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                      <div class="m-list-timeline m-list-timeline--skin-light">
                                                         <div class="m-list-timeline__items">
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                               <a href="" class="m-list-timeline__text">
                                                               New order received
                                                               </a>
                                                               <span class="m-list-timeline__time">
                                                               Just now
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
                                                               <a href="" class="m-list-timeline__text">
                                                               New invoice received
                                                               </a>
                                                               <span class="m-list-timeline__time">
                                                               20 mins
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                               <a href="" class="m-list-timeline__text">
                                                               Production server up
                                                               </a>
                                                               <span class="m-list-timeline__time">
                                                               5 hrs
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                               <a href="" class="m-list-timeline__text">
                                                               New order received
                                                               </a>
                                                               <span class="m-list-timeline__time">
                                                               7 hrs
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                               <a href="" class="m-list-timeline__text">
                                                               System shutdown
                                                               </a>
                                                               <span class="m-list-timeline__time">
                                                               11 mins
                                                               </span>
                                                            </div>
                                                            <div class="m-list-timeline__item">
                                                               <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                               <a href="" class="m-list-timeline__text">
                                                               Production server down
                                                               </a>
                                                               <span class="m-list-timeline__time">
                                                               3 hrs
                                                               </span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                                   <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                                      <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                         <span class="">
                                                         All caught up!
                                                         <br>
                                                         No new logs.
                                                         </span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                 <a href="#" class="m-nav__link m-dropdown__toggle">
                                 <span class="m-topbar__userpic">
                                 <img src="{{ url('storage/media/image/user5.jpg') }}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                 </span>
                                 <span class="m-topbar__username m--hide">
                                 Nick
                                 </span>
                                 </a>
                                 <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                       <div class="m-dropdown__header m--align-center" style="background: url(../../storage/media/image/user_profile_bg.jpg); background-size: cover;">
                                          <div class="m-card-user m-card-user--skin-dark">
                                             <div class="m-card-user__pic">
                                                <img src="{{ url('storage/media/image/user5.jpg') }}" class="m--img-rounded m--marginless" alt="" />
                                             </div>
                                             <div class="m-card-user__details">
                                                <span class="m-card-user__name m--font-weight-500">
                                                Mark Andre
                                                </span>
                                                <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                mark.andre@gmail.com
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="m-dropdown__body">
                                          <div class="m-dropdown__content">
                                             <ul class="m-nav m-nav--skin-light">
                                                <li class="m-nav__section m--hide">
                                                   <span class="m-nav__section-text">
                                                   Section
                                                   </span>
                                                </li>
                                                <li class="m-nav__item">
                                                   <a href="header/profile.html" class="m-nav__link">
                                                   <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                   <span class="m-nav__link-title">
                                                     <span class="m-nav__link-wrap">
                                                       <span class="m-nav__link-text">
                                                       My Profile
                                                       </span>
                                                     </span>
                                                   </span>
                                                   </a>
                                                </li>
                                                <li class="m-nav__item">
                                                   <a href="header/profile.html" class="m-nav__link">
                                                   <i class="m-nav__link-icon flaticon-share"></i>
                                                   <span class="m-nav__link-text">
                                                   Activity
                                                   </span>
                                                   </a>
                                                </li>
                                                <li class="m-nav__item">
                                                   <a href="header/profile.html" class="m-nav__link">
                                                   <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                   <span class="m-nav__link-text">
                                                   Messages
                                                   </span>
                                                   </a>
                                                </li>
                                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                                <li class="m-nav__item">
                                                   <a href="{{ AdminURL('logout') }}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                   Logout
                                                   </a>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <!-- END: Topbar -->
                  </div>
               </div>
            </div>
         </header>
         <!-- END: Header -->
         <!-- begin::Body -->
         <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <!-- BEGIN: Left Aside -->
            <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
            </button>
            <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
               <!-- BEGIN: Aside Menu -->
               <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
                  <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                     <li class="m-menu__item" aria-haspopup="true">
                        <a href="{{ AdminURL('dashboard') }}" class="m-menu__link ">
                        <i class="m-menu__link-icon flaticon-line-graph"></i>
                        <span class="m-menu__link-title">
                          <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                              Dashboard
                            </span>
                          </span>
                        </span>
                        </a>
                     </li>
                     @if (count($sidebar_menu))
                       @foreach ($sidebar_menu as $k => $menu)
                          @if ($menu['head'])
                             <li class="m-menu__section">
                                <h4 class="m-menu__section-text">
                                   {{ $menu['head'] }}
                                </h4>
                                <i class="m-menu__section-icon flaticon-more-v3"></i>
                             </li>
                          @endif
                          @foreach ($menu['menu'] as $key => $m)
                             <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
                                <a href="#" class="m-menu__link m-menu__toggle">
                                    @if (isset($m['icon']))
                                      {!! $m['icon'] !!}
                                    @else
                                      <i class="m-menu__link-icon flaticon-layers"></i>
                                    @endif
                                    <span class="m-menu__link-text">
                                       {{ $m['text'] }}
                                    </span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="m-menu__submenu ">
                                    <span class="m-menu__arrow"></span>
                                    @if (count($m['child']))
                                      <ul class="m-menu__subnav">
                                          <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                           <span class="m-menu__link">
                                             <span class="m-menu__link-text">
                                             {{ $m['text'] }}
                                             </span>
                                           </span>
                                        </li>
                                          @foreach ($m['child'] as $child)
                                            <li class="m-menu__item " aria-haspopup="true">
                                               <a href="{{ AdminURL($child['slug']) }}" class="m-menu__link ">
                                               <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                               <span></span>
                                               </i>
                                               <span class="m-menu__link-text">
                                               {{ $child['text'] }}
                                               </span>
                                               </a>
                                            </li>
                                          @endforeach
                                        </ul>
                                    @endif
                                </div>
                              </li>
                          @endforeach
                        @endforeach
                      @endif
                    </ul>
               </div>
               <!-- END: Aside Menu -->
            </div>
            <!-- END: Left Aside -->
            <div class="m-grid__item m-grid__item--fluid">
               <div class="m-content">
                     @yield('content')
               </div>
            </div>
         </div>
         <!-- end:: Body -->
      </div>
      <!-- end:: Page -->
      <!-- begin::Scroll Top -->
      <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
         <i class="la la-arrow-up"></i>
      </div>
      @foreach ($js_files as $js)
          <script src="{{ $js }}"></script>
      @endforeach
      <!--end::Page Snippets -->
   </body>
   <!-- end::Body -->
</html>
