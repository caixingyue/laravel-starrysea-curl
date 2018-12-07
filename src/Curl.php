<?php

namespace Starrysea\Curl;

use Starrysea\Arrays\Arrays;

class Curl
{
    private $curl;

    /**
     * 请求curl
     * @param string $url 请求地址
     * @param string|array $post_data post请求数据[空时默认get请求]
     * @param array $headers http头数据传输
     * @param bool $see_head 输出请求头数据
     * @return array|bool|mixed|object|string
     */
    public static function get_curl(string $url = '', $post_data = '', array $headers = [], bool $see_head = false)
    {
        if ($url == '') return '请求地址不能为空';
        $curl = self::first(); // 初始化
        if ($post_data !== ''){ // POST 请求
            $curl->post($url, $post_data);
        }else{ // GET 请求
            $curl->get($url);
        }
        $curl->headers($headers); // 设置HTTP头数据
        return $curl->request($see_head); // 请求并取得数据
    }

    /**
     * 初始化自身
     * @param bool $fileStream true => 以文件流的形式获取数据, false => 直接输出数据
     * @return Curl
     */
    public static function first(bool $fileStream = true)
    {
        $data = new self;
        $data->curl = curl_init(); // 初始化CURL

        // 设置获取的信息以文件流的形式返回，而不是直接输出
        if ($fileStream === true)
            curl_setopt($data->curl, CURLOPT_RETURNTRANSFER, 1);

        return $data;
    }

    /**
     * 配置post请求
     * @param string $url 请求的url
     * @param array $data 请求的数据
     * @return $this
     */
    public function post(string $url, array $data = [])
    {
        curl_setopt($this->curl, CURLOPT_URL, $url); // 设置请求的url
        curl_setopt($this->curl, CURLOPT_POST, 1); // 设置post方式提交
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data); // 设置post数据
        return $this;
    }

    /**
     * 配置get请求
     * @param string $url 请求的url
     * @param array $data 请求的数据,同键名将覆盖
     * @return $this
     */
    public function get(string $url, array $data = [])
    {
        $url = explode('?', $url);
        $uda = data_get($url, 1, '');
        $url = data_get($url, 0, '');
        parse_str($uda, $uda);
        $data = array_merge($uda, $data); // 合并请求数据
        $data = http_build_query($data); // 设置get数据
        curl_setopt($this->curl, CURLOPT_URL, $url . '?' . $data); // 设置请求的url
        return $this;
    }

    /**
     * 配置header请求数据
     * @param array $data 请求的数据
     * @return $this
     */
    public function headers(array $data = [])
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, Arrays::composite($data)); // 设置http头数据
        return $this;
    }

    /**
     * 请求并取得数据
     * @param bool $seeHead true => 头文件的信息作为数据流输出
     * @return array|bool|mixed|object|string
     */
    public function request(bool $seeHead = false)
    {
        // 设置头文件的信息作为数据流输出
        if ($seeHead === true)
            curl_setopt($this->curl, CURLOPT_HEADER, 1);

        $data = curl_exec($this->curl); // 执行命令
        curl_close($this->curl); // 关闭URL请求
        return $data;
    }
}
