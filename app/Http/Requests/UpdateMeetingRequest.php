<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title"=>"required",
            "organiser_id"=>"required",
            "secretary_id"=>"required",
            "date"=>"required",
            "end_date"=>"required",
            "time"=>"required",
            "end_time"=>"required",
            "venue"=>"required"
        ];
    }
}
