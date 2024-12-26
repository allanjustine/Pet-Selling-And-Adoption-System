<?php 

namespace App\Traits;

trait HasAvatar {

    // ============================== Accessor & Mutator ==========================================

     public function getAvatarProfileAttribute()
     {
         return $this->getFirstMedia('avatar_image')?->getUrl('avatar');
     }
     
     public function getAvatarThumbnailAttribute()
     {
         return $this->getFirstMedia('avatar_image')?->getUrl('thumbnail');
     }
}