<?php

namespace App\Shared\Enum;

enum State: string
{
    case AL = 'Alabama';
    case AK = 'Alaska';
    case AS = 'American Samoa';
    case AZ = 'Arizona';
    case AR = 'Arkansas';
    case AE = 'Armed Forces - Europe';
    case AP = 'Armed Forces - Pacific';
    case AA = 'Armed Forces - USA/Canada';
    case CA = 'California';
    case CO = 'Colorado';
    case CT = 'Connecticut';
    case DE = 'Delaware';
    case DC = 'District of Columbia';
    case FM = 'Federated States of Micronesia';
    case FL = 'Florida';
    case GA = 'Georgia';
    case GU = 'Guam';
    case HI = 'Hawaii';
    case ID = 'Idaho';
    case IL = 'Illinois';
    case IN = 'Indiana';
    case IA = 'Iowa';
    case KS = 'Kansas';
    case KY = 'Kentucky';
    case LA = 'Louisiana';
    case ME = 'Maine';
    case MH = 'Marshall Islands';
    case MD = 'Maryland';
    case MA = 'Massachusetts';
    case MI = 'Michigan';
    case MN = 'Minnesota';
    case MS = 'Mississippi';
    case MO = 'Missouri';
    case MT = 'Montana';
    case NE = 'Nebraska';
    case NV = 'Nevada';
    case NH = 'New Hampshire';
    case NJ = 'New Jersey';
    case NM = 'New Mexico';
    case NY = 'New York';
    case NC = 'North Carolina';
    case ND = 'North Dakota';
    case OH = 'Ohio';
    case OK = 'Oklahoma';
    case OR = 'Oregon';
    case PA = 'Pennsylvania';
    case PR = 'Puerto Rico';
    case RI = 'Rhode Island';
    case SC = 'South Carolina';
    case SD = 'South Dakota';
    case TN = 'Tennessee';
    case TX = 'Texas';
    case UT = 'Utah';
    case VT = 'Vermont';
    case VI = 'Virgin Islands';
    case VA = 'Virginia';
    case WA = 'Washington';
    case WV = 'West Virginia';
    case WI = 'Wisconsin';
    case WY = 'Wyoming';

    /** @return string[] */
    public static function getAsArray(): array
    {
        return array_column(self::cases(), 'name');
    }
}
