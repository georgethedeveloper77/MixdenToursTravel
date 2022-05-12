<?php
/**
 * Created by PhpStorm.
 * User: h2 gaming
 * Date: 8/9/2019
 * Time: 11:56 PM
 */

namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;

class InboxMessage extends BaseModel
{
    protected $table = 'core_inbox_messages';

    protected $fillable = ['from_user', 'to_user', 'content', 'inbox_id'];

    public function save(array $options = [])
    {
        $isInsert = $this->id == false ? true : false;

        $res = parent::save($options); // TODO: Change the autogenerated stub

        if ($res && $isInsert) {
            $noti = new Notification();
            $noti->fillByAttr(['from_user', 'to_user', 'is_read', 'type', 'type_group', 'target_id', 'target_parent_id'], [
                'from_user' => $this->from_user,
                'to_user' => $this->to_user,
                'is_read' => 0,
                'type' => 'create',
                'type_group' => 'inbox',
                'target_id' => $this->id,
                'target_parent_id' => $this->inbox_id,
            ]);
            $noti->save();
        }

        return $res;
    }

    public function getLastUpdatedTextAttribute()
    {
        return human_time_diff_short(strtotime($this->created_at));
    }

    public function jsData()
    {
        return [
            "id" => $this->id,
            "content" => $this->content,
            'last_updated_text' => $this->last_updated_text,
            'created_at' => strtotime($this->created_at),
            "me" => Auth::id() == $this->from_user ? true : false,
            'is_read' => $this->is_read
        ];
    }
}
