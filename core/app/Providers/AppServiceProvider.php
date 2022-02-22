<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Escrow;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $activeTemplate = activeTemplate();
        $general = Cache::get('GeneralSetting');
        if (!$general) {
            $general = GeneralSetting::first();/// call from DB
            Cache::put('GeneralSetting', $general);
        }
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('is_default',0)->get();
        view()->share($viewShare);

        $actionRequire = [
                'banned_users_count' => User::banned()->count(),
                'email_unverified_users_count' => User::emailUnverified()->count(),
                'sms_unverified_users_count'   => User::smsUnverified()->count(),
                'pending_ticket_count'         => SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count'       => Deposit::pending()->count(),
                'pending_withdraw_count'       => Withdrawal::pending()->count(),
                'disputed_escrow'              => Escrow::where('status',8)->count(),
            ];

        view()->composer(['admin.partials.sidenav','admin.partials.tabnav'], function ($view) use ($actionRequire) {
            $view->with([
                'actionRequire'=>$actionRequire
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if($general->force_ssl){
            \URL::forceScheme('https');
        }


        Paginator::useBootstrap();

        $actionRequire = json_encode($actionRequire);

        Blade::directive('tsknav', function ($tabKey) use ($actionRequire) {

            $str = "<?php \$__env->startPush('tsknav'); ?>";
            $str .= "<?php echo view('admin.partials.tabnav',['tabKey'=>$tabKey]); ?>";
            $str .= "<?php \$__env->stopPush(); ?>";
            $str .= "<?php \$__env->startPush('script'); ?>";
            $str .= "<script> $('.breadcum-nav-open').removeClass('d-none') </script>";
            $str .= "<?php \$__env->stopPush(); ?>";

            return $str;
        });

    }
}
