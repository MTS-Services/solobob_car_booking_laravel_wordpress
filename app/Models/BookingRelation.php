<?php

namespace App\Models;

use App\Models\BaseModel;

class BookingRelation extends BaseModel
{
    protected $fillable = [
        'booking_id',
        'billing_information_id',
        'residential_address_id',
        'parking_address_id',
        'user_document_id',
        'signature_path',
        'terms_accepted',
        'sms_alerts',
        'terms_accepted_at',
        'same_as_residential',
        'rental_range',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'sms_alerts' => 'boolean',
        'same_as_residential' => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    /* ================================================================
     * *** RELATIONS ***
     ================================================================ */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function billingInformation()
    {
        return $this->belongsTo(BillingInformation::class, 'billing_information_id', 'id');
    }

    public function residentialAddress()
    {
        return $this->belongsTo(Addresse::class, 'residential_address_id', 'id');
    }

    public function parkingAddress()
    {
        return $this->belongsTo(Addresse::class, 'parking_address_id', 'id');
    }

    public function userDocument()
    {
        return $this->belongsTo(UserDocuments::class, 'user_document_id', 'id');
    }
}