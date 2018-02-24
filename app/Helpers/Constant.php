<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 1/20/17
 * Time: 00:05
 */
namespace App\Helpers;

/**
 * Class Constant
 * @package App\Helpers
 */
class Constant
{

	const LOCUM_AVATAR_PATH = '/images/avatar/locum/';
	const PRACTICE_AVATAR_PATH = '/images/avatar/practice/';
    const NEWS_AVATAR_PATH = '/images/avatar/news/';
	const LOCUM_DEFAULT_AVATAR_PATH = '/images/avatar/locum/default_locum.png';
	const PRACTICE_DEFAULT_AVATAR_PATH = '/images/avatar/practice/default_practice.jpg';
    const NEWS_DEFAULT_AVATAR_PATH = '/images/avatar/news/default_news.png';


    //Roles
    const ROLE_OWNER = 'ROLE_OWNER';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    //Class identifiers
    const APPLICATION_IDENTIFIERS = 'App\Application';
    const CALENDAR_IDENTIFIERS = 'App\Calendar';
    const INVOICE_IDENTIFIERS = 'App\Invoice';
    const JOB_IDENTIFIERS = 'App\Job';
    const PAYMENTS_OPTIONS_IDENTIFIERS = 'App\PaymentsOptions';
    const PRACTICE_IDENTIFIERS = 'App\Practice';
    const REVIEW_IDENTIFIERS = 'App\Review';
    const USER_IDENTIFIERS = 'App\User';
    const NEWS_IDENTIFIERS = 'App\News';

    //Enum type field for locum and practice
    const SpecialistEquipment = [
        'OCT',
        'Digital Retinal Camera',
        'Optos Optomap',
        'Visual Fields Perimetry',
        'HRT',
        'Digital Slit Lamp',
    ];
    const _Specialty = [
        'Pediatric',
        'Glaucoma',
        'Perimetry',
        'Low Vision',
        'Sports Vision',
        'Vision Therapy',
        'Specialty Contact Lenses',
        'Dry Eye',
    ];
    const PracticeManagementSystem = [
        'Acuitas activeEHR2',
        'VisualEyes',
        'MyVisionExpress',
        'iFile/cFile',
        'Maximeyes',
        'Genie',
        'Eyefinity OfficeMate',
        'Other',
    ];
    const _LensProduct = [
        'Hoya',
        'Nikon',
        'Essilor',
        'Zeiss',
        'Rodenstock',
        'Centennial',
        'Seiko',
        'Other',
        'Independent',
    ];
    const ContactLensSpecialty = [
        'Scleral',
        'RGP',
        'Keratoconus',
        'Toric',
    ];
    const AverageFullExamTime = [
        '15min',
        '20min',
        '25min',
        '30min',
        '35min',
        '40min',
        '45min',
    ];
    const PatientBookingPreference = [
        'Full-Full-Partial',
        'Full-Partial-Full',
        'No Preference',
        'Other',
    ];

    //Enum type just for practice
    const PretestEquipment = [
        'Non Contact Tonometer',
        'Auto Refractor',
        'Keratometer',
        'Color Vision Test',
        'E-Chart',
        'Pachymetry',
    ];
    const ExperienceRequirement = [
        'New Grad',
        '1-3 Years',
        '3-5 Years',
        '5+ Years',
    ];
    /**
     *  Payment Terms due date max days
     */
    const PAYMENT_TERMS = 30;
	
	
	/**
	 * @param $constant
	 * @return string
	 */
	public static function absolutePath($constant) {
		return public_path() . constant('self::' . $constant);
	}
}











