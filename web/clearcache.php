<?php



function recursiveDelete($str){

    echo "Delete ".$str."<br />\n";

    if(is_file($str)){
        return @unlink($str);
    }
    elseif(is_dir($str)){
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path){
            recursiveDelete($path);
        }
        return @rmdir($str);
    }
}

recursiveDelete("../app/cache/");
recursiveDelete("../app/logs/");

//apc_clear_cache();
//apc_clear_cache('user');