<?php

namespace App;
use Intervention\Image\Facades\Image;

class Helper {

    public static function saveOptimizedImages($directory, $imageName)
    {
        $image = Image::make(public_path() . '/' . $directory . '/' . $imageName);

        //Save Medium Sized Image
        $image->resize(400, null, function($constraint){
            $constraint->aspectRatio();
        });

        $image->save(public_path() . '/' . $directory . '/medium/' . $imageName);

        //Save Thumbnail Image
        $image->resize(150, null, function($constraint){
            $constraint->aspectRatio();
        });

        $image->save(public_path() . '/' . $directory . '/thumbnail/' . $imageName);
    }

   public static function validateDate($date, $format = 'Y-m-d')
     {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

}
