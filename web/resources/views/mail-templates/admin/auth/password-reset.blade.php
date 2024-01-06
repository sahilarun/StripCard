<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        *, ::after, ::before {
            box-sizing: border-box;
        }
        body{
            background-color: #f1f1f1;
            font-family: "Karla", sans-serif;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.5em;
            color: #343a40;
            overflow-x: hidden;
            padding: 0;
            margin: 0;
        }
        a{
            display: inline-block;
            color: inherit;
            text-decoration: none;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        span{
            display: inline-block;
        }
        .btn--base {
            position: relative;
            background: #5a5278;
            border-radius: 5px;
            color: #ffffff !important;
            padding: 9px 20px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            -webkit-transition: all ease 0.5s;
            transition: all ease 0.5s;
        }
        .email-templates-section{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .email-templates-wrapper{
            max-width: 600px;
            margin: 0 auto;
        }
        .email-templates-logo{
            max-width: 150px;
            margin: 0 auto;
            margin-bottom: 15px;
        }
        .email-templates-box{
            background-color: rgba(255,255,255,0.3);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        .email-templates-box .hello{
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            color: #5a5278;
        }
        .email-templates-box .thanks{
            margin-bottom: 0;
        }
        .email-templates-box span a{
            font-weight: 800;
            color: #5a5278;
        }
    </style>
</head>
<body>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Admin
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="email-templates-section">
    <div class="email-templates-wrapper">
        <div class="email-templates-logo">
            <img src="{{ $message->embed($logo) }}" alt="logo">
        </div>
        <div class="email-templates-box">
            <div class="email-templates-content">
                <p class="hello">Hello,</p>
                <p>You have requested us to send a link to reset your password for your admin account</p>
                <div class="email-templates-btn">
                    <a href="{{ $reset_url ?? "javascript:void(0)" }}" class="btn--base">Reset Password</a>
                </div>
                <p>If you didn't initiate this request, you can safely ignore this email.</p>
                <p class="thanks">Thanks!</p>
                <span><a href="{{ $site_url ?? "" }}">{{ $site_name ?? "" }}</a> Support Team</span>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Admin
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

</body>
</html>