<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MortgageApplication
 *
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 *
 * @property double $net_income
 * @property double $requested_amount
 *
 * @property integer $mortgage_expert_id
 * @property Carbon $assignment_date
 * @property double $scoring
 *
 * @property integer $start_time_slot
 * @property integer $end_time_slot
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read \App\Models\MortgageExpert $mortgage_expert
 */
class MortgageApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone_number', 'net_income', 'requested_amount',
        'mortgage_expert_id', 'assignment_date',
        'scoring',
        'start_time_slot', 'end_time_slot'
    ];

    protected $dates = ['assignment_date'];

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mortgage_expert()
    {
        return $this->belongsTo(MortgageExpert::class);
    }

    /**
     * Calculate the scoring of a mortgage application
     *
     * @return float
     */
    public function getScoringAttribute()
    {
        return round(($this->requested_amount / $this->net_income) * now()->diffInRealHours($this->created_at), 2);
    }

    /**
     * Get the mortgage applications that are not assigned to a mortgage expert
     *
     * @return \App\Models\MortgageApplication|null
     */
    public static function getMortgageApplicationsNotAssigned()
    {
        return static::whereNull('mortgage_expert_id')->get();
    }

    /**
     * Assign randomly a mortgage application to a mortgage expert
     */
    public static function assignMortgageApplicationsToMortgageExperts()
    {
        $mortgage_experts = MortgageExpert::getMortgageExpertIds();
        $mortgage_applications = self::getMortgageApplicationsNotAssigned();
        /** @var \App\Models\MortgageApplication $mortgage_application */
        foreach ($mortgage_applications as $mortgage_application) {
            $mortgage_application->assignExpert($mortgage_experts->random());
        }
    }

    /**
     * Assign a mortgage expert to a mortgage application
     *
     * @param  int  $mortgage_expert_id
     */
    private function assignExpert(int $mortgage_expert_id)
    {
        $this->mortgage_expert_id = $mortgage_expert_id;
        $this->assignment_date = now();
        $this->save();
    }

    /**
     * Get the mortgage applications given a a mortgage expert Id
     *
     * @param  int  $mortgage_expert_id
     * @return \App\Models\MortgageApplication|null
     */
    public static function getMortgageApplicationsByMortgageExpertId(int $mortgage_expert_id)
    {
        return static::where('mortgage_expert_id', $mortgage_expert_id)->get();
    }

    /**
     * Check if the mortgage application is in the time slot
     *
     * @return bool
     */
    public function isInTimeSlot()
    {
        return now()->between(now()->startOfDay()->setHour($this->start_time_slot), now()->endOfDay()->setHour($this->end_time_slot));
    }
}
