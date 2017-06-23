<?php

/**
 * 验证码控制器
 * Class CaptchaController
 */
class CaptchaController extends Controller
{
    /**
     * 生成验证码
     */
    public function index(){
        $this->generate();
    }
    /**
     * 生成随机码
     * @param int $num
     */
    private function makeCode($num=4){
        $str = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        $str = str_shuffle($str);
        return substr($str,0,$num);
    }

    /**
     * 生成随机验证码
     */
    private function generate(){
        //1.随机码值
        $random_code = $this->makeCode(4);

        //将随机码保存到session中
        @session_start();
        $_SESSION['random_code'] = $random_code;

//2.随机背景
        $width = 322;
        $height = 44;
        $image = imagecreatetruecolor($width,$height);
        $green = imagecolorallocate($image,92, 189, 170);
        imagefill($image,0,0,$green);

//4.字体随机白色黑色
        $white = imagecolorallocate($image,255, 255, 255);
        $black = imagecolorallocate($image,0,0,0);
        imagestring($image,5,($width/5)*2,$height/3,$random_code,mt_rand(0,1) ? $white:$black);

//5.输出验证码
        header("Content-Type:image/jpeg;charset=utf-8");
        imagejpeg($image);
        //关闭图片资源
        imagedestroy($image);
    }
}