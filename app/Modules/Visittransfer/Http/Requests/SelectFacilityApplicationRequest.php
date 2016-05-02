<?php
namespace App\Modules\Visittransfer\Http\Requests;

use App\Models\Mship\Account\State;
use App\Modules\Visittransfer\Models\Application;
use App\Modules\Visittransfer\Models\Facility;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SelectFacilityApplicationRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"facility_id" => "required|exists:vt_facility,id",
			"permitted" => "accepted",
		];
	}

	/**
	 * Get the messages that are displayed when a validation rule fails.
	 *
	 * @return array
	 */
	public function messages(){
		return [
			"facility_id.required" => "You have chosen an invalid facility.",
			"permitted.accepted" => "You are not permitted to apply to this facility.",
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Gate::allows("select-facility", Auth::user()->visitTransferCurrent());
	}

	protected function getValidatorInstance(){
		$data = $this->all();
		$data['permitted'] = true;


		$facility = Facility::find(array_get($data, "facility_id", null));

		if(!$facility->training_required && Auth::user()->visitTransferCurrent()->is_transfer){
			$data['permitted'] = false;
		}

		if($facility->training_spaces < 1){
			$data['permitted'] = false;
		}

		$this->getInputSource()->replace($data);

		return parent::getValidatorInstance();
	}
}
