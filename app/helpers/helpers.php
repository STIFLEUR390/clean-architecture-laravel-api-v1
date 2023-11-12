<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

if (! function_exists('transformArrayForSelect')) {
    function transformArrayForSelect($arrays)
    {
        $my_array_values = array_values($arrays);
        $my_array_reversed = [];

        foreach ($my_array_values as $value) {
            $my_array_reversed[$value] = $value;
        }

        return $my_array_reversed;
    }
}
if (! function_exists('parseUrl')) {
    function parseUrl($url): string
    {
        return (filter_var($url, FILTER_VALIDATE_URL)) ? $url : asset($url);
    }
}

/*
if (! function_exists('isRole')) {
    function isRole($role): bool
    {
        return Auth::user()->hasAnyRole(explode('|', $role));
    }
}

if (! function_exists('isPermission')) {
    function isPermission($permission): bool
    {
        return Auth::user()->hasAnyPermission($permission);
    }
}

if (! function_exists('hasRoleOrPermission')) {
    function hasRoleOrPermission($permission): bool
    {
        // return Auth::user()->hasAnyPermission($permission) || Auth::user()->hasAnyRole($permission);
        return Auth::user()->hasAnyPermission($permission) || Auth::user()->hasAnyRole($permission);
    }
} */

/* if (! function_exists('showDateDiff')) {
    function showDateDiff($start, $end = null, string $suffix = ''): void
    {
        if (! empty($end)) {
            $diff = $end->shortAbsoluteDiffForHumans($start);
            echo $diff.' '.__(trim($suffix));
        } else {
            echo $end->shortAbsoluteDiffForHumans();
        }
    }
} */

/* if (! function_exists('priceFormat')) {
    function priceFormat($price): bool|string
    {
        $gdpf = getDataForPriceFormat();
        $devise = $gdpf['devise'];
        $local = empty($gdpf['local']) ? config('app.faker_locale') : $gdpf['local'];
        $fmt = new NumberFormatter($local, NumberFormatter::CURRENCY);

        return $fmt->formatCurrency($price, $devise);
    }
}

if (! function_exists('priceFormatGuest')) {
    function priceFormatGuest($price, $devise = 'XAF', $local = 'fr_FR'): bool|string
    {
        $fmt = new NumberFormatter($local, NumberFormatter::CURRENCY);

        return $fmt->formatCurrency($price, $devise);
    }
} */

if (! function_exists('phoneFormat')) {
    function phoneFormat($phone, $country = 'CM'): string
    {
        return (string) new \Propaganistas\LaravelPhone\PhoneNumber($phone, [$country]);
    }
}

if (! function_exists('exception_image')) {
    function exception_image(): array
    {
        return [
            'logo/logo_32x32.ico,',
            'logo/logo.png,',
            'logo/logo.svg,',
            'logo/short_logo_32x32.ico,',
            'logo/short_logo.png,',
            'logo/short_logo.svg,',
            '',
        ];
    }
}

if (! function_exists('parcourirRepertoire')) {
    function parcourirRepertoire($chemin, $extension, $sous_dossiers = true): array
    {
        $fichiers = [];
        $dir = opendir($chemin);
        while ($fichier = readdir($dir)) {
            if ($fichier != '.' && $fichier != '..') {
                $chemin_fichier = $chemin.DIRECTORY_SEPARATOR.$fichier;
                if (is_dir($chemin_fichier) && $sous_dossiers) {
                    $fichiers = array_merge($fichiers, parcourirRepertoire($chemin_fichier, $extension));
                } elseif (pathinfo($chemin_fichier, PATHINFO_EXTENSION) == $extension) {
                    $fichiers[] = $chemin_fichier;
                }
            }
        }
        closedir($dir);

        return $fichiers;
    }
}

if (! function_exists('countNotificationType')) {
    function countNotificationType($notifiable_type): int
    {
        return DB::table('notifications')->where('type', $notifiable_type)->count();
    }
}

if (! function_exists('getNotificationType')) {
    function getNotificationType($notifiable_type): Illuminate\Support\Collection
    {
        return DB::table('notifications')->where('type', $notifiable_type)->get();
    }
}

if (! function_exists('countUnReadNotificationType')) {
    function countUnReadNotificationType($notifiable_type): int
    {
        return DB::table('notifications')->where('type', $notifiable_type)->whereNull('read_at')->count();
    }
}

