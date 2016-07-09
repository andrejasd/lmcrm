<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SphereMask extends Model
{
    protected $table = NULL;
    private $userID = NULL;

    public $tableDB = NULL;
    public $timestamps = false;

    public function __construct($id = NULL, $userID = NULL, array $attributes = array())
    {
        $this->table = 'sphere_bitmask_'.(int)$id;
        if ($id && !DB::getSchemaBuilder()->hasTable($this->table)) {
            DB::statement('CREATE TABLE IF NOT EXISTS `' . $this->table . '`(`id` INT NOT NULL AUTO_INCREMENT, `user_id` BIGINT NOT NULL, `type` ENUM( \'agent\', \'lead\' ) NOT NULL DEFAULT \'agent\' , `status` TINYINT(1) DEFAULT 0, `lead_price` FLOAT NULL,`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`))', []);
            DB::statement('ALTER TABLE `'.$this->table.'` ADD UNIQUE (`user_id`)');
        }
        $this->tableDB = DB::table($this->table);
        if($userID) { $this->userID=$userID; }

        parent::__construct($attributes);

        return $this->table;
    }

    private  function changeTable($id){
        $this->table = 'sphere_bitmask_'.(int)$id;
        $this->tableDB = DB::table($this->table);
        return $this->tableDB;
    }

    public function query_builder(){
        return $this->tableDB;
    }

    public function getTableName(){
        return $this->table;
    }

    public function setUserID($user_id){
        $this->userID = (int)$user_id;
        return true;
    }

    public function getStatus($user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        return $this->tableDB->where('user_id','=',$user_id)->first();
    }

    public function setStatus($status=0,$user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        return $this->tableDB->where('user_id','=',$user_id)->update(['status'=>$status]);
    }

    public function getPrice($user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        return $this->tableDB->where('user_id','=',$user_id)->first();
    }
    public function setPrice($val=0,$user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        return $this->tableDB->where('user_id','=',$user_id)->update(['lead_price'=>$val]);
    }

    public function findMask($user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        return $this->tableDB->where('user_id','=',$user_id);
    }
    
    public function setType($val='agent',$user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        return $this->tableDB->where('user_id','=',$user_id)->update(['type'=>$val]);
    }

    public function obtain($type='lead',$user_id=NULL){
        $user_id = ($user_id)?(int)$user_id:$this->userID;
        $attributes = $this->attributes();
        $list = DB::table(DB::raw('`'.$this->table.'` as `t1`'))->join(DB::raw('`'.$this->table.'` as `t2`'),function($join) use ($attributes){
                foreach($attributes as $attr){
                    if(stripos($attr,'fb_')!==false) {
                        $join->on('t1.'.$attr,'>=','t2.'.$attr);
                    }
                }
            })
            ->where('t1.user_id','=',$user_id)
            ->where('t1.status','=','1')
            ->where('t2.type','=',$type)
            ->where('t2.user_id','<>',$user_id) ///??? need refactoring
            ->select('t2.*');
        return $list;
    }

    public function findShortMask($user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        $short_mask=array();
        $mask = $this->tableDB->where('user_id','=',$user_id)->first();
        if(!$mask) { return $short_mask; }
        $mask=get_object_vars($mask);
        foreach($mask as $field=>$val){
            if(stripos($field,'fb_')!==false){
                $short_mask[preg_replace('/^fb_[\d]+_/','',$field)]=$val;
            }
        }
        return $short_mask;
    }

    public function findSphereMask($sphere_id,$user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        $this->changeTable($sphere_id);
        return $this->findMask($user_id);
    }

    public function setAttr($opt_index,$user_id=NULL){
        $user_id = ($user_id)?$user_id:$this->userID;
        if (is_array($opt_index)) {
            $values = array();
            $mask = $this->tableDB->where('user_id','=',$user_id)->first();
            if($mask) {
                $values['id']=$mask->id;
            } else {
                $values['id'] = $this->tableDB->insertGetId(['user_id'=>$user_id]);
            }
            $attributes = $this->attributesAssoc();
            foreach($attributes as $field=>$index) {
                $values[$field]=(in_array($index,$opt_index))?1:0;
            }
            $test=$values;
            $this->tableDB->update($values);
        }
        return $this->tableDB;
    }
    /* ---------------------------------- Table links ---------------------------------- */

    public function lead() {
        return $this->hasOne('\App\Models\Lead','id','user_id');
    }

    public function agent() {
        return $this->hasOne('\App\Models\Agent','id','user_id');
    }

    /* ---------------------------------- Table structure ---------------------------------- */

    public function attributes() {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    public function attributesAssoc() {
        $attributes = DB::getSchemaBuilder()->getColumnListing($this->table);
        $indexes= array();
        foreach($attributes as $field){
            if(stripos($field,'fb_')!==false){
                $indexes[$field]=preg_replace('/^fb_[\d]+_/','',$field);
            }
        }
        return $indexes;
    }

    public function addAttr($group_index,$opt_index){
        if(is_array($opt_index)) {
            foreach($opt_index as $aVal) $this->addAttr($group_index,$aVal);
        } else {
            $index = implode('_', ['fb', $group_index, $opt_index]);
            if (!in_array($index, $this->attributes())) {
                DB::statement('ALTER TABLE `' . $this->table . '` ADD COLUMN `' . $index . '` TINYINT(1) NULL', []);
            }
        }
        return $this->tableDB;
    }

    public function removeAttr($group_index,$opt_index){
        if(is_array($group_index) && $opt_index==null) {
            foreach($group_index as $item) {
                $delAttr = preg_grep("/^fb_" . $item . "_.*/", $this->attributes());
                foreach($delAttr as $item) {
                    DB::statement('ALTER TABLE `' . $this->table . '` DROP COLUMN `' . $item . '', []);
                }
            }
        } else {
            if (is_array($opt_index)) {
                foreach ($opt_index as $aVal) $this->removeAttr($group_index, $aVal);
            } else {
                $index = implode('_', ['fb', $group_index, $opt_index]);
                if (in_array($index, $this->attributes())) {
                    DB::statement('ALTER TABLE `' . $this->table . '` DROP COLUMN `' . $index . '', []);
                }
            }
        }
        return $this->tableDB;
    }

    public function setDefault($index=0, $hash=false, $force=false){
        if($index==0 || !is_array($hash)) { return false; }
        foreach($hash as $id=>$val) {
            $fname = implode('_', ['fb', $index, $id]);
            $this->tableDB->where($fname,NULL)->update([$fname=>1]);
        }
        return $this->tableDB;
    }

    public function _delete() {
        //return $this->tableDB->drop();
        return DB::delete('DROP TABLE `'.$this->table.'`');
    }

    public function getAppends() {

        return $this->hasOne();
    }

    public function copyAttr($group_index,$new_opt_index,$parent_opt_index){
        DB::statement('UPDATE `'.$this->table.'` SET `'.implode('_', ['fb', $group_index, $new_opt_index]).'`=`'.implode('_', ['fb', $group_index, $parent_opt_index]).'` WHERE 1');
        return $this->tableDB;
    }
}