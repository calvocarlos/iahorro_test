<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MortgageExpert
 *
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $first_name
 * @property string $last_name
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read \App\Models\MortgageApplication[] $mortgage_applications
 */
class MortgageExpert extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mortgage_applications()
    {
        return $this->hasMany(MortgageApplication::class);
    }

    /**
     * Others
     */

    /**
     * Get an array with the Ids of the mortgage experts
     *
     * @return mixed
     */
    public static function getMortgageExpertIds()
    {
        return static::pluck('id');
    }
}
