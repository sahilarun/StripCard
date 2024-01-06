<div class="left">
    <div class="icon">
        <button class="sidebar-menu-bar">
            <i class="fas fa-exchange-alt"></i>
        </button>
    </div>
    <div class="content">
        <h3 class="title">{{ $title }}</h3>
        <p>{{ (isset($sub_title)) ? $sub_title : __("Welcome To") . " " . $basic_settings->site_name . " " . "Admin Panel" }}</p>
    </div>
</div>