<?php

namespace App\Models\book;

use App\Models\category\MCategoryTab;
use App\Models\UserTab;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBookTab extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_tabs_id',
        'title',
        'm_category_tabs_id',
        'description',
        'count',
        'book_file',
        'book_cover',
    ];

    public function user()
    {
        return $this->hasOne(UserTab::class,'id','user_tabs_id');
    }
    public function category()
    {
        return $this->hasOne(MCategoryTab::class,'id','m_category_tabs_id');
    }

    public function getDetailCategoryAttribute(){
        return $this->category->title;
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
