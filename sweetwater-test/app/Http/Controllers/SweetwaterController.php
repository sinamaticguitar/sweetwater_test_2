<?php

namespace App\Http\Controllers;

use App\Models\SweetwaterTest;
use Illuminate\Support\Facades\DB;

class SweetwaterController extends Controller
{
    /**
     * Show the main page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        // Fix the expected ship dates
        $this->fixExpectedShipDate();

        // Display the view
        return view('sweetwater', [
            'comments' => SweetwaterTest::all()->sortBy("category"),
            'categories' => SweetwaterTest::CATEGORIES
        ]);
    }

    /**
     * Function to update the shipping dates based upon the data in the comment body. I shifted the weight of this action to the database since there are ways
     * to parse these dates from the text. Takes the strain off of the controller layer.
     *
     * Additionally, the logic here should know whether this action has previously taken place and not fire, returning a TRUE gracefully to avoid updating the
     * database recklessly.
     *
     * @return mixed
     */
    private function fixExpectedShipDate() {
        return SweetwaterTest::whereRaw("SUBSTRING_INDEX(comments, \"Expected Ship Date: \", -1) <> comments")
            ->update(['shipdate_expected' => DB::raw("SUBSTR(comments, POSITION(\"Expected Ship Date: \" IN comments) + LENGTH(\"Expected Ship Date: \"), 8)")]);
    }
}