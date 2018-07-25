<?php

namespace App\Model\App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Build extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['build_number', 'version_code'];

    /**
     * @return mixed
     */
    public function getBuildNumberNumericAttribute()
    {
        return str_replace('|', '', $this->build_number);
    }

    /**
     * @param $version_code
     * @return mixed
     */
    public static function generateNewBuildNumberFor($version_code)
    {
        $build = self::where('version_code', '=', $version_code)->latest()->first();
        if ($build == null) {
            $build = self::create([
                'build_number' => self::generateBuildNumber($version_code, 0),
                'version_code' => $version_code,
            ]);
        } else {
            $_d = explode('|', $build->build_number);
            $last_build = last($_d);
            $build = self::create([
                'build_number' => self::generateBuildNumber($version_code, $last_build + 0),
                'version_code' => $version_code,
            ]);
        }

        return $build->build_number_numeric;
    }

    /**
     * @param $version_code
     * @param int $build
     * @return string
     */
    public static function generateBuildNumber($version_code, $build = 0)
    {
        $points = explode('.', $version_code);
        // Increment Build
        $build++;
        // from 2.2.0 will be 200 <-- Major 2 <-- Minor 0 <-- Bugfixing 21 <-- Build
        $build_number_with_pipes = $points[0].'|'.str_pad($points[1], 3 ,'0', STR_PAD_LEFT).'|'.str_pad($points[2], 3 ,'0', STR_PAD_LEFT).'|'.str_pad($build, 3 ,'0', STR_PAD_LEFT);

        return $build_number_with_pipes;
    }
}
