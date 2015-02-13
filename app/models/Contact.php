<?php

class Contact extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
      'first_name'       => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = array(
                           'first_name',
                           'middle_name',
                           'last_name',
                           'title',
                           'suffix',
                           'initials',
                           'web_page',
                           'gender',
                           'birthday',
                           'anniversary',
                           'location',
                           'language',
                           'internet_free_busy',
                           'notes',
                           'e_mail_address',
                           'e_mail_2_address',
                           'e_mail_3_address',
                           'primary_phone',
                           'home_phone',
                           'home_phone_2',
                           'mobile_phone',
                           'pager',
                           'home_fax',
                           'home_address',
                           'home_street',
                           'home_street_2',
                           'home_street_3',
                           'home_address_po_box',
                           'home_city',
                           'home_state',
                           'home_postal_code',
                           'home_country',
                           'spouse',
                           'children',
                           'managers_name',
                           'assistants_name',
                           'referred_by',
                           'company',
                           'company_main_phone',
                           'business_phone',
                           'business_phone_2',
                           'business_fax',
                           'assistants_phone',
                           'job_title',
                           'department',
                           'office_location',
                           'organizational_id_number',
                           'profession',
                           'account',
                           'business_address',
                           'business_street',
                           'business_street_2',
                           'business_street_3',
                           'business_address_po_box',
                           'business_city',
                           'business_state',
                           'business_postal_code',
                           'business_country',
                           'other_phone',
                           'other_fax',
                           'other_address',
                           'other_street',
                           'other_street_2',
                           'other_street_3',
                           'other_address_po_box',
                           'other_city',
                           'other_state',
                           'other_postal_code',
                           'other_country',
                           'callback',
                           'car_phone',
                           'isdn',
                           'radio_phone',
                           'ttytdd_phone',
                           'telex',
                           'user_1',
                           'user_2',
                           'user_3',
                           'user_4',
                           'keywords',
                           'mileage',
                           'hobby',
                           'billing_information',
                           'directory_server',
                           'sensitivity',
                           'priority',
                           'private',
                           'categories'
                        );


   public static function boot()
   {
      parent::boot();

      // Setup event bindings...
      Contact::saved(function($contact)
      {
         // echo 'contact saved!';
         // exit;
      });
   }


}