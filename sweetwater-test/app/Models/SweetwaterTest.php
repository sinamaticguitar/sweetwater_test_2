<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweetwaterTest extends Model
{
    const CAT_NAME_CANDY    = 'Candy';
    const CAT_NAME_CALL     = 'Call / Do Not Call';
    const CAT_NAME_REFER    = 'Referrals';
    const CAT_NAME_SIG      = 'Signatures';
    const CAT_NAME_MISC     = 'Miscellaneous';

    const CATEGORIES = array(
        1 => self::CAT_NAME_CANDY,
        2 => self::CAT_NAME_CALL,
        3 => self::CAT_NAME_REFER,
        4 => self::CAT_NAME_SIG,
        5 => self::CAT_NAME_MISC
    );

    protected $table = 'sweetwater_test';

    public $timestamps = false;

    /**
     * Parses the comment body for certain criteria and assigns a virtual category attribute to the record.
     *
     * @return int
     */
    public function getCategoryAttribute() {
        $comment = $this->comments;
        switch($comment) {
            case (bool)preg_match('/(?:^|\W)(candy|candies|smarties|honey|taffy|tootsie)(?:$|\W)/mi', $comment):
                return 1; // Candy
                break; // Safety Net
            case (bool)preg_match('/(?:^|\W)(call|calls)(?:$|\W)/mi', $comment):
                return 2; // Call / Do Not Call
                break; // Safety Net
            case (bool)preg_match('/(?:^|\W)(referral|referred)(?:$|\W)/mi', $comment):
                return 3; // Referrals
                break; // Safety Net
            case (bool)preg_match('/(?:^|\W)(signature)(?:$|\W)/mi', $comment):
                return 4; // Signatures
                break; // Safety Net
            default:
                return 5; // Misc
        }
    }
}