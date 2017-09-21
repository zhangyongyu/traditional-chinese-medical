<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

// $config['db']['host']   = "localhost";
// $config['db']['user']   = "root";
// $config['db']['pass']   = "";
// $config['db']['dbname'] = "slimapp";


$app = new \Slim\App(["settings"=>$config]);


$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};


// $container['db'] = function ($c) {
//     $db = $c['settings']['db'];
//     $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
//         $db['user'], $db['pass']);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     return $pdo;
// };



$container['view'] = new \Slim\Views\PhpRenderer("../templates/");

$app->get('/', function (Request $request, Response $response) {
    $response = $this->view->render($response, "main.phtml");

    return $response;
});

$app->post('/displayitems', function (Request $request, Response $response) {

    $items = array(

        1=>[['code' => 1,'name'=>'保持好心情'],['code' => 2,'name'=>'适当增加户外活动'],['code' => 3,'name'=>'多听活泼兴奋的音乐'],['code' => 4,'name'=>'多听悠扬舒缓的音乐'],['code' => 5,'name'=>'多参加社会活动，与多人沟通'],['code' => 6,'name'=>'多看书、写字、作画，增加修养'],['code' => 7,'name'=>'鼓励安静内敛'],['code' => 8,'name'=>'学会排解不良情绪'],['code' => 9,'name'=>'培养广泛的兴趣爱好'],['code' => 10,'name'=>'鼓励活泼好动']],



        2=>[['code' => 1,'name'=>'保证睡眠充足，不熬夜'],['code' => 2,'name'=>'三餐规律'],['code' => 3,'name'=>'大便定时'],['code' => 4,'name'=>'不过度劳累'],['code' => 5,'name'=>'避风保暖'],['code' => 6,'name'=>'不待在阴凉湿润的环境'],['code' => 7,'name'=>'待在阴凉湿润的环境'],['code' => 8,'name'=>'多进行室外活动'],['code' => 9,'name'=>'春捂'],['code' => 10,'name'=>'秋冻'],['code' => 11,'name'=>'安静少动']],

        3=>[['code' => 1,'name'=>'人参粥'],['code' => 2,'name'=>'黄花菜瘦肉汤'],['code' => 3,'name'=>'苁蓉羊肉汤'],['code' => 4,'name'=>'补气五红粥'],['code' => 5,'name'=>'莲子百合煲瘦肉'],['code' => 6,'name'=>'冬瓜海带薏米排骨汤'],['code' => 7,'name'=>'黄芪首乌藤炖猪瘦肉'],['code' => 8,'name'=>'绿豆薏米粥'],['code' => 9,'name'=>'三花茶'],['code' => 10,'name'=>'韭菜炒胡桃仁'],['code' => 11,'name'=>'老黄瓜赤小豆煲猪肉汤'],['code' => 12,'name'=>'黑豆川芎粥'],['code' => 13,'name'=>'红花三七蒸老']],

        4=>[['code' => 1,'name'=>'轻度运动'],['code' => 2,'name'=>'低度运动'],['code' => 3,'name'=>'中度运动'],['code' => 4,'name'=>'较强运动']],
        5=>[['code' => 1,'name'=>'按揉足三里、丰隆、水道'],['code' => 2,'name'=>'按揉三阴交、太溪'],['code' => 3,'name'=>'艾灸足三里、命门、肾俞'],['code' => 4,'name'=>'敲打足厥阴肝经'],['code' => 5,'name'=>'摩擦肾腰法'],['code' => 6,'name'=>'按压阴陵泉、阳陵泉'],['code' => 7,'name'=>'耳穴贴压肝区、肾区'],['code' => 8,'name'=>'按压太冲、膻中'],['code' => 9,'name'=>'按压中脘、气海、关元、天枢'],['code' => 10,'name'=>'艾灸（按压）足三里、关元、神阙、肾俞'],['code' => 11,'name'=>'按压血海、内关'],['code' => 12,'name'=>'艾灸足三里、关元、气海'],['code' => 13,'name'=>'敲打足少阴肾经'],['code' => 14,'name'=>'耳穴贴压肾区']]

    );

    $data = $request->getParsedBody();
    $cate = $data['cate'];

    $response = $items[$cate];

    return json_encode($response);


});

