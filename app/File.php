<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
   public function news()
   {
      return $this->belongsTo(News::class);
   }
}
