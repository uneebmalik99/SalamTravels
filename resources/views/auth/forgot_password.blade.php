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
        <form method="POST" action="{{ route('forget.password.post') }}" aria-label="{{ __('Login') }}">
            @csrf
            <div id="loginBox" class="loginBox">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="form-group">
                    E-mail:
                    <input name="email" type="text" maxlength="254" id="email" onchange="ClearValidation(&#39;LoginNameTextBox_NotificationID&#39;)" />
                    @error('email')
                    <span class="" role="alert">
                        <strong class="text-dark">{{ $message }}</strong>
                    </span>
                    @enderror     
                </div>        
                <input type="submit" name="SigninBtn" value="Send Reset Password Request" id="SigninBtn" />
                &nbsp;&nbsp;&nbsp;
                    <span id="Message" class="ErrorMessage"></span>
                
            </div>
        </form>
    </div>
</body>
</html>