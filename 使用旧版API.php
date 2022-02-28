<?php
$set_randstr = '';//自定义内部许可码
$set_proxy = 'i.pixiv.re';//自定义Pixiv反代地址，默认为i.pixiv.cat

function head_tag($keyword, $page){
    if ($keyword != null) $title = " | “{$keyword}”的搜索结果";
    return("<head><meta name='viewport' content='width=device-width,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'><title>Search in the Lolicon.App - Lolicon.App涩图检索工具{$title}</title><style>.input_control{width:360px;margin:20px auto;}input[type='{$page}'],#btn1,#btn2{box-sizing:border-box;text-align:center;font-size:1.4em;height:2.7em;border-radius:4px;border:1px solid #c8cccf;color:#6a6f77;-web-kit-appearance:none;-moz-appearance:none;display:block;outline:0;padding:0 1em;text-decoration:none;width:100%;}input[type='{$page}']:focus{border:1px solid #ff7496;}input[type='submit']{width:360px;margin:20px auto;height:40px;border-width:0px;border-radius:3px;background:#1E90FF;cursor:pointer;outline:none;font-family: Microsoft YaHei;color:white;font-size:17px;-webkit-appearance:none;}input[type='submit']:hover{background: #5599FF;-webkit-appearance:none;}::-moz-placeholder {color:#6a6f77;}::-moz-placeholder{color:#6a6f77;}input::-webkit-input-placeholder{color:#6a6f77;}</style></head><body><div class='input_control'><h3><form action='#' method='post'><input type='asked' name='asked' value='true' style='display: none'>");
};
$asked = $_POST['asked'];
$keyword = $_POST['keyword'];
$randstr = $_POST['randstr'];
$r18 = "r18_checked".intval($_POST['r18']);
if (!$asked){
    $return = head_tag(null, "randstr")."<input type='randstr' name='randstr' placeholder='请输入内部许可码'><input type='submit' value='Link Start !',name='submit'></form></h3></div></body>";
}else{
    if ($randstr == $set_randstr){
        $keyword0 = urlencode($keyword);
        $json = file_get_contents("http://api.lolicon.app/setu/?size1200=true&proxy={$set_proxy}&r18={$r18}&keyword={$keyword0}");
        $array = json_decode($json, true);
        $$r18 = "checked='checked' ";
        if ($array['code'] == 404){
            $setu_url = "NULL";
            $setu_title = "标题：NULL<br>画师：NULL";
            $setu_mode = "是否为R18图：NULL";
            $setu_tag = "图片Tag：NULL";
        }else{
            $setu_url = $array['data'][0]['url'];
            $setu_title = "标题：".$array['data'][0]['title']."<br>画师：".$array['data'][0]['author'];
            $setu_mode = "是否为R18图：".var_export($array['data'][0]['r18'], true);
            $setu_tag = "图片Tag：";
            foreach ($array['data'][0]['tags'] as $key => $value){
                if ($key < 2){
                    $setu_tag = $setu_tag.$value.", ";
                }else{
                    $setu_tag = $setu_tag.$value."...";
                    break;
                };
            };
        };
        $return = head_tag($keyword, "keyword")."<input type='randstr' name='randstr' value='{$set_randstr}' style='display: none'> <input type='keyword' name='keyword' value='{$keyword}' placeholder='请输入搜索关键词'><br>全年龄<input type='radio' {$r18_checked0}name='r18' value='0'>&emsp;&emsp;R18<input type='radio' {$r18_checked1}name='r18' value='1'>&emsp;&emsp;随机<input type='radio' {$r18_checked2}name='r18' value='2'><input type='submit' value='立即搜索',name='submit'></form><p>{$setu_title}<br>{$setu_mode}<br>{$setu_tag}<br></p><img src='{$setu_url}' width='360'/></h3></div></body>";
    }else{
        $return = "<head><meta name='viewport' content='width=device-width,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'><meta http-equiv='refresh' content='0; url=#'><title>Search in the Lolicon.App - Lolicon.App涩图检索工具</title></head><body><script>alert('警告：内部许可码错误！');</script></body>";
    };
};
echo($return);
?>
