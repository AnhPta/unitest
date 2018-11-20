<?php

namespace App\Repositories\Branches;

trait FilterTrait
{
	/**
	 * Tìm kiếm theo tên, email, điện thoại, địa chỉ, website, mã số thuế, ngân hàng
	 * @param  [type] $query [description]
	 * @param  string $q     name, email, phone, address, website, tax_number, bank
	 * @return Collection Branch Model
	 */
	public function scopeQ($query, $q)
	{
		if ($q) {
			return $query->where('name', 'like', "%${q}%")
			->orWhere('email', 'like', "%${q}%")
			->orWhere('phone', 'like', "%${q}%")
			->orWhere('address', 'like', "%${q}%")
			->orWhere('website', 'like', "%${q}%")
			->orWhere('tax_number', 'like', "%${q}%")
			->orWhere('bank', 'like', "%${q}%");
		}
		return $query;
	}

	/**
	 * Tìm kiếm theo thành phố
	 * @param  [type] $query  	[description]
	 * @param  int    $cityId 	city_id
	 * @return Collection Branch Model
	 */
	// public function scopeCityID($query, $cityId)
	// {
	// 	if (is_numeric($cityId)) {
	// 		return $query->where('city_id', $cityId);
	// 	}
	// 	return $query;
	// }

	/**
	 * Tìm kiếm theo quận/huyện
	 * @param  [type] $query      	  [description]
	 * @param  int    $districtId 	  district_id
	 * @return Collection Branch Model
	 */
	// public function scopeDistrictID($query, $districtId)
	// {
	// 	if (is_numeric($districtId)) {
	// 		return $query->where('district_id', $districtId);
	// 	}
	// 	return $query;
	// }
}
