<?php

    namespace Delos\Dgp\Entities;

    use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
    use Illuminate\Database\Eloquent\Model;
    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;

    /**
     * Class CoastUser.
     *
     * @package namespace Delos\Dgp\Entities;
     */
    class CoastUser extends Model implements Transformable
    {
        use TransformableTrait, RelationshipsTrait;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'date',
            'value'
        ];

        /**
         * @var array
         */
        protected $casts = [
            'user_id' => 'integer',
            'value'   => 'float'
        ];

        /**
         * @var array
         */
        protected $dates = [
            'date'
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function getValueAttribute()
        {
            $float = $this->attributes['value'];

            if ( strpos($float, 'R$ ') !== false ) {
                $float           = str_replace('R$ ', '', $float);
                $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
                $float           = $numberFormatter->parse($float);
            }

            $formattedNumber = number_format($float, 2, ',', '.');

            return $formattedNumber;
        }

        public function setValueAttribute($value)
        {
            $float                     = str_replace('R$ ', '', $value);
            $numberFormatter           = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
            $float                     = $numberFormatter->parse($float);
            $this->attributes['value'] = $float;
        }
    }
