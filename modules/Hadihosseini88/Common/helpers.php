<?php

function newFeedback($title = 'عملیات موفق', $body = 'عملیات با موفقیت انجام شد.', $type = 'success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title, 'body' => $body, 'type' => $type];
    session()->flash('feedbacks', $session);

}
