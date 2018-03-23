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
        return $this->belongsToMany('App\PoliticalParty', 'pivot_election_parties')
                ->orderBy("code")
                ->select(["political_parties.*"]);
    }

    public function fnPollingUnits(){
        $polling_list = \DB::table("election_onetime_passwords")->where("election_id", "=", $this->id);

        return $polling_list;
    }


    public function get_polling_result($type,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null){
        if($type == 'general'){
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_".$code."_results")->where("election_id","=",$this->id);
            
            return $result;
        }

        if($type == 'state'){
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_".$code."_results")
                            ->where("state_id","=",$state_id)
                            ->where("election_id","=",$this->id);
            
            return $result;
        }

        if($type == 'local'){
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_".$code."_results")
                            ->where("election_id","=",$this->id)
                            ->where("state_id","=",$state_id)
                            ->where("constituency_id","=",$const_id)
                            ->where("lga_id","=",$lga_id);  
            
            return $result;
        }

        if($type == 'constituency') {
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_".$code."_results")
                            ->where("state_id","=",$state_id)
                            ->where("constituency_id","=",$const_id)
                            ->where("election_id","=",$this->id);
            
            return $result;
        }

        if($type == 'ward') {
            $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
            $code = $ElectionCode['election_code'];
            $result = \DB::table("polling_".$code."_results")
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
            $result = \DB::table("polling_".$code."_results")
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

        //querying result based on presidency level
        if($type == 'general'){
            $result = $this->get_polling_result('general')->get();

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

    public function get_latest_submitted_result() {
        $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
        $code = $ElectionCode['election_code'];
        $result = \DB::table("polling_".$code."_results")->where("election_id","=",$this->id)->where("step","=",2)->first();
        
        return $result;
    }

    public function get_all_total_result(){
        $Ret = [];
        $ElectionCode = ElectionResultIndex::where('election_id','=',$this->id)->first();
        $code = $ElectionCode['election_code'];
        $result = \DB::table("polling_".$code."_results")->where("election_id","=",$this->id)->get();
        
        $parties = $this->fnAssignParties()->get();
        foreach($parties as $i => $party) {
            $code = strtolower($party['code']);
            $Ret[$code] = 0;
        }

        foreach($result as $k => $val){
            foreach($parties as $i => $party) {
                $code = strtolower($party['code']);
                $Ret[$code] += (int)$val->$code;
            }
        }
        return $Ret;
    }
}
