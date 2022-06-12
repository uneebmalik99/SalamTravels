<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Travel</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/BaseStyle.css')}}">
    <link rel="stylesheet" href="{{asset('css/customer-login.css')}}">
</head>
<body>
    <div id="ctl00_updProgress" style="display:none;">
        <img id="ctl00_img" src="../Runtime/Enterprise_ZArchitecture_Web_GUI_Ajax/21_5_19_880/AJAXManager/ajax-indicator.gif" style="position:absolute;z-index:1000;left:50%;top:50%;" />
    </div>
    <div id="OuterContentPane">
        <form method="POST" action="{{ route('reset.password.post') }}" aria-label="{{ __('Rest Password') }}">
            @csrf
            <div id="loginBox" class="loginBox">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    E-mail:
                    <input name="email" type="text" maxlength="254" id="email" onchange="ClearValidation(&#39;LoginNameTextBox_NotificationID&#39;)" />
                    @error('email')
                    <span class="" role="alert">
                        <strong class="text-dark">{{ $message }}</strong>
                    </span>
                    @enderror     
                </div> 

                <div class="form-group">
                    New Password:<br />
                    <input name="password" type="password" maxlength="50" id="password" onchange="ClearValidation(&#39;PasswordTextBox_NotificationID&#39;)" />
                    @error('password')
                        <span class="" role="alert">
                            <strong  class="text-dark">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    Configrm Password:<br />
                    <input id="password-confirm" type="password"  name="password_confirmation" required autocomplete="new-password">
                    
                </div>

                    <input type="submit" class="btn btn-lg btn-block" name="SigninBtn" value="Reset" id="SigninBtn" />
                            
                
                
            </div>
        </form>
    </div>
</body>
</html>






