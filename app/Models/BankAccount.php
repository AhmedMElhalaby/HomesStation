<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';

    protected $fillable = ['bank_name', 'owner_account', 'account_number', 'logo_bank'];

    protected $appends = ['logo_bank200', 'logo_bank400', 'logo_bank600'];

    public function delete()
    {
        if (isset($this->attributes['logo_bank']) && $this->attributes['logo_bank'] != '') {
            if (file_exists(storage_path('app/uploads/bank_account/org' . "/" . $this->attributes['logo_bank']))) {
                ImageController::delete_image_from_folder($this->attributes['logo_bank'], 'app/uploads/bank_account');
            }
        }
        parent::delete();
    }

    public function setLogoBankAttribute($value)
    {
        if (isset($this->attributes['logo_bank']) && $this->attributes['logo_bank'] != '') {
            if (file_exists(storage_path('app/uploads/bank_account/org' . "/" . $this->attributes['logo_bank']))) {
                ImageController::delete_image_from_folder($this->attributes['logo_bank'], 'app/uploads/bank_account');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/bank_account');
        $this->attributes['logo_bank'] = $filename;
    }

    public function getLogoBank200Attribute()
    {
        if ($this->attributes['logo_bank'] != "") {
            if (!file_exists(storage_path('app/uploads/bank_account/200' . "/" . $this->attributes['logo_bank']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/bank_account/200') . '/' . $this->attributes['logo_bank'];
        } else {
            return asset('storage/uploads/default.png');
        }
    }

    public function getLogoBank400Attribute()
    {
        if ($this->attributes['logo_bank'] != "") {
            if (!file_exists(storage_path('app/uploads/bank_account/400' . "/" . $this->attributes['logo_bank']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/bank_account/400') . '/' . $this->attributes['logo_bank'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getLogoBank600Attribute()
    {
        if ($this->attributes['logo_bank'] != "") {
            if (!file_exists(storage_path('app/uploads/bank_account/600' . "/" . $this->attributes['logo_bank']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/bank_account/600') . '/' . $this->attributes['logo_bank'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
