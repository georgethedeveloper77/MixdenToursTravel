<?php

namespace Modules\Vendor;

use Modules\ModuleServiceProvider;
use Modules\Vendor\Models\VendorPayout;

class ModuleProvider extends ModuleServiceProvider
{

    public static function getAdminMenu()
    {
        $count = VendorPayout::countInitial();
        return [
            'payout' => [
                "position" => 70,
                'url' => route('vendor.admin.payout.index'),
                'title' => __("Payouts :count", ['count' => $count ? sprintf('<span class="badge badge-warning">%d</span>', $count) : '']),
                'icon' => 'icon ion-md-card',
                'permission' => 'user_create',
            ]
        ];
    }

    public static function getTemplateBlocks()
    {
        return [
            'vendor_register_form' => "\\Modules\\Vendor\\Blocks\\VendorRegisterForm",
            'vendor_list' => "\\Modules\\Vendor\\Blocks\\ListVendor",
        ];
    }

    public static function getUserMenu()
    {
        $res = [];
        $res['booking_report'] = [
            'url' => route('vendor.bookingReport'),
            'title' => __("Booking Report"),
            'icon' => 'icon ion-ios-pie',
            'position' => 35,
            'permission' => 'dashboard_vendor_access',
        ];
        if (!setting_item('disable_payout')) {
            $res['payout'] = [
                'url' => route('vendor.payout.index'),
                'title' => __("Payouts"),
                'icon' => 'icon ion-md-card',
                'position' => 38,
                'permission' => 'dashboard_vendor_access',
            ];
        }
        return $res;
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }
}
