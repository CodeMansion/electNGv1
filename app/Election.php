<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date',
    ];

    public static function isElectionExists($field){
        $data = self::where('name',$field)->first();
        if($data){
            return true;
        }
        return false;
    }

    public function status(){
        return $this->belongsTo('App\ElectionStatus','election_status_id');
    }

    public function types(){
        return $this->belongsTo('App\ElectionType', 'election_type_id');
    }

    public function setNameAttribute($value) {
        return $this->attributes['name'] = ucfirst($value);
    }

    public static function find($id,$field=null){
        if($field){
            return self::where($field,$id)->firstOrFail();
        }
        return self::where('id',$id)->firstOrFail();
    }

    public function entries() {
        return $this->hasMany('App\ElectionEntry', 'election_id');
    }

    public function passcodes() {
        return $this->hasMany('App\ElectionPasscode', 'election_id');
    }

    public function parties(){
        return $this->belongsToMany('App\PoliticalParty', 'election_parties')
            ->orderBy("code")
            ->select(["political_parties.*"]);
    }

    public function fnPollingUnits(){
        $polling_list = \App\ElectionPasscode::where("election_id", "=", $this->id);
        return $polling_list;
    }


    public function getResult($type,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$station_id=null){
        if($type == 'general'){
            $result = ElectionEntry::where("election_id","=",$this->id)->get();

            return $result;
        }

        if($type == 'state'){
            $result = ElectionEntry::where([
                "election_id"   => $this->id,
                "state_id"      => $state_id
            ])->get();    

            return $result;
        }

        if($type == 'local'){
            $result = ElectionEntry::where([
                "election_id"       => $this->id,
                "state_id"          => $state_id,
                "constituency_id"   => $const_id,
                "lga_id"            => $lga_id
            ])->get(); 

            return $result;
        }

        if($type == 'constituency') {
            $result = ElectionEntry::where([
                "election_id"       => $this->id,
                "state_id"          => $state_id,
                "constituency_id"   => $const_id
            ])->get();
            
            return $result;
        }

        if($type == 'ward') {
            $result = ElectionEntry::where([
                "election_id"       => $this->id,
                "state_id"          => $state_id,
                "constituency_id"   => $const_id,
                "lga_id"            => $lga_id,
                "ward_id"           => $ward_id
            ])->get();
            
            return $result;
        }

        if($type == 'polling-station') {
            $result = ElectionEntry::where([
                "election_id"           => $this->id,
                "state_id"              => $state_id,
                "constituency_id"       => $const_id,
                "lga_id"                => $lga_id,
                "ward_id"               => $ward_id,
                "polling_station_id"    => $station_id
            ])->get();
            
            return $result;
        }
    }

    public function getResultEntry($type,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null)
    {
        $Ret = [];
        $party_accumulator = [];
        $parties = $this->parties()->get();

        //looping through the parties to get individual party first
        foreach($parties as $party) {
            $code = $party['code'];
            $Ret[$code] = 0;
        }

        //querying result based on presidency level
        if($type == 'general'){
            $result = $this->getResult('general');
            
            foreach($result as $k => $val){
                foreach($parties as $party) {
                    if($val['political_party_id'] == $party['id']) {
                        $party_accumulator[$k] = $party['votes'];
                        $Ret[$code] = array_sum($party_accumulator);
                    }
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
        $result = $this->getResult('general');
        $parties = $this->parties()->get();
        foreach($parties as $party) {
            $code = $party['code'];
            $Ret[$code] = 0;
        }

        foreach($parties as $i => $party) {
            foreach($result as $k => $val){
                if($val['party_code'] == $party['code']) {
                    $Ret[$party['code']] += (int)$val['votes'];
                }
            }
        }

        return $Ret;
    }
}
