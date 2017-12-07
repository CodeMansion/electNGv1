<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date',
    ];

    public static function isElectionExists($field){
        $data = self::where('name','=',$field)->first();
        if($data){
            return true;
        }
        return false;
    }

    public function status(){
        return $this->belongsTo('App\ElectionStatus','election_status_id');
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = ucfirst($value);
    }

    public static function find($id,$field=null){
        if($field){
            return self::where($field, '=', $id)->firstOrFail();
        }
        return self::where('id', '=', $id)->firstOrFail();
    }

    public function centre($id){
        $centre = PollingStation::find($id);
        return $centre['name'];
        // return $this->belongsTo('App\PollingStation','polling_station_id','id');
    }

    public function lga($id){
        $lga = Lga::find($id);
        return $lga['name'];
    }

    public function ward($id){
        $ward = Ward::find($id);
        return $ward['name'];
    }

    public function state($id){
        $state = State::find($id);
        return strtoupper($state['name']);
    }

    public function pollingUsers($id) {
        $user = User::find($id);
        return strtoupper($user->profile->first_name.' '.$user->profile->last_name);
    }

    public function pollingCentres($id) {
        $centre = PollingStation::find($id);
        return strtoupper($centre['name']);
    }

    public function fnAssignParties(){
        return $this->belongsToMany('App\PoliticalParty', 'pivot_election_party')
                ->where("state_id", "=", config('constants.ACTIVE_STATE_ID'))
                ->orderBy("code")
                ->select(["political_parties.*"]);
    }

    public function fnApprovedPasscodes() {
        $passcodes = \DB::table("pivot_election_users_passcode")
                ->where("state_id","=",config('constants.ACTIVE_STATE_ID'))
                ->where("election_id","=",$this->id);

        return $passcodes;
    }

    public function fnPollingUnits(){
        // return $this->belongsToMany('App\PollingStation','pivot_election_polling_units')
        //         ->where("pivot_election_polling_units.state_id", "=", config('constants.ACTIVE_STATE_ID'))
        //         ->where("pivot_election_polling_units.election_id", "=", $this->id);
        //         // ->orderBy("name")
        //         // ->select(["polling_stations.*"]);
        $polling_list = \DB::table("pivot_election_polling_units")
                ->where("pivot_election_polling_units.state_id", "=", config('constants.ACTIVE_STATE_ID'))
                ->where("pivot_election_polling_units.election_id", "=", $this->id);

        return $polling_list;
    }


    public function get_polling_result(){
       $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
       $code = $ElectionCode['election_code'];
    //    return $this->belongsToMany('App\PollingStation',"polling_result_$code")
    //                 ->where("polling_result_$code.state_id","=",config('constants.ACTIVE_STATE_ID'))
    //                 ->where("polling_result_$code.election_id","=",$this->id)
    //                 ->orderBy("name")
    //                 ->select(["polling_stations.*"]);
        
        $parties = \DB::table("polling_result_$code")
                        ->where("state_id","=",config('constants.ACTIVE_STATE_ID'))
                        ->where("election_id","=",$this->id);
        
        return $parties;
    }
}
