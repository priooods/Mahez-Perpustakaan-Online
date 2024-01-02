<?php

namespace App\Models\category;

use App\Models\UserTab;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCategoryTab extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_tabs_id',
        'title',
    ];

    public function user()
    {
        return $this->hasOne(UserTab::class,'id','user_tabs_id');
    }

    public function getCreatorAttribute(){
        return $this->user->fullname;
    }

    public function scopeFilter($query, $user){
        if($user->m_access_tabs_id > 1){
            $query->where('user_tabs_id', $user->id)
            ->latest();
        }
        $query->latest();
        return $query;

    }
}