if (! function_exists('getUnReaNotificationType')) {
    function getUnReaNotificationType($notifiable_type): Illuminate\Support\Collection
    {
        return DB::table('notifications')->where('type', $notifiable_type)->whereNull('read_at')->get();
    }
}

if (! function_exists('countMultiUnReadNotificationType')) {
    function countMultiUnReadNotificationType($notifiable_type): int
    {
        $user_id = Auth::user()->id;

        return DB::table('notifications')->whereIn('type', $notifiable_type)->where('notifiable_id', $user_id)->whereNull('read_at')->get()->count();
    }
}

if (! function_exists('getMultiUnReaNotificationType')) {
    function getMultiUnReaNotificationType($notifiable_type): Illuminate\Support\Collection
    {
        $user_id = Auth::user()->id;

        return DB::table('notifications')->whereIn('type', $notifiable_type)->where('notifiable_id', $user_id)->whereNull('read_at')->latest()->get();
    }
}

if (! function_exists('isNew')) {
    function isNew($date): bool
    {
        $now = Carbon::now();
        $compare_date = Carbon::parse($date);
        $diff = $now->diffInDays($compare_date);

        return $diff <= 7;
    }
}

function retirerEspaceExplode($datas): array
{
    $new_data = explode(',', $datas);
    foreach ($new_data as $key => $value) {
        $new_data[$key] = trim($value);
    }

    return $new_data;
}

if (! function_exists('datatableParseDate')) {
    function datatableParseDate($date): string
    {
        // $locale = config('app.locale') == 'fr' ? 'fr_FR' : 'en_US';
        $locale = config('app.locale');

        return Carbon::parse($date)->locale($locale)->isoFormat('DD MMM YYYY');
    }
}

if (! function_exists('defaultTimezone')) {
    function defaultTimezone()
    {
        return config('app.timezone');
    }
}

if (! function_exists('datatableParseDateAndTimeZone')) {
    function datatableParseDateAndTimeZone($date): string
    {
        // $locale = config('app.locale') == 'fr' ? 'fr_FR' : 'en_US';
        $locale = config('app.locale');
        $default_timezone = config('app.timezone');
        $cart = Carbon::parse($date->format('Y-m-d H:i:s'), $default_timezone)->tz(geoip(request()->ip())->timezone)->locale($locale);
        $new_date = $cart->isoFormat('DD MMM YYYY');
        $heure = $cart->format('H:i');

        return $new_date.' à '.$heure;
    }
}

if (! function_exists('datatableParseDateAndTimeZoneTwo')) {
    function datatableParseDateAndTimeZoneTwo($date): string
    {
        // $locale = config('app.locale') == 'fr' ? 'fr_FR' : 'en_US';
        $locale = config('app.locale');
        $default_timezone = config('app.timezone');
        $cart = Carbon::parse($date, $default_timezone)->tz(geoip(request()->ip())->timezone)->locale($locale);
        $new_date = $cart->isoFormat('DD MMM YYYY');
        $heure = $cart->format('H:i');

        return $new_date.' à '.$heure;
    }
}

if (! function_exists('formatDateToUTC')) {
    function formatDateToUTC($date): Carbon|string
    {
        $default_timezone = config('app.timezone');

        return Carbon::parse($date, geoip(request()->ip())->timezone)->tz($default_timezone);
    }
}

if (! function_exists('getAuthorName')) {
    function getAuthorName(): string
    {
        return 'Dev Master';
    }
}

if (! function_exists('getAuthorAddresse')) {
    function getAuthorAddresse(): string
    {
        return 'Douala Cameroun';
    }
}

if (! function_exists('getAppEmail')) {
    function getAppEmail(): string
    {
        return 'heroldtamko39@gmail.com';
    }
}

if (! function_exists('getAppSupportEmail')) {
    function getAppSupportEmail(): string
    {
        return 'heroldtamko39@gmail.com';
    }
}

if (! function_exists('getAuthorwebsite')) {
    function getAuthorwebsite(): string
    {
        return 'javascript:void(0)';
    }
}

if (! function_exists('appDocs')) {
    function appDocs(): string
    {
        return 'javascript:void(0)';
    }
}

if (! function_exists('getAuthorEmail')) {
    function getAuthorEmail(): string
    {
        return 'heroldtamko39@gmail.com';
    }
}

if (! function_exists('getAuthorPhone')) {
    function getAuthorPhone(): string
    {
        return '+237697626397';
    }
}