$app->post('/submit', function (Request $request, Response $response) {

    $data = $request->getParsedBody();

    $z =  $data['zhi'];
    $c =  $data['cate'];
    $i = $data['item'];


    if($z==1)
    {
        if($c==1)
        {
            if($i==4)
                $response='×气虚者内向，多听兴奋活泼音乐';
            elseif($i==7)
                $response='×气虚者内向安静，鼓励活好动';
            else
                $response='right';

        }
        elseif($c==2)
        {
            if($i==7)
                $response='×气虚肌腠疏松，不宜阴凉';
            elseif($i==10)
                $response='×气虚肌腠疏松，不宜冻';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==8)
                $response='×清热祛湿，湿热质适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            elseif($i==11)
                $response='×清热利湿、理气和中，湿热者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==4)
                $response='×';
            else
                $response='right';


        }
        elseif($c==5)
        {
            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==10)
                $response='×培补元气，特禀质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==13)
                $response='×培补元气，特禀质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }

    }
    elseif($z==2)
    {
        if($c==1)
        {
            if($i==4)
                $response='×气虚者内向，多听兴奋活泼音乐';
            elseif($i==7)
                $response='×气虚者内向安静，鼓励活好动';
            elseif($i==7)
                $response='×气虚者内向安静，鼓励活好动';
            else
                $response='right';

        }
        elseif($c==2)
        {
            if($i==7)
                $response='×阳虚则寒，不宜阴凉';
            elseif($i==10)
                $response='×阳虚则寒，不宜冻';
            elseif($i==11)
                $response='×阳虚则寒，宜多运动，活跃阳气';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==8)
                $response='×清热祛湿，湿热质适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';

            elseif($i==11)
                $response='×清热利湿、理气和中，湿热者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==1)
                $response='×阳虚者宜适度运动，活跃阳气';
            if($i==4)
                $response='x';
            else
                $response='right';

        }
        elseif($c==5)
        {

            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==10)
                $response='×培补元气，特禀质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==13)
                $response='×培补元气，特禀质适用';
            else
                $response='right';

        }
    }
    elseif($z==3)
    {
        if($c==1)
        {
            if($i==2)
                $response='×阴虚者烦躁，宜静不宜动';
            elseif($i==3)
                $response='×阴虚者烦躁，宜静不宜动';
            elseif($i==10)
                $response='×阴虚者烦躁，宜安静内敛';
            else
                $response='right';

        }
        elseif($c==2)
        {
            if($i==5)
                $response='×阴虚则热，不宜保暖';
            elseif($i==6)
                $response='×阴虚则热，需要阴凉环境';
            elseif($i==8)
                $response='×阴虚则热，增加室外活动会进一步损伤阴液';
            elseif($i==9)
                $response='×阴虚则热，不宜捂';
            else
                $response='right';
        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==8)
                $response='×清热祛湿，湿热质适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            elseif($i==11)
                $response='×清热利湿、理气和中，湿热者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==4)
                $response='×阴虚不适合较强运动，宜进一步伤阴液';
            else $response='right';

        }
        elseif($c==5)
        {

            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==10)
                $response='×培补元气，特禀质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==13)
                $response='×培补元气，特禀质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }
    }
    elseif($z==4)
    {
        if($c==1)
        {
            if($i==4)
                $response='×痰湿者多忍耐，多听活泼兴奋音乐';
            elseif($i==7)
                $response='×痰湿者稳重忍耐，鼓励活泼好动';
            else
                $response='right';

        }
        elseif($c==2)
        {

            if($i==7)
                $response='×痰湿无热，无需阴凉湿润';
            elseif($i==10)
                $response='×痰湿无热，不宜冻';
            elseif($i==11)
                $response='×痰湿者宜多运动，化痰祛湿';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==8)
                $response='×清热祛湿，湿热质适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            elseif($i==11)
                $response='×清热利湿、理气和中，湿热者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==1)
                $response='×痰湿者需中度以上运动';
            elseif($i==2)
                $response='×痰湿者需中度以上运动';
            else $response='right';

        }
        elseif($c==5)
        {

            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==10)
                $response='×培补元气，特禀质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==13)
                $response='×培补元气，特禀质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }
    }
    elseif($z==5)
    {
        if($c==1)
        {
            if($i==3)
                $response='×湿热质躁，宜静不宜动';
            elseif($i==10)
                $response='×湿热者烦躁，宜安静内敛';
            else
                $response='right';

        }
        elseif($c==2)
        {

            if($i==5)
                $response='×湿热质多表现为热象，不宜保暖';
            elseif($i==6)
                $response='×湿热质多表现为热象，需阴凉';
            elseif($i==9)
                $response='×湿热质多表现为热象，不宜捂';
            elseif($i==11)
                $response='×湿热者宜多运动，祛湿散热';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==1)
                $response='×湿热者需中度以上运动';
            elseif($i==2)
                $response='×湿热者需中度以上运动';
            else $response='right';

        }
        elseif($c==5)
        {

            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==10)
                $response='×培补元气，特禀质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==13)
                $response='×培补元气，特禀质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }
    }
    elseif($z==6)
    {
        if($c==1)
        {
            if($i==7)
                $response='×气郁质忧郁，鼓励活泼好动';
            else
                $response='right';

        }
        elseif($c==2)
        {

            if($i==5)
                $response='×气郁宜化火，不宜保暖';
            elseif($i==7)
                $response='×阴凉湿润会影响气血运行，加重气郁';
            elseif($i==10)
                $response='×寒凉会影响气血运行，加重气郁';
            elseif($i==11)
                $response='×少动不利于气血的运行';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==1)
                $response='×气郁质轻度运动不利于气血运行';
            elseif($i==2)
                $response='×气郁质轻度运动不利于气血运行';
            else $response='right';

        }
        elseif($c==5)
        {

            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==10)
                $response='×培补元气，特禀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==13)
                $response='×培补元气，特禀质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }
    }
    elseif($z==7)
    {
        if($c==1)
        {
            if($i==10)
                $response='×血瘀质烦躁，宜安静内敛';
            else
                $response='right';

        }
        elseif($c==2)
        {

            if($i==7)
                $response='×阴凉湿润会影响气血运行，加重血瘀';
            elseif($i==10)
                $response='×寒凉会影响气血运行，加重血瘀';
            elseif($i==11)
                $response='×少动不利于气血的运行';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==7)
                $response='×滋补脱敏，特禀质适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            else
                $response='right';

        }
        elseif($c==4)
        {
            if($i==4)
                $response='×较强运动可能会引起出血';
            else $response='right';

        }
        elseif($c==5)
        {

            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }
    }
    elseif($z==8)
    {
        if($c==1)
        {
            if($i==3)
                $response='×特禀质者敏感，宜静不宜动';
            elseif($i==10)
                $response='×特禀者敏感，宜安静内敛';
            else
                $response='right';

        }
        elseif($c==2)
        {

            if($i==7)
                $response='×阴凉湿润易引起过敏';
            elseif($i==8)
                $response='×室外活动易引起花粉类过敏';
            elseif($i==10)
                $response='×寒凉易引起过敏';
            elseif($i==11)
                $response='×湿热者宜多运动，祛湿散热';
            else
                $response='right';

        }
        elseif($c==3)
        {
            if($i==1)
                $response='×大补元气，气虚者适用';
            elseif($i==2)
                $response='×疏肝解郁，气郁者适用';
            elseif($i==3)
                $response='×温补肾阳，阳虚者适用';
            elseif($i==4)
                $response='×益气健脾，气虚者适用';
            elseif($i==5)
                $response='×滋阴补肾，阴虚者适用';
            elseif($i==6)
                $response='×祛湿化痰，痰湿者适用';
            elseif($i==9)
                $response='×行气解郁，气郁者适用';
            elseif($i==10)
                $response='×温补阳气，阳虚者适用';
            elseif($i==12)
                $response='×活血化瘀，血瘀者适应';
            elseif($i==13)
                $response='×活血补气，血瘀质适用';
            else
                $response='right';

        }
        elseif($c==4)
        {

            $response='right';

        }
        elseif($c==5)
        {

            if($i==1)
                $response='×补气健脾，痰湿质适用';
            if($i==2)
                $response='×滋补阴液，阴虚质适用';
            if($i==3)
                $response='×温补阳气，阳虚质适用';
            if($i==4)
                $response='×行气解郁，气虚质适用';
            if($i==5)
                $response='×温补肾阳，阳虚质适用';
            if($i==6)
                $response='×清利湿热，湿热质适用';
            if($i==7)
                $response='×滋阴补肾，阴虚质适用';
            if($i==8)
                $response='×疏肝解郁，气郁质适用';
            if($i==9)
                $response='×健脾祛湿，痰湿质适用';
            if($i==11)
                $response='×活血化瘀，血瘀质适用';
            if($i==12)
                $response='×益气健脾，气虚质适用';
            if($i==14)
                $response='×温肾助阳，阳虚质适用';
            else
                $response='right';

        }
    }

    return json_encode($response);
});

$app->run();

