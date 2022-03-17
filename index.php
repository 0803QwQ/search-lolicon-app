<?php
$setLicense = '';//自定义内部许可码
$setProxy = 'i.pixiv.re';//自定义Pixiv反代地址，默认为i.pximg.net(注意这个地址被墙了)
$setPixivAPI = 'pixiv.re';//自定义Pixiv原图下载API，必须设置
$setSize = 'regular';//自定义图片大小，默认为original，可以使用这些参数：original/regular/small/thumb/mini
$setShowTags = 3;//自定义显示的Tag数量，0为不限制，默认为0
$maxNumber = 10;//自定义输出的最多图片数量，最大为100，必须设置
$verifyR18 = true;//设置是否在搜索R18内容时要求年龄高于18岁
$hideR18 = false;//设置是否隐藏R18内容，注意设置此项后$verifyR18变量将无效
$htmlBackground = 'https://iw233.cn/api/Random.php';//自定义背景图片，可以设置为任意图片或随机图片的API，默认无背景
$htmlBgBlur = 5;//自定义背景高斯模糊，单位px
$htmlBgOpacity = 0.9;//自定义背景透明度，区间为0-1，0为完全透明，1为完全不透明
$htmlIcon = './icon.ico';//自定义网站的图标
$allowIP = [];//限制可以访问的IP，若填写该项，将只有被允许的IP能够访问此页面

