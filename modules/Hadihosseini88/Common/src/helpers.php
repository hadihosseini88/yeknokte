<?php

function newFeedback($title = 'عملیات موفق', $body = 'عملیات با موفقیت انجام شد.', $type = 'success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title, 'body' => $body, 'type' => $type];
    session()->flash('feedbacks', $session);
}

function dateFromJalali($date, $format = "Y/m/d"){
        return $date ? \Morilog\Jalali\Jalalian::fromFormat($format,$date)->toCarbon() : null;
}

function getJalaliFromFormat($date, $format = "Y-m-d"){
    return \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::createFromFormat($format,$date))->format('Y/m/d');
}

function createFromCarbon(\Carbon\Carbon $carbon){
    return \Morilog\Jalali\Jalalian::fromCarbon($carbon);
}
