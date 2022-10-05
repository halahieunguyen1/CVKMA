<?php

namespace App\Models\CvVersion;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait CvVersionTrait
{
    public function cvVersion()
    {
        return $this->belongsTo('App\Models\CvVersion\CvVersion', 'cv_version_id', 'id');
    }

    public function getParsedData()
    {
        $data = optional($this->cvVersion)->dataCvVersion->data ?? "";
        if (is_string($data)) {
            return json_decode($data, true);
        }
        return $data;
    }

    public function data(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->dataCvVersion->data ?? ""
        );
    }

    public function template()
    {
        return optional($this->cvVersion)->template;
    }

    public function colorScheme(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->color_scheme
        );
    }

    public function font(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->font
        );
    }

    public function fontsize(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->fontsize
        );
    }

    public function spacing(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->spacing
        );
    }

    public function lang(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->lang
        );
    }

    public function templateCvId(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->cvVersion)->template_cv_id
        );
    }
}
