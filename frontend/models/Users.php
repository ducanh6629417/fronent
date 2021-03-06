<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for collection "users".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $id
 * @property mixed $user_name
 * @property mixed $user_email
 */
class Users extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['thebank_db', 'users'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id',
			'user_pass',
			'user_email',
			'display_name',
			'province_id',
			'acc_type',
			'phone',
			'service_type',
			'year_experience',
			'company_name',
			'repeat_password',
			'is_active',
			'avatar',
			'currentPassword',
			'user_name',
			'verifyCode',
			'buyer_counseling_service',
			'is_user_backend',
			'working_position',
			'working_at',
			'introduction_user',
			'company_drafts',
			'service_type_drafts',
			'company_branch_drafts',
			'working_position_drafts',
			'company_branch_name',
			'verify',
			'level',
			'backend_added',
			'user_registered',
			'register_from',
			'district_id',
			'district_name',
			'note',
			'source',
			'company_id',
			'company_branch',
			'promos_code_in',
			'promos_code_out',
			'moved_money',
			'complete_distributing_email',
			'status_supplier',
			'ga_source',
			'ga_referer',
			'ga_campaign',
			'user_approved',
			'compensation',
			'total_customer_distributed',
			'information_classifieds',
			'branch_samo_id',
			'type_management',
			'branch_management',
			'is_banned',
			'is_partners',
			'is_branch_organzine',
			'date_drafts',
			'point_rank',
			'user_point',
			'partner_code',
			'source_id',
			'is_user_backend',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
			array('currentPassword,code_reset,display_name_drafts,phone_drafts,province_name_drafts,year_experience_drafts,introduction_complete,working_position_drafts, phone, user_pass, working_position, display_name, year_experience', 'required','message'=>'Nh???p {attribute}'),
			array('user_email', 'required', 'message' => 'Nh???p ?????a ch??? email'),
			array('repeat_password', 'required', 'message' => 'Nh???p l???i m???t kh???u'),
			array('user_name', 'required','message'=>'{attribute} kh??ng ???????c tr???ng <i style="border: 1px solid; border-radius: 50%; width: 13px; height: 13px; text-align: center; background-color: #2695D2; color: #fff;" class="fa fa-info" title="Ph???i l?? ti???ng vi???t kh??ng d???u, kh??ng ch???a kho???ng tr???ng.V?? d???: davidnguyen"></i>'),
			array('verifyCode', 'required','message'=>'Nh???p c??c k?? t??? trong ???nh trong ???nh.'),
			array('gender,province_id_drafts,district_id_drafts,acc_type,district_id,buyer_counseling_service,avatar,company_drafts,company_branch_drafts,service_type_drafts,company_branch, company_id, province_id','required', 'message'=> 'Ch???n {attribute}'),
			array('service_type', 'required', 'message' => 'Ch???n d???ch v???'),
			array('is_tba, province_id, acc_type, year_experience,phone,cmnd', 'numerical', 'integerOnly'=>true , 'message'=>'{attribute} ph???i l?? s???'),
			array('agree', 'required', 'requiredValue' => 1, 'message' => 'B???n ch??a ?????ng ?? v???i ch??ng t??i'),
			array('user_email', 'email', 'message' => '?????a ch??? email kh??ng h???p l???'),
			array('user_email,user_name,phone,phone_drafts,email_drafts', 'validateAttribute'),
			array('introduction_complete', 'validateSpace'),
			array('phone,phone_drafts', 'checkPhone'),
			array('code_reset', 'checkOTP'),
			array('birthday, ngaycap', 'checkBirthday'),
			array('year_experience,year_experience_drafts', 'checkYearEexperience'),
			array('currentPassword', 'checkChangePassword'),
			array('display_name, type_register,user_name,company_branch_name', 'length', 'max'=>255),
			array('phone,phone_drafts,birthday', 'length', 'max'=>20),
			array('branch_organzine_infomation,is_branch_organzine,facebook,twitter,linkedin,display_name_drafts,phone_drafts,province_id_drafts,province_name_drafts,district_id_drafts,district_name_drafts,year_experience_drafts,company_name,introduction_user_drafts,information_classifieds_drafts,electronic_signatures,partner_create,show_user,total_service_register,total_money,income,compare_product,promos_code_in,promos_code_out,sync_account,contact,chat,source,information_classifieds,district_name,district_id,buyer_counseling_service,complete_profile,register_from,list_user_send_email,backend_added,customer_interact,verify_update_info,user_point,user_rating,level,point_rating,send_customer_email,code_reset,date_reset_expire,view_customer_phone,certificate,is_organized,is_partners,currentPassword,social_id,verify,rating,introduction_user,working_position,province_name,company_branch_name,date_issued,place_issued', 'safe'),
			array('currentPassword', 'equalPasswords'),
			array('repeat_password', 'compare', 'compareAttribute'=>'user_pass', 'message'=>"M???t kh???u kh??ng gi???ng nhau"),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'message'=>'M?? b???o m???t kh??ng ????ng!'),
			array('user_name', 'length', 'min' => 6, 'max'=>20,
					'tooShort'=>Yii::t("translation", "{attribute} t??? 6 - 20 k?? t???."),
					'tooLong'=>Yii::t("translation", "{attribute} t??? 6 - 20 k?? t???.")),
			array(
				'user_name',
				'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_]/',
				'message' => 'Kh??ng ch???a k?? t??? c?? d???u ho???c k?? t??? ?????c bi???t.',
			),
			array('user_pass', 'length', 'min' => 6, 'max'=>30,
					'tooShort'=>Yii::t("translation", "{attribute} t??? 6 - 30 k?? t???."),
					'tooLong'=>Yii::t("translation", "{attribute} t??? 6 - 30 k?? t???.")),
			array('day,id, user_pass, user_email, user_registered, user_activation_key,buyer_counseling_service, user_status, display_name, role_id, type_register, social_id, province_id, acc_type, phone, service_type, year_experience, is_active', 'safe', 'on'=>'search'),

			array('phone', 'required', 'message' => 'Nh???p s??? ??i???n tho???i', 'on' => 'create_buyer'),
			array('customer_everyday', 'default', 'value'=> 0),
		    array('point_distributary', 'default', 'value'=> 500),
		    array('display_everyday', 'default', 'value'=> 0),
		    array('point_prioritize', 'default', 'value'=> 10),
		    array('total_display', 'default', 'value'=> 0),
		);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
			'id' => 'ID',
			'user_name' => 'T??n ????ng nh???p',
			'user_email' => 'Email',
			'user_pass' => 'M???t kh???u',
			'repeat_password' => 'Nh???p l???i m???t kh???u',
			'verifyCode' => 'M?? b???o m???t',
			'user_registered' => 'Ng??y ????ng k??',
			'user_activation_key' => 'ma kich hoat tai khoan',
			'user_status' => 'User Status',
			'display_name' => 'H??? v?? t??n',
			'display_name_drafts' => 'H??? v?? t??n',
			'role_id' => 'Role',
			'type_register' => 'Register on social , website',
			'social_id' => 'id social of user',
			'province_id' => 'Th??nh ph???',
			'province_id_drafts' => 'Th??nh ph???',
			'province_name_drafts' => 'Th??nh ph???',
			'acc_type' => 'L??nh v???c',
			'phone' => 'S??? ??i???n tho???i',
			'phone_drafts' => 'S??? ??i???n tho???i',
			'service_type' => 'T?? v???n d???ch v???',
			'service_type_drafts'=>'T?? v???n d???ch v???',
			'year_experience' => 'S??? n??m kinh nghi???m',
			'year_experience_drafts' => 'S??? n??m kinh nghi???m',
			'is_active' => 'tinh trang kich hoat tai khoan : 0 : chua / 1 : Da kich hoat',
			'avatar' => '???nh ?????i di???n',
			'rank' => 'diem tich luy',
			'company_id' => 'T??n doanh nghi???p',
			'company_name' => 'T??n doanh nghi???p',
			'company_branch' => 'L??m vi???c t???i chi nh??nh',
			'company_branch_drafts' => 'L??m vi???c t???i chi nh??nh',
			'verify' => 'Xac thuc tai khoan hay chua : 1 : Chua xac thuc / 2 : Da xac thuc',
			'company_drafts' => 'T??n doanh nghi???p',
			'is_change_drafts' => 'Is Change Drafts',
			'date_drafts' => 'Date Drafts',
			'is_superadmin' => 'Is Superadmin',
			'is_user_backend' => 'Co phai user trong backend khong?',
			'is_banned' => 'Banned user',
			'buyer_counseling_service' => 'C???n t?? v???n d???ch v???',
			'rating' => 'diem danh gia nguoi dung a;b',
			'introduction_user' => 'Gi???i thi???u k??? n??ng v?? kinh nghi???m l??m vi???c',
			'introduction_complete' => 'Gi???i thi???u k??? n??ng v?? kinh nghi???m l??m vi???c',
			'working_position' => 'V??? tr?? c??ng t??c',
			'working_position_drafts'=>'V??? tr?? c??ng t??c',
			'currentPassword'=>'M???t kh???u c??',
			'facebook'  => 'T??i kho???n Facebook',
			'twitter'   => 'T??i kho???n Twitter',
			'linkedin'  => 'T??i kho???n LinkedIn',
			'certificate' => 'B???ng c???p & Ch???ng ch???',
			'district_id'     => 'Qu???n/Huy???n',
			'district_id_drafts'     => 'Qu???n/Huy???n',
			'district_name'     => 'Qu???n/Huy???n',
			'information_classifieds' => 'Gi???i thi???u s???n ph???m ??ang t?? v???n',
			'electronic_signatures'	  => 'Ch??? k??',
			'birthday'	  => 'Ng??y sinh',
			'gender'	  => 'Gi???i t??nh',
			'code_reset'  => 'M?? OTP',
			'email_draft' => 'Email',
			'cmnd'	=> 'CMND/H??? chi???u',
			'place_issued' => 'N??i c???p',
			'date_issued' => 'Ng??y c???p'
        ];
    }
}
