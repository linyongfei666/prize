<?php

namespace App\Http\Controllers;

use App\model\PrizeModel;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    public function index()
    {
        return view('/prize/index');
    }

    public function prizedo(Request $request)
    {
        $uid = mt_rand(1,10000);
        $uid = 100;
        //获取用户抽奖记录
        $record = PrizeModel::where(['uid'=>$uid])->get()->toArray();
        $count = 0;
        foreach($record as $k=>$v){
            if($v['level']>0){
                $level = 0;
                $msg = "你已经中过奖了";
                $resposer = [
                    'error' =>0,
                    'msg'=>$msg,
                    'data'=>[
                        'level'=>$level,
                        'msg'=>$msg
                    ],
                ];
                die(json_encode($resposer));
            }
            $count++;
        }

        if($count>=3){
            $resposer = [
                'error' =>0,
                'msg'=>'抽奖次数已用完',
                'data'=>[
                    'level'=>0,
                ],
            ];
            die(json_encode($resposer));
        }
        $prize = $this->getPrize();
        $data = [
            'uid'=>$uid,
            'level'=>$prize['level']
        ];

        $resposer = [
            'error'=>0,
            'msg'=>'再来一次',
            'data'=>[
                'level'=>$prize['level'],
                'msg'=>$prize['msg'],
            ]
        ];
        PrizeModel::insertGetId($data);
        echo json_encode($resposer);


    }
    /**
     * 返回中奖等级
     */
    protected function getPrize()
    {
        $rand_number = mt_rand(1,100);
        //判断一等奖个数
        if($rand_number==1){
            $count = PrizeModel::where(['level'=>1])->count();
            if($count == 1){
                $level = 0;
                $msg = "未中奖";
            }else{
                $level = 1;
                $msg = "恭喜,一等奖";
            }
        }elseif($rand_number==2 || $rand_number==3){
            $count = PrizeModel::where(['level'=>2])->count();
            if($count == 2){
                $level = 0;
                $msg = "未中奖";
            }else{
                $level = 2;
                $msg = "恭喜,二等奖";
            }
        }elseif($rand_number==4 || $rand_number==5 || $rand_number==6){
            $count = PrizeModel::where(['level'=>3])->count();
            if($count == 3){
                $level =0;
                $msg = "未中奖";
            }else{
                $level =3;
                $msg = "恭喜,三等奖";
            }
        }elseif($rand_number>6 && $rand_number<17){
            $count = PrizeModel::where(['level'=>4])->count();
            if($count == 4){
                $level =0;
                $msg = "未中奖";
            }else{
                $level =4;
                $msg ="恭喜,阳光普照奖";
            }
        }else{
            $level = 0;
            $msg = "未中奖";
        }

        return [
            'level' => $level,
            'msg' => $msg
        ];
    }
}