function htmlHeader($page){
    global $keyword, $over18, $htmlBackground, $htmlBgBlur, $htmlBgOpacity, $htmlIcon;
    if ($keyword != null) $title = " | \"{$keyword}\"的搜索结果";
    if ($page == "verifyR18"){
        $note = "p{margin:0;}*,*::before,*::after{box-sizing:border-box;}.overlay,.scare{position:fixed;top:0;left:0;height:100vh;width:100vw;}p.overlay-title{font-size:24px;font-weight:900;color:black;line-height:1;margin-bottom:16px;}.overlay-button{display:inline-flex;align-items:center;height:40px;padding-right:24px;padding-left:24px;font-size:16px;font-weight:500;line-height:1;border-radius:4px;margin:4px;cursor:pointer;}.overlay-buttons-wrapper{margin:24px -8px -8px;}#accept-button{background-color:rgb(255, 0, 0);color:white;}#decline-button{color:rgb(0, 0, 0);border:2px solid rgb(0, 0, 0);}p.overlay-description{font-size:16px;font-weight:400;color:rgba(0, 0, 0, 0.5);line-height:1.25;margin-bottom:16px;}a.overlay-link{display:inline-block;text-decoration:none;font-size:16px;font-weight:500;color:rgb(255, 0, 0);line-height:1;position:relative;margin-top:16px;}a.overlay-link::before{position:absolute;content:'';height:calc(50% + 4px);width:calc(100% + 8px);bottom:-4px;left:-4px;background-color:rgba(132, 94, 194, 0.1);}.overlay-body{max-width:512px;text-align:center;font-family:'Inter', sans-serif;}</style></head><body><div id='overlay' class='overlay'><div class='text-bg'><div class='overlay-body'><p class='overlay-title'>您是否已满18岁?</p><p class='overlay-description'>以下内容的某些部分可能不适合<b>未满18岁</b>的人群查看，我们需要确认您的年龄以便于隐藏相关内容。</p><p class='overlay-description'>Some sections of the following may not be suitable for people <b>under the age of 18</b>, and we need to confirm your age in order to hide the content.</p><div class='overlay-buttons-wrapper'><form method='post'><button id='accept-button' class='overlay-button' name='over18' value='1'>已满18岁</button></form><form method='post'><button id='decline-button' class='overlay-button' name='over18' value='-1'>未满18岁</button></form></div></div></div></div>";
    }else{
        $note = "input[id='{$page}'],#btn1,#btn2{box-sizing:border-box;text-align:center;font-size:1.4em;height:2.7em;border-radius:4px;border:1px solid #c8cccf;color:#6a6f77;-web-kit-appearance:none;-moz-appearance:none;display:block;outline:0;padding:0 1em;text-decoration:none;width:100%;}input[id='{$page}']:focus{border:1px solid #ff7496;}input[id='number']:focus{border:1px solid #ff7496;}input[id='submit']{width:360px;margin:20px auto;height:40px;border-width:0px;border-radius:3px;background:#1E90FF;cursor:pointer;outline:none;font-family:Microsoft YaHei;color:white;font-size:17px;-webkit-appearance:none;}input[id='submit']:hover{background:#5599FF;-webkit-appearance:none;}::-moz-placeholder {color:#6a6f77;}::-moz-placeholder{color:#6a6f77;}input::-webkit-input-placeholder{color:#6a6f77;}.notice{margin:10%auto0;background-color:rgba(245, 245, 245, 0.8);padding:2%5%}p{line-height:2}</style></head><body><div id='overlay' class='overlay'><div class='text-bg'><div class='input_control'><h3><form method='post'><input type='asked' name='asked' value='true' style='display:none'><input type='over18' name='over18' value='{$over18}' style='display:none'>";
    };
    return("<html><head><meta http-equiv'Content-Type' content='text/html; charset=utf-8'><meta name='viewport' content='width=device-width,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'><title>Search in the Lolicon.App V2 - Lolicon.App涩图检索工具2.0{$title}</title><link href='{$htmlIcon}' rel='icon' type='image/x-icon' /><style>.overlay{z-index:2;display:flex;align-items:center;justify-content:center;}.overlay:before{background:url({$htmlBackground}) no-repeat;background-size:cover;background-position:center 0;width:100%;height:100%;content:\"\";position:absolute;top:0;left:0;z-index:-1;-webkit-filter:blur(3px);filter:blur({$htmlBgBlur}px);opacity:{$htmlBgOpacity};margin:0;padding:0;position:fixed;}.text-bg{background-color:rgba(255, 255, 255, 0.6);padding:24px;}.input_control{width:360px;margin:20px auto;}.dlbg{z-index:3;position:fixed;bottom:1px;right:1px;}#imgLayer{display:none;z-index:4;position:fixed;width:100%;height:100%;background:rgba(0,0,0,0.6);top:50%;left:50%;transform:translateX(-50%) translateY(-50%);}#imgBoxl{display:none;height:100%;z-index:5;position:fixed;margin:5%;}#bigimg{position:fixed;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);}button[id='download']{color:rgb(0, 0, 0);border:2px solid rgb(0, 0, 0);cursor:pointer;}{$note}");
};
function htmlAlert($info){
    global $htmlIcon;
    return(print_r("<html><head><meta http-equiv'Content-Type' content='text/html; charset=utf-8'><meta name='viewport' content='width=device-width,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'><meta http-equiv='refresh' content='0; url='><title>Search in the Lolicon.App V2 - Lolicon.App涩图检索工具2.0</title><link href='{$htmlIcon}' rel='icon' type='image/x-icon' /></head><body><script>alert('{$info}');</script></body></html>"));
};
function setuGet($pid, $p){
    global $setPixivAPI;
    $url = "http://{$setPixivAPI}/{$pid}";
    $fileTypeArray = ['png', 'jpg', 'gif'];
    foreach ($fileTypeArray as $fileType){
        if (@file_get_contents($url."-{$p}.{$fileType}")){
            $url .= "-{$p}.{$fileType}";
        }elseif (@file_get_contents($url."-1.{$fileType}")){
            $p = 1;
            $url .= "-1.{$fileType}";
        }elseif (@file_get_contents($url.".{$fileType}")){
            $p = 1;
            $url .= ".{$fileType}";
        }else{
            if ($fileType == 'gif') unset($url);
            continue;
        };
        break;
    };
    return(['pid' => $pid, 'p' => $p, 'url' => $url]);
};
function isTencentAppBrowser(){
    $UA = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($UA, "MicroMessenger")) return("inWeiXin");
    if (strpos($UA, "Windows Phone")) return("WPBrowser");
    if (strpos($UA, "QQ")){
        if (strpos($UA, "_SQ_")) return("inQQ"); else return("inQQBrowser");
    };
    return(false);
};
$iTAB = isTencentAppBrowser();
if ($iTAB == "WPBrowser" && !$_GET['WPBrowser']){
    return(print_r("<font size='6'><b>提示：<br>您使用的可能是Windows Phone平台，我们无法判断您的浏览器，请确保您是使用非国产软件内置浏览器访问的本页面后点击<a href='?WPBrowser=true'>【继续】</a>；亦或者，如果您使用的是国产软件内置浏览器，请点击右上角的“···”按钮选择“在默认浏览器中打开”，谢谢</b></font>"));
}elseif (in_array($iTAB, ['inWeiXin', 'inQQ'], true)){
    return(print_r("<font size='6'><b>提示：<br>请使用非国产软件内置浏览器访问本页面，你可以点击右上角的“···”按钮选择“在默认浏览器中打开”，谢谢</b></font>"));
};
$asked = (bool)$_POST['asked'];
$keyword = strval($_POST['keyword']);
$license = strval($_POST['license']);
$r18 = intval($_POST['r18']);
$number = intval($_POST['number']);
if ($hideR18 == true){
    $over18 = -1;
}elseif ($verifyR18 == false){
    $over18 = 1;
}else{
    $over18 = intval($_POST['over18']);
};
if ($_GET['download'] != null){
    $setuIpInfo = json_decode(urldecode($_GET['download']), true);
    if ($setuIpInfo['url'] != null){
        $setuGetURL = $setuIpInfo['url'];
    }else{
        $setuGetURL = setuGet($setuIpInfo['pid'], $setuIpInfo['p'])['url'];
        if (!$setuGetURL) exit;
    };
    header('Content-Type: application/force-download');
    header('Content-Disposition: attachment; filename="'.basename($setuGetURL).'"');
    header('Content-Transfer-Encoding: binary');
    header('Connection: close');
    readfile($setuGetURL);
    exit;
};
unset($_GET['download']);
$setBefore = ['license', 'proxy','pixivapi', 'size', 'showtags'];
$setAfter = ['License', 'Proxy','PixivAPI', 'Size', 'ShowTags'];
foreach ($_GET as $setKey => $setValue){
    foreach ($setBefore as $key => $value) $setKey = str_replace($value, $setAfter[$key], $setKey);
    if ($setKey == "License"){
        $license = $setValue;
    }else{
        $userSetting = "set".$setKey;
        $$userSetting = strval($setValue);
    };
};
if ($allowIP != array() && !in_array($_SERVER['REMOTE_ADDR'], $allowIP)) htmlAlert("警告：访问IP未经授权！");
$htmlBgHeader = get_headers($htmlBackground, 1);
if ($htmlBgHeader['Location'] != null) $htmlBackground = $htmlBgHeader['Location'];
if ($htmlBgHeader['location'] != null) $htmlBackground = $htmlBgHeader['location'];
$bgDownload = urlencode(json_encode(['url' => $htmlBackground]));
$htmlEnd = "<div id='dlbg' class='dlbg'><a href=\"JavaScript:openBg()\"><button id='download'>获取背景</button></a></div><div id='imgLayer' onclick=\"closeBg()\"></div><div id='imgBoxl' class='modal'><a href=\"JavaScript:download('{$bgDownload}')\"><img id='bigimg' src='{$htmlBackground}' title='点击图片以保存\n点击空白处以关闭'/></a></div><script>function download(info){alert('正在唤起浏览器下载...');location.href='?download='+info;};function openBg(){var imgLayer=document.getElementById(\"imgLayer\");var imgBoxl=document.getElementById(\"imgBoxl\");imgLayer.style.display=\"block\";imgBoxl.style.display=\"block\";imgSg();};function closeBg(){var imgLayer=document.getElementById(\"imgLayer\");var imgBoxl=document.getElementById(\"imgBoxl\");imgLayer.style.display=\"none\";imgBoxl.style.display=\"none\";};function imgSg(){var img=document.getElementById(\"bigimg\");var imgw=img.naturalWidth;var imgh=img.naturalHeight;var userw=document.body.clientWidth;var userh=document.body.clientHeight;if (imgw>=(userw * 0.8) && imgh<=(userh * 0.8)){img.style.width=\"80%\";img.style.height=\"auto\";}else if (imgh>=(userh * 0.8)){img.style.width=\"auto\";img.style.height=\"80%\";}else{img.style.width=\"auto\";img.style.height=\"auto\";};};</script></body></html>";
if (!$asked){
    if ($verifyR18 == true && !$over18){
        $htmlDoc = htmlHeader("verifyR18").$htmlEnd;
    }else{
        if ($_GET == array()) $help = "网址示例：【<span id='here'></span>?Size=original&ShowTags=0】";
        if ($over18 != -1){
            $R18Info = "<p>注：R18作品占比约为25%</p>";
            $pidInfo = "在此之外，网站也支持通过PID获取任意Pixiv图片原图，你可以使用选择PID选项后在搜索框直接输入图片的PID进行搜索";
        }else{
            $pidInfo = "【数据删除】";
        };
        if ($setLicense != "") $htmlLicense = "<input id='license' type='password' name='license' placeholder='请输入内部许可码'>";
        $htmlDoc = htmlHeader("license")."{$htmlLicense}<input id='submit' type='submit' value='Link Start !',name='submit'></form></h3><div class='notice'><p><b>欢迎使用Lolicon.App涩图检索工具2.0！</b></p><p>请阅读以下说明:</p><p>搜索时支持AND和OR规则，方法如下:</p><p>1.你可以使用逗号【,】来获取包含特定多个tag的涩图(最多3个)，如【可莉,白丝】</p><p>2.你可以使用分割符【|】来获取包含任意一个tag的涩图(最多20个)，如【黑丝|白丝|萝莉】</p>3.你可以两者混用，如【可莉,黑丝|白丝】</p><p>4.如果你只搜索一个关键词，网站将会在标题/Tag/画师中进行模糊搜索</p><p>5.网站也支持搜索特定画师的涩图，你可以使用类似如下语句【UID:画师UID】进行搜索(注意这种搜索方式不能包含其他关键词)</p><p>6.{$pidInfo}</p><p>7.规则语句会被自动修正，所以您同样可以使用中文标点，如【可莉，兽耳｜泳装】</p><p>8.网站支持一次性获取最多{$maxNumber}张图片，请冲的稍微节制一些(doge)</p><p>9.网站支持添加以下GET参数以小幅度更改网站的显示效果：<ul><li>Proxy：Pixiv反代地址</li><li>PixivAPI：Pixiv原图下载API</li><li>Size：图片大小，你可以使用值\"original\"以获取原图</li><li>ShowTags：显示tag数量，你可以使用值\"0\"以获取全部Tag</li></ul>{$help}</p><p>目前可以透露的情报：</p><iframe width='100%' src='https://charts.mongodb.com/charts-setu-api-qxdzw/embed/charts?id=f973f61b-912b-4dd6-b00a-f9c52db92918&amp;attribution=false'></iframe><iframe width='100%' src='https://charts.mongodb.com/charts-setu-api-qxdzw/embed/charts?id=b23a40a5-8c50-48ae-a950-95c81f9b013c&amp;attribution=false'></iframe>{$R18Info}</div></div></div><script>document.getElementById(\"here\").innerHTML = window.location.href;</script>".$htmlEnd;
    };
}else{
    if ($license != $setLicense) htmlAlert("警告：内部许可码错误！");
    $before = ['，', '｜', 'uid', 'pid', '：'];
    $after = [',', '|', 'UID', 'PID', ':'];
    foreach ($before as $key => $value) $keyword = str_replace($value, $after[$key], $keyword);
    $r18X = "r18Check".$r18;
    $$r18X = "checked='checked' ";
    if ($number >= $maxNumber && $r18 != 3){
        $number = $maxNumber;
    }elseif (!$number){
        $number = 1;
    };
    if ($over18 != -1) $chooseR18 = "全年龄<input id='radio' type='radio' {$r18Check0}name='r18' value='0' onclick=\"radioCheck1()\">&emsp;&emsp;R18<input id='radio' type='radio' {$r18Check1}name='r18' value='1' onclick=\"radioCheck1()\">&emsp;&emsp;随机<input id='radio' type='radio' {$r18Check2}name='r18' value='2' onclick=\"radioCheck1()\"><br>PID<input id='radio' type='radio' {$r18Check3}name='r18' value='3' onclick=\"radioCheck2()\">&ensp;&ensp;";
    if ($r18 == 3){
        $pid = intval($keyword);
        $setuGet = setuGet($pid, $number);
        $setuDownload = urlencode(json_encode(['pid' => $setuGet['pid'], 'p' => $setuGet['p']]));
        $numberInfo = "页码：<input id='number' type='number' name='number' value='{$number}' min='1' max='2147483647' />页";
        if (!$setuGet['url']){
            $htmlSetu = "<div class='notice'><p>PID：NULL(第NULL页)</p><p>404 Not Found</p></div><br>";
        }else{
            $htmlSetu = "<div class='notice'><p>PID：{$setuGet['pid']}(第{$setuGet['p']}页)&ensp;<a href=\"JavaScript:download('{$setuDownload}')\"><button id='download'>下载原图</button></a></p><img src='{$setuGet['url']}' width='100%'/></div><br>";
        };
        goto printSetu;
    }else{
        $numberInfo = "数量(1-{$maxNumber})：<input id='number' type='number' name='number' value='{$number}' min='1' max='{$maxNumber}' />张";
    };
    if (strstr($keyword, ',') || strstr($keyword, '|')){
        $postValue = explode(',', $keyword);
        $postKey = 'tag';
    }elseif (substr($keyword , 0 , 4) == 'UID:'){
        $postValue = intval(str_replace('UID:', null, $keyword));
        $postKey = 'uid';
    }else{
        $postValue = $keyword;
        $postKey = 'keyword';
    };
    $context = stream_context_create(['http' => ['method' => 'POST', 'header' => 'Content-Type: application/json', 'content' => json_encode([$postKey => $postValue, 'r18' => $r18, 'num' => $number, 'proxy' => $setProxy, 'size' => $setSize]), 'timeout' => 60]]);
    $array = json_decode(file_get_contents('https://api.lolicon.app/setu/v2', false, $context), true)['data'];
    if ($array == array()){
        if ($over18 != -1) $setuMode = "<br>是否为R18图：NULL";
        $htmlSetu = "<div class='notice'><p>标题：NULL<br>画师：NULL<br>PID：NULL(第NULL页){$setuMode}<br>图片Tag：NULL<br></p><p>404 Not Found</p></div><br>";
        goto printSetu;
    };
    foreach ($array as $setuKey => $setuArray){
        if ($over18 == -1 && in_array('R-18', $setuArray['tags'])){
            $htmlSetu .= "<div class='notice'><p>标题：NULL<br>画师：NULL<br>PID：NULL(第NULL页)<br>图片Tag：NULL<br></p><p>403 Forbidden</p></div><br>";
            continue;
        };
        if ($number != 1) $setuNum = "【".($setuKey + 1)."】";
        $setuURL = $setuArray['urls'][$setSize];
        $setuOpInfo = "标题{$setuNum}：".$setuArray['title']."<br>画师：".$setuArray['author']."(".$setuArray['uid'].")<br>PID：".$setuArray['pid']."(第".($setuArray['p'] + 1)."页)";
        $setuDownload = urlencode(json_encode(['pid' => $setuArray['pid'], 'p' => ($setuArray['p'] + 1)]));
        if ($over18 != -1) $setuMode = "<br>是否为R18图：".var_export($setuArray['r18'], true);
        $setuTag = "图片Tag：";
        $setShowTagsX = "setShowTags";
        foreach ($setuArray['tags'] as $key => $value){
            if ($setShowTags == 0){
                $setShowTagsX .= "Y";
                $$setShowTagsX = count($setuArray['tags']);
            };
            if ($key < ($$setShowTagsX - 1)){
                $setuTag .= $value.", ";
            }else{
                if ($setShowTags != 0) $setuTagEnd = "...";
                $setuTag .= $value.$setuTagEnd;
                break;
            };
        };
        $htmlSetu .= "<div class='notice'><p>{$setuOpInfo}&ensp;<a href=\"JavaScript:download('{$setuDownload}')\"><button id='download'>下载原图</button></a>{$setuMode}<br>{$setuTag}<br></p><img src='{$setuURL}' width='100%'/></div><br>";
    };
    printSetu:
    $htmlDoc = htmlHeader("keyword")."<input id='license' type='license' name='license' value='{$setLicense}' style='display:none'><input id='keyword' type='keyword' name='keyword' value='{$keyword}' placeholder='请输入搜索关键词'><br>{$chooseR18}获取<span id='numberInfo'>{$numberInfo}</span><input id='submit' type='submit' value='立即搜索',name='submit'></form>{$htmlSetu}</h3></div></div></div><script>var background=new Image();background.src='{$htmlBackground}';function radioCheck1(){document.getElementById('numberInfo').innerHTML=\"数量(1-{$maxNumber})：<input id='number' type='number' name='number' value='{$number}' min='1' max='{$maxNumber}' />张\";};function radioCheck2(){document.getElementById('numberInfo').innerHTML=\"页码：<input id='number' type='number' name='number' value='{$number}' min='1' max='2147483647' />页\";};</script>".$htmlEnd;
};
return(print_r($htmlDoc));
?>
