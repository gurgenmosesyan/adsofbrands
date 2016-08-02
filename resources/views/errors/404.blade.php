<?php
use App\Models\Background\Background;

$title = '404';
$page = null;
$bookingPage = true;
$errorPage = true;
$background = Background::first()->getImage('homepage');
?>
@extends('layout')

@section('content')

@stop