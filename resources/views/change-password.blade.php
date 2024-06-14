@extends('layouts.app')

@section('title', 'Change-Password')


@section('content')
<div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">
    <div class="mypage">
        <div class="row" style="margin-top: 5px;">
            <div class="col-md-12 fleft">
                @if (session('message'))
                <h5 class="alert alert-success mb-2">{{ session('message') }}</h5>
            @endif

            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
                @endforeach
            </ul>
            @endif
                <form action="{{ route('change-password') }}" role="form" class="inform well" style="width: 420px;" method="post" accept-charset="utf-8">
                    @csrf
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="width: 100%; vertical-align: top; padding-right: 20px;">

                                    <div class="form-group">
                                        <label class="control-label" for="current">Current Password</label>
                                        <input type="password" name="current" id="current" class="form-control input-sm" placeholder="Current Password" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="new">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control input-sm" placeholder="New Password" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="confirm">Confirm Password</label>
                                        <input type="password" name="confirm" id="confirm" class="form-control input-sm" placeholder="Confirm Password" value="">
                                    </div>
                                    <input type="hidden" name="valid">
                                    <p class="help-block form_error" style="font-size: 11px;"></p>
                                    <p class="help-block line"></p>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <span class="glyphicon glyphicon-lock"></span>
                                        Change
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>


 </div>
 @endsection
