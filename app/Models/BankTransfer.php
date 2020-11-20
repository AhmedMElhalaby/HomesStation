<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class BankTransfer extends Model
{
    protected $fillable = ['user_id', 'bank_name', 'owner_account', 'account_number', 'amount_of_transfer', 'type', 'type_id', 'image'];

    protected $appends = ['image200', 'image400', 'image600'];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function setImageAttribute($value)
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != '') {
            if (file_exists(storage_path('app/uploads/bank_transfer/org' . "/" . $this->attributes['image']))) {
                ImageController::delete_image_from_folder($this->attributes['image'], 'app/uploads/bank_transfer');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/bank_transfer');
        $this->attributes['image'] = $filename;
    }

    public function getImage200Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/bank_transfer/200' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/bank_transfer/200') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage400Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/bank_transfer/400' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/bank_transfer/400') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage600Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/bank_transfer/600' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/bank_transfer/600') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function Subscription()
    {
        return $this->belongsTo(Subscription::class, 'type_id');
    }
}
