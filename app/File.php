<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
   protected $fillable = [
      'titulo', 'link', 'tipo', 'news_id'
   ];

   public function news()
   {
      return $this->belongsTo(News::class);
   }
}
