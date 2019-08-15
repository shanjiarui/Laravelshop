<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class ZfbController extends Controller
{
    protected $config = [
        'alipay' => [
            'app_id' => '2016100100642211',
            'notify_url' => 'http://s6fewq.natappfree.cc/blog/public/api/notify',
            'return_url' => 'http://localhost/blog/public/api/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhJL4aTq1ItJUpsGAmB2MNKDkHlcFmX5rhZKQf6QU3TLuukYCTP5g/TMKhf4sKdpbZv5kjAD6YqKjTdIj+JnHtGUOb1sxCfRyHwdlvWNmzc9o39UGSPMGpSFuSH7vwaT0InNOm+VeVfnI6tZjneg35cHGzaEDeLsZdRhvjxiS+YI3Fb1A+UslPIpgn8Bq5+AOobu24iEpmfmXK3Q+3BYAIynBQiLezPr8rwnjGjg082S4K/kWMCm+nxlstHYYMsCRl158ulj5ysJZ7Lt1/LscVcro5kbCLyNFnxgeJwR+5NaIeb+qahzR/QgwaEnELOMV6eRvl7YzWmnh5qEML14xmwIDAQAB',
            'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC7vjtDpfsJ7BQJQpB/3ef4KbHrqpalzubm/F1qAT4zt679N0BB4c2ErhXDqywfpNxtOie5nND+/60Ssv+fFXTtWXjRkpu2WryAW9QuCMwGXy2lWncv/V33GO9HgWuv57toIlnUKilt0oGGa0So+whpf6SIMhBUNtRSGT+iCh0veLCKcoxLQ/Xy9GI2+kiyeSY0qKRgvMcU0tKjfVDqrSoRrsC4LLbUSNenjN3UX+5BSnVFke1ISjlG0LkTSKbVZbE2lOm+owFz0pxEfgG20oG5FPrtbJ1+epHCYJX3T+buVUDyOU2okhcAHBWxdINmipn8YUHLDmARgpAhBl7ucrSvAgMBAAECggEAAN+sxO7T0UMBAN4HcCDnQHdpNZCQrOreljqccK7azEDRlqoYKXZUj4aD4Wo9hVQuFnAL2UhKjLVB5/FfUS03YxdkgY0uHlYjxHEo9qHh2TG+M6PNJDMIqeq6yllm1+W7MIvgYSVlFfbB1Y9QPX0Vl/AZIu0guFOc/1jQu/9SDXN/SZvbh3ObxSYWorCvIj5pfR7DvkxpKosUBpluCjUPkCbad9fnmJAwELK3fyDAh7JBwfMokwVR+fF8Ggq3V7MZrNB6g9P8dz2qd+a39+LQFM6nUUHjBJmGonH7WNuzb5AqV8HGgS1efqMD/tcmDj/TdJa5yxnFa6aHgRVQnZNvYQKBgQDzT8GW3QNX7tVOQv8pfDosDgEcjZ97E/52DQA9Y07iow0f4FtFs69P3fcfbHoj5Z6LiBfWtaWa4/vLK+cqDfei230DBKDCnz7ZDfyhsaFzqlSfi1clO1FVmSuDkP5VtuwVL0l09rlygg+GDlAyKJZIK9z2PVJ+MuqWRodEOv+9/wKBgQDFiKDlOUIcHxliMqnacjh8pFfoS9nCY6rBlG1ue4hwYbEONlni4qt374nUW/AmT0KdL7K5QVCvyoX+P6owDLlIV5tm444rVbnG7wEQnUvw/92hH5qxxM2MwyEaFoplWVG/jR6hVna28/fi2mro1Evb9Uu9AsSteeoaEuJmVWZpUQKBgFzQh+Cs3qGkkeoQ1JVWtjon/XSO8c9ZiTAvNXA1edoqqM8IHskwCihFXAe4sb8P0LMZbz6QfGPhpCOU09HPEjAl2kJUeZ7EcI0MMNrdj+E3kKBr3wps3lHw5BCENwErjlNmfncHxyZPRuy0eRMpOGq/kMK+EcHiWmqI7QCyIOyxAoGASTS5bDosJf/giGP+TtbF2GuPqKdzrHcDcXpwk+F0TzHlTD8YUN1wbqJ3khwAhDIbneVvdvidzohf4Dn3+Ja+k/Djxt3OcoDyuKca3e1tl4M7v9rWmcs14lTuj5yK7cSMZ1EFaQWCOYtw8sG/nUoQUxQ1XXcJLMFh4Qfen85GhgECgYEAx4pqPSBGMH3qXTkJlzgBVzW2kSU4w4ndg+pWBKRMhy+lJ2AskH8uxh3cvcdGeCIU2OGMh0+5+ap/Nvl0Mj1Ss0R4teNQvHHkqz8+Lv6POCqZWsQ4BYQJfeied1H1JtZRRFUDM8JbZiN2ElTNVKupr4pWBrZQO6D0XO/kQvsx4I8=',
        ],
    ];
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['return','notify']]);
    }
    public function index(Request $request)
    {
        $price=$request->get("price");
        $order_id=$request->get("order_id");
        $config_biz = [
            'out_trade_no' => $order_id,
            'total_amount' => $price,
            'subject'      => '请打开手机支付宝扫一扫',
        ];

        $pay = new Pay($this->config);
        return $pay->driver("alipay")->gateway('web')->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);
//        var_dump($request->all());die
//        var_dump($request->all());die;
        $arr=$request->all();
        $order_id=$arr['out_trade_no'];
        $price=$arr['total_amount'];
//        echo $order_id;
//        echo $price;
        echo
        header("location:http://localhost:8080/#/Buycarthree?order_id=$order_id&price=$price");
//        return $pay->driver("alipay")->gateway('web')->verify($request->all());
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver("alipay")->gateway('web')->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
//
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }
        $arr=$request->all();
        $order_id=$arr['out_trade_no'];
        Db::update("update my_order set status=1 where order_id=$order_id");
        echo "success";
    }
}
