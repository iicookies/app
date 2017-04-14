<?php    
class ClassLoaderEx     
{     
    public static function loader($classname)     
    {     
        //$class_file = strtolower($classname).".php";
        $class_file =  "./Controller/".$classname.".php"; 
        $plugin_file = "./Plugins/" .$classname.".php";  
        $model_file = "./Model/" .$classname.".php";     
        if (strstr($classname,"Controller") && file_exists($class_file)){     
            require_once($class_file);  
        }else if(file_exists($plugin_file)){
            require_once($plugin_file);
        }else if(file_exists($model_file)){
            require_once($model_file);
        }else{

        }     
    }     
}      
// 方法为静态方法     
spl_autoload_register('ClassLoaderEx::loader');


/******************************************************* 
 * 
 * URL 路由原理展示代码 
 * 
 * 浏览器访问地址: http://server/index.php?C=Controler1&M=Method1 
 * 根据C找到控制器类，再根据M找到方法，然后执行这个方法 
 *  
 * ****************************************************/ 

$C = isset($_GET['C'])?$_GET['C']:(isset($_REQUEST['C'])?$_REQUEST['C']:NULL);  
$M = isset($_GET['M'])?$_GET['M']:(isset($_REQUEST['M'])?$_REQUEST['M']:NULL);  
  #&& class_exists($C) && method_exists($C, $M)
if($C != NULL && $M != NULL ) {
    if(!class_exists($C))
    $C = $C.'Controller'; 
    if(!class_exists($C)){
        echo json_encode(array('code'=>1,'msg'=>'找不到控制器'),true);  
        exit;  
    }
    $cObj = new $C();
    if(method_exists($C, $M)){
         $cObj->$M();  
    }else{
        echo json_encode(array('code'=>1,'msg'=>'找不到控制器或方法'),true);  
        exit;  
    }
}else{  
     echo json_encode(array('code'=>1,'msg'=>'找不到控制器'),true);  
    exit;  
}  

