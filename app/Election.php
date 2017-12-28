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

    public function Types(){
        return $this->belongsTo(ElectionType::class);
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

    public function fnAssignParties(){
        return $this->belongsToMany('App\PoliticalParty', 'pivot_election_party')
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
        $polling_list = \DB::table("pivot_election_polling_units")
                // ->where("pivot_election_polling_units.state_id","=",1)
                ->where("pivot_election_polling_units.election_id", "=", $this->id);

        return $polling_list;
    }


    public function get_polling_result($type,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null){
        if($type == 'state'){
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_result_$code")
                            ->where("state_id","=",$state_id)
                            ->where("election_id","=",$this->id);
            
            return $result;
        }

        if($type == 'local'){
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_result_$code")
                            ->where("election_id","=",$this->id)
                            ->where("state_id","=",$state_id)
                            ->where("constituency_id","=",$const_id)
                            ->where("lga_id","=",$lga_id);  
            
            return $result;
        }

        if($type == 'constituency') {
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_result_$code")
                            ->where("state_id","=",$state_id)
                            ->where("constituency_id","=",$const_id)
                            ->where("election_id","=",$this->id);
            
            return $result;
        }

        if($type == 'ward') {
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_result_$code")
                            ->where("state_id","=",$state_id)
                            ->where("constituency_id","=",$const_id)
                            ->where("lga_id","=",$lga_id)
                            ->where("ward_id","=",$ward_id)
                            ->where("election_id","=",$this->id);
            
            return $result;
        }

        if($type == 'polling-station') {
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_result_$code")
                            ->where("state_id","=",$state_id)
                            ->where("lga_id","=",$lga_id)
                            ->where("ward_id","=",$ward_id)
                            ->where("polling_station_id","=",$unit_id)
                            ->where("election_id","=",$this->id);
            
            return $result;
        }
    }

    public function get_result_summary($type,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null)
    {
        $Ret = [];

        //getting the parties involved in the election
        $parties = $this->fnAssignParties()->get();

        //looping through the parties to get individual party first
        foreach($parties as $i => $party) {
            $code = strtolower($party['code']);
            $Ret[$code] = 0;
        }

        //querying result based on state level
        if($type == 'state'){
            $result = $this->get_polling_result('state',$state_id)->get();

            //looping through the result to able to calculate total for each parties 
            //under this election
            foreach($result as $k => $val){
                foreach($parties as $i => $party) {
                    $code = strtolower($party['code']);
                    $Ret[$code] += (int)$val->$code;
                }
            }

            return $Ret;  
        }
        
        //querying result based on constituency level
        if($type == 'constituency'){
            $result = $this->get_polling_result('constituency',$state_id,$const_id)->get();

            //looping through the result to able to calculate total for each parties 
            //under this election
            foreach($result as $k => $val){
                foreach($parties as $i => $party) {
                    $code = strtolower($party['code']);
                    $Ret[$code] += (int)$val->$code;
                }
            }
            return $Ret;  
        }
        
        //querying result based on local govt level
        if($type == 'local'){
            $result = $this->get_polling_result('local',$state_id,$const_id,$lga_id)->get();

            //looping through the result to able to calculate total for each parties 
            //under this election
            foreach($result as $k => $val){
                foreach($parties as $i => $party) {
                    $code = strtolower($party['code']);
                    $Ret[$code] += (int)$val->$code;
                }
            }
            return $Ret;  
        }

        //querying result based on ward level
        if($type == 'ward'){
            $result = $this->get_polling_result('ward',$state_id,$const_id,$lga_id,$ward_id)->get();

            //looping through the result to able to calculate total for each parties 
            //under this election
            foreach($result as $k => $val){
                foreach($parties as $i => $party) {
                    $code = strtolower($party['code']);
                    $Ret[$code] += (int)$val->$code;
                }
            }
            return $Ret;  
        }

         //querying result based on polling units level
        if($type == 'polling-station'){
            $result = $this->get_polling_result('polling-station',$state_id,$lga_id,$ward_id,$unit_id)->get();

            //looping through the result to able to calculate total for each parties 
            //under this election
            foreach($result as $k => $val){
                foreach($parties as $i => $party) {
                    $code = strtolower($party['code']);
                    $Ret[$code] += (int)$val->$code;
                }
            }
            return $Ret;  
        }
    }
}
