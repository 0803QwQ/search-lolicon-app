<?php
$setLicense = '';//自定义内部许可码
$setProxy = 'i.pixiv.re';//自定义Pixiv反代地址，默认为i.pximg.net(注意这个地址被墙了)
$setSize = 'regular';//自定义图片大小，默认为original，可以使用这些参数：original/regular/small/thumb/mini
$setShowTags = 3;//自定义显示的Tag数量，0为不限制，默认为0
$setMaxNumber = 10;//自定义输出的最多图片数量，最大为100，必须设置

function post($data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
    curl_setopt($ch, CURLOPT_URL, 'https://api.lolicon.app/setu/v2');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
};

function htmlHeader($keyword, $page){
    if ($keyword != null) $title = " | “{$keyword}”的搜索结果";
    return("<html><head><meta http-equiv'Content-Type' content='text/html; charset=utf-8'><meta name='viewport' content='width=device-width,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'><title>Search in the Lolicon.App V2 - Lolicon.App涩图检索工具2.0{$title}</title><style>.input_control{width:360px;margin:20px auto;}input[type='{$page}'],#btn1,#btn2{box-sizing:border-box;text-align:center;font-size:1.4em;height:2.7em;border-radius:4px;border:1px solid #c8cccf;color:#6a6f77;-web-kit-appearance:none;-moz-appearance:none;display:block;outline:0;padding:0 1em;text-decoration:none;width:100%;}input[type='{$page}']:focus{border:1px solid #ff7496;}input[type='number']:focus{border:1px solid #ff7496;}input[type='submit']{width:360px;margin:20px auto;height:40px;border-width:0px;border-radius:3px;background:#1E90FF;cursor:pointer;outline:none;font-family: Microsoft YaHei;color:white;font-size:17px;-webkit-appearance:none;}input[type='submit']:hover{background: #5599FF;-webkit-appearance:none;}::-moz-placeholder {color:#6a6f77;}::-moz-placeholder{color:#6a6f77;}input::-webkit-input-placeholder{color:#6a6f77;}.notice{margin:10%auto0;background-color:#f0f0f0;padding:2%5%}p{line-height:2}</style></head><body><div class='input_control'><h3><form action='#' method='post'><input type='asked' name='asked' value='true' style='display: none'>");
};

$asked = $_POST['asked'];
$keyword = $_POST['keyword'];
$license = $_POST['license'];
$r18 = intval($_POST['r18']);
$number = intval($_POST['number']);
if (!$asked){
    $return = htmlHeader(null, "license")."<input type='license' name='license' placeholder='请输入内部许可码'><input type='submit' value='Link Start !',name='submit'></form></h3><div class='notice'><p><b>欢迎使用Lolicon.App涩图检索工具2.0！</b></p><p>请阅读以下说明:</p><p>搜索时支持AND和OR规则，方法如下:</p><p>1.你可以使用逗号【,】来获取包含特定多个tag的涩图(最多3个)，如【可莉,白丝】</p><p>2.你可以使用分割符【|】来获取包含任意一个tag的涩图(最多20个)，如【黑丝|白丝|萝莉】</p>3.你可以两者混用，如【可莉,黑丝|白丝】</p><p>4.如果你只搜索一个关键词，网站将会在标题/tag/画师中进行模糊搜索</p><p>5.网站也支持搜索特定画师的涩图，你可以使用类似如下语句【UID:画师ID】进行搜索(注意这种搜索方式不能包含其他关键词)</p><p>6.规则语句会被自动修正，所以您同样可以使用中文标点，如【可莉，兽耳｜泳装】</p><p>7.网站支持一次性获取最多{$setMaxNumber}张图片，请冲的稍微节制一些(doge)</p><p>目前可以透露的情报：</p><iframe width='100%' src='https://charts.mongodb.com/charts-setu-api-qxdzw/embed/charts?id=f973f61b-912b-4dd6-b00a-f9c52db92918&amp;attribution=false'></iframe><iframe width='100%' src='https://charts.mongodb.com/charts-setu-api-qxdzw/embed/charts?id=b23a40a5-8c50-48ae-a950-95c81f9b013c&amp;attribution=false'></iframe><p>注：R18作品占比约为25%</p></div></body></html>";
}else{
    if ($license == $setLicense){
        $before = ['，', '｜', 'uid', '：'];
        $after = [',', '|', 'UID', ':'];
        foreach ($before as $key => $value){
            $keyword = str_replace($value, $after[$key], $keyword);
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
        if ($number >= $setMaxNumber){
            $number = $setMaxNumber;
        }elseif (!$number){
            $number = 1;
        };
        $data = [$postKey => $postValue, 'r18' => $r18, 'num' => $number, 'proxy' => $setProxy, 'size' => $setSize];
        $array = post(json_encode($data))['data'];
        $r18X = "r18Check".$r18;
        $$r18X = "checked='checked' ";
        if ($array == array()){
            $setuHtml = "<div class='notice'><p>标题：NULL<br>画师：NULL<br>PID：NULL<br>是否为R18图：NULL<br>图片Tag：NULL<br></p><p>404 Not Found</p></div><br>";
        }else{
            foreach ($array as $setuKey => $setuArray){
                if ($number != 1){
                    $setuNum = "【".($setuKey + 1)."】";
                };
                $setuURL = $setuArray['urls'][$setSize];
                $setuTitle = "标题{$setuNum}：".$setuArray['title']."<br>画师：".$setuArray['author']."(".$setuArray['uid'].")<br>PID：".$setuArray['pid'];
                $setuMode = "是否为R18图：".var_export($setuArray['r18'], true);
                $setuTag = "图片Tag：";
                foreach ($setuArray['tags'] as $key => $value){
                    if ($setShowTags == 0) $setShowTags = count($setuArray['tags']);
                    if ($key < ($setShowTags - 1)){
                        $setuTag = $setuTag.$value.", ";
                    }else{
                        $setuTag = $setuTag.$value."...";
                        break;
                    };
                };
                $setuHtml = $setuHtml."<div class='notice'><p>{$setuTitle}<br>{$setuMode}<br>{$setuTag}<br></p><img src='{$setuURL}' width='100%'/></div><br>";
            };
        };
        $return = htmlHeader($keyword, "keyword")."<input type='license' name='license' value='{$setLicense}' style='display: none'><input type='keyword' name='keyword' value='{$keyword}' placeholder='请输入搜索关键词'><br>全年龄<input type='radio' {$r18Check0}name='r18' value='0'>&emsp;&emsp;R18<input type='radio' {$r18Check1}name='r18' value='1'>&emsp;&emsp;随机<input type='radio' {$r18Check2}name='r18' value='2'><br>获取图片数量(1-{$setMaxNumber})：<input type='number' name='number' value='{$number}' min='1' max='{$setMaxNumber}' />张<input type='submit' value='立即搜索',name='submit'></form>{$setuHtml}</h3></div></body><html>";
    }else{
        $return = "<html><head><meta http-equiv'Content-Type' content='text/html; charset=utf-8'><meta name='viewport' content='width=device-width,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'><meta http-equiv='refresh' content='0; url=#'><title>Search in the Lolicon.App V2 - Lolicon.App涩图检索工具2.0</title></head><body><script>alert('警告：内部许可码错误！');</script></body></html>";
    };
};
echo($return);
?>
