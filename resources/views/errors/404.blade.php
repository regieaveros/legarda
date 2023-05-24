<?php

    include 'admin/functions/fn_connect.php';
    include 'admin/functions/fn_main.php';

    session_start();

?>
@extends('layouts.404_template')

@section('title')

 <?=get_value_condition("website_name_str","tbl_detail","id=1")?>

@endsection

@section('icon')

    <link rel="icon" type="image/png" href="<?=get_value_condition("base_url_str","tbl_detail","id=1")?>admin/uploads/favicon/<?=get_value_condition("favicon_img","tbl_detail","id=1")?>">

@endsection

@section('content')
	
    <!-- Start page content -->
    <section id="page-content" class="page-wrapper">

        @include('includes.errors.404.error')

    </section>

@endsection

@section('header')

	@include('includes.header_footer.header_rooms')
        
@endsection