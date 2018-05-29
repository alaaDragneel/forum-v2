<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * $guarded
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * $casts
     *
     * @var array
     */
    protected $casts = ['archived' => 'boolean'];
    
    /**
     * Get The Route key Name For Laravel
     * @return string
     */
    public function getRouteKeyName ()
    {
        return 'slug';
    }


    /**
     * threads
     *
     * @return HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class, 'channel_id');
    }

    /**
     * archived
     *
     * @return void
     */
    public function archived(): void
    {
       $this->update([ 'archived' => true ]); 
    }
    
    /**
     * active
     *
     * @return void
     */
    public function active(): void
    {
       $this->update([ 'archived' => false ]); 
    }
    
    public function isArchived()
    {
        return $this->archived;
    }
}
