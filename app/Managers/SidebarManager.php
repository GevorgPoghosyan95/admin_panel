<?php
namespace App\Managers;

use App\Group;

class SidebarManager
{
    public function groups(){
        $groups = Group::all();
        $arrays = [];
        foreach ($groups as $item => $group) {
            //$arrays[$group->id] = explode("_", $group->name);
            //$arrays[$group->id]['route'] = $group->route;
            $arrays[] = [
                "permission" => $this->arrjson(explode(".", $group->name),$group->route)
            ];

        }
        //$result = $this->arrjson($arrays);
        $merge = [];
        foreach ($arrays as $key=>$value){
            if(empty($merge)){
                $merge = $value['permission'];
            }else{
                $merge = array_merge_recursive($merge,$value['permission']);
            }

        }
        return $merge;

    }

    public function arrjson ($arr,$route){
        $temp1 = '';
        for($j=0;$j<count($arr);$j++){
            $temp1 =$temp1."{\"".$arr[$j]."\":";
        }
        return json_decode($temp1."\"".$route."\"".str_repeat("}",$j), true);
    }
}
